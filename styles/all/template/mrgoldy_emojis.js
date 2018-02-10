(function($) {

'use strict';

$(function() {
	$('#message, #signature').jemoji({
		btn: $('#emojis'),
		folder: 'ext/mrgoldy/emojis/emojis/',
		container: $('#message-box'),
		navigation: false,
		//theme: 'blue',
	});
});

}) (jQuery);
