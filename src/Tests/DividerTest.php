<?php
namespace GiveToken\Tests;

use \GiveToken\Divider;

/**
 * This class tests the Divider class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/DividerTest
 */
class DividerTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $result = new Divider();
        $this->assertEquals('GiveToken\Divider', get_class($result));
    }
}
