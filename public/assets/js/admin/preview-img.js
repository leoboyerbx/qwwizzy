function updateImage(url) {
    $('#preview-image').style.backgroundImage = `url(${url}), url('/assets/img/default.png')`
}
$('#url_image').addEventListener('input', function(e) {
    updateImage(this.value)
})