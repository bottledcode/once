const quill = new Quill('#viewer', {
	theme: null,
	readOnly: true,
});
quill.setContents(JSON.parse(document.getElementById('message').value));
