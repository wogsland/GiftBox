<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="S!zzle - Recruiting Token">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="S!zzle - Recruiting Token">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicon.png">
    <meta name="theme-color" content="#ffffff">
    <!-- endFavicon -->

    <!-- SEO: If your mobile URL is different from the desktop URL, add a canonical link to the desktop page https://developers.google.com/webmasters/smartphone-sites/feature-phones -->
    <!--
    <link rel="canonical" href="http://www.example.com/">
    -->

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.blue-green.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/recruiting-token.css">

    <!-- jQuery -->
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous">
    </script>

    <!-- Masonry -->
    <script src="components/masonry/dist/masonry.pkgd.min.js" async></script>

    <!-- Polymer -->
    <script src="components/webcomponentsjs/webcomponents-lite.min.js" async></script>
    <link rel="import" href="components/paper-dialog/paper-dialog.html">
    <link rel="import" href="components/paper-input/paper-input.html">
    <link rel="import" href="components/paper-button/paper-button.html">
    <link rel="import" href="components/paper-styles/paper-styles.html">
    <link rel="import" href="components/paper-radio-group/paper-radio-group.html">
    <link rel="import" href="components/paper-radio-button/paper-radio-button.html">
    <link rel="import" href="components/neon-animation/neon-animated-pages.html" async>
    <link rel="import" href="components/neon-animation/neon-animations.html" async>
    <link rel="import" href="elements/description-x-card.html" async>
    <link rel="import" href="elements/image-x-card.html" async>
    <link rel="import" href="elements/location-x-card.html" async>
    <link rel="import" href="elements/video-x-card.html" async>
    <link rel="import" href="elements/x-cards-list.html">

  </head>
  <body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base fullbleed">


    <template is="dom-bind">
      <neon-animated-pages id="pages" selected="0">
          <x-cards-list id="list">
            <div class="fit layout vertical center-center" id="div-1">
              <div class="fit layout horizontal large" id="div-2">

                <div class="mdl-layout mdl-js-layout" id="div-3">
                  <main class="mdl-layout__content" on-scroll="_onTrack">
                    <div class="mdl-layout__tab-panel is-active" id="overview">
                      <div id="ordered-sections">
                        <section id="company-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" on-click="_onImagesClick">
                          <div class="mdl-grid no-padding no-margin link-finger" id="company-image-grid">
                            <div class="mdl-cell no-margin" id="company-main-image">
                              <div id="supporting-company">
                                <i id="token-tag-1" class="material-icons">business</i>
                                <i id="token-tag-2" class="gt-info-company"></i>
                              </div>
                            </div>
                            <div class="mdl-cell no-margin" id="company-secondary-images">
                              <div class="mdl-grid no-padding" style="height:337px" id="div-4">
                                <div class="no-margin" id="div-5">
                                  <img id="company-secondary-image-1" src="" class="company-secondary-image">
                                </div>
                                <div class="no-margin" id="div-6">
                                  <img id="company-secondary-image-2" src="" class="company-secondary-image">
                                </div>
                                <div class="no-margin" id="div-7">
                                  <img id="company-secondary-image-3" src="" class="company-secondary-image" style="-webkit-filter: brightness(25%);">
                                  <i id="token-tag-3" class="material-icons plus-icon--overlay">add</i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--12-col link-finger" id="company-description">
                            <div class="mdl-card__supporting-text" id="div-8">
                              <h4 id="token-tag-4" class="mdl-color-text--primary-dark">Company Information</h4>
                              <p id="company-description-text">
                              </p>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" id="job-description-section">
                          <div class="mdl-card mdl-cell mdl-cell--4-col" id="job-description-icon">
                            <div class="mdl-card__supporting-icon" id="div-9">
                              <h4 class="mdl-color-text--primary-contrast" id="briefcase-or-logo">
                                <i id="token-tag-5" class="material-icons huge-icon">work</i>
                              </h4>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--8-col" id="div-10">
                            <div class="mdl-card__supporting-text" id="div-11">
                              <h4 id="token-tag-6" class="mdl-color-text--primary-dark gt-info-jobtitle">Job Description</h4>
                              <p id="token-tag-7" class="gt-info-overview-short link-finger" on-click="_onOverviewClick">
                              </p>
                            </div>
                            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="job-description-options">
                              <a id="skills-button" href="#skills-section" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect job-description-option" on-click="_onSkillsClick">
                                Skills Required
                              </a>
                              <a id="responsibilities-button"  href="#responsibilities-section" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect job-description-option" on-click="_onResponsibilitiesClick">
                                Responsibilities
                              </a>
                              <a id="values-button"  href="#values-section" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect job-description-option" on-click="_onValuesClick">
                                Values
                              </a>
                              <a id="perks-button"  href="#perks-section" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect job-description-option" on-click="_onPerksClick">
                                Perks
                              </a>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" id="recruiter-section">
                          <div class="mdl-card mdl-cell mdl-cell--8-col" id="div-12">
                            <div class="mdl-card__supporting-text" id="div-13">
                              <i id="gt-info-recruiter-position"></i>
                              <h4 class="mdl-color-text--primary-dark" id="gt-info-recruiter-name"></h4>
                              <p id="gt-info-recruiter-bio">
                              </p>
                            </div>
                            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="recruiter-options">
                              <a id="bio-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                Full Bio
                              </a>
                              <a id="linkedin-button" target="_blank" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                LinkedIn Page
                              </a>
                              <a id="contact-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                Contact Information
                              </a>
                              <a id="email-now-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                Email Now
                              </a>
                              <a id="schedule-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                Schedule Meeting
                              </a>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--4-col" id="recruiter-face">
                            <div class="mdl-card__supporting-icon" id="div-14">
                              <h4 class="mdl-color-text--primary-contrast" id="icon-or-face">
                                <i id="token-tag-8" class="material-icons huge-icon">face</i>
                              </h4>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp social-section" id="social-section">
                          <a id="token-tag-9" href="http://twitter.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-twitter">
                            <i id="token-tag-10" class="fa fa-twitter big-icon"></i>
                          </a>
                          <a id="token-tag-11" href="http://facebook.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-facebook">
                            <i id="token-tag-12" class="fa fa-facebook big-icon"></i>
                          </a>
                          <a id="token-tag-13" href="http://linkedin.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-linkedin">
                            <i id="token-tag-14" class="fa fa-linkedin big-icon"></i>
                          </a>
                          <a id="token-tag-15" href="http://youtube.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-youtube">
                            <i id="token-tag-16" class="fa fa-youtube big-icon"></i>
                          </a>
                          <a id="token-tag-16" href="http://plus.google.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-gplus">
                            <i id="token-tag-17" class="fa fa-google-plus big-icon"></i>
                          </a>
                          <a id="token-tag-18" href="http://pinterest.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-pinterest">
                            <i id="token-tag-19" class="fa fa-pinterest big-icon"></i>
                          </a>
                        </section>

                        <section id="location-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
                          <div class="mdl-card mdl-cell mdl-cell--12-col" id="div-15">
                            <div class="mdl-grid no-padding no-margin link-finger" id="location-image-grid" on-click="_onLocationClick">
                              <div class="mdl-cell no-margin" id="location-main-image">
                                <div id="supporting-location">
                                  <i id="token-tag-20" class="material-icons">room</i>
                                  <i id="token-tag-21" class="gt-info-location"></i>
                                </div>
                              </div>
                            </div>
                            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="location-options">
                              <a id="general-location-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect location-option" on-click="_onLocationClick">
                                General
                              </a>
                              <a id="weather-location-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect location-option" on-click="_onLocationClick">
                                Weather
                              </a>
                              <a id="housing-location-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect location-option">
                                Housing
                              </a>
                              <a id="cost-location-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect location-option">
                                Cost of Living
                              </a>
                            </div>
                          </div>
                        </section>

                        <section id="doublet-location-section" class="section--center mdl-grid mdl-grid--no-spacing" on-click="_onLocationClick">
                          <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="doublet-location-image-grid-1">
                            <div class="mdl-cell no-margin" id="doublet-location-main-image-1">
                              <div id="doublet-supporting-location-1">
                                <i id="token-tag-22" class="material-icons">room</i>
                                <i id="token-tag-23" class="gt-info-location-1">Location One</i>
                              </div>
                            </div>
                          </div>
                          <div class="mdl-layout-spacer" id="div-17">
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="doublet-location-image-grid-2">
                            <div class="mdl-cell no-margin" id="doublet-location-main-image-2">
                              <div id="doublet-supporting-location-2">
                                <i id="token-tag-24" class="material-icons">room</i>
                                <i id="token-tag-25" class="gt-info-location-2">Location Two</i>
                              </div>
                            </div>
                          </div>
                        </section>

                        <section id="triplet-location-section" class="section--center mdl-grid mdl-grid--no-spacing" on-click="_onLocationClick">
                          <div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--2dp link-finger" id="triplet-location-image-grid-1">
                            <div class="mdl-cell no-margin" id="triplet-location-main-image-1">
                              <div id="triplet-supporting-location-1">
                                <i id="token-tag-26" class="material-icons">room</i>
                                <i id="token-tag-27" class="gt-info-location-1">Location One</i>
                              </div>
                            </div>
                          </div>
                          <div class="mdl-layout-spacer" id="div-18">
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--2dp link-finger" id="triplet-location-image-grid-2">
                            <div class="mdl-cell no-margin" id="triplet-location-main-image-2">
                              <div id="triplet-supporting-location-2">
                                <i id="token-tag-28" class="material-icons">room</i>
                                <i id="token-tag-29" class="gt-info-location-2">Location Two</i>
                              </div>
                            </div>
                          </div>
                          <div class="mdl-layout-spacer" id="div-19">
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--4-col mdl-shadow--2dp link-finger" id="triplet-location-image-grid-3">
                            <div class="mdl-cell no-margin" id="triplet-location-main-image-3">
                              <div id="triplet-supporting-location-3">
                                <i id="token-tag-30" class="material-icons">room</i>
                                <i id="token-tag-31" class="gt-info-location-3">Location Three</i>
                              </div>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing" id="image-video-section">
                          <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="images-frontpage" on-click="_onImagesClick">
                            <div id="supporting-images">
                              <i id="token-tag-32" class="material-icons">image</i> IMAGES
                            </div>
                          </div>
                          <div class="mdl-layout-spacer" id="div-20">
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="videos-frontpage" on-click="_onVideosClick">
                            <div id="supporting-videos">
                              <i id="token-tag-33" class="material-icons">videocam</i> VIDEOS
                            </div>
                          </div>
                        </section>
                      </div>

                      <section id="token-tag-34" class="section--footer mdl-color--light-grey mdl-grid">
                      </section>
                    </div>
                  </main>
                </div>
              </div>
            </div>
            <div>
              <button id="token-tag-35" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick" data-fab-index="0">
                <i id="token-tag-36" class="material-icons interest-thumb" data-fab-index="0">thumb_up</i>
              </button>
              <paper-dialog id="token-tag-37" class="interest-dialog" modal>
                  <div id="token-tag-38" class="interest-form">
                    <center id="token-tag-39">
                      <h2 id="token-tag-40">Interested in this job?</h2>
                    </center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button id="token-tag-41" class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button id="token-tag-42" class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button id="token-tag-43" class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      id="token-tag-44"
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-45" class="buttons">
                    <paper-button
                      id="token-tag-46"
                      class="apply-button"
                      on-click="_applyNow"
                      hidden>
                      Apply Now
                    </paper-button>
                    <paper-button
                      id="token-tag-47"
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
                      id="token-tag-48"
                      class="dismiss-interest-button"
                      dialog-dismiss
                      on-click="_closeInterestDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
              <paper-dialog id="learn-more-dialog" class="learn-more-dialog-wide" modal>
                  <div id="token-tag-49" class="learn-more-form">
                    <center>
                      <h2 id="learn-more-modal-text"></h2>
                    </center>
                    <paper-input
                      type="email"
                      id="learn-more-email"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-50" class="buttons">
                    <paper-button
                      id="token-tag-51"
                      class="learn-more-button"
                      on-click="_submitLearnMore">
                    </paper-button>
                    <paper-button
                      id="token-tag-52"
                      class="dismiss-learn-more-button"
                      dialog-dismiss
                      on-click="_closeLearnMoreDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
            </div>
          </x-cards-list>
          <location-x-card>
            <div id="token-tag-53" class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button id="token-tag-54" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick" data-fab-index="1">
                <i id="token-tag-55" class="material-icons" data-fab-index="1">thumb_up</i>
              </button>
              <paper-dialog id="token-tag-56" class="interest-dialog" modal>
                  <div id="token-tag-57" class="interest-form">
                    <center id="token-tag-58">
                      <h2 id="token-tag-59">Interested in this job?</h2>
                    </center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button id="token-tag-60" class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button id="token-tag-61" class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button id="token-tag-62" class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      id="token-tag-63"
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-64" class="buttons">
                    <paper-button
                      id="token-tag-65"
                      class="apply-button"
                      on-click="_applyNow"
                      hidden>
                      Apply Now
                    </paper-button>
                    <paper-button
                      id="token-tag-66"
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
                      id="token-tag-67"
                      class="dismiss-interest-button"
                      dialog-dismiss
                      on-click="_closeInterestDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
            </div>
          </location-x-card>
          <image-x-card>
            <div id="token-tag-68" class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button id="token-tag-69" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick" data-fab-index="2">
                <i id="token-tag-70" class="material-icons" data-fab-index="2">thumb_up</i>
              </button>
              <paper-dialog id="token-tag-71" class="interest-dialog" modal>
                  <div id="token-tag-72" class="interest-form">
                    <center id="token-tag-73">
                      <h2 id="token-tag-74">Interested in this job?</h2>
                    </center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button id="token-tag-75" class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button id="token-tag-76" class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button id="token-tag-77" class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      id="token-tag-78"
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-79" class="buttons">
                    <paper-button
                      id="token-tag-80"
                      class="apply-button"
                      on-click="_applyNow"
                      hidden>
                      Apply Now
                    </paper-button>
                    <paper-button
                      id="token-tag-81"
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
                      id="token-tag-82"
                      class="dismiss-interest-button"
                      dialog-dismiss
                      on-click="_closeInterestDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
            </div>
          </image-x-card>
          <video-x-card>
            <div id="token-tag-83" class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div id="token-tag-84">
              <button id="token-tag-85" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick" data-fab-index="3">
                <i id="token-tag-86" class="material-icons" data-fab-index="3">thumb_up</i>
              </button>
              <paper-dialog id="token-tag-87" class="interest-dialog" modal>
                  <div id="token-tag-88" class="interest-form">
                    <center id="token-tag-89">
                      <h2 id="token-tag-90">Interested in this job?</h2>
                    </center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button id="token-tag-91" class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button id="token-tag-92" class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button id="token-tag-93" class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      id="token-tag-94"
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-95" class="buttons">
                    <paper-button
                      id="token-tag-96"
                      class="apply-button"
                      on-click="_applyNow"
                      hidden>
                      Apply Now
                    </paper-button>
                    <paper-button
                      id="token-tag-97"
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
                      id="token-tag-98"
                      class="dismiss-interest-button"
                      dialog-dismiss
                      on-click="_closeInterestDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
            </div>
          </video-x-card>
          <description-x-card>
            <div id="token-tag-99" class="mdl-button mdl-js-button mdl-button--raised back-button-lower" on-click="_onBackClick">
              BACK
            </div>
            <div id="token-tag-100">
              <button id="token-tag-101" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick" data-fab-index="4">
                <i id="token-tag-102" class="material-icons" data-fab-index="4">thumb_up</i>
              </button>
              <paper-dialog id="token-tag-103" class="interest-dialog" modal>
                  <div id="token-tag-104" class="interest-form">
                    <center id="token-tag-105">
                      <h2 id="token-tag-106">Interested in this job?</h2>
                    </center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button id="token-tag-107" class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button id="token-tag-108" class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button id="token-tag-109" class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      id="token-tag-110"
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div id="token-tag-111" class="buttons">
                    <paper-button
                      id="token-tag-112"
                      class="apply-button"
                      on-click="_applyNow"
                      hidden>
                      Apply Now
                    </paper-button>
                    <paper-button
                      id="token-tag-113"
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
                      id="token-tag-114"
                      class="dismiss-interest-button"
                      dialog-dismiss
                      on-click="_closeInterestDialog">
                      Cancel
                    </paper-button>
                  </div>
              </paper-dialog>
            </div>
          </description-x-card>
      </neon-animated-pages>
    </template>

    <!-- JavaScript -->
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.min.js"></script>
    <script src="js/recruiting-token.js"></script>
  </body>
</html>
