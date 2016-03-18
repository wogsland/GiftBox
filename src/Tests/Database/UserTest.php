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
        $this->assertEquals($userId, $user->getId());
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
        $this->assertEquals($userId, $user->getId());
        $user = User::fetch(rand() . $apiKey, 'api_key'); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key = email_address
        $email = rand() . '@gossizle.io';
        $sql = "INSERT INTO user (email_address) VALUES ('$email')";
        $userId = insert($sql);
        $user = User::fetch($email, 'email_address');
        $this->assertEquals('Sizzle\Database\User', get_class($user));
        $this->assertEquals($email, $user->email_address);
        $this->assertEquals($userId, $user->getId());
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
        $this->assertEquals($userId, $user->getId());
        $user = User::fetch(rand() . $reset, 'reset_code'); //this one shouldn't be there
        $this->assertFalse(isset($user));

        // $key garbage
        $user = User::fetch($email, 'garbage');
        $this->assertFalse(isset($user));
    }
}
