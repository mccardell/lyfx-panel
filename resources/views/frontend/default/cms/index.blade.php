@extends('frontend.default.pages.1column')

@section('content')

	<!-- START SIGN UP -->
	<section class="top dark">
		<div class="wrapper">
			<div class="col title">
				<h2>
					Turn your passion into your paycheck.
				</h2>
			</div>
			<div class="col lead">
				<form id="intro" class="sign-up">
					<input id="u" type="hidden" name="u" value="8c8df90f304dc08383bd3c2cc">
      				<input id="ref" type="hidden" name="id" value="52a77450ef">
					<input id="firstName" type="text" name="firstName" placeholder="First name">
					<input id="lastName" type="text" name="lastName" placeholder="Last name">
					<input id="email" type="email" name="email" placeholder="Email Address">
					<input id="zipCode" type="text" name="zipCode" onkeypress='validateZip(event)' placeholder="Zip-code">
					<div class="text-error"></div>
					<input id="city" type="text" name="city" placeholder="City" readonly>
					<input id="state" type="text" name="state" placeholder="State" readonly>
					<input id="tel" type="tel" name="phone" onkeypress='validateNumber(event)' placeholder="Phone number">
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
					<img src="{{ url('/assets/img/mockup.png') }}" alt="Lyfx Mockup">
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
@stop