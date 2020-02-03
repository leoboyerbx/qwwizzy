/**
 * Le script présent sur la page des questions
 * Il se charge d'envoyer une requête au serveur pour vérifier si la réponse fournie par l'utilisateur est juste.
 * Il modifie le DOM en conséquence.
 */

(() => {
    // Permet d'utiliser une forme courte du sélecteur.
    const $ = document.querySelector.bind(document)
    const $$ = document.querySelectorAll.bind(document)

    /**
     * Fonction qu ienvoie au serveur l'id de la question et la réponse fournie, et qui retourne une promesse qui se résoud avec la réponse du serveur.
     * @param questionId
     * @param reponse
     * @returns {Promise<any>}
     */
    async function checkReponse(questionId, reponse) {
        // On stocke les données de la requête dans un objet FormData
        let data = new FormData()
        data.append('question_id', questionId)
        data.append('reponse', reponse)
        // On envoie une requête avec fetch() (équivalend a jquery.ajax())
        let response = await fetch('/question/check', {
            method: 'POST',
            mode: "same-origin",
            credentials: "same-origin",
            body: data
        })
        // On convertit la chaîne json obtenue en objet javascript
        return await response.json()
    }

    let question = $('#question')           // Le bloc question
    let questionId = question.dataset.id    // L'id de la question
    let buttons = $$('.bouton-reponse')     // Les boutons vrai et faux

    // On agit sur chaque bouton
    buttons.forEach(button => {
        button.addEventListener('click', ev => {
            buttons.forEach(b => {
                // Lors du cloc sur les boutons, on commence par les désactiver, pour éviter que l'utilisateur clique à nouveau.
                b.disabled = true
                // On modifie l'apparence pour montrer que les boutons ne sont plus cliquables.
                b.classList.remove('btn-danger', 'btn-success')
                b.classList.add('btn-basic')
            })
            // on envoie une requete de vérification au serveur.
            checkReponse(questionId, button.value).then(response => {
                // Une fois la réponse reçue, on vérifie que la réponse est juste, et on ajuste des détails de design
                if (response.juste) {
                    question.classList.add('vrai')
                    // On renseigne la valeur de score qui sera envoyée à PHP
                    $('#score').value = "1";
                } else {
                    question.classList.add('faux')
                }
                // On remplit le texte de la réponse
                $('#texte-reponse').innerHTML = response.texte_reponse
            })

        })
    })
})();
