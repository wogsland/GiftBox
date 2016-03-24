<?php
namespace Sizzle\Tests\Database;

use \Sizzle\Database\{
    RecruitingCompany,
    RecruitingToken,
    RecruitingTokenImage
};

/**
 * This class tests the RecruitingToken class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/RecruitingTokenTest
 */
class RecruitingTokenTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\User;

    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Creates test user
     */
    public function setUp()
    {
        // setup test user
        $this->User = $this->createUser();
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // no params
        $result = new RecruitingToken();
        $this->assertEquals('Sizzle\Database\RecruitingToken', get_class($result));

        // save for 1 param
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
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
        $RecruitingToken->user_id = $this->User->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();

        // Test function with param
        $RecruitingToken2 = new RecruitingToken();
        $this->assertTrue($RecruitingToken2->uniqueLongId(rand()));
        $this->assertFalse($RecruitingToken2->uniqueLongId($RecruitingToken->long_id));

        // Test function without param
        $RecruitingToken2->long_id = $RecruitingToken->long_id;
        $this->assertFalse($RecruitingToken2->uniqueLongId());
    }

    /**
     * Tests the getUserCompanies function.
     */
    public function testGetUserCompanies()
    {
        // create some companies fo rthe user
        $co1 = new RecruitingCompany();
        $co1->name = 'Company '.rand();
        $co1->user_id = $this->User->id;
        $co1->save();
        $co2 = new RecruitingCompany();
        $co2->name = 'Company '.rand();
        $co2->user_id = $this->User->id;
        $co2->save();
        $co3 = new RecruitingCompany();
        $co3->name = 'Company '.rand();
        $co3->user_id = $this->User->id;
        $co3->save();

        $companies = RecruitingToken::getUserCompanies($this->User->id);
        //print_r($companies);
        $this->assertEquals(3, count($companies));
        $this->assertEquals($companies[0]['id'], $co1->id);
        $this->assertEquals($companies[0]['name'], $co1->name);
        $this->assertEquals($companies[1]['id'], $co2->id);
        $this->assertEquals($companies[1]['name'], $co2->name);
        $this->assertEquals($companies[2]['id'], $co3->id);
        $this->assertEquals($companies[2]['name'], $co3->name);
    }

    /**
     * Tests the getUser function.
     */
    public function testGetUser()
    {
        $result = new RecruitingToken();
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->save();

        $user = $result->getUser();
        $this->assertNotNull($user);
        $this->assertNotEquals('', $user);
        $this->assertEquals($this->User->id, $user->id);
        $this->assertEquals('Y', $user->allow_token_responses);
        $this->assertEquals('Y', $user->receive_token_notifications);
    }

    /**
     * Tests the getCompany function.
     */
    public function testGetCompany()
    {
        $co = new RecruitingCompany();
        $co->name = 'Company '.rand();
        $co->user_id = $this->User->id;
        $co->save();

        $result = new RecruitingToken();
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->recruiting_company_id = $co->id;
        $result->save();

        $company = $result->getCompany();
        $this->assertNotNull($company);
        $this->assertNotEquals('', $company);
        $this->assertEquals($co->id, $company->id);
        $this->assertEquals($co->name, $company->name);
        $this->assertEquals($this->User->id, $company->user_id);
    }

    /**
     * Tests the recruiter_profile enum is save properly
     */
    public function testSaveRecruiterProfile()
    {
        // create company
        $co = new RecruitingCompany();
        $co->name = 'Company '.rand();
        $co->user_id = $this->User->id;
        $co->save();

        // test save with default (N)
        $result = new RecruitingToken();
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->recruiting_company_id = $co->id;
        $result->save();
        $test = new RecruitingToken($result->id);
        $this->assertEquals('N', $test->recruiter_profile);

        // test save with Y
        $result = new RecruitingToken();
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->recruiting_company_id = $co->id;
        $result->recruiter_profile = 'Y';
        $result->save();
        $test = new RecruitingToken($result->id);
        $this->assertEquals($result->recruiter_profile, $test->recruiter_profile);

        // test save with N
        $result = new RecruitingToken();
        $result->user_id = $this->User->id;
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->recruiting_company_id = $co->id;
        $result->recruiter_profile = 'N';
        $result->save();
        $test = new RecruitingToken($result->id);
        $this->assertEquals($result->recruiter_profile, $test->recruiter_profile);
    }

    /**
     * Tests the screenshot function.
     */
    public function testScreenshot()
    {
        $token = new RecruitingToken();
        $token->user_id = $this->User->id;
        $token->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $token->save();

        // Create images
        $image = new RecruitingTokenImage();
        $fileName = rand().'.jpg';
        $id = $image->create($fileName, $token->id);

        // Test function
        $image = $token->screenshot();
        $this->assertEquals($image, $fileName);
    }

    /**
     * Delete users created for testing
     */
    protected function tearDown()
    {
        //$this->deleteUsers();
    }
}
