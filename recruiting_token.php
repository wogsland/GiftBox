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
  	<link rel="apple-touch-icon" sizes="57x57" href="/assets/gt-favicons.ico/apple-icon-57x57.png">
  	<link rel="apple-touch-icon" sizes="60x60" href="/assets/gt-favicons.ico/apple-icon-60x60.png">
  	<link rel="apple-touch-icon" sizes="72x72" href="/assets/gt-favicons.ico/apple-icon-72x72.png">
  	<link rel="apple-touch-icon" sizes="76x76" href="/assets/gt-favicons.ico/apple-icon-76x76.png">
  	<link rel="apple-touch-icon" sizes="114x114" href="/assets/gt-favicons.ico/apple-icon-114x114.png">
  	<link rel="apple-touch-icon" sizes="120x120" href="/assets/gt-favicons.ico/apple-icon-120x120.png">
  	<link rel="apple-touch-icon" sizes="144x144" href="/assets/gt-favicons.ico/apple-icon-144x144.png">
  	<link rel="apple-touch-icon" sizes="152x152" href="/assets/gt-favicons.ico/apple-icon-152x152.png">
  	<link rel="apple-touch-icon" sizes="180x180" href="/assets/gt-favicons.ico/apple-icon-180x180.png">
  	<link rel="icon" type="image/png" sizes="192x192"  href="/assets/gt-favicons.ico/android-icon-192x192.png">
  	<link rel="icon" type="image/png" sizes="32x32" href="/assets/gt-favicons.ico/favicon-32x32.png">
  	<link rel="icon" type="image/png" sizes="96x96" href="/assets/gt-favicons.ico/favicon-96x96.png">
  	<link rel="icon" type="image/png" sizes="16x16" href="/assets/gt-favicons.ico/favicon-16x16.png">
  	<link rel="manifest" href="/assets/gt-favicons.ico/manifest.json">
  	<meta name="msapplication-TileColor" content="#ffffff">
  	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
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
    <link rel="import" href="components/paper-styles/paper-styles.html">
    <link rel="import" href="components/neon-animation/neon-animated-pages.html" async>
    <link rel="import" href="components/neon-animation/neon-animations.html" async>
    <link rel="import" href="elements/description-x-card.html" async>
    <link rel="import" href="elements/image-x-card.html" async>
    <link rel="import" href="elements/location-x-card.html" async>
    <link rel="import" href="elements/video-x-card.html" async>
    <link rel="import" href="elements/x-card.html" async>
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

                      <section id="company-section" class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" on-click="_onImagesClick">
                        <div class="mdl-grid no-padding no-margin" id="company-image-grid">
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
                        <div class="mdl-card mdl-cell mdl-cell--12-col" id="company-description">
                          <div class="mdl-card__supporting-text">
                            <h4 class="mdl-color-text--primary-dark">Company Information</h4>
                            <p id="company-description-text">
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sit amet laoreet orci. Ut id massa ut diam ultrices convallis at nec elit. Suspendisse efficitur pellentesque sapien vel gravida. Praesent vitae vehicula lorem. Phasellus bibendum nunc tristique suscipit feugiat. Vestibulum in placerat urna. Curabitur malesuada ex vitae convallis vulputate.
                              Nulla facilisi. Phasellus a nisl sit amet nisi ullamcorper mattis non a dui. Fusce sit amet pellentesque urna. Nunc non orci dolor. Duis maximus felis in nisi finibus, ut tristique diam sodales. In sed egestas nisl, et vestibulum urna. Fusce mollis sed est sit amet viverra. Suspendisse sed velit non arcu lobortis iaculis et et arcu.
                            </p>
                          </div>
                        </div>
                      </section>

                      <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
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
                            <p class="gt-info-overview-short" on-click="_onOverviewClick">
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

                      <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp social-section">
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
                      <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp" on-click="_onLocationClick">
                        <div class="mdl-card mdl-cell mdl-cell--12-col" id="location-frontpage">
                          <div id="supporting-location">
                            <i class="material-icons">room</i>
                            <i class="gt-info-location"></i>
                          </div>
                        </div>
                      </section>
                      <section class="section--center mdl-grid mdl-grid--no-spacing">
                        <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp" id="images-frontpage" on-click="_onImagesClick">
                          <div id="supporting-images">
                            <i class="material-icons">image</i> IMAGES
                          </div>
                        </div>
                        <div class="mdl-layout-spacer">
                        </div>
                        <div class="mdl-card mdl-cell mdl-cell--6-col mdl-shadow--2dp" id="videos-frontpage" on-click="_onVideosClick">
                          <div id="supporting-videos">
                            <i class="material-icons">videocam</i> VIDEOS
                          </div>
                        </div>
                      </section>
                      <section class="section--footer mdl-color--light-grey mdl-grid">
                      </section>
                    </div>
                  </main>
                </div>
              </div>
            </div>
            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="interested-row">
              <div id="interested-disabled-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-color--primary-dark"  on-click="_onYesClick">Interested?</div>
              <div id="interested-yes-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onYesClick">
                YES
              </div>
              <div id="interested-maybe-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onMaybeClick">
                MAYBE
              </div>
              <div id="interested-no-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onNoClick">
                NO
              </div>
            </div>
          </x-cards-list>
          <x-card>
            <div class="fit layout vertical center-center">
              <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
                BACK
              </div>
              <h2 class="mdl-color-text--primary-dark">Yes</h2>
              <div id="yes-content">
                <p>
                  I'm interested in this position. Tell me more.
                </p>
                <form id="yes-email-form">
                  <div class="mdl-textfield mdl-js-textfield">
                    <input type="email" class="mdl-textfield__input" id="yes-email" name="email">
                    <label class="mdl-textfield__label" for="email">Email</label>
                  </div>
                </form>
                <div>
                  <button id="yes-submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Submit</button>
                </div>
              </div>
            </div>
          </x-card>
          <x-card>
            <div class="fit layout vertical center-center">
              <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
                BACK
              </div>
              <h2 class="mdl-color-text--primary-dark">Maybe</h2>
              <div id="maybe-content">
                <p>
                  I might be interested in this position. Tell me more.
                </p>
                <form id="maybe-email-form">
                  <div class="mdl-textfield mdl-js-textfield">
                    <input type="email" class="mdl-textfield__input" id="maybe-email" name="email">
                    <label class="mdl-textfield__label" for="email">Email</label>
                  </div>
                </form>
                <div>
                  <button id="maybe-submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Submit</button>
                </div>
              </div>
            </div>
          </x-card>
          <x-card>
            <div class="fit layout vertical center-center">
              <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
                BACK
              </div>
              <h2 class="mdl-color-text--primary-dark">No</h2>
              <div id="no-content">
                <p>
                  No, I'm not interested right now.
                </p>
                <form id="no-email-form">
                  <div class="mdl-textfield mdl-js-textfield">
                    <input type="email" class="mdl-textfield__input" id="no-email" name="email">
                    <label class="mdl-textfield__label" for="email">Email</label>
                  </div>
                </form>
                <div>
                  <button id="no-submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">Submit</button>
                </div>
              </div>
            </div>
          </x-card>
          <location-x-card>
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="interested-row">
              <div id="interested-disabled-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-color--primary-dark"  on-click="_onYesClick">Interested?</div>
              <div id="interested-yes-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onYesClick">
                YES
              </div>
              <div id="interested-maybe-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onMaybeClick">
                MAYBE
              </div>
              <div id="interested-no-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onNoClick">
                NO
              </div>
            </div>
          </location-x-card>
          <image-x-card>
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="interested-row">
              <div id="interested-disabled-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-color--primary-dark"  on-click="_onYesClick">Interested?</div>
              <div id="interested-yes-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onYesClick">
                YES
              </div>
              <div id="interested-maybe-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onMaybeClick">
                MAYBE
              </div>
              <div id="interested-no-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onNoClick">
                NO
              </div>
            </div>
          </image-x-card>
          <video-x-card>
            <div class="mdl-button mdl-js-button mdl-button--raised back-button" on-click="_onBackClick">
              BACK
            </div>
            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="interested-row">
              <div id="interested-disabled-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-color--primary-dark"  on-click="_onYesClick">Interested?</div>
              <div id="interested-yes-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onYesClick">
                YES
              </div>
              <div id="interested-maybe-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onMaybeClick">
                MAYBE
              </div>
              <div id="interested-no-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onNoClick">
                NO
              </div>
            </div>
          </video-x-card>
          <description-x-card>
            <div class="mdl-button mdl-js-button mdl-button--raised back-button-lower" on-click="_onBackClick">
              BACK
            </div>
            <div class="mdl-row section--center mdl-grid mdl-grid--no-spacing" id="interested-row">
              <div id="interested-disabled-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-color--primary-dark"  on-click="_onYesClick">Interested?</div>
              <div id="interested-yes-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onYesClick">
                YES
              </div>
              <div id="interested-maybe-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onMaybeClick">
                MAYBE
              </div>
              <div id="interested-no-button" class="mdl-cell--3-col mdl-cell--1-col-phone mdl-button mdl-js-button interested-button mdl-button--raised mdl-js-ripple-effect" on-click="_onNoClick">
                NO
              </div>
            </div>
          </description-x-card>
      </neon-animated-pages>
    </template>

    <!-- JavaScript -->
    <script src="https://storage.googleapis.com/code.getmdl.io/1.0.5/material.min.js"></script>
    <script src="js/recruiting-token.js"></script>
  </body>
</html>
