/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'Knights-Plaza\'">' + entity + '</span>' + html;
	}
	var icons = {
			'kp-office' : '&#xe012;',
			'kp-see' : '&#xe00f;',
			'kp-kplogo-upper' : '&#xe003;',
			'kp-kplogo-lower' : '&#xe00d;',
			'kp-sfo' : '&#xe005;',
			'kp-stacked' : '&#xe004;',
			'kp-pegasus' : '&#xe001;',
			'kp-kplogo-small' : '&#xe002;',
			'kp-kp-logo-full' : '&#xe000;',
			'kp-youtube' : '&#xe00c;',
			'kp-share' : '&#xe00b;',
			'kp-google-plus' : '&#xe00a;',
			'kp-flickr' : '&#xe009;',
			'kp-twitter' : '&#xe008;',
			'kp-facebook' : '&#xe007;',
			'kp-cfe' : '&#xe006;',
			'kp-do' : '&#xe013;',
			'kp-shop' : '&#xe014;',
			'kp-park' : '&#xe015;',
			'kp-you-tube' : '&#xe016;',
			'kp-phone' : '&#xe017;',
			'kp-lease' : '&#xe018;',
			'kp-email' : '&#xe019;',
			'kp-info' : '&#xe01a;',
			'kp-huh' : '&#xe01c;',
			'kp-tag' : '&#xe01d;',
			'kp-newsletter' : '&#xe01e;',
			'kp-mobile-device' : '&#xe01f;',
			'kp-search' : '&#xe020;',
			'kp-map' : '&#xe022;',
			'kp-grid' : '&#xe023;',
			'kp-boxes' : '&#xe024;',
			'kp-list' : '&#xe025;',
			'kp-flux-capacitor' : '&#xe026;',
			'kp-athletics' : '&#xe027;',
			'kp-play' : '&#xe010;',
			'kp-eat' : '&#xe01b;',
			'kp-web' : '&#xe00e;',
			'kp-microphone' : '&#xe028;',
			'kp-users' : '&#xe029;',
			'kp-user' : '&#xe02a;',
			'kp-heart' : '&#xe02b;',
			'kp-star' : '&#xe02c;',
			'kp-clock' : '&#xe02e;',
			'kp-calendar' : '&#xe02f;',
			'kp-music' : '&#xe030;',
			'kp-ticket' : '&#xe031;',
			'kp-trophy' : '&#xe02d;',
			'kp-theatre' : '&#xe032;',
			'kp-commencement' : '&#xe033;',
			'kp-celebration' : '&#xe034;',
			'kp-football' : '&#xe035;',
			'kp-basketball' : '&#xe036;',
			'kp-sport' : '&#xe037;',
			'kp-mixer' : '&#xe039;',
			'kp-chill' : '&#xe038;',
			'kp-mingle' : '&#xe03a;',
			'kp-mix' : '&#xe011;',
			'kp-bug' : '&#xe021;',
			'kp-home' : '&#xe03b;',
			'kp-mixer-2' : '&#xe03c;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/kp-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};