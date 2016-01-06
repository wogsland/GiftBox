<?php
namespace GiveToken;

use \Monolog\Handler\SlackHandler;
use \Monolog\Logger;

class UserMilestone
{
    public $id;
    public $user_id;
    public $milestone_id;
    public $created;

    /**
     * This function constructs the class from a valid user_id & milestone.
     * Fails silently for invalid input.
     *
     * @param int $user_id - id of the user acheiving the milestone
     * @param mixed $milestone - name or id of milestone
     */
    public function __construct($user_id, $milestone)
    {
        // get milestone
        $Milestone = new Milestone($milestone);

        if (isset($Milestone->id) && (int)$user_id > 0) {
            // see if this user_milestone exists already
            $query = "SELECT id, created
                      FROM user_milestone
                      WHERE user_id = '$user_id'
                      AND milestone_id = '{$Milestone->id}'";
            $result = execute_query($query);
            if ($result->num_rows > 0) {
                $user_milestone = $result->fetch_assoc();
                $this->id = $user_milestone['id'];
                $this->user_id = $user_id;
                $this->milestone_id = $Milestone->id;
                $this->created = $user_milestone['created'];
            } else {

                try {
                    // create the milestone
                    $query = "INSERT INTO user_milestone (user_id, milestone_id)
                              VALUES ('$user_id', '{$Milestone->id}')";
                    $id = insert($query);

                    // set class properties
                    $this->id = $id;
                    $this->user_id = $user_id;
                    $this->milestone_id = $Milestone->id;
                    $this->created = date('Y-m-d H:i:s');//close enough

                    // send it to Slack
                    $milestoneLogger = new Logger('milestones');
                    $User = new User($user_id);
                    $name = 'Customer Milestone Bot';
                    if (DEVELOPMENT) {
                        $slackHandler = new SlackHandler(SLACK_TOKEN, '#development', $name, false);
                    } else {
                        $slackHandler = new SlackHandler(SLACK_TOKEN, '#customers', $name, false);
                    }
                    $slackHandler->setLevel(Logger::DEBUG);
                    $milestoneLogger->pushHandler($slackHandler);
                    $milestoneLogger->log(200, "{$User->email_address} achieved the *{$Milestone->name}* milestone.");
                } catch (Exception $e) {
                  //silent fail
                }
            }
        }
    }
}
