<?php
namespace GiveToken\Tests;

use \GiveToken\Social;

/**
 * This class tests the Social class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/SocialTest
 */
class SocialTest
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
        $result = new Social();
        $this->assertEquals('GiveToken\Social', get_class($result));
    }
}
