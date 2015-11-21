<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingToken;
use \GiveToken\RecruitingTokenVideo;
use \GiveToken\User;

/**
 * This class tests the RecruitingTokenVideo class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingTokenVideoTest
 */
class RecruitingTokenVideoTest
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
     * Creates testing items in the database
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

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->getId();
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();
        $this->RecruitingToken = $RecruitingToken;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new RecruitingTokenVideo();
        $this->assertEquals('GiveToken\RecruitingTokenVideo', get_class($result));
        $this->assertFalse(isset($result->id));

        // invalid id case
        $result = new RecruitingTokenVideo(-1);
        $this->assertEquals('GiveToken\RecruitingTokenVideo', get_class($result));
        $this->assertFalse(isset($result->id));

        // valid id case
        $url = 'http://server'.rand().'.givetoken.com';
        $query = "INSERT INTO recruiting_token_video (recruiting_token_id, url)
                  VALUES ('{$this->RecruitingToken->id}', '$url')";
        $id = insert($query);
        $result = new RecruitingTokenVideo($id);
        $this->assertEquals('GiveToken\RecruitingTokenVideo', get_class($result));
        $this->assertTrue(isset($result->id));
        $this->assertEquals($result->id, $id);
        $this->assertEquals($result->url, $url);
        $this->assertEquals($result->recruiting_token_id, $this->RecruitingToken->id);
    }
}
