<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'jdf.php';

function js($array,$j=0) {
	return json_encode($array,$j);
}
function jd($array,$j=0) {
	return json_decode($array,$j);
}

$token = getenv('BOT_TOKEN'); // دریافت امن از محیط
define('API_KEY',$token);

if(!is_dir('ne'))mkdir('ne');

function Neman($method,$data=[],$token=API_KEY) {
	$ch=curl_init('https://api.telegram.org/bot'.$token.'/'.$method);
	curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>1,CURLOPT_POSTFIELDS=>$data]);
	return jd(curl_exec($ch));
}

$bot=Neman('getme')->result;
$usbot=$bot->username;
$bname=$bot->first_name;
$botid=$bot->id;

$upd=jd(file_get_contents('php://input'));

if($msg=$upd->message) {
	$text=$msg->text;
	$date=$msg->date;
	$from=$msg->from;
	$from_first_name=$from->first_name;
	$from_last_name=$from->last_name;
	$from_username=$from->username;
	$from_is_bot=$from->is_bot;
	$from=$from->id;
	$chat=$msg->chat;
	$type=$chat->type;
	$chat_type=$type;
	$chat_title=$chat->title;
	$chat=$chat->id;
	$reply_to_message=$msg->reply_to_message;
	$reply_to_message_photo=$reply_to_message->photo;
	$reply_to_message_photo=$reply_to_message->sticker_file_id;
	$rp=$reply_to_message;
	$rp_from=$rp->from;
	$rp_from_id=$rp_from->id;
	$rp_from_username=$rp_from->username;
	$rp_message_id=$rp->message_id;
	$msgid=$msg->message_id;
	$message_id=$msgid;
	$left_chat_member=$msg->left_chat_member;
	$new_chat_member=$msg->new_chat_member;
	$new_chat_members=$msg->new_chat_members;
	$photo=$msg->photo;
	$sticker=$msg->sticker;
	$forward_from=$msg->forward_from;
	$forward_from_chat=$msg->forward_from_chat;
	$video=$msg->video;
	$voice=$msg->voice;
	$document=$msg->document;
	$video_note=$msg->video_note;
	$game=$msg->game;
	$location=$msg->location;
	$contact=$msg->contact;
	$entities=$msg->entities;
	$caption=$msg->caption;
	$caption_entities=$msg->caption_entities;
	$audio=$msg->audio;
}

if($query=$upd->callback_query) {
	$msg=$query->message;
	$text=$msg->text;
	$date=$msg->date;
	$from=$query->from;
	$msgid=$msg->message_id;
	$message_id=$msgid;
	$from_first_name=$from->first_name;
	$from_last_name=$from->last_name;
	$from_username=$from->username;
	$from=$from->id;
	$chat=$msg->chat;
	$type=$chat->type;
	$chat_type=$type;
	$chat_title=$chat->title;
	$chat=$chat->id;
	$idc=$query->id;
	$data=$query->data;
}

if($msg=$upd->edited_message) {
	$text=$msg->text;
	$date=$msg->date;
	$msgid=$msg->message_id;
	$message_id=$msgid;
	$from=$msg->from;
	$from_first_name=$from->first_name;
	$from_last_name=$from->last_name;
	$from_username=$from->username;
	$from=$from->id;
	$chat=$msg->chat;
	$chat_type=$chat->type;
	$chat_title=$chat->title;
	$chat=$chat->id;
	$type=$chat_type;
	$photo=$msg->photo;
	$sticker=$msg->sticker;
	$forward_from=$msg->forward_from;
	$forward_from_chat=$msg->forward_from_chat;
	$video=$msg->video;
	$voice=$msg->voice;
	$document=$msg->document;
	$video_note=$msg->video_note;
	$game=$msg->game;
	$location=$msg->location;
	$contact=$msg->contact;
	$entities=$msg->entities;
	$caption=$msg->caption;
	$caption_entities=$msg->caption_entities;
	$audio=$msg->audio;
}

$types=[
	'photo',
	'text',
	'sticker',
	'voice',
	'video',
	'left_chat_member',
	'forward_from',
	'forward_from_chat',
	'new_chat_members'
];

$randn=[
	'بوس %n',
	'بای %n'
];

$monas=[
	'98/10'=>'http://uupload.ir/files/aqn_۲۰۱۹۱۲۲۵_۱۹۰۷۰۶.jpg'
];

