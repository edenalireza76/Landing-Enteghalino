/* انتقالینو · سفارشی‌سازی: با باز شدن هر بخش، پیش‌نمایش به همان قسمت صفحه می‌رود. */
(function (api) {
	'use strict';
	var targets = window.enteghalinoTargets || {};
	api.bind('ready', function () {
		Object.keys(targets).forEach(function (id) {
			api.section(id, function (section) {
				section.expanded.bind(function (open) {
					if (open) api.previewer.send('enteghalino-scroll', targets[id]);
				});
			});
		});
	});
})(wp.customize);
