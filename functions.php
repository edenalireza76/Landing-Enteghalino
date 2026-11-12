<?php
/**
 * قالب لندینگ انتقالینو
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

define( 'ENTEGHALINO_FAQ_MAX', 8 );

require get_template_directory() . '/inc/options.php';
require get_template_directory() . '/inc/customizer.php';

/**
 * امکانات قالب.
 */
function enteghalino_setup() {
	load_theme_textdomain( 'enteghalino', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'script', 'style', 'search-form', 'gallery', 'caption', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	register_nav_menus(
		array(
			'primary' => __( 'منوی بالای لندینگ', 'enteghalino' ),
		)
	);
}
add_action( 'after_setup_theme', 'enteghalino_setup' );

/**
 * نسخه‌ی فایل‌ها برای شکستن کش مرورگر.
 */
function enteghalino_asset_version() {
	return wp_get_theme( get_template() )->get( 'Version' );
}

/**
 * بارگذاری استایل و اسکریپت، و رنگ‌های انتخاب‌شده به‌صورت متغیر CSS.
 */
function enteghalino_assets() {
	$ver = enteghalino_asset_version();
	wp_enqueue_style( 'enteghalino', get_theme_file_uri( 'assets/css/landing.css' ), array(), $ver );
	wp_add_inline_style( 'enteghalino', enteghalino_palette_css() );
	wp_enqueue_script(
		'enteghalino',
		get_theme_file_uri( 'assets/js/landing.js' ),
		array(),
		$ver,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// لندینگ از بلوک‌های وردپرس استفاده نمی‌کند؛ استایل‌هایشان فقط حجم اضافه است.
	if ( is_front_page() ) {
		wp_dequeue_style( 'wp-block-library' );
		wp_dequeue_style( 'wp-block-library-theme' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_dequeue_style( 'global-styles' );
	}
}
add_action( 'wp_enqueue_scripts', 'enteghalino_assets', 100 );

/**
 * در صفحه‌ی اول، اسکریپت و استایل ایموجی وردپرس لازم نیست.
 */
function enteghalino_trim_head() {
	if ( is_front_page() ) {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
	}
}
add_action( 'wp', 'enteghalino_trim_head' );

/**
 * پیش‌بارگذاری فونت، رنگ نوار مرورگر و کلاس‌های js، پیش از هر چیز در head.
 */
function enteghalino_head() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_theme_file_uri( 'assets/fonts/Vazirmatn-Variable.woff2' ) )
	);
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( enteghalino_opt( 'color_paper' ) ) );

	$classes = array( 'js' );
	if ( ! enteghalino_opt( 'cursor' ) ) {
		$classes[] = 'no-cursor';
	}
	if ( ! enteghalino_opt( 'reveal' ) ) {
		$classes[] = 'no-reveal';
	}
	printf( "<script>document.documentElement.className+=' %s';</script>\n", esc_js( implode( ' ', $classes ) ) );

	// اگر افزونه‌ی سئو فعال نیست، توضیح صفحه‌ی اول را خود قالب می‌نویسد.
	if ( is_front_page() && ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) && ! defined( 'AIOSEO_VERSION' ) ) {
		$desc = trim( (string) enteghalino_opt( 'meta_description' ) );
		if ( '' !== $desc ) {
			printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
		}
	}
}
add_action( 'wp_head', 'enteghalino_head', 1 );

/**
 * لندینگ راست‌چین طراحی شده؛ حتی اگر زبان سایت فارسی نباشد.
 *
 * @param string $output ویژگی‌های تگ html.
 * @return string
 */
function enteghalino_language_attributes( $output ) {
	if ( false === strpos( $output, 'dir=' ) ) {
		$output .= ' dir="rtl"';
	}
	return $output;
}
add_filter( 'language_attributes', 'enteghalino_language_attributes' );

/**
 * آدرس یک لنگر لندینگ؛ در برگه‌های دیگر به صفحه‌ی اول برمی‌گردد.
 *
 * @param string $anchor مثل story.
 * @return string
 */
function enteghalino_anchor( $anchor ) {
	return ( is_front_page() ? '' : home_url( '/' ) ) . '#' . $anchor;
}

/**
 * پیوندهای منوی بالا. اگر در «نمایش › فهرست‌ها» منویی به این جایگاه داده شود، همان نمایش داده می‌شود.
 */
function enteghalino_nav_links() {
	$locations = get_nav_menu_locations();
	$items     = ! empty( $locations['primary'] ) ? wp_get_nav_menu_items( $locations['primary'] ) : array();

	if ( $items ) {
		foreach ( $items as $item ) {
			if ( (int) $item->menu_item_parent ) {
				continue; // منوی بالا یک‌سطحی است.
			}
			printf( '<a href="%s">%s</a>' . "\n", esc_url( $item->url ), esc_html( $item->title ) );
		}
		return;
	}

	$defaults = array(
		array( 'story', 'i-route', 'nav_1' ),
		array( 'manifest', 'i-package', 'nav_2' ),
		array( 'faq', 'i-help', 'nav_3' ),
	);
	foreach ( $defaults as $link ) {
		// پیوند بخشی که پنهان شده یا متنش خالی است، نمایش داده نمی‌شود.
		if ( ! enteghalino_show( $link[0] ) || '' === trim( (string) enteghalino_opt( $link[2] ) ) ) {
			continue;
		}
		printf(
			'<a href="%1$s"><svg class="ic" aria-hidden="true"><use href="#%2$s"/></svg><span%3$s>%4$s</span></a>' . "\n",
			esc_url( enteghalino_anchor( $link[0] ) ),
			esc_attr( $link[1] ),
			is_customize_preview() ? ' data-ent="' . esc_attr( $link[2] ) . '"' : '',
			enteghalino_fmt( enteghalino_opt( $link[2] ) ) // phpcs:ignore WordPress.Security.EscapeOutput -- خروجی امن است.
		);
	}
}
