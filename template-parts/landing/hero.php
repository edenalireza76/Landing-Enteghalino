<?php
/**
 * هیرو: پیام اصلی و انیمیشن انتقال از مبدأ به مقصد
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- ============ HERO ============ -->
<section class="hero">
	<div class="hero-in">
		<div class="hero-copy">
			<p class="hero-label">
				<span class="hero-label-dot" aria-hidden="true"></span>
				<span<?php enteghalino_bind( 'hero_label' ); ?>><?php enteghalino_e( 'hero_label' ); ?></span>
				<?php if ( enteghalino_opt( 'hero_show_version' ) ) : ?>
					<span class="hero-label-ver"><?php esc_html_e( 'نسخه‌ی', 'enteghalino' ); ?> <bdi<?php enteghalino_bind( 'version' ); ?>><?php echo esc_html( enteghalino_opt( 'version' ) ); ?></bdi></span>
				<?php endif; ?>
			</p>
			<h1 class="hero-title">
				<span class="hl"<?php enteghalino_bind( 'hero_title_1' ); ?>><?php enteghalino_e( 'hero_title_1' ); ?></span>
				<span class="hl"<?php enteghalino_bind( 'hero_title_2' ); ?>><?php enteghalino_e( 'hero_title_2' ); ?></span>
				<em class="hl"><span<?php enteghalino_bind( 'hero_title_3' ); ?>><?php enteghalino_e( 'hero_title_3' ); ?></span></em>
			</h1>
			<p class="lead"<?php enteghalino_bind( 'hero_lead' ); ?>><?php enteghalino_e( 'hero_lead' ); ?></p>
			<div class="hero-actions">
				<?php if ( '' !== trim( (string) enteghalino_opt( 'hero_btn_1' ) ) && enteghalino_link_ok( 'hero_btn_1_url' ) ) : ?>
					<a class="btn btn-signal" href="<?php echo esc_url( enteghalino_link( 'hero_btn_1_url' ) ); ?>"<?php enteghalino_bind( 'hero_btn_1_url', 'href' ); ?>><svg class="ic" aria-hidden="true"><use href="#i-download"/></svg><span<?php enteghalino_bind( 'hero_btn_1' ); ?>><?php enteghalino_e( 'hero_btn_1' ); ?></span></a>
				<?php endif; ?>
				<?php if ( '' !== trim( (string) enteghalino_opt( 'hero_btn_2' ) ) && enteghalino_link_ok( 'hero_btn_2_url' ) ) : ?>
					<a class="btn btn-ghost" href="<?php echo esc_url( enteghalino_link( 'hero_btn_2_url' ) ); ?>"<?php enteghalino_bind( 'hero_btn_2_url', 'href' ); ?>><span<?php enteghalino_bind( 'hero_btn_2' ); ?>><?php enteghalino_e( 'hero_btn_2' ); ?></span> <svg class="ic arrow" aria-hidden="true"><use href="#i-arrow-down"/></svg></a>
				<?php endif; ?>
			</div>
			<?php $enteghalino_points = enteghalino_lines( 'hero_points' ); ?>
			<?php if ( $enteghalino_points ) : ?>
				<ul class="hero-points">
					<?php foreach ( $enteghalino_points as $enteghalino_point ) : ?>
						<li><svg class="ic" aria-hidden="true"><use href="#i-check"/></svg><span><?php echo enteghalino_fmt( $enteghalino_point ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<!-- انتقال: از پنل سایت مبدأ، تکه‌به‌تکه به پنل سایت مقصد -->
		<div class="hero-visual">
			<div class="mig" role="img" aria-label="<?php
				/* translators: 1: دامنه‌ی مبدأ 2: دامنه‌ی مقصد */
				echo esc_attr( sprintf( __( 'داده‌ها تکه‌به‌تکه از سایت مبدأ %1$s به سایت مقصد %2$s منتقل می‌شوند', 'enteghalino' ), enteghalino_opt( 'hero_src_domain' ), enteghalino_opt( 'hero_dst_domain' ) ) );
			?>">
				<svg class="mig-route" viewBox="0 0 600 560" preserveAspectRatio="none" aria-hidden="true">
					<path class="route-base" d="M204 124 C 140 124, 118 200, 118 316"/>
					<path class="route-trail" d="M204 124 C 140 124, 118 200, 118 316"/>
					<circle class="port port-out" cx="204" cy="124" r="5"/>
					<circle class="port port-in" cx="118" cy="316" r="5"/>
				</svg>

				<div class="win win-src" aria-hidden="true">
					<div class="win-bar">
						<span class="win-dots"><i></i><i></i><i></i></span>
						<span class="win-url"><bdi<?php enteghalino_bind( 'hero_src_domain' ); ?>><?php echo esc_html( enteghalino_opt( 'hero_src_domain' ) ); ?></bdi></span>
						<span class="win-role">مبدأ</span>
					</div>
					<ul class="src-rows">
						<li class="is-done" data-icon="i-user" data-name="کاربرها" data-file="users" data-n="8">
							<span class="r-ic"><svg class="ic"><use href="#i-user"/></svg></span>
							<span class="r-name">کاربرها</span><span class="r-count mono">۵٬۰۹۷</span>
							<span class="r-bar"><i></i></span>
						</li>
						<li class="is-done" data-icon="i-image" data-name="رسانه" data-file="media" data-n="13">
							<span class="r-ic"><svg class="ic"><use href="#i-image"/></svg></span>
							<span class="r-name">رسانه</span><span class="r-count mono">۳٬۴۶۰</span>
							<span class="r-bar"><i></i></span>
						</li>
						<li class="is-active" data-icon="i-bag" data-name="محصولات" data-file="products" data-n="18">
							<span class="r-ic"><svg class="ic"><use href="#i-bag"/></svg></span>
							<span class="r-name">محصولات</span><span class="r-count mono">۱٬۲۴۰</span>
							<span class="r-bar"><i></i></span>
						</li>
						<li data-icon="i-receipt" data-name="سفارش‌ها" data-file="orders" data-n="1">
							<span class="r-ic"><svg class="ic"><use href="#i-receipt"/></svg></span>
							<span class="r-name">سفارش‌ها</span><span class="r-count mono">۸٬۳۱۲</span>
							<span class="r-bar"><i></i></span>
						</li>
						<li data-icon="i-sliders" data-name="تنظیمات افزونه‌ها" data-file="options" data-n="1">
							<span class="r-ic"><svg class="ic"><use href="#i-sliders"/></svg></span>
							<span class="r-name">تنظیمات افزونه‌ها</span><span class="r-count mono">۹ گروه</span>
							<span class="r-bar"><i></i></span>
						</li>
					</ul>
				</div>

				<div class="win win-dst" aria-hidden="true">
					<div class="win-bar">
						<span class="win-dots"><i></i><i></i><i></i></span>
						<span class="win-url"><bdi<?php enteghalino_bind( 'hero_dst_domain' ); ?>><?php echo esc_html( enteghalino_opt( 'hero_dst_domain' ) ); ?></bdi></span>
						<span class="win-role">مقصد</span>
					</div>
					<ul class="dst-log">
						<li><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span><span class="l-name">رسانه</span><span class="l-file mono ltr">media-0012.json</span></li>
						<li><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span><span class="l-name">رسانه</span><span class="l-file mono ltr">media-0011.json</span></li>
						<li><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span><span class="l-name">کاربرها</span><span class="l-file mono ltr">users-0007.json</span></li>
						<li><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span><span class="l-name">کاربرها</span><span class="l-file mono ltr">users-0006.json</span></li>
					</ul>
					<div class="dst-foot">
						<span>تکه‌ی <b class="mono chunk-n">۱۸</b> از <span class="mono">۴۲</span></span>
						<span class="dst-bar" style="--p:.43"><i></i></span>
					</div>
				</div>

				<div class="packet" aria-hidden="true">
					<span class="pk-ic"><svg class="ic"><use href="#i-bag"/></svg></span>
					<span class="pk-txt"><b>محصولات</b><small class="mono ltr">products-0018.json</small></span>
				</div>
				<i class="trail-dot td1" aria-hidden="true"></i>
				<i class="trail-dot td2" aria-hidden="true"></i>
			</div>
		</div>
	</div>
</section>
