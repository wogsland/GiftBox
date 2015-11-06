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
}