$locks=[
	'gif'=>'گیف',
	'document'=>'فایل',
	'sticker'=>'استیکر',
	'photo'=>'عکس',
	'video'=>'فیلم',
	'videonote'=>'فیلم سلفی',
	'audio'=>'آهنگ',
	'voice'=>'صدا',
	'game'=>'بازی',
	'location'=>'مکان',
	'contact'=>'مخاطب',
	'tgservice'=>'خدمات تلگرام',
	'text'=>'متن',
	'sticker animation'=>'استیکر متحرک',
	'emoji'=>'شکلک',
	'verfication'=>'احراز هویت',
	'link'=>'لینک',
	'hyper'=>'هایپر',
	'forward'=>'نقل قول',
	'tag'=>'شناسه کاربری',
	'hashtag'=>'هشتگ',
	'persian'=>'فارسی',
	'english'=>'انگلیسی',
	'badword'=>'فحش',
	'bot'=>'ربات',
	'join'=>'عضوجدید',
	'flood'=>'رگبار',
	'addbot'=>'اد ربات',
	'hard'=>'سختگیرانه'
];

$dev=[7807129923,0000000];//ایدی عددی ادمین
// Defines

define('FROM',$from);
define('CHAT',$chat);
define('MSGID',$msgid);

function sm($from,$text,$key='',$reply='',$parse='') {
	if(mb_strlen($text)>4096) {
		foreach(array_chunk(preg_split('//u',$text),4096) as $txt)
			$ar[]=Neman('sendmessage',[
				'chat_id'=>$from,
				'text'=>join($txt),
				'reply_markup'=>$key,
				'reply_to_message_id'=>$reply,
				'parse_mode'=>$parse
			]);
		return $ar;
	}else
	return Neman('sendmessage',[
		'chat_id'=>$from,
		'text'=>$text,
		'reply_markup'=>$key,
		'reply_to_message_id'=>$reply,
		'parse_mode'=>$parse
	]);
}

function reply($text,$key='',$parse='markdown',$reply='') {
	global $chat,$msgid;
	return sm($chat,$text,$key,$reply?:$msgid,$parse);
}

function leave($chat=CHAT) {
	return Neman('leavechat',[
		'chat_id'=>$chat
	]);
}

function forward($from,$chat,$msgid) {
	return Neman('forwardmessage',[
		'chat_id'=>$from,
		'from_chat_id'=>$chat,
		'message_id'=>$msgid
	]);
}

function editmessage($chat,$msg,$text,$key='',$parse) {
	return Neman('editmessagetext',[
		'chat_id'=>$chat,
		'message_id'=>$msg,
		'text'=>$text,
		'reply_markup'=>$key,
		'parse_mode'=>$parse
	]);
}
function edit($text,$key='',$parse='markdown') {
	global $chat,$msgid;
	return editmessage($chat,$msgid,$text,$key,$parse);
}

function administrator($chat=CHAT,$user='') {
	$s=Neman('getchatadministrators',[
		'chat_id'=>$chat
	])->result;
	if($user=='')return $s;
	else return $s;
}

function admins($chat=CHAT) {
	foreach(administrator($chat) as $admin)$ad[]=$admin->user->id;
	return $ad;
}

function is_member($user,$chat=CHAT) {
	return Neman('getchatmember',[
		'chat_id'=>$chat,
		'user_id'=>$user
	])->result->user->id;
}

function kick($id=FROM,$chat=CHAT) {
	return Neman('kickchatmember',[
		'chat_id'=>$chat,
		'user_id'=>$id
	]);
}

function is_admin($user=FROM,$chat=CHAT) {
	return in_array($user,admins($chat));
}
function alert($text,$show=false){
	return Neman('answercallbackquery',[
		'callback_query_id'=>$GLOBALS['idc'],
		'text'=>$text,
		'show_alert'=>$show
	]);
}
function silent($id,$tof=false,$date=0,$chat=CHAT) {
	return Neman('restrictChatMember',[
		'chat_id'=>$chat,
		'user_id'=>$id,
		'permissions'=>js([
			'can_send_messages'=>$tof
		]),
		'until_date'=>$date
	]);
}

function getinfo($id=FROM) {
	return Neman('getchat',[
		'chat_id'=>$id
	])->result;
}

function unban($id,$chat=CHAT) {
	return Neman('unbanChatMember',[
		'chat_id'=>$chat,
		'user_id'=>$id
	]);
}

function getprofiles($user=FROM) {
	return Neman('getUserProfilePhotos',[
		'user_id'=>$user
	])->result;
}

function reply_photo($photo,$caption='',$key='',$msgid='',$parse='markdown') {
	return Neman('sendphoto',[
		'chat_id'=>CHAT,
		'photo'=>$photo,
		'caption'=>$caption,
		'reply_markup'=>$key,
		'reply_to_message_id'=>$msgid?:$GLOBALS['message_id'],
		'parse_mode'=>$parse
	]);
}

function del($msgid=MSGID,$chat=CHAT) {
	return Neman('deletemessage',[
		'chat_id'=>$chat,
		'message_id'=>$msgid
	]);
}

