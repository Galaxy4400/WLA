const editor = document.querySelector('#editor');

if (editor) {

	ClassicEditor
		.create(document.querySelector('#editor'))
		.catch(error => {
			console.error(error);
		});
		
}