/* Tema Mey: menu mobile e pulsante "Torna su". */
(function () {
	'use strict';

	var btn = document.querySelector('.hdr-burger');
	var nav = document.getElementById('menu');
	if (btn && nav) {
		var setOpen = function (open) {
			nav.classList.toggle('open', open);
			btn.setAttribute('aria-expanded', open ? 'true' : 'false');
			btn.setAttribute('aria-label', open ? btn.dataset.labelClose : btn.dataset.labelOpen);
		};
		btn.addEventListener('click', function () {
			setOpen(btn.getAttribute('aria-expanded') !== 'true');
		});
		nav.addEventListener('click', function (e) {
			if (e.target.closest('a')) setOpen(false);
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && nav.classList.contains('open')) {
				setOpen(false);
				btn.focus();
			}
		});
	}

	var top = document.querySelector('.totop');
	if (top) {
		var onScroll = function () { top.hidden = window.scrollY < 600; };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
		top.addEventListener('click', function () {
			var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
			window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
			var brand = document.querySelector('.brand');
			if (brand) brand.focus({ preventScroll: true });
		});
	}
})();
