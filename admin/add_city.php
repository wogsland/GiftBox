<?php
use \GiveToken\RecruitingTokenResponse;

require_once __DIR__.'/../config.php';
if (!logged_in() || !is_admin()) {
    header('Location: '.$app_root);
}
//echo '<pre>';print_r($_SESSION);die;
//echo '<pre>';print_r($_POST);die;

define('TITLE', 'GiveToken.com - Add City');
require __DIR__.'/../header.php';
?>
<style>
body {
  background-color: white;
}
#city-form {
  margin-top: 100px;
}
</style>
</head>
<body id="add-city-body">
  <div>
    <?php require __DIR__.'/../navbar.php';?>
  </div>
  <div class="row" id="city-form">
    <div class="col-sm-offset-3 col-sm-6">
      <h1>Create City</h1>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" id="cityName" placeholder="City Name" required>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input type="file" id="exampleInputFile" required>
          <p class="help-block">Please only upload public domain photos.</p>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="population" placeholder="Population" required>
        </div>
        <div class="form-group col-sm-6">
          <input type="text" class="form-control" id="longitude" placeholder="Longitude" required>
        </div>
        <div class="form-group col-sm-6">
          <input type="text" class="form-control" id="latitude" placeholder="Latitude" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="county" placeholder="County" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="country" placeholder="Country" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="timezone" placeholder="Timezone" required>
        </div>
        <h3>Temperatures</h3>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_spring" placeholder="Spring High" required>
          <input type="text" class="form-control" id="temp_lo_spring" placeholder="Spring Low" required>
          <input type="text" class="form-control" id="temp_avg_spring" placeholder="Spring Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_summer" placeholder="Summer High" required>
          <input type="text" class="form-control" id="temp_lo_summer" placeholder="Summer Low" required>
          <input type="text" class="form-control" id="temp_avg_summer" placeholder="Summer Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_fall" placeholder="Fall High" required>
          <input type="text" class="form-control" id="temp_lo_fall" placeholder="Fall Low" required>
          <input type="text" class="form-control" id="temp_avg_fall" placeholder="Fall Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_winter" placeholder="Winter High" required>
          <input type="text" class="form-control" id="temp_lo_winter" placeholder="Winter Low" required>
          <input type="text" class="form-control" id="temp_avg_winter" placeholder="Winter Average" required>
        </div>
        <button type="submit" class="btn btn-success" id="submit-city">Submit</button>
      </form>
    </div>
  </div>
  <?php require __DIR__.'/../footer.php';?>
  <script>
  $(document).ready(function(){
    $('#submit-city').on('click', function (event) {
      event.preventDefault();
      url = '/ajax/city/add';
      $.post(url, '', function(data) {
        $('#city-form').html("<h1>New City Created!</h1>It's like Sim City around here, but without Godzilla.");
        $('#city-form').css('margin-bottom','500px');
        window.scrollTo(0, 0);
      });
    });
  });
  </script>
</body>
</html>
