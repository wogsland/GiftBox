<?php
if (ENVIRONMENT == 'production') {
  include __DIR__.'/error.php';die;
} else {
  define('TITLE', 'S!zzle - API Documentation');
  require __DIR__.'/header.php';
?>
  <link href='/css/reset.min.css' media='screen' rel='stylesheet' type='text/css'/>
  <link href='/css/swagger-screen.min.css' media='screen' rel='stylesheet' type='text/css'/>
  <link href='/css/reset.min.css' media='print' rel='stylesheet' type='text/css'/>
  <link href='/css/swagger-print.min.css' media='print' rel='stylesheet' type='text/css'/>
  <style>
  #resources_container {
    text-align: left;
    max-width: 980px;
  }
  .sizzle-nav-choice {
    font-family: 'Roboto',sans-serif;
  }
  </style>
  <script src='/js/jquery.slideto.min.js' type='text/javascript'></script>
  <script src='/js/jquery.wiggle.min.js' type='text/javascript'></script>
  <script src='/js/jquery.ba-bbq.min.js' type='text/javascript'></script>
  <script src='/js/handlebars-2.0.0.min.js' type='text/javascript'></script>
  <script src='/js/underscore-min.js' type='text/javascript'></script>
  <script src='/js/backbone-min.js' type='text/javascript'></script>
  <script src='/js/swagger-ui.min.js' type='text/javascript'></script>
  <script src='/js/highlight.7.3.pack.js' type='text/javascript'></script>
  <script src='/js/jsoneditor.min.js' type='text/javascript'></script>
  <script src='/js/marked.min.js' type='text/javascript'></script>
  <script src='/js/swagger-oauth.min.js' type='text/javascript'></script>

  <script type="text/javascript">
    $(function () {
      var url = window.location.search.match(/url=([^&]+)/);
      if (url && url.length > 1) {
        url = decodeURIComponent(url[1]);
      } else {
        url = "../js/api-v1.json";
      }

      window.swaggerUi = new SwaggerUi({
        url: url,
        dom_id: "swagger-ui-container",
        supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
        onComplete: function(swaggerApi, swaggerUi){
          if(typeof initOAuth == "function") {
            initOAuth({
              clientId: "your-client-id",
              clientSecret: "your-client-secret-if-required",
              realm: "your-realms",
              appName: "your-app-name",
              scopeSeparator: ",",
              additionalQueryStringParams: {}
            });
          }

          $('pre code').each(function(i, e) {
            hljs.highlightBlock(e)
          });

          addApiKeyAuthorization();
        },
        onFailure: function(data) {
          log("Unable to Load SwaggerUI");
        },
        docExpansion: "none",
        jsonEditor: false,
        apisSorter: "alpha",
        defaultModelRendering: 'schema',
        showRequestHeaders: false
      });

      function addApiKeyAuthorization(){
        var key = encodeURIComponent($('#input_apiKey')[0].value);
        if(key && key.trim() != "") {
            var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("api_key", key, "query");
            window.swaggerUi.api.clientAuthorizations.add("api_key", apiKeyAuth);
            log("added key " + key);
        }
      }

      $('#input_apiKey').change(addApiKeyAuthorization);

      // if you have an apiKey you would like to pre-populate on the page for demonstration purposes...
      /*
        var apiKey = "myApiKeyXXXX123456789";
        $('#input_apiKey').val(apiKey);
      */

      window.swaggerUi.load();

      function log() {
        if ('console' in window) {
          console.log.apply(console, arguments);
        }
      }
  });
  </script>
</head>

<body class="swagger-section" style="background-color:white; text-align:left; margin-top:100px; color: black;">
  <?php require __DIR__.'/navbar.php';?>
  <?php /*
  <div id='header'>
    <div class="swagger-ui-wrap">
      <a href="http://swagger.io">
        <img src="/assets/img/sizzle-logo.png" style="max-height: 30px;"/>
      </a>
      <form id='api_selector'>
        <!--<div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>-->
        <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
        <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
      </form>
    </div>
  </div>*/?>

  <div id="message-bar" class="swagger-ui-wrap" data-sw-translate style="margin-top:100px;">&nbsp;</div>
  <div class="input" style="text-align:right;">
    <input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/>
  </div>
  <div id="swagger-ui-container" class="swagger-ui-wrap" style="margin-bottom:100px;"></div>
  <div style="text-align:center; font-family: 'Roboto',sans-serif;">
    Or you can use one of our SDKs:<br /><br />
    <a href="#" target=csharpsdk>C#</a> |
    <a href="#" target=javasdk>Java</a> |
    <a href="https://packagist.org/packages/gosizzle/sizzle-php-sdk" target=phpsdk>PHP</a> |
    <a href="#" target=pythonsdk>Python</a> |
    <a href="#" target=rubysdk>Ruby</a>
  </div>
  <div style="text-align:center; font-family: 'Roboto',sans-serif;">
    <?php require __DIR__.'/footer.php';?>
  </div>
</body>
</html>
<?php }?>
