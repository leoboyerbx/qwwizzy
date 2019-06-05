const $ = document.querySelector.bind(document)
const $$ = document.querySelectorAll.bind(document)

class DynamicMessage {
    
    static instances = []
    
    constructor (message, type = "light", expiration = null, closable = true, stackable = true) {
        let element = document.createElement('div')
        element.classList.add('dyn-msg')
        let content = `<div class="alert alert-${type}">
        <div class="dyn-msg-content">
            ${message}
        </div>`
        if (closable) content += `
        <div class="dyn-msg-close">
            <i class="fas fa-times"></i>
        </div>`
        content += "</div>"
    
        element.innerHTML = content
        if (closable) {
            element.querySelector('.dyn-msg-close').addEventListener('click', () => {
                this.close()
            })
        }
        if (DynamicMessage.instances.length == 1 && !DynamicMessage.instances[0].stackable) {
            DynamicMessage.instances[0].wiggle()
        } else {
            if (DynamicMessage.instances.length > 0) {
                document.querySelector('body').insertBefore(element, document.querySelector('.dyn-msg'))
            } else {
                document.querySelector('body').appendChild(element)
            }
            this.element = element
            this.height = element.getBoundingClientRect().height
            this.translated = 0
            this.stackable = stackable
            
            if (DynamicMessage.instances.length > 0) {
                DynamicMessage.instances.forEach(instance => {
                    instance.moveUp(this.height)
                })
            }
            DynamicMessage.instances.push(this)
            
            if (expiration) {
                setTimeout(() => {this.close()}, expiration*1000)
            }
        }
    }
    
    close() {
        this.element.classList.add('closed');
        
        for (let i = 0; i < this.getIndex(); i++) {
            DynamicMessage.instances[i].moveDown(this.height)
        }
        DynamicMessage.instances.splice(this.getIndex(), 1)
        
        setTimeout(() => {
            this.element.remove()
        }, 1000)
    }
    
    moveUp(delta) {
        this.element.style.transform = "translateY(" + (this.translated - delta) + "px)"
        this.translated -= delta
    }
    moveDown (delta) {
        this.moveUp(-delta)
    }
    
    getIndex() {
        return DynamicMessage.instances.indexOf(this)
    }
    
    wiggle() {
        this.element.classList.add('wiggle')
        setTimeout(() => {
            this.element.classList.remove('wiggle')
        }, 1000)
    }
    
    
    static autoFromFlash() {
        document.querySelectorAll('.flashmsg').forEach(msg => {
            let messageText = msg.innerHTML
            let messageType = msg.dataset.type
            msg.remove()
            new DynamicMessage(messageText, messageType)
        })
    }
    
}
class DynamicMessagePrompt extends DynamicMessage {
    constructor(message, type, textYes = "Oui", textNo = "Annuler", stackable = false) {
        message += `</div>
        <div class="dyn-msg-prompt">
            <button class="btn btn-${type} action-yes">${textYes}</a>
            <button class="btn btn-light action-no">${textNo}</a>
            `
        super(message, type, null, false, stackable)
        this.element.querySelector('.action-yes').focus()
    }
    
    yes(callback) {
        this.element.querySelector('.action-yes').addEventListener('click', ev => {
            callback(this)
        })
        return this
    }
    no(callback) {
        this.element.querySelector('.action-no').addEventListener('click', ev => {
            callback(this)
        })
        return this
    }
    closeOnYes() {
        this.element.querySelector('.action-yes').addEventListener('click', () => {
            this.close()
        })
        return this
    }
    closeOnNo() {
        this.element.querySelector('.action-no').addEventListener('click', () => {
            this.close()
        })
        return this
    }
    
}


/**
 * Util function for lightening the colour with a %
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
    
    $$('.btn-retour').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault()
            history.go(-1)
        })
    })
    
    document.addEventListener('DOMContentLoaded', function() {
        DynamicMessage.autoFromFlash()
    })
    
})()

