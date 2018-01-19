function buildScopeHandler() {
	let ctx = {}
	let uField = ctx.uField = document.getElementById('u')
	let refField = ctx.refField = document.getElementById('ref')
	let firstNameField = ctx.firstNameField = document.getElementById('firstName')
	let lastNameField = ctx.lastNameField = document.getElementById('lastName')
	let emailField = ctx.emailField = document.getElementById('email')
	let emailNewsletter = ctx.emailNewsletterField = document.getElementById('emailNewsletter')
	let zipCodeField = ctx.zipCodeField = document.getElementById('zipCode')
	let stateField = ctx.stateField = document.getElementById('state')
	let telField = ctx.telField = document.getElementById('tel')
	return ctx
}

function validateZip(evt) {
  	var theEvent = evt || window.event;
  	var key = theEvent.keyCode || theEvent.which;
  	key = String.fromCharCode( key );
  	var regex = /[0-9\s-]/;
  	if( !regex.test(key) ) {
    	theEvent.returnValue = false;
    	if(theEvent.preventDefault) theEvent.preventDefault();
  	}
}

function isFieldEmpty(name,suffix='Field') { return !this[name + suffix].value }

function buildAlertScope(name) {
	let ctx = {}
	let textMessage = (n) => `Please fill the \(${n}\) field.`
	ctx.title = 'Oops!'
	ctx.text = textMessage(name)
	ctx.icon = 'info'
	return ctx
}

function validateNumber(evt) {
  	var theEvent = evt || window.event;
  	var key = theEvent.keyCode || theEvent.which;
  	key = String.fromCharCode( key );
  	var regex = /[()\s0-9\s+]/;
  	if( !regex.test(key) ) {
    	theEvent.returnValue = false;
    	if(theEvent.preventDefault) theEvent.preventDefault();
  	}
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email.toLowerCase());
}

function checkSignupProcessHandler() {
	let self = this;

	if (isFieldEmpty.call(self.that,'firstName')) {
		self.ctx = swal(buildAlertScope('First Name'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'lastName')) {
		self.ctx = swal(buildAlertScope('Last Name'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'email')) {
		self.ctx = swal(buildAlertScope('E-mail'))
		self.ctx.isDone = false
	} else if (!validateEmail(self.that.emailField.value)) {
		self.ctx = swal(buildAlertScope('E-mail'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'zipCode')) {
		self.ctx = swal(buildAlertScope('Zip-Code'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'tel')) {
		self.ctx = swal(buildAlertScope('Phone Number'))
		self.ctx.isDone = false
	} else {
		self.ctx.then = fn => fn.call(self.ctx)
		self.ctx.isDone = true
	}
	return self.ctx
}

function checkNewsletterProcessHandler() {
	let self = this
	if (isFieldEmpty.call(self.that,'emailNewsletter')) {
		self.ctx = swal(buildAlertScope('E-mail'))
		self.ctx.isDone = false
	} else {
		self.ctx.then = fn => fn.call(self.ctx)
		self.ctx.isDone = true
	}
	return self.ctx
}

function checkEmptyFieldsHandler(firstPart=0) {
	let that = this
	let ctx = {}
	if (firstPart === 0) {
		ctx = checkSignupProcessHandler.call({ctx:ctx,that:that})
	} else if (firstPart === 1) {
		ctx = checkNewsletterProcessHandler.call({ctx:ctx,that:that})
	}
	ctx.then = ctx.then.bind(ctx)
	return ctx
}

function saveContext(data) {
	let keys = Object.keys(data)
	keys.map(k => window.localStorage.setItem(k,data[k].value))
	return data
}

function signupSubmitHandler(e) {
	let scope = buildScopeHandler()
	let url = 'https://api.lyfx.co/consumers'
	let checkedFields = checkEmptyFieldsHandler.call(scope)
	checkedFields.then(() => {
		let that = this
		if (checkedFields.isDone) superagent.get(url + '?email=' + scope.emailField.value).end((err,res) => {
			if (!res.body.total) {
			$('#signupBtn').html('<img src="/assets/img/loading.gif" />');
				superagent.post(url).send({
					uField: scope.uField.value,
					refField: scope.refField.value,
					firstName: scope.firstNameField.value,
					lastName: scope.lastNameField.value,
					email: scope.emailField.value,
					zipCode: scope.zipcodeField.value,
					city: scope.cityField.value,
					state: scope.stateField.value,
					phone: scope.telField.value,
				}).end((err,res) => {
					$('#signupBtn').html("Ok, Let's do it!");
					swal({
						title: 'GREAT',
						text: 'Successfully done.',
						icon: 'success'
					}).then((res) => {
						$('#signupBtn').html("Ok, Let's do it!");
						saveContext(scope)
						if (res) window.location.href = '/signup';
					})
				});
			} else {
				swal({
					title: 'WAIT',
					text: `your email (${scope.emailField.value}) already registered in LYFX.`,
					icon: 'warning'
				})
			}
		})
	})
	e.preventDefault()
}

function newsletterSubmitHandler(e) {
	if (validateEmail(e.path[1].emailNewsletter.value)) {
		let scope = buildScopeHandler()
		let url = 'https://api.lyfx.co/newsletter'
		let checkedFields = checkEmptyFieldsHandler.call(scope,1)
		checkedFields.then(() => {
			let that = this
			if (checkedFields.isDone) superagent.get(url + '?email=' + scope.emailNewsletterField.value).end((err,res) => {
				if (!res.body.total) {
					superagent.post(url).send({
						uField: scope.uField.value,
						email: scope.emailNewsletterField.value
					}).end((err,res) => {
						swal({
							title: 'GREAT',
							text: 'Successfully done.',
							icon: 'success'
						}).then((res) => {
							saveContext(scope)
							if (res) window.location.href = '/done';
						})
					})
				} else {
					swal({
						title: 'WAIT',
						text: `your email (${scope.emailNewsletterField.value}) already registered in LYFX.`,
						icon: 'warning'
					})
				}
			})
		})
	}else{
		self.ctx = swal(buildAlertScope('E-mail'))
	}
	e.preventDefault()
}

function loadHandler() {
	let signupBtn = document.getElementById('signupBtn')
	let newsletterSubmitBtn = document.getElementById('newsletterSubmitBtn')

	signupBtn.onclick = signupSubmitHandler
	newsletterSubmitBtn.onclick = newsletterSubmitHandler
}
window.onload = loadHandler