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
}
