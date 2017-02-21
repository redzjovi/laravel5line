<?php
namespace App\Http\Controllers\Api\Line;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessagesController extends Controller
{
    public function __construct()
    {
        // init bot line
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
    	$this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
    }

    public function index()
    {
        $body = file_get_contents('php://input');
        file_put_contents('php://stderr', 'Body: '.$body);

        $data = json_decode($body, true);
    	foreach ((array) $data['events'] as $event)
    	{
            if ($event['type'] == 'message')
    		{
    			if ($event['message']['type'] == 'text')
    			{
    				// send same message as reply to user
    				$result = $this->bot->replyText($event['replyToken'], $event['message']['text']);

    				// or we can use pushMessage() instead to send reply message
    				$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($event['message']['text']);
                    $result = $this->bot->pushMessage($event['source']['userId'], $textMessageBuilder);

                    return $result->getHTTPStatus() . ' ' . $result->getRawBody();
    			}
    		}
    	}
    }
}