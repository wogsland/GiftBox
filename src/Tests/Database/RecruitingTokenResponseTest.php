<?php
namespace Sizzle\Tests\Database;

use \Sizzle\Database\{
    RecruitingTokenResponse,
    RecruitingToken,
    User
};

/**
 * This class tests the RecruitingTokenResponse class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/Tests/Database/RecruitingTokenResponseTest
 */
class RecruitingTokenResponseTest
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

        // setup test token
        $RecruitingToken = new RecruitingToken();
        $RecruitingToken->user_id = $this->User->getId();
        $RecruitingToken->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken->save();
        $this->RecruitingToken = $RecruitingToken;
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        $result = new RecruitingTokenResponse();
        $this->assertEquals('Sizzle\Database\RecruitingTokenResponse', get_class($result));
    }

    /**
     * Tests the create function.
     */
    public function testCreate()
    {
        // Test function success
        $RecruitingTokenResponse = new RecruitingTokenResponse();
        $email = rand() . '@gmail.com';
        $this->assertEquals($this->RecruitingToken->id, (int) $this->RecruitingToken->id);
        $this->assertTrue((bool) filter_var($email, FILTER_VALIDATE_EMAIL));
        $id = $RecruitingTokenResponse->create($this->RecruitingToken->long_id, $email, 'Yes');
        $this->assertGreaterThan(0, $id);
        $id = $RecruitingTokenResponse->create($this->RecruitingToken->long_id, $email, 'No');
        $this->assertGreaterThan(0, $id);
        $id = $RecruitingTokenResponse->create($this->RecruitingToken->long_id, $email, 'Maybe');
        $this->assertGreaterThan(0, $id);

        // Test function fails
        $id = $RecruitingTokenResponse->create($this->RecruitingToken->long_id, $email, 'T');
        $this->assertEquals(0, $id);
        $id = $RecruitingTokenResponse->create($this->RecruitingToken->long_id, 'T', 'Yes');
        $this->assertEquals(0, $id);
        $id = $RecruitingTokenResponse->create('T', $email, 'Yes');
        $this->assertEquals(0, $id);
    }

    /**
     * Tests the get function.
     */
    public function testGet()
    {
        // grab for a single token
        $user_id = $this->User->getId();
        $long_id = $this->RecruitingToken->long_id;
        $RecruitingTokenResponse = new RecruitingTokenResponse();
        $possible = ['Yes','No','Maybe'];
        $responses = array();
        $count = 10;
        for ($i=0; $i<$count; $i++) {
            $email = rand() . '@gmail.com';
            $response = $possible[array_rand($possible)];
            $id = $RecruitingTokenResponse->create($long_id, $email, $response);
            $responses[] = array(
                'email' => $email,
                'response' => $response,
                'id' => $id
            );
        }
        $this->assertEquals($count, count($responses));
        $resp = $RecruitingTokenResponse->get($user_id, $long_id);
        $this->assertEquals($count, count($resp));
        $found = 0;
        foreach ($responses as $r1) {
            foreach ($resp as $r2) {
                if ($r1['email'] == $r2['email']) {
                    $found++;
                    $this->assertEquals($r1['response'], $r2['response']);
                    $this->assertEquals($r1['id'], $r2['id']);
                }
            }
        }
        $this->assertEquals($count, $found);

        // grab for a single user, all tokens
        $RecruitingToken2 = new RecruitingToken();
        $RecruitingToken2->user_id = $this->User->getId();
        $RecruitingToken2->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken2->save();
        $email = rand() . '@gmail.com';
        $response = $possible[array_rand($possible)];
        $id = $RecruitingTokenResponse->create($RecruitingToken2->long_id, $email, $response);
        $responses[] = array(
            'email' => $email,
            'response' => $response,
            'id' => $id
        );
        $RecruitingToken3 = new RecruitingToken();
        $RecruitingToken3->user_id = $this->User->getId();
        $RecruitingToken3->long_id = substr(md5(microtime()), rand(0, 26), 20);
        $RecruitingToken3->save();
        $email = rand() . '@gmail.com';
        $response = $possible[array_rand($possible)];
        $id = $RecruitingTokenResponse->create($RecruitingToken3->long_id, $email, $response);
        $responses[] = array(
            'email' => $email,
            'response' => $response,
            'id' => $id
        );
        $new_count = $count+2;
        $this->assertEquals($new_count, count($responses));
        $resp = $RecruitingTokenResponse->get($user_id, $long_id);// without new two
        $this->assertEquals($count, count($resp));
        $resp = $RecruitingTokenResponse->get($user_id);//with new two
        $this->assertEquals($new_count, count($resp));
        $found = 0;
        foreach ($responses as $r1) {
            foreach ($resp as $r2) {
                if ($r1['email'] == $r2['email']) {
                    $found++;
                    $this->assertEquals($r1['response'], $r2['response']);
                    $this->assertEquals($r1['id'], $r2['id']);
                }
            }
        }
        $this->assertEquals($new_count, $found);
    }
}
