<?php
namespace GiveToken\Tests;

use \GiveToken\UserMilestone;
use \GiveToken\User;

/**
 * This class tests the UserMilestone & Milestone classes
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/UserMilestoneTest
 */
class UserMilestoneTest extends \PHPUnit_Framework_TestCase
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
        $User->email_address = 'user-'.rand().'@gosizzle.io';
        $User->first_name = rand();
        $User->last_name = rand();
        $User->save();
        $this->User = $User;

        // setup test milestone
        $this->milestone_name = 'Super '.rand().' Thing';
        $query = "INSERT INTO milestone (`name`) VALUES ('{$this->milestone_name}')";
        $this->milestone_id = insert($query);
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // id case
        $UserMilestone = new UserMilestone($this->User->getId(), $this->milestone_id);
        $this->assertEquals('GiveToken\UserMilestone', get_class($UserMilestone));
        $this->assertTrue(isset($UserMilestone->id));
        $this->assertEquals($this->User->getId(), $UserMilestone->user_id);
        $this->assertEquals($this->milestone_id, $UserMilestone->milestone_id);
        $this->assertTrue(isset($UserMilestone->created));

        // name case
        $UserMilestone = new UserMilestone($this->User->getId(), $this->milestone_name);
        //print_r($UserMilestone);
        $this->assertEquals('GiveToken\UserMilestone', get_class($UserMilestone));
        $this->assertTrue(isset($UserMilestone->id));
        $this->assertEquals($this->User->getId(), $UserMilestone->user_id);
        $this->assertEquals($this->milestone_id, $UserMilestone->milestone_id);
        $this->assertTrue(isset($UserMilestone->created));
    }

    /**
     * Destroys the test data.
     */
    protected function tearDown()
    {
        $query = "DELETE FROM user_milestone WHERE milestone_id = '{$this->milestone_id}'";
        execute($query);
        $user_id = $this->User->getId();
        $query = "DELETE FROM user WHERE id = '{$user_id}'";
        execute($query);
        $query = "DELETE FROM milestone WHERE id = '{$this->milestone_id}'";
        execute($query);
    }
}
