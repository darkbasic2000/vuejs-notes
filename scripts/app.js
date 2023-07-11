const { createApp } = Vue
    createApp({
        data() {   
            return {
                contacts: [],
                notes: [],
                quantity: 0,
                quantity_notes: 0,
                limit: 10,
                note_length: 0,
                messages: '',
                messages_notes: '',
                error_messages: '',
                listContacts: true,
                newForm: false,
                newNoteForm: false,
                showContact: false,
                editContact: false,
                contact: {
                    id: '',
                    username: '',
                    email: '',
                    phone: '',
                    picture: ''
                },
                deleteId: '',
                deletePicture: ''
            }   
        },
        mounted() {
            this.list(10, null)
            this.list_notes()
        },
        methods: {
            setQuantity(e) {
                const search = document.querySelector("#search").value
                if(search.trim() !== '') {
                    this.list(this.limit, search)
                }
                else {
                    this.list(e.target.value, null)
                }
            },
            remaining(e) {
                this.note_length = e.target.value.length
            },
            async list(n, search) {
                fetch('./controllers/ContactController.php', {
                    body: 'query=list&quantity='+n+'&search='+search,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    this.contacts = data
                    this.quantity = this.contacts.length
                    if(this.contacts.length === 0) {
                        if(search === null) {
                            this.messages = "No contact has been registered"
                        }
                        else {
                            this.messages = "Your search has not returned any results"
                        }                        
                    }
                    else {
                        this.messages = ''
                    }
                })                
            },
            search() {
                const search = document.querySelector("#search").value
                if(search.trim() !== '') {
                    this.list(this.limit, search)
                }
            },
            async list_notes() {
                fetch('./controllers/NoteController.php', {
                    body: 'query=list',
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    this.notes = data
                    this.quantity_notes = data.length
                    if(this.notes.length === 0) {
                        this.messages_notes = "There are not any notes registered"
                    }
                    else if(this.notes.length === 30) {
                        this.messages_notes = "You reached the limit of 30 notes"
                    }
                })
            },
            showNewForm() {
                this.newForm = true
                this.listContacts = false
                this.showContact = false
            },
            hideNewForm() {
                this.newForm = false
                this.listContacts = true
            },
            saveContact() {
                const username = document.querySelector('#username').value
                const phone = document.querySelector('#phone').value
                const email = document.querySelector('#email').value
                const picture = document.querySelector('#picture').files[0]                
                let formData = new FormData()
                formData.append('query', 'save')
                formData.append('username', username)
                formData.append('phone', phone)
                formData.append('email', email)
                formData.append('picture', picture)
                fetch('./controllers/ContactController.php', {
                    body: formData,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data === true) {
                        this.error_messages = ""
                        window.location.href = 'index.html'
                    }
                    else {
                        this.error_messages = "Error saving contact. This e-mail is already taken"
                    }
                })
            },
            saveNote() {
                const annotations = document.querySelector('#annotations').value
                let formData = new FormData()
                formData.append('query', 'save')
                formData.append('annotations', annotations)                
                fetch('./controllers/NoteController.php', {
                    body: formData,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data) {
                        window.location.href = 'index.html'
                    }
                })
            },
            showContactForm(contact) {
                this.listContacts = false
                this.showContact = true                                
                this.contact.id = contact.id
                this.contact.username = contact.username
                this.contact.phone = contact.phone
                this.contact.email = contact.email
                this.contact.picture = contact.picture
            },
            hideContactForm() {
                this.showContact = false
                this.listContacts = true
            },
            showEditForm(contact) {
                this.listContacts = false
                this.showContact = false
                this.editContact = true
                this.contact.id = contact.id
                this.contact.username = contact.username
                this.contact.phone = contact.phone
                this.contact.email = contact.email
                this.contact.picture = contact.picture
                this.error_messages = ""
            },
            hideEditForm() {
                this.editContact = false
                this.listContacts = true
            },
            updateContact() {
                const id = document.querySelector('#id_edit').value           
                const username = document.querySelector('#username_edit').value
                const phone = document.querySelector('#phone_edit').value
                const email = document.querySelector('#email_edit').value
                const picture = document.querySelector('#picture_edit').files[0]                
                let formData = new FormData()
                formData.append('query', 'edit')
                formData.append('id', id)
                formData.append('username', username)
                formData.append('phone', phone)
                formData.append('email', email)
                formData.append('picture', picture)
                fetch('./controllers/ContactController.php', {
                    body: formData,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data === true) {
                        this.error_messages = ""
                        window.location.href = 'index.html'
                    }
                    else {
                        this.error_messages = "Error updating contact. This e-mail is already taken"
                    }
                })
            },
            deleteContact(id, picture) {                
                this.hideContactForm()
                let formData = new FormData()
                formData.append("query", "delete")
                formData.append("id", id)
                formData.append("picture", picture)
                fetch('./controllers/ContactController.php', {
                    body: formData,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data) {
                        this.contacts = this.contacts.filter(contact => id !== contact.id)
                        this.deleteId = ''
                        this.deletePicture = ''
                        this.quantity = this.contacts.length
                        if(this.contacts.length === 0) {
                            this.list(limit, null)
                        }
                    }
                })                
            },
            deleteNote(id) {                
                let formData = new FormData()
                formData.append("query", "delete")
                formData.append("id", id)                
                fetch('./controllers/NoteController.php', {
                    body: formData,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*'
                    }
                })
                .then((res) => res.json())
                .then((data) => {
                    if(data) {
                        this.notes = this.notes.filter(note => id !== note.id)
                        this.quantity_notes = this.notes.length
                        if(this.notes.length === 0) {
                            this.messages_notes = "There are not any notes registered"
                        }
                    }
                })                
            }
        }
  }).mount('#app')