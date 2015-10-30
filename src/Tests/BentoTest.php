<?php
namespace GiveToken\Tests;

use \GiveToken\Bento;

/**
 * This class tests the Bento class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/BentoTest
 */
class BentoTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $result = new Bento();
        $this->assertEquals('GiveToken\Bento', get_class($result));
    }
}
