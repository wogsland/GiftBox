<?php
namespace Sizzle\Tests\Database;

use \Sizzle\Database\{
    Organization,
    User
};

/**
 * This class tests the Organization class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/OrganizationTest
 */
class OrganizationTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
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
        $this->assertEquals('Sizzle\Database\Organization', get_class($result));

        // test with bad id
        $result2 = new Organization(-1);
        $this->assertFalse(isset($result2->id));

        // test with good id (Sizzle)
        $result3 = new Organization(1);
        $this->assertEquals($result3->id, 1);
        $this->assertEquals($result3->name, 'Sizzle');
        $this->assertEquals($result3->website, 'https://www.gosizzle.io');
    }

    /**
     * Tests the create function with a name only.
     */
    public function testCreateNameOnly()
    {
        $name = 'The '.rand().' Corporation';

        // Create open
        $organization = new Organization();
        $id = $organization->create($name);

        // Check class variables set
        $this->assertEquals($organization->id, $id);
        $this->assertEquals($organization->name, $name);
        $this->assertFalse(isset($organization->website));
        $this->assertFalse(isset($organization->paying_user));

        // See if open was saved in DB
        $organization2 = new Organization($id);
        $this->assertEquals($organization2->id, $id);
        $this->assertEquals($organization2->name, $name);
        $this->assertFalse(isset($organization2->website));
        $this->assertFalse(isset($organization2->paying_user));
        $this->assertTrue(isset($organization2->created));
    }

    /**
     * Tests the create function with a name & website.
     */
    public function testCreateNameWebsite()
    {
        // setup vars
        $name = 'The '.rand().' Corporation';
        $website = 'http://www.'.rand().'.org';

        // Create open
        $organization = new Organization();
        $id = $organization->create($name, $website);

        // Check class variables set
        $this->assertEquals($organization->id, $id);
        $this->assertEquals($organization->name, $name);
        $this->assertEquals($organization->website, $website);
        $this->assertFalse(isset($organization->paying_user));

        // See if open was saved in DB
        $organization2 = new Organization($id);
        $this->assertEquals($organization2->id, $id);
        $this->assertEquals($organization2->name, $name);
        $this->assertEquals($organization2->website, $website);
        $this->assertFalse(isset($organization2->paying_user));
        $this->assertTrue(isset($organization2->created));
    }

    /**
     * Tests the create function with a name and paying user id.
     */
    public function testCreateNamePayingUser()
    {
        // test vars
        $name = 'The '.rand().' Corporation';
        $user_id = $this->User->id;

        // Create open
        $organization = new Organization();
        $id = $organization->create($name, null, $user_id);

        // Check class variables set
        $this->assertEquals($organization->id, $id);
        $this->assertEquals($organization->name, $name);
        $this->assertFalse(isset($organization->website));
        $this->assertEquals($organization->paying_user, $user_id);

        // See if open was saved in DB
        $organization2 = new Organization($id);
        $this->assertEquals($organization2->id, $id);
        $this->assertEquals($organization2->name, $name);
        $this->assertFalse(isset($organization2->website));
        $this->assertEquals($organization2->paying_user, $user_id);
        $this->assertTrue(isset($organization2->created));
    }

    /**
     * Tests the create function with name, website & paying user id.
     */
    public function testCreateAll()
    {
        // test ALL the things!
        $name = 'The '.rand().' Corporation';
        $website = 'http://www.'.rand().'.org';
        $user_id = $this->User->id;

        // Create open
        $organization = new Organization();
        $id = $organization->create($name, $website, $user_id);

        // Check class variables set
        $this->assertEquals($organization->id, $id);
        $this->assertEquals($organization->name, $name);
        $this->assertEquals($organization->website, $website);
        $this->assertEquals($organization->paying_user, $user_id);

        // See if open was saved in DB
        $organization2 = new Organization($id);
        $this->assertEquals($organization2->id, $id);
        $this->assertEquals($organization2->name, $name);
        $this->assertEquals($organization2->website, $website);
        $this->assertEquals($organization2->paying_user, $user_id);
        $this->assertTrue(isset($organization2->created));
    }
}
