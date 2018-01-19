@extends('frontend.default.pages.1column')

@section('content')

	
	<section id="bg" class="top dark">
	    @if((isset($page))&&($page == 'signup'))
	            @include('frontend.default.pages.html.header')
        @endif
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
					<input id="zipCodeField" type="text" name="zipCode" onkeypress='validateZip(event)' placeholder="Zip-code">
					<div class="text-error"></div>
					<input id="cityField" type="text" name="city" placeholder="City" readonly>
					<input id="stateField" type="text" name="state" placeholder="State" readonly>
					<input id="telField" type="tel" name="tel" onkeypress='validateNumber(event)' placeholder="Phone number">
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
						<!-- <input id="describe-the-adventure-you-want-to-create-in-a-few-words" class="progression-field" type="text" name="describeTheAdventureYouWantToCreateInAFewWords" placeholder="Your adventure needs to be on an activity that you enjoy and are passionate about. Something that you're not only an expert at but that also brings you happiness..."> -->
						<textarea
							style="margin-top:1em;"
							name="describeTheAdventureYouWantToCreateInAFewWords"
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
					<label class="specific-progression-label" for="howManyTravellersCanYourAdventureAccomodate">
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
						<input id="tell-us-about-the-location-where-you-adventure-will-take-place-and-what-makes-it-special" class="progression-field" type="text" name="tellUsAboutTheLocationWhereYouAdventureWillTakePlaceAndWhatMakesItSpecial" placeholder="My adventure will take place at...">
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
@stop