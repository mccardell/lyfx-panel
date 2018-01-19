let consumerData = window.consumerData = {}
// function whatIsYourPassionVisibleHandler() {
// 	// state refer to stb on itself
// 	let adventures = document.getElementById('adventures')
// 	let whatIsYourPassion = document.getElementById('what-is-your-passion')
// 	adventures.setAttribute('style','display:none;')
// 	whatIsYourPassion.onclick = whatIsYourPassionHandler
// }

// function whatIsYourPassionHandler() {
// 	// state refer to stb on itself
// 	let adventures = document.getElementById('adventures')
// 	let whatIsYourPassion = document.getElementById('what-is-your-passion')
// 	adventures.setAttribute('style','display:block;')
// 	whatIsYourPassion.onclick = whatIsYourPassionVisibleHandler
// }

function buildScopeHandler() {
	let ctx = {}
	let uField = ctx.uField = document.getElementById('uField')
	let idField = ctx.idField = document.getElementById('idField')
	let firstNameField = ctx.firstNameField = document.getElementById('firstNameField')
	let lastNameField = ctx.lastNameField = document.getElementById('lastNameField')
	let emailField = ctx.emailField = document.getElementById('emailField')
	let zipCodeField = ctx.zipCodeField = document.getElementById('zipCodeField')
	let cityField = ctx.cityField = document.getElementById('cityField')
	let stateField = ctx.stateField = document.getElementById('stateField')
	let telField = ctx.telField = document.getElementById('telField')
	return ctx
}

function buildScopeHandlerFirstStep() {
	let ctx = {}
	let whatIsYourPassionField = ctx.whatIsYourPassionField = document.getElementById('what-is-your-passion')
	let whenDidYouRealizeYouLovedThisField = ctx.whenDidYouRealizeYouLovedThisField = document.getElementById('when-did-you-realize-you-loved-this')
	let howOftenDoYouPracticeField = ctx.howOftenDoYouPracticeField = document.getElementById('how-often-do-you-practice')
	return ctx
}

function buildScopeHandlerSecondStep() {
	let ctx = {}
	let describeTheAdventureYouWantToCreateInAFewWords = ctx.describeTheAdventureYouWantToCreateInAFewWords = document.getElementById('describe-the-adventure-you-want-to-create-in-a-few-words')
	let howOftenWillYouTakeYourTravellersOut = ctx.howOftenWillYouTakeYourTravellersOut = document.getElementById('how-often-will-you-take-your-travellers-out')
	let howManyTravellersCanYourAdventureAccomodate = ctx.howManyTravellersCanYourAdventureAccomodate = document.getElementById('how-many-travellers-can-your-adventure-accomodate')
	return ctx
}

function buildScopeHandlerThirdStep() {
	let ctx = {}
	let whatMakesYourAdventureUnique = ctx.whatMakesYourAdventureUnique = document.getElementById('what-makes-your-adventure-unique')
	let tellUsAboutTheLocationWhereYouAdventureWillTakePlaceAndWhatMakesItSpecial = ctx.tellUsAboutTheLocationWhereYouAdventureWillTakePlaceAndWhatMakesItSpecial = document.getElementById('tell-us-about-the-location-where-you-adventure-will-take-place-and-what-makes-it-special')
	return ctx
}

function checkEmptyFieldsHandler(step=0) {
	let that = this
	let ctx = {}
	if (step === 0) {
		ctx = checkSignupProcessHandler.call({ctx:ctx,that:that})
	} else if (step === 1) {
		ctx = checkFirstStepProcessHandler.call({ctx:ctx,that:that})
	} else if (step === 2) {
		ctx = checkSecondStepProcessHandler.call({ctx:ctx,that:that})
	} else if (step === 3) {
		ctx = checkThirdStepProcessHandler.call({ctx:ctx,that:that})
	}
	ctx.then = ctx.then.bind(ctx)
	return ctx
}
function buildAlertScope(name) {
	let ctx = {}
	let textMessage = (n) => `Please fill the \(${n}\) field.`
	ctx.title = 'Oops!'
	ctx.text = textMessage(name)
	ctx.icon = 'info'
	return ctx
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email.toLowerCase());
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

function isFieldEmpty(name,suffix='Field') { return !this[name + suffix].value }

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

