<?php
namespace Sizzle\Tests\Token;

use \Sizzle\Database\{
    RecruitingCompany,
    RecruitingCompanyImage,
    RecruitingToken,
    RecruitingTokenImage
};

/**
 * This class tests the token presentation to LinkedIn
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Token/LinkedInBotTest
 */
class LinkedInBotTest
extends \PHPUnit_Framework_TestCase
{
    use \Sizzle\Tests\Traits\City;
    use \Sizzle\Tests\Traits\User;

    /**
     * Sets up class vars
     */
    public function setUp()
    {
        // create a city for testing
        $this->city = $this->createCity();

        // setup test user
        $this->user = $this->createUser();
    }

    /**
     * Tests the endpoint with a bad token long_id
     */
    public function testBadTokenId()
    {
        $url = TEST_URL.'/token/recruiting/'.rand();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals('', $response);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * Job Description
     */
    public function testMinimalToken()
    {
        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        //print_r($response);
        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * company
     * location
     * Job Description
     */
    public function testCompanyName()
    {
        // setup test company
        $company = new RecruitingCompany();
        $company->user_id = $this->user->id;
        $company->name = 'Anteil '.rand().', GmbH';
        $company->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->recruiting_company_id = $company->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        //print_r($response);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertContains($company->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * company image
     * Job Description
     */
    public function testCompanyImage()
    {
        // setup test company with image
        $company = new RecruitingCompany();
        $company->user_id = $this->user->id;
        $company->save();
        $file = rand().'.png';
        (new RecruitingCompanyImage())->create($company->id, $file);

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->recruiting_company_id = $company->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        //print_r($response);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertContains($file, $response);
        $this->assertContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * screenshot
     * Job Description
     */
    public function testScreenshot()
    {
        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->save();

        // setup screenshot
        $file = rand().'.gif';
        (new RecruitingTokenImage())->create($file, $RecruitingToken->id);

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        //print_r($response);
        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertContains($RecruitingToken->screenshot(), $response);
        $this->assertContains($file, $response);
        $this->assertContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * Job Description
     * Skills Required
     */
    public function testSkills()
    {
        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->skills_required = 'Have '.rand().' mutant powers!';
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));
        //print_r($response);
        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertContains('<h2>Skills Required</h2>', $response);
        $this->assertContains($RecruitingToken->skills_required, $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * Job Description
     * Responsibilities
     */
    public function testResponsibilities()
    {
        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->responsibilities = 'Be excellent to eachother. Party on dudes!';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        //print_r($response);
        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertContains('<h2>Responsibilities</h2>', $response);
        $this->assertContains($RecruitingToken->responsibilities, $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * Job Description
     * Company Values
     */
    public function testValues()
    {
        // setup test company
        $company = new RecruitingCompany();
        $company->user_id = $this->user->id;
        $company->values = 'Aum';
        $company->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->recruiting_company_id = $company->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        //print_r($response);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertContains('<h2>Company Values</h2>', $response);
        $this->assertContains($company->values, $response);
        $this->assertNotContains('<h2>Perks</h2>', $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * location
     * Job Description
     * Perks
     */
    public function testPerks()
    {
        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->perks = rand().' ping pong tables';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->save();

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        //print_r($response);
        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertNotContains('<img src', $response);
        $this->assertNotContains('<h2>Skills Required</h2>', $response);
        $this->assertNotContains('<h2>Responsibilities</h2>', $response);
        $this->assertNotContains('<h2>Company Values</h2>', $response);
        $this->assertContains('<h2>Perks</h2>', $response);
        $this->assertContains($RecruitingToken->perks, $response);
    }

    /**
     * Tests the endpoint with a good token long_id for a token containing
     * job title
     * company
     * location
     * screenshot
     * Job Description
     * Skills Required
     * Responsibilities
     * Company Values
     * Perks
     */
    public function testFullToken()
    {
        // setup test company
        $company = new RecruitingCompany();
        $company->user_id = $this->user->id;
        $company->name = 'Anteil '.rand().', GmbH';
        $company->values = 'Aum '.rand();
        $company->save();

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->user->id;
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->job_title = 'Job #'.rand();
        $RecruitingToken->job_description = 'Do the '.rand().' things. Every day.';
        $RecruitingToken->city_id = $this->city->id;
        $RecruitingToken->recruiting_company_id = $company->id;
        $RecruitingToken->skills_required = 'Have '.rand().' mutant powers!';
        $RecruitingToken->responsibilities = 'Be excellent to '.rand().'. Party on dudes!';
        $RecruitingToken->perks = rand().' ping pong tables';
        $RecruitingToken->save();

        // setup screenshot
        $file = rand().'.gif';
        (new RecruitingTokenImage())->create($file, $RecruitingToken->id);

        // get the bot token version
        $url = TEST_URL.'/token/recruiting/'.$RecruitingToken->long_id;
        //echo $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-agent: LinkedInBot 1.0 blah blah blah'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        //print_r($response);
        $this->assertEquals(200, curl_getinfo($ch, CURLINFO_HTTP_CODE));

        $this->thingsThatShouldAlwaysBeThere($response);
        $this->assertContains($RecruitingToken->job_title, $response);
        $this->assertContains('<h2>Job Description</h2>', $response);
        $this->assertContains($RecruitingToken->job_description, $response);
        $this->assertContains($this->city->name, $response);
        $this->assertContains($company->name, $response);
        $this->assertContains($file, $response);
        $this->assertContains('<img src', $response);
        $this->assertContains('<h2>Skills Required</h2>', $response);
        $this->assertContains($RecruitingToken->skills_required, $response);
        $this->assertContains('<h2>Responsibilities</h2>', $response);
        $this->assertContains($RecruitingToken->responsibilities, $response);
        $this->assertContains('<h2>Company Values</h2>', $response);
        $this->assertContains($company->values, $response);
        $this->assertContains('<h2>Perks</h2>', $response);
        $this->assertContains($RecruitingToken->perks, $response);
    }

    /**
     * Helper function to test things that should always be there
     *
     * @param string $html - the html to test for things
     */
    protected function thingsThatShouldAlwaysBeThere(string $html)
    {
        $this->assertContains('<!doctype html>', $html);
        $this->assertContains('<html lang="en">', $html);
        $this->assertContains('<head>', $html);
        $this->assertContains('<meta charset="UTF-8">', $html);
        $this->assertContains('<meta name="description" content="S!zzle Recruiting Token">', $html);
        $this->assertContains('<meta name="keywords" content="">', $html);
        $this->assertContains('<meta name="author" content="S!zzle">', $html);
        $this->assertContains('</head>', $html);
        $this->assertContains('<body>', $html);
        $this->assertContains('</body>', $html);
        $this->assertContains('</html>', $html);
    }

    /**
     * Delete cities & users created for testing
     */
    protected function tearDown()
    {
        //$this->deleteCities();
        //$this->deleteUsers();
    }
}
