(() => {
    const $ = document.querySelector.bind(document)
    const $$ = document.querySelectorAll.bind(document)
    let barre = $('#barre-score div')
    barre.style.backgroundColor = "#ff6666";
    setTimeout(() => {
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


