(() => {
    async function updateColortoServer(main, lighter, darker) {
    let data = new FormData()
    data.append('main', main)
    data.append('lighter', lighter)
    data.append('darker', darker)
    let response = await fetch('/admin/couleur_theme', {
        method: 'POST',
        mode: "same-origin",
        credentials: "same-origin",
        body : data
    })
     return await response.json()
    }
    
    function updateColor(mainColor) {
        let mainColorLighter = lightenDarkenColor(mainColor, 20)
        let mainColorDarker = lightenDarkenColor(mainColor, -20)
        $(":root").style.cssText = "--main-color: " + mainColor + "; --main-color-lighter: " + mainColorLighter + "; --main-color-darker: " + mainColorDarker + ";"
        
        updateColortoServer(mainColor, mainColorLighter, mainColorDarker).then(res => {
            new DynamicMessage('La couleur du site a été mise à jour avec succès !', 'success', 2)
        }).catch(function() {
            new DynamicMessage("Une erreur s'est produite lors de la mise à jour de la couleur", 'danger')
        })
    }
    
    
    $('#sitecolor').addEventListener('change', function() {
        updateColor("#"+this.value.toLowerCase())
    })
    let  event = new Event('input', {
        'bubbles': true,
        'cancelable': true
    })

    $$('.colorpreset').forEach(button => {
        button.addEventListener('click', function() {
            $('#sitecolor').value = this.dataset.color
            $('#sitecolor').dispatchEvent(event)
            updateColor(this.dataset.color)
        })
    })
    
    
}) ()