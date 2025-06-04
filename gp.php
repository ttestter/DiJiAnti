<?php
$channel = "fatherweb";
$channel2 = "iranpanele";

$sql=$ne->fetchone("select * from groups where id='$chat'");

$promote=jd($sql['promote']);
$warn=jd($sql['warn']);
$vip=jd($sql['vip'],1);
$step=jd($sql['step']);
$filter=jd($sql['filter'],1);
$lock=jd($sql['locked']);
$flood=jd($sql['flood'],1);
$del=jd($sql['del']);
$ban=jd($sql['ban']);

function is_promote($user=FROM,$chat=CHAT) {
	return in_array($user,jd($GLOBALS['ne']->fetchone("select * from groups where id='$chat'")['promote']));
}

function is_vip($user=FROM,$chat=CHAT) {
	return in_array($user,jd($GLOBALS['ne']->fetchone("select * from groups where id='$chat'")['vip']));
}

function add_promote($user,$chat=CHAT) {
	global $ne,$promote;
	if(!is_promote($user,$chat))$promote[]=$user;
	$ne->update('groups',['promote'=>js($promote)],"id='$chat'");
}

function rem_promote($user,$chat=CHAT) {
	global $ne,$promote;
	if(is_promote($user,$chat))unset($promote[array_search($user,$promote)]);
	$ne->update('groups',['promote'=>js($promote)],"id='$chat'");
}


function creator($chat=CHAT) {
	foreach(administrator($chat) as $admin)
		if($admin->status=='creator')return $admin;
}
function is_creator($user=FROM,$chat=CHAT) {
	return creator($chat)->user->id==$user;
}

function setwarn($warn,$chat=CHAT) {
	global $ne,$warn;
	$warn->warn=$warn;
	$ne->update('groups',['warn'=>js($warn)],"id='$chat'");
}

function warn($user,$len=1,$chat=CHAT) {
	global $ne,$warn;
	if($warn->warnlist->$user)
		$warn->warnlist->$user+=$len;
	else
		$warn->warnlist->$user=$len;
	$ne->update('groups',['warn'=>js($warn)],"id='$chat'");
	return [$warn->warnlist->$user,$warn->warn];
}


$cmd=tr_num(strtolower(preg_replace(['~^[@#$%&!\?/]*|@'.$usbot.'$~i'],'',$text)));

if(($date<time()-5) and !$data)return;

if($ne->query("select * from groups")->num_rows>=900) {
	reply("بات پر شده، از بات دیگمون استفاده کنید.");
	leave();
}

if($cmd=='start' or $cmd=='نصب') {
	if($sql and (is_promote() or is_creator())) {
		reply("• این گروه از قبل نصب شده است !\n\n» در صورت نیاز به پشتیبانی به گروه پشتیبانی ربات مراجعه کنید .\n\n[» Click To Join DIGIANTI Support Group «](https://t.me/joinchat/$hash)\n\n• Ch : @$channel");
	}
	else if(!$sql) {
		$admins=admins();
		$len=count($admins)-1;
		$creator=creator()->user;
		$us=$creator->username?' - @'.$creator->username:'';
		$ne->insert('groups',['id'=>$chat,'promote'=>js($admins),'creator'=>$creator->id,'warn'=>js(['warn'=>3,'type'=>'ban']),'installer'=>$from,'flood'=>js(['max'=>3,'time'=>3,'type'=>'silent']),'locked'=>js(['link'=>'on','badword'=>'on','bot'=>'on','tag'=>'on','addbot'=>'on','hashtag'=>'on']),'step'=>js(['adde'=>['t'=>3,'d'=>3]])]);
		$creator=$creator->id.$us;
		if($x=explode(',',file_get_contents("ne/sauto.txt")))forward($chat,$x[0],$x[1]);
		reply("• ربات با موفقیت در گروه نصب شد !\n\n» کاربر [ $creator ] به عنوان مالک گروه تنظیم شد !\n\n» [ $len ] ادمین شناسایی شده با موفقیت ترفیع یافتند .\n\n» ابتدا ربات را ادمین کنید و برای اطلاع از دستورات ربات میتوانید از دستور زیر استفاده کنید 👇🏻\n/help\n\n» درصورت وجود هرگونه مشکل در نصب یا ربات با گروه پشتیبانی در ارتباط باشید : https://t.me/joinchat/$hash \n\n• Ch : @$channel",null,null);
	}
}

if(count($x=explode(',',file_get_contents("ne/st.txt")))==3 and ($step->sendads+($x[2]*60*60))<=time()) {
	forward($chat,$x[0],$x[1]);
	$step->sendads=time()+($x[2]*60*60);
	$ne->update('groups',['step'=>js($step,256)]);
}

if(!$sql or !in_array($botid,admins()))return;

require 'do.php';

if($answers=$questions[$text])reply($answers[array_rand($answers)]);

if($e=array_intersect(array_keys(jd(js($update->message),1)),$types) and $e=end($e)) {
	if($step->msgs->date!=date('d')) {
		unset($step->msgs);
		$step->msgs->date=date('d');
		foreach($step->users as $id=>$v)
			$step->users->$id->msgs=0;
	}
	if($step->users->$from->msgs)$step->users->$from->msgs+=1;else $step->users->$from->msgs=1;
	if($step->msgs->$e)$step->msgs->$e+=1;else $step->msgs->$e=1;
	if($n=$update->message->new_chat_member->id and $n!=$from)
		if($step->users->$from->added)
			$step->users->$from->added+=1;
		else
			$step->users->$from->added=1;
	$ne->update('groups',['step'=>js($step,256)]);
}

