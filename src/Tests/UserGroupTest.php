<?php
namespace GiveToken\Tests;

use \GiveToken\UserGroup;

/**
 * This class tests the UserGroup class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/UserGroupTest
 */
class UserGroupTest
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
        $result = new UserGroup();
        $this->assertEquals('GiveToken\UserGroup', get_class($result));
        $this->assertFalse(isset($result->name));
    }
}
