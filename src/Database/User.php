<?php
namespace Sizzle\Database;

class User extends \Sizzle\DatabaseEntity
{
    protected $email_address;
    protected $first_name;
    protected $last_name;
    protected $organization_id;
    protected $password = null;
    protected $activation_key = null;
    protected $admin = "N";
    protected $stripe_id;
    protected $active_until;
    protected $facebook_email;
    protected $access_token;
    protected $position;
    protected $linkedin;
    protected $face_image;
    protected $about;
    protected $user_group;
    protected $group_admin;
    protected $reset_code;
    protected $internal;
    protected $allow_token_responses;
    protected $receive_token_notifications;

    public static function exists($email_address)
    {
        $exists = false;
        $user = User::fetch($email_address);
        if ($user) {
            $exists = true;
        }
        return $exists;
    }

    /**
     * Fetches a user object by email or reset code
     *
     * @param string $value - the value of the key
     * @param string $key   - email_address or reset_code
     *
     * @return User - the corresponding object
     */
    public static function fetch($value, $key = 'email_address')
    {
        $user = null;
        $value = escape_string($value);
        switch ($key) {
        case 'api_key':
            $condition = "api_key = '$value'";
            break;
        case 'email_address':
            $condition = "upper(email_address) = '".strtoupper($value)."'";
            break;
        case 'reset_code':
            $condition = "reset_code = '$value'";
            break;
        default:
            return $user;
        }
        $result = execute_query(
            "SELECT * FROM user
            WHERE $condition"
        );
        if ($result->num_rows > 0) {
            $user = $result->fetch_object("Sizzle\Database\User");
        }
        return $user;
    }

    public function update_token($token = null)
    {
        if ($token !== null) {
            $token = escape_string($token);
            execute_query("UPDATE user set access_token = '".$token."' WHERE id = '$this->id'");
        }
    }

    public function save()
    {
        if (!isset($this->organization_id)) {
            $this->organization_id = false !== strpos($this->email_address, 'gosizzle.io') ? '1' : null;
        }
        if (!$this->id) {
            $sql = "INSERT into user (email_address, first_name, last_name, password, activation_key, admin, access_token "
            .", position, about, user_group, linkedin, face_image, group_admin, internal, organization_id) VALUES ("
            ."'".escape_string($this->email_address)."'"
            .", '".escape_string($this->first_name)."'"
            .", '".escape_string($this->last_name)."'"
            .", ".($this->password ? "'".$this->password."'" : "null")
            .", ".($this->activation_key ? "'".$this->activation_key."'" : "null")
            .", '$this->admin'"
            .", '$this->access_token', '$this->position'"
            .", '$this->about' "
            .", ".($this->user_group ? $this->user_group : "null")
            .", ".($this->linkedin ? "'$this->linkedin'" : "null")
            .", ".($this->face_image ? "'$this->face_image'" : "null")
            .", '$this->group_admin'"
            .", '".(false !== strpos($this->email_address, 'gosizzle.io') ? 'Y' :'N')."'"
            .", ".($this->organization_id ? "'$this->organization_id'" : "null").")";
            $this->id = insert($sql);
        } else {
            $sql = "UPDATE user SET email_address = '".escape_string($this->email_address)."', "
            . "first_name = '".escape_string($this->first_name)."', "
            . "last_name = '".escape_string($this->last_name)."', "
            . "password = ".($this->password ? "'".$this->password."'" : "null").", "
            . "activation_key = ".($this->activation_key ? "'".$this->activation_key."'" : "null").", "
            . "admin = '".escape_string($this->admin)."', "
            . "stripe_id = ".($this->stripe_id ? "'".escape_string($this->stripe_id)."'" : "null").", "
            . "active_until =  ".($this->active_until ? "'".escape_string($this->active_until)."'" : "null").", "
            . "access_token = '$this->access_token', "
            . "position = '".escape_string($this->position)."', "
            . "about = '".escape_string($this->about)."', "
            . "user_group = ".escape_string($this->user_group ? $this->user_group : "null").", "
            . "linkedin = ".($this->linkedin ? "'".escape_string($this->linkedin)."'" : "null").", "
            . "face_image = ".($this->face_image ? "'".escape_string($this->face_image)."'" : "null").", "
            . "group_admin = '".escape_string($this->group_admin)."', "
            . "reset_code = '$this->reset_code', "
            . "allow_token_responses = '$this->allow_token_responses', "
            . "receive_token_notifications = '$this->receive_token_notifications' "
            . "WHERE id = '$this->id'";
            execute($sql);
        }
    }

}
