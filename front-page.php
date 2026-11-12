<?php
/**
 * صفحه‌ی اول: لندینگ انتقالینو.
 *
 * هر بخش را می‌توان در «سفارشی‌سازی › لندینگ انتقالینو» پنهان کرد.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

get_header();

echo '<main id="content">';
foreach ( array( 'hero', 'ticker', 'story', 'manifest', 'numbers', 'faq', 'cta' ) as $enteghalino_part ) {
	if ( enteghalino_show( $enteghalino_part ) ) {
		get_template_part( 'template-parts/landing/' . $enteghalino_part );
	}
}
echo '</main>';

get_footer();
