const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)


/**
 * Fonction chargée d'éclaircir ou assombrir une couleur
 * @param - string - colour with leading #
 * @param - number - percentage to lighten by
 */
function lightenDarkenColor (c,p) {
	var n = parseInt(c.slice(1),16)
	, a = Math.round(2.55 * p)
	// Bitshift 16 bits to the left
	, r = (n >> 16) + a
	// Bitshift 8 bits to the left based on blue
	, b = (n >> 8 & 0x00FF) + a
	// 
	, g = (n & 0x0000FF) + a;
	// Calculate
	return '#' + (
    		0x1000000 + (r < 255 ? r < 1 ? 0 : r : 255) * 0x10000 +
    		(b < 255 ? b < 1 ? 0 : b : 255) * 0x100 + (g < 255 ? g < 1 ? 0 : g : 255)
    	).toString(16).slice(1);
};

(() => {
    /**
     * Pour toutes les pages qui contiennent un bouton supprimer, on ajoute un message de confirmation avant d'effectuer l'action.
     * */
    if ($('.form-delete')) {
        $$('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault()
                let confirm = new DynamicMessagePrompt('Êtes-vous sûr de vouloir supprimer cet élément ? <br> CETTE ACTION EST IRRÉVERSIBLE.', 'warning')
                confirm.yes(function() {
                    form.submit()
                }).closeOnNo()
            })
        })
    }
    /**
     * Permets aux boutons "retour" de renvoyer à la page précédemment visitée et non pas toujours à la même page.
     * */
    $$('.btn-retour').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            history.go(-1)
        })
    })
    /**
     * On récupère les messages envoyés par PHP pour en faire un bel affichage     * */
    document.addEventListener('DOMContentLoaded', function() {
        DynamicMessage.autoFromFlash()
    })
    
})()

