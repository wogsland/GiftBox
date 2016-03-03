<?php
namespace Sizzle\Tests\Ajax\User;

use \Sizzle\{
    Organization,
    RecruitingCompany,
    RecruitingToken,
    User
};

/**
 * This class tests the ajax endpoint to get the recruiter profile for a token.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/User/GetRecruiterProfileTest
 */
class GetRecruiterProfileTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../util.php';
    }

    /**
     * Set up for the tests by creating User/Company/Token
     */
    public function setUp()
    {
        $this->url = TEST_URL .'/ajax/user/get_recruiter_profile';

        // setup test organization
        $name = 'The '.rand().' Corporation';
        $website = 'http://www.'.rand().'.org';
        $this->Organization = new Organization((new Organization())->create($name, $website));

        // setup test user
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->organization_id = $this->Organization->id;
        $User->position = rand();
        $User->linkedin = 'https://linkedin.com/in/'.rand();
        $User->about = rand();
        $User->face_image = rand().'.jpg';
        $User->save();
        $this->User = $User;

        // setup test company
        $RecruitingCompany = new RecruitingCompany();
        $RecruitingCompany->user_id = $this->User->getId();
        $RecruitingCompany->name = 'The '.rand().' Company';
        $RecruitingCompany->website = 'https://'.rand().'.com/';
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
     * Tests request via ajax endpoint.
     */
    public function testRequest()
    {
        // test for created images
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$this->User->getId());
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertEquals($this->User->first_name, $return->data->first_name);
        $this->assertEquals($this->User->last_name, $return->data->last_name);
        $this->assertEquals($this->User->position, $return->data->position);
        $this->assertEquals($this->User->linkedin, $return->data->linkedin);
        $this->assertEquals($this->User->about, $return->data->about);
        $this->assertEquals($this->User->face_image, $return->data->face_image);
        $this->assertEquals($this->Organization->website, $return->data->website);
        $this->assertEquals($this->Organization->name, $return->data->organization);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('', $return->data);
        ob_end_clean();
    }
}
?>
