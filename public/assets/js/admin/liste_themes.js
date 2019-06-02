async function updateThemeCategorie(theme, categorie) {
    let data = new FormData()
    data.append('theme', theme)
    data.append('categorie', categorie)
    let response = await fetch('/admin/themes/deplacer', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body : data
    })
     return await response.text()
}
(() => {
    let scrollatStart = 0
    $$('.tr-theme').forEach(function (ligne) {
        ligne.querySelector('.btn-move-theme').ligne = ligne
        interact(
            ligne.querySelector('.btn-move-theme')).draggable({
            autoScroll: true,
    
            listeners: {
                start: function(ev) {
                    scrollatStart = window.scrollY
                    ligne.classList.add('dragged')
                },
                move: function(ev) {
                    // console.log(ev.clientY - ev.clientY0)
                    ligne.style.transform = "translateY("+ ((ev.clientY - ev.clientY0) + (window.scrollY - scrollatStart)) +"px)"
                }
            }
        })
    })
    
    $$('.bloc-categorie').forEach(cat => {
        interact(cat).dropzone({
            listeners: {
                drop: function (ev) {
                    let theme = ev.relatedTarget.ligne
                    theme.parentNode.removeChild(theme)
                    
                    ev.target.querySelector('tbody').appendChild(theme)
                    theme.classList.remove('dragged')
                    theme.style.transform = null
                    
                    ev.target.classList.remove('dropping')
                    
                    ev.target.updateNbrThemes(1)
                    $('.bloc-categorie[data-categorie="'+ ev.relatedTarget.dataset.categorie +'"]').updateNbrThemes(-1)
                    
                    if (ev.target.dataset.categorie !== ev.relatedTarget.dataset.categorie) {
                        let theme_id = ev.relatedTarget.dataset.theme
                        let categorie_id = ev.target.dataset.categorie
                        updateThemeCategorie(theme_id, categorie_id).then(res => {
                            if (res== "ok") {
                                new DynamicMessage('Le thème a été déplacé avec succès.', 'success', 4)
                            } else {
                                new DynamicMessage("Une erreur s'est produite lors du déplacement du thème.", 'danger')
                                
                            }
                        })
                    }
                    
                },
                dragenter: function(ev) {
                    ev.target.classList.add('dropping')
                },
                dragleave: function(ev) {
                    ev.target.classList.remove('dropping')
                },
                
            }
            
        })
    })
}) ()

HTMLDivElement.prototype.updateNbrThemes = function (delta, absolute = false) {
            let nbr = this.querySelector('.nbr_themes')
            let currentNbr = parseInt(nbr.innerHTML)
            nbr.innerHTML = currentNbr + parseInt(delta)
        }