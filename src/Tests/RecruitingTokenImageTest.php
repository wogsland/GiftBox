<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingTokenImage;

/**
 * This class tests the RecruitingTokenImage class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingTokenImageTest
 */
class RecruitingTokenImageTest
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
        $result = new RecruitingTokenImage();
        $this->assertEquals('GiveToken\RecruitingTokenImage', get_class($result));
        $this->assertFalse(isset($result->id));
    }
}
