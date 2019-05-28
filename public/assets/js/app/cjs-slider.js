/**
 *  Script slider: génère un carousel simple
 *
 * Les classes utilisées commencent par "cjs-" pour éviter toute interférence.
 *
 *  Réalisé pour le projet Qwwizzy
 * 2019 - Léo BOYER
 */

const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)

class CjsSlider {
    constructor(element) {
        this.allSlides = element.querySelectorAll('.cjs-slide')
        this.nbrSlides = this.allSlides.length
        this.block = element.querySelector('.cjs-slides-block')
        this.currentSlide = 0
        this.block.style.width = (this.nbrSlides * 100) + "%"

        let btnPrev = document.createElement('div')
        btnPrev.classList.add('cjs-btn', 'cjs-prev-btn')
        btnPrev.innerHTML = `<i class="fas fa-chevron-left"></i>`
        let btnNext = document.createElement('div')
        btnNext.classList.add('cjs-btn', 'cjs-next-btn')
        btnNext.innerHTML = `<i class="fas fa-chevron-right"></i>`
        element.appendChild(btnPrev)
        element.appendChild(btnNext)

        btnPrev.addEventListener('click', () => this.prev())
        btnNext.addEventListener('click', () => this.next())

    }
    next() {
        if (this.currentSlide >= this.nbrSlides-1) {
            this.goTo(0)
        } else {
            this.goTo(this.currentSlide+1)
        }
    }

    prev() {
        if (this.currentSlide === 0) {
            this.goTo(this.nbrSlides-1)
        } else {
            this.goTo(this.currentSlide-1)
        }
    }

    goTo (slide) {
        let val = -1*(100 / this.nbrSlides)*slide
        this.block.style.transform = "translate3d("+ val +"%, 0, 0)";
        this.currentSlide = slide
    }

}

