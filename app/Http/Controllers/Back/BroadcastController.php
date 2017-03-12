<?php
namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Http\Models\UserLine;
use App\Http\Requests\Back\BroadcastRequest;
use Illuminate\Http\Request;

class BroadcastController extends Controller
{
    public function index()
    {
        return view('back.broadcast.index');
    }

    public function message(BroadcastRequest $request)
    {
        $message = $request->get('message');

        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($_ENV['CHANNEL_ACCESS_TOKEN']);
    	$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $_ENV['CHANNEL_SECRET']]);
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);

        $userLine = UserLine::All();

        foreach ($userLine as $user) {
            $bot->pushMessage($user->line_id, $textMessageBuilder);
        }

        return redirect()->back()->with('status', 'Your message has been sent');
    }
}