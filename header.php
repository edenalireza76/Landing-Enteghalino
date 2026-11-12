<?php
/**
 * سربرگ: head، آیکون‌ها و منوی بالا.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#content"><?php esc_html_e( 'رفتن به محتوا', 'enteghalino' ); ?></a>

<?php get_template_part( 'template-parts/icons' ); ?>

<header class="top">
	<div class="top-in">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="brand-mark" aria-hidden="true"><i></i><i></i></span>
			<span<?php enteghalino_bind( 'brand_name' ); ?>><?php enteghalino_e( 'brand_name' ); ?></span>
		</a>
		<nav class="top-nav" id="top-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'enteghalino' ); ?>">
			<span class="nav-glider" aria-hidden="true"></span>
			<?php enteghalino_nav_links(); ?>
		</nav>
		<div class="top-end">
			<?php $enteghalino_btn = trim( (string) enteghalino_opt( 'header_btn' ) ); ?>
			<?php if ( enteghalino_link_ok( 'header_btn_url' ) ) : ?>
			<a class="btn btn-signal btn-sm" href="<?php echo esc_url( enteghalino_link( 'header_btn_url' ) ); ?>"<?php enteghalino_bind( 'header_btn_url', 'href' ); ?> aria-label="<?php echo esc_attr( str_replace( array( '*', '[', ']' ), '', $enteghalino_btn ) ); ?>"><svg class="ic" aria-hidden="true"><use href="#i-download"/></svg><span class="hide-xs"<?php enteghalino_bind( 'header_btn' ); ?>><?php enteghalino_e( 'header_btn' ); ?></span></a>
			<?php endif; ?>
			<button class="menu-toggle" type="button" aria-controls="top-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'باز کردن منو', 'enteghalino' ); ?>">
				<svg class="ic" aria-hidden="true"><use href="#i-menu"/></svg>
			</button>
		</div>
	</div>
</header>
