(() => {
    const $ = document.querySelector.bind(document)
    
    if (document.page === "edit") {
        let keyNom = $('[name=key_nom]')
        let nom = $('[name=nom]')
        nom.addEventListener('input', function () {
            let textNom = this.value;
            keyNom.value = textNom.replace(/ /gi, '_').toLowerCase()
        })
    }
})()