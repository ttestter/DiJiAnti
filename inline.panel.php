<?php
$k_p=js(['inline_keyboard'=>[
	[['text'=>'لیست ها','callback_data'=>'lists'],['text'=>'قفل ها','callback_data'=>'locks']],
	[['text'=>'تنظیمات پیشرفته','callback_data'=>'locks2'],['text'=>'• راهنما','callback_data'=>'help']],
	[['text'=>'• بستن','callback_data'=>'close']]
]]);

$b=function($m){return js(['inline_keyboard'=>[
	[['text'=>'🏛 برگشت','callback_data'=>'back-'.$m]]
]]);};

if($cmd=='panel' or $cmd=='پنل')
	reply("• لطفا بخش مورد نظر خود را انتخاب کنید :",$k_p);

if($data=='close')
	edit("• پنل با موفقیت بسته شد!");

$k_h=js(['inline_keyboard'=>[
	[['text'=>'راهنمای قفلی','callback_data'=>'h-l'],['text'=>'راهنمای مدیریت','callback_data'=>'h-m']],
	[['text'=>'راهنمای سرگرمی','callback_data'=>'h-s'],['text'=>'راهنمای پاکسازی','callback_data'=>'h-p']],
	[['text'=>'دستورات انگلیسی','callback_data'=>'d-e'],['text'=>'راهنمای اد اجباری','callback_data'=>'h-j']],
	[['text'=>'راهنمای کنترلی','callback_data'=>'h-k'],['text'=>'راهنمای خوشامد','callback_data'=>'h-kh']],
	[['text'=>'🏛 برگشت','callback_data'=>'back-m']]
]]);


if($data=='help' or $data=='back-h')
	edit("• لطفا بخش مورد نظر خود را انتخاب کنید :",$k_h);

if($data=='back-m')
	edit("• لطفا بخش مورد نظر خود را انتخاب کنید :",$k_p);

$k_b_m=$b('h');

