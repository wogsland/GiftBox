<?php
namespace Sizzle\Tests\Ajax\City;

/**
 * This class tests the ajax endpoint to get a city.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/City/GetTest
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\City;

    protected $city;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    protected function setUp()
    {
        // create a city
        $this->city = $this->createCity();
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testRequest()
    {
        // test created city
        $city = $this->city;
        $url = TEST_URL . "/ajax/city/get/$city->id";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals($city->id, $return->data->id);
        $this->assertEquals($city->name, $return->data->name);
        $this->assertEquals($city->image_file, $return->data->image_file);
        $this->assertEquals($city->population, $return->data->population);
        $this->assertEquals($city->longitude, $return->data->longitude);
        $this->assertEquals($city->latitude, $return->data->latitude);
        $this->assertEquals($city->county, $return->data->county);
        $this->assertEquals($city->country, $return->data->country);
        $this->assertEquals($city->timezone, $return->data->timezone);
        $this->assertEquals($city->temp_hi_spring, $return->data->temp_hi_spring);
        $this->assertEquals($city->temp_lo_spring, $return->data->temp_lo_spring);
        $this->assertEquals($city->temp_avg_spring, $return->data->temp_avg_spring);
        $this->assertEquals($city->temp_hi_summer, $return->data->temp_hi_summer);
        $this->assertEquals($city->temp_lo_summer, $return->data->temp_lo_summer);
        $this->assertEquals($city->temp_avg_summer, $return->data->temp_avg_summer);
        $this->assertEquals($city->temp_hi_fall, $return->data->temp_hi_fall);
        $this->assertEquals($city->temp_lo_fall, $return->data->temp_lo_fall);
        $this->assertEquals($city->temp_avg_fall, $return->data->temp_avg_fall);
        $this->assertEquals($city->temp_hi_winter, $return->data->temp_hi_winter);
        $this->assertEquals($city->temp_lo_winter, $return->data->temp_lo_winter);
        $this->assertEquals($city->temp_avg_winter, $return->data->temp_avg_winter);
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

    /**
     * Delete cities created for testing
     */
    protected function tearDown()
    {
        $this->deleteCities();
    }
}
