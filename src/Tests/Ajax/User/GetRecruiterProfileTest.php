<?php
namespace Sizzle\Tests\Ajax\User;

use \Sizzle\{
    RecruitingCompany,
    RecruitingToken,
    User
};

/**
 * This class tests the ajax endpoint to get the recruiter profile for a token.
 *
 * phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/User/GetRecruiterProfileTest
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
     * Tests request via ajax endpoint.
     */
    public function testRequest()
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

        // setup test images
        $RecruitingCompanyImage = new RecruitingCompanyImage();
        $file_name[1] = rand().'.jpg';
        $file_name[2] = rand().'.jpg';
        $file_name[3] = rand().'.jpg';
        $id[1] = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[1]);
        $id[2] = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[2]);
        $id[3] = $RecruitingCompanyImage->create($this->RecruitingCompany->id, $file_name[3]);

        // test for created images
        $url = TEST_URL . "/ajax/recruiting_token/get_images/{$RecruitingToken->long_id}";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        //print_r($return);
        foreach ($return->data as $image) {
            $this->assertTrue(in_array($image->id, $id));
            $this->assertTrue(in_array($image->file_name, $file_name));
        }
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/recruiting_token/get_images";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
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
