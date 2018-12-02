<?php
define("LINE_MESSAGING_API_CHANNEL_SECRET", '{your secret}');
define("LINE_MESSAGING_API_CHANNEL_TOKEN", '{your token}');


use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\MessageEvent\TextMessage;

require('../vendor/autoload.php');

$bot = new LINEBot(new CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN), [
            'channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET,
        ]);

$signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$body = file_get_contents("php://input");

try {
    // Bodyと$signatureから内容をVerifyして成功すればEventを得られる
    $events = $bot->parseEventRequest($body, $signature);

    foreach ($events as $event) {
       if ($event instanceof TextMessage) {
          $bot->replyText($event->getReplyToken(), 'メッセージが来たよ！');
          continue;
       }
    }
} catch (Exception $e) {
  // none
}