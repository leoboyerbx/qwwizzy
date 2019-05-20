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
})()