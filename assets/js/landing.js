/* انتقالینو · لندینگ: منو، انیمیشن انتقال هیرو، صحنه‌ی چسبان، ورود سکشن‌ها و نشانگر ماوس */
(function () {
	'use strict';

	var FA = '۰۱۲۳۴۵۶۷۸۹';
	var root = document.documentElement;
	var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var mobileMq = window.matchMedia('(max-width: 980px)');
	function fa(n, sep) {
		var s = String(n);
		if (sep) s = s.replace(/\B(?=(\d{3})+(?!\d))/g, '٬');
		return s.replace(/\d/g, function (d) { return FA[d]; }).replace('.', '٫');
	}
	function pad(n) { return fa(n < 10 ? '0' + n : n); }
	function isMobile() { return mobileMq.matches; }

	// ---------- هدر و منو ----------
	var top = document.querySelector('.top');
	var nav = document.querySelector('.top-nav');
	if (!top || !nav) return;
	var glider = nav.querySelector('.nav-glider');
	var navLinks = [].slice.call(nav.querySelectorAll('a'));
	var toggle = document.querySelector('.menu-toggle');
	var currentLink = null;

	// بدون پیوند، دکمه‌ی منوی موبایل معنایی ندارد
	if (!navLinks.length && toggle) toggle.hidden = true;

	function moveGlider(a) {
		if (!a || isMobile()) { glider.classList.remove('on'); return; }
		glider.style.width = a.offsetWidth + 'px';
		glider.style.transform = 'translateX(' + a.offsetLeft + 'px)';
		glider.classList.add('on');
	}
	function setCurrent(a) {
		if (a === currentLink) return;
		currentLink = a;
		navLinks.forEach(function (l) {
			var on = l === a;
			l.classList.toggle('is-current', on);
			if (on) l.setAttribute('aria-current', 'location'); else l.removeAttribute('aria-current');
		});
		moveGlider(a);
	}

	// بخشی که از ۴۰٪ بالای صفحه گذشته، بخش فعلی منوست
	function samePage(a) { return a.pathname.replace(/\/$/, '') === location.pathname.replace(/\/$/, ''); }
	var spySections = navLinks.map(function (a) {
		if (!a.hash || !samePage(a)) return null;
		try { return document.querySelector(a.hash); } catch (e) { return null; }
	});
	function spy() {
		var line = window.innerHeight * 0.4;
		var hit = null;
		spySections.forEach(function (s, i) {
			if (!s) return;
			var r = s.getBoundingClientRect();
			if (r.top < line && r.bottom > line) hit = navLinks[i];
		});
		setCurrent(hit);
	}

	function closeMenu() {
		if (!top.classList.contains('open')) return;
		top.classList.remove('open');
		toggle.setAttribute('aria-expanded', 'false');
	}
	toggle.addEventListener('click', function () {
		var open = top.classList.toggle('open');
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		if (open && navLinks[0]) navLinks[0].focus({ preventScroll: true });
	});
	navLinks.forEach(function (a) {
		a.addEventListener('click', function () { setCurrent(a); closeMenu(); });
	});
	document.addEventListener('click', function (e) { if (!top.contains(e.target)) closeMenu(); });
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape' && top.classList.contains('open')) { closeMenu(); toggle.focus(); }
	});

	// ---------- هیرو: انتقال از مبدأ به مقصد ----------
	// هر چرخه یک نوع داده، یک تکه را از پنل مبدأ در مسیر به پنل مقصد می‌برد.
	(function () {
		var mig = document.querySelector('.mig');
		if (!mig || !mig.querySelector('.route-base').getTotalLength) return;
		var src = mig.querySelector('.win-src'), dst = mig.querySelector('.win-dst');
		var svg = mig.querySelector('.mig-route');
		var base = svg.querySelector('.route-base'), trail = svg.querySelector('.route-trail');
		var portOut = svg.querySelector('.port-out'), portIn = svg.querySelector('.port-in');
		var packet = mig.querySelector('.packet');
		var pkUse = packet.querySelector('use'), pkName = packet.querySelector('b'), pkFile = packet.querySelector('small');
		var dots = [].slice.call(mig.querySelectorAll('.trail-dot'));
		var rows = [].slice.call(src.querySelectorAll('.src-rows li'));
		var log = dst.querySelector('.dst-log');
		var chunkEl = dst.querySelector('.chunk-n'), dstBar = dst.querySelector('.dst-bar');

		var HOLD = 350, SEND = 1900, REST = 950, CYCLE = HOLD + SEND + REST;
		var STATIC_T = 0.55;
		var len = 0, chunk = 18, i = rows.indexOf(src.querySelector('.is-active'));
		var start = 0, last = 0, arrived = true, raf = 0, visible = true;

		function file(r) { return r.dataset.file + '-' + ('000' + r.dataset.n).slice(-4) + '.json'; }
		function ease(x) { return x < .5 ? 4 * x * x * x : 1 - Math.pow(-2 * x + 2, 3) / 2; }
		function clamp(x) { return x < 0 ? 0 : x > 1 ? 1 : x; }

		// مسیر از روی جای واقعی دو پنل ساخته می‌شود تا در هر اندازه‌ای درست بنشیند
		function layout() {
			var m = mig.getBoundingClientRect(), a = src.getBoundingClientRect(), b = dst.getBoundingClientRect();
			var aL = a.left - m.left, aT = a.top - m.top, aB = a.bottom - m.top;
			var bL = b.left - m.left, bT = b.top - m.top;
			var sx, sy, ex, ey, d;
			svg.setAttribute('viewBox', '0 0 ' + m.width + ' ' + m.height);
			if (aL >= 140) { // کنار هم: از لبه‌ی مبدأ بیرون می‌آید و از بالا وارد مقصد می‌شود
				sx = aL; sy = aT + a.height * 0.42;
				ex = bL + Math.min(b.width * 0.3, aL * 0.62); ey = bT;
				d = 'M' + sx + ' ' + sy + ' C ' + (ex + (sx - ex) * 0.12) + ' ' + sy + ', ' + ex + ' ' + (sy + (ey - sy) * 0.3) + ', ' + ex + ' ' + ey;
			} else { // زیر هم: از پایین مبدأ به بالای مقصد
				sx = aL + a.width * 0.5; sy = aB; ex = bL + b.width * 0.5; ey = bT;
				var mid = (sy + ey) / 2;
				d = 'M' + sx + ' ' + sy + ' C ' + sx + ' ' + mid + ', ' + ex + ' ' + mid + ', ' + ex + ' ' + ey;
			}
			base.setAttribute('d', d);
			trail.setAttribute('d', d);
			len = base.getTotalLength();
			trail.style.strokeDasharray = len;
			portOut.setAttribute('cx', sx); portOut.setAttribute('cy', sy);
			portIn.setAttribute('cx', ex); portIn.setAttribute('cy', ey);
		}

		function place(el, t) {
			var p = base.getPointAtLength(len * t);
			el.style.transform = 'translate(' + p.x + 'px,' + p.y + 'px) translate(-50%, -50%)';
		}

		// حالت ثابت: بسته در میانه‌ی راه؛ بدون حرکت هم معنای انتقال روشن است
		function still() {
			layout();
			place(packet, STATIC_T);
			place(dots[0], STATIC_T - 0.09);
			place(dots[1], STATIC_T - 0.17);
			trail.style.strokeDashoffset = len * (1 - STATIC_T);
		}

		function begin(now) {
			i = (i + 1) % rows.length;
			if (i === 0) rows.forEach(function (r) { r.classList.remove('is-done'); });
			rows.forEach(function (r) { r.classList.remove('is-active'); });
			var r = rows[i];
			r.classList.remove('is-done');
			void r.offsetWidth;
			r.classList.add('is-active');
			pkUse.setAttribute('href', '#' + r.dataset.icon);
			pkName.textContent = r.dataset.name;
			pkFile.textContent = file(r);
			start = now;
			arrived = false;
		}

		function arrive() {
			var r = rows[i];
			r.classList.remove('is-active');
			r.classList.add('is-done');

			var li = document.createElement('li');
			li.className = 'enter';
			li.innerHTML = '<span class="ok-ic"><svg class="ic"><use href="#i-check"/></svg></span><span class="l-name"></span><span class="l-file mono ltr"></span>';
			li.querySelector('.l-name').textContent = r.dataset.name;
			li.querySelector('.l-file').textContent = file(r);
			log.insertBefore(li, log.firstChild);
			while (log.children.length > 5) log.removeChild(log.lastChild);
			r.dataset.n = +r.dataset.n + 1;

			chunk = chunk >= 42 ? 1 : chunk + 1;
			chunkEl.textContent = fa(chunk);
			dstBar.style.setProperty('--p', (chunk / 42).toFixed(3));

			portIn.classList.remove('hit');
			void portIn.getBoundingClientRect();
			portIn.classList.add('hit');
		}

		function frame(now) {
			raf = requestAnimationFrame(frame);
			if (last && now - last > 250) start += now - last; // جبران وقفه (تب پنهان یا خارج از دید)
			last = now;
			var e = now - start;
			if (e >= CYCLE) { begin(now); e = 0; }

			var p = clamp((e - HOLD) / SEND);
			place(packet, ease(p));
			packet.style.opacity = e < HOLD ? e / HOLD : p < 1 ? 1 : clamp(1 - (e - HOLD - SEND) / 220);
			dots.forEach(function (dot, k) {
				var q = clamp((e - HOLD - (k + 1) * 120) / SEND);
				place(dot, ease(q));
				dot.style.opacity = q <= 0 || q >= 1 ? 0 : '';
			});
			trail.style.strokeDashoffset = len * (1 - ease(p));
			trail.style.opacity = p < 1 ? 1 : clamp(1 - (e - HOLD - SEND) / 600);

			if (!arrived && p >= 1) { arrived = true; arrive(); }
		}

		function run() { if (!raf && visible) raf = requestAnimationFrame(frame); }
		function stop() { cancelAnimationFrame(raf); raf = 0; }

		if (reduce) {
			still();
			window.addEventListener('resize', still);
			if (document.fonts && document.fonts.ready) document.fonts.ready.then(still);
			return;
		}

		layout();
		mig.classList.add('is-live');
		mig.style.setProperty('--send', SEND + 'ms');
		// چرخه از همان نوع داده‌ای شروع می‌شود که در حالت ثابت دیده می‌شود
		i = (i - 1 + rows.length) % rows.length;
		begin(performance.now());
		if ('ResizeObserver' in window) new ResizeObserver(layout).observe(mig);
		else window.addEventListener('resize', layout);
		if (document.fonts && document.fonts.ready) document.fonts.ready.then(layout);
		if ('IntersectionObserver' in window) {
			new IntersectionObserver(function (en) {
				visible = en[0].isIntersecting;
				if (visible) run(); else stop();
			}).observe(mig);
		}
		run();
	})();

	// ---------- صحنه‌ها ----------
	// در برگه‌های دیگرِ سایت وردپرسی این بخش نیست؛ آن‌جا کاری انجام نمی‌شود.
	var pickStep = function () {};
	var stage = document.querySelector('.stage');
	if (stage) (function () {
		var story = document.querySelector('.story');
		var steps = [].slice.call(document.querySelectorAll('.step'));
		var curEl = stage.querySelector('.cur');
		var titleBox = stage.querySelector('.stage-title');
		var titleText = stage.querySelector('.st-text');
		var titleIcon = titleBox.querySelector('use');
		var stepper = stage.querySelector('.stage-steps');
		var chips = [].slice.call(stepper.querySelectorAll('li'));
		var timers = [];
		var active = 0;

		function later(fn, ms) { timers.push(setTimeout(fn, reduce ? 0 : ms)); }
		function clearTimers() { timers.forEach(clearTimeout); timers = []; }

		var scenes = {
			1: function () {
				var labels = stage.querySelectorAll('.pick-list label');
				var box = stage.querySelector('.box');
				var num = stage.querySelector('.box-num');
				var packed = 0;
				labels.forEach(function (l) { l.classList.remove('on', 'packed'); });
				box.classList.remove('closed');
				box.style.setProperty('--n', 0);
				num.textContent = fa(0);
				labels.forEach(function (l, i) {
					if (l.classList.contains('off')) return;
					later(function () { l.classList.add('on'); }, 250 + i * 180);
					later(function () {
						l.classList.add('packed');
						packed++;
						num.textContent = fa(packed);
						box.style.setProperty('--n', packed);
						box.classList.remove('bump'); void box.offsetWidth; box.classList.add('bump');
					}, 1900 + i * 230);
				});
				later(function () { box.classList.add('closed'); }, 1900 + labels.length * 230 + 300);
			},
			3: function () {
				// منحنی نمودار را با عددها همگام می‌کنیم
				var load = [0.4, 0.5, 0.9, 2.6, 3.1, 2.2, 1.0, 0.6, 0.6];
				var batch = [50, 50, 44, 18, 10, 24, 40, 48, 49];
				var lv = stage.querySelector('.load-val'), bv = stage.querySelector('.batch-val');
				var lb = stage.querySelector('.load-bar'), bb = stage.querySelector('.batch-bar');
				load.forEach(function (_, i) {
					later(function () {
						lv.textContent = fa(load[i].toFixed(1));
						bv.textContent = fa(batch[i]);
						lb.style.width = Math.min(100, load[i] / 3.4 * 100) + '%';
						bb.style.width = batch[i] / 55 * 100 + '%';
					}, 300 + i * 400);
				});
			},
			5: function () {
				var chain = stage.querySelectorAll('.chain li');
				var rows = stage.querySelectorAll('.idmap tbody tr');
				chain.forEach(function (c) { c.classList.remove('lit'); });
				rows.forEach(function (r) { r.classList.remove('in'); });
				chain.forEach(function (c, i) { later(function () { c.classList.add('lit'); }, 200 + i * 320); });
				rows.forEach(function (r, i) { later(function () { r.classList.add('in'); }, 600 + i * 380); });
			},
			7: function () {
				var rows = stage.querySelectorAll('.verify tbody tr');
				rows.forEach(function (r) { r.classList.remove('in'); });
				rows.forEach(function (r, i) { later(function () { r.classList.add('in'); }, 300 + i * 330); });
			}
		};

		function activate(n) {
			if (n === active) return;
			active = n;
			clearTimers();
			stage.setAttribute('data-active', n);
			curEl.textContent = pad(n);

			steps.forEach(function (s) {
				var k = +s.dataset.step;
				s.classList.toggle('is-active', k === n);
				s.classList.toggle('is-done', k < n);
			});
			chips.forEach(function (c, i) {
				c.classList.toggle('cur', i + 1 === n);
				c.classList.toggle('done', i + 1 < n);
				var b = c.firstElementChild;
				if (i + 1 === n) b.setAttribute('aria-current', 'step'); else b.removeAttribute('aria-current');
			});
			stepper.style.setProperty('--frac', ((n - 1) / (steps.length - 1)).toFixed(3));

			// عنوان نوار بالای صحنه
			var step = steps[n - 1];
			titleText.textContent = step.querySelector('h3').textContent;
			titleIcon.setAttribute('href', '#' + step.dataset.icon);
			titleBox.classList.remove('swap'); void titleBox.offsetWidth; titleBox.classList.add('swap');

			if (scenes[n]) scenes[n]();
		}

		function stepLine() { return isMobile() ? window.innerHeight * 0.78 : window.innerHeight * 0.55; }

		// گامی فعال است که از خط میانی صفحه (یا زیر صحنه در موبایل) گذشته باشد
		pickStep = function () {
			var line = stepLine();
			var n = 1;
			steps.forEach(function (s) {
				if (s.getBoundingClientRect().top < line) n = +s.dataset.step;
			});
			activate(n);

			var first = steps[0].getBoundingClientRect();
			var last = steps[steps.length - 1].getBoundingClientRect();
			var span = last.bottom - first.top - window.innerHeight * 0.4;
			var prog = Math.max(0, Math.min(1, (line - first.top) / span));
			story.style.setProperty('--prog', prog.toFixed(3));
		};

		// کلیک روی ایستگاه‌های نوار صحنه، متن همان گام را به وسط می‌آورد
		stepper.addEventListener('click', function (e) {
			var btn = e.target.closest('button[data-go]');
			if (!btn) return;
			var step = steps[+btn.dataset.go - 1];
			var r = step.getBoundingClientRect();
			var target = isMobile() ? stepLine() - 40 : (window.innerHeight - step.offsetHeight) / 2;
			window.scrollTo({ top: window.scrollY + r.top - target, behavior: reduce ? 'auto' : 'smooth' });
		});
	})();

	var ticking = false;
	function onScroll() {
		if (ticking) return;
		ticking = true;
		requestAnimationFrame(function () {
			top.classList.toggle('scrolled', window.scrollY > 8);
			pickStep();
			spy();
			ticking = false;
		});
	}
	window.addEventListener('scroll', onScroll, { passive: true });
	var resizeRaf = 0;
	window.addEventListener('resize', function () {
		if (resizeRaf) return;
		resizeRaf = requestAnimationFrame(function () {
			resizeRaf = 0;
			if (!isMobile()) closeMenu();
			moveGlider(currentLink);
			onScroll();
		});
	});
	onScroll();
	if (document.fonts && document.fonts.ready) document.fonts.ready.then(function () { moveGlider(currentLink); });

	// ---------- ورود و خروج سکشن‌ها ----------
	// هر بلوک وقتی وارد دید می‌شود حرکت می‌کند: با اسکرول رو به پایین از پایین بالا می‌آید،
	// با اسکرول رو به بالا از بالا پایین می‌آید. بیرون که رفت، برای ورود بعدی آماده می‌شود.
	var RV = [
		'.hero-copy > *', '.hero-visual', '.ticker',
		'.sec-head', '.mf-file', '.mf-list li', '.mf-note',
		'.num', '.faq details', '.cta-copy > *', '.cta-steps .cs', '.cs-tip'
	];
	if (!reduce && !root.classList.contains('no-reveal') && 'IntersectionObserver' in window) {
		var rvEls = [].slice.call(document.querySelectorAll(RV.join(',')));
		rvEls.forEach(function (el) { el.classList.add('rv'); });
		rvEls.forEach(function (el) {
			var sibs = [].filter.call(el.parentNode.children, function (c) { return c.classList.contains('rv'); });
			el.style.setProperty('--rv-d', Math.min(sibs.indexOf(el), 6) * 0.07 + 's');
		});
		var lastY = window.scrollY, goingUp = false;
		window.addEventListener('scroll', function () {
			var y = window.scrollY;
			if (y !== lastY) goingUp = y < lastY;
			lastY = y;
		}, { passive: true });
		var rvIo = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				var el = e.target;
				if (!e.isIntersecting) { el.classList.remove('in'); return; }
				// جهت ورود = جهت اسکرول؛ پیش از نمایش، نقطه‌ی شروع را عوض می‌کنیم
				if (goingUp !== el.classList.contains('rv-top')) {
					el.style.transition = 'none';
					el.classList.toggle('rv-top', goingUp);
					void el.offsetWidth;
					el.style.transition = '';
				}
				el.classList.add('in');
			});
		}, { rootMargin: '0px 0px -6% 0px' });
		rvEls.forEach(function (el) { rvIo.observe(el); });
	}

	// ---------- نشانگر ماوس ----------
	// نقطه بی‌درنگ دنبال ماوس می‌آید و حلقه با کمی تأخیر؛ روی لینک و دکمه حلقه بزرگ می‌شود.
	(function () {
		if (reduce || root.classList.contains('no-cursor') || !window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;
		var dot = document.createElement('div'), ring = document.createElement('div');
		dot.className = 'cursor-dot';
		ring.className = 'cursor-ring';
		dot.setAttribute('aria-hidden', 'true');
		ring.setAttribute('aria-hidden', 'true');
		document.body.appendChild(ring);
		document.body.appendChild(dot);
		root.classList.add('has-cursor');

		var HOVER = 'a, button, summary, label';
		var x = 0, y = 0, rx = 0, ry = 0, raf = 0, shown = false;
		function follow() {
			dot.style.transform = 'translate(' + x + 'px,' + y + 'px)';
			rx += (x - rx) * 0.2;
			ry += (y - ry) * 0.2;
			ring.style.transform = 'translate(' + rx + 'px,' + ry + 'px)';
			raf = Math.abs(x - rx) + Math.abs(y - ry) > 0.2 ? requestAnimationFrame(follow) : 0;
		}
		document.addEventListener('mousemove', function (e) {
			x = e.clientX; y = e.clientY;
			if (!shown) { shown = true; rx = x; ry = y; root.classList.add('cursor-on'); }
			if (!raf) raf = requestAnimationFrame(follow);
		}, { passive: true });
		document.addEventListener('mouseover', function (e) {
			var on = !!(e.target.closest && e.target.closest(HOVER));
			ring.classList.toggle('is-hover', on);
			dot.classList.toggle('is-hover', on);
		});
		document.addEventListener('mousedown', function () { ring.classList.add('is-down'); });
		document.addEventListener('mouseup', function () { ring.classList.remove('is-down'); });
		root.addEventListener('mouseleave', function () { shown = false; root.classList.remove('cursor-on'); });
	})();
})();
