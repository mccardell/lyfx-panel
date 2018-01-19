<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lyfx - Turn your passion into your paycheck.</title>
	<meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="msapplication-tap-highlight" content="no">
	<meta name="author" content="Karen Bizanha">
	<meta name="description" content="Bring others along in your next adventure
				and earn extra money. Surfing, mountain biking, hiking, canoeing,
				rock climbing, rafting, horse riding, diving." />
	<meta name="robots" content="index,follow">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="assets/css/venobox.css">

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
		function buildScopeHandler() {
			let ctx = {}
			let uField = ctx.uField = document.getElementById('u')
			let refField = ctx.refField = document.getElementById('ref')
			let firstNameField = ctx.firstNameField = document.getElementById('firstName')
			let lastNameField = ctx.lastNameField = document.getElementById('lastName')
			let emailField = ctx.emailField = document.getElementById('email')
			let emailNewsletter = ctx.emailNewsletterField = document.getElementById('emailNewsletter')
			let cityField = ctx.cityField = document.getElementById('city')
			let telField = ctx.telField = document.getElementById('tel')
			return ctx
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

		function checkSignupProcessHandler() {
			let self = this
			if (isFieldEmpty.call(self.that,'firstName')) {
				self.ctx = swal(buildAlertScope('First Name'))
				self.ctx.isDone = false
			} else if (isFieldEmpty.call(self.that,'lastName')) {
				self.ctx = swal(buildAlertScope('Last Name'))
				self.ctx.isDone = false
			} else if (isFieldEmpty.call(self.that,'email')) {
				self.ctx = swal(buildAlertScope('E-mail'))
				self.ctx.isDone = false
			} else if (isFieldEmpty.call(self.that,'city')) {
				self.ctx = swal(buildAlertScope('City'))
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
						superagent.post(url).send({
							uField: scope.uField.value,
							refField: scope.refField.value,
							firstName: scope.firstNameField.value,
							lastName: scope.lastNameField.value,
							email: scope.emailField.value,
							phone: scope.telField.value,
						}).end((err,res) => {
							swal({
								title: 'GREAT',
								text: 'Successfully done.',
								icon: 'success'
							}).then((res) => {
								saveContext(scope)
								if (res) window.location.href = '/signup.html';
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
								if (res) window.location.href = '/done.html';
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
			e.preventDefault()
		}

		function loadHandler() {
			let signupBtn = document.getElementById('signupBtn')
			let newsletterSubmitBtn = document.getElementById('newsletterSubmitBtn')

			signupBtn.onclick = signupSubmitHandler
			newsletterSubmitBtn.onclick = newsletterSubmitHandler
		}
		window.onload = loadHandler
	</script>
</head>
<body>
	<!-- START HEADER -->
	<header>

		<h1 class="logo"><a href="/">
			<span>Lyfx</span>
			<img alt="Lyfx - Turn your passion into your paycheck." src='assets/img/lyfx.svg'>
		</a></h1>

		<button class="menu-button" id="open-button">Open Menu</button>
		<nav>
			<ul>
				<li><a href="/">Home</a></li>
				<li><a href="/signup.html">Sign-up</a></li>
				<li><a href="/blog">Blog</a></li>
				<li><a href="mailto:hello@lyfx.co">Contact</a></li>
			</ul>
			<button class="close-button" id="close-button">Close Menu</button>
		</nav>
	</header>


	<!-- START SIGN UP -->
	<section class="top dark">
		<div class="wrapper">
			<div class="col title">
				<h2>
					Turn your passion into your paycheck.
				</h2>
			</div>
			<div class="col lead">
				<form class="sign-up">
					<input id="u" type="hidden" name="u" value="8c8df90f304dc08383bd3c2cc">
          <input id="ref" type="hidden" name="id" value="52a77450ef">
					<input id="firstName" type="text" name="firstName" placeholder="First name">
					<input id="lastName" type="text" name="lastName" placeholder="Last name">
					<input id="email" type="email" name="email" placeholder="Email Address">
					<input id="city" type="text" name="city" placeholder="City">
					<input id="tel" type="tel" name="phone" placeholder="Phone number">
					<button id="signupBtn" class="full" type="button">Ok, Let's do it!</button>
				</form>
			</div>
		</div>
	</section>


	<!-- START SELECT ACTIVITE
	<section class="activities dark">
		<div class="wrapper">
		<h2>See How Much You Can Make</h2>
		<form action="" class="select-activity">
			<input type="text" placeholder="City">
			<select id="dropdown" class="select">
				<option selected>Select your activity</option>
				<option value="">Motorcyclism</option>
				<option value="">Bicycle</option>
				<option value="">Surf</option>
				<option value="">Campaing</option>
			</select>
			<button type="submit">Let's Start</button>
		</form>
		</div>
	</section>
	 END SELECT ACTIVITE -->


	<!-- START APP SCREEN -->
	<section class="app-screen light">
		<div class="wrapper">
			<div class="col c_7-12">
				<h2>You are the local expert.</h2>

				<p>Use your expertise to create an unforgettable authentic experience.</p>

				<p>Bring others along on your next adventure
				and earn extra money.</p>

				<p>Surfing, mountain biking, hiking, canoeing,
				rock climbing, rafting, horse riding, diving.</p>

				<p>Whatever your passion is, you can now share
				it with like minded people.</p>

				<!-- <button class="outline">Learn More</button> -->
			</div>
			<div class="col c_5-12">
				<figure>
					<img src="assets/img/mockup.png" alt="Lyfx Mockup">
				</figure>
			</div>
		</div>
	</section>


	<!-- START LEARN MORE -->
	<section class="learn-more dark">
		<div class="wrapper">
			<div class="col c_6-12 right">
				<h2>Connect<br>With Other Adventurers.</h2>
				<p>Picture this: an app that connects travelers with a local guide who creates a personal, unique and unforgettable outdoor experience. Travelers get off the beaten path and locals have the opportunity to turn their passion into their paycheck. Surfing, skiing, hiking, biking, and snowboarding. And that’s just the beginning.</p>

				<!-- <button class="outline">Learn More</button> -->
			</div>
		</div>
	</section>


	<!-- START VIDEO -->
	<section class="video dark">
		<div class="wrapper">
			<!-- <h2>What Is Stopping You Now?</h2> -->
			<a
				class="venobox"
				data-autoplay="true"
				data-title="Lyfx - Turn your passion into your paycheck."
				data-vbtype="video"
				href="https://vimeo.com/246453179/c8f0f3145e">
				<button class="play">Play</button>
			</a>
			</div>
	</section>


	<!-- START NEWSLETTER -->
	<section class="newsletter dark">
		<div class="wrapper">
		<h2>Stay Up To Date</h2>
		<p>This is your backyard, share your expertise, earn extra cash.</p>
		<form action="#newsletter" class="newsletter">
			<!-- <input type="hidden" name="uField" value="8c8df90f304dc08383bd3c2cc">
      <input type="hidden" name="idField" value="ef9323608d"> -->
			<input type="email" name="emailNewsletter" id="emailNewsletter" placeholder="Email Address">
			<button id="newsletterSubmitBtn" class="full" type="submit">Subscribe</button>
		</form>
		</div>
	</section>


	<!-- START FOOTER -->
	<footer>

		<div class="wrapper">

			<!-- COLUMN 1 -->
			<div class="col c_4-12">
				<h1 class="logo"><a href="/">
					<span>Lyfx</span>
					<img alt="Lyfx" src='assets/img/lyfx-footer.svg'>
				</a></h1>
			</div>

			<!-- COLUMN 2 -->
			<div class="col c_4-12">
				<p>1450 2nd St Santa Monica, CA, USA<br>
				CA 90292 - USA</p>
				<p><a href="mailto:hello@lyfx.co">hello@lyfx.co</a></p>
			</div>

			<!-- COLUMN 3 -->
			<div class="col c_4-12">
				<ul class="social">
					<li><a href="https://www.facebook.com/lyfx.co/" target="_blank"><i class="fa fa-facebook fa-3x"></i></a></li>
					<li><a href="https://www.instagram.com/lyfx.co/" target="_blank"><i class="fa fa-instagram fa-3x"></i></a></li>
				</ul>
				<p class="copyright">© 2017 Lyfx.co</p>
			</div>

		</div>
	</footer>

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
