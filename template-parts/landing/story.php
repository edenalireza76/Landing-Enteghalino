<?php
/**
 * روند کار: هفت ایستگاه با صحنه‌ی چسبان
 *
 * @package Enteghalino
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- ============ STORY (scrollytelling) ============ -->
<section class="story" id="story">
	<?php get_template_part( 'template-parts/sec-head', null, array( 'key' => 'story', 'icon' => 'i-route' ) ); ?>

	<div class="story-grid">
		<div class="steps">
			<div class="rail" aria-hidden="true"><i></i></div>

			<?php
			$enteghalino_icons = array( 1 => 'i-list', 'i-layers', 'i-gauge', 'i-swap', 'i-link', 'i-bell-off', 'i-clipboard' );
			foreach ( $enteghalino_icons as $enteghalino_n => $enteghalino_icon ) :
				$enteghalino_k     = 'step_' . $enteghalino_n . '_';
				$enteghalino_facts = enteghalino_lines( $enteghalino_k . 'facts' );
				?>
				<article class="step" data-step="<?php echo esc_attr( $enteghalino_n ); ?>" data-icon="<?php echo esc_attr( $enteghalino_icon ); ?>">
					<div class="step-card">
						<span class="step-no"><?php echo esc_html( enteghalino_fa( sprintf( '%02d', $enteghalino_n ) ) ); ?><i>/ ۰۷</i></span>
						<h3<?php enteghalino_bind( $enteghalino_k . 'title' ); ?>><?php enteghalino_e( $enteghalino_k . 'title' ); ?></h3>
						<p<?php enteghalino_bind( $enteghalino_k . 'text' ); ?>><?php enteghalino_e( $enteghalino_k . 'text' ); ?></p>
						<?php if ( $enteghalino_facts ) : ?>
							<ul class="facts">
								<?php foreach ( $enteghalino_facts as $enteghalino_fact ) : ?>
									<li><?php echo enteghalino_fmt( $enteghalino_fact ); // phpcs:ignore WordPress.Security.EscapeOutput ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="stage-wrap">
			<div class="stage-sticky">
				<div class="stage" data-active="1">
					<div class="stage-bar" aria-hidden="true">
						<span class="stage-dots"><i></i><i></i><i></i></span>
						<span class="stage-title"><svg class="ic"><use href="#i-list"/></svg><span class="st-text"><?php echo esc_html( wp_strip_all_tags( enteghalino_fmt( enteghalino_opt( 'step_1_title' ) ) ) ); ?></span></span>
						<span class="stage-count mono"><b class="cur">۰۱</b> / ۰۷</span>
					</div>

					<ol class="stage-steps" aria-label="<?php esc_attr_e( 'ایستگاه‌ها', 'enteghalino' ); ?>">
						<?php for ( $enteghalino_n = 1; $enteghalino_n <= 7; $enteghalino_n++ ) : ?>
							<?php $enteghalino_label = (string) enteghalino_opt( 'step_' . $enteghalino_n . '_label' ); ?>
							<li><button type="button" data-go="<?php echo esc_attr( $enteghalino_n ); ?>" data-label="<?php echo esc_attr( $enteghalino_label ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: 1: شماره 2: نام */ __( 'ایستگاه %1$s: %2$s', 'enteghalino' ), enteghalino_fa( $enteghalino_n ), $enteghalino_label ) ); ?>"></button></li>
						<?php endfor; ?>
					</ol>

					<div class="scenes" aria-hidden="true">
						<!-- 1: pick -->
						<div class="scene scene-1">
							<div class="pick-list">
								<label><i></i>کاربرها و نقش‌ها <small>۵٬۰۹۷</small></label>
								<label><i></i>رسانه <small>۳٬۴۶۰</small></label>
								<label><i></i>دسته‌ها و برچسب‌ها <small>۲۱۴</small></label>
								<label class="off"><i></i>نوشته‌ها <small>۹۸</small></label>
								<label><i></i>برگه‌ها <small>۱۲</small></label>
								<label><i></i>محصولات <small>۱٬۲۴۰</small></label>
								<label><i></i>سفارش‌ها <small>۸٬۳۱۲</small></label>
								<label><i></i>تنظیمات افزونه‌ها <small>۹ گروه</small></label>
							</div>
							<div class="box">
								<div class="pkg-head"><svg class="ic"><use href="#i-package"/></svg><span>بسته‌ی <span class="ltr">ZIP</span></span></div>
								<div class="box-tag">
									<small>در بسته</small>
									<b class="mono box-num">۰</b>
								</div>
								<div class="pkg-meter"><i></i></div>
							</div>
						</div>

						<!-- 2: chunks -->
						<div class="scene scene-2">
							<div class="req-head">
								<span>درخواست‌ها</span>
								<span class="budget-label">سقف زمانی هر درخواست</span>
							</div>
							<div class="reqs">
								<div class="req"><span class="mono">#۱۶</span><div class="req-track"><i style="--w:.78"></i></div></div>
								<div class="req"><span class="mono">#۱۷</span><div class="req-track"><i style="--w:.83"></i></div></div>
								<div class="req req-fail"><span class="mono">#۱۸</span><div class="req-track"><i style="--w:.4"></i><em>قطع شد</em></div></div>
								<div class="req req-resume"><span class="mono">#۱۸</span><div class="req-track"><i style="--w:.8"></i><em>از تکه‌ی ۱۸ ادامه</em></div></div>
								<div class="req"><span class="mono">#۱۹</span><div class="req-track"><i style="--w:.76"></i></div></div>
								<div class="budget-line"></div>
							</div>
							<div class="files mono ltr">
								<span>products-0016.json</span>
								<span>products-0017.json</span>
								<span class="hot">products-0018.json</span>
								<span>orders-0001.json</span>
							</div>
						</div>

						<!-- 3: adaptive -->
						<div class="scene scene-3">
							<div class="gauges">
								<div class="gauge">
									<small>بار سرور</small>
									<b class="mono load-val">۰٫۴</b>
									<div class="meter"><i class="load-bar"></i></div>
								</div>
								<div class="gauge">
									<small>اندازه‌ی دسته</small>
									<b class="mono batch-val">۵۰</b>
									<div class="meter"><i class="batch-bar"></i></div>
								</div>
							</div>
							<svg class="chart" viewBox="0 0 400 170" preserveAspectRatio="none">
								<g class="grid"><line x1="0" y1="40" x2="400" y2="40"/><line x1="0" y1="85" x2="400" y2="85"/><line x1="0" y1="130" x2="400" y2="130"/></g>
								<path class="line-load" d="M0 140 L50 135 L100 120 L150 60 L200 42 L250 70 L300 118 L350 130 L400 128"/>
								<path class="line-batch" d="M0 40 L50 40 L100 52 L150 110 L200 128 L250 100 L300 60 L350 46 L400 44"/>
							</svg>
							<div class="legend"><span class="lg-load">بار سرور</span><span class="lg-batch">اندازه‌ی دسته</span></div>
						</div>

						<!-- 4: two routes -->
						<div class="scene scene-4">
							<div class="lane">
								<b class="lane-title">با فایل</b>
								<div class="lane-row">
									<span class="node node-src">مبدأ</span>
									<span class="pipe"><span class="zip mono">ZIP</span></span>
									<span class="node node-dst">مقصد</span>
								</div>
								<small>دانلود بسته ← آپلود تکه‌ای ← ایمپورت</small>
							</div>
							<div class="lane lane-direct">
								<b class="lane-title">اتصال مستقیم</b>
								<div class="lane-row">
									<span class="node node-src">مبدأ</span>
									<span class="pipe pipe-packets"><i></i><i></i><i></i><i></i><i></i><i class="x"></i></span>
									<span class="node node-dst">مقصد</span>
								</div>
								<small><span class="ltr mono">receive-chunk</span> · بررسی <span class="ltr mono">MD5</span> · تلاش دوباره روی خطا</small>
							</div>
						</div>

						<!-- 5: id map -->
						<div class="scene scene-5">
							<ol class="chain">
								<li>کاربر</li><li>رسانه</li><li>ترم</li><li>نوشته</li><li>دیدگاه</li><li>ووکامرس</li>
							</ol>
							<table class="idmap">
								<thead><tr><th>موجودیت</th><th>شناسه‌ی قدیم</th><th></th><th>شناسه‌ی جدید</th></tr></thead>
								<tbody>
									<tr><td>کاربر</td><td class="mono">۴۲</td><td class="arr">←</td><td class="mono">۷</td></tr>
									<tr><td>رسانه</td><td class="mono">۵۱۰</td><td class="arr">←</td><td class="mono">۹۰۳</td></tr>
									<tr><td>دسته</td><td class="mono">۱۹</td><td class="arr">←</td><td class="mono">۳۴</td></tr>
									<tr><td>محصول</td><td class="mono">۸۸</td><td class="arr">←</td><td class="mono">۲۱۳</td></tr>
									<tr class="hl"><td>سفارش <span class="mono">#۱۰۴۲</span></td><td colspan="3">مشتری ۷ · محصول ۲۱۳</td></tr>
								</tbody>
							</table>
						</div>

						<!-- 6: silent -->
						<div class="scene scene-6">
							<div class="phone">
								<div class="notch"></div>
								<div class="notif n1"><span class="n-x"><svg class="ic"><use href="#i-x"/></svg></span><span class="n-app"><svg class="ic"><use href="#i-bag"/></svg></span><span class="n-txt"><b>فروشگاه</b>سفارش #۱۰۴۲ شما تکمیل شد</span></div>
								<div class="notif n2"><span class="n-x"><svg class="ic"><use href="#i-x"/></svg></span><span class="n-app"><svg class="ic"><use href="#i-message"/></svg></span><span class="n-txt"><b>پیامک</b>کد رهگیری مرسوله…</span></div>
								<div class="notif n3"><span class="n-x"><svg class="ic"><use href="#i-x"/></svg></span><span class="n-app"><svg class="ic"><use href="#i-mail"/></svg></span><span class="n-txt"><b>ایمیل</b>رسید سفارش #۱۰۴۳</span></div>
								<div class="silent-badge">ارسال نشد</div>
							</div>
							<div class="stock">
								<small>موجودی «کفش کتانی، سایز ۴۲»</small>
								<div class="stock-grid">
									<div class="stock-row"><b class="mono">۱۲</b><span>پیش از ایمپورت</span></div>
									<span class="stock-eq" aria-hidden="true">=</span>
									<div class="stock-row"><b class="mono">۱۲</b><span>پس از ایمپورت</span></div>
								</div>
							</div>
						</div>

						<!-- 7: verify -->
						<div class="scene scene-7">
							<table class="verify">
								<thead><tr><th>بخش</th><th>مبدأ</th><th>مقصد</th><th></th></tr></thead>
								<tbody>
									<tr><td>محصولات</td><td class="mono">۱٬۲۴۰</td><td class="mono">۱٬۲۴۰</td><td class="ok"><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span></td></tr>
									<tr><td>سفارش‌ها</td><td class="mono">۸٬۳۱۲</td><td class="mono">۸٬۳۱۲</td><td class="ok"><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span></td></tr>
									<tr><td>کاربرها</td><td class="mono">۵٬۰۹۷</td><td class="mono">۵٬۰۹۷</td><td class="ok"><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span></td></tr>
									<tr><td>رسانه</td><td class="mono">۳٬۴۶۰</td><td class="mono">۳٬۴۶۰</td><td class="ok"><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span></td></tr>
									<tr><td>دیدگاه‌ها</td><td class="mono">۲٬۱۸۸</td><td class="mono">۲٬۱۸۸</td><td class="ok"><span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span></td></tr>
								</tbody>
							</table>
							<div class="done-badge"><svg class="ic" aria-hidden="true"><use href="#i-check"/></svg>تحویل شد</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
