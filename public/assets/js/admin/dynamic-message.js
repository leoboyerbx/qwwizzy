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