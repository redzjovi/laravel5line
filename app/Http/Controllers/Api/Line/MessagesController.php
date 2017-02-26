<?php
namespace App\Http\Controllers\Api\Line;

use App\Http\Controllers\Controller;
use App\Http\Models\UserLine;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    function __construct()
    {
        // init bot line
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
    	$this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
    }

    function index(UserLine $userLine)
    {
        $body = file_get_contents('php://input');
        file_put_contents('php://stderr', 'Body: '.$body);

        $body = '{
            "events": [
                {
                    "replyToken": "nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
                    "type": "message",
                    "timestamp": 1462629479859,
                    "source": {
                        "type": "user",
                        "userId": "U488b052cfa53ad77e08c4e9ac6b3ca15"
                    },
                    "message": {
                        "id": "325708",
                        "type": "text",
                        "text": "Hello, world"
                    }
                }
            ]
        }';
        $data = json_decode($body, true);

        foreach ((array) $data['events'] as $event)
    	{
            if ($event['source']['type'] == 'user')
            {
                $userId = $event['source']['userId'];
                $userLine = $userLine->check_user($userId);
            }

            if ($event['type'] == 'message')
    		{
    			if ($event['message']['type'] == 'text')
    			{
    				// send same message as reply to user
    				// $result = $this->bot->replyText($event['replyToken'], $event['message']['text']);

    				// or we can use pushMessage() instead to send reply message
    				// $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($event['message']['text']);
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($userLine->status);
                    $result = $this->bot->pushMessage($event['source']['userId'], $textMessageBuilder);

                    return $result->getHTTPStatus() . ' ' . $result->getRawBody();
    			}
    		}
    	}
    }
}