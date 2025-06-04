<?php
if(in_array($from,$dev)) {
$k_panel=js(['keyboard'=>[
	[['text'=>'امار کاربران'],['text'=>'امار گروها']],
	[['text'=>'فور به گروه'],['text'=>'فور به کاربر']],
	[['text'=>'ارسال به گروه'],['text'=>'ارسال به کاربر']],
	[['text'=>'افزودن سوال'],['text'=>'حذف سوال']],
	[['text'=>'ارسال خودکار'],['text'=>'ارسال تبلیغ ۱']]
]]);
if($text=='پنل')
	reply("بیه اینم پنلت",$k_panel);
if($text=='امار کاربران')
	reply('آمار کاربران : '.$ne->query('select id from members')->num_rows);

if($text=='امار گروها')
	reply('آمار گروها : '.$ne->query('select id from groups')->num_rows);

$stp=file_get_contents("ne/$from.txt");

$k_back=js(['keyboard'=>[
		[['text'=>'برگشت']]
],'resize_keyboard'=>true]);

if($text=='برگشت') {
	unlink("ne/$from.txt");
	unlink("ne/$from-q.txt");
	reply("به پنل بازگشتید.",$k_panel);
}

else if($text=='ارسال به کاربر') {
	reply('پیام خود را ارسال کنید.',$k_back);
	file_put_contents("ne/$from.txt",'sendc');
}

else if($text=='ارسال به گروه') {
	reply('پیام خود را ارسال کنید.',$k_back);
	file_put_contents("ne/$from.txt",'sendgp');
}

else if($text=='فور به گروه') {
	reply('پیام خود را فروارد کنید.',$k_back);
	file_put_contents("ne/$from.txt",'forgp');
}

else if($text=='فور به کاربر') {
	reply('پیام خود را فروارد کنید.',$k_back);
	file_put_contents("ne/$from.txt",'forc');
}

else if($stp=='sendgp') {
	if($photo){$fid=end($photo)->file_id;$w='photo';}
	if(!$fid and $video){$fid=$video->file_id;$w='video';}
	else if(!$fid and $document){$fid=$document->file_id;$w='document';}
	else if(!$fid and $text)$w='message';
	if(!$w) {
		reply("فرمت پشتیبانی نمیشود.");
		return;
	}
	$ne->insert('sendall',['send'=>js(['chat'=>$from,'send'=>$w,'file_id'=>$fid,'caption'=>($caption?:$text),'for'=>'gp'])]);
	reply('در حال ارسال پیام به گروها، شماره ی ارسال : '.$ne->insert_id,$k_panel);
	unlink("ne/$from.txt");
}

else if($stp=='sendc') {
	if($photo){$fid=end($photo)->file_id;$w='photo';}
	if(!$fid and $video){$fid=$video->file_id;$w='video';}
	else if(!$fid and $document){$fid=$document->file_id;$w='document';}
	else if(!$fid and $text)$w='message';
	if(!$w) {
		reply("فرمت پشتیبانی نمیشود.");
		return;
	}
	$ne->insert('sendall',['send'=>js(['chat'=>$from,'send'=>$w,'file_id'=>$fid,'caption'=>($caption?:$text),'for'=>'c'])]);
	reply('در حال ارسال پیام به کاربران، شماره ی ارسال : '.$ne->insert_id,$k_panel);
	unlink("ne/$from.txt");
}

else if($stp=='forc') {
	$ne->insert('sendall',['send'=>js(['send'=>'forward','chat'=>$from,'msgid'=>$msgid,'for'=>'c'])]);
	reply('در حال ارسال پیام به کاربران، شماره ی ارسال : '.$ne->insert_id,$k_panel);
	unlink("ne/$from.txt");
}

else if($stp=='forgp') {
	$ne->insert('sendall',['send'=>js(['send'=>'forward','chat'=>$from,'msgid'=>$msgid,'for'=>'gp'])]);
	reply('در حال ارسال پیام به گروها، شماره ی ارسال : '.$ne->insert_id,$k_panel);
	unlink("ne/$from.txt");
}

else if($text=='افزودن سوال') {
	file_put_contents("ne/$from.txt",'addq');
	reply("بفرست سوالو",$k_back);
}

else if($text=='حذف سوال') {
	file_put_contents("ne/$from.txt",'delq');
	reply("بفرست سوالو",$k_back);
}

else if($stp=='addq') { 
	if(!$questions[$text]) {
		file_put_contents("ne/$from-q.txt",$text);
		file_put_contents("ne/$from.txt",'add2');
		reply("جوابو بفرست");
	}else
		reply("قبلا داشتیش");
}
else if($stp=='add2') {
	$questions[file_get_contents("ne/$from-q.txt")][]=$text;
	file_put_contents("questions.json",js($questions));
	reply("حله، اگه میخوایی ادامه بده :)",$k_back);
}

else if($stp=='delq') { 
	if($questions[$text]) {
		unset($questions[$text]);
		file_put_contents("questions.json",js($questions));
		reply("حذف شد.",$k_panel);
		unlink("ne/$from.txt");
	}else
		reply("نداریش");
}

else if($text=='ارسال خودکار') {
	reply("پیامو فور کن",$k_back);
	file_put_contents("ne/$from.txt",'sauto');
}

else if($stp=='sauto') {
	file_put_contents("ne/sauto.txt",$from.','.$msgid);
	reply('حله',$k_panel);
	unlink("ne/$from.txt");
}
else if($text=='ارسال تبلیغ ۱') {
	reply("پیامو فور کن",$k_back);
	file_put_contents("ne/$from.txt",'st2');
}
else if($stp=='st2') {
	reply('زمانو بفرست',$k_back);
	file_put_contents("ne/$from.txt",'st3');
	file_put_contents("ne/st.txt",$from.','.$msgid);
}
else if($stp=='st3') {
	reply("حله",$k_panel);
	unlink("ne/$from.txt");
	file_put_contents("ne/st.txt",file_get_contents("ne/st.txt").','.tr_num($text));
}

}
