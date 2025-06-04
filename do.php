<?php
require 'vendor/autoload.php';
use Gregwar\Captcha\CaptchaBuilder;

if($text=='بای' and $nick=$step->nickname->$from) {
	reply(str_replace('%n',$nick,$randn[array_rand($randn)]),null,null);
}

if($step->autolockNow=='on') {
	if($d1=explode(':',$step->autolockStart) and $d2=explode(':',$step->autolockEnd)) {
		if(jmktime($d2[0],$d2[1])<=time()) {
			if($step->sayautolock) {
				unset($step->sayautolock);
				sm($chat,"• زمان قفل خودکار به پایان رسیده است !

» کاربران میتوانند مطالب خود را ارسال کنند .");
				$ne->update('groups',['step'=>js($step,256)]);
			}
		}
		else if(jmktime($d1[0],$d1[1])>=time()) {
			if(!is_creator() and !is_admin() and !is_promote() and !is_vip())del();
			if(!$step->sayautolock) {
				$step->sayautolock='ok';
				sm($chat,"• زمان فعال شدن قفل خودکار رسیده است قفل خودکار فعال میشود !

» ارسال پیام در گروه تا ساعت [ {$step->autolockEnd} ] ممنوع میباشد .",null,null);
				$ne->update('groups',['step'=>js($step,256)]);
			}
		}
	}
}

if($step->status->now=='on' and $d=$step->status->date) {
	$d=explode(':',$d);
	if(jmktime($d[0],$d[1])<=time() and $step->status->today!=date('m')) {
		$step->status->today=date('m');
		$ne->update('groups',['step'=>js($step,256)]);
		$da=tr_num(jdate('Y/m/d'));
	$ho=tr_num(jdate('H:i'));
	$msg=$step->msgs;
	$fo=($msg->forward_from+$msg->from_from_chat)?:0;
	$new=$msg->new_chat_members?:0;
	$le=$msg->left_chat_member?:0;
	$ba=$msg->banned?:0;
	$si=$msg->silented?:0;
	$vi=$msg->video?:0;
	$v=$msg->voice?:0;
	$p=$msg->photo?:0;
	$s=$msg->sticker?:0;
	$al=$vi+$fo+$v+$p+$s+$msg->text;
	
	foreach($step->users as $id=>$js)
		$ar[$id]=$js->msgs;
	arsort($ar);

	$f1='نفر اول 🥇
با '.current($ar).' پیام <a href="tg://user?id='.key($ar).'">'.(mb_substr(htmlentities(getinfo(key($ar))->first_name),0,25)).'</a>';
	next($ar);
	$f2=current($ar)?PHP_EOL.'نفر دوم 🥈
با '.current($ar).' پیام <a href="tg://user?id='.key($ar).'">'.(mb_substr(htmlentities(getinfo(key($ar))->first_name),0,25)).'</a>':'';
	next($ar);
	$f3=current($ar)?PHP_EOL.'نفر سوم 🥉
با '.current($ar).' پیام <a href="tg://user?id='.key($ar).'">'.(mb_substr(htmlentities(getinfo(key($ar))->first_name),0,25)).'</a>':'';
	
	reply("◄ فعالیت های امروز  تا این لحظه

• چهارشنبه ، $da
• ساعت : $ho

• کل پیام ها: $al
• پیام های فورواردی: $fo

• فعال ترین اعضای گروه:
 $f1$f2$f3

• اعضای جدید: $new
• اعضای خارج شده: $le
• اعضای اخراج شده: $ba
• اعضای سکوت شده: $si

🔹فیلم ها: $vi
🔹عکس ها: $p
🔹صداها: $v
🔹استیکر ها: $s",null,'html');
	}
}

if($n=$msg->new_chat_members or $n[]=$msg->new_chat_member)
	foreach($n as $g) {
		$i=0;
		$id=$g->id;
		if($lock->join=='on'){$i++;kick($id);}
		if($g->is_bot==true) {
			if($lock->bot=='on')kick($id);
			if($lock->addbot=='on')kick();
			$i++;
		}
		if($i==0) {
			if($from!=$id and $step->adde->ok=='on') {
				if($step->adde->list->$from->ok!='ok') {
					if($step->adde->list->$from->ok+1==$step->adde->t) {
						$step->adde->list->$from->ok='ok';
						reply("[کاربر](tg://user?id=$from) شما معاف شدید.");
					}else
						$step->adde->list->$from->ok=$step->adde->list->$from->ok+1;
					$ne->update('groups',['step'=>js($step,256)]);
				}
			}
			if($lock->verfication=='on' and !$step->ver->$from) {
				$x=rand(1000,9999);
				$captcha=new CaptchaBuilder((string)$x);
				$captcha->build();
				$captcha->save($chat.$id.'.jpg');
				$n=[rand(1000,9999),$x,rand(1000,9999),rand(1000,9999)];
				shuffle($n);
				$k=js(['inline_keyboard'=>[
					[['text'=>$n[0],'callback_data'=>'v-'.$id.'-'.($x==$n[0]?'t':'w')],['text'=>$n[1],'callback_data'=>'v-'.$id.'-'.($x==$n[1]?'t':'w')]],
					[['text'=>$n[2],'callback_data'=>'v-'.$id.'-'.($x==$n[2]?'t':'w')],['text'=>$n[3],'callback_data'=>'v-'.$id.'-'.($x==$n[3]?'t':'w')]],
					[['text'=>'معاف','callback_data'=>'free-'.$id]]
				]]);
				reply_photo(new curlfile($chat.$id.'.jpg'),"[کاربر](tg://user?id=$id) گرامی
عدد داخل عکس را از دکمه های زیر انتخاب کنید.",$k);
				unlink($chat.$id.'.jpg');
				$step->ver->$id=1;
				$ne->update('groups',['step'=>js($step,256)]);
			}
			else if($step->welcome->now=='on') {
				$m=reply(str_replace(['mention','firstname','lastname','username','groupname','grouprules','grouplink','userid','time','date'],["<a href='tg://user?id=$id'>".htmlentities($g->first_name)."</a>",$g->first_name,$g->last_name,$g->username?'@'.$g->username:'',$chat_title,$step->rules,$step->link,$id,tr_num(jdate('H:i')),tr_num(jdate('Y/m/d'))],htmlentities($step->welcome->pm?:'سلام firstname
به گروه groupname خوش امدید 🌹

ساعت : time')),null,'html')->result->message_id;
				if($s=$step->welcome->del) {
					$del->$m=time()+$s;
					$ne->update('groups',['del'=>js($del)]);
				}
			}
		}
	}

if($lock->tgservice=='on' and ($msg->left_chat_member or $msg->new_chat_member))del();

if(!is_creator() and !is_admin() and !is_promote() and !is_vip()) {

if($c=$step->adj->ch and $step->adj->ok=='on') {
	if(!Neman('getchatmember',['chat_id'=>$c,'user_id'=>$botid])->result) {
		reply('عضویت اجباری فعال است ولی منو تو کانالت ادمین نکردی.. برای استفاده از این قابلیت منو ادمین کن!');
		$step->adj->say='ok';
		$ne->update('groups',['step'=>js($step,256)]);
	}else if(Neman('getchatmember',['chat_id'=>$c,'user_id'=>$from])->result->status=='left') {
		$k_c=js(['inline_keyboard'=>[
			[['text'=>'• ورود به کانال','url'=>'https://t.me/'.str_replace('@','',$c)]]
		]]);
		$m=reply("• [$name](tg://user?id=$from) -  $from برای ارسال پیام باید *عضو کانال* گروه باشید ، لطفاً با استفاده از دکمه زیر در کانال عضو شوید !

⚠️ شما در کانال عضو نیستید:",$k_c)->result->message_id;
		$step->adj->list->$from=time()+60;
		$del->$m=time()+30;
		$ne->update('groups',['step'=>js($step,256)]);
	}else if($step->adj->list->$from) {
		unset($step->adj->list->$from);
		$ne->update('groups',['step'=>js($step,256)]);
	}
}

if($step->adj->ok=='on' and $step->adj->ch and $step->adj->list->$from<time()) {
	del();
	$k_c=js(['inline_keyboard'=>[
		[['text'=>'• ورود به کانال','url'=>'https://t.me/'.str_replace('@','',$c)]]
	]]);
	$m=reply("• [$name](tg://user?id=$from) -  $from برای ارسال پیام باید *عضو کانال* گروه باشید ، لطفاً با استفاده از دکمه زیر در کانال عضو شوید !

⚠️ شما در کانال عضو نیستید:",$k_c)->result->message_id;
	$step->adj->list->$from=time()+60;
	$del->$m=time()+30;
	$ne->update('groups',['step'=>js($step,256)]);
}

if($step->adde->ok=='on' and $step->adde->list->$from->ok!='ok' and !$new_chat_member) {
	if(!$step->adde->list->$from->ok and $step->adde->type=='now') {
		$step->adde->list->$from->ok='ok';
		$ne->update('groups',['step'=>js($step,256)]);
	}
	if($step->adde->list->$from->time<=time()) {
		$x=$step->adde->list->$from->ok?:0;
		$t=$step->adde->t;
		$m=sm($chat,"کاربر <a href='tg://user?id=$from'>".htmlentities($from_first_name)."</a> با آیدی عددی $from شما برای چت کردن باید $t نفر را دعوت کنید.
تعداد ادد های شما $x",null,null,'html')->result->message_id;
		$del->$m=time()+$step->adde->d;
		$step->adde->list->$from->time=time()+60;
		$ne->update('groups',['del'=>js($del),'step'=>js($step,256)]);
	}
	del();
}

if($lock->flood=='on') {
	$flood['list'][$from][]=time();
$ne->update('groups',['flood'=>js($flood)]);
	$ar=array_slice($flood['list'][$from],-($flood['max']));
	foreach(array_diff($flood['list'][$from],$ar) as $x)unset($flood['list'][$from][$x]);
	if(count($ar)==$flood['max']) {
		$t=$flood['time'];
		if((end($ar)-$ar[0])<$t) {
			if($flood['type']=='silent')silent();
			else kick();
			unset($flood['list'][$from]);
		}
	}
	$ne->update('groups',['flood'=>js($flood)]);
}

if(($lock->hard=='on' and ($msg->forward_from or $msg->forward_from_chat or array_search('url',array_column(($msg->entities?:$msg->caption_entities),'type')) ) ) or ($lock->tabchi=='on' and str_ireplace(['سکس','صیغه'],'',$from_first_name.$from_last_name)!=$from_first_name.$from_last_name))kick();

if(preg_match('~^v-(.+)-(.)$~',$data,$d)) {
	if($d[1]==$from) {
		if($d[2]=='w') {
			if($step->ver->$from==1) {
				alert('گزینه ی اشتباه را انتخاب کردید، شما فقط یک فرصت دیگر دارید.',true);
				del();
				$x=rand(1000,9999);
				$captcha=new CaptchaBuilder((string)$x);
				$captcha->build();
				$captcha->save($chat.$from.'.jpg');
				$n=[rand(1000,9999),$x,rand(1000,9999),rand(1000,9999)];
				shuffle($n);
				$k=js(['inline_keyboard'=>[
					[['text'=>$n[0],'callback_data'=>'v-'.$from.'-'.($x==$n[0]?'t':'w')],['text'=>$n[1],'callback_data'=>'v-'.$from.'-'.($x==$n[1]?'t':'w')]],
					[['text'=>$n[2],'callback_data'=>'v-'.$from.'-'.($x==$n[2]?'t':'w')],['text'=>$n[3],'callback_data'=>'v-'.$from.'-'.($x==$n[3]?'t':'w')]],
					[['text'=>'معاف','callback_data'=>'free-'.$from]]
				]]);
				reply_photo(new curlfile($chat.$from.'.jpg'),"[کاربر](tg://user?id=$from) گرامی
عدد داخل عکس را از دکمه های زیر انتخاب کنید.",$k);
				unlink($chat.$from.'.jpg');
				$step->ver->$from=2;
				$ne->update('groups',['step'=>js($step,256)]);
			}else{
				alert('گزینه اشتباه بود، برای تلاش مجدد، دوباره وارد گروه شوید.');
				del();
			}
		}else{
			unset($step->ver->$from);
			$ne->update('groups',['step'=>js($step,256)]);
			alert('تأیید شدید!');
			del();
		}
	}else
		alert('این برای شما نیست!',true);
}

if(!$data and (($e=array_intersect(array_keys(jd(js($msg),1)),array_keys($locks)) and $e=end($e) and $lock->$e=='on') or $step->mute=='on' or ($lock->gif=='on' and $msg->animation and $msg->document) or ($lock->{'sticker animation'}=='on' and $msg->sticker->is_animated==true) or ($lock->videonote=='on' and $msg->video_note) or (strpos(($text?:$caption),'@')!==false and $lock->tag=='on') or (strpos(($text?:$caption),'#')!==false and $lock->hashtag=='on') or (preg_match('~[a-z0-9]~i',($text?:$caption)) and $lock->english=='on') or (preg_match('~[ضصقفغعهخحجکمنتالبیشسظطدزروچپگژ۱۲۳۴۵۶۷۸۹۰]~i',($text?:$caption)) and $lock->persian=='on') or ($lock->link=='on' and ($msg->entities[array_search('url',array_column(jd(js($msg->entities?:$msg->caption_entities),1),'type'))] or $msg->caption_entities[array_search('url',array_column(jd(js($msg->entities?:$msg->caption_entities),1),'type'))])) or ($lock->hyper=='on' and ($msg->entities[array_search('text_link',array_column(jd(js($msg->entities?:$msg->caption_entities),1),'type'))] or $msg->captuon_entities[array_search('text_link',array_column(jd(js($msg->entities?:$msg->caption_entities),1),'type'))])) or (str_ireplace($filter,'',($text?:$caption))!=($text?:$caption)) or ($lock->forward=='on' and ($msg->forward_from or $msg->forward_from_chat)) or $step->ver->$from or $step->adj->list->$from or ($lock->emoji=='on' and preg_match('~([*#0-9](?>\\xEF\\xB8\\x8F)?\\xE2\\x83\\xA3|\\xC2[\\xA9\\xAE]|\\xE2..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?(?>\\xEF\\xB8\\x8F)?|\\xE3(?>\\x80[\\xB0\\xBD]|\\x8A[\\x97\\x99])(?>\\xEF\\xB8\\x8F)?|\\xF0\\x9F(?>[\\x80-\\x86].(?>\\xEF\\xB8\\x8F)?|\\x87.\\xF0\\x9F\\x87.|..(\\xF0\\x9F\\x8F[\\xBB-\\xBF])?|(((?<zwj>\\xE2\\x80\\x8D)\\xE2\\x9D\\xA4\\xEF\\xB8\\x8F\k<zwj>\\xF0\\x9F..(\k<zwj>\\xF0\\x9F\\x91.)?|(\\xE2\\x80\\x8D\\xF0\\x9F\\x91.){2,3}))?))~',($text?:$caption)) )))del();
}
