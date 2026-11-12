<?php
/**
 * پانویس: نسخه و سازنده.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="foot">
	<div class="foot-in">
		<a class="brand brand-sm" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="brand-mark" aria-hidden="true"><i></i><i></i></span><span<?php enteghalino_bind( 'brand_name' ); ?>><?php enteghalino_e( 'brand_name' ); ?></span></a>
		<span class="foot-ver"><?php esc_html_e( 'نسخه‌ی', 'enteghalino' ); ?> <bdi<?php enteghalino_bind( 'version' ); ?>><?php echo esc_html( enteghalino_opt( 'version' ) ); ?></bdi></span>
		<?php if ( '' !== trim( (string) enteghalino_opt( 'footer_text' ) ) || is_customize_preview() ) : ?>
			<span class="foot-text"<?php enteghalino_bind( 'footer_text' ); ?>><?php enteghalino_e( 'footer_text' ); ?></span>
		<?php endif; ?>
		<?php if ( '' !== trim( (string) enteghalino_opt( 'team_name' ) ) ) : ?>
			<a class="foot-team" href="<?php echo esc_url( enteghalino_opt( 'team_url' ) ); ?>"<?php enteghalino_bind( 'team_url', 'href' ); ?>><svg class="ic" aria-hidden="true"><use href="#i-github"/></svg><span><?php esc_html_e( 'ساخته‌ی', 'enteghalino' ); ?> <span<?php enteghalino_bind( 'team_name' ); ?>><?php enteghalino_e( 'team_name' ); ?></span></span></a>
		<?php endif; ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
