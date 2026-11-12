<?php
/**
 * فهرست همه‌ی تنظیمات قالب، مقدارهای پیش‌فرض و ابزارهای خواندن و قالب‌بندی متن.
 *
 * هر تنظیم یک‌بار این‌جا تعریف می‌شود؛ سفارشی‌سازی، پیش‌نمایش زنده و قالب‌ها همه از همین فهرست می‌خوانند.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

/**
 * آیکون‌هایی که در تنظیمات قابل انتخاب‌اند.
 *
 * @return array
 */
function enteghalino_icon_choices() {
	return array(
		'i-clock'     => __( 'ساعت', 'enteghalino' ),
		'i-bell-off'  => __( 'زنگ خاموش', 'enteghalino' ),
		'i-server'    => __( 'سرور', 'enteghalino' ),
		'i-code'      => __( 'کد', 'enteghalino' ),
		'i-package'   => __( 'بسته', 'enteghalino' ),
		'i-layers'    => __( 'لایه‌ها', 'enteghalino' ),
		'i-gauge'     => __( 'سرعت‌سنج', 'enteghalino' ),
		'i-link'      => __( 'پیوند', 'enteghalino' ),
		'i-user'      => __( 'کاربر', 'enteghalino' ),
		'i-bag'       => __( 'فروشگاه', 'enteghalino' ),
		'i-receipt'   => __( 'سفارش', 'enteghalino' ),
		'i-check'     => __( 'تیک', 'enteghalino' ),
		'i-rocket'    => __( 'موشک', 'enteghalino' ),
		'i-clipboard' => __( 'گزارش', 'enteghalino' ),
	);
}

/**
 * ساختار کامل تنظیمات: بخش‌ها و فیلدها به ترتیب نمایش در سفارشی‌سازی.
 *
 * نوع‌ها: text، textarea، lines (هر خط یک مورد)، url، color، checkbox، select، heading (فقط عنوان).
 * fmt: chip یعنی متن داخل [کروشه] به شکل دکمه نمایش داده شود.
 *
 * @return array
 */
