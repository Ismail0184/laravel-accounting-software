/*
 * Custom Java Script
 * -----------------------
 */
(function ($) {
	var url = document.URL;
	if (url.indexOf("?") > 0) {
		var urlWithNoParams = url.substring(0, url.indexOf('?'));
	}
	else {
		var urlWithNoParams = url;
	}
	$('.sidebar-menu li:has(li.active)').addClass('active');
	$('.sidebar-menu li:has(a[href="'+urlWithNoParams+'"])').addClass('active');
	$(".select2").select2();
	//jQuery('.form-horizontal').validate();
	jQuery('.dropdown-submenu > a').submenupicker();
}(jQuery));