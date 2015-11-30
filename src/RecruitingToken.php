<?php
namespace GiveToken;

class RecruitingToken
{
    public $id;
    public $long_id;
    public $user_id;
    public $job_title;
    public $job_description;
    public $city_id;
    public $skills_required;
    public $responsibilities;
    public $perks;
    public $company;
    public $company_logo;
    public $company_tagline;
    public $company_website;
    public $company_values;
    public $company_size;
    public $company_facebook;
    public $company_linkedin;
    public $company_youtube;
    public $company_twitter;
    public $company_google_plus;

    /**
     * This function constructs the class
     *
     * @param mixed  $value - optional id of the token
     * @param string $key   - optional parameter to test $value against: 'id' (default) or 'long_id'
     */
    public function __construct($value = null, $key = null)
    {
        if ($value !== null) {
            if ($key == null || !in_array($key, array('id','long_id'))) {
                $key = 'id';
            }
            $token = execute_query("SELECT * FROM recruiting_token WHERE $key = '$value'")->fetch_object("GiveToken\RecruitingToken");
            if ($token) {
                foreach (get_object_vars($token) as $key => $value) {
                    if (isset($value)) {
                        $this->$key = $value;
                    } else {
                        unset($this->$key);
                    }
                }
            }
        }
    }

    public static function getUserTokens($user_id) {
        $results =  execute_query("SELECT * FROM recruiting_token where user_id = $user_id ORDER BY company, job_title");
        $user_tokens = array();
        while($token = $results->fetch_object()) {
            $user_tokens[count($user_tokens)] = $token;
        }
        $results->free();
        return $user_tokens;
    }

    public function init($post)
    {
        foreach (get_object_vars($post) as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    private function changeFileName($file_name)
    {
        $new_file_name = $this->id."_".$this->user_id."_".$file_name;
        return $new_file_name;
    }

    private function insert()
    {
        $omitted = ['id','company_images','company_videos'];
        $comma = null;
        $columns = null;
        $values = null;
        $sql = 'INSERT INTO recruiting_token (';
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $omitted) && isset($value)) {
                $columns .= $comma.$key;
                $values .= $comma."'".escape_string($value)."'";
                $comma = ', ';
            }
        }
        $sql .= $columns.') VALUES (';
        $sql .= $values.')';
        $this->id = insert($sql);
    }

    private function update()
    {
        $saved = new RecruitingToken($this->id);

        $omitted = ['id','company_images','company_videos'];
        $comma = null;
        $sql = 'UPDATE recruiting_token SET ';
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $omitted)) {
                $sql .= $comma.$key." = ";
                if (strlen($value) > 0) {
                    $sql .= "'".escape_string($value)."'";
                } else {
                    $sql .= 'NULL';
                }
                $comma = ', ';
            }
        }
        $sql .= " WHERE id = '$this->id'";
        execute($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM recruiting_token WHERE id = '$this->id'";
        execute($sql);
    }

    public function save()
    {
        if (!$this->id) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * This function tests a long_id for uniqueness
     *
     * @param string $long_id - optional id to test (defaults to class property)
     *
     * @return boolean - is it unique
     */
    public function uniqueLongId($long_id = '')
    {
        if ('' == $long_id) {
            $long_id = $this->long_id;
        }
        $sql = "SELECT id FROM recruiting_token WHERE long_id = '$long_id'";
        $result = execute_query($sql);
        if (0 == $result->num_rows) {
            return true;
        } else {
            return false;
        }
    }
}
