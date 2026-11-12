/* انتقالینو · پیش‌نمایش زنده‌ی سفارشی‌سازی
   قاعده‌های قالب‌بندی متن و ساخت پالت، همان enteghalino_fmt() و enteghalino_palette() در inc/options.php هستند. */
(function (api) {
	'use strict';
	var fields = window.enteghalinoFields || {};
	var root = document.documentElement;

	// ---------- متن ----------
	function esc(s) {
		return String(s).replace(/[&<>"']/g, function (c) {
			return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c];
		});
	}
	var LATIN = /([A-Za-z0-9][A-Za-z0-9.+\-_\/@:%]*(?: +[A-Za-z0-9][A-Za-z0-9.+\-_\/@:%]*)*)/;
	function bidi(s) {
		return String(s).split(LATIN).map(function (p, i) {
			return p === '' ? '' : i % 2 ? '<bdi>' + esc(p) + '</bdi>' : esc(p);
		}).join('');
	}
	function fmt(s, mode) {
		var re = mode === 'chip' ? /(\*[^*\n]+\*|\[[^\]\n]+\])/ : /(\*[^*\n]+\*)/;
		return String(s || '').split(re).map(function (p, i) {
			if (p === '') return '';
			if (i % 2 && p[0] === '*') return '<mark>' + bidi(p.slice(1, -1)) + '</mark>';
			if (i % 2) return '<span class="cs-btn">' + bidi(p.slice(1, -1)) + '</span>';
			return bidi(p);
		}).join('');
	}

	// ---------- رنگ ----------
	function rgb(hex) {
		hex = String(hex || '').replace('#', '');
		if (hex.length === 3) hex = hex.replace(/./g, '$&$&');
		if (!/^[0-9a-f]{6}$/i.test(hex)) hex = '000000';
		return [0, 2, 4].map(function (i) { return parseInt(hex.substr(i, 2), 16); });
	}
	function hex(c) { return '#' + c.map(function (v) { return ('0' + Math.round(v).toString(16)).slice(-2); }).join(''); }
	function mix(a, b, t) { return a.map(function (v, i) { return v + (b[i] - v) * t; }); }
	function lum(c) {
		var l = c.map(function (v) { v /= 255; return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4); });
		return 0.2126 * l[0] + 0.7152 * l[1] + 0.0722 * l[2];
	}
	function contrast(a, b) { var x = lum(a), y = lum(b); return (Math.max(x, y) + 0.05) / (Math.min(x, y) + 0.05); }
	function palette(base) {
		var white = [255, 255, 255], paper = rgb(base.paper), ink = rgb(base.ink), card = mix(paper, white, 0.65);
		var v = {
			'paper': hex(paper), 'paper-2': hex(mix(paper, ink, 0.05)), 'card': hex(card), 'ink': hex(ink),
			'ink-2': hex(mix(ink, paper, 0.24)), 'ink-3': hex(mix(ink, paper, 0.4)), 'line': hex(mix(paper, ink, 0.14)),
			'paper-rgb': paper.map(Math.round).join(' '), 'ink-rgb': ink.map(Math.round).join(' ')
		};
		['brand', 'accent'].forEach(function (name) {
			var c = rgb(base[name]), text = c;
			for (var t = 0; t <= 1.001 && contrast(text, card) < 4.5; t += 0.05) text = mix(c, ink, t);
			v[name] = hex(c);
			v[name + '-ink'] = hex(text);
			v[name + '-soft'] = hex(mix(card, c, 0.26));
			v[name + '-rgb'] = c.join(' ');
			v['on-' + name] = contrast(c, ink) >= contrast(c, white) ? hex(ink) : '#ffffff';
		});
		return v;
	}
	var colors = {};
	function applyColors() {
		var v = palette(colors);
		Object.keys(v).forEach(function (k) { root.style.setProperty('--' + k, v[k]); });
		var meta = document.querySelector('meta[name="theme-color"]');
		if (meta) meta.setAttribute('content', v.paper);
	}

	// ---------- اتصال ----------
	Object.keys(fields).forEach(function (key) {
		var kind = fields[key].split(':');
		api('enteghalino_' + key, function (setting) {
			if (kind[0] === 'color') {
				var name = key.replace('color_', '');
				colors[name] = setting.get();
				setting.bind(function (val) { colors[name] = val; applyColors(); });
				return;
			}
			setting.bind(function (val) {
				document.querySelectorAll('[data-ent="' + key + '"]').forEach(function (el) {
					el.innerHTML = kind[0] === 'url' ? esc(val) : fmt(val, kind[1]);
				});
				document.querySelectorAll('[data-ent-href="' + key + '"]').forEach(function (el) {
					el.setAttribute('href', val && val.charAt(0) === '#' && !document.querySelector('.hero') ? '/' + val : val);
				});
			});
		});
	});

	// رفتن به بخشی که در پنل باز شده
	api.bind('preview-ready', function () {
		api.preview.bind('enteghalino-scroll', function (selector) {
			var el = document.querySelector(selector);
			if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	});
})(wp.customize);
