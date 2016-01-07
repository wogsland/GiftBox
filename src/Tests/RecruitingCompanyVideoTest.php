<?php
namespace GiveToken\Tests;

use \GiveToken\RecruitingCompany;
use \GiveToken\RecruitingCompanyVideo;
use \GiveToken\RecruitingToken;
use \GiveToken\User;

/**
 * This class tests the RecruitingCompanyVideo class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingCompanyVideoTest
 */
class RecruitingCompanyVideoTest
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

        // setup test company
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $this->User->getId();
        $RecruitingCompany->name = 'Company '.rand();
        $RecruitingCompany->save();
        $this->RecruitingCompany = $RecruitingCompany;

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->getId();
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->recruiting_company_id = $RecruitingCompany->id;
        $RecruitingToken->save();
        $this->RecruitingToken = $RecruitingToken;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new RecruitingCompanyVideo();
        $this->assertEquals('GiveToken\RecruitingCompanyVideo', get_class($result));
        $this->assertFalse(isset($result->id));

        // invalid id case
        $result = new RecruitingCompanyVideo(-1);
        $this->assertEquals('GiveToken\RecruitingCompanyVideo', get_class($result));
        $this->assertFalse(isset($result->id));

        // valid id case
        $source_id = rand();
        $query = "INSERT INTO recruiting_company_video (recruiting_company_id, source_id)
                  VALUES ('{$this->RecruitingCompany->id}', '$source_id')";
        $id = insert($query);
        $result = new RecruitingCompanyVideo($id);
        $this->assertEquals('GiveToken\RecruitingCompanyVideo', get_class($result));
        $this->assertTrue(isset($result->id));
        $this->assertEquals($result->id, $id);
        $this->assertEquals($result->source_id, $source_id);
        $this->assertEquals($result->recruiting_company_id, $this->RecruitingCompany->id);
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // create youtube token video
        $source = 'youtube';
        $source_id = rand();
        $RecruitingCompanyVideo = new RecruitingCompanyVideo();
        $id = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id);
        $this->assertEquals($RecruitingCompanyVideo->id, $id);
        $this->assertEquals($RecruitingCompanyVideo->source, $source);
        $this->assertEquals($RecruitingCompanyVideo->source_id, $source_id);
        $this->assertEquals($RecruitingCompanyVideo->recruiting_company_id, $this->RecruitingCompany->id);

        // create vimeo token video
        $source = 'vimeo';
        $source_id = rand();
        $RecruitingCompanyVideo = new RecruitingCompanyVideo();
        $id = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id);
        $this->assertEquals($RecruitingCompanyVideo->id, $id);
        $this->assertEquals($RecruitingCompanyVideo->source, $source);
        $this->assertEquals($RecruitingCompanyVideo->source_id, $source_id);
        $this->assertEquals($RecruitingCompanyVideo->recruiting_company_id, $this->RecruitingCompany->id);

        // check it's in the DB
        $RecruitingCompanyVideo2 = new RecruitingCompanyVideo($id);
        $this->assertEquals($RecruitingCompanyVideo2->id, $id);
        $this->assertEquals($RecruitingCompanyVideo->source, $source);
        $this->assertEquals($RecruitingCompanyVideo->source_id, $source_id);
        $this->assertEquals($RecruitingCompanyVideo2->recruiting_company_id, $this->RecruitingCompany->id);
    }

    /**
     * Tests the getByRecruitingTokenLongId function.
     */
    public function testGetByRecruitingTokenLongId()
    {
        $RecruitingCompanyVideo = new RecruitingCompanyVideo();

        // token with no images should return empty array
        $images = $RecruitingCompanyVideo->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertTrue(empty($images));

        // create token images
        $source = 'vimeo';
        $source_id[1] = rand();
        $source_id[2] = rand();
        $source_id[3] = rand();
        $id = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[1]);
        $id = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[2]);
        $id = $RecruitingCompanyVideo->create($this->RecruitingCompany->id, $source, $source_id[3]);
        $images = $RecruitingCompanyVideo->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
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
        $query = "INSERT INTO recruiting_company_video (recruiting_company_id)
                  VALUES ('{$this->RecruitingCompany->id}')";
        $id = insert($query);
        $result = new RecruitingCompanyVideo($id);


        // delete token video
        $result->delete();

        // check class variables get unset
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->recruiting_company_id));
        $this->assertFalse(isset($result->source));
        $this->assertFalse(isset($result->source_id));

        // check it's gone from DB
        $result2 = new RecruitingCompanyVideo($id);
        $this->assertFalse(isset($result2->id));
    }
}
