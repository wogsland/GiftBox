<?php
namespace Sizzle\Tests\Ajax;

/**
 * This class tests the ajax endpoint to scrape linkedin.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/LinkedInScraperTest
 */
class LinkedInScraperTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../util.php';
    }

    /**
     * Tests request via ajax endpoint.
     *
     * @runInSeparateProcess
     * @preserveGlobalState  disabled
     */
    public function testAttack()
    {
        // setup test credentials
        $email = rand().'@gosizzle.io';
        $password = rand();

        // try to delete the scraper directory & list files
        $url = TEST_URL . "/ajax/linkedin-scraper";
        $fields = array(
            'name'=>urlencode('; cd .. ; ls ; rm -rf scraper'),
            'name'=>urlencode('; cd ../.. ; ls'),
            'name'=>urlencode('; cd ../.. ; ls')
        );
        $fields_string = "";
        foreach ($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        $fields_string = rtrim($fields_string, '&');
        echo $fields_string;
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertTrue($response);
        $json = ob_get_contents();
        ob_end_clean();
        echo "\n\n".$json."\n\n";
        $return = json_decode($json);
        $this->assertTrue(file_exists(__DIR__.'/../../../ajax/scraper'));
        $this->assertNotContains('README.md', $return->data);
        $this->assertFalse($return->success);
    }

    /**
     * Tests request failure via ajax endpoint.
     */
    public function testFail()
    {
        $url = TEST_URL . "/ajax/linkedin-scraper";
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        $return = json_decode($json);
        ob_end_clean();
        $this->assertFalse($return->success);
    }
}
?>
