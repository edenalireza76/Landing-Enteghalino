<?php
/**
 * پرسش‌های پرتکرار
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- ============ FAQ ============ -->
<section class="faq" id="faq">
	<?php get_template_part( 'template-parts/sec-head', null, array( 'key' => 'faq', 'icon' => 'i-help' ) ); ?>
	<div class="faq-list">
		<?php
		$enteghalino_no = 0;
		for ( $enteghalino_n = 1; $enteghalino_n <= ENTEGHALINO_FAQ_MAX; $enteghalino_n++ ) :
			$enteghalino_q = 'faq_' . $enteghalino_n . '_q';
			if ( '' === trim( (string) enteghalino_opt( $enteghalino_q ) ) ) {
				continue;
			}
			++$enteghalino_no;
			?>
			<details>
				<summary><span class="q-no mono"><?php echo esc_html( enteghalino_fa( sprintf( '%02d', $enteghalino_no ) ) ); ?></span><span class="q-text"<?php enteghalino_bind( $enteghalino_q ); ?>><?php enteghalino_e( $enteghalino_q ); ?></span><span class="q-ic" aria-hidden="true"><svg class="ic"><use href="#i-plus"/></svg></span></summary>
				<p<?php enteghalino_bind( 'faq_' . $enteghalino_n . '_a' ); ?>><?php enteghalino_e( 'faq_' . $enteghalino_n . '_a' ); ?></p>
			</details>
		<?php endfor; ?>
	</div>
</section>
