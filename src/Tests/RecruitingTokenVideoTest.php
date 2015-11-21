<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingTokenVideo;

/**
 * This class tests the RecruitingTokenVideo class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingTokenVideoTest
 */
class RecruitingTokenVideoTest
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
        $result = new RecruitingTokenVideo();
        $this->assertEquals('GiveToken\RecruitingTokenVideo', get_class($result));
        $this->assertFalse(isset($result->id));
    }
}
