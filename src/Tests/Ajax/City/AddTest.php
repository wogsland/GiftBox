<?php
namespace GiveToken\Tests\Ajax\City;

/**
 * This class tests the ajax endpoint to add a city.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/City/AddTest
 */
class AddTest
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

        // test created city
        $url = TEST_URL . "/ajax/city/add";
        $fields = array(
            'name'=>$name,
            'image_file'=>$image_file,
            'population'=>$population,
            'longitude'=>$longitude,
            'latitude'=>$latitude,
            'county'=>$county,
            'country'=>$country,
            'timezone'=>$timezone,
            'temp_hi_spring'=>$temp_hi_spring,
            'temp_lo_spring'=>$temp_lo_spring,
            'temp_avg_spring'=>$temp_avg_spring,
            'temp_hi_summer'=>$temp_hi_summer,
            'temp_lo_summer'=>$temp_lo_summer,
            'temp_avg_summer'=>$temp_avg_summer,
            'temp_hi_fall'=>$temp_hi_fall,
            'temp_lo_fall'=>$temp_lo_fall,
            'temp_avg_fall'=>$temp_avg_fall,
            'temp_hi_winter'=>$temp_hi_winter,
            'temp_lo_winter'=>$temp_lo_winter,
            'temp_avg_winter'=>$temp_avg_winter
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
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals('', $return->data);

        // grab it from the database
        $query = "SELECT * FROM city WHERE `name` = '{$name}'";
        $result = execute_query($query);
        $this->assertEquals(1, $result->num_rows);
        $row = $result->fetch_assoc();
        $this->assertEquals($name, $row['name']);
        //$this->assertEquals($image_file, $row['image_file']);
        $this->assertEquals($population, $row['population']);
        $this->assertEquals($longitude, $row['longitude']);
        $this->assertEquals($latitude, $row['latitude']);
        $this->assertEquals($county, $row['county']);
        $this->assertEquals($country, $row['country']);
        $this->assertEquals($timezone, $row['timezone']);
        $this->assertEquals($temp_hi_spring, $row['temp_hi_spring']);
        $this->assertEquals($temp_lo_spring, $row['temp_lo_spring']);
        $this->assertEquals($temp_avg_spring, $row['temp_avg_spring']);
        $this->assertEquals($temp_hi_summer, $row['temp_hi_summer']);
        $this->assertEquals($temp_lo_summer, $row['temp_lo_summer']);
        $this->assertEquals($temp_avg_summer, $row['temp_avg_summer']);
        $this->assertEquals($temp_hi_fall, $row['temp_hi_fall']);
        $this->assertEquals($temp_lo_fall, $row['temp_lo_fall']);
        $this->assertEquals($temp_avg_fall, $row['temp_avg_fall']);
        $this->assertEquals($temp_hi_winter, $row['temp_hi_winter']);
        $this->assertEquals($temp_lo_winter, $row['temp_lo_winter']);
        $this->assertEquals($temp_avg_winter, $row['temp_avg_winter']);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/city/add";
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