if(is_promote() or is_creator()) {

if($cmd=='config' or $cmd=='پیکربندی' and is_creator()) {
	$len=0;
	foreach(admins() as $admin) {
		if(!in_array($admin,$promote)) {
			$promote[]=$admin;
			$len++;
		}
	}
	$admin=creator()->user->id;
	$ne->update('groups',['promote'=>js($promote),'creator'=>$admin]);
	reply("• کاربر [ <a href='tg://user?id=$admin'>$admin</a> ] به عنوان مالک گروه تنظیم شد !\n\n» ( $len ) ادمین شناسایی شده با موفقیت ترفیع یافتند .\n\n• Ch : @$channel",null,'html');
}

if($cmd=='modlist' or $cmd=='لیست مدیران') {
	$i=0;
	$s='';
	foreach($promote as $id) {
		$i++;
		$s.="\n$i - [ <a href='tg://user?id=$id'>$id</a> ]";
	}
	if($s)
		reply("» لیست مدیران گروه :\n$s",null,'html');
	else
		reply("• لیست مدیران گروه خالی میباشد !");
}

if($cmd=='clean modlist' or $cmd=='پاکسازی لیست مدیران') {
	$ne->update('groups',['promote'=>'[]']);
	$len=count($promote);
	reply("• لیست مدیران گروه پاکسازی شد !\n\n» تعداد مدیران : [ $len ]\n\n• Ch : @$channel");
}

if((preg_match('~^(?:promote|تنظیم مدیر) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='promote' or $cmd=='تنظیم مدیر')) and $id!=$botid) {
	if($id=is_member($id)) {
		$tg="[$id](tg://user?id=$id)";
		if(!is_promote($id)) {
			reply("_› کاربر (_ $tg _)\n\n›› به لیست مدیران گروه اضافه شد._");
			add_promote($id);
		}else
			reply("_› کاربر (_ $tg _)\n\n›› در لیست مدیران گروه وجود دارد!_");
	}else
		reply("• شناسه نادرست است !");
}

if((preg_match('~^(?:demote|حذف مدیر) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='demote' or $cmd=='حذف مدیر')) and $id!=$botid) {
	if($id=is_member($id)) {
		$tg="[$id](tg://user?id=$id)";
		if(is_promote($id)) {
			reply("_› کاربر (_ $tg _)\n\n›› از لیست مدیران گروه حذف شد._");
			rem_promote($id);
		}else
			reply("_› کاربر (_ $tg _)\n\n›› در لیست مدیران گروه وجود ندارد!_");
	}else
		reply("• شناسه نادرست است !");
}


if($cmd=='help')
	reply("• راهنمای دستورات انگلیسی ربات :

» ترفیع ادمین های گروه :
• <code>config</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» ترفیع کاربر :
• <code>promote</code> 
» عزل کاربر :
• <code>demote</code>
» لیست ترفیع :
• <code>modlist</code>
» پاکسازی لیست ترفیع :
• <code>clean modlist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیم تعداد اخطار :
• <code>setwarn</code> [ 1-10 ]
» اخطار به کاربر :
• <code>warn</code>
» حذف اخطار :
• <code>remwarn</code>
» لیست اخطار :
• <code>warnlist</code>
» پاکسازی لیست اخطار :
• <code>clean warnlist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیم به عنوان کاربر ویژه :
• <code>setvip</code>
» حذف کاربر از لیست ویژه :
• <code>remvip</code> 
» لیست کاربران ویژه :
• <code>viplist</code>
» پاکسازی لیست کاربران ویژه :
• <code>clean viplist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» افزودن کاربر به حالت سکوت :
• <code>silent</code>
» حذف کاربر از حالت سکوت :
• <code>unsilent</code> 
» لیست کاربران در حالت سکوت :
• <code>silentlist</code>
» پاکسازی لیست کاربران در حالت سکوت :
• <code>clean silentlist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» افزودن کاربر به حالت سکوت زمان دار :
• <code>mute</code> [time] [ reply ]
- example : <code>mute 5</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» مسدود کردن کاربر از گروه :
• <code>ban</code> 
» لغومسدودیت کاربر از گروه :
• <code>unban</code>
» لیست کاربران در حالت مسدودیت :
• <code>banlist</code>
» پاکسازی لیست کاربران در حالت مسدودیت :
• <code>clean banlist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» فیلتر کردن کلمه مورد نظر :
• <code>filter</code> [word]
» حذف فیلتر کلمه مرود نظر :
• <code>remfilter</code> [word]
» لیست کلمات فیلتر شده :
• <code>filterlist</code>
» پاکسازی لیست کلمات فیلتر شده :
• <code>clean filterlist</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» فعال کردن پیام خوشامد گویی :
• <code>welcome on</code>
» غیرفعال کردن پیام خوشامد گویی :
• <code>welcome off</code>
» تنظیم پیام خوشامد گویی :
• <code>setwelcome</code> [text]
» حذف پیام خوشامد گویی :
• <code>remwelcome</code>
» شما میتوانید از گزینه های زیر نیز در پیام خوشامد گویی استفاده کنید :
• <code>groupname</code> : بکار بردن نام گروه
• <code>firstname</code> : بکار بردن نام کوچک
• <code>lastname</code> : بکار بردن نام بزرگ
• <code>tag</code> : بکار بردن یوزرنیم
• <code>grouprules</code> : بکار بردن قوانین
• <code>grouplink</code> : بکار بردن لینک
• <code>userid</code> : بکار بردن شناسه
• <code>time</code> : بکار بردن زمان
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل کردن و بازکردن پیام رگباری :
• <code>lock flood</code> / <code>unlock flood</code>
» تنظیم تعداد پیام رگباری :
• <code>setfloodmax</code> [3-10]
» تنظیم زمان پیام رگباری :
• <code>setfloodtime</code> [3-10]
~ ~ ~ ~ ~ ~ ~ ~ ~
» فعال کردن قفل خودکار :
• <code>setautolock</code>
» غیرفعال کردن قفل خودکار :
• <code>remautolock</code>
» وضعیت قفل خودکار :
• <code>autolock stats</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل کردن گروه :
• <code>muteall</code>
» باز کردن گروه :
• <code>unmuteall</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» سنجاق کردن پیام :
• <code>pin</code>
» حذف پیام سنجاق شده :
• <code>unpin</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» اخراج کاربر از گروه :
• <code>kick</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیم لینک گروه :
• <code>setlink</code> [link]
» حذف لینک گروه :
• <code>remlink</code>
» لینک :
• <code>link</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیم قوانین گروه :
• <code>setrules</code> [rules]
» حذف قوانین گروه :
• <code>remrules</code>
» قوانین :
• <code>rules</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» پاک کردم پیام ها :
• <code>del</code> [ 1-100 ]
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیمات گروه :
• <code>settings</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» پنل مدیریتی :
• <code>panel</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» اطلاعات گروه :
• <code>gpinfo</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» اطلاعات کاربر :
• <code>whois</code> [ id ]
• <code>info</code> [ reply ]
• <code>id</code> 
~ ~ ~ ~ ~ ~ ~ ~ ~
» اطلاعات شما :
• <code>me</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» دریافت پروفایل :
• <code>getpro</code> [ 1-200 ]
~ ~ ~ ~ ~ ~ ~ ~ ~
» وضعیت ربات :
• <code>ping</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل ها :
• <code>lock</code> { link | forward | tag | hashtag | persian | english | badword | bot | join | verfication }
» باز کردن قفل ها :
• <code>unlock</code> { link | forward | tag | hashtag | persian | english | badword | bot | join | verfication }
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل رسانه ها :
• <code>lock</code> { gif | contact | photo | video | voice | audio | game | sticker | sticker animation | emoji | text | document | videonote | tgservice | location }
» باز کردن قفل رسانه ها :
• <code>unlock</code> { gif | contact | photo | video | voice | audio | game | sticker | sticker animation | emoji | text | document | videonote | tgservice | location }

• Ch : @fatherweb
• Linkdoni : @$channel2",null,'html');


if(preg_match('/^(?:setwarn|تنظیم اخطار) (\d+)$/',$cmd,$d) and $d=$d[1]) {
	if($d>2) {
		if($d<11) {
			setwarn($d);
			reply("• سقف مجاز اخطار با موفقیت تنظیم شد !\n\n» تعداد مجاز : [ $d ]");
		}else
			reply("• حداکثر مقدار اخطار باید کمتر از 10 باشد !");
	}else
		reply("• حداقل مقدار اخطار باید بیشتر از 2 باشد !");
}

if((preg_match('~^(?:warn|اخطار) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='warn' or $cmd=='اخطار')) and $id!=$botid) {
	if($id=is_member($id)) {
		if(!is_promote($id) and !is_creator($id)) {
			$w=warn($id);
			if($w[0]>=$w[1]) {
				if($warn->type=='ban') {
					kick($id);
					if($step->msgs->banned)$step->msgs->banned+=1;else $step->msgs->banned=1;
					$ban->$id=1;
					$ne->update('groups',['step'=>js($step,256),'ban'=>js($ban)]);
					
					reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› به دلیل دریافت بیش از حد مجاز اخطار اخراج میشوید!_");
				}else{
					silent($id);
					if($step->msgs->silented)$step->msgs->silented+=1;else $step->msgs->silented=1;
					$ne->update('groups',['step'=>js($step,256)]);
					
					reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› به دلیل دریافت بیش از حد مجاز اخطار سکوت میشوید!_");
				}
			}else
				reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› شما [ {$w[0]}/{$w[1]} ] اخطار دریافت کردید._");
		}else
			reply("• شما دسترسی لازم برای اخطار دادن به [ مدیران | سازندگان ] ربات را ندارید !");
	}else
		reply("• شناسه نادرست است !");
}
if((preg_match('~^(?:remwarn|حذف اخطار) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='remwarn' or $cmd=='حذف اخطار')) and $id!=$botid) {
	if($id=is_member($id)) {
		if($warn->warnlist->$id) {
			unset($warn->warnlist->$id);
			$ne->update('groups',['warn'=>js($warn)]);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› اخطارهای شما با موفقیت پاکسازی شدند._");
		}else
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در حال حاضر اخطاری دریافت نکرده است!_");
	}else
		reply("• شناسه نادرست است !");
}

if($cmd=='clean warnlist' or $cmd=='پاکسازی لیست اخطار') {
	if($warn->warnlist) {
		$warn->warnlist=[];
		$ne->update('groups',['warn'=>js($warn)]);
		reply("• لیست کاربرانی که اخطار دریافت کرده اند پاکسازی شد !\n\n• Ch : @$channel");
	}else
		reply("• لیست کاربرانی که اخطار دریافت کرده اند خالی میباشد !");
}

if($cmd=='warnlist' or $cmd=='لیست اخطار') {
	if($a=$warn->warnlist) {
		$list='';
		$i=0;
		foreach($a as $id=>$w)
			$list.=++$i."- [ <a href='tg://user?id=$id'>$id</a> - ($w) ]\n";
		reply("» لیست کاربرانی که اخطار دریافت کرده اند :\n\n1 - [ warnmax - ({$warn->warn}) ]\n$list",null,'html');
	}else
		reply("• لیست کاربرانی که اخطار دریافت کرده اند خالی میباشد !");
}

if((($cmd=='setvip' or $cmd=='تنظیم ویژه') and $id=$rp_from_id) or (preg_match('~^(?:setvip|تنظیم ویژه) (.+)$~',$cmd,$d) and $id=$d[1])) {
	if($id=is_member($id)) {
		if($vip[array_search($id,$vip)])
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در لیست کاربران ویژه وجود دارد!_");
		else {
			$vip[]=$id;
			$ne->update('groups',['vip'=>js($vip)]);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› به لیست کاربران ویژه اضافه شد._");
		}
	}else
		reply("• شناسه نادرست است !");
}

if((preg_match('~^(?:remvip|حذف ویژه) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='remvip' or $cmd=='حذف ویژه')) and $id!=$botid) {
	if($id=is_member($id)) {
		if($vip[array_search($id,$vip)]) {
			unset($vip[array_search($id,$vip)]);
			$ne->update('groups',['vip'=>js($vip)]);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از لیست کاربران ویژه حذف شد._");
		} else
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در لیست کاربران ویژه وجود ندارد!_");
	}else
		reply("• شناسه نادرست است !");
}

if($cmd=='viplist' or $cmd=='لیست ویژه') {
	if($a=$vip) {
		$list='';
		$i=0;
		foreach($a as $id)
			$list.=++$i."- [ <a href='tg://user?id=$id'>$id</a> ]\n";
		reply("» لیست کاربران ویژه :\n\n$list",null,'html');
	}else
		reply("• لیست کاربران ویژه خالی میباشد !");
}
if($cmd=='clean viplist' or $cmd=='پاکسازی لیست ویژه') {
	if($vip) {
		$len=count($vip);
		$ne->update('groups',['vip'=>'[]']);
		reply("• لیست کاربران ویژه پاکسازی شد !\n\n» تعداد کاربران : [ <code>$len</code> ]\n\n• Ch : @$channel",null,'html');
	}else
		reply("• لیست کاربران ویژه خالی میباشد !");
}






if((($cmd=='ban' or $cmd=='بن') and $id=$rp_from_id) or (preg_match('~^(?:ban|بن) (.+)$~',$cmd,$d) and $id=$d[1]) and $id!=$botid) {
	if($id=is_member($id)) {
		if(!is_promote($id) and !is_creator($id)) {
			if(!$ban->$id) {
				$ban->$id=1;
				if($step->msgs->banned)$step->msgs->banned+=1;else $step->msgs->banned=1;
				$ne->update('groups',['ban'=>js($ban),'step'=>js($step,256)]);
				kick($id);
				reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از گروه مسدود شد!_");
			}else
				reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از گروه مسدود شده است!_");
		}else
			reply("• شما دسترسی لازم برای مسدود کردن ( مدیران | سازندگان ) ربات را ندارید !");
	}else
		reply("• شناسه نادرست است !");
}

if((preg_match('~^(?:unban|حذف بن) (.+)$~',$cmd,$d) and $id=$d[1]) or ($id=$rp_from_id and ($cmd=='unban' or $cmd=='حذف بن')) and $id!=$botid) {
	if($id=is_member($id)) {
		if($ban->$id) {
			unset($ban->$id);
			$ne->update('groups',['ban'=>js($ban)]);
			unban($id);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از لیست مسدودین گروه حذف شد._");
		} else
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از گروه مسدود نشده است!_");
	}else
		reply("• شناسه نادرست است !");
}

if(preg_match('~^free-(.+)$~',$data,$d)) {
	unset($step->ver->$d[1]);
	$ne->update('groups',['step'=>js($step,256)]);
	alert('شخص معاف گردید.');
	del();
	
}

if((preg_match('~^معاف (.+)~',$cmd,$d) and $id=$d[1]) or ($cmd=='معاف' and $id=$rp_from_id)) {
	if($id=is_member($id)) {
		if($step->adde->list->$id->ok!='ok') {
			$step->adde->list->$id->ok='ok';
			$ne->update('groups',['step'=>js($step,256)]);
			reply('معاف شد.');
		}else
			reply('ایشون معاف شده بودن.');
	}else
		reply('شناسه اشتباه است.');
}

if($cmd=='banlist' or $cmd=='لیست بن') {
	if($a=$ban) {
		$list='';
		$i=0;
		foreach($a as $id=>$x)
			$list.=++$i."- [ <a href='tg://user?id=$id'>$id</a> ]\n";
		reply("» لیست کاربران مسدود شده :\n\n$list",null,'html');
	}else
		reply("• لیست کاربران مسدود شده خالی میباشد !");
}
if($cmd=='clean banlist' or $cmd=='پاکسازی لیست بن') {
	if($ban) {
		$len=count($ban);
		foreach($ban as $id=>$x)
			unban($id);
		$ne->update('groups',['ban'=>'[]']);
		reply("• لیست کاربران مسدود شده پاکسازی شد !\n\n» تعداد کاربران : [ `$len` ]\n\n• Ch : @$channel");
	}else
		reply("• لیست کاربران مسدود شده خالی میباشد !");
}

if(preg_match('~^(?:filter|فیلتر) (.+)~s',$cmd,$d) and $d=$d[1]) {
	if(!in_array($d,$filter)) {
		$filter[]=$d;
		$ne->update('groups',['filter'=>js($filter,256)]);
	}
	reply("• عبارت مورد نظر شما با موفقیت فیلتر گردید !\n\n» عبارت : [ $d ]\n\n• Ch : @$channel");
}

if(preg_match('~^(?:remfilter|حذف فیلتر) (.+)~',$cmd,$d) and $d=$d[1]) {
	unset($filter[array_search($d,$filter)]);
	$ne->update('groups',['filter'=>js($filter,256)]);
	reply("• عبارت مورد نظر شما با موفقیت رفع فیلتر گردید !\n\n» عبارت : [ $d ]\n\n• Ch : @$channel");
}

if($cmd=='filterlist' or $cmd=='لیست فیلتر') {
	if($filter) {
		$s='';
		$i=0;
		foreach($filter as $value)
			$s.=++$i." - [ <i>$value</i> ]\n";
		reply("• لیست عبارات فیلتر شده :\n\n$s",null,'html');
	}else
		reply("• لیست عبارات فیلتر شده گروه خالی میباشد !\n\n» شما میتوانید با ارسال دستور\n`فیلتر`\nعبارت مورد نظر خود را فیلتر کنید .\n\n• Ch : @$channel");
}

if($cmd=='clean filterlist' or $cmd=='پاکسازی لیست فیلتر') {
	if($filter) {
		$len=count($filter);
		$ne->update('groups',['filter'=>'[]']);
		reply("• عبارات فیلتر شده در گروه با موفقیت پاکسازی شدند !\n\n» تعداد عبارات فیلتر شده : [ <code>$len</code> ]\n\n• Ch : @$channel",null,'html');
	}else
		reply("• لیست عبارات فیلتر شده گروه خالی میباشد !\n\n» شما میتوانید با دستور\n`فیلترکردن` _text_\nعبارت مورد نظر خود را فیلتر کنید.\n\n• Ch : @$channel");
}

if(preg_match('~^(?:mute|سکوت) (\d+)$~',$cmd,$d) and $d=$d[1] and $id=$rp_from_id and $id!=$botid) {
	if(is_member($id)) {
		if(!is_admin($id) and !is_promote($id)) {
			silent($id,false,time()+$d*60);
			if($step->msgs->silented)$step->msgs->silented+=1;else $step->msgs->silented=1;
			$ne->update('groups',['step'=>js($step,256)]);
			reply("• کاربر [ <a href='tg://user?id=$id'>$id</a> ] \n\n» برای [ $d ] دقیقه در حالت سکوت قرار گرفت !",null,'html');
		}else
			reply("• شما دسترسی لازم برای ساکت کردن [ مدیران | سازندگان ] ربات را ندارید !");
	}else
		reply("• شناسه نادرست است !");
}

if((($cmd=='silent' or $cmd=='سکوت') and $id=$rp_from_id) or (preg_match('~^(?:silent|سکوت) (.+)~',$cmd,$d) and $id=$d[1] and !$rp_from_id)) {
	if($id=is_member($id)) {
		if(!is_admin($id) and !is_promote($id)) {
			if(!$silent->$id) {
				$silent->$id=1;
				if($step->msgs->silented)$step->msgs->silented+=1;else $step->msgs->silented=1;
				$ne->update('groups',['silent'=>js($silent),'step'=>js($step,256)]);
				reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در حالت سکوت قرار گرفت._");
			}else
				reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در حالت سکوت قرار دارد!_");
		}else
			reply("• شما دسترسی لازم برای ساکت کردن [ مدیران | سازندگان ] ربات را ندارید !");
	}else
		reply("• شناسه نادرست است !");
}

if(($cmd=='افزودن ادمین' and $id=$rp_from_id) or (preg_match('~^افزودن ادمین (.+)~',$cmd,$d) and $id=$d[1] and !$rp_from_id)) {
	if($id=is_member($id)) {
		Neman('promoteChatMember',[
			'chat_id'=>$chat,
			'user_id'=>$id,
			'can_change_info'=>true,
			'can_delete_messages'=>true,
			'can_invite_users'=>true,
			'can_restrict_members'=>true,
			'can_pin_messages'=>true,
			'can_promote_members'=>false
		]);
		reply("_› کاربر (_ [$id](tg://user?id=$id) _)

›› با موفقیت به ادمین گروه ترفیع یافت._");
	}else
		reply("• شناسه نادرست است !");
}

if(($cmd=='حذف ادمین' and $id=$rp_from_id) or (preg_match('~^حذف ادمین (.+)~',$cmd,$d) and $id=$d[1] and !$rp_from_id)) {
	if($id=is_member($id)) {
		Neman('promoteChatMember',[
			'chat_id'=>$chat,
			'user_id'=>$id,
			'can_change_info'=>false,
			'can_delete_messages'=>false,
			'can_invite_users'=>false,
			'can_restrict_members'=>falss,
			'can_pin_messages'=>false,
			'can_promote_members'=>false
		]);
		reply("_› کاربر (_ [$id](tg://user?id=$id) _)

›› با موفقیت از ادمین گروه عزل شد._");
	}else
		reply("• شناسه نادرست است !");
}

if($cmd=='لیست ادمین ها') {
	$x='';
	$i=0;
	foreach(admins() as $admin) {
		if($admin->status=='administrator') {
			$u=$admin->user;
			$user=$u->username?"{$u->username} - <code>{$u->id}</code>":"<a href='tg://user?id={$u->id}'>{$u->id}</a>";
			$x=++$i." - [ $x ]";
		}
	}
	reply("›› لیست ادمین های گروه :

$x",null,'html');
}


if(preg_match('~^تنظیم لقب (.+)~s',$cmd,$d) and $d=$d[1] and $id=$rp_from_id) {
	if($id!=$botid) {
		$step->nickname->$id=$d;
		$ne->update('groups',['step'=>js($step,256)]);
		$us=$rp_from_username?'@'.$rp_from_username.' - <code>'.$id.'</code>':"<code>$id</code>";
		$d=htmlentities($d);
		reply("• مقام کاربر [ $us ] 

» به [ $d ] تنظیم شد !",null,'html');
	}else
		reply("به توپم دست نزن :(");
}

if($cmd=='حذف لقب' and $id=$rp_from_id) {
	if($id!=$botid) {
		unset($step->nickname->$id);
		$ne->update('groups',['step'=>js($step,256)]);
		$us=$rp_from_username?'@'.$rp_from_username.' - <code>'.$id.'</code>':"<code>$id</code>";
		$d=htmlentities($d);
		reply("• مقام کاربر [ $us ] 

» حذف شد !",null,'html');
	}else
		reply("به توپم دست نزن :(");
}

if(preg_match('~^تنظیم کانال (@.+)$~',$cmd,$d) and $d=$d[1]) {
	$step->adj->ch=$d;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("کانال تنظیم شد!");
}

if($cmd=='اجبار عضویت فعال') {
	if($step->adde->ok!='on') {
		$step->adde->ok='on';
		$ne->update('groups',['step'=>js($step,256)]);
		reply("اجبار عضویت فعال شد");
	}else
		reply("اجبار عضویت در حال حاضر فعال است");
}

if($cmd=='اجبار عضویت غیرفعال') {
	if($step->adde->ok!='off') {
		$step->adde->ok='off';
		$ne->update('groups',['step'=>js($step,256)]);
		reply("اجبار عضویت غیرفعال شد");
	}else
		reply("اجبار عضویت در حال حاضر غیرفعال است");
}

if($cmd=='وضعیت اجبار عضویت جدید') {
	$step->adde->type='new';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("عضویت اجبار برای اعضای جدید فعال شد!");
}

if($cmd=='وضعیت اجبار عضویت همه') {
	$step->adde->type='all';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("عضویت اجبار برای همه اعضا فعال شد!");
}

if($cmd=='اجبار حضور فعال') {
	if($step->adj->ok!='on') {
		$step->adj->ok='on';
		$ne->update('groups',['step'=>js($step,256)]);
		reply("اجبار حضور فعال شد");
	}else
		reply("اجبار حضور در حال حاضر فعال است");
}

if(preg_match('~^تنظیم زمان اجبار عضویت (\d+)$~',$cmd,$d) and $d=$d[1]) {
	$step->adde->d=$d;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("زمان اجبار عضویت به $d ثانیه تغییر یافت!");
}

if($cmd=='اجبار حضور غیرفعال') {
	if($step->adj->ok!='off') {
		$step->adj->ok='off';
		$ne->update('groups',['step'=>js($step,256)]);
		reply("اجبار حضور غیرفعال شد");
	}else
		reply("اجبار حضور در حال حاضر غیرفعال است");
}


if(preg_match('~^تنظیم اجبار عضویت (\d+)$~',$cmd,$d) and $d=$d[1]) {
	$step->adde->t=$d;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("تعداد اجبار عضویت به $d نفر تغییر یافت!");
}

if($cmd=='پاکسازی سابقه اجبار عضویت') {
	unset($step->adde->list);
	$ne->update('groups',['step'=>js($step,256)]);
	reply('سابقه اجبار عضویت همه اعضای گروه پاک شد!');
}


if($cmd=='پاکسازی لیست لقب') {
	if($step->nickname) {
		unset($step->nickname);
		reply("لیست لقب گروه خالی شد !");
	}else
		reply("لیست لقب گروه خالی میباشد");
}



if((($cmd=='unsilent' or $cmd=='حذف سکوت') and $id=$rp_from_id) or (preg_match('~^(?:unsilent|حذف سکوت) (.+)~',$cmd,$d) and $id=$d[1])) {
	if($id=is_member($id)) {
		if($silent->$id) {
			unset($silent->$id);
			$ne->update('groups',['silent'=>js($silent)]);
			silent($id,true);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› از حالت سکوت خارج شد._");
		} else
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› در حالت سکوت قرار ندارد!_");
	}else
		reply("• شناسه نادرست است !");
}

if($cmd=='silentlist' or $cmd=='لیست سکوت') {
	if($a=$silent) {
		$list='';
		$i=0;
		foreach($a as $id=>$x)
			$list.=++$i."- [ <a href='tg://user?id=$id'>$id</a> ]\n";
		reply("» لیست کاربران در حالت سکوت :\n\n$list",null,'html');
	}else
		reply("• لیست کاربران در حالت سکوت خالی میباشد !");
}
if($cmd=='clean silentlist' or $cmd=='پاکسازی لیست سکوت') {
	if($silent) {
		$len=count($ban);
		foreach($silent as $id=>$x)
			silent($id,true);
		$ne->update('groups',['silent'=>'[]']);
		reply("• کاربرانی که در حالت سکوت بودند آزاد شدند !\n\n» تعداد کاربران : [ `$len` ]\n\n• Ch : @$channel");
	}else
		reply("• لیست کاربران در حالت سکوت خالی میباشد !");
}
if($text=='ping')
	reply("• ربات رایگان دیجی آنلاین میباشد !");
if(preg_match('~^whois (\d+)~',$cmd,$d) and $id=$d[1])if(is_member($id))reply("[Click!](tg://user?id=$id)");else reply("• کاربر  $id  یافت نشد !");

if($cmd=='id')
	if($ph=jd(js(getprofiles()->photos[0]),1) and $ph=end($ph)['file_id'])
		reply_photo($ph,"» شناسه شما : [ $from ]\n» شناسه گروه : [ $chat ]\n• Ch : @$channel");
	else
		reply("» شناسه شما : [ $from ]\n» شناسه گروه : [ $chat ]\n• Ch : @$channel");

if($cmd=='info' and $id=$rp_from_id) {
	$w=$warn->warnlist->$id?:0;
	$a=$step->users->$id->added?:0;
	$p=getprofiles($id)->total_count?:0;
	
	$s='فرد عادی';
	$s=is_promote($id)?'مدیر گروه':$s;
	$s=is_admin($id)?'ادمین گروه':$s;
	$s=is_creator($id)?'مالک گروه':$s;
	$s=$botid==$id?'سازنده ربات':$s;
	
	$m=$step->users->$id->nickname?:'-----';
	
	reply("• مشخصات دریافتی از کاربر :\n\n» آیدی کاربری شخص : [ $id ]\n» آیدی پیام ریپلی شده : [ $message_id ]\n\n» تعداد اخطارهای دریافتی کاربر : [ $w ]\n» کاربران اضافه شده توسط کاربر : [ $a ]\n\n» سطح دسترسی کاربر : [ $s ]\n» مقام ثبت شده در ربات : [ $m ]\n\n» تعداد پروفایل های موجود کاربر : [ $p ]\n\n• Ch : @$channel");
}


if(($cmd=='pin' or $cmd=='سنجاق') and $mid=$rp_message_id) {
	Neman('pinchatmessage',[
		'chat_id'=>$chat,
		'message_id'=>$mid
	]);
	reply("• پیام مورد نظر شما با موفقیت سنجاق گردید !");
}

if($cmd=='unpin' or $cmd=='حذف سنجاق') {
	Neman('unpinchatmessage',[
		'chat_id'=>$chat
	]);
	reply("• پیام سنجاق شده با موفقیت از سنجاق خارج گردید !");
}

if($cmd=='welcome on' or $cmd=='خوشامد روشن') {
	if(!$step->welcome->now) {
		reply("• ارسال پیام خوشامدگویی فعال شد !");
		$step->welcome->now='on';
		$ne->update('groups',['step'=>js($step,256)]);
	}else
		reply("• خوشامدگویی از قبل فعال است!");
}
if($cmd=='welcome off' or $cmd=='خوشامد خاموش') {
	if($step->welcome->now) {
		unset($step->welcome->now);
		$ne->update('groups',['step'=>js($step,256)]);
			reply("• ارسال پیام خوشامدگویی غیرفعال شد !");
	}else
		reply("• خوشامدگویی از قبل غیرفعال است!");
}

if(preg_match('!^[/\!\?#@]?(?:setwelcome|تنظیم خوشامد) (.+)!s',$text,$t) and $t=$t[1]) {
	$step->welcome->pm=$t;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• پیام خوشامد گویی با موفقیت ثبت شد .\n\n» پیام خوشامد گویی :\n» { $t }");
}

if($cmd=='فال')
	Neman('senddocument',[
		'chat_id'=>$chat,
		'document'=>'http://www.beytoote.com/images/Hafez/'.rand(1,149).'.gif',
		'caption'=>"• Ch : @$channel",
		'reply_to_message_id'=>$msgid
	]);

if($cmd=='remwelcome' or $cmd=='حذف خوشامد') {
	unset($step->welcome->pm);
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• پیام خوشامدگویی با موفقیت حذف و به حالت اولیه بازگشت !");
}

if(preg_match('~^(?:setrules|تنظیم قوانین) (.+)~',$cmd,$t) and $t=$t[1]) {
	$step->rules=$t;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• قوانین ثبت شده برای گروه عبارتند از :\n\n» { $t }\n• Ch : @$channel");
}
if($cmd=='remrules' or $cmd=='حذف قوانین') {
	unset($step->rules);
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• قوانین ثبت شده با موفقیت حذف شدند !");
}
if($cmd=='rules' or $cmd=='دریافت قوانین')
	if($r=$step->rules)
		reply("• قوانین ثبت شده برای گروه عبارتند از :\n\n» { $r }\n\n• Ch : @$channel");
	else
		reply("• در حال حاضر قانونی برای گروه ثبت نشده است !\n\n» برای ثبت قوانین از دستور \n`Setrules` _text_\nاستفاده کنید .\n\n• Ch : @$channel");

if(preg_match('~^[/!#\?@]?(?:setlink|تنطیم لینک) ((?:https?://)?t(?:elegram)?\.me/joinchat/\S+)$~i',$text,$t) and $t=$t[1]) {
	$step->link=$t;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• لینک ارائه شده با موفقیت ثبت شد !\n\n» لینک ارائه شده :\n» { $t }");
}

if(preg_match('~^تنظیم زمان خوشامد (\d+)$~',$cmd,$d)) {
	$step->welcome->del=$d[1];
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• زمان حذف شدن پیام خوشامد به {$d[1]} ثانیه تنظیم شد !");
}

if(preg_match('~^تنظیم رگبار (سکوت|بن)$~',$cmd,$d) and $d=$d[1]) {
	$flood['type']=str_replace(['سکوت','بن'],['silent','ban'],$d);
	$ne->update('groups',['flood'=>js($flood)]);
	reply("_» حالت رگبار بر روی $d قرار گرفت !_");
}

if($cmd=='remlink' or $cmd=='حذف لینک') {
	unset($step->link);
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• لینک ثبت شده با موفقیت حذف شد !");
}

if($cmd=='link' or $cmd=='دریافت لینک')
	if($link=$step->link)
		reply("• لینک گروه: \n\n $link");
	else
		reply("• در حال حاضر لینکی برای گروه ثبت نشده است !\n\n» برای ثبت لینک از دستور \n`تنظیم لینک` _link_\nاستفاده کنید .\n\n• Ch : @$channel");


if((($cmd=='kick' or $cmd=='اخراج') and $id=$rp_from_id) or (preg_match('~^(:?kick|اخراج) (.+)$~',$cmd,$d) and $id=$d[1]) and $id!=$botid) {
	if($id=is_member($id)) {
		if(!is_promote($id) and !is_creator($id)) {
			kick($id);
			if($step->msgs->banned)$step->msgs->banned+=1;else $step->msgs->banned=1;
			$ne->update('groups',['step'=>js($step,256)]);
			reply("_› کاربر (_ [$id](tg://user?id=$id) _)\n\n›› با موفقیت از گروه اخراج شد._");
		}else
			reply("• شما دسترسی لازم برای مسدود کردن ( مدیران | سازندگان ) ربات را ندارید !");
	}else
		reply("• شناسه نادرست است !");
}

if($cmd=='muteall' or $cmd=='قفل گروه') {
	if(!$step->mute) {
		$step->mute='on';
		$ne->update('groups',['step'=>js($step,256)]);
		reply("• قفل گروه با موفقیت فعال شد !");
	}else
		reply("• قفل گروه درحال حاضر فعال است !");
}
if($cmd=='unmuteall' or $cmd=='باز کردن گروه') {
	if($step->mute) {
		unset($step->mute);
		$ne->update('groups',['step'=>js($step,256)]);
		reply("• قفل گروه با موفقیت غیرفعال شد !");
	}else
		reply("• قفل گروه درحال حاضر غیرفعال است !");
}

if(preg_match('~^getpro (\d+)~',$cmd,$d) and $d=$d[1]) {
	$g=getprofiles();
	if(($t=$g->total_count)>=$d) {
		$ph=$g->photos[$d-1];
		$ph=end($ph);
		$s=$ph->file_size;
		reply_photo($ph->file_id,"» تعداد پروفایل : [ $t/$d ]
» سایز عکس : [ $s پیکسل ]
• Ch : @$channel");
	}else
		reply("• کاربر گرامی درخواست شما امکان پذیر نیست !

» عکس های موجود شما کمتر از [ <code>$d</code> ] عکس است. (مطمئن شوید ربات را استارت کرده اید!)

• Ch : @$channel",null,'html');
}

if($cmd=='me') {
	$w=$warn->warnlist->$from?:0;
	$c=$step->users->$from->added?:0;
	$t=getprofiles()->total_count?:0;
	
	$s='فرد عادی';
	$s=is_promote()?'مدیر گروه':$s;
	$s=is_admin()?'ادمین گروه':$s;
	$s=is_creator()?'مالک گروه':$s;
	
	$n=$step->users->$from->nickname?:'-----';
	
	$m=$ne->query("select * from groups where step like '%$from%'")->num_rows-1;
	$a=$ne->query("select * from groups where installer='$from'")->num_rows;
	
	reply("• بخشی از اطلاعات کاربری شما :

» نام کاربری شما : [ <a href='tg://user?id=$from'>".htmlentities('> Click <')."</a> ]
» آیدی کاربری شما : [ $from ]

» یوزرنیم کاربری شما : [ ".($from_username?'@'.$from_username:'------')." ]
» شماره موبایل شما : [ ------ ]

» تعداد پیام های گروه : [ $message_id ]

» رابط کاربری شما : [ کامپیوتر ]
» نوع پیام ارسالی شما : [ متن ]

» تعداد پروفایل های شما : [ $t ]

» مقام کاربری شما : [ $n ]
» سطح دسترسی شما : [ $s ]

» آخرین بازدید شما : [ آخرین بازدید اخیرا ]
» مسدود شده توسط ربات : [ خیر ]

» تعداد گروه های مشترک : [ $m ]
» تعداد گروهای نصب شده توسط شما : [ $a ]

» تعداد اخطار های دریافتی شما : [ $w ]
» تعداد افراد اضافه شده توسط شما : [ $c ]

» تماس با شما از طریق تلگرام : [ مجاز ]
» نوع تماس با شما از طریق تلگرام : [ عمومی ]


• Ch : @$channel",null,'html');
}

if($text=='آمار') {
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

if(preg_match('~^(?:del|حذف|پاک) (\d+)$~',$cmd,$d) and $d=$d[1] and $d<=100 and $d>=1) {
	$n=0;
	$time=time();
	for($i=$message_id;$i>$message_id-$d;$i--) {
		if(del($i)->ok==true)$n++;
		if(time()-10>$time)break;
	}
	sm($chat,"تعداد $n پیام پاک شد");
}

if(preg_match('~^(?:lock|قفل) (.+)~',$cmd,$d) and $d=$d[1]) {
	if((in_array($d,array_keys($locks)) and $j=$locks[$d]) or (in_array($d,$locks) and $j=$d and $d=array_search($d,$locks))) {
		if($lock->$d!='on') {
			$lock->$d='on';
			$ne->update('groups',['locked'=>js($lock)]);
			reply("_» قفل $j با موفقیت فعال شد ._");
		}else
			reply("_» قفل $j در حال حاضر فعال است !_");
	}
}

if(preg_match('~^(?:unlock|بازکردن) (.+)~',$cmd,$d) and $d=$d[1]) {
	if((in_array($d,array_keys($locks)) and $j=$locks[$d]) or (in_array($d,$locks) and $j=$d and $d=array_search($d,$locks))) {
		if($lock->$d=='on') {
			$lock->$d='off';
			$ne->update('groups',['locked'=>js($lock)]);
			reply("_» قفل $j با موفقیت غیرفعال شد ._");
		}else
			reply("_» قفل $j در حال حاضر غیرفعال است !_");
	}
}

if(preg_match('~^(?:setfloodmax|تعداد رگبار) (\d+)$~',$cmd,$d) and $d=$d[1]) {
	if($d>2) {
		if($d<=10) {
			$flood['max']=$d;
			$ne->update('groups',['flood'=>js($flood)]);
			reply("• مقدار ارسال پیام های مکرر با موفقیت تنظیم شد .

» مقدار تنظیم شده : [ $d ]");
		}else
			reply("• حداکثر مقدار ارسال پیام مکرر باید کوچکتر از 10 باشد !");
	}else
		reply("• حداقل مقدار ارسال پیام مکرر باید بزرگ تر از 2 باشد !");
}

if(preg_match('~^(?:setfloodtime|زمان رگبار) (\d+)$~',$cmd,$d) and $d=$d[1]) {
	if($d>2) {
		if($d<=10) {
			$flood['time']=$d;
			$ne->update('groups',['flood'=>js($flood)]);
			reply("• زمان ارسال پیام های مکرر با موفقیت تنظیم شد .

» زمان تنظیم شده : [ $d ]");
		}else
			reply("• حداکثر زمان ارسال پیام مکرر باید کوچکتر از 10 باشد !");
	}else
		reply("• حداقل زمان ارسال پیام مکرر باید بزرگ تر از 2 باشد !");
}



if($cmd=='راهنما')
	reply("• راهنمای مدیریتی ربات دیجی آنتی :

» دستورات ارتقا مقام کاربران و ادمین های گروه :
• <code>پیکربندی</code>
• <code>تنظیم مدیر</code> (×)
• <code>حذف مدیر</code> (×)
• <code>لیست مدیران</code>
• <code>پاکسازی لیست مدیران</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» دستورات اخطار و تنظیم اخطار :
• <code>اخطار</code> (×)
• <code>حذف اخطار</code> (×)
• <code>تعداد اخطار</code> [ 1-10 ]
• <code>لیست اخطار</code>
• <code>پاکسازی لیست اخطار</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیم کاربران به عنوان کاربر ویژه :
• <code>تنظیم ویژه</code> (×)
• <code>حذف ویژه</code> (×)
• <code>لیست ویژه</code>
• <code>پاکسازی لیست ویژه</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» افزودن ادمین به گروه ( مناسب مدیران ریپورت ) :
توجه : ربات دیجی باید فول ادمین باشد و تمام تیکها فعال باشند
• <code>افزودن ادمین</code> (×)
• <code>حذف ادمین</code> (×)
• <code>لیست ادمین ها</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» سکوت و سکوت زمان دار کردن کاربر :
• <code>سکوت</code> (×)
• <code>حذف سکوت</code> (×)
• <code>لیست سکوت</code>
• <code>پاکسازی لیست سکوت</code>

• <code>سکوت</code> [دقیقه] (×)
برای مثال ( <code>سکوت 26</code> ) با این دستور کاربر 26 دقیقه سکوت میشود.
~ ~ ~ ~ ~ ~ ~ ~ ~
» مسدود کردن کاربر از گروه :
• <code>بن</code> (×)
• <code>حذف بن</code> (×)
• <code>لیست بن</code>
• <code>پاکسازی لیست بن</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» فیلتر کردن کلمه مورد نظر :
• <code>فیلتر کردن</code> [word]
• <code>حذف فیلتر</code> [word]
• <code>لیست فیلتر</code>
• <code>پاکسازی لیست فیلتر</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» فعال کردن پیام خوشامد گویی :
• <code>خوشامد روشن</code>
• <code>خوشامد خاموش</code>
• <code>تنظیم خوشامد</code> [متن دلخواه]
• <code>حذف خوشامد</code>
» شما میتوانید از گزینه های زیر نیز در پیام خوشامد گویی استفاده کنید :
• <code>groupname</code> : بکار بردن نام گروه
• <code>firstname</code> : بکار بردن نام کوچک
• <code>lastname</code> : بکار بردن نام بزرگ
• <code>tag</code> : بکار بردن یوزرنیم
• <code>grouprules</code> : بکار بردن قوانین
• <code>grouplink</code> : بکار بردن لینک
• <code>userid</code> : بکار بردن شناسه
• <code>time</code> : بکار بردن زمان
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل کردن و بازکردن پیام رگباری (فلود) :
• <code>قفل رگبار</code> 
• <code>بازکردن رگبار</code>
• <code>تعداد رگبار</code> [3-10]
~ ~ ~ ~ ~ ~ ~ ~ ~
» دستورات تنظیم و فعال کردن قفل خودکار :
• <code>تنظیم قفل خودکار</code>
• <code>حذف قفل خودکار </code>
• <code>وضعیت قفل خودکار</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل و باز کردن گروه :
• <code>قفل گروه</code>
• <code>باز کردن گروه</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» سنجاق و حذف پیام سنجاق کردن پیام :
• <code>سنجاق</code>
• <code>حذف سنجاق</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» اخراج کاربر از گروه :
• <code>اخراج</code> (×)
~ ~ ~ ~ ~ ~ ~ ~ ~
» دستورات تنظیم لینک گروه :
• <code>تنظیم لینک</code> [link]
• <code>حذف لینک</code>
• <code>دریافت لینک</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» دستورات تنظیم قوانین گروه :
• <code>تنظیم قوانین</code> [rules]
• <code>حذف قوانین</code>
• <code>دریافت قوانین</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» پاک کردم پیام ها :
• <code>حذف</code> [ 1-100 ]
~ ~ ~ ~ ~ ~ ~ ~ ~
» تنظیمات گروه :
• <code>تنظیمات</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» پنل شیشه ای قفلها :
• <code>پنل</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» قفل سختگیرانه :
با فعال سازی این قفل اگر کاربران، فروارد و لینک بفرستند برای همیشه سکوت خواهند شد
• <code>قفل سختگیرانه</code>
• <code>بازکردن سختگیرانه</code>
~ ~ ~ ~ ~ ~ ~ ~ ~
» تمامی قفل های اصلی ربات :
• <code>لینک . فروارد . تگ . هشتگ  . سرویس تلگرام . فارسی . انگلیسی . اد ربات . فحش . ربات . فیلم سلفی . عضوجدید . عکس . فیلم . ویس . گیف . آهنگ . فایل . متن . مخاطب . استیکر . بازی </code> 

شما میتوانید تمام موارد بالا را طبق مثال زیر قفل و باز کنید:
• <code>قفل لینک</code>
• <code>بازکردن لینک</code>
~ ~ ~ ~ ~ ~ ~ ~ ~

⌑منظور از \"×\" ریپلای ، شناسه . آیدی و آیدی عددی است؛ یک مورد الزامی است.


• Ch : @$channel",null,'html');


if($cmd=='setautolock' or $cmd=='تنظیم قفل خودکار') {
	$step->steps->$from='setautolockStart';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• لطفا زمان مورد نظر برای قفل شدن گروه را وارد کنید !

» برای مثال : 17:30

• Ch : @$channel");
}

if($cmd=='آمار روشن') {
	$step->status->now='on';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("ارسال آمار بصورت خودکار روشن شد!");
}

if($cmd=='آمار خاموش') {
	$step->status->now='off';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("ارسال آمار بصورت خودکار خاموش شد!");
}

if(preg_match('~^تنظیم آمار ((\d\d):(\d\d))$~',$cmd,$d) and $d1=$d[2] and $d2=$d[3] and $d1<=24 and $d3=$d[1] and $d[2]<=60 and $d1>=0 and $d2>=0 and jmktime($d1,$d2)) {
	reply("زمان ارسال امار برای $d3 تنظیم شد!");
	$step->status->date=$d3;
	unset($step->status->today);
	$ne->update('groups',['step'=>js($step,256)]);
}

if($step->steps->$from=='setautolockStart' and preg_match('~^(\d\d):(\d\d)$~',$text,$d) and $d[1]<25 and $d[2]<61) {
	$step->autolockStart=$text;
	$step->steps->$from='setautolockend';
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• زمان اولیه برای قفل خودکار گروه ثبت شد !

» لطفا دومین زمان برای باز شدن خودکار گروه را وارد کنید .

• Ch : @$channel");
}
else if($step->steps->$from=='setautolockend' and preg_match('~^(\d\d):(\d\d)$~',$text,$d) and $d[1]<25 and $d[2]<61) {
	$step->autolockEnd=$text;
	$step->steps->$from='';
	$ne->update('groups',['step'=>js($step,256)]);
	$start=$step->autolockStart;
	reply("• ثبت زمان قفل خودکار با موفقیت انجام شد !

» گروه در ساعت [ <code>$start</code> ] قفل و در ساعت [ <code>$text</code> ] باز خواهد شد !

• Ch : @$channel",null,'html');
}


if(preg_match('~^بگوو (.+)~s',$cmd,$d) and $d=$d[1])
	reply($d,null,null);

if($cmd=='عکس به استیکر' and $ph=jd(js($reply_to_message_photo),1) and $ph=end($ph)['file_id']) {
	copy('https://api.telegram.org/file/bot'.API_KEY.'/'.Neman('getfile',['file_id'=>$ph])->result->file_path,'ne/sticker-'.$chat.'.png');
	Neman('sendsticker',[
		'chat_id'=>$chat,
		'sticker'=>new curlfile('ne/sticker-'.$chat.'.png'),
		'reply_to_message_id'=>$msgid
	]);
	unlink('ne/sticker-'.$chat.'.png');
}

if($cmd=='استیکر به عکس' and $ph=$reply_to_message_sticker_file_id) {
	copy('https://api.telegram.org/file/bot'.API_KEY.'/'.Neman('getfile',['file_id'=>$ph])->result->file_path,'ne/photo-'.$chat.'.png');
	Neman('sendphoto',[
		'chat_id'=>$chat,
		'photo'=>new curlfile('ne/photo-'.$chat.'.png'),
		'reply_to_message_id'=>$msgid
	]);
	unlink('ne/photo-'.$chat.'.png');
}

if(preg_match('~^معنی (.+)~s',$cmd,$d) and $d=$d[1]) {
	preg_match('~<p class="">(.+?)</p>~si',file_get_contents('https://www.vajehyab.com/?q='.urlencode($d)),$p);
	$p=trim(strip_tags(preg_replace(['~<[a-z0-9]+?>.+?</[a-z0-9]+?>|&.+?;~','~<br.+?>~s'],['',"\n"],$p[1])));
	if($p)
		reply("کلمه اولیه : $d
 معنی: 
$p",null,null);
	else
		reply("کلمه وجود ندارد");
}

if($cmd=='تقویم') {
	$f=html_entity_decode(file_get_contents('https://time.ir'));
	preg_match('~shamsi" class="show date">(.+?)</span>~si',$f,$s);
	$sh=$s[1];
	preg_match('~Hijri" class="show date">(.+?)</~si',$f,$s);
	$gh=$s[1];
	preg_match('~Gregorian" class="show date">(.+?)</s~si',$f,$s);
	$mi=$s[1];
	reply("• زمان : ".tr_num(jdate('H:i:s'))."
• تاریخ خورشیدی : $sh
• تاریخ قمری : $gh
• تاریخ میلادی : $mi

• روز های سپری شده : ".tr_num(jdate('z'))."
 روز ( ".tr_num(jdate('K'))." درصد )
• روز های باقی مانده : ".(365-tr_num(jdate('z')))." روز ( ".tr_num(jdate('k'))." درصد )

[‌](".$monas[tr_num(jdate('y/m'))].")");
}

if($cmd=='remautolock' or $cmd=='حذف قفل خودکار') {
	unset($step->autolockStart,$step->autolockEnd,$step->autolockNow);
	$ne->update('groups',['step'=>js($step,256)]);
	
	reply("• زمان وارد شده شما برای قفل خودکار گروه حذف شد !

• Ch : @$channel");
}

if($cmd=='autolock stats' or $cmd=='وضعیت قفل خودکار') {
	if($s=$step->autolockStart) {
		$x=$step->autolockNow?'فعال':'غیر فعال';
		reply("• قفل خودکار گروه در حال حاضر [ $x ] میباشد !

» ارسال پیام در گروه در ساعت  [ <code>$s</code> ]  ممنوع و در ساعت  [ <code>{$step->autolockEnd}</code> ]  آزاد خواهد شد .

• Ch : @$channel");
	}else
		reply("• در حال حاضر زمانی برای قفل خودکار تایین نشده است !

» برای ثبت زمان از دستور
`Setautolock`
استفاده کنید .

• Ch : @$channel");
}

if($cmd=='settings' or $cmd=='تنظیمات') {
	$s="• تنظیمات گروه مدیریتی عبارتند از :";
	foreach($locks as $k=>$v)
		$s.="\n» قفل $v : ".($lock->$k=='on'?'( فعال|🔐 )':'------');
	$s.="\n\n» مقدار ارسال رگبار : ( 10/{$flood['max']} )
» وضعیت قفل خودکار : ".($step->autolockNow?'فعال':'غیر فعال')."
» ساعات تعطیلی گروه : "
.($step->autolockStart?"{$step->autolockStart} الی {$step->autolockEnd}":'------')."

» حداکثر اخطار : ( 10/{$warn->warn} )
» خوشامدگویی : ".($step->welcome->now=='on'?'( فعال|🔐 )':'------')."
» ارسال آمار : ".($step->status->now=='on'?'( فعال|🔐 )':'------')."
» آیدی عددی گروه : ( $chat )

• Ch : @$channel";
	reply($s);
}

require 'inline.panel.php';
}
