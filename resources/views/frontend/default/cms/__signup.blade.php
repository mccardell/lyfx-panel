<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lyfx - Turn your passion into your paycheck.</title>
	<meta name="author" content="Karen Bizanha">
	<meta name="description" content="Bring others along in your next adventure
				and earn extra money. Surfing, mountain biking, hiking, canoeing,
				rock climbing, rafting, horse riding, diving." />
	<meta name="robots" content="index,follow">
	<link rel="stylesheet" type="text/css" href="assets/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/venobox.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/signup-style.css" />

	<!-- CRAZY EGG -->
	<script type="text/javascript">
	setTimeout(function(){var a=document.createElement("script");
	var b=document.getElementsByTagName("script")[0];
	a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0070/6890.js?"+Math.floor(new Date().getTime()/3600000);
	a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>

	<script src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.8.1/superagent.min.js"></script>

	<script>
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

		function signupHandler() {
			console.log('Save the another part of the content')
			let that = this
			let bg = document.getElementById('bg')
			let labeledTitle = document.getElementById('labeled-title')
			let intro = document.getElementById('intro')
			// let community = document.getElementById('community')
			let progression = document.getElementById('progression')
			let thePassion = document.getElementById('the-passion')
			// let whatIsYourPassion = document.getElementById('what-is-your-passion')

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
			consumerData['telField'] = document.getElementById('telField').value
		}

		function localStorageGetItem(n) { return window.localStorage.getItem(n) }

		function storageKeys() {
			return [
				'firstName', 'lastName',
				'email', 'tel'
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
			keys.forEach(k => els[k + suffix].value = store[k])
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
			bg.setAttribute('style','background-image:url(assets/img/step-02.jpg) !important;')
			thePassion.setAttribute('style','display:none;')
			theRoadmap.setAttribute('style','display:block;')
			thePassionProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:none;')
			theRoadmapProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:block;')
			consumerData['what-is-your-passion'] = document.getElementById('what-is-your-passion').value
			consumerData['when-did-you-realize-you-loved-this'] = document.getElementById('when-did-you-realize-you-loved-this').value
			consumerData['how-often-do-you-practice'] = document.getElementById('how-often-do-you-practice').value
		}

		function secondStepForward() {
			console.log('second step forward')
			let bg = document.getElementById('bg')
			let theRoadmap = document.getElementById('the-roadmap')
			let theAllure = document.getElementById('the-allure')
			let theRoadmapProgress = document.getElementById('the-roadmap-progress')
			let theAllureProgress = document.getElementById('the-allure-progress')
			bg.setAttribute('style','background-image:url(assets/img/step-03.jpg) !important;')
			theRoadmap.setAttribute('style','display:none;')
			theAllure.setAttribute('style','display:block;')
			theRoadmapProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:none;')
			theAllureProgress.setAttribute('style','margin:0;padding:0;width:50.8em;display:block;')
			consumerData['describe-the-adventure-you-want-to-create-in-a-few-words'] = document.getElementById('describe-the-adventure-you-want-to-create-in-a-few-words').value
			consumerData['how-often-will-you-take-your-travellers-out'] = document.getElementById('how-often-will-you-take-your-travellers-out').value
			consumerData['how-many-travellers-can-your-adventure-accomodate'] = document.getElementById('how-many-travellers-can-your-adventure-accomodate').value
		}

		function thirdStepForward() {
			console.log('third step forward')
			let theAllure = document.getElementById('the-allure')
			// let progression = document.getElementById('progression')
			// let completed = document.querySelector('#completed')
			theAllure.setAttribute('style','display:none;')
			// progression.setAttribute('style','display:none;')
			// completed.setAttribute('style','display:block;')
			consumerData['what-makes-your-adventure-unique'] = document.getElementById('what-makes-your-adventure-unique').value
			consumerData['tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special'] = document.getElementById('tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special').value
		  superagent
		  	.post('https://api.lyfx.co/consumers')
		  	.send(consumerData)
		  	.end((err,res) => {
		  		window.location.href = 'done.html'
		  	})
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
	</script>
</head>
<body>
	<section id="bg" class="top dark">
		<header>
			<h1 class="logo">
				<a href="/">
					<span>Lyfx</span>
					<img witdh="80" height="60" alt="Lyfx - Turn your passion into your paycheck." src='assets/img/lyfx.svg'>
				</a>
			</h1>

			<button class="menu-button" id="open-button">Open Menu</button>
			<nav>
				<ul>
					<li><a href="/">Home</a></li>
					<li><a href="/signup">Sign-up</a></li>
					<li><a href="/blog">Blog</a></li>
					<li><a href="mailto:hello@lyfx.co">Contact</a></li>
				</ul>
				<button class="close-button" id="close-button">Close Menu</button>
			</nav>
		</header>

		<article class="wrapper">
			<article id="labeled-title" class="col labeled title" style="margin-left:0 !important;">
				<h2 style="margin-bottom:0;">Let's create <br/> your adventure</h2>
				<p style="margin-top:1em !important;margin-bottom:0!important;font-size:2.3em;">Tell us a little bit about yourself so we can get started.</p>
			</article>

			<article id="progression" class="progressive-path" style="display:none;">
				<img id="the-passion-progress" style="margin:0;padding:0;width:50.8em;" src="assets/img/the-passion.png">
				<img id="the-roadmap-progress" style="margin:0;padding:0;width:50.8em;display:none" src="assets/img/the-roadmap.png">
				<img id="the-allure-progress" style="margin:0;padding:0;width:50.8em;display:none" src="assets/img/the-allure.png">
			</article>

			<!-- <article id="completed" class="col labeled title" style="margin-left:0 !important;display:none;">
				<h2 style="margin-bottom:0;">You are all set</h2>
				<p style="margin-top:1em !important;margin-bottom:0!important;font-size:2.3em;">You're now part of the lyfx community! Nice.</p>
				<p style="margin-top:1em !important;margin-bottom:0!important;font-size:2.3em;">
					You have successfully submitted your adventure application, you should
					receive an email shortly from our experience team on next steps.
				</p>
				<p style="margin-top:1em !important;margin-bottom:0!important;font-size:2.3em;">In the meantime, help us spread the word.</p>

				<ul id="sharing" class="social-networks">
					<li>
						<icon class="share-icon">
							<img src="assets/img/facebook.png" alt="">
						</icon>
						<a href="#facebook">Share on Facebook</a>
					</li>
					<li>
						<icon class="share-icon">
							<img src="assets/img/instagram.png" alt="">
						</icon>
						<a href="#instagram">Share on Instagram</a>
					</li>
					<li>
						<icon class="share-icon">
							<img src="assets/img/twitter.png" alt="">
						</icon>
						<a href="#twitter">Share on Twitter</a>
					</li>
				</ul>
			</article> -->

			<article id="appliance" class="col appliance lead" style="padding-top:3em!important;">
				<form id="intro" class="sign-up" style="margin-top:0;margin-left:1em;margin-bottom:10em;">
					<input id="uField" type="hidden" name="u" value="8c8df90f304dc08383bd3c2cc">
          <input id="idField" type="hidden" name="id" value="52a77450ef">
					<input id="firstNameField" type="text" name="firstName" placeholder="First name">
					<input id="lastNameField" type="text" name="lastName" placeholder="Last name">
					<input id="emailField" type="email" name="email" placeholder="Email Address">
					<input id="zipCodeField" type="text" name="zipCode" placeholder="Zip-code">
					<input id="telField" type="tel" name="tel" placeholder="Phone number">
					<button id="signupBtn" class="full" type="button">Start your adventure</button>
				</form>

				<form id="the-passion" class="sign-up" style="display:none;">
					<label class="specific-progression-label" for="whatIsYourPassion">
          	What is your passion?
						<input id="what-is-your-passion" style="cursor:pointer;" class="progression-field" type="text" name="whatIsYourPassion" placeholder="eg.: Hiking, Surfing and so on" autocomplete="off">
						<ul id="adventures" class="adventures-list" style="display:none;">
							<!-- <li><a href="#">Hike</a></li>
							<li><a href="#">Surf</a></li>
							<li><a href="#">Cycle</a></li> -->
						</ul>
					</label>
					<label class="specific-progression-label" for="whenDidYouRealizeYouLovedThis">
						When Did You Realize You Loved This?
						<input id="when-did-you-realize-you-loved-this" class="progression-field" type="text" name="whenDidYouRealizeYouLovedThis" placeholder="I've been doing this...">
					</label>
					<label class="specific-progression-label" for="howOftenDoYouPractice">
						How Often Do You Practice?
						<input id="how-often-do-you-practice" class="progression-field" type="text" name="howOftenDoYouPractice" placeholder="I practice every...">
					</label>
					<button id="nextBtn" class="full" type="button" onclick="firstStepForward()">Next >></button>
				</form>

				<form id="the-roadmap" class="sign-up" style="margin-top:0;margin-left:1em;margin-bottom:10em;display:none;">
					<label class="specific-progression-label" for="describeTheAdventureYouWantToCreateInAFewWords">
						Describe The Adventure You Want To Create In A Few Words:
						<!-- <input id="describe-the-adventure-you-want-to-create-in-a-few-words" class="progression-field" type="text" name="describeTheAdventureYouWantToCreateInFewWords" placeholder="Your adventure needs to be on an activity that you enjoy and are passionate about. Something that you're not only an expert at but that also brings you happiness..."> -->
						<textarea
							style="margin-top:1em;"
							name="describeTheAdventureYouWantToCreateInFewWords"
							id="describe-the-adventure-you-want-to-create-in-a-few-words"
							class="progression-field"
							cols="77"
							rows="10"
							placeholder="Your adventure needs to based on an activity that you enjoy and are passionate about.       Something that you're not only an expert at but that also brings you happiness..."></textarea>
					</label>
					<label class="specific-progression-label" for="howOftenWillYouTakeYourTravellersOut">
						How Often Will You Take Your Travellers Out?
						<input id="how-often-will-you-take-your-travellers-out" class="progression-field" type="text" name="howOftenWillYouTakeYourTravellersOut" placeholder="I'll host the adventure every...">
					</label>
					<label class="specific-progression-label" for="howManyTravellersCanYourAdventureAccommodate">
						How Many Travellers Can Your Adventure Accomodate?						
						<input id="how-many-travellers-can-your-adventure-accomodate" class="progression-field" type="text" name="howManyTravellersCanYourAdventureAccomodate" placeholder="My adventure is designed to accomodate...">
					</label>
					<button id="nextBtn" class="full" type="button" onclick="secondStepForward()">Next >></button>
				</form>

				<form id="the-allure" class="sign-up" style="margin-top:0;margin-left:1em;margin-bottom:10em;display:none;">
					<label class="specific-progression-label" for="whatMakesYourAdventureUnique">
						What Makes Your Adventure Unique?
						<textarea style="margin-top:1em;"
							name="whatMakesYourAdventureUnique"
							id="what-makes-your-adventure-unique"
							class="progression-field"
							cols="77"
							rows="10" placeholder="It could be anything. A special path that only you know, a nice little deli that you'll take your travellers to after the adventure is done. Whatever brings some uniqueness to this experience..."></textarea>
					</label>
					<label class="specific-progression-label" for="tellUsAboutTheLocationWhereYouAdventureWillTakePlaceAndWhatMakesItSpecial">
						Tell Us About The Location Where You Adventure Will Take Place And What Makes It Special?
						<input id="tell-us-about-the-location-where-your-adventure-will-take-place-and-what-makes-it-special" class="progression-field" type="text" name="tellUsAboutTheLocationWhereYourAdventureWillTakePlaceAndWhatMakesItSpecial" placeholder="My adventure will take place at...">
					</label>
					<button id="nextBtn" class="full" type="button" onclick="thirdStepForward()">Next >></button>
				</form>
			</article>

			<!-- <article id="community" class="col thumbs">
				<h3>Check out our community</h3>
				<ul class="thumbnails">
					<li><a href="#"><img src="/assets/img/thumb-01.png"></a></li>
					<li><a href="#"><img src="/assets/img/thumb-02.png"></a></li>
					<li><a href="#"><img src="/assets/img/thumb-03.png"></a></li>
					<li><a href="#"><img src="/assets/img/thumb-04.png"></a></li>
				</ul>
			</article> -->
		</article>
	</section>

	<script src="assets/js/classie.min.js"></script>
	<script src="assets/js/main.min.js"></script>
	<script src="assets/js/jquery-3.1.1.min.js"></script>
	<script  src="assets/js/venobox.min.js"></script>

	<!-- Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108095866-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-108095866-1');
	</script>
</body>
</html>
