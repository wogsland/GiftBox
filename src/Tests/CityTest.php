<?php
namespace GiveToken\Tests;

use GiveToken\City;

/**
 * This class tests the City class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/CityTest
 */
class CityTest extends \PHPUnit_Framework_TestCase
{
    protected $existing_city;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../util.php';
    }

    protected function setUp()
    {
        // create a city for testing
        $city = new City();
        $city->name = "Test City";
        $city->image_file = "city.png";
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
        $this->existing_city = $city;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new City();
        $this->assertEquals('GiveToken\City', get_class($result));
        $this->assertFalse(isset($result->name));

        // $id specified case
        $result = new City($this->existing_city->id);
        foreach (get_object_vars($result) as $key => $value) {
            $this->assertEquals($this->existing_city->$key, $value);
        }
    }

    public function testSaveInsert()
    {
        // test saving a new city
        $city = new City();
        $city->name = "City #" . rand(0, 100);
        $city->image_file = "city.png";
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

        // id should be null before save
        $this->assertNull($city->id);
        $city->save();

        // id should be populated after save
        $this->assertGreaterThan(0, $city->id);

        // make sure all properties were inserted correctly
        $saved_city = new City($city->id);
        foreach (get_object_vars($saved_city) as $key => $value) {
            $this->assertEquals($city->$key, $value);
        }

        // delete the inserted city
        $city->delete();
    }

    public function testSaveUpdate()
    {
        // test updating an existing city
        $city = $this->existing_city;

        // set string properties to "updated <property_name>"
        // set numeric properties to strlen(<property_name>)
        foreach (get_object_vars($city) as $key => $value) {
            if ($key !== 'id' && $key != 'created') {
                if (is_string($value)) {
                    $city->$key = "updated ".$key;
                } elseif (is_numeric($value)) {
                    $city->$key = strlen($key);
                }
            }
        }

        // update the city
        $city->save();
        
        // go get the updated record
        $updated_city = new City($city->id);
        // check the properties of the updatedCity
        foreach (get_object_vars($updated_city) as $key => $value) {
            if ($key !== 'id' && $key != 'created') {
                if (is_string($city->$key)) {
                    $this->assertEquals("updated ".$key, $value);
                } elseif (is_numeric($city->$key)) {
                    $this->assertEquals(strlen($key), $value);
                }
            }
        }
    }
    
    public function testGetAll()
    {
        $this->markTestIncomplete();
    }

    public function testGetIdFromName()
    {
        $id = City::getIdFromName($this->existing_city->name);
        $this->assertEquals($this->existing_city->id, $id);
    }

    protected function tearDown()
    {
        $this->existing_city->delete();
    }
}
