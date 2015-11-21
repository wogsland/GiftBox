<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingToken;
use \GiveToken\RecruitingTokenImage;
use \GiveToken\User;

/**
 * This class tests the RecruitingTokenImage class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingTokenImageTest
 */
class RecruitingTokenImageTest
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
        $result = new RecruitingTokenImage();
        $this->assertEquals('GiveToken\RecruitingTokenImage', get_class($result));
        $this->assertFalse(isset($result->id));

        // invalid id case
        $result = new RecruitingTokenImage(-1);
        $this->assertEquals('GiveToken\RecruitingTokenImage', get_class($result));
        $this->assertFalse(isset($result->id));

        // valid id case
        $file_name = rand().'.jpg';
        $query = "INSERT INTO recruiting_token_image (recruiting_token_id, file_name)
                  VALUES ('{$this->RecruitingToken->id}', '$file_name')";
        $id = insert($query);
        $result = new RecruitingTokenImage($id);
        $this->assertEquals('GiveToken\RecruitingTokenImage', get_class($result));
        $this->assertTrue(isset($result->id));
        $this->assertEquals($result->id, $id);
        $this->assertEquals($result->file_name, $file_name);
        $this->assertEquals($result->recruiting_token_id, $this->RecruitingToken->id);
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // create token video
        $file_name = rand().'.jpg';
        $RecruitingTokenImage = new RecruitingTokenImage();
        $id = $RecruitingTokenImage->create($this->RecruitingToken->id, $file_name);
        $this->assertEquals($RecruitingTokenImage->id, $id);
        $this->assertEquals($RecruitingTokenImage->file_name, $file_name);
        $this->assertEquals($RecruitingTokenImage->recruiting_token_id, $this->RecruitingToken->id);

        // check it's in the DB
        $RecruitingTokenImage2 = new RecruitingTokenImage($id);
        $this->assertEquals($RecruitingTokenImage2->id, $id);
        $this->assertEquals($RecruitingTokenImage2->file_name, $file_name);
        $this->assertEquals($RecruitingTokenImage2->recruiting_token_id, $this->RecruitingToken->id);
    }

    /**
     * Tests the delete function.
     */
    public function testDelete()
    {
        // creaete image
        $file_name = rand().'.jpg';
        $query = "INSERT INTO recruiting_token_image (recruiting_token_id, file_name)
                  VALUES ('{$this->RecruitingToken->id}', '$file_name')";
        $id = insert($query);
        $result = new RecruitingTokenImage($id);
        $this->assertTrue(isset($result->id));

        // delete image
        $result->delete();

        // check class variables get unset
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->recruiting_token_id));
        $this->assertFalse(isset($result->file_name));

        // check it's gone from DB
        $result2 = new RecruitingTokenImage($id);
        $this->assertFalse(isset($result2->id));

        //check it's deleted from the filesystem
        $this->markTestIncomplete();
    }
}
