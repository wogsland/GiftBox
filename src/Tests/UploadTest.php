<?php
namespace Sizzle\Tests;

/**
 * This class tests the upload endpint
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/UploadTest
 */
class UploadTest
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
     * Sets up for the tests.
     */
    public function setUp()
    {
        $this->url = TEST_URL . "/upload";
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testSuccess()
    {
        $this->markTestIncomplete();
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
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('', $return->data);
    }

    /**
     * Tests request failure via ajax endpoint with a logged in user cookie.
     */
    public function testFailWithCookie()
    {
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertEquals('', $return->data);
    }
}
?>
