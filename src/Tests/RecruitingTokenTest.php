<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingToken;
use \GiveToken\User;

/**
 * This class tests the User class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/RecruitingTokenTest
 */
class RecruitingTokenTest
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
     * Creates test user
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
        $result = new RecruitingToken();
        $this->assertEquals('GiveToken\RecruitingToken', get_class($result));

        // save for 1 param
        $result->user_id = $this->User->getId();
        $result->long_id = substr(md5(microtime()),rand(0,26),20);
        $result->save();

        // test with id
        $result2 = new RecruitingToken($result->id);
        $this->assertEquals($result->id, $result2->id);
        $this->assertEquals($result->long_id, $result2->long_id);

        //test with 2 params
        $result3 = new RecruitingToken($result->id, 'id');
        $this->assertEquals($result->id, $result3->id);
        $this->assertEquals($result->long_id, $result3->long_id);
        $result4 = new RecruitingToken($result->long_id, 'long_id');
        $this->assertEquals($result->id, $result3->id);
        $this->assertEquals($result->long_id, $result3->long_id);
    }

    /**
     * Tests the uniqueLongId function.
     */
    public function testUniqueLongId()
    {
        // Create token to dup against
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->getId();
        $RecruitingToken->long_id = substr(md5(microtime()),rand(0,26),20);
        $RecruitingToken->save();

        // Test function with param
        $RecruitingToken2 = new RecruitingToken();
        $this->assertTrue($RecruitingToken2->uniqueLongId(rand()));
        $this->assertFalse($RecruitingToken2->uniqueLongId($RecruitingToken->long_id));

        // Test function without param
        $RecruitingToken2->long_id = $RecruitingToken->long_id;
        $this->assertFalse($RecruitingToken2->uniqueLongId());
    }
}
