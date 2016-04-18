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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

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
            <div class="fit layout vertical center-center">
              <div class="fit layout horizontal large">

                <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
                  <header class="mdl-layout__header">
                    <!-- Top row, always visible -->
                    <div class="mdl-layout__header-row">
                      <span class="mdl-layout-title long-title">
                        <i class="gt-info-title"></i>
                      </span>
                      <div class="mdl-layout-spacer"></div>
                    </div>
                  </header>

                  <main class="mdl-layout__content" on-scroll="_onTrack">
                    <div class="mdl-layout__tab-panel is-active" id="overview">
                      <div id="ordered-sections">
                        <section id="company-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" on-click="_onImagesClick">
                          <div class="mdl-grid no-padding no-margin link-finger" id="company-image-grid">
                            <div class="mdl-cell no-margin" id="company-main-image">
                              <div id="supporting-company">
                                <i class="material-icons">business</i>
                                <i class="gt-info-company"></i>
                              </div>
                            </div>
                            <div class="mdl-cell no-margin" id="company-secondary-images">
                              <div class="mdl-grid no-padding" style="height:337px">
                                <div class="no-margin">
                                  <img id="company-secondary-image-1" src="" class="company-secondary-image">
                                </div>
                                <div class="no-margin">
                                  <img id="company-secondary-image-2" src="" class="company-secondary-image">
                                </div>
                                <div class="no-margin">
                                  <img id="company-secondary-image-3" src="" class="company-secondary-image" style="-webkit-filter: brightness(25%);">
                                  <i class="material-icons plus-icon--overlay">add</i>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--12-col link-finger" id="company-description">
                            <div class="mdl-card__supporting-text">
                              <h4 class="mdl-color-text--primary-dark">Company Information</h4>
                              <p id="company-description-text">
                              </p>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" id="job-description-section">
                          <div class="mdl-card mdl-cell mdl-cell--4-col" id="job-description-icon">
                            <div class="mdl-card__supporting-icon">
                              <h4 class="mdl-color-text--primary-contrast" id="briefcase-or-logo">
                                <i class="material-icons huge-icon">work</i>
                              </h4>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--8-col">
                            <div class="mdl-card__supporting-text">
                              <h4 class="mdl-color-text--primary-dark gt-info-jobtitle">Job Description</h4>
                              <p class="gt-info-overview-short link-finger" on-click="_onOverviewClick">
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
                          <div class="mdl-card mdl-cell mdl-cell--8-col">
                            <div class="mdl-card__supporting-text">
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
                              <a id="schedule-button" class="mdl-cell mdl-cell--3-col mdl-cell--2-col-phone mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect recruiter-profile-option">
                                Schedule Meeting
                              </a>
                            </div>
                          </div>
                          <div class="mdl-card mdl-cell mdl-cell--4-col" id="recruiter-face">
                            <div class="mdl-card__supporting-icon">
                              <h4 class="mdl-color-text--primary-contrast" id="icon-or-face">
                                <i class="material-icons huge-icon">face</i>
                              </h4>
                            </div>
                          </div>
                        </section>

                        <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp social-section" id="social-section">
                          <a href="http://twitter.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-twitter">
                            <i class="fa fa-twitter big-icon"></i>
                          </a>
                          <a href="http://facebook.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-facebook">
                            <i class="fa fa-facebook big-icon"></i>
                          </a>
                          <a href="http://linkedin.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-linkedin">
                            <i class="fa fa-linkedin big-icon"></i>
                          </a>
                          <a href="http://youtube.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-youtube">
                            <i class="fa fa-youtube big-icon"></i>
                          </a>
                          <a href="http://plus.google.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-gplus">
                            <i class="fa fa-google-plus big-icon"></i>
                          </a>
                          <a href="http://pinterest.com" target="_blank" class="mdl-cell--2-col mdl-cell--2-col-phone mdl-button--raised mdl-js-ripple-effect mdl-color-text--primary-contrast frontpage-social-button gt-info-pinterest">
                            <i class="fa fa-pinterest big-icon"></i>
                          </a>
                        </section>

                        <section id="location-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" on-click="_onLocationClick">
                          <div class="mdl-grid no-padding no-margin link-finger" id="location-image-grid">
                            <div class="mdl-cell no-margin" id="location-main-image">
                              <div id="supporting-location">
                                <i class="material-icons">room</i>
                                <i class="gt-info-location"></i>
                              </div>
                            </div>
                            <div class="mdl-cell no-margin" id="location-secondary-images">
                              <div class="mdl-grid no-padding" style="height:337px">
                                <div class="no-margin">
                                  <img id="location-secondary-image-1" src="" class="location-secondary-image">
                                </div>
                                <div class="no-margin">
                                  <img id="location-secondary-image-2" src="" class="location-secondary-image">
                                </div>
                                <div class="no-margin">
                                  <img id="location-secondary-image-3" src="" class="location-secondary-image" style="-webkit-filter: brightness(25%);">
                                  <i class="material-icons plus-icon--overlay">add</i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                      </div>

                      <section class="section--center mdl-grid mdl-grid--no-spacing">
                        <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="images-frontpage" on-click="_onImagesClick">
                          <div id="supporting-images">
                            <i class="material-icons">image</i> IMAGES
                          </div>
                        </div>
                        <div class="mdl-layout-spacer">
                        </div>
                        <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp link-finger" id="videos-frontpage" on-click="_onVideosClick">
                          <div id="supporting-videos">
                            <i class="material-icons">videocam</i> VIDEOS
                          </div>
                        </div>
                      </section>

                      <section class="section--footer mdl-color--light-grey mdl-grid">
                      </section>
                    </div>
                  </main>
                  <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick">
                    <i class="material-icons interest-thumb">thumb_up</i>
                  </button>
                  <paper-dialog class="interest-dialog" modal>
                      <div class="interest-form">
                        <center><h2>Interested in this job?</h2></center>
                        <paper-radio-group selected="Yes" id="interest-response">
                          <paper-radio-button class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                          <paper-radio-button class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                          <paper-radio-button class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                        </paper-radio-group>
                        <paper-input
                          type="email"
                          class="email-paper-input"
                          label="email address"
                          autofocus
                          error-message="Please input a valid email"
                          required>
                        </paper-input>
                      </div>
                      <div class="buttons">
                        <paper-button
                          class="submit-interest-button"
                          on-click="_submitInterest">
                          Submit
                        </paper-button>
                        <paper-button
                          class="dismiss-interest-button"
                          dialog-dismiss
                          on-click="_closeInterestDialog">
                          Cancel
                        </paper-button>
                      </div>
                  </paper-dialog>
                  <!--<div class="arrow-down"></div>-->
                </div>
              </div>
            </div>
          </x-cards-list>
          <location-x-card>
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick">
                <i class="material-icons">thumb_up</i>
              </button>
              <paper-dialog class="interest-dialog" modal>
                  <div class="interest-form">
                    <center><h2>Interested in this job?</h2></center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div class="buttons">
                    <paper-button
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
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
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick">
                <i class="material-icons">thumb_up</i>
              </button>
              <paper-dialog class="interest-dialog" modal>
                  <div class="interest-form">
                    <center><h2>Interested in this job?</h2></center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div class="buttons">
                    <paper-button
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
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
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick">
                <i class="material-icons">thumb_up</i>
              </button>
              <paper-dialog class="interest-dialog" modal>
                  <div class="interest-form">
                    <center><h2>Interested in this job?</h2></center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div class="buttons">
                    <paper-button
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
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
            <div class="mdl-button mdl-js-button mdl-button--raised back-button-lower" on-click="_onBackClick">
              BACK
            </div>
            <div>
              <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect interest-fab" on-click="_onInterestClick">
                <i class="material-icons">thumb_up</i>
              </button>
              <paper-dialog class="interest-dialog" modal>
                  <div class="interest-form">
                    <center><h2>Interested in this job?</h2></center>
                    <paper-radio-group selected="Yes" id="interest-response">
                      <paper-radio-button class="interest-radio-button" name="Yes" value="yes">Yes, I'm interested</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="Maybe" value="maybe">Maybe</paper-radio-button><br />
                      <paper-radio-button class="interest-radio-button" name="No" value="no">No, not for me</paper-radio-button>
                    </paper-radio-group>
                    <paper-input
                      type="email"
                      class="email-paper-input"
                      label="email address"
                      autofocus
                      error-message="Please input a valid email"
                      required>
                    </paper-input>
                  </div>
                  <div class="buttons">
                    <paper-button
                      class="submit-interest-button"
                      on-click="_submitInterest">
                      Submit
                    </paper-button>
                    <paper-button
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
