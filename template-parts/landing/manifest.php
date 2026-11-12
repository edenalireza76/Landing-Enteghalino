<?php
/**
 * فهرست چیزهایی که منتقل می‌شود
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- ============ MANIFEST ============ -->
<section class="manifest" id="manifest">
	<div class="manifest-paper">
		<div class="mf-head">
			<?php get_template_part( 'template-parts/sec-head', null, array( 'key' => 'mf', 'icon' => 'i-package' ) ); ?>
			<?php if ( '' !== trim( (string) enteghalino_opt( 'mf_file' ) ) ) : ?>
				<span class="mono mf-file"><svg class="ic" aria-hidden="true"><use href="#i-code"/></svg><bdi<?php enteghalino_bind( 'mf_file' ); ?>><?php echo esc_html( enteghalino_opt( 'mf_file' ) ); ?></bdi></span>
			<?php endif; ?>
		</div>
		<div class="mf-cols">
			<?php foreach ( array( 'mf_col_1', 'mf_col_2' ) as $enteghalino_col ) : ?>
				<ul class="mf-list">
					<?php foreach ( enteghalino_pairs( $enteghalino_col ) as $enteghalino_row ) : ?>
						<li>
							<span class="mf-ic" aria-hidden="true"><svg class="ic"><use href="#i-check"/></svg></span>
							<span class="mf-name"><?php echo enteghalino_fmt( $enteghalino_row[0] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<?php if ( '' !== $enteghalino_row[1] ) : ?>
								<i aria-hidden="true"></i><b><?php echo enteghalino_fmt( $enteghalino_row[1] ); // phpcs:ignore WordPress.Security.EscapeOutput ?></b>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endforeach; ?>
		</div>
		<?php if ( '' !== trim( (string) enteghalino_opt( 'mf_note' ) ) ) : ?>
			<p class="mf-note"<?php enteghalino_bind( 'mf_note' ); ?>><?php enteghalino_e( 'mf_note' ); ?></p>
		<?php endif; ?>
	</div>
</section>
