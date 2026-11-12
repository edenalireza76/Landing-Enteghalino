<?php
/**
 * نوار متحرک بخش‌های قابل انتقال
 *
 * فهرست دو بار چاپ می‌شود تا حرکت بی‌درز باشد.
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;

$enteghalino_items = enteghalino_lines( 'ticker_items' );
if ( ! $enteghalino_items ) {
	return;
}
?>
<div class="ticker-wrap">
	<div class="ticker" aria-hidden="true">
		<div class="ticker-in">
			<?php for ( $enteghalino_i = 0; $enteghalino_i < 2; $enteghalino_i++ ) : ?>
				<?php foreach ( $enteghalino_items as $enteghalino_item ) : ?>
					<span><?php echo enteghalino_fmt( $enteghalino_item ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
</div>
