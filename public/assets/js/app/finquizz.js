// Script qui gère le choix de la oculeur de la barre à la fin d'un quizz
(() => {
    let barre = document.querySelector('#barre-score div')
    barre.style.backgroundColor = "#ff6666";
    // A la fin de la première animation (600 ms), on choisit la couleur en fonction du score, et on fice la taille de la barre
    setTimeout(() => {
        // On récupère le score qui se trouve dans l'attribut "data-score"
        let score = barre.dataset.score
        barre.style.width = score * 10 + "%";
        
        let scoreCouleur = "#ff6666";
        if (score > 7) {
            scoreCouleur = "#66ff99";
        } else if (score > 4) {
            scoreCouleur = "#ffff66";
        } else if (score > 2) {
            scoreCouleur = "#ff9966";
        }
        barre.style.backgroundColor = scoreCouleur;
        
    }, 600)
}) ();


