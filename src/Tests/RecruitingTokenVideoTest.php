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
        $source_id = rand();
        $query = "INSERT INTO recruiting_token_video (recruiting_token_id, source_id)
                  VALUES ('{$this->RecruitingToken->id}', '$source_id')";
        $id = insert($query);
        $result = new RecruitingTokenVideo($id);
        $this->assertEquals('GiveToken\RecruitingTokenVideo', get_class($result));
        $this->assertTrue(isset($result->id));
        $this->assertEquals($result->id, $id);
        $this->assertEquals($result->source_id, $source_id);
        $this->assertEquals($result->recruiting_token_id, $this->RecruitingToken->id);
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // create youtube token video
        $source = 'youtube';
        $source_id = rand();
        $RecruitingTokenVideo = new RecruitingTokenVideo();
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $source, $source_id);
        $this->assertEquals($RecruitingTokenVideo->id, $id);
        $this->assertEquals($RecruitingTokenVideo->source, $source);
        $this->assertEquals($RecruitingTokenVideo->source_id, $source_id);
        $this->assertEquals($RecruitingTokenVideo->recruiting_token_id, $this->RecruitingToken->id);

        // create vimeo token video
        $source = 'vimeo';
        $source_id = rand();
        $RecruitingTokenVideo = new RecruitingTokenVideo();
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $source, $source_id);
        $this->assertEquals($RecruitingTokenVideo->id, $id);
        $this->assertEquals($RecruitingTokenVideo->source, $source);
        $this->assertEquals($RecruitingTokenVideo->source_id, $source_id);
        $this->assertEquals($RecruitingTokenVideo->recruiting_token_id, $this->RecruitingToken->id);

        // check it's in the DB
        $RecruitingTokenVideo2 = new RecruitingTokenVideo($id);
        $this->assertEquals($RecruitingTokenVideo2->id, $id);
        $this->assertEquals($RecruitingTokenVideo->source, $source);
        $this->assertEquals($RecruitingTokenVideo->source_id, $source_id);
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
        $source = 'vimeo';
        $source_id[1] = rand();
        $source_id[2] = rand();
        $source_id[3] = rand();
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $source, $source_id[1]);
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $source, $source_id[2]);
        $id = $RecruitingTokenVideo->create($this->RecruitingToken->id, $source, $source_id[3]);
        $images = $RecruitingTokenVideo->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertEquals(count($images), 3);
        foreach ($images as $image) {
            $this->assertTrue($image['id'] > 0);
            $this->assertTrue(in_array($image['source_id'], $source_id));
        }
    }

    /**
     * Tests the delete function.
     */
    public function testDelete()
    {
        // create token video
        $query = "INSERT INTO recruiting_token_video (recruiting_token_id)
                  VALUES ('{$this->RecruitingToken->id}')";
        $id = insert($query);
        $result = new RecruitingTokenVideo($id);


        // delete token video
        $result->delete();

        // check class variables get unset
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->recruiting_token_id));
        $this->assertFalse(isset($result->source));
        $this->assertFalse(isset($result->source_id));

        // check it's gone from DB
        $result2 = new RecruitingTokenVideo($id);
        $this->assertFalse(isset($result2->id));
    }
}
