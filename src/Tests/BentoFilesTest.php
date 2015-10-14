<?php
namespace GiveToken\Tests;

use \GiveToken\BentoFiles;

/**
 * This class tests the BentoFiles class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/BentoFilesTest
 */
class BentoFilesTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $result = new BentoFiles();
        $this->assertEquals('GiveToken\BentoFiles', get_class($result));
    }
}
