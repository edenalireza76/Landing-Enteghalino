<?php
/**
 * چند عدد کلیدی
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

$enteghalino_cards = array();
for ( $enteghalino_n = 1; $enteghalino_n <= 4; $enteghalino_n++ ) {
	if ( '' !== trim( (string) enteghalino_opt( 'num_' . $enteghalino_n . '_value' ) ) ) {
		$enteghalino_cards[] = $enteghalino_n;
	}
}
if ( ! $enteghalino_cards ) {
	return;
}
?>
<!-- ============ NUMBERS ============ -->
<section class="numbers" data-count="<?php echo esc_attr( count( $enteghalino_cards ) ); ?>">
	<?php foreach ( $enteghalino_cards as $enteghalino_n ) : ?>
		<?php $enteghalino_k = 'num_' . $enteghalino_n . '_'; ?>
		<div class="num">
			<span class="num-ic"><svg class="ic" aria-hidden="true"><use href="#<?php echo esc_attr( enteghalino_opt( $enteghalino_k . 'icon' ) ); ?>"/></svg></span>
			<b><span<?php enteghalino_bind( $enteghalino_k . 'value' ); ?>><?php enteghalino_e( $enteghalino_k . 'value' ); ?></span><small<?php enteghalino_bind( $enteghalino_k . 'unit' ); ?>><?php enteghalino_e( $enteghalino_k . 'unit' ); ?></small></b>
			<span class="num-text"<?php enteghalino_bind( $enteghalino_k . 'text' ); ?>><?php enteghalino_e( $enteghalino_k . 'text' ); ?></span>
		</div>
	<?php endforeach; ?>
</section>
