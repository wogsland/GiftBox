<?php
namespace Sizzle\Tests\Ajax\City;

use Sizzle\Database\City;

/**
 * This class tests the ajax endpoint to get a city.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/City/GetListTest
 */
class GetListTest extends \PHPUnit_Framework_TestCase
{
    protected $city;
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    public function setUp()
    {
        $this->city = $this->createCity("City #" . rand(0, 100));
        $this->url = TEST_URL . "/ajax/city/get_list";
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRequestTooMany()
    {
        $fields = array(
            'typed'=>''
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
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //print_r($json);
        $return = json_decode($json);
        //print_r($return);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(empty($return->data));
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRequestFor10()
    {
        // test 10
        $firstPart = rand();
        for ($i=0; $i<10; $i++) {
            $this->createCity($firstPart.rand());
        }
        $fields = array(
            'typed'=>$firstPart
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
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        //print_r($json);
        $return = json_decode($json);
        //print_r($return);
        $this->assertEquals('true', $return->success);
        $this->assertEquals(10, count($return->data));
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('', $return->data);
        ob_end_clean();
    }

    public function tearDown()
    {
        $this->city->delete();
    }

    /**
     * Create a city
     */
    protected function createCity(string $name = null)
    {
        // create a city for testing
        $city = new City();
        $city->name = $name ?? "Test City";
        $city->image_file = rand().".png";
        $city->population = rand(10000, 10000000);
        $city->longitude = rand(0, 100);
        $city->latitude = rand(0, 100);
        $city->county = "County " . rand(0, 100);
        $city->country = "CT";
        $city->timezone = "Awesome Standard Time";
        $city->temp_hi_spring = rand(0, 100);
        $city->temp_lo_spring = rand(0, 100);
        $city->temp_avg_spring = rand(0, 100);
        $city->temp_hi_summer = rand(0, 100);
        $city->temp_lo_summer = rand(0, 100);
        $city->temp_avg_summer = rand(0, 100);
        $city->temp_hi_fall = rand(0, 100);
        $city->temp_lo_fall = rand(0, 100);
        $city->temp_avg_fall = rand(0, 100);
        $city->temp_hi_winter = rand(0, 100);
        $city->temp_lo_winter = rand(0, 100);
        $city->temp_avg_winter = rand(0, 100);
        $city->save();
        return $city;
    }
}
