<?php
namespace App\Http\Models;

use App\Http\Models\UserLine;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Sunra\PhpSimple\HtmlDomParser;

class Activity extends Model
{
    protected $table = 'activities';

    function check_status_message($userLine, $text)
    {
        var_dump($text);

        $activity = self::where('code', $text)->first();
        if ($activity)
        {
            $userLine = UserLine::find($userLine->id);
            $userLine->status = $activity->id;
            $userLine->save();
        }
        else
        {
            if ($userLine->activity->code == '/1')
            {
                $result = $this->gsmarenaHeader($text);

                if (empty($result))
                {
                    $text_new['text'] = 'Data tidak ditemukan';
                }
                else
                {
                    foreach($result as $row)
                    {
                        $detail = $this->gsmarenaDetail($row['slug']);
                        $text_new['text'][] = $this->gsmarenaGenerateText($detail);
                    }
                }
            }
        }

        $activity = self::where('id', $userLine->status)->first();
        $text_new['help'] = $activity->help;

        // var_dump($text_new);
        // die;

        return $text_new;
    }

    function gsmarenaHeader($text)
    {
        $result = array();

        $client = new Client(['base_uri' => 'http://www.gsmarena.com']);
        $response = $client->request('GET', '/results.php3?sQuickSearch=yes&sName='.urlencode($text));
        var_dump('/results.php3?sQuickSearch=yes&sName='.urlencode($text));
        $html = $response->getBody();

        $dom = HtmlDomParser::str_get_html($html);
        $div = $dom->find('div[class=makers]', 0);

        if ($div->find('li', 0))
        {
            $i = 0;
            foreach ($div->find('li') as $li) {
                $grid = $li->find('a', 0);
                $title = $grid->find('span', 0);
                $slug = str_replace('.php', '', $grid->href);
                $result[] = array(
                    'title' => str_replace('<br>', ' ', $title->innertext),
                    'slug' => str_replace($this->simbol, $this->kata, $slug)
                );

                $i++;
                if ($i == 2) break;
            }
        }

        return $result;
    }

    function gsmarenaDetail($slug = "")
    {
        $result = array();

        $client = new Client(['base_uri' => 'http://www.gsmarena.com']);
        $response = $client->request('GET', '/'.str_replace($this->kata, $this->simbol, $slug).'.php');
        $html = $response->getBody();

        $dom = HtmlDomParser::str_get_html($html);
        $result["title"] = $dom->find('h1[class=specs-phone-name-title]', 0)->innertext;

        $img_div = $dom->find('div[class=specs-photo-main]', 0);
        $result["img"] = $img_div->find('img', 0)->src;

        $div = $dom->find('div[id=specs-list]', 0);

        foreach ($div->find('table') as $table)
        {
            $th = $table->find('th', 0);

            foreach ($table->find('tr') as $tr) {
                ($tr->find('td', 0) == "&nbsp;" ? $ttl = "empty" : $ttl = $tr->find('td', 0));
                $search  = array(".", ",", "&", "-", " ");
                $replace = array("", "", "", "_", "_");
                $ttl = strtolower(str_replace($search, $replace, $ttl));
                $nfo = $tr->find('td', 1);

                $result["data"][strtolower($th->innertext)][] = array(
					strip_tags($ttl) => strip_tags($nfo)
				);
                // $result["data"][strtolower(strip_tags($ttl))] = strip_tags($nfo);
            }
        }
        // $search  = array("},{", "[", "]", '","nbsp;":"', "nbsp;", " - ");
        // $replace = array(",", "", "", "<br>", "", "<br>- ");
        $search  = array("},{", "[", "]", '","nbsp;":"', "nbsp;", " - ");
        $replace = array(",", "", "", "", "", ", ");
        $newjson = str_replace($search, $replace, json_encode($result));
        $result = json_decode($newjson, TRUE);

        // var_dump($result);

        return $result;
    }

    function gsmarenaGenerateText($data)
    {
        $text = '';
        $columns = ['announced', 'sim', 'size', 'os', 'cpu', 'internal', 'primary', 'secondary', ''];

        $text = 'name : '.$data['title'].PHP_EOL;
        foreach ($data['data'] as $row)
        {
            foreach ($row as $key => $value)
            {
                if (in_array($key, $columns))
                {
                    if ($key == '') $key = 'battery';
                    $text .= $key.' : '.$value.PHP_EOL;
                }
            }
        }

        // var_dump($data);
        // var_dump($text);
        // die;

        return $text;
    }
}