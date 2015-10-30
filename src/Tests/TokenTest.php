<?php
namespace GiveToken\Tests;

use \GiveToken\Token;

/**
 * This class tests the Token class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/TokenTest
 */
class TokenTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new Token();
        $this->assertEquals('GiveToken\Token', get_class($result));
    }
}