class db extends mysqli {
	public function insert($table,$query) {
		$val='';
		foreach($query as $v)
			$val.="'".$this->real_escape_string($v)."',";
		$val=trim($val,"',");
		$this->query("insert into `$table`(".join(',',array_keys($query)).")values('$val')");
	}
	public function fetchone($query) {
		return $this->query($query)->fetch_assoc();
	}
	public function del($table,$where='') {
		$this->query("delete from `$table`".($where?' where '.$where:''));
	}
	public function drop($table) {
		$this->query("drop table `$table`");
	}
	public function fetchall($query) {
		$q=$this->query($query);
		while($r=$q->fetch_assoc()!==false)
			$ar[]=$r;
		return $ar;
	}
	public function update($table,$sets,$where="id='".CHAT."'") {
		$set='';
		foreach($sets as $col=>$value)
			$set.="`$col`='".$this->real_escape_string($value)."',";
		$this->query("update `$table` set ".trim($set,',')."where $where");
	}
}

$questions=jd(file_get_contents('questions.json'),1);

$ne=new db('localhost','user','pass','dbname');//اطلاعات دیتابیس به ترتیب گذاری کنید
;

$ne->query('create table if not exists groups(id varchar(15),creator varchar(10),vip json,promote json,ban json,flood json,locked json,warn json,silent json,step json,filter json,installer int,del json)');
$ne->query('create table if not exists members(id varchar(10))');

$ne->query('create table if not exists sendall(id int auto_increment primary key,send json,now int default 0)');

$channel='fatherweb';//یوزر نیم چنل 
$hash=str_replace('_','\_','K9RQAxasT3FBbyHYs0q_Q');// آیدی گروه خصوصی


$k_start=json_encode(['keyboard'=>[
	[['text'=>'گروه پشتیبانی'],['text'=>'آموزش اد کردن ربات']],
	[['text'=>'بزرگترین لینکدونی']]
],'resize_keyboard'=>true]);


if($chat_type=='private') {
	if($text=='/start') {
		if(!$ne->fetchone("select * from members where id='$from'"))
			$ne->insert('members',['id'=>$from]);
		reply("• با سلام ❤️\nبرای استفاده از ربات لطفا از طریق لینک زیر ربات را به گروه خود اضافه کنید .\nhttps://telegram.me/$usbot?startgroup=new\n\n- مرحله ی دوم :\nربات را در گروه ادمین کنید تا فعالیت خود را به طور کامل انجام دهد .\n\n- پس از ادمین کردن ربات در صورت فعال نشدن از دستور\n/start\nاستفاده کنید .\n\n-در صورت بروز هرگونه مشکلی کافی است در گروه پشتیبانی https://t.me/drsite پیام بدید.\n\n• Ch : @$channel",$k_start);
	}
	if($text=='بزرگترین لینکدونی')
		reply("کانال ما ارائه دهده خدمات تلگرامی با بهترین کیفیت و قیمت میباشد .\n            \nتبلیغ گروه و کانال شما\nممبر کانال\nرباتهای قدرتمند رایگان و پولی\n        \nلطفا برای حمایت از ما در کانال زیر عضو شوید 🌹\n            \n• Ch : @$channel");
	if($text=='گروه پشتیبانی')
		reply("قوانين گروه پشتيباني :\n            \nاین گروه متعلق به ربات $bname میباشد !\nپشتیبانی و پاسخ به سوالات برخی از کاربران ربات در این گروه انجام می شود .\n\nدر گروه پشتیبانی قوانین زیر را رعایت کنید :\n\n🔸ارسال تبلیغات به هر شکل در این گروه ممنوع است از جمله تبلیغات : ربات، کانال، گروه، وب سایت و ...\n🔸چت بیخود ممنوع و از ارسال گیف و استیکر در گروه خودداری کنید !\n🔸فحش و فحاشی به اعضای گروه، اکیدا ممنوع میباشید و در صورت مشاهده برخورد جدی خواهد شد !\n🔹در صورت مشاهده از گروه مسدود و در صورت لزوم از تمامی گروه‌های ربات ".strtoupper($bname)." محروم خواهید شد !\n\nلطفا به نکات بالا توجه فرمایید تا محیطی دوستانه و صمیمی را در کنار یکدیگر داشته باشیم 🌹\n\nhttps://t.me/iranpanele");
	if($text=='آموزش اد کردن ربات')
		reply("• شما میتوانید با کلیک بر روی لینک زیر ربات را به گروه خود دعوت کنید !\n            \nhttp://t.me/$usbot?startgroup=new'");
	require 'panel.php';
}


if($type=='group') {
	if($text=='/start')
		reply("• ربات توانایی نصب شدن در گروه معمولی را ندارد !\n\n» در صورت نیاز به پشتیبانی به گروه پشتیبانی ربات مراجعه کنید .\n\n[» Click To Join DIGIANTI Support Group «](https://t.me/fatherweb)\n\n• Ch : @$channel");
	return;
}

if($type=='supergroup') {
	require 'gp.php';
}
