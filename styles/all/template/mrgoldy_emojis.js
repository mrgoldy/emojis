(function($) {

'use strict';

$(function() {
	$('#message, #signature').jemoji({
		btn: $('#emojis'),
		theme: $('#emojis').data('theme'),
		folder: $('#emojis').data('path'),
		container: $('#message-box'),
		navigation: false
	});
});

}) (jQuery);
