<?php

//read the incoming info
$content = file_get_contents("php://input");

//decode the incoming array
$update = json_decode($content, true);

if (isset($update['inline_query'])) {
    inline_response($update['inline_query']['id'], $update['inline_query']['query']);
    include_once('botstats.php'); \botstats\increase(224929004, 'letmebot');
} else if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $message_text = $update['message']['text'];
    $message_text_final = explode(' ',$message_text);
	if ($message_text_final[0]=='/start'){
		sendMessage($chat_id,'Hello, i am an inline bot to search the web. Try typing @letmebot <i>query</i> in any chat','How to google');
	} else {
		sendMessage($chat_id,'Hello, i am an inline bot to search the web. Try typing @letmebot <i>query</i> in any chat or tap the button below:',$message_text);
	}
}


function inline_response($query_id, $query_text) {
	$urls = [
		[
			'ident' => 'google',
			'url' => 'http://google.com/search?q=' . urlencode($query_text),
			'name' => '🔎 Google',
			'thumb_url' => 'https://www.google.de/images/hpp/ic_wahlberg_product_core_48.png8.png',
			
		],
		[
			'ident' => 'ddg',
			'url' => 'https://duckduckgo.com/?q='.urlencode($query_text),
			'name' => '🦆 DuckDuckGo',
			'thumb_url' => 'https://duckduckgo.com/assets/icons/meta/DDG-iOS-icon_152x152.png',
		],
		[
			'ident' => 'startpage',
			'url' => 'https://www.startpage.com/do/dsearch?query='.urlencode($query_text),
			'name' => '🔎 Startpage',
			'thumb_url' => 'https://www.startpage.com/graphics/favicon/sp-apple-touch-icon-152x152.png',
		],
		[
			'ident' => 'youtube',
			'url' => 'https://www.youtube.com/results?search_query=' . urlencode($query_text),
			'name' => '📺 YouTube',
			'thumb_url' => 'https://s.ytimg.com/yts/img/favicon_144-vflWmzoXw.png',
		],
		[
			'ident' => 'ecosia',
			'url' => 'https://ecosia.org/search?q=' . urlencode($query_text),
			'name' => '🌳 Ecosia',
			'thumb_url' => 'https://cdn.ecosia.org/assets/images/png/apple-touch-icon.png',
		],
		[
			'ident' => 'wiki',
			'url' => 'https://en.wikipedia.org/wiki/Special:Search/' . urlencode($query_text),
			'name' = '📚 Wikipedia',
			'thumb_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/63/Wikipedia-logo.png',
		],
		[
			'ident' => 'Wikihow',
			'url' => 'https://en.wikihow.com/wikiHowTo?search=' . urlencode($query_text),
			'name' => '📖 Wikihow',
			'thumb_url' => 'http://www.wikihow.com/images/7/71/Wh-logo.jpg',
		],
		[
			'ident' => 'bing',
			'url' => 'https://bing.com/search?q=' . urlencode($query_text),
			'name' => '💩 Bing',
			'thumb_url' => 'http://logok.org/wp-content/uploads/2014/09/Bing-logo-2013-880x660.png',
		],
		[
			'ident' => 'ud',
			'url' => 'https://www.urbandictionary.com/define.php?term=' . urlencode($query_text),
			'name' => '📖 Urban Dictionary',
			'thumb_url' => 'http://a2.mzstatic.com/us/r30/Purple/v4/dd/ef/75/ddef75c7-d26c-ce82-4e3c-9b07ff0871a5/mzl.yvlduoxl.png',
		],
		[
			'ident' => 'lmgtfy',
			'url' => 'http://lmgtfy.com/?q=' . urlencode($query_text),
			'name' => '🔎  Let Me Google That For You',
			'thumb_url' => 'https://www.lmgtfy.com/assets/sticker-b222a421fb6cf257985abfab188be7d6746866850efe2a800a3e57052e1a2411.png',
		],
		[
			'ident' => 'amazon',
			'url' => 'https://www.amazon.de/s?field-keywords=' . urlencode($query_text),
			'name' => '🛒 Amazon',
			'thumb_url' => 'http://www.turnerduckworth.com/media/filer_public/86/18/86187bcc-752a-46f4-94d8-0ce54b98cd46/td-amazon-smile-logo-01-large.jpg'
		],		[
			'ident' => 'telethondocs',
			'url' => 'https://lonamiwebs.github.io/Telethon/?q=' . urlencode($query_text),
			'name' => '📖 Telethon Docs',
]
	];
	$results = array();
	foreach($urls as $value) {
		$results[] = [
			'type' => 'article',
			'id' => $value['ident'].'response',
			'title' => $value['name'],
			'description' => 'Search for "' . $query_text . '"',
			'input_message_content' => [
				'message_text' => "Let me <b>".$value['name']."</b> that for you:\n🔎 <a href=\"".$value['url']."\">".htmlspecialchars($query_text)."</a>",
				'parse_mode' => 'HTML',
				'disable_web_page_preview' => true,
			],
		];  
	}
	$ReplyContent = [
    	'method' => 'answerInlineQuery',
    	'inline_query_id' => $query_id,
    	'cache_time' => '300000',
    	'results' => $results,
    	];	
  	$replyJson =json_encode($ReplyContent);
  	header("Content-Type: application/json");
  	echo($replyJson);
}

function sendMessage($chatID,$reply,$inline_query_new){
	// send reply
	$ReplyContent = [
		'method' => "sendMessage",
		'chat_id' => $chatID,
		'parse_mode' => 'HTML',
		'disable_web_page_preview' => $wtrue,
		'text' => $reply,
		'reply_markup' => [
  			'inline_keyboard' => [[[
				'text' => 'Try me',
				'switch_inline_query' => $inline_query_new,	]]]]
	];
	$replyJson =json_encode($ReplyContent);
	header("Content-Type: application/json");
	echo($replyJson);
}
