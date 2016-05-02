<?php
use \Sizzle\Bacon\Database\User;

$user = (new User())->fetch($_SESSION['email'] ?? '');

define('TITLE', 'S!zzle - Give a Token of Appreciation');
require __DIR__.'/header.php';
?>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <!-- data -->
  <script>
    (function () {
      Stripe.setPublishableKey('<?= STRIPE_PUBLISHABLE_KEY ?>');
    })();
  </script>
</head>

<body id="pricing-page">

<!-- =========================
     HEADER
============================== -->
<header class="header" data-stellar-background-ratio="0.5" id="account-profile">

<!-- SOLID COLOR BG -->
<div class=""> <!-- To make header full screen. Use .full-screen class with solid-color. Example: <div class="solid-color full-screen">  -->
    <?php require __DIR__.'/navbar.php';?>
</div>
<!-- /END COLOR OVERLAY -->
</header>
<!-- /END HEADER -->

<!-- =========================
     PRICING SECTION
============================== -->

<section class="Pricing">
  <header class="Pricing__hero">
    <h1 class="Pricing__title">Pick a plan and get the first 30 days free.</h1>
    <p class="Pricing__message">That's right. <b>Free.</b> Use the slider to select the number of job postings you need per month, and we'll give you your first month on the house.</p>
  </header>
  <div class="Pricing__slider">
    <div class="Slider" data-min="1" data-max="200" data-value="25">
      <div class="Slider__handle"><div class="Slider__label">0</div></div>
      <input type="hidden" class="Slider__value">
    </div>
  </div>
  <ul class="Pricing__options">
    <li class="Pricing__option">
      <div class="Plan" data-min="0">
        <div class="Plan__details">
          <i class="Plan__icon fa fa-home"></i>
          <h2 class="Plan__name">Small Corp</h2>
          <span class="Plan__features"><b>1-10</b> posts per month</span>
        </div>
        <div class="Plan__buttons">
          <button class="Plan__callToAction Plan__callToAction--primary" type="button" data-billing="m" data-plan="recruiting-133">$133<sup>33</sup> / Month</button>
          <button class="Plan__callToAction" type="button" data-billing="y" data-plan="recruiting-year">$1200<sup>00</sup> / Year<div>25% savings!</div></button>
        </div>
      </div>
    </li><li class="Pricing__option">
      <div class="Plan" data-min="11">
        <div class="Plan__details">
          <i class="Plan__icon fa fa-briefcase"></i>
          <h2 class="Plan__name">Medium Corp</h2>
          <span class="Plan__features"><b>11-50</b> posts per month</span>
        </div>
        <div class="Plan__buttons">
          <button class="Plan__callToAction Plan__callToAction--primary" type="button" data-billing="m" data-plan="recruiting-midlevel">$150<sup>00</sup> / Month</button>
          <button class="Plan__callToAction" type="button" data-billing="y" data-plan="recruiting-midlevel-year">$1,350<sup>00</sup> / Year<div>25% savings!</div></button>
        </div>
      </div>
    </li><li class="Pricing__option">
      <div class="Plan" data-min="51">
        <div class="Plan__details">
          <i class="Plan__icon fa fa-building"></i>
          <h2 class="Plan__name">Large Corp</h2>
          <span class="Plan__features"><b>51-199</b> posts per month</span>
        </div>
        <div class="Plan__buttons">
          <button class="Plan__callToAction Plan__callToAction--primary" type="button" data-billing="m" data-plan="recruiting-upperlevel">$275<sup>00</sup> / Month</button>
          <button class="Plan__callToAction" type="button" data-billing="y" data-plan="recruiting-upperlevel-year">$2,475<sup>00</sup> / Year<div>25% savings!</div></button>
        </div>
      </div>
    </li><li class="Pricing__option">
      <div class="Plan" data-min="200">
        <div class="Plan__details">
          <i class="Plan__icon fa fa-globe"></i>
          <h2 class="Plan__name">Enterprise</h2>
          <span class="Plan__features"><b>200+</b> posts per month</span>
        </div>
        <div class="Plan__buttons">
          <button class="Plan__callToAction Plan__callToAction--primary" type="button">Contact us</button>
        </div>
      </div>
    </li>
  </ul>
</section>

<!-- These modals will be deleted when Stripe is used -->

<div class="modal fade"  id="contact-dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/ajax/sendemail" data-redirect="/thankyou?action=enterprise" class="Form">
        <div class ="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title Form__title" id="gridSystemModalLabel">Let's talk.</h3>
        </div>
        <div class ="modal-body">

          <p class="Form__group">For more information on our Enterprise pricing please enter your email below.</p>

          <div class="Form__group Form__feedback"></div>

          <div class="Form__group">
            <label class="Form__label">Email</label>
            <input class="Form__input" type="text" data-validation="required email" name="email" <?="value={$user->email_address}"?>>
            <input type="hidden" name="message" value="Interested in Enterprise pricing.">
          </div>

          <div class="Form__clearFix"></div>

        </div>
        <div class ="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Ok</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal 2-->

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="plan-dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/ajax/signup" data-redirect="/thankyou?action=signup" class="Form">
        <div class ="modal-header">
          <div class="modal-title Form__title" id="gridSystemModalLabel">Medium Corp <span class="Form__subtitle">$150<sup>00</sup> a month</span></div>
        </div>
        <div class ="modal-body">

          <p class="Form__group">Your first thirty days are <b>free</b>, and after that you'll be billed at the rate above!</p>

          <input type="hidden" name="stripeToken" value="">
          <input type="hidden" name="plan" value="">
          <input type="hidden" name="billing" value="">

          <div class="Form__group Form__feedback"></div>

          <div class="Form__group">
            <label class="Form__label">Email</label>
            <input class="Form__input" type="text" data-validation="required email" name="email" <?="value={$user->email_address}"?>>
          </div>

          <div class="Form__group">
            <label class="Form__label">Card number</label>
            <input class="Form__input" type="text" size="20" data-validation="required" data-stripe="number">
          </div>

          <div class="Form__group Form__group--quarter">
            <label class="Form__label">Exp MM</label>
            <input class="Form__input" type="text" size="2" data-validation="required" data-stripe="exp-month">
          </div>
          <div class="Form__group Form__group--quarter">
            <label class="Form__label">Exp YYYY</label>
            <input class="Form__input" type="text" size="4" data-validation="required" data-stripe="exp-year">
          </div>
          <div class="Form__group Form__group--half">
            <label class="Form__label">CVC</label>
            <input class="Form__input" type="text" size="4" data-validation="required" data-stripe="cvc">
          </div>

          <div class="Form__clearFix"></div>
        </div>

        <div class ="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Ok</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?php require __DIR__.'/footer.php';?>
<!-- =========================
     PAGE SPECIFIC SCRIPTS
============================== -->

</body>
</html>