function enteghalino_schema() {
	static $schema = null;
	if ( null !== $schema ) {
		return $schema;
	}

	$hint_mark  = __( 'بخشی را که باید رنگی شود بین دو ستاره بگذارید؛ مثل: در *هفت ایستگاه*', 'enteghalino' );
	$hint_lines = __( 'هر خط یک مورد.', 'enteghalino' );
	$hint_pairs = __( 'هر خط یک مورد، به شکل «عنوان | توضیح».', 'enteghalino' );
	$hint_chip  = __( 'متن داخل [کروشه] به شکل دکمه نمایش داده می‌شود.', 'enteghalino' );
	$hint_link  = __( 'نشانی کامل، یا لنگر یکی از بخش‌ها: #get ، #story ، #manifest ، #faq', 'enteghalino' );

	$schema = array();

	// ---------- عمومی ----------
	$schema['general'] = array(
		'title'  => __( 'عمومی', 'enteghalino' ),
		'target' => '.hero',
		'fields' => array(
			'brand_name'       => array( 'text', __( 'نام برند (سربرگ و پانویس)', 'enteghalino' ), 'انتقالینو' ),
			'version'          => array( 'text', __( 'نسخه‌ی افزونه', 'enteghalino' ), '1.0.0' ),
			'download_url'     => array( 'url', __( 'لینک دریافت افزونه', 'enteghalino' ), 'https://github.com/pixitm/Enteghalino', __( 'دکمه‌ی بخش پایانی به این نشانی می‌رود.', 'enteghalino' ) ),
			'meta_description' => array( 'textarea', __( 'توضیح صفحه‌ی اول برای موتورهای جست‌وجو', 'enteghalino' ), 'انتقالینو محصولات، سفارش‌ها، کاربرها، رسانه و تنظیمات یک سایت وردپرس و ووکامرس را به سایت دیگر منتقل می‌کند؛ تکه‌تکه و قابل ازسرگیری، حتی روی هاست کم‌منبع.', __( 'اگر Yoast، Rank Math یا AIOSEO فعال باشد، این متن نوشته نمی‌شود.', 'enteghalino' ), 'refresh' ),
			'_h_motion'        => array( 'heading', __( 'حرکت و تعامل', 'enteghalino' ) ),
			'cursor'           => array( 'checkbox', __( 'نشانگر ماوس اختصاصی', 'enteghalino' ), true, __( 'روی دستگاه‌های لمسی همیشه خاموش است.', 'enteghalino' ) ),
			'reveal'           => array( 'checkbox', __( 'انیمیشن ورود سکشن‌ها هنگام اسکرول', 'enteghalino' ), true ),
		),
	);

	// ---------- رنگ‌ها ----------
	$schema['colors'] = array(
		'title'       => __( 'رنگ‌ها', 'enteghalino' ),
		'description' => __( 'سایه‌های روشن‌تر و تیره‌تر و رنگ متن روی دکمه‌ها خودکار ساخته می‌شوند تا خوانایی حفظ شود.', 'enteghalino' ),
		'target'      => '.hero',
		'fields'      => array(
			'color_brand'  => array( 'color', __( 'رنگ اصلی (دکمه‌ها، نشانه‌ها، داده‌ی در راه)', 'enteghalino' ), '#ffb145' ),
			'color_accent' => array( 'color', __( 'رنگ دوم (تأیید، رسیدن، مقصد)', 'enteghalino' ), '#24c184' ),
			'color_paper'  => array( 'color', __( 'رنگ زمینه', 'enteghalino' ), '#f2eee5' ),
			'color_ink'    => array( 'color', __( 'رنگ متن و سطح‌های تیره', 'enteghalino' ), '#17150f' ),
		),
	);

	// ---------- سربرگ ----------
	$schema['header'] = array(
		'title'       => __( 'سربرگ و منو', 'enteghalino' ),
		'description' => __( 'اگر در «نمایش › فهرست‌ها» منویی به جایگاه «منوی بالای لندینگ» بدهید، به‌جای این سه پیوند نمایش داده می‌شود.', 'enteghalino' ),
		'target'      => '.top',
		'fields'      => array(
			'nav_1'          => array( 'text', __( 'پیوند ۱ (روند کار)', 'enteghalino' ), 'روند کار' ),
			'nav_2'          => array( 'text', __( 'پیوند ۲ (فهرست بار)', 'enteghalino' ), 'چه چیزهایی منتقل می‌شود' ),
			'nav_3'          => array( 'text', __( 'پیوند ۳ (پرسش‌ها)', 'enteghalino' ), 'پرسش‌ها' ),
			'header_btn'     => array( 'text', __( 'متن دکمه‌ی سربرگ', 'enteghalino' ), 'دریافت افزونه' ),
			'header_btn_url' => array( 'url', __( 'لینک دکمه‌ی سربرگ', 'enteghalino' ), '#get', $hint_link ),
		),
	);

	// ---------- هیرو ----------
	$schema['hero'] = array(
		'title'  => __( 'هیرو (بالای صفحه)', 'enteghalino' ),
		'target' => '.hero',
		'fields' => array(
			'hero_label'        => array( 'text', __( 'برچسب بالای عنوان', 'enteghalino' ), 'افزونه‌ی وردپرس' ),
			'hero_show_version' => array( 'checkbox', __( 'نمایش نسخه کنار برچسب', 'enteghalino' ), true ),
			'hero_title_1'      => array( 'text', __( 'عنوان، خط اول', 'enteghalino' ), 'اسباب‌کشیِ سایت،' ),
			'hero_title_2'      => array( 'text', __( 'عنوان، خط دوم', 'enteghalino' ), 'بدون جاماندن' ),
			'hero_title_3'      => array( 'text', __( 'عنوان، خط سوم (برجسته)', 'enteghalino' ), 'حتی یک سفارش' ),
			'hero_lead'         => array( 'textarea', __( 'متن معرفی', 'enteghalino' ), 'انتقالینو محصولات و متغیرها، سفارش‌ها، کاربرها، رسانه، منوها و تنظیمات افزونه‌ها را از یک سایت وردپرس به سایت دیگر می‌برد. کار تکه‌به‌تکه جلو می‌رود؛ اگر هاست وسط کار کم آورد، انتقال از همان تکه ادامه پیدا می‌کند و چیزی از اول شروع نمی‌شود.' ),
			'_h_hero_btn'       => array( 'heading', __( 'دکمه‌ها', 'enteghalino' ) ),
			'hero_btn_1'        => array( 'text', __( 'دکمه‌ی اصلی', 'enteghalino' ), 'دریافت رایگان' ),
			'hero_btn_1_url'    => array( 'url', __( 'لینک دکمه‌ی اصلی', 'enteghalino' ), '#get', $hint_link ),
			'hero_btn_2'        => array( 'text', __( 'دکمه‌ی دوم', 'enteghalino' ), 'ببینید چطور کار می‌کند' ),
			'hero_btn_2_url'    => array( 'url', __( 'لینک دکمه‌ی دوم', 'enteghalino' ), '#story', $hint_link ),
			'_h_hero_more'      => array( 'heading', __( 'ویژگی‌ها و تصویر انتقال', 'enteghalino' ) ),
			'hero_points'       => array( 'lines', __( 'ویژگی‌های زیر دکمه‌ها', 'enteghalino' ), "تکه‌تکه و قابل ازسرگیری\nحتی روی هاست کم‌منبع\nبدون ایمیل و پیامک به مشتری‌ها", $hint_lines ),
			'hero_src_domain'   => array( 'text', __( 'دامنه‌ی سایت مبدأ', 'enteghalino' ), 'old-shop.ir' ),
			'hero_dst_domain'   => array( 'text', __( 'دامنه‌ی سایت مقصد', 'enteghalino' ), 'new-shop.ir' ),
		),
	);

	// ---------- نوار متحرک ----------
	$schema['ticker'] = array(
		'title'  => __( 'نوار متحرک', 'enteghalino' ),
		'target' => '.ticker',
		'fields' => array(
			'show_ticker'  => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
			'ticker_items' => array( 'lines', __( 'موارد نوار', 'enteghalino' ), "محصولات و متغیرها\nسفارش‌ها و ریفاندها\nکاربرها و نقش‌ها\nرسانه\nدسته‌ها و برچسب‌ها\nبرندها\nکدهای تخفیف\nمنوها\nدیدگاه‌ها\nفرم‌های المنتور\nسئوی Yoast و Rank Math\nتنظیمات افزونه‌ها", $hint_lines ),
		),
	);

	// ---------- روند کار ----------
	$steps = array(
		1 => array( 'انتخاب', 'انتخاب می‌کنید چه چیزی برود', 'می‌توانید کل سایت را بفرستید یا فقط محصولات را، بدون نوشته‌های وبلاگ. برای هر بخش هم می‌شود تعیین کرد کدام فیلدهای متا همراهش بروند.', "فهرست بخش‌ها از روی همین سایت ساخته می‌شود\nگزینه‌ی نوع‌نوشته‌های سفارشی فقط وقتی هست که سایت چنین نوشته‌هایی داشته باشد" ),
		2 => array( 'تکه‌ها', 'هر درخواست، یک تکه', 'هاست‌های ارزان معمولاً بعد از ۳۰ ثانیه درخواست را قطع می‌کنند. انتقالینو هر درخواست را پیش از این سقف تمام می‌کند و کار را به درخواست بعدی می‌سپارد. اگر مرورگر بسته شد یا اینترنت رفت، انتقال از آخرین تکه‌ی ذخیره‌شده ادامه پیدا می‌کند.', "هر درخواست حداکثر *۲۵ ثانیه* طول می‌کشد\nجای دقیق کار بعد از هر تکه در دیتابیس ثبت می‌شود" ),
		3 => array( 'سرعت', 'سرعت را از خود سرور می‌پرسد', 'پیش از شروع، تعداد هسته‌ها و حافظه‌ی هاست سنجیده می‌شود و اندازه‌ی اولین دسته از روی آن تعیین می‌شود. بعد از آن هر تکه‌ای که کند تمام شود، یا هر بار که بار سرور بالا برود، دسته‌ی بعدی کوچک‌تر می‌شود. وقتی سرور نفس کشید، دوباره بزرگ می‌شود.', '' ),
		4 => array( 'مسیر', 'با فایل، یا مستقیم بین دو سایت', 'در روش فایلی، یک بسته‌ی ZIP دانلود می‌کنید و در سایت مقصد آپلود می‌کنید. آپلود تکه‌ای است و سقف آپلود هاست جلویش را نمی‌گیرد. در اتصال مستقیم، کلید اتصال سایت مقصد را در مبدأ وارد می‌کنید و بسته بدون دانلود و آپلود، تکه‌به‌تکه به مقصد می‌رود.', "سلامت هر تکه با MD5 بررسی می‌شود\nاگر شبکه قطع شود، ارسال تا ۱۵ دقیقه خودش دوباره تلاش می‌کند" ),
		5 => array( 'شناسه‌ها', 'سفارش ۱۰۴۲ هنوز مال همان مشتری است', 'محصولی که در سایت قدیم شماره‌ی ۸۸ بود، در سایت جدید ممکن است ۲۱۳ شود. انتقالینو کنار هر شناسه‌ی قدیم، شناسه‌ی جدیدش را نگه می‌دارد. کاربرها اول منتقل می‌شوند و سفارش‌ها آخر، پس وقتی نوبت سفارش می‌رسد، مشتری و محصولش از قبل در سایت جدید هستند و سفارش به همان‌ها وصل می‌شود.', '' ),
		6 => array( 'سکوت', 'مشتری‌ها چیزی متوجه نمی‌شوند', 'اگر هشت هزار سفارش قدیمی وارد سایت جدید شود و هر کدام یک ایمیل «سفارش شما تکمیل شد» بفرستد، صبح فردا تلفن پشتیبانی قطع نمی‌شود. برای همین تا ایمپورت تمام نشده، ایمیل‌ها و اعلان‌های سفارش خاموش‌اند. موجودی انبار هم دوباره کم نمی‌شود.', "افزونه‌های پیامک هم چیزی نمی‌فرستند\nیادداشت‌ها و ریفاندهای سفارش با تاریخ اصلی‌شان ثبت می‌شوند" ),
		7 => array( 'شمارش', 'در آخر، شمارش', 'بعد از ایمپورت، تعداد هر بخش در مبدأ با مقصد مقایسه می‌شود و نتیجه در صفحه‌ی گزارش‌ها می‌ماند. اگر چیزی کم باشد، همان‌جا معلوم است کدام بخش و چند مورد.', '' ),
	);
	$story = array(
		'show_story'   => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
		'story_kicker' => array( 'text', __( 'برچسب بالای عنوان', 'enteghalino' ), 'یک انتقال، از اول تا آخر' ),
		'story_title'  => array( 'text', __( 'عنوان بخش', 'enteghalino' ), 'از سایت قدیم تا سایت جدید، در *هفت ایستگاه*', $hint_mark ),
	);
	foreach ( $steps as $n => $step ) {
		/* translators: %s: شماره‌ی ایستگاه */
		$story[ '_h_step_' . $n ]      = array( 'heading', sprintf( __( 'ایستگاه %s', 'enteghalino' ), enteghalino_fa( $n ) ) );
		$story[ 'step_' . $n . '_label' ] = array( 'text', __( 'نام کوتاه (نوار ایستگاه‌ها)', 'enteghalino' ), $step[0] );
		$story[ 'step_' . $n . '_title' ] = array( 'text', __( 'عنوان', 'enteghalino' ), $step[1] );
		$story[ 'step_' . $n . '_text' ]  = array( 'textarea', __( 'توضیح', 'enteghalino' ), $step[2] );
		$story[ 'step_' . $n . '_facts' ] = array( 'lines', __( 'نکته‌ها (اختیاری)', 'enteghalino' ), $step[3], $hint_lines . ' ' . $hint_mark );
	}
	$schema['story'] = array(
		'title'       => __( 'روند کار (هفت ایستگاه)', 'enteghalino' ),
		'description' => __( 'تصویرهای متحرک هر ایستگاه ثابت‌اند؛ متن‌ها را این‌جا تغییر دهید.', 'enteghalino' ),
		'target'      => '#story',
		'fields'      => $story,
	);

	// ---------- فهرست بار ----------
	$schema['manifest'] = array(
		'title'  => __( 'فهرست بار', 'enteghalino' ),
		'target' => '#manifest',
		'fields' => array(
			'show_manifest' => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
			'mf_kicker'     => array( 'text', __( 'برچسب بالای عنوان', 'enteghalino' ), 'فهرست بار' ),
			'mf_title'      => array( 'text', __( 'عنوان بخش', 'enteghalino' ), 'چه چیزهایی *منتقل می‌شود*', $hint_mark ),
			'mf_file'       => array( 'text', __( 'برچسب فایل کنار عنوان', 'enteghalino' ), 'manifest.json' ),
			'mf_col_1'      => array( 'lines', __( 'ستون اول', 'enteghalino' ), "کاربرها، مشتری‌ها و نقش‌های سفارشی | با همان رمز عبور قبلی\nرسانه و بندانگشتی‌ها | بدون بازنویسی فایل مقصد\nدسته، برچسب و ویژگی محصول | با تصویر دسته\nنوشته‌ها، برگه‌ها و نوع‌نوشته‌های سفارشی | هر کدام جدا قابل انتخاب\nدیدگاه‌ها و منوها | با والد و ترتیب\nبرگه‌های فروشگاه، سبد خرید و تسویه‌حساب | بدون برگه‌ی تکراری\nفرم‌های المنتور | با پیام‌های ثبت‌شده در المنتور پرو", $hint_pairs ),
			'mf_col_2'      => array( 'lines', __( 'ستون دوم', 'enteghalino' ), "محصولات ساده، متغیر و گروهی | با محصولات مرتبط\nبرندها | تبدیل بین افزونه‌های برند\nکدهای تخفیف | با محدودیت محصول\nسفارش‌ها، یادداشت‌ها و ریفاندها | سازگار با HPOS\nسئوی هر نوشته و دسته | تبدیل بین Yoast و Rank Math\nتنظیمات افزونه‌ها | به انتخاب خودتان\nافزونه‌ی Extra Product Options | فرم‌ها و قواعد نمایش", $hint_pairs ),
			'mf_note'       => array( 'textarea', __( 'یادداشت پایین فهرست', 'enteghalino' ), 'هر جا آدرس سایت قدیم آمده باشد، در متن نوشته‌ها، منوها یا صفحه‌های المنتور، به آدرس سایت جدید تغییر می‌کند. چند تنظیم هسته‌ی وردپرس، مثل آدرس سایت و فهرست افزونه‌های فعال، عمداً منتقل نمی‌شوند تا سایت مقصد از کار نیفتد.' ),
		),
	);

	// ---------- عددها ----------
	$nums    = array(
		1 => array( 'i-clock', '۲۵', 'ثانیه', 'بیشترین زمان یک درخواست؛ کمتر از سقف رایج هاست‌ها' ),
		2 => array( 'i-bell-off', '۰', '', 'ایمیل یا پیامکی که هنگام ایمپورت به مشتری‌ها می‌رسد' ),
		3 => array( 'i-server', '۰', '', 'فایل از سرور بیرونی؛ فونت و اسکریپت‌ها داخل خود افزونه‌اند' ),
		4 => array( 'i-code', '7.4+', '', 'نسخه‌ی PHP؛ آزموده تا 8.4' ),
	);
	$numbers = array(
		'show_numbers' => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
	);
	foreach ( $nums as $n => $num ) {
		/* translators: %s: شماره‌ی کارت */
		$numbers[ '_h_num_' . $n ]       = array( 'heading', sprintf( __( 'کارت %s', 'enteghalino' ), enteghalino_fa( $n ) ) );
		$numbers[ 'num_' . $n . '_icon' ]  = array( 'select', __( 'آیکون', 'enteghalino' ), $num[0], '', 'refresh', enteghalino_icon_choices() );
		$numbers[ 'num_' . $n . '_value' ] = array( 'text', __( 'عدد', 'enteghalino' ), $num[1] );
		$numbers[ 'num_' . $n . '_unit' ]  = array( 'text', __( 'واحد (اختیاری)', 'enteghalino' ), $num[2] );
		$numbers[ 'num_' . $n . '_text' ]  = array( 'text', __( 'توضیح', 'enteghalino' ), $num[3] );
	}
	$schema['numbers'] = array(
		'title'       => __( 'عددها', 'enteghalino' ),
		'description' => __( 'کارتی که عددش خالی باشد نمایش داده نمی‌شود.', 'enteghalino' ),
		'target'      => '.numbers',
		'fields'      => $numbers,
	);

	// ---------- پرسش‌ها ----------
	$qa  = array(
		array( 'آیا اطلاعات فعلی سایت مقصد پاک می‌شود؟', 'نه. داده‌ها کنار محتوای فعلی اضافه می‌شوند. برگه‌ی فروشگاه و سبد خرید با برگه‌ی هم‌نقشی که در مقصد هست یکی می‌شود و اگر فایلی هم‌نام در رسانه‌ها باشد، فایل تازه با نام دیگری ذخیره می‌شود. برای انتقال دوباره، حالت «بروزرسانی» هم هست که موارد قبلاً منتقل‌شده را به‌روز می‌کند و نسخه‌ی تکراری نمی‌سازد.' ),
		array( 'هاست من محدودیت زمان و آپلود دارد. مشکلی پیش می‌آید؟', 'انتقالینو برای همین هاست‌ها ساخته شده است. هر درخواست در کمتر از ۲۵ ثانیه تمام می‌شود و بسته تکه‌به‌تکه آپلود می‌شود، پس محدودیت حجم آپلود و زمان اجرای PHP مانع کار نیست.' ),
		array( 'اگر وسط کار اینترنت قطع شود چه؟', 'صفحه‌ی گزارش‌ها را باز کنید و «ادامه در این صفحه» را بزنید. کار از آخرین تکه ادامه پیدا می‌کند. در اتصال مستقیم، ارسال تا ۱۵ دقیقه خودش دوباره تلاش می‌کند و اگر شبکه برنگشت، دکمه‌ی «ادامه‌ی ارسال» ظاهر می‌شود.' ),
		array( 'بدون ووکامرس هم کار می‌کند؟', 'بله. روی سایتی که ووکامرس ندارد، بخش‌های محصول و سفارش اصلاً نمایش داده نمی‌شوند و بقیه‌ی انتقال مثل همیشه انجام می‌شود.' ),
		array( 'کلید اتصال مستقیم امن است؟', 'هر کس کلید را داشته باشد می‌تواند روی سایت مقصد داده وارد کند، حتی کاربر مدیر. پس آن را مثل رمز عبور نگه دارید و بعد از انتقال، از صفحه‌ی «اتصال سایت‌ها» کلید تازه بسازید تا کلید قبلی باطل شود.' ),
	);
	$faq = array(
		'show_faq'   => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
		'faq_kicker' => array( 'text', __( 'برچسب بالای عنوان', 'enteghalino' ), 'قبل از شروع' ),
		'faq_title'  => array( 'text', __( 'عنوان بخش', 'enteghalino' ), 'پرسش‌های *پرتکرار*', $hint_mark ),
	);
	for ( $n = 1; $n <= ENTEGHALINO_FAQ_MAX; $n++ ) {
		$pair = isset( $qa[ $n - 1 ] ) ? $qa[ $n - 1 ] : array( '', '' );
		/* translators: %s: شماره‌ی پرسش */
		$faq[ '_h_faq_' . $n ]     = array( 'heading', sprintf( __( 'پرسش %s', 'enteghalino' ), enteghalino_fa( $n ) ) );
		$faq[ 'faq_' . $n . '_q' ] = array( 'text', __( 'پرسش', 'enteghalino' ), $pair[0] );
		$faq[ 'faq_' . $n . '_a' ] = array( 'textarea', __( 'پاسخ', 'enteghalino' ), $pair[1] );
	}
	$schema['faq'] = array(
		'title'       => __( 'پرسش‌های پرتکرار', 'enteghalino' ),
		/* translators: %s: بیشترین تعداد پرسش */
		'description' => sprintf( __( 'تا %s پرسش؛ پرسشی که خالی باشد نمایش داده نمی‌شود.', 'enteghalino' ), enteghalino_fa( ENTEGHALINO_FAQ_MAX ) ),
		'target'      => '#faq',
		'fields'      => $faq,
	);

	// ---------- دعوت به نصب ----------
	$schema['cta'] = array(
		'title'  => __( 'دعوت به نصب (پایان صفحه)', 'enteghalino' ),
		'target' => '#get',
		'fields' => array(
			'show_cta'         => array( 'checkbox', __( 'نمایش این بخش', 'enteghalino' ), true ),
			'cta_kicker'       => array( 'text', __( 'برچسب بالای عنوان', 'enteghalino' ), 'شروع انتقال' ),
			'cta_title'        => array( 'text', __( 'عنوان', 'enteghalino' ), 'افزونه را روی *هر دو سایت* نصب کنید', $hint_mark ),
			'cta_btn'          => array( 'text', __( 'متن دکمه', 'enteghalino' ), 'دریافت از گیت‌هاب', __( 'لینک دکمه همان «لینک دریافت افزونه» در بخش عمومی است.', 'enteghalino' ) ),
			'cta_reqs'         => array( 'lines', __( 'نیازمندی‌ها', 'enteghalino' ), "وردپرس 5.8+\nPHP 7.4+\nووکامرس اختیاری", $hint_lines ),
			'_h_cta_1'         => array( 'heading', __( 'قدم ۱', 'enteghalino' ) ),
			'cta_step_1_title' => array( 'text', __( 'عنوان', 'enteghalino' ), 'در سایت قدیم' ),
			'cta_step_1_role'  => array( 'text', __( 'برچسب', 'enteghalino' ), 'مبدأ' ),
			'cta_step_1_text'  => array( 'text', __( 'توضیح', 'enteghalino' ), 'از منوی انتقالینو [خروجی گرفتن] را بزنید', $hint_chip, 'postMessage', null, 'chip' ),
			'_h_cta_2'         => array( 'heading', __( 'قدم ۲', 'enteghalino' ) ),
			'cta_step_2_title' => array( 'text', __( 'عنوان', 'enteghalino' ), 'در سایت جدید' ),
			'cta_step_2_role'  => array( 'text', __( 'برچسب', 'enteghalino' ), 'مقصد' ),
			'cta_step_2_text'  => array( 'text', __( 'توضیح', 'enteghalino' ), '[ایمپورت] را بزنید', $hint_chip, 'postMessage', null, 'chip' ),
			'cta_tip'          => array( 'textarea', __( 'نکته‌ی پایانی', 'enteghalino' ), 'اگر هر دو سایت آنلاین‌اند، اتصال مستقیم کار را یک مرحله کوتاه‌تر می‌کند.' ),
		),
	);

	// ---------- پانویس ----------
	$schema['footer'] = array(
		'title'  => __( 'پانویس', 'enteghalino' ),
		'target' => '.foot',
		'fields' => array(
			'team_name'   => array( 'text', __( 'نام سازنده', 'enteghalino' ), 'تیم پیکسی' ),
			'team_url'    => array( 'url', __( 'لینک سازنده', 'enteghalino' ), 'https://github.com/pixitm' ),
			'footer_text' => array( 'text', __( 'متن اضافه (اختیاری)', 'enteghalino' ), '', __( 'مثلاً حق نشر؛ کنار نسخه نمایش داده می‌شود.', 'enteghalino' ) ),
		),
	);

	// شکل کامل هر فیلد: type, label, default, description, transport, choices, fmt.
	foreach ( $schema as $sid => $section ) {
		foreach ( $section['fields'] as $key => $f ) {
			$type = $f[0];
			$schema[ $sid ]['fields'][ $key ] = array(
				'type'        => $type,
				'label'       => $f[1],
				'default'     => isset( $f[2] ) ? $f[2] : '',
				'description' => isset( $f[3] ) ? $f[3] : '',
				'transport'   => isset( $f[4] ) ? $f[4] : ( in_array( $type, array( 'text', 'textarea', 'url', 'color' ), true ) ? 'postMessage' : 'refresh' ),
				'choices'     => isset( $f[5] ) ? $f[5] : array(),
				'fmt'         => isset( $f[6] ) ? $f[6] : '',
			);
		}
	}

	return $schema;
}

/**
 * همه‌ی فیلدها، بدون ساختار بخش‌ها.
 *
 * @return array
 */
function enteghalino_fields() {
	static $fields = null;
	if ( null === $fields ) {
		$fields = array();
		foreach ( enteghalino_schema() as $section ) {
			foreach ( $section['fields'] as $key => $field ) {
				if ( 'heading' !== $field['type'] ) {
					$fields[ $key ] = $field;
				}
			}
		}
	}
	return $fields;
}

/**
 * خواندن یک تنظیم. اگر کاربر چیزی ذخیره نکرده باشد، پیش‌فرض برمی‌گردد.
 *
 * @param string $key کلید تنظیم.
 * @return mixed
 */
function enteghalino_opt( $key ) {
	$fields  = enteghalino_fields();
	$default = isset( $fields[ $key ] ) ? $fields[ $key ]['default'] : '';
	return get_theme_mod( 'enteghalino_' . $key, $default );
}

/**
 * فهرست خط‌به‌خط یک تنظیم چندخطی.
 *
 * @param string $key کلید تنظیم.
 * @return string[]
 */
function enteghalino_lines( $key ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) enteghalino_opt( $key ) );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/**
 * فهرست جفت «عنوان | توضیح».
 *
 * @param string $key کلید تنظیم.
 * @return array[] هر مورد: array( عنوان، توضیح ).
 */
function enteghalino_pairs( $key ) {
	$out = array();
	foreach ( enteghalino_lines( $key ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$out[] = array( $parts[0], isset( $parts[1] ) ? $parts[1] : '' );
	}
	return $out;
}

/**
 * عدد به رقم فارسی.
 *
 * @param int|string $n عدد.
 * @return string
 */
function enteghalino_fa( $n ) {
	return strtr( (string) $n, array( '0' => '۰', '1' => '۱', '2' => '۲', '3' => '۳', '4' => '۴', '5' => '۵', '6' => '۶', '7' => '۷', '8' => '۸', '9' => '۹' ) );
}

/**
 * عبارت‌های لاتین (نام افزونه، نسخه، دامنه) را جدا می‌کند تا در متن راست‌چین جابه‌جا نشوند.
 *
 * @param string $text متن خام.
 * @return string HTML امن.
 */
function enteghalino_bidi( $text ) {
	$parts = preg_split( '/([A-Za-z0-9][A-Za-z0-9.+\-_\/@:%]*(?: +[A-Za-z0-9][A-Za-z0-9.+\-_\/@:%]*)*)/u', (string) $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	$html  = '';
	foreach ( $parts as $i => $part ) {
		if ( '' === $part ) {
			continue;
		}
		$html .= $i % 2 ? '<bdi>' . esc_html( $part ) . '</bdi>' : esc_html( $part );
	}
	return $html;
}

/**
 * قالب‌بندی متن تنظیمات: *برجسته* و [دکمه] و جداسازی عبارت‌های لاتین. خروجی امن است.
 *
 * همین قاعده‌ها در assets/js/customizer-preview.js برای پیش‌نمایش زنده تکرار شده‌اند.
 *
 * @param string $text  متن خام.
 * @param string $fmt   chip برای فعال کردن [دکمه].
 * @return string
 */
function enteghalino_fmt( $text, $fmt = '' ) {
	$pattern = 'chip' === $fmt ? '/(\*[^*\n]+\*|\[[^\]\n]+\])/u' : '/(\*[^*\n]+\*)/u';
	$parts   = preg_split( $pattern, (string) $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	$html    = '';
	foreach ( $parts as $i => $part ) {
		if ( '' === $part ) {
			continue;
		}
		if ( $i % 2 && '*' === $part[0] ) {
			$html .= '<mark>' . enteghalino_bidi( substr( $part, 1, -1 ) ) . '</mark>';
		} elseif ( $i % 2 ) {
			$html .= '<span class="cs-btn">' . enteghalino_bidi( substr( $part, 1, -1 ) ) . '</span>';
		} else {
			$html .= enteghalino_bidi( $part );
		}
	}
	return $html;
}

/**
 * چاپ یک تنظیم متنی قالب‌بندی‌شده.
 *
 * @param string $key کلید تنظیم.
 */
function enteghalino_e( $key ) {
	$fields = enteghalino_fields();
	echo enteghalino_fmt( enteghalino_opt( $key ), isset( $fields[ $key ] ) ? $fields[ $key ]['fmt'] : '' ); // phpcs:ignore WordPress.Security.EscapeOutput -- خروجی enteghalino_fmt امن است.
}

/**
 * ویژگی پیوند پیش‌نمایش زنده؛ فقط داخل سفارشی‌سازی چیزی چاپ می‌کند.
 *
 * @param string $key  کلید تنظیم.
 * @param string $kind text یا href.
 */
function enteghalino_bind( $key, $kind = 'text' ) {
	if ( is_customize_preview() ) {
		printf( ' data-ent%s="%s"', 'href' === $kind ? '-href' : '', esc_attr( $key ) );
	}
}

/**
 * لینک یک تنظیم؛ لنگرهای #بخش در برگه‌های دیگر به صفحه‌ی اول برمی‌گردند.
 *
 * @param string $key کلید تنظیم.
 * @return string
 */
function enteghalino_link( $key ) {
	$url = (string) enteghalino_opt( $key );
	return ( '' !== $url && '#' === $url[0] ) ? enteghalino_anchor( substr( $url, 1 ) ) : $url;
}

/**
 * آیا لینک یک تنظیم به بخشی می‌رود که پنهان شده؟ (در آن صورت دکمه نمایش داده نمی‌شود)
 *
 * @param string $key کلید تنظیم لینک.
 * @return bool
 */
function enteghalino_link_ok( $key ) {
	$url  = (string) enteghalino_opt( $key );
	$map  = array( '#story' => 'story', '#manifest' => 'manifest', '#faq' => 'faq', '#get' => 'cta' );
	return '' !== $url && ( ! isset( $map[ $url ] ) || enteghalino_show( $map[ $url ] ) );
}

/**
 * آیا این بخش لندینگ نمایش داده شود؟
 *
 * @param string $part نام بخش (ticker، story، ...).
 * @return bool
 */
function enteghalino_show( $part ) {
	$fields = enteghalino_fields();
	return ! isset( $fields[ 'show_' . $part ] ) || (bool) enteghalino_opt( 'show_' . $part );
}

/* ---------- رنگ‌ها ---------- */

/**
 * هگز به آرایه‌ی RGB.
 *
 * @param string $hex مثل #ffb145.
 * @return int[]
 */
function enteghalino_rgb( $hex ) {
	$hex = ltrim( (string) $hex, '#' );
	if ( 3 === strlen( $hex ) ) {
		$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
	}
	if ( ! preg_match( '/^[0-9a-f]{6}$/i', $hex ) ) {
		$hex = '000000';
	}
	return array_map( 'hexdec', str_split( $hex, 2 ) );
}

/**
 * آرایه‌ی RGB به هگز.
 *
 * @param array $c RGB.
 * @return string
 */
function enteghalino_hex( $c ) {
	return sprintf( '#%02x%02x%02x', round( $c[0] ), round( $c[1] ), round( $c[2] ) );
}

/**
 * ترکیب دو رنگ؛ $t سهم رنگ دوم است.
 *
 * @param array $a RGB.
 * @param array $b RGB.
 * @param float $t ۰ تا ۱.
 * @return array
 */
function enteghalino_mix( $a, $b, $t ) {
	return array( $a[0] + ( $b[0] - $a[0] ) * $t, $a[1] + ( $b[1] - $a[1] ) * $t, $a[2] + ( $b[2] - $a[2] ) * $t );
}

/**
 * روشنایی نسبی (WCAG).
 *
 * @param array $c RGB.
 * @return float
 */
function enteghalino_lum( $c ) {
	$l = array();
	foreach ( $c as $v ) {
		$v   = $v / 255;
		$l[] = $v <= 0.03928 ? $v / 12.92 : pow( ( $v + 0.055 ) / 1.055, 2.4 );
	}
	return 0.2126 * $l[0] + 0.7152 * $l[1] + 0.0722 * $l[2];
}

/**
 * نسبت کنتراست دو رنگ.
 *
 * @param array $a RGB.
 * @param array $b RGB.
 * @return float
 */
function enteghalino_contrast( $a, $b ) {
	$x = enteghalino_lum( $a );
	$y = enteghalino_lum( $b );
	return ( max( $x, $y ) + 0.05 ) / ( min( $x, $y ) + 0.05 );
}

/**
 * متغیرهای رنگی کامل از چهار رنگ پایه. همین محاسبه در پیش‌نمایش زنده (JS) هم انجام می‌شود.
 *
 * @param array $base brand، accent، paper، ink (هگز).
 * @return array نام متغیر => مقدار.
 */
function enteghalino_palette( $base ) {
	$white = array( 255, 255, 255 );
	$paper = enteghalino_rgb( $base['paper'] );
	$ink   = enteghalino_rgb( $base['ink'] );
	$card  = enteghalino_mix( $paper, $white, .65 );
	$vars  = array(
		'paper'   => enteghalino_hex( $paper ),
		'paper-2' => enteghalino_hex( enteghalino_mix( $paper, $ink, .05 ) ),
		'card'    => enteghalino_hex( $card ),
		'ink'     => enteghalino_hex( $ink ),
		'ink-2'   => enteghalino_hex( enteghalino_mix( $ink, $paper, .24 ) ),
		'ink-3'   => enteghalino_hex( enteghalino_mix( $ink, $paper, .4 ) ),
		'line'    => enteghalino_hex( enteghalino_mix( $paper, $ink, .14 ) ),
		'paper-rgb' => implode( ' ', array_map( 'round', $paper ) ),
		'ink-rgb'   => implode( ' ', array_map( 'round', $ink ) ),
	);

	foreach ( array( 'brand', 'accent' ) as $name ) {
		$c = enteghalino_rgb( $base[ $name ] );
		// نسخه‌ی تیره‌تر برای متن روی زمینه‌ی روشن: کمترین تیرگی که کنتراست ۴٫۵ بدهد.
		$text = $c;
		for ( $t = 0; $t <= 1.001 && enteghalino_contrast( $text, $card ) < 4.5; $t += .05 ) {
			$text = enteghalino_mix( $c, $ink, $t );
		}
		$vars[ $name ]              = enteghalino_hex( $c );
		$vars[ $name . '-ink' ]     = enteghalino_hex( $text );
		$vars[ $name . '-soft' ]    = enteghalino_hex( enteghalino_mix( $card, $c, .26 ) );
		$vars[ $name . '-rgb' ]     = implode( ' ', $c );
		$vars[ 'on-' . $name ]      = enteghalino_contrast( $c, $ink ) >= enteghalino_contrast( $c, $white ) ? enteghalino_hex( $ink ) : '#ffffff';
	}
	return $vars;
}

/**
 * پالت فعلی بر اساس تنظیمات.
 *
 * @return array
 */
function enteghalino_current_palette() {
	$base = array();
	foreach ( array( 'brand', 'accent', 'paper', 'ink' ) as $name ) {
		$base[ $name ] = enteghalino_opt( 'color_' . $name );
	}
	return enteghalino_palette( $base );
}

/**
 * CSS متغیرهای رنگی.
 *
 * @return string
 */
function enteghalino_palette_css() {
	$css = '';
	foreach ( enteghalino_current_palette() as $k => $v ) {
		$css .= '--' . $k . ':' . $v . ';';
	}
	return ':root{' . $css . '}';
}
