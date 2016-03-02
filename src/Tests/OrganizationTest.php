<?php
namespace Sizzle\Tests;

use \Sizzle\{
    Organization,
    User
};

/**
 * This class tests the Organization class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/tests/OrganizationTest
 */
class OrganizationTest
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
     * Creates test user & credentials
     */
    public function setUp()
    {
        // setup test user
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $this->User = $User;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // no params
        $result = new Organization();
        $this->assertEquals('Sizzle\Organization', get_class($result));

        // test with bad id
        $result2 = new Organization(-1);
        $this->assertFalse(isset($result2->id));

        // test with good id (Sizzle)
        $result3 = new Organization(1);
        $this->assertEquals($result3->id, 1);
        $this->assertEquals($result3->name, 'Sizzle');
        $this->assertEquals($result3->website, 'https://www.gosizzle.io');
    }
}
