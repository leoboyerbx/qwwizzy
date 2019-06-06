// Sur la page où on choisit une icone, permet d'afficher une prévisualisation de l'icône choisie.
$('#icon').addEventListener('input', function() {
    $('#icon-preview').className = "fas fa-"+this.value
})