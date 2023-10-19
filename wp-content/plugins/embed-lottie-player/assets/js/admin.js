function lpbHandleShortcode(id) {
	var input = document.querySelector('#lpbFrontShortcode-' + id + ' input');
	var tooltip = document.querySelector('#lpbFrontShortcode-' + id + ' .tooltip');
	input.select();
	input.setSelectionRange(0, 30);
	document.execCommand('copy');
	tooltip.innerHTML = wp.i18n.__('Copied Successfully!', 'lottie-player');
	setTimeout(() => {
		tooltip.innerHTML = wp.i18n.__('Copy To Clipboard', 'lottie-player');
	}, 1500);
}