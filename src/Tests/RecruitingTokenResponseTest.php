<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingTokenResponse;
use \GiveToken\RecruitingToken;
use \GiveToken\User;

/**
 * This class tests the RecruitingTokenResponse class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/RecruitingTokenResponseTest
 */
class RecruitingTokenResponseTest
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
        $result = new RecruitingTokenResponse();
        $this->assertEquals('GiveToken\RecruitingTokenResponse', get_class($result));
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // setup test user
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $this->User = $User;

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->getId();
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // Test function success
        $RecruitingTokenResponse = new RecruitingTokenResponse();
        $email = rand() . '@gmail.com';
        $this->assertEquals($RecruitingToken->id, (int) $RecruitingToken->id);
        $this->assertTrue((bool) filter_var($email, FILTER_VALIDATE_EMAIL));
        $id = $RecruitingTokenResponse->create($RecruitingToken->long_id, $email, 'Yes');
        $this->assertGreaterThan(0, $id);
        $id = $RecruitingTokenResponse->create($RecruitingToken->long_id, $email, 'No');
        $this->assertGreaterThan(0, $id);
        $id = $RecruitingTokenResponse->create($RecruitingToken->long_id, $email, 'Maybe');
        $this->assertGreaterThan(0, $id);

        // Test function fails
        $id = $RecruitingTokenResponse->create($RecruitingToken->long_id, $email, 'T');
        $this->assertEquals(0, $id);
        $id = $RecruitingTokenResponse->create($RecruitingToken->long_id, 'T', 'Yes');
        $this->assertEquals(0, $id);
        $id = $RecruitingTokenResponse->create('T', $email, 'Yes');
        $this->assertEquals(0, $id);
    }
}
