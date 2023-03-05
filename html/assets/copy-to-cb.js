(function () {
	const ele = document.getElementById('message_link');
	const oele = document.getElementById('message_copied')
	const link = ele.value;
	ele.onclick = oele.onclick = function () {
		console.log('clicked');
		navigator.clipboard.writeText(link).then(function () {
			/* clipboard successfully set */
			console.log('clipboard successfully set');
			document.getElementById('message_copied').classList.remove('opacity-0');
			setTimeout(function () {
				document.getElementById('message_copied').classList.add('opacity-0');
			}, 1000);
		}, function () {
			/* clipboard write failed */
			console.error('clipboard write failed');
		});
	};
})();
