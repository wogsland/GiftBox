<?php
namespace GiveToken\Tests\Ajax\City;

/**
 * This class tests the ajax endpoint to get a city.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/City/GetTest
 */
class GetTest
extends \PHPUnit_Framework_TestCase
{
    /**
   * Requires the util.php file of functions
   */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    /**
   * Tests request via ajax endpoint.
   */
    public function testRequest()
    {
        // create a city
        $name = "City #" . rand(0, 100);
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
        $query = "INSERT INTO `city` (
           `name`,
           `population`,
           `longitude`,
           `latitude`,
           `county`,
           `country`,
           `timezone`,
           `temp_hi_spring`,
           `temp_lo_spring`,
           `temp_avg_spring`,
           `temp_hi_summer`,
           `temp_lo_summer`,
           `temp_avg_summer`,
           `temp_hi_fall`,
           `temp_lo_fall`,
           `temp_avg_fall`,
           `temp_hi_winter`,
           `temp_lo_winter`,
           `temp_avg_winter`
        ) VALUES (
           '$name',
           '$population',
           '$longitude',
           '$latitude',
           '$county',
           '$country',
           '$timezone',
           '$temp_hi_spring',
           '$temp_lo_spring',
           '$temp_avg_spring',
           '$temp_hi_summer',
           '$temp_lo_summer',
           '$temp_avg_summer',
           '$temp_hi_fall',
           '$temp_lo_fall',
           '$temp_avg_fall',
           '$temp_hi_winter',
           '$temp_lo_winter',
           '$temp_avg_winter'
        )";
        $id = insert($query);

        // test created city
        $url = TEST_URL . "/ajax/city/get/$id";
        //$fields = array();
        //$fields_string = "";
        //foreach ($fields as $key=>$value) {
        //    $fields_string .= $key.'='.$value.'&';
        //}
        //$fields_string = rtrim($fields_string, '&');
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        //curl_setopt($ch, CURLOPT_COOKIE, ChocolateChip);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //print_r($return);
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals($id, $return->data->id);
        $this->assertEquals($name, $return->data->name);
        $this->assertEquals($population, $return->data->population);
        $this->assertEquals($longitude, $return->data->longitude);
        $this->assertEquals($latitude, $return->data->latitude);
        $this->assertEquals($county, $return->data->county);
        $this->assertEquals($country, $return->data->country);
        $this->assertEquals($timezone, $return->data->timezone);
        $this->assertEquals($temp_hi_spring, $return->data->temp_hi_spring);
        $this->assertEquals($temp_lo_spring, $return->data->temp_lo_spring);
        $this->assertEquals($temp_avg_spring, $return->data->temp_avg_spring);
        $this->assertEquals($temp_hi_summer, $return->data->temp_hi_summer);
        $this->assertEquals($temp_lo_summer, $return->data->temp_lo_summer);
        $this->assertEquals($temp_avg_summer, $return->data->temp_avg_summer);
        $this->assertEquals($temp_hi_fall, $return->data->temp_hi_fall);
        $this->assertEquals($temp_lo_fall, $return->data->temp_lo_fall);
        $this->assertEquals($temp_avg_fall, $return->data->temp_avg_fall);
        $this->assertEquals($temp_hi_winter, $return->data->temp_hi_winter);
        $this->assertEquals($temp_lo_winter, $return->data->temp_lo_winter);
        $this->assertEquals($temp_avg_winter, $return->data->temp_avg_winter);
    }

    /**
   * Tests request failure via ajax endpoint.
   */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/city/get";
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
}
?>
