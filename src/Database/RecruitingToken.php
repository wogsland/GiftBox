<?php
namespace Sizzle\Database;

/**
 * This class is for interacting with the recruiting_token table.
 */
class RecruitingToken extends \Sizzle\DatabaseEntity
{
    protected $long_id;
    protected $user_id;
    protected $job_title;
    protected $job_description;
    protected $city_id;
    protected $skills_required;
    protected $responsibilities;
    protected $perks;
    protected $recruiting_company_id;
    protected $recruiter_profile;

    /**
     * This function constructs the class
     *
     * @param mixed  $value - optional id of the token
     * @param string $key   - optional parameter to test $value against: 'id' (default) or 'long_id'
     */
    public function __construct($value = null, string $key = null)
    {
        if ($value !== null) {
            if ($key == null || !in_array($key, array('id','long_id'))) {
                $key = 'id';
            }
            $value = escape_string($value);
            $token = execute_query("SELECT * FROM recruiting_token WHERE $key = '$value'")->fetch_object("Sizzle\Database\RecruitingToken");
            if ($token) {
                foreach (get_object_vars($token) as $key => $value) {
                    if (isset($value)) {
                        $this->$key = $value;
                    }
                }
            }
        }
    }

    public static function getUserTokens(int $user_id)
    {
        $user_id = (int) $user_id;
        $results =  execute_query(
            "SELECT recruiting_token.*, COALESCE(recruiting_company.`name`, 'Unnamed Company') as company
            FROM recruiting_token
            LEFT JOIN recruiting_company ON recruiting_company.id = recruiting_company_id
            WHERE recruiting_token.user_id = '$user_id'
            ORDER BY company, job_title"
        );
        $user_tokens = array();
        while($token = $results->fetch_object()) {
            $user_tokens[count($user_tokens)] = $token;
        }
        $results->free();
        return $user_tokens;
    }

    public function getUser()
    {
        $user = null;
        $result = execute_query(
            "SELECT * FROM user WHERE id='$this->user_id'"
        );

        if ($result->num_rows > 0) {
            $user = $result->fetch_object("Sizzle\Database\User");
        }
        return $user;
    }

    public function getCompany()
    {
        $company = null;
        $result = execute_query(
            "SELECT * FROM recruiting_company WHERE id='$this->recruiting_company_id'"
        );

        if ($result->num_rows > 0) {
            $company = $result->fetch_object("Sizzle\Database\RecruitingCompany");
        }
        return $company;
    }

    /**
     * Gets information about recruiting companies owned by the user specified
     *
     * @param int $user_id - the user whose companies are being returned
     */
    public static function getUserCompanies(int $user_id)
    {
        $user_id = (int) $user_id;
        $query = "SELECT id, `name`
                  FROM recruiting_company
                  WHERE user_id = '$user_id'";
        $results = execute_query($query);
        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function init($post)
    {
        foreach (get_object_vars($post) as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    private function changeFileName(string $file_name)
    {
        $new_file_name = $this->id."_".$this->user_id."_".$file_name;
        return $new_file_name;
    }

    public function delete()
    {
        $sql = "DELETE FROM recruiting_token WHERE id = '$this->id'";
        execute($sql);
    }

    /**
     * This function tests a long_id for uniqueness
     *
     * @param string $long_id - optional id to test (defaults to class property)
     *
     * @return boolean - is it unique
     */
    public function uniqueLongId(string $long_id = '')
    {
        if ('' == $long_id) {
            $long_id = $this->long_id;
        }
        $long_id = escape_string($long_id);
        $sql = "SELECT id FROM recruiting_token WHERE long_id = '$long_id'";
        $result = execute_query($sql);
        if (0 == $result->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function returns the screenshot file name
     *
     * @return mixed - name of screenshot file or false if there isn't one
     */
    public function screenshot()
    {
        $return = false;
        if (isset($this->id)) {
            $images = (new RecruitingTokenImage())->getByRecruitingTokenId($this->id);
            if (!empty($images)) {
                $return = $images[0]['file_name'];
            }
        }
        return $return;
    }

    /**
     * This function returns the properties in an array
     *
     * @return array - array of class properties
     */
    public function toArray()
    {
        $data = get_object_vars($this);
        unset($data['readOnly']);
        return $data;
    }
}