if($data=='h-l')
	edit("➊ تمامی قفل های اصلی ربات :
`لینک . فروارد . تگ . هشتگ . اینلاین . سرویس تلگرام . فارسی . انگلیسی . اد ربات . هایپر . استیکر متحرک . ربات . فیلم سلفی . عضوجدید . عکس . فیلم . ویس . گیف . آهنگ . فایل . متن . مخاطب . استیکر . بازی  `

» شما میتوانید تمام موارد بالا را طبق مثال زیر قفل و باز کنید 
ᴥ  `قفل لینک`
ᴥ  `بازکردن لینک`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ قفل پیام رگباری (فلود) :
» با فعال سازی این قفل اگر کاربران بطور رگباری و مکرر پیام ارسال کنند از گروه محروم میشوند. قفل کردن و بازکردن و تنظیم تعداد پیام رگباری  و حالت آن
ᴥ  `قفل رگبار`
ᴥ  `بازکردن رگبار`
ᴥ  `تعداد رگبار 3-10`
ᴥ  `تنظیم رگبار سکوت`
ᴥ  `تنظیم رگبار بن`
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ قفل سختگیرانه :
» با فعال سازی این قفل اگر کاربران، فروارد و لینک بفرستند سکوت میشوند
ᴥ  `قفل سختگیرانه`
ᴥ  `بازکردن سختگیرانه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➍ قفل و بازکردن گروه :
ᴥ  `قفل گروه`
ᴥ  `بازکردن گروه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➎ قفل خودکار گروه :
» با فعال سازی این قفل گروه در زمان تنظیم شده قفل و باز می شود
ᴥ  `تنظیم قفل خودکار`
ᴥ  `حذف قفل خودکار`
ᴥ  `وضعیت قفل خودکار`
─┅━━━━━━━┅─
Ch : @$channel",$k_b_m);

if($data=='h-m')
	edit("📍 راهنمای دستورات ارتقا مقام :

➊ مدیریت مدیران :
» با ارسال دستور اول تمام ادمین های گروه ارتقا مقام پیدا می کنند و با دستور دوم عزل می شوند
ᴥ  `پیکربندی`
ᴥ  `پاکسازی لیست مدیران`
» برای ارتقا مقام و عزل یک کاربر از مدیریت ربات و  مشاهده لیست مدیران از دستورات زیر استفاده می کنیم
ᴥ  `تنظیم مدیر`
ᴥ  `حذف مدیر`
ᴥ  `لیست مدیران`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ مدیریت کاربران ویژه :
کاربر ویژه به فردی گفته میشود که توانایی مدیریت ربات را ندارد اما درصورت ارسال لینک و... پست او حذف نخواهد شد
» برای ویژه کردن و عزل یک کاربر ویژه از دو دستور زیر استفاده می کنیم
ᴥ  `تنظیم ویژه`
ᴥ  `حذف ویژه`
» برای مشاهده لیست کاربران ویژه و پاکسازی آن از دو دستور زیر استفاده می کنیم
ᴥ  `لیست ویژه`
ᴥ  `پاکسازی لیست ویژه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ ادمین کردن :
» برای ادمین گروه کردن و حذف آن و مشاهده لیست از دستورات زیر استفاده می کنیم
توجه : ربات دیجی باید فول ادمین باشد و تیک آخر مجوز فعال باشد
ᴥ  `افزودن ادمین`
ᴥ  `حذف ادمین`
ᴥ  `لیست ادمین ها`

─┅━━━━━━━┅─
Ch : @$channel",$k_b_m);

if($data=='h-s')
	edit("📍 راهنمای دستورات سرگرمی و کاربردی ربات :

➊ تبدیل استیکر به عکس و بلعکس :
» برای تبدیل استیکر به عکس و بلعکس از دو دستور زیر استفاده می کنیم
ᴥ  `عکس به استیکر`
ᴥ  `استیکر به عکس`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ کاربردی :
» با ارسال هر یک از دستورات زیر گذینه مورد نظر را دریافت کنید . بطور مثال با نوشتن کلمه \"تقویم\" ، تقویم روز جاری ارسال می شود
ᴥ  `تقویم`
ᴥ  `شعر`
ᴥ  `فال`
ᴥ  `نرخ ارز`
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ هواشناسی :
» مثال : هواشناسی تهران یا هواشناسی qom
ᴥ  `هواشناسی`
~ ~ ~ ~ ~ ~ ~ ~ ~
➍ تنظیم لقب کاربر :
» برای مثال \"تنظیم لقب فسقلی\" با این دستور لقب کاربر به کلمه فسقلی تنظیم می شود. و با هر بار صدا کردن ربات، ربات او را فسقلی خطاب می کند
ᴥ  `تنظیم لقب`
» برای حذف لقب یک کاربر و پاکسازی تمام القاب از دو دستور زیر استفاده می کنیم
ᴥ  `حذف لقب`
ᴥ  `پاکسازی لیست لقب`
~ ~ ~ ~ ~ ~ ~ ~ ~
➎ مترجم :
» با این قابلیت ترجمه کلمات یا جملات را دریافت کنید . برای مثال با ریپلای بر روی یک پست انگلیسی و نوشتن ترجمه فارسی ترجمه آن برای شما ارسال می شود
ᴥ  `ترجمه فارسی`
ᴥ  `ترجمه انگلیسی`
~ ~ ~ ~ ~ ~ ~ ~ ~
➏ دریافت اطلاعات :
» اطلاعات کاربر 
ᴥ   `whois`  id 
ᴥ  `info`  reply 
ᴥ  `id`  username | mention 
» اطلاعات شما 
ᴥ  `me`
» اطلاعات گروه 
ᴥ  `اطلاعات گروه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➐ اکو یا سخن گفتن ربات :
» بر روی پیام شخصی که میخواد ربات به اون پیام دهد ریپلای کنید و بنویسید \"بگوو\" و با یک فاصله پیام  خود را بنویسید و ارسال کنید 
ᴥ  `بگوو`
~ ~ ~ ~ ~ ~ ~ ~ ~
➑ آمار :
» برای بدست آوردن آمار فعالیت های گروه و فعال ترین اعضا از دستور زیر استفاده می کنیم
ᴥ  `آمار`
» برای روشن و خاموش کردن آمار خودکار از دو دستور زیر استفاده می کنیم. توجه کنید آمار خودکار هر روز ساعت 12 و 20 ارسال می شود
ᴥ  `آمار روشن`
ᴥ  `آمار خاموش`
» برای دریافت روزانه ی آمار در زمان دلخواه از دستور زیر استفاده می کنیم. 
مثال: تنظیم آمار 23:30
ᴥ  `تنظیم آمار`
~ ~ ~ ~ ~ ~ ~ ~ ~
➒ معنی کلمات فارسی :
» با این دستور معنی کلمات فارسی را دریافت کنید . برای مثال \"معنی مشرب\"
ᴥ  `معنی`

─┅━━━━━━━┅─
Ch : @$channel",$k_b_m);

if($data=='h-p')
	edit("📍 راهنمای دستورات پاکسازی :

➊ پاکسازی کامل پیام های گروه :

داخل گپ بنویسید
ᴥ  `حذف 100`
بعد از پاک شدن پیام ها اگر پیامی موند
» ابتدا یکبار گپ و دستی کامل پاکسازی کنید
» سپس برای پاک کردن پیام های جدید هر روز یا هر چند ساعت که مایل بودید البته کمتر از 48 ساعت

داخل گپ بنویسید حذف 10000

نکات مهم:
1— بهتر داخل گپ ربات دیگه ای نداشته باشید!
2— تا حد ممکن پیامهای یک کاربرو delete all نکنید!
3— صبر کنید ربات گزارش پاکسازی و بده و مکرر دستور حذف 10000 و نزنید!
4— بعد گزارش مثلا گفت 4000 پیام پاک شده ولی تو گپ پیامی مونده بود حتما یکی از دلایل بالا باعث شده کار ربات مختل بشه و باید اون مقدار مونده رو دستی پاک کنید
5— ربات و ادمین کامل کنید
6— اگر هر روز گپو کامل پاکسازی میکنید بنابراین از دستورات حذف 100 و عددهای کوچیک مشابه استفاده نکنید
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ پاکسازی لیست ها :
ᴥ  `پاکسازی لیست مدیران`
ᴥ  `پاکسازی لیست ویژه`
ᴥ  `پاکسازی لیست اخطار`
ᴥ  `پاکسازی لیست بن`
ᴥ  `پاکسازی لیست سکوت`
ᴥ  `پاکسازی لیست لقب`
ᴥ  `پاکسازی لیست فیلتر`

» توجه داشته باشید که دستور پاکسازی لیست مدیران ، ویژه و لقب مختص مالکین گروه میباشد

─┅━━━━━━━┅─
Ch : @fatherweb",$k_b_m);

if($data=='d-e')
	edit("• راهنمای دستورات انگلیسی ربات :

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

• Ch : @$channel",$k_b_m,'html');

if($data=='h-j')
	edit("📍 راهنمای دستورات اد اجباری گروه :

➊ اد اجباری :
» با فعال سازی این قفل تمام کاربران مجبور میشوند 3 نفر به گروه  اد کنند تا اجازه چت کردن زا بدست بیاورند
ᴥ  `اجبار عضویت فعال`
ᴥ  `اجبار عضویت غیرفعال`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ تعداد اد اجباری :
» برای تعیین تعداد اد اجباری بطور مثال 5 نفر از دستور زیر استقاده می کنیم
ᴥ  `تنظیم اجبار عضویت 5`
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ حالت اد اجباری :
» برای اینکه فقط اعضای جدید یا تمام اعضای گروه مجبور به اد شوند
ᴥ  `وضعیت اجبار عضویت جدید`
ᴥ  `وضعیت اجبار عضویت همه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➍ پاکسازی سابقه اد اجباری :
» برای پاکسازی لیست افرادی که اد کردن و تمام اعضای گروه مجبور به اد شوند
ᴥ  `پاکسازی سابقه اجبار عضویت`
~ ~ ~ ~ ~ ~ ~ ~ ~
➎ پیام اد اجباری :
» برای تنظیم زمان پاک شدن پیام ربات بطور مثال از دستور 
ᴥ  `تنظیم زمان اجبار عضویت 60`
~ ~ ~ ~ ~ ~ ~ ~ ~
➏ معاف کردن :
» برای معاف کردن کاربر از اد از دستور زیر استقاده می کنیم
ᴥ  `معاف`
~ ~ ~ ~ ~ ~ ~ ~ ~
📍حضور اجباری کانال (ربات باید در کانال ادمین باشد) :

➊ حضور اجباری :
» با فعال سازی این قفل تمام کاربران مجبور میشوند در کانال شما عضو شوند تا اجازه چت کردن را بدست بیاورند
ᴥ  `اجبار حضور فعال`
ᴥ  `اجبار حضور غیرفعال`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ تنظیم کانال :
» برای تنظیم کانال ابتدا بنویسید تنظیم کانال و با یک فاصله آیدی کانال رو قرار بدید
ᴥ  `تنظیم کانال @$channel`
 
💬 اکثر دستورات بالا به روش بسیار راحتی از طریق پنل ربات بخش تنظیمات پیشرفته قسمت ادد اجباری گروه و عضویت اجباری قابل تنظیم میباشد
─┅━━━━━━━┅─
Ch : @drsite",$k_b_m);

if($data=='h-k')
	edit("📍 راهنمای دستورات کنترل کاربران :

➊ بن :
» با ریپلای و ارسال دستور اول کاربر بن و با دستور دوم حذف بن می شود. 
ᴥ  `بن`
ᴥ  `حذف بن`
» برای مشاهده لیست بن و پاکسازی آن از دو دستور زیر استفاده می کنیم
ᴥ  `لیست بن`
ᴥ  `پاکسازی لیست بن`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ سکوت :
» با ریپلای و ارسال دستور اول کاربر سکوت و با دستور دوم حذف سکوت می شود. 
ᴥ  `سکوت`
ᴥ  `حذف سکوت`
» برای مشاهده لیست سکوت و پاکسازی آن از دو دستور زیر استفاده می کنیم.
ᴥ  `لیست سکوت`
ᴥ  `پاکسازی لیست سکوت`
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ سکوت زماندار :
» با ریپلای و ارسال دستور کاربر به مدت مشخص شده سکوت می شود. 
برای مثال ( سکوت 26 ) با این دستور کاربر 26 دقیقه سکوت میشود.
ᴥ  `سکوت دقیقه`
~ ~ ~ ~ ~ ~ ~ ~ ~
➍ اخطار :
» با ریپلای و ارسال دستور اول کاربر اخطار و با دستور دوم حذف اخطار می شود. 
ᴥ  `اخطار`
ᴥ  `حذف اخطار`
» برای مشاهده لیست اخطار و پاکسازی آن از دو دستور زیر استفاده می کنیم
ᴥ  `لیست اخطار`
ᴥ  `پاکسازی لیست اخطار`
» برای تغییر حالت اخطار و اینکه کاربران بعد از رسیدن به حداکثر اخطار بن یا سکوت شوند از دو دستور زیر استفاده می کنیم
ᴥ  `تنظیم اخطار سکوت`
ᴥ  `تنظیم اخطار بن`
~ ~ ~ ~ ~ ~ ~ ~ ~
» برای تنظیم تعداد اخطار از دستور زیر استفاده می کنیم
برای مثال ( تعداد اخطار 4 ) با این دستور کاربران بعد از دریافت 4 اخطار بن یا سکوت میشوند
ᴥ  `تعداد اخطار`

» برای مشاهده تعداد اخطارهای یک کاربر بر روی پیام وی ریپلای کرده و دستور زیر را ارسال می کنیم
ᴥ  `وضعیت اخطار`
~ ~ ~ ~ ~ ~ ~ ~ ~

💬 برای مجازات کاربران بجز ریپلای از آیدی و آیدی عددی و منشن نیز می توانیم استفاده کنیم
برای مثال ( بن  @moshreb ) با این دستور کاربران بن میشود
─┅━━━━━━━┅─
Ch : @iranpanele",$k_b_m);

if($data=='h-kh')
	edit("📍 راهنمای دستورات خوشامد :

➊ فعال کردن پیام خوشامد گویی :
ᴥ  `خوشامد روشن`
ᴥ  `خوشامد خاموش`
~ ~ ~ ~ ~ ~ ~ ~ ~
➋ تنظیم متن پیام خوشامد :
ᴥ  `تنظیم خوشامد متن دلخواه`
ᴥ  `حذف خوشامد`

» شما میتوانید از گزینه های زیر نیز در پیام خوشامد گویی استفاده کنید :
• `mention` : منشن کردن نام کاربر
• `firstname` : بکار بردن نام کوچک
• `lastname` : بکار بردن نام بزرگ
• `username` : بکار بردن یوزرنیم
• `groupname` : بکار بردن نام گروه
• `grouprules` : بکار بردن قوانین
• `grouplink` : بکار بردن لینک
• `userid` : بکار بردن شناسه
• `time` : بکار بردن ساعت
• `date` : بکار بردن تاریخ

بطوز مثال :
تنظیم خوشامد سلام mention به گروه groupname خوش اومدین 🌹
 
~ ~ ~ ~ ~ ~ ~ ~ ~
➌ حذف خودکار پیام خوشامد :
» با دستور زیر پیام خوشامدگویی پس از زمان مشخص حذف میشود و با دستور دوم دیگر حذف نمی شود. 
ᴥ  `تنظیم زمان خوشامد عدد`
ᴥ  `زمان خوشامد خاموش`

بطوز مثال :
`تنظیم زمان خوشامد 30`
» با این دستور پیام خوشامد بعد از گذشت 30 ثانیه حذف میشود.

─┅━━━━━━━┅─
Ch : @fatherweb",$k_b_m);

$k_l=js(['inline_keyboard'=>[
	[['text'=>'⛔️ لیست بن','callback_data'=>'l-b'],['text'=>'🤐 لیست سکوت','callback_data'=>'l-s']],
	[['text'=>'📝 لیست فیلتر','callback_data'=>'l-f'],['text'=>'🔮 لیست ویژه','callback_data'=>'l-v']],
	[['text'=>'👨‍✈️ لیست مدیران','callback_data'=>'l-m']],
	[['text'=>'🏛 برگشت','callback_data'=>'back-m']]
]]);

if($data=='lists' or $data=='back-l')
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_l);

$b2=function($x){return js(['inline_keyboard'=>[[['text'=>'پاکسازی لیست','callback_data'=>'rem-'.$x]],
[['text'=>'🏛 برگشت','callback_data'=>'back-l']]]]);};
$k_b_l=$b('l');
if($data=='rem-v') {
	$ne->update('groups',['vip'=>'[]']);
	edit("لیست مورد نظر با موفقیت پاک شد!",$k_b_l);
}
if($data=='rem-m') {
	$ne->update('groups',['promote'=>'[]']);
	edit("لیست مورد نظر با موفقیت پاک شد!",$k_b_l);
}
if($data=='rem-s') {
	$ne->update('groups',['silent'=>'[]']);
	edit("لیست مورد نظر با موفقیت پاک شد!",$k_b_l);
}
if($data=='rem-f') {
	$ne->update('groups',['filter'=>'[]']);
	edit("لیست مورد نظر با موفقیت پاک شد!",$k_b_l);
}
if($data=='rem-b') {
	$ne->update('groups',['ban'=>'[]']);
	edit("لیست مورد نظر با موفقیت پاک شد!",$k_b_l);
}

if($data=='l-m')
	if($promote) {
		$x='';$i=0;
		foreach($promote as $id)
			$x.=++$i." - [$id](tg://user?id=$id)\n";
		edit($x,$b2('m'));
	}else
		alert("لیست مورد نظر خالی میباشد!",true);
if($data=='l-v')
	if($vip) {
		$x='';$i=0;
		foreach($vip as $id=>$k)
			$x.=++$i." - [$id](tg://user?id=$id)\n";
		edit($x,$b2('v'));
	}else
		alert("لیست مورد نظر خالی میباشد!",true);
if($data=='l-f')
	if($filter) {
		$x='';$i=0;
		foreach($filter as $k)
			$x.=++$i." - ( $k )\n";
		edit($x,$b2('f'));
	}else
		alert("لیست مورد نظر خالی میباشد!",true);
if($data=='l-s')
	if($silent) {
		$x='';$i=0;
		foreach($silent as $id=>$v)
			$x.=++$i." - [$id](tg://user?id=$id)\n";
		edit($x,$b2('s'));
	}else
		alert("لیست مورد نظر خالی میباشد!",true);
if($data=='l-b')
	if($ban) {
		$x='';$i=0;
		foreach($ban as $id=>$v)
			$x.=++$i." - [$id](tg://user?id=$id)\n";
		edit($x,$b2('b'));
	}else
		alert("لیست مورد نظر خالی میباشد!",true);


if(preg_match('~^locks(?:-(.+))?$~',$data,$d)) {
	if($d=$d[1]) {
		$lock->$d=$lock->$d=='on'?'off':'on';
		$ne->update('groups',['locked'=>js($lock)]);
		}
	$n=function($s)use($lock,$locks){
		$l=$lock->$s=='on'?'✅':'❌';
		return ['text'=>$locks[$s].' : '.$l,'callback_data'=>'locks-'.$s];
	};
	
	$k=js(['inline_keyboard'=>[
		[$n('link'),$n('hyper')],
		[$n('tag'),$n('hashtag')],
		[$n('english'),$n('persian')],
		[$n('text'),$n('tgservice')],
		[$n('forward'),$n('location')],
		[$n('contact'),$n('addbot')],
		[$n('bot'),$n('emoji')],
		[$n('verfication')],
		[['text'=>'صفحه بعدی','callback_data'=>'np'],['text'=>'🏛 برگشت','callback_data'=>'back-m']],
	]]);
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k);
}

if(preg_match('~^np-?(.+)?~',$data,$d)) {
	if($d=$d[1]) {
		$lock->$d=$lock->$d=='on'?'off':'on';
		$ne->update('groups',['locked'=>js($lock)]);
		}
	$n=function($s)use($lock,$locks){
		$l=$lock->$s=='on'?'✅':'❌';
		return ['text'=>$locks[$s].' : '.$l,'callback_data'=>'np-'.$s];
	};
	$k=js(['inline_keyboard'=>[
		[$n('photo'),$n('video')],
		[$n('audio'),$n('document')],
		[$n('gif'),$n('sticker')],
		[$n('game'),$n('voice')],
		[$n('videonote'),$n('sticker animation')],
		[['text'=>'صفحه قبلی','callback_data'=>'locks'],['text'=>'🏛 برگشت','callback_data'=>'back-m']]
	]]);
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k);
}

$k_l2=js(['inline_keyboard'=>[
	[['text'=>'🔮 ادد اجباری','callback_data'=>'adde'],['text'=>'📮 عضویت اجباری','callback_data'=>'adj']],
	[['text'=>'⚠️ تنظیمات اخطار','callback_data'=>'setw'],['text'=>'💬 خوشامد گویی','callback_data'=>'wel']],
	[['text'=>'سختگیرانه','callback_data'=>'hard'],['text'=>'⚙ دسترسی های گروه','callback_data'=>'can']],
	[['text'=>'🔏 پیام رگباری','callback_data'=>'flood'],['text'=>'✅ قفل گروه','callback_data'=>'lockgp']],
	[['text'=>'📚 ضدتبچی','callback_data'=>'antit']],
	[['text'=>'🏛 برگشت','callback_data'=>'back-m']]
]]);
if($data=='locks2')
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_l2);

if(preg_match('~antit(?:-(.+))?$~',$data,$d)) {
	if($d=$d[1]) {
		$lock->tabchi=$d;
		$ne->update('groups',['locked'=>js($lock)]);
	}
	if($lock->tabchi=='on')
		$k_lg=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'antit-on'],['text'=>'غیرفعال','callback_data'=>'antit-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_lg=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'antit-on'],['text'=>'غیرفعال ✅','callback_data'=>'antit-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_lg);
}


if(preg_match('~lockgp(?:-(.+))?$~',$data,$d)) {
	if($d=$d[1]) {
		$step->autolockNow=$d;
		$ne->update('groups',['step'=>js($step,256)]);
	}
	$x=$step->autolockStart?$step->autolockStart.' الی '.$step->autolockEnd:'( تنظیم نشده )';
	if($step->autolockNow=='on')
		$k_lg=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'lockgp-on'],['text'=>'غیرفعال','callback_data'=>'lockgp-off']],
			[['text'=>'ساعات قفل خودکار : '.$x,'callback_data'=>'null']],
			[['text'=>'تنظیم قفل خودکار','callback_data'=>'say']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_lg=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'lockgp-on'],['text'=>'غیرفعال ✅','callback_data'=>'lockgp-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_lg);
}

if($data=='say')alert('• لطفا دستور زیر را در گروه ارسال کنید !

›› تنظیم قفل خودکار',true);

if(preg_match('/^flood(?:-(.+))?$/',$data,$d)) {
	if($d=$d[1]) {
		if($d=='on' or $d=='off')
			$lock->flood=$d;
		if($d=='ban' or $d=='silent')
			$flood['type']=$d;
		if(preg_match('~^t-(.+)$~',$d,$b)) {
			if($b[1]==-1 and $flood['time']==2)
				alert('حداقل زمان مرگبار 2 ثانیه میباشد!');
			else if($b[1]==1 and $flood['time']==10)
				alert('حداکثر زمان مرگبار 10 ثانیه میباشد!');
			else
				$flood['time']+=$b[1];
		}
		
		if(preg_match('~^d-(.+)$~',$d,$b)) {
			if($b[1]==-1 and $flood['max']==2)
				alert('حداقل تعداد رگبار 2 میباشد!');
			else if($b[1]==1 and $flood['max']==10)
				alert('حداکثر تعداد رگبار 10 میباشد!');
			else
				$flood['max']+=$b[1];
		}
		
		$ne->update('groups',['locked'=>js($lock),'flood'=>js($flood)]);
	}
	$n=$flood['time'];
	$n2=$flood['max'];
	$n3=$flood['type']=='silent'?'سکوت ✅':'سکوت';
	$n4=$flood['type']=='ban'?'بن ✅':'بن';
	if($lock->flood=='on')
		$k_flo=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'flood-on'],['text'=>'غیرفعال','callback_data'=>'flood-off']],
			[['text'=>$n3,'callback_data'=>'flood-silent'],['text'=>$n4,'callback_data'=>'flood-ban']],
			[['text'=>'⏰تنظیم زمان رگبار⏰','callback_data'=>'null']],
			[['text'=>'➖','callback_data'=>'flood-t--1'],['text'=>$n,'callback_data'=>'null'],['text'=>'➕','callback_data'=>'flood-t-1']],
			[['text'=>'🌀تنظیم رگبار🌀','callback_data'=>'null']],
			[['text'=>'➖','callback_data'=>'flood-d--1'],['text'=>$n2,'callback_data'=>'null'],['text'=>'➕','callback_data'=>'flood-d-1']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_flo=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'flood-on'],['text'=>'غیرفعال ✅','callback_data'=>'flood-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
		edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_flo);
}




if(preg_match('~^can(?:_(.+))?$~',$data,$d)) {
	$n=Neman('getchat',['chat_id'=>$chat])->result->permissions;
	if($d=$d[1]) {
		$c='can_'.$d;
		$n->$c=$n->$c===true?false:true;
		Neman('setChatPermissions',[
			'chat_id'=>$chat,
			'permissions'=>js($n)
		]);
	}
	$n=Neman('getchat',['chat_id'=>$chat])->result->permissions;
	$k_ca=js(['inline_keyboard'=>[
		[['text'=>'ارسال پیام : '.($n->can_send_messages===true?'باز':'بسته'),'callback_data'=>'can_send_messages']],
		[['text'=>'ارسال رسانه : '.($n->can_send_media_messages===true?'باز':'بسته'),'callback_data'=>'can_send_media_messages']],
		[['text'=>'ارسال نظرسنجی : '.($n->can_send_polls===true?'باز':'بسته'),'callback_data'=>'can_send_polls']],
		[['text'=>'ارسال باقی پیام ها : '.($n->can_send_other_messages===true?'باز':'بسته'),'callback_data'=>'can_send_other_messages']],
		[['text'=>'ارسال لینک با نمایش لینک: '.($n->can_add_web_page_previews===true?'باز':'بسته'),'callback_data'=>'can_add_web_page_previews']],
		[['text'=>'اضافه کردن عضو جدید : '.($n->can_invite_users===true?'باز':'بسته'),'callback_data'=>'can_invite_users']],
		[['text'=>'💬 برگشت','callback_data'=>'locks2']]
	]]);
	edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_ca);
}

if(preg_match('~^hard(?:-(.+))?$~',$data,$d)) {
	if($d=$d[1]) {
		$lock->hard=$d;
		$ne->update('groups',['locked'=>js($lock)]);
	}
	if($step->hard=='on')
		$k_ha=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'hard-on'],['text'=>'غیرفعال','callback_data'=>'hard-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_ha=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'hard-on'],['text'=>'غیرفعال ✅','callback_data'=>'hard-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	edit('به بخش حالت سختگیرانه خوش آمدی . حالت سختگیرانه روی لینک ، فوروارد تنظیم شده است با فعال سازی این حالت اگر کاربران لینک ، فوروارد بفرستند بصورت همیشگی سکوت می شود',$k_ha);
}

if(preg_match('~^wel(?:-(.+))?$~',$data,$d)) {
	if($d=$d[1]) {
		$step->welcome->now=$d;
		$ne->update('groups',['step'=>js($step,256)]);
	}
	if($step->welcome->now=='on')
		$k_we=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'wel-on'],['text'=>'غیرفعال','callback_data'=>'wel-off']],
			[['text'=>'💈 تنظیم پیام خوشامد','callback_data'=>'setwel']],
			[['text'=>'🚫 حذف پیام خوشامد','callback_data'=>'remwel']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_we=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'wel-on'],['text'=>'غیرفعال ✅','callback_data'=>'wel-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
		$step->welcome->pm=$step->welcome->pm?:'سلام firstname
به گروه groupname خوش امدید 🌹

ساعت : time';
	edit('به بخش خوشامد گویی ربات خوشامدید.

متن خوشامد گویی فعلی :  '.
(mb_strlen($step->welcome->pm)>53?mb_substr($step->welcome->pm,0,53).'...':$step->welcome->pm),$k_we);
}

if($data=='setwel') {
	alert('پیام خوشامد جدید را ارسال کنید.',true);
	$step->steps->$from='setwel';
	$ne->update('groups',['step'=>js($step,256)]);
}

else if($step->steps->$from=='setwel' and $text) {
	$step->steps->$from='';
	$step->welcome->pm=$text;
	$ne->update('groups',['step'=>js($step,256)]);
	reply("• پیام خوشامد گویی با موفقیت ثبت شد .

» پیام خوشامد گویی :
» { ".(mb_strlen($text)>55?mb_substr($text,0,55).'...':$text)." }");
}

if($data=='remwel') {
	unset($step->welcome->pm);
	$ne->update('groups',['step'=>js($step,256)]);
	alert('پیام خوشامد پاک شد.',true);
	edit('به بخش خوشامد گویی ربات خوشامدید.

متن خوشامد گویی فعلی :  سلام firstname
به گروه groupname خوش امدید 🌹

ساعت : ...',js($update->callback_query->message->reply_markup));
}


if(preg_match('/^setw(?:-(.+))?$/',$data,$d)) {
	if($d=$d[1]) {
		if(preg_match('~^w-(.+)~',$d,$b)) {
			if($b=$b[1]) {
				if($b==1 and $warn->warn==10)
					alert('تعداد اخطار نمیتواند بیشتر از 10 باشد!');
				else if($b==-1 and $warn->warn==1)
					alert('تعداد اخطار نمیتواند کمتر از 1 باشد!');
				else
					$warn->warn+=$b;
			}
		}else
			$warn->type=$d;
		$ne->update('groups',['warn'=>js($warn)]);
	}
	$b=$warn->type=='ban'?'بن ✅':'بن';
	$s=$warn->type=='silent'?'سکوت ✅':'سکوت';
		$k_w=js(['inline_keyboard'=>[
			[['text'=>'➖','callback_data'=>'setw-w--1'],['text'=>$warn->warn,'callback_data'=>'null'],['text'=>'➕','callback_data'=>'setw-w-1']],
			[['text'=>$s,'callback_data'=>'setw-silent'],['text'=>$b,'callback_data'=>'setw-ban']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
		edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_w);
}

if(preg_match('/^adde(?:-(.+))?$/',$data,$d)) {
	if($d=$d[1]) {
		if($d=='on' or $d=='off')
			$step->adde->ok=$d;
		if(preg_match('~^t-(.+)$~',$d,$b)) {
			if($b[1]==-1 and $step->adde->t==1)
				alert('تعداد اجبار ادد نمیتواند کمتر از 1 باشد!');
			else if($b[1]==1 and $step->adde->t==10)
				alert('تعداد اجبار ادد نمیتواند بیشتر از 10 باشد!');
			else
				$step->adde->t+=$b[1];
		}
		
		if(preg_match('~^d-(.+)$~',$d,$b)) {
			if($b[1]==-5 and $step->adde->d<=5)
				alert('زمان حذف پیام نمیتواند کمتر از 5 باشد!');
			else if($b[1]==5 and $step->adde->d>55)
				alert('زمان حذف پیام نمیتواند بیشتر از 60 باشد!');
			else
				$step->adde->d+=$b[1];
		}
		
		$ne->update('groups',['step'=>js($step,256)]);
	}
	$n=$step->adde->t;
	$n2=$step->adde->d;
	if($step->adde->ok=='on')
		$k_adde=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'adde-on'],['text'=>'غیرفعال','callback_data'=>'adde-off']],
			[['text'=>'تعداد اجبار','callback_data'=>'null']],
			[['text'=>'➖','callback_data'=>'adde-t--1'],['text'=>"$n نفر",'callback_data'=>'null'],['text'=>'➕','callback_data'=>'adde-t-1']],
			[['text'=>'زمان حذف پیام','callback_data'=>'null']],
			[['text'=>'➖','callback_data'=>'adde-d--5'],['text'=>"$n2 ثانیه",'callback_data'=>'null'],['text'=>'➕','callback_data'=>'adde-d-5']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_adde=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'adde-on'],['text'=>'غیرفعال ✅','callback_data'=>'adde-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
		edit('• لطفا بخش مورد نظر خود را انتخاب کنید :',$k_adde);
}



if(preg_match('/^adj(?:-(.+))?/',$data,$d)) {
	$ch=$step->adj->ch?:'{تنظیم نشده}';
	if($d=$d[1]) {
		$step->adj->ok=$d;
		$ne->update('groups',['step'=>js($step,256)]);
	}
	if($step->adj->ok=='on')
		$k_adj=js(['inline_keyboard'=>[
			[['text'=>'فعال ✅','callback_data'=>'adj-on'],['text'=>'غیرفعال','callback_data'=>'adj-off']],
			[['text'=>"کانال : $ch",'callback_data'=>'null']],
			[['text'=>'📮 تنظیم کانال','callback_data'=>'set-adj']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	else
		$k_adj=js(['inline_keyboard'=>[
			[['text'=>'فعال','callback_data'=>'adj-on'],['text'=>'غیرفعال ✅','callback_data'=>'adj-off']],
			[['text'=>'💬 برگشت','callback_data'=>'locks2']]
		]]);
	edit('به بخش عضویت اجباری ربات خوشامدید.

دقت داشته باشید که برای استفاده از این قابلیت حتما باید ربات را در کانال خود ادمین کنید.:',$k_adj);
}

if($data=='set-adj') {
	alert('آیدی کانال خود را وارد کنید!',true);
	$step->steps->$from='setadj';
	$ne->update('groups',['step'=>js($step,256)]);
}

if($step->steps->$from=='setadj' and $text) {
	if(preg_match('~^@.+~',$text)) {
		reply("• آیدی کانال مورد نظر برای عضویت اجباری ثبت شد .

» کانال شما :
» { $text }");
	$step->adj->ch=$text;
	$step->steps->$from='';
	$ne->update('groups',['step'=>js($step,256)]);
	}else
		reply('آیدی کانال حتما باید با @ شروع شود..');
}

