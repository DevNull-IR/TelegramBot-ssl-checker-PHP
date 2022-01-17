<?php 
error_reporting(0); 
##########################################
##                                      ##
##        craeted by @dev_null          ##
##                                      ##
##        channel : @iso_plus           ##
##                                      ##
##     https://github.com/DevNull-IR    ##
##                                      ##
##########################################
$telegram_ip_ranges = [
['lower' => '149.154.160.0', 'upper' => '149.154.175.255'], // literally 149.154.160.0/20
['lower' => '91.108.4.0',    'upper' => '91.108.7.255'],    // literally 91.108.4.0/22
];
$ip_dec = (float) sprintf("%u", ip2long($_SERVER['REMOTE_ADDR']));
$ok=false;
foreach ($telegram_ip_ranges as $telegram_ip_range) if (!$ok) {
    $lower_dec = (float) sprintf("%u", ip2long($telegram_ip_range['lower']));
    $upper_dec = (float) sprintf("%u", ip2long($telegram_ip_range['upper']));
    if ($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok=true;
}
if (!$ok) die("This page is for Telegram Online :)");
const token = ""; //token bot
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".token."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function check_channel_member($channel , $chat_id){
	$res = bot("getChatMember" , array("chat_id" => $channel , "user_id" => $chat_id));
	if(isset($res->result->user) && $res->result->status == "member"){
		return "yes";
	}elseif($res->result->status == "administrator"){
		return "yes";
	}elseif($res->result->status == "creator"){
		return "yes";
	}else{
	    return "no";
	}
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$message_id = $message->message_id;
$text = $message->text;
$chat_id = $message->chat->id;
$tc = $message->chat->type;
$first_name = $message->from->first_name;
$from_id = $message->from->id;
@mkdir("member");
$step = file_get_contents("member/$from_id.user");
$channel = "iso_plus";
$admin = 997471963;
if(check_channel_member("@".$channel, $chat_id)=="no"){
   bot('sendMessage', [
'chat_id' => $chat_id,
'text'=>"
⚒ لطفا جهت استفاده از ربات وارد کانال زیر شوید
[🆔] @$channel
لطفا بعد از عضویت در کانال ها (/start) کلیک کنید❗️️",
              'parse_mode'=>"HTML",
        ]); 
return false;
}
elseif(file_exists("member/$from_id.user") !== true){
    file_put_contents("member/$from_id.user",NULL);
       bot('sendmessage',[
    'chat_id'=>$from_id,
    'text' =>"$creatAcc",
    'reply_to_message_id'=>$message_id,
    'reply_markup'=>$hoad
        ]); 
}
elseif($text == "/start" or $text == "🔙 بازگشت"){
    file_put_contents("member/$from_id.user","$from_id");
    if($text != "🔙 بازگشت"){    
    bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 سلام به ربات ssl چکر خوش آمدید برای چک کردن ssl میتوانید از دکمه ی زیر استفاده کنید",
        'reply_to_message_id'=>$message_id,
        'reply_markup'=> json_encode([
            'keyboard'=>[

              [['text'=>"🛠 چک کردن ssl "],['text'=>"💠 درباره ی ما"]],
              ], 'resize_keyboard'=>true
              ])
        ]);
    }else{
            bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🥲به منوی اصلی برگشتیم",
        'reply_to_message_id'=>$message_id,
        ]);
            bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 سلام به ربات ssl چکر خوش آمدید برای چک کردن ssl میتوانید از دکمه ی زیر استفاده کنید",
        'reply_to_message_id'=>$message_id,
        'reply_markup'=> json_encode([
            'keyboard'=>[

              [['text'=>"🛠 چک کردن ssl "],['text'=>"💠 درباره ی ما"]],
              ], 'resize_keyboard'=>true
              ])

        ]);
    }
}
elseif($text == "🛠 چک کردن ssl"){
    file_put_contents("member/$from_id.user","$from_id"."check");
                bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"💠 دامنه ی مورد نظر را ارسال کنید 

‼️ دامنه را بدون http & https & www ارسال کنید تا ربات به مشکل نخورد",
        'reply_to_message_id'=>$message_id,
        'reply_markup'=>json_encode([
            'keyboard'=>[

              [['text'=>"🔙 بازگشت"]],
              ], 'resize_keyboard'=>true
              ])
        ]);
}
elseif($step == $from_id."check" && $text != "🔙 بازگشت" && $text != "/start"){
                bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 در حال برسی دامنه",
        'reply_to_message_id'=>$message_id,
        ]);
        $api = file_get_contents("https://api.iso-plus.ir/ssl/?domain=$text&type=optionall");
        $apis = file_get_contents("https://api.iso-plus.ir/ssl/?domain=$text&type=option");
        preg_match_all ('# '.$text.' ((.*?) days)#', $apis, $match);
$st = str_replace( "(" , "" , $match[2][0]);
        $is = explode(PHP_EOL,$api);
        if($is[4] == NULL){
   
                                                bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 دامنه ی $text متاسفانه ssl ندارد
        ",
        'reply_to_message_id'=>$message_id,
        ]);
        die();
        }
        if($is[4] == "R3"){
                                    bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 {$is[0]}
💠 زمان باقی مانده : $st روز
💠 ایجاد : {$is[1]}
💠 انقضا : {$is[2]}
💠 سریال : {$is[3]}
💠 نوع : رایگان ({$is[4]})
        
        ",
        'reply_to_message_id'=>$message_id,
        ]);
            die();
        }
                        bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🙂 {$is[0]}
💠 زمان باقی مانده : $st روز
💠 ایجاد : {$is[1]}
💠 انقضا : {$is[2]}
💠 سریال : {$is[3]}
💠 نوع : {$is[4]}
        
        ",
        'reply_to_message_id'=>$message_id,
        ]);
}
elseif($text == "💠 درباره ی ما"){
         bot('sendmessage',[
        'chat_id'=>$from_id,
        'text'=>"🛠 created by @iso_plus 

🔻 این ربات فقط فعال بودن ssl رو چک می کنه 
🔻 زمان ایجاد ssl رو میگه 
🔻 زمان انقضای ssl رو میگه
🔻 سریال ssl رو میگه 
🔻 زمان باقی مانده ssl رو میگه 
🔻 نوع ssl رو میگه

‼️ اگر ssl شما رایگان باشه و خودکار از طرف هاستینگ فعال شده باشه و انقضا ی اون برسه خودکار مجدد شارژ میشه ",
        'reply_to_message_id'=>$message_id,
        ]);
}

// جهت استفاده از هاست خارج استفاده کنید و حتما ست وب هوک کنید
