<?php
namespace Sizzle\Tests\Ajax\City;

/**
 * This class tests the ajax endpoint to get a city's images.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/City/GetImagesTest
 */
class GetImagesTest
  extends \PHPUnit_Framework_TestCase
{
  /**
   * Requires the util.php file of functions
   */
  public static function setUpBeforeClass()
  {
    include_once __DIR__.'/../../../../util.php';
  }

  public function setUp()
  {
    // TODO: This is fragile, needs to be updated once the database is imported
    $this->city_id = 52011;
  }

  /**
   * Tests request via ajax endpoint.
   */
  public function testRequest()
  {
    // test created city
    $url = TEST_URL . "/ajax/city/get_images";
    $fields = array(
      'city_id'=>$this->city_id
    );
    $fields_string = "";
    foreach ($fields as $key=>$value) {
      $fields_string .= $key.'='.$value.'&';
    }
    $fields_string = rtrim($fields_string, '&');
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_COOKIE, getTestCookie(true));
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    $this->assertEquals(true, $response);
    $json = ob_get_contents();
    ob_end_clean();
    $return = json_decode($json);
    $this->assertEquals('true', $return->success);
    $this->assertEquals(4, count($return->data));

    // grab it from the database
    $query = "SELECT * FROM city_image WHERE `city_id` = '$this->city_id'";
    $result = execute_query($query);
    $this->assertEquals(4, $result->num_rows);
  }

  /**
   * Tests request failure via ajax endpoint.
   */
  public function testFail()
  {
    $url = TEST_URL . "/ajax/city/get_images";
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    $this->assertEquals(true, $response);
    $json = ob_get_contents();
    $return = json_decode($json);
    $this->assertEquals('false', $return->success);
    $this->assertEquals('', $return->data);
    ob_end_clean();
  }

  /**
   * Tests request failure via ajax endpoint with no cookie.
   */
  public function testFailNoCookie()
  {
    // create city test variables
    $name = "City #" . rand();
    $image_file = rand().".png";
    $population = rand(10000, 10000000);
    $longitude = rand(0, 100);
    $latitude = rand(0, 100);
    $county = "County " . rand(0, 100);
    $country = "CT";
    $timezone = "Awesome Standard Time";
    $temp_hi_spring = rand(0, 100);
    $temp_lo_spring = rand(0, 100);
    $temp_avg_spring = rand(0, 100);
    $temp_hi_summer = rand(0, 100);
    $temp_lo_summer = rand(0, 100);
    $temp_avg_summer = rand(0, 100);
    $temp_hi_fall = rand(0, 100);
    $temp_lo_fall = rand(0, 100);
    $temp_avg_fall = rand(0, 100);
    $temp_hi_winter = rand(0, 100);
    $temp_lo_winter = rand(0, 100);
    $temp_avg_winter = rand(0, 100);

    // attempt curl request
    $url = TEST_URL . "/ajax/city/get_images";
    $fields = array(
      'city_id'=>$this->city_id
    );
    $fields_string = "";
    foreach ($fields as $key=>$value) {
      $fields_string .= $key.'='.$value.'&';
    }
    $fields_string = rtrim($fields_string, '&');
    ob_start();
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    $this->assertEquals(true, $response);
    $json = ob_get_contents();
    ob_end_clean();
    $return = json_decode($json);
    $this->assertEquals('false', $return->success);
    $this->assertEquals('', $return->data);

    // grab it from the database
    $query = "SELECT * FROM city_image WHERE `city_id` = '$this->city_id'";
    $result = execute_query($query);
    $this->assertEquals(4, $result->num_rows);
  }
}
?>
