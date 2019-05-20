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