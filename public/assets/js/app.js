$ = document.querySelector.bind(document)
$$ = document.querySelectorAll.bind(document)

async function checkReponse(questionId, reponse) {
    let data = new FormData()
    data.append('question_id', questionId)
    data.append('reponse', reponse)
    let response = await fetch('/questions/check', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body : data
    })
     return await response.text()
}

let question = $('#question')
let questionId = question.dataset.id
let buttonVrai = $('#button-vrai')
let buttonFaux = $('#button-faux')
let buttons = [buttonVrai, buttonFaux]

function bonneReponse(question) {
    question.classList.add('vrai')
    buttonFaux.classList.remove('btn-danger')
}

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
            if (response === 'true') {
                bonneReponse(question)
            } else {
                question.classList.add('faux')
            }
        })

    })
})

