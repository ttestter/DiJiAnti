<?php
error_reporting(0);
set_time_limit(60);
$ne=new mysqli('localhost','user','pass','dbname');//اطلاعات دیتابیس به ترتیب جا گذاری کنید

$token='00000000';//توکن
define('API_KEY',$token);

function Neman($method,$data=[],$token=API_KEY) {
	$ch=curl_init('https://api.telegram.org/bot'.$token.'/'.$method);
	curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>1,CURLOPT_POSTFIELDS=>$data]);
	return json_decode(curl_exec($ch));
}
$i=0;
while($i<=60) {
$q=$ne->query("select id,del from groups where `del` IS NOT NULL");
	while($r=$q->fetch_assoc()) {
		foreach(json_decode($r['del']) as $msgid=>$time)
			if($time<=time()) {
				Neman('deletemessage',[
					'chat_id'=>$r['id'],
					'message_id'=>$msgid
				]);
				$ne->query("update groups set del='' where id='{$r['id']}'");
			}
	}
sleep(1);
$i++;
}