function checkFirstStepProcessHandler() {
	let self = this;

	if (isFieldEmpty.call(self.that,'whatIsYourPassion')) {
		self.ctx = swal(buildAlertScope('First Question'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'whenDidYouRealizeYouLovedThis')) {
		self.ctx = swal(buildAlertScope('Second Question'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'howOftenDoYouPractice')) {
		self.ctx = swal(buildAlertScope('Third Question'))
		self.ctx.isDone = false
	} else {
		self.ctx.then = fn => fn.call(self.ctx)
		self.ctx.isDone = true
	}
	return self.ctx
}

function checkSecondStepProcessHandler() {
	let self = this;

	if (isFieldEmpty.call(self.that,'describeTheAdventureYouWantToCreateInAFewWords','')) {
		self.ctx = swal(buildAlertScope('First Question'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'howOftenWillYouTakeYourTravellersOut','')) {
		self.ctx = swal(buildAlertScope('Second Question'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'howManyTravellersCanYourAdventureAccomodate','')) {
		self.ctx = swal(buildAlertScope('Third Question'))
		self.ctx.isDone = false
	} else {
		self.ctx.then = fn => fn.call(self.ctx)
		self.ctx.isDone = true
	}
	return self.ctx
}

function checkThirdStepProcessHandler() {
	let self = this;

	if (isFieldEmpty.call(self.that,'whatMakesYourAdventureUnique','')) {
		self.ctx = swal(buildAlertScope('First Question'))
		self.ctx.isDone = false
	} else if (isFieldEmpty.call(self.that,'tellUsAboutTheLocationWhereYouAdventureWillTakePlaceAndWhatMakesItSpecial','')) {
		self.ctx = swal(buildAlertScope('Second Question'))
		self.ctx.isDone = false
	} else {
		self.ctx.then = fn => fn.call(self.ctx)
		self.ctx.isDone = true
	}
	return self.ctx
}

function signupHandler(e) {
	console.log('Save the another part of the content')
	let that = this
	let bg = document.getElementById('bg')
	let labeledTitle = document.getElementById('labeled-title')
	let intro = document.getElementById('intro')
	// let community = document.getElementById('community')
	let progression = document.getElementById('progression')
	let thePassion = document.getElementById('the-passion')
	// let whatIsYourPassion = document.getElementById('what-is-your-passion')

	let scope = buildScopeHandler();
	let checkedFields = checkEmptyFieldsHandler.call(scope);
	checkedFields.then(() => {
		if (checkedFields.isDone){
			intro.setAttribute('style','display:none;')
			labeledTitle.setAttribute('style','display:none;')
			bg.setAttribute('style','background-image:url(assets/img/step-01.jpg) !important;')
			// community.setAttribute('style','display:none;')
			progression.setAttribute('style','display:block;margin-top:1em!important;margin-left:0 !important;')
			thePassion.setAttribute('style','display:block;')
			// whatIsYourPassion.onclick = whatIsYourPassionHandler
			consumerData['uField'] = document.getElementById('uField').value
			consumerData['idField'] = document.getElementById('idField').value
			consumerData['firstNameField'] = document.getElementById('firstNameField').value
			consumerData['lastNameField'] = document.getElementById('lastNameField').value
			consumerData['emailField'] = document.getElementById('emailField').value
			consumerData['zipCodeField'] = document.getElementById('zipCodeField').value
			consumerData['cityField'] = document.getElementById('cityField').value
			consumerData['stateField'] = document.getElementById('stateField').value
			consumerData['telField'] = document.getElementById('telField').value
		}
	})
	e.preventDefault()
}

function localStorageGetItem(n) { return window.localStorage.getItem(n) }

function storageKeys() {
	return [
		'firstName', 'lastName',
		'email', 'zipCode', 'tel'
	]
}

function buildStoreContext(suffix='Field') {
	let ctx = Object.create(null,{})
	let keys = storageKeys()
	keys.forEach(k => ctx[k] = localStorageGetItem(k + suffix))
	return ctx
}

function select(n) { return document.getElementById(n) }

function elementKeys() {
	return [
		'firstNameField', 'lastNameField',
		'emailField', 'zipCodeField',
		'telField', 'signupBtn'
	]
}

function buildElementContext() {
	let ctx = Object.create(null,{})
	let keys = elementKeys()
	keys.forEach(k => ctx[k] = select(k))
	return ctx
}

function restoreFields(store,els,suffix='Field') {
	let keys = Object.keys(store)
	keys.forEach(function(k){
		k => els[k + suffix].value = store[k]
	})
	return els
}

let pgs = 0

function firstStepForward() {
	console.log('first step forward')
	let bg = document.getElementById('bg')
	let thePassion = document.getElementById('the-passion')
	let theRoadmap = document.getElementById('the-roadmap')
	let nextBtn = document.getElementById('nextBtn')
	let thePassionProgress = document.getElementById('the-passion-progress')
	let theRoadmapProgress = document.getElementById('the-roadmap-progress')

	let scope = buildScopeHandlerFirstStep();
	let checkedFields = checkEmptyFieldsHandler.call(scope,1);
	checkedFields.then(() => {
		if (checkedFields.isDone){
			bg.setAttribute('style','background-image:url(assets/img/step-02.jpg) !important;')
			thePassion.setAttribute('style','display:none;')
			theRoadmap.setAttribute('style','display:block;')
			thePassionProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:none;')
			theRoadmapProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:block;')
			consumerData['what-is-your-passion'] = document.getElementById('what-is-your-passion').value
			consumerData['when-did-you-realize-you-loved-this'] = document.getElementById('when-did-you-realize-you-loved-this').value
			consumerData['how-often-do-you-practice'] = document.getElementById('how-often-do-you-practice').value
		}
	});
}

function secondStepForward() {
	console.log('second step forward')
	let bg = document.getElementById('bg')
	let theRoadmap = document.getElementById('the-roadmap')
	let theAllure = document.getElementById('the-allure')
	let theRoadmapProgress = document.getElementById('the-roadmap-progress')
	let theAllureProgress = document.getElementById('the-allure-progress')

	let scope = buildScopeHandlerSecondStep();
	let checkedFields = checkEmptyFieldsHandler.call(scope,2);
	checkedFields.then(() => {
		if (checkedFields.isDone){
			bg.setAttribute('style','background-image:url(assets/img/step-03.jpg) !important;')
			theRoadmap.setAttribute('style','display:none;')
			theAllure.setAttribute('style','display:block;')
			theRoadmapProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:none;')
			theAllureProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:block;')
			consumerData['describe-the-adventure-you-want-to-create-in-a-few-words'] = document.getElementById('describe-the-adventure-you-want-to-create-in-a-few-words').value
			consumerData['how-often-will-you-take-your-travellers-out'] = document.getElementById('how-often-will-you-take-your-travellers-out').value
			consumerData['how-many-travellers-can-your-adventure-accomodate'] = document.getElementById('how-many-travellers-can-your-adventure-accomodate').value
		}
	});
}

function thirdStepForward() {
	console.log('third step forward');
	let theAllure = document.getElementById('the-allure');
	let scope = buildScopeHandlerThirdStep();
	let checkedFields = checkEmptyFieldsHandler.call(scope,3);
	checkedFields.then(() => {
		if (checkedFields.isDone){
			// let progression = document.getElementById('progression')
			// let completed = document.querySelector('#completed')
			theAllure.setAttribute('style','display:none;');
			// progression.setAttribute('style','display:none;')
			// completed.setAttribute('style','display:block;')
			consumerData['what-makes-your-adventure-unique'] = document.getElementById('what-makes-your-adventure-unique').value;
			consumerData['tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special'] = document.getElementById('tell-us-about-the-location-where-you-adventure-will-take-place-and-what-makes-it-special').value;
		  superagent
		  	.post('https://api.lyfx.co/consumers')
		  	.send(consumerData)
		  	.end((err,res) => {
		  		window.location.href = '/done';
		  	})
		}
	});
}

function loadHandler() {
	let store = buildStoreContext()
	let els = buildElementContext()
	// adventures pre-population cache
	// let whatIsYourPassion = document.getElementById('what-is-your-passion')
	// let adventures = $('#adventures')

	restoreFields(store,els)

	els.signupBtn.onclick = signupHandler

	// $.ajax('https://api.lyfx.co/acts').done(res => {
	// 	res
	// 		.data
	// 		.map(v => {
	// 			adventures
	// 				.append($(`<li><a class="act" href=\"#${v.name}\" data-act-value="${v.name}">${v.name}</a></li>`))
	// 		})
		
	// 	$('.act').on('click', e => {
	// 		let v = e.target.getAttribute('data-act-value')
	// 		whatIsYourPassion.value = v
	// 		whatIsYourPassionVisibleHandler()
	// 		e.preventDefault()
	// 	})
	// })
}



window.onload = loadHandler