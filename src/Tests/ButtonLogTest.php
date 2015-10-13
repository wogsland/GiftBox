<?php
namespace GiveToken\Tests;

use \GiveToken\ButtonLog;

/**
 * This class tests the ButtonLog class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/ButtonLogTest
 */
class ButtonLogTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        require_once __DIR__.'/../../util.php';
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new ButtonLog();
        $this->assertEquals('GiveToken\ButtonLog', get_class($result));
        $this->assertFalse(isset($result->id));
    }
}
