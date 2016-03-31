<?php
namespace Sizzle\Tests\Database;

use \Sizzle\Database\User;

/**
 * This class tests the User class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/UserTest
 */
class UserTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\User;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Tests the __construct method.
     */
    public function testConstructor()
    {
        // $id = null case
        $user = new User();
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertFalse(isset($user->email_address));
    }

    /**
     * Tests the exists method.
     */
    public function testExists()
    {
        $this->markTestIncomplete();
    }

    /**
     * Tests the fetch method.
     */
    public function testFetch()
    {
        // $key default
        $email = rand() . '@gossizle.io';
        $sql = "INSERT INTO user (email_address) VALUES ('$email')";
        $userId = insert($sql);
        $user = User::fetch($email);
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertEquals($email, $user->email_address);
        $this->assertEquals($userId, $user->id);
        $user = User::fetch(rand() . $email); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key = api_key
        $email = rand() . '@gossizle.io';
        $apiKey = rand() . '_key';
        $sql = "INSERT INTO user (email_address, api_key)
                VALUES ('$email', '$apiKey')";
        $userId = insert($sql);
        $user = User::fetch($apiKey, 'api_key');
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertEquals($email, $user->email_address);
        $this->assertEquals($apiKey, $user->api_key);
        $this->assertEquals($userId, $user->id);
        $user = User::fetch(rand() . $apiKey, 'api_key'); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key = email_address
        $email = rand() . '@gossizle.io';
        $sql = "INSERT INTO user (email_address) VALUES ('$email')";
        $userId = insert($sql);
        $user = User::fetch($email, 'email_address');
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertEquals($email, $user->email_address);
        $this->assertEquals($userId, $user->id);
        $user = User::fetch(rand() . $email, 'email_address'); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key = reset_code
        $email = rand() . '@gossizle.io';
        $reset = rand() . '_code';
        $sql = "INSERT INTO user (email_address, reset_code)
                VALUES ('$email', '$reset')";
        $userId = insert($sql);
        $user = User::fetch($reset, 'reset_code');
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertEquals($email, $user->email_address);
        $this->assertEquals($reset, $user->reset_code);
        $this->assertEquals($userId, $user->id);
        $user = User::fetch(rand() . $reset, 'reset_code'); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key garbage
        $user = User::fetch($email, 'garbage');
        $this->assertFalse(isset($user));
    }

    /**
     * Tests the update_token method.
     */
    public function testUpdateToken()
    {
        $this->markTestIncomplete();
    }

    /**
     * Tests the save method.
     */
    public function testSave()
    {
        $this->markTestIncomplete();
    }

    /**
     * Tests the activate method.
     */
    public function testActivate()
    {
        //create user that needs activation
        $user = $this->createUser();
        $user->activation_key = 'v5y3q'.rand().'nachoes';
        $user->save();
        $this->assertTrue($user->activate($user->activation_key));
        $this->assertFalse($user->activate($user->activation_key)); // second time should fail

        // create user that doens't need activation
        $user2 = $this->createUser();
        $key = 'jrhgksv'.rand().'gorilla';
        $this->assertFalse($user2->activate($key));

        // create user that needs activation, but use bad key
        $user3 = $this->createUser();
        $user3->activation_key = 'bsu4v65'.rand().'pecan';
        $user3->save();
        $key = '4ic7tq346b'.rand().'cashew';
        $this->assertFalse($user3->activate($key));
        $this->assertTrue($user3->activate($user3->activation_key)); // but true key should still work
    }

    /**
     * Delete users created for testing
     */
    protected function tearDown()
    {
        foreach($this->users as $id) {
            $sql = "DELETE FROM user_milestone WHERE user_id = '$id'";
            execute($sql);
        }
        $this->deleteUsers();
    }
}
