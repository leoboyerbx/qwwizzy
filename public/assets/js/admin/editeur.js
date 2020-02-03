/**
 * In tègre le plugin quill pour les pages qui l'utilisent.
 * */
let quill = new Quill('#editeur', {
    theme: 'snow',
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline'],
            ['link', 'code-block']
        ]
    }
})

$('.form-editeur').addEventListener('submit', function(e) {
    e.preventDefault()
    $('#editeurval').value = $('#editeur .ql-editor').innerHTML
    this.submit()
})