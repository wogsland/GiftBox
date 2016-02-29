<?php
namespace Sizzle\Tests;

use \Sizzle\{
    RecruitingCompany,
    RecruitingToken,
    User
};

/**
 * This class tests the RecruitingToken class
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
        $this->assertEquals('Sizzle\RecruitingToken', get_class($result));

        // save for 1 param
        $result->user_id = $this->User->getId();
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
        $RecruitingToken->user_id = $this->User->getId();
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
        $co1->user_id = $this->User->getId();
        $co1->save();
        $co2 = new RecruitingCompany();
        $co2->name = 'Company '.rand();
        $co2->user_id = $this->User->getId();
        $co2->save();
        $co3 = new RecruitingCompany();
        $co3->name = 'Company '.rand();
        $co3->user_id = $this->User->getId();
        $co3->save();

        $companies = RecruitingToken::getUserCompanies($this->User->getId());
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
        $result->user_id = $this->User->getId();
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->save();

        $user = $result->getUser();
        $this->assertNotNull($user);
        $this->assertNotEquals('',$user);
        $this->assertEquals($this->User->getId(),$user->getId());
        $this->assertEquals('Y',$user->allow_token_responses);
        $this->assertEquals('Y',$user->receive_token_notifications);
    }

    /**
     * Tests the getCompany function.
     */
    public function testGetCompany()
    {
        $co = new RecruitingCompany();
        $co->name = 'Company '.rand();
        $co->user_id = $this->User->getId();
        $co->save();

        $result = new RecruitingToken();
        $result->user_id = $this->User->getId();
        $result->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $result->recruiting_company_id = $co->id;
        $result->save();

        $company = $result->getCompany();
        $this->assertNotNull($company);
        $this->assertNotEquals('',$company);
        $this->assertEquals($co->id,$company->id);
        $this->assertEquals($co->name,$company->name);
        $this->assertEquals($this->User->getId(),$company->user_id);
    }
}
