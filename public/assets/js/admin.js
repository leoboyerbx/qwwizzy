(() => {
    const $ = document.querySelector.bind(document)
    const $$ = document.querySelectorAll.bind(document)
    
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
                keyNom.value = textNom.replace(/ /gi, '_').replace(/'/gi, '').replace(/é|è|ê/gi, 'e').replace(/â|à/gi,'a').toLowerCase()
            }
        })
        
        function updateImage(url) {
            $('#preview-image').style.backgroundImage = `url(${url})`
        }
        $('#url_image').addEventListener('input', function(e) {
            updateImage(this.value)
        })
        
        
        
        HTMLElement.prototype.hide = function() {
        	this.classList.remove('show', 'active')
        }
        HTMLElement.prototype.show = function() {
        	this.classList.add('show', 'active')
        }
        
        document.addEventListener('DOMContentLoaded', () => {
        	
        
        	$$('#onglets li a').forEach(e => e.addEventListener('click', function(ev) {
        			ev.preventDefault()
        			$$('#contenuOnglets div').forEach(e => e.hide())
        			$$("#onglets li a").forEach(e => e.classList.remove('active'))
        
        			this.classList.add('active')
        			$(this.hash).show()
        		})
        	)
        })
    }
    // if (document.upload) {
    //     $('#upload_image').addEventListener('change', function(ev) {
    //         console.log('salut')
    //     })
    // }
    
    
    /* Le code suivant permet de vérifier le mot de passe sur la page change_mdp */
    
    if (document.page == "changemdp") {
        var mdp_a_verif, mdp_confirm, bouton_change
        
        mdp_a_verif = document.getElementById("mdp_a_confirm")
        console.log(mdp_a_verif.value)
        mdp_confirm = document.getElementById("mdp_confirm")
        bouton_change = document.getElementById("btn_sub_change")
        mdp_confirm.onchange = function() {
            mdp_confirm = document.getElementById("mdp_confirm")
            mdp_a_verif = document.getElementById("mdp_a_confirm")
            console.log(mdp_confirm.value)
            console.log(mdp_a_verif.value)
            if (mdp_a_verif.value == mdp_confirm.value) {
                mdp_confirm.classList.add('green')
                mdp_confirm.classList.remove('red')
            }
            else {
                mdp_confirm.classList.add('red')
                mdp_confirm.classList.remove('green')
            }
        }
        
        bouton_change.onclick = function(e) {
            if (mdp_a_verif.value != mdp_confirm.value) { 
                event.preventDefault()
                alert("Les 2 mots de passe rentrés sont différents, veuillez les retaper.")
            }
        }
    }
    
    
})()

