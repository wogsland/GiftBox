<?php
namespace GiveToken\Tests;

use \GiveToken\Service\GoogleMail;

/**
 * This class tests the GoogleMail class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Service/GoogleMailTest
 */
class GoogleMailTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $GoogleMail = new GoogleMail();
        $this->assertEquals('GiveToken\Service\GoogleMail', get_class($GoogleMail));
    }

    /**
     * Tests the sendMail function.
     */
    public function testSendMail()
    {
        // No way to test this locally?
        $this->markTestIncomplete();
    }

    /**
     * Tests mocking the GoogleMail class.
     * This is my first attempt at mocking...
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMock()
    {
        $mock = \Mockery::mock('overload:\\GiveToken\\Service\\GoogleMail');
        $this->assertEquals('GiveToken\Service\GoogleMail', get_class($mock));
        $mock->shouldReceive('sendMail')
             ->with('founder@givetoken.com','hi','hi','founder@givetoken.com')
             ->andReturn(true);
        $GoogleMail = new GoogleMail();
        $this->assertTrue($GoogleMail->sendMail('founder@givetoken.com','hi','hi','founder@givetoken.com'));
    }

    /**
     * Cleans up after the tests
     */
    public function tearDown()
    {
        \Mockery::close();
    }
}
