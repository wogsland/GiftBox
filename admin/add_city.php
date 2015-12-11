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
          <input type="text" class="form-control" id="name" name="name" placeholder="City Name" required>
        </div>
        <div class="form-group">
          <label for="exampleInputFile">File input</label>
          <input type="file" id="exampleInputFile" name="exampleInputFile">
          <input type="hidden" id="image_file" name="image_file">
          <p class="help-block">Please only upload public domain photos.</p>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="population" name="population" placeholder="Population" required>
        </div>
        <div class="form-group col-sm-6">
          <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" required>
        </div>
        <div class="form-group col-sm-6">
          <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="county" name="county" placeholder="County" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="country" name="country" placeholder="Country" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="timezone" name="timezone" placeholder="Timezone" required>
        </div>
        <h3>Temperatures</h3>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_spring" name="temp_hi_spring" placeholder="Spring High" required>
          <input type="text" class="form-control" id="temp_lo_spring" name="temp_lo_spring" placeholder="Spring Low" required>
          <input type="text" class="form-control" id="temp_avg_spring" name="temp_avg_spring" placeholder="Spring Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_summer" name="temp_hi_summer" placeholder="Summer High" required>
          <input type="text" class="form-control" id="temp_lo_summer" name="temp_lo_summer" placeholder="Summer Low" required>
          <input type="text" class="form-control" id="temp_avg_summer" name="temp_avg_summer" placeholder="Summer Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_fall" name="temp_hi_fall" placeholder="Fall High" required>
          <input type="text" class="form-control" id="temp_lo_fall" name="temp_lo_fall" placeholder="Fall Low" required>
          <input type="text" class="form-control" id="temp_avg_fall" name="temp_avg_fall" placeholder="Fall Average" required>
        </div>
        <div class="form-group form-inline">
          <input type="text" class="form-control" id="temp_hi_winter" name="temp_hi_winter" placeholder="Winter High" required>
          <input type="text" class="form-control" id="temp_lo_winter" name="temp_lo_winter" placeholder="Winter Low" required>
          <input type="text" class="form-control" id="temp_avg_winter" name="temp_avg_winter" placeholder="Winter Average" required>
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

      //save image
      var file = $('#exampleInputFile')[0].files[0];
      var reader  = new FileReader();
      reader.fileName = file.name;
      reader.onloadend = function () {
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {
          xhr.open("POST", "/upload", true);
          xhr.setRequestHeader("X-FILENAME", file.name);
          xhr.send(reader.result);
        }
      };
      reader.readAsDataURL(file);
      $('#image_file').val(file.name);

      // save info in the database
      url = '/ajax/city/add';
      $.post(url, $('form').serialize(), function(data) {
        if (data.success === 'true') {
          $('#city-form').html("<h1>New City Created!</h1>It's like Sim City around here, but without Godzilla.");
          $('#city-form').css('margin-bottom','500px');
          window.scrollTo(0, 0);
        } else {
          alert('All fields required!');
        }
      });
    });
  });
  </script>
</body>
</html>
