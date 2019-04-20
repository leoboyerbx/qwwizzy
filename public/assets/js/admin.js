(() => {
    const $ = document.querySelector.bind(document)
    
    if (document.page === "edit" || document.page === "ajouter") {
        let keyNom = $('[name=key_nom]')
        let locked = true;
        keyNom.addEventListener('dblclick', function() {
            this.toggleAttribute('readonly')
            locked = !locked;
        })
        let nom = $('[name=nom]')
        nom.addEventListener('input', function () {
            if (locked) {
                let textNom = this.value;
                keyNom.value = textNom.replace(/ /gi, '_').replace(/'/gi, '').toLowerCase()
            }
        })
    }
})()