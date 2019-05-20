(() => {
    const $ = document.querySelector.bind(document)
    const $$ = document.querySelectorAll.bind(document)

    async function checkReponse(questionId, reponse) {
        let data = new FormData()
        data.append('question_id', questionId)
        data.append('reponse', reponse)
        let response = await fetch('/question/check', {
            method: 'POST',
            mode: "same-origin",
            credentials: "same-origin",
            body: data
        })
        return await response.json()
    }

    let question = $('#question')
    let questionId = question.dataset.id
    let buttons = $$('.bouton-reponse')

 

    buttons.forEach(button => {
        button.addEventListener('click', ev => {
            buttons.forEach(b => {
                b.disabled = true
            })
            buttons.forEach(b => {
                b.classList.remove('btn-danger', 'btn-success')
                b.classList.add('btn-basic')
            })
            checkReponse(questionId, button.value).then(response => {
                console.log(response.texte_reponse)
                if (response.juste) {
                    question.classList.add('vrai')
                    $('#score').value = "1";
                } else {
                    question.classList.add('faux')
                }
                $('#texte-reponse').innerHTML = response.texte_reponse
            })

        })
    })
})();
