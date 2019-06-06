/** Génère un nom clef de manière automatique au cours de la frappe
 * */
(() => {
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
                keyNom.value = textNom.replace(/ /gi, '_').replace(/'/gi, '').replace(/é|è|ê/gi, 'e').replace(/â|à/gi,'a').toLowerCase()
            }
        })
        
})()