<?php
namespace Sizzle\Tests\Ajax\Email\Lista;
//the word "List" doesn't work in namespaces, so I translated it to Spanish

use \Sizzle\Database\{
    EmailList,
    EmailListEmail,
    User
};

/**
 * This class tests the ajax endpoint to add email credentials.
 *
 * ./vendor/bin/phpunit --bootstrap src/Tests/autoload.php src/Tests/Ajax/Email/Lista/UploadTest
 */
class UploadTest
extends \PHPUnit_Framework_TestCase
{
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../../../../util.php';
    }

    /**
     * Sets up class variables
     */
    public function setUp()
    {
        $this->url = TEST_URL . "/ajax/email/list/upload";
        $this->files = array();
    }

    /**
     * Tests a not logged in request via ajax endpoint.
     */
    public function testNotLoggedIn()
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
     * Tests request via ajax endpoint with no file.
     */
    public function testNoFile()
    {
        $fields = array(
            'listName'=>'list'.rand(),
        );
        $json = $this->curl($fields);
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('There were errors processing your request.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(1, count($return->data->errors));
        $this->assertTrue(in_array('File is required.', $return->data->errors));
    }

    /**
     * Tests request via ajax endpoint with no list name.
     */
    public function testNoListName()
    {
        $this->markTestIncomplete();

        $fileName = $this->createUploadFile();
        $path = realpath($fileName);
        $fields = array(
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $fileName",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('There were errors processing your request.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(1, count($return->data->errors));
        $this->assertTrue(in_array('List name is required.', $return->data->errors));
    }

    /**
     * Tests request via ajax endpoint no file and no list name.
     */
    public function testNoFileNoListName()
    {
        $json = $this->curl();
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('There were errors processing your request.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(2, count($return->data->errors));
        $this->assertTrue(in_array('File is required.', $return->data->errors));
        $this->assertTrue(in_array('List name is required.', $return->data->errors));
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testDuplicateListName()
    {
        $this->markTestIncomplete();

        $listName = 'list'.rand();

        // create the list once
        $fileName = $this->createUploadFile();
        $path = realpath($fileName);
        $fields = array(
            'listName'=>$listName,
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $path",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);

        // try to create a different list with the same name
        $fileName = $this->createUploadFile();
        $path = realpath($fileName);
        $fields = array(
            'listName'=>$listName,
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $path",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('That list name is already taken.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(1, count($return->data->errors));
        $this->assertTrue(in_array('That list name is already taken.', $return->data->errors));
    }

    /**
     * Tests request via ajax endpoint where list name matches another user's
     * list name, but not this user's.
     */
    public function testNotDupListName()
    {
        $this->markTestIncomplete();

        $listName = 'list'.rand();

        // create a user and a list
        $User = new User();
        $User->email_address = rand();
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $emailList = new EmailList();
        $emailListID = $emailList->create($User->id, $listName);

        // try to create a different list with the same name for a different user
        $fileName = $this->createUploadFile();
        $path = realpath($fileName);
        $fields = array(
            'listName'=>$listName,
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $path",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('true', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('Emails uploaded successfully.', $return->data->message);
        $this->assertFalse(isset($return->data->errors));
        $this->assertTrue(isset($return->data->list_id));

        //cleanup
        $emailList->delete();
        $emailList2 = new EmailList($return->data->list_id);
        $emailList2->delete();
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testBinaryFile()
    {
        $this->markTestIncomplete();
    }

    /**
     * Tests request via ajax endpoint with some bad emails.
     */
    public function testInvalidEmails()
    {
        $this->markTestIncomplete();

        $listName = 'list'.rand();
        $bad = rand(3, 13);
        $fileName = $this->createUploadFile(5, $bad);
        $path = realpath($fileName);
        $fields = array(
            'listName'=>$listName,
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $path",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('There were errors processing some emails.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals($bad, count($return->data->errors));
        $this->assertTrue(isset($return->data->list_id));
        for ($i=0;$i<$bad;$i++) {
            $endpos = strrpos($return->data->errors[$i], ' is not a valid email.');
            $this->assertGreaterThan(0, $endpos);
            $endlength = strlen($return->data->errors[$i]) - $endpos;
            $this->assertEquals(22, $endlength);
        }

        // clean up
        $emailList = new EmailList($return->data->list_id);
        $emailList->delete();
    }

    /**
     * Tests request via ajax endpoint.
     */
    public function testDuplicateEmails()
    {
        $this->markTestIncomplete();

        $listName = 'list'.rand();
        $email = 'duplicate'.rand().'@gosizzle.io';
        $dups = [$email, $email];
        $fileName = $this->createUploadFile(5, 0, $dups);
        $path = realpath($fileName);
        $fields = array(
            'listName'=>$listName,
            'fileName'=>$path,
        );
        $headers = array(
            "X-FILENAME: $path",
        );
        $json = $this->curl($fields, $headers);
        $return = json_decode($json);
        $this->assertEquals('false', $return->success);
        $this->assertTrue(is_object($return->data));
        $this->assertEquals('There were errors processing some emails.', $return->data->message);
        $this->assertTrue(is_array($return->data->errors));
        $this->assertEquals(1, count($return->data->errors));
        $this->assertTrue(in_array("$email is a duplicate.", $return->data->errors));

        // clean up
        $emailList = new EmailList($return->data->list_id);
        $emailList->delete();
    }

    /**
     * Tears down created things
     */
    protected function tearDown()
    {
        foreach ($this->files as $file) {
            unlink($file);
        }
    }

    /**
     * Creates a test file to upload.
     *
     * @param int $good - number of good emails in the file
     * @param int $bad  - number of bad emails in the file
     *
     * @return string - path to the file
     */
    protected function createUploadFile(int $good = 10, int $bad = 0, $include = array())
    {
        $hosts = ['@gosizzle.io', '@gmail.com', '@givetoken.com'];
        $newlines = ["\n", "\n\r", "\r\n"];
        $path = rand().'.txt';
        $file = fopen($path, 'w');
        for ($i=0;$i<$good;$i++) {
            $email = rand().$hosts[array_rand($hosts)].$newlines[array_rand($newlines)];
            fwrite($file, $email);
        }
        for ($i=0;$i<$bad;$i++) {
            $email = rand().' is not an email '.$newlines[array_rand($newlines)];
            fwrite($file, $email);
        }
        foreach ($include as $email) {
            fwrite($file, $email.$newlines[array_rand($newlines)]);
        }
        $this->files[] = $path;
        return $path;
    }

    /**
     * Curls with parameters.
     *
     * @param mixed $fields  - string or array of POST fields
     * @param array $headers - array of headers to set
     *
     * @return string - the curl return
     */
    protected function curl($fields = '', $headers = array())
    {
        ob_start();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_COOKIE, TEST_COOKIE);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $response = curl_exec($ch);
        $this->assertEquals(true, $response);
        $json = ob_get_contents();
        ob_end_clean();
        return $json;
    }
}
