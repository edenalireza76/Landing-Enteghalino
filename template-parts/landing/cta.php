<?php
/**
 * دعوت به نصب افزونه
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- ============ CTA ============ -->
<section class="cta" id="get">
	<div class="cta-card">
		<div class="cta-copy">
			<?php get_template_part( 'template-parts/sec-head', null, array( 'key' => 'cta', 'icon' => 'i-rocket' ) ); ?>
			<div class="cta-actions">
				<a class="btn btn-signal" href="<?php echo esc_url( enteghalino_opt( 'download_url' ) ); ?>"<?php enteghalino_bind( 'download_url', 'href' ); ?>><svg class="ic" aria-hidden="true"><use href="#i-github"/></svg><span<?php enteghalino_bind( 'cta_btn' ); ?>><?php enteghalino_e( 'cta_btn' ); ?></span></a>
			</div>
			<?php $enteghalino_reqs = enteghalino_lines( 'cta_reqs' ); ?>
			<?php if ( $enteghalino_reqs ) : ?>
				<ul class="cta-req">
					<?php foreach ( $enteghalino_reqs as $enteghalino_req ) : ?>
						<li><svg class="ic" aria-hidden="true"><use href="#i-check"/></svg><span><?php echo enteghalino_fmt( $enteghalino_req ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<!-- همان دو پنل هیرو، این بار به‌صورت دو قدم -->
		<div class="cta-steps">
			<ol>
				<?php foreach ( array( 1 => 'src', 2 => 'dst' ) as $enteghalino_n => $enteghalino_side ) : ?>
					<?php $enteghalino_k = 'cta_step_' . $enteghalino_n . '_'; ?>
					<li class="cs cs-<?php echo esc_attr( $enteghalino_side ); ?>">
						<span class="cs-no mono" aria-hidden="true"><?php echo esc_html( enteghalino_fa( $enteghalino_n ) ); ?></span>
						<div class="cs-body">
							<div class="cs-top"><b<?php enteghalino_bind( $enteghalino_k . 'title' ); ?>><?php enteghalino_e( $enteghalino_k . 'title' ); ?></b><span class="cs-role"<?php enteghalino_bind( $enteghalino_k . 'role' ); ?>><?php enteghalino_e( $enteghalino_k . 'role' ); ?></span></div>
							<p<?php enteghalino_bind( $enteghalino_k . 'text' ); ?>><?php enteghalino_e( $enteghalino_k . 'text' ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
			<?php if ( '' !== trim( (string) enteghalino_opt( 'cta_tip' ) ) ) : ?>
				<p class="cs-tip"><svg class="ic" aria-hidden="true"><use href="#i-link"/></svg><span<?php enteghalino_bind( 'cta_tip' ); ?>><?php enteghalino_e( 'cta_tip' ); ?></span></p>
			<?php endif; ?>
		</div>
	</div>
</section>
