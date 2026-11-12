<?php
/**
 * سرتیتر مشترک سکشن‌ها: آیکون، برچسب و عنوان.
 *
 * آرگومان‌ها: key (پیشوند تنظیم‌ها، مثل faq برای faq_kicker و faq_title) و icon.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

$enteghalino_key = isset( $args['key'] ) ? $args['key'] : '';
?>
<header class="sec-head">
	<p class="kicker"><span class="sec-icon"><svg class="ic" aria-hidden="true"><use href="#<?php echo esc_attr( $args['icon'] ); ?>"/></svg></span><span<?php enteghalino_bind( $enteghalino_key . '_kicker' ); ?>><?php enteghalino_e( $enteghalino_key . '_kicker' ); ?></span></p>
	<h2<?php enteghalino_bind( $enteghalino_key . '_title' ); ?>><?php enteghalino_e( $enteghalino_key . '_title' ); ?></h2>
</header>
