<?php
namespace GiveToken\Tests;

/**
 * This class tests analyticsauth.php
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/AnalyticsAuthTest
 */
class AnalyticsAuthTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the php file being tested.
     */
    public static function setUpBeforeClass()
    {
        require_once __DIR__.'/../../analyticsauth.php';
    }

    /**
     * Tests the getService function.
     */
    public function testGetService()
    {
        $result = getService();
        $this->assertEquals('Google_Service_Analytics', get_class($result));
    }
}
