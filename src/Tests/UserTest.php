<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingToken;

/**
 * This class tests the RecruitingToken class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/RecruitingTokenTest
 */
class RecruitingTokenTest
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
        $result = new RecruitingToken();
        $this->assertEquals('GiveToken\RecruitingToken', get_class($result));
    }
}
