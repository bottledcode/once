const quill = new Quill('#editor', {
	theme: 'bubble'
});
quill.on('text-change', (delta, oldContents, source) => {
	try {
		document.getElementById('text-editor').value = JSON.stringify(quill.getContents());
	} catch (e) {
		// nothing to do...
	}
});
