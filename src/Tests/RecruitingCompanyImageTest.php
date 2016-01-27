<?php
namespace Sizzle\Tests;

use \Sizzle\{
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken,
    User
};

/**
 * This class tests the RecruitingCompanyImage class
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/RecruitingCompanyImageTest
 */
class RecruitingCompanyImageTest
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
        $RecruitingCompany->name = 'The '.rand().' Company';
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
        $result = new RecruitingCompanyImage();
        $this->assertEquals('Sizzle\RecruitingCompanyImage', get_class($result));
        $this->assertFalse(isset($result->id));

        // invalid id case
        $result = new RecruitingCompanyImage(-1);
        $this->assertEquals('Sizzle\RecruitingCompanyImage', get_class($result));
        $this->assertFalse(isset($result->id));

        // valid id case
        $file_name = rand().'.jpg';
        $query = "INSERT INTO recruiting_company_image (recruiting_company_id, file_name)
                  VALUES ('{$this->RecruitingCompany->id}', '$file_name')";
        $id = insert($query);
        $result = new RecruitingCompanyImage($id);
        $this->assertEquals('Sizzle\RecruitingCompanyImage', get_class($result));
        $this->assertTrue(isset($result->id));
        $this->assertEquals($result->id, $id);
        $this->assertEquals($result->file_name, $file_name);
        $this->assertEquals($result->recruiting_company_id, $this->RecruitingCompany->id);
        $this->assertTrue(isset($result->created));
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // create token image
        $file_name = rand().'.jpg';
        $RecruitingCompanyImage = new RecruitingCompanyImage();
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name);
        $this->assertEquals($RecruitingCompanyImage->id, $id);
        $this->assertEquals($RecruitingCompanyImage->file_name, $file_name);
        $this->assertEquals($RecruitingCompanyImage->recruiting_company_id, $this->RecruitingCompany->id);
        $this->assertTrue(isset($RecruitingCompanyImage->created));

        // check it's in the DB
        $RecruitingCompanyImage2 = new RecruitingCompanyImage($id);
        $this->assertEquals($RecruitingCompanyImage2->id, $id);
        $this->assertEquals($RecruitingCompanyImage2->file_name, $file_name);
        $this->assertEquals($RecruitingCompanyImage2->recruiting_company_id, $this->RecruitingCompany->id);
        $this->assertTrue(isset($RecruitingCompanyImage2->created));
    }

    /**
     * Tests the delete function.
     */
    public function testDelete()
    {
        // creaete image
        $file_name = rand().'.jpg';
        $query = "INSERT INTO recruiting_company_image (recruiting_company_id, file_name)
                  VALUES ('{$this->RecruitingCompany->id}', '$file_name')";
        $id = insert($query);
        $result = new RecruitingCompanyImage($id);
        $this->assertTrue(isset($result->id));

        // delete image
        $result->delete();

        // check class variables get unset
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->recruiting_company_id));
        $this->assertFalse(isset($result->file_name));

        // check it's gone from DB
        $result2 = new RecruitingCompanyImage($id);
        $this->assertFalse(isset($result2->id));

        //check it's deleted from the filesystem
        $this->markTestIncomplete();
    }

    /**
     * Tests the getByRecruitingTokenId function.
     */
    public function testGetByRecruitingTokenId()
    {
        $RecruitingCompanyImage = new RecruitingCompanyImage();

        // token with no images should return empty array
        $images = $RecruitingCompanyImage->getByRecruitingTokenId($this->RecruitingToken->id);
        $this->assertTrue(is_array($images));
        $this->assertTrue(empty($images));

        // create token images
        $file_name[1] = rand().'.jpg';
        $file_name[2] = rand().'.jpg';
        $file_name[3] = rand().'.jpg';
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[1]);
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[2]);
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[3]);
        $images = $RecruitingCompanyImage->getByRecruitingTokenId($this->RecruitingToken->id);
        $this->assertTrue(is_array($images));
        $this->assertEquals(count($images), 3);
        foreach ($images as $image) {
            $this->assertTrue($image['id'] > 0);
            $this->assertTrue(in_array($image['file_name'], $file_name));
        }
    }

    /**
     * Tests the getByRecruitingTokenLongId function.
     */
    public function testGetByRecruitingTokenLongId()
    {
        $RecruitingCompanyImage = new RecruitingCompanyImage();

        // token with no images should return empty array
        $images = $RecruitingCompanyImage->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertTrue(empty($images));

        // create token images
        $file_name[1] = rand().'.jpg';
        $file_name[2] = rand().'.jpg';
        $file_name[3] = rand().'.jpg';
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[1]);
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[2]);
        $id = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[3]);
        $images = $RecruitingCompanyImage->getByRecruitingTokenLongId($this->RecruitingToken->long_id);
        $this->assertTrue(is_array($images));
        $this->assertEquals(count($images), 3);
        foreach ($images as $image) {
            $this->assertTrue($image['id'] > 0);
            $this->assertTrue(in_array($image['file_name'], $file_name));
        }
    }
}
