<?php
namespace GiveToken\Tests;

use \GiveToken\City;

/**
 * This class tests the City class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/CityTest
 */
class CityTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../util.php';
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
    }

    /**
     * Tests the save function.
     */
    public function testSave()
    {
        // $id = null case
        $City = new City();
        $this->assertFalse($City->save());
        $City->name = 'City of '.rand();
        $this->assertFalse($City->save());
        $City->image_file = rand().'.jpg';
        $this->assertFalse($City->save());
        $City->population = rand();
        $this->assertFalse($City->save());
        $City->longitude = rand(0,180);
        $this->assertFalse($City->save());
        $City->latitude = rand(0,180);
        $this->assertFalse($City->save());
        $City->county = 'County '.rand();
        $this->assertFalse($City->save());
        $City->country = 'USA';
        $this->assertFalse($City->save());
        $City->timezone = rand().' Time';
        $this->assertFalse($City->save());
        $City->temp_hi_spring = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_lo_spring = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_avg_spring = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_hi_summer = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_lo_summer = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_avg_summer = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_hi_fall = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_lo_fall = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_avg_fall = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_hi_winter = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_lo_winter = rand(0,127);
        $this->assertFalse($City->save());
        $City->temp_avg_winter = rand(0,127);
        $this->assertTrue($City->save());
        $query = "SELECT * FROM city WHERE `name` = '{$City->name}'";
        $result = execute_query($query);
        $this->assertEquals(1, $result->num_rows);
        $row = $result->fetch_assoc();
        $this->assertEquals($City->name, $row['name']);
        $this->assertEquals($City->image_file, $row['image_file']);
        $this->assertEquals($City->population, $row['population']);
        $this->assertEquals($City->longitude, $row['longitude']);
        $this->assertEquals($City->latitude, $row['latitude']);
        $this->assertEquals($City->county, $row['county']);
        $this->assertEquals($City->country, $row['country']);
        $this->assertEquals($City->timezone, $row['timezone']);
        $this->assertEquals($City->temp_hi_spring, $row['temp_hi_spring']);
        $this->assertEquals($City->temp_lo_spring, $row['temp_lo_spring']);
        $this->assertEquals($City->temp_avg_spring, $row['temp_avg_spring']);
        $this->assertEquals($City->temp_hi_summer, $row['temp_hi_summer']);
        $this->assertEquals($City->temp_lo_summer, $row['temp_lo_summer']);
        $this->assertEquals($City->temp_avg_summer, $row['temp_avg_summer']);
        $this->assertEquals($City->temp_hi_fall, $row['temp_hi_fall']);
        $this->assertEquals($City->temp_lo_fall, $row['temp_lo_fall']);
        $this->assertEquals($City->temp_avg_fall, $row['temp_avg_fall']);
        $this->assertEquals($City->temp_hi_winter, $row['temp_hi_winter']);
        $this->assertEquals($City->temp_lo_winter, $row['temp_lo_winter']);
        $this->assertEquals($City->temp_avg_winter, $row['temp_avg_winter']);

        // $id set case
        $City = new City();
        $City->id = 12;
        $this->assertFalse($City->save());
    }
}
