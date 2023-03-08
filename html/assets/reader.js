const quill = new Quill('#viewer', {
	theme: 'snow',
	readOnly: true,
});
quill.setContents(JSON.parse(document.getElementById('message').value));
