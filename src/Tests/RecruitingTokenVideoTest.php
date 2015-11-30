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

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // create token video
        $url = 'http://server'.rand().'.givetoken.com';
        $RecruitingTokenVideo = new RecruitingTokenVideo();
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $url);
        $this->assertEquals($RecruitingTokenVideo->id, $id);
        $this->assertEquals($RecruitingTokenVideo->url, $url);
        $this->assertEquals($RecruitingTokenVideo->recruiting_token_id, $this->RecruitingToken->id);

        // check it's in the DB
        $RecruitingTokenVideo2 = new RecruitingTokenVideo($id);
        $this->assertEquals($RecruitingTokenVideo2->id, $id);
        $this->assertEquals($RecruitingTokenVideo2->url, $url);
        $this->assertEquals($RecruitingTokenVideo2->recruiting_token_id, $this->RecruitingToken->id);
    }

    /**
     * Tests the getByRecruitingTokenLongId function.
     */
    public function testGetByRecruitingTokenLongId()
    {
        $RecruitingTokenVideo = new RecruitingTokenVideo();

        // token with no images should return empty array
        $images = $RecruitingTokenVideo->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertTrue(empty($images));

        // create token images
        $url[1] = 'https://givetoken.com/video/'.rand();
        $url[2] = 'https://givetoken.com/video/'.rand();
        $url[3] = 'https://givetoken.com/video/'.rand();
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $url[1]);
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $url[2]);
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $url[3]);
        $images = $RecruitingTokenVideo->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertEquals(count($images), 3);
        foreach ($images as $image) {
            $this->assertTrue($image['id'] > 0);
            $this->assertTrue(in_array($image['url'], $url));
        }
    }

    /**
     * Tests the delete function.
     */
    public function testDelete()
    {
        // create token video
        $url = 'http://server'.rand().'.givetoken.com';
        $query = "INSERT INTO recruiting_token_video (recruiting_token_id, url)
                  VALUES ('{$this->RecruitingToken->id}', '$url')";
        $id = insert($query);
        $result = new RecruitingTokenVideo($id);


        // delete token video
        $result->delete();

        // check class variables get unset
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->recruiting_token_id));
        $this->assertFalse(isset($result->url));

        // check it's gone from DB
        $result2 = new RecruitingTokenVideo($id);
        $this->assertFalse(isset($result2->id));
    }
}
