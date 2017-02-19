<?php

namespace App\Http\Controllers\Line;

use Illuminate\Http\Request;
use LINE\LINEBot\SignatureValidator;
use App\Http\Controllers\Controller;


class MessagesController extends Controller
{
    function index()
    {
        $body = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];

        // file_put_contents('php://stderr', 'Body: '.$body);

        if (empty($signature))
        	return $response->withStatus(400, 'Signature not set');
        else if ($_ENV['PASS_SIGNATURE'] == false && ! SignatureValidator::validateSignature($body, $_ENV['CHANNEL_SECRET'], $signature))
        	return $response->withStatus(400, 'Invalid signature');

        return '1';
    }
}