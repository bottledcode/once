const quill = new Quill('#editor', {
	theme: 'snow', placeholder: 'Write a message...', modules: {
		toolbar: [['bold', 'italic', 'underline', 'strike'],        // toggled buttons
			['blockquote', 'code-block'],
			[{'list': 'ordered'}, {'list': 'bullet'}], [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
			[{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
			[{'direction': 'rtl'}],                         // text direction

			[{'size': ['small', false, 'large', 'huge']}],  // custom dropdown

			[{'color': []}, {'background': []}],          // dropdown with defaults from theme
			[{'font': []}], [{'align': []}],

			['clean']                                         // remove formatting button
		]
	}
});
quill.on('text-change', (delta, oldContents, source) => {
	try {
		document.getElementById('text-editor').value = JSON.stringify(quill.getContents());
	} catch (e) {
		// nothing to do...
	}
});
