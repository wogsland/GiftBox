<?php
namespace GiveToken\Tests;

use \GiveToken\EventLogger;

/**
 * This class tests the EventLogger class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/EventLoggerTest
 */
class EventLoggerTest
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
        $user_id = rand();
        $event_type_id = rand();
        $event_info = 'info info '.rand().' info';
        $result = new EventLogger($user_id, $event_type_id, $event_info);
        $this->assertEquals('GiveToken\EventLogger', get_class($result));
        $this->assertFalse(isset($result->id));
        $this->assertEquals($result->user_id, $user_id);
        $this->assertEquals($result->event_type_id, $event_type_id);
        $this->assertEquals($result->event_info, $event_info);
    }
}
