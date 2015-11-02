<?php
namespace GiveToken;

class RecruitingToken
{
    public $id;
    public $long_id;
    public $user_id;
    public $job_title;
    public $job_description;
    public $skills_required;
    public $responsibilities;
    public $perks;
    public $job_locations;
    public $company;
    public $salary_range;
    public $full_time_part_time;
    public $ask_interested;
    public $ask_salary;
    public $ask_remote;
    public $company_video;
    public $company_picture;
    public $company_tagline;
    public $company_values;
    public $backdrop_picture;
    public $backdrop_color;
    public $style;
    public $special_size;
    public $company_facebook;
    public $company_linkedin;
    public $company_twitter;
    public $company_youtube;

    /**
     * This function constructs the class
     *
     * @param mixed $value - optional id of the token
     * @param string $key - optional parameter to test $value against: 'id' (default) or 'long_id'
     */
    public function __construct($value = null, $key = null)
    {
        if ($value !== null) {
            if ($key == null || !in_array($key, array('id','long_id'))) {
              $key = 'id';
            }
            $token = execute_query("SELECT * FROM recruiting_token
                WHERE $key = '$value'")->fetch_object("GiveToken\RecruitingToken");
            foreach (get_object_vars($token) as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function init($post)
    {
        foreach (get_object_vars($post) as $key => $value) {
            $this->$key = $value;
        }
    }

    private function changeFileName($file_name)
    {
        $new_file_name = $this->id."_".$this->user_id."_".$file_name;
        return $new_file_name;
    }

    private function insert()
    {
        $comma = null;
        $columns = null;
        $values = null;
        $sql = 'INSERT INTO recruiting_token (';
        foreach (get_object_vars($this) as $key => $value) {
            if ($key !== 'id') {
                $columns .= $comma.$key;
                $values .= $comma."'".escape_string($value)."'";
                $comma = ', ';
            }
        }
        $sql .= $columns.') VALUES (';
        $sql .= $values.')';
        $this->id = insert($sql);

        if (strlen($this->backdrop_picture) > 0) {
            $new_file_name = $this->changeFileName($this->backdrop_picture);
            execute("UPDATE recruiting_token
                SET backdrop_picture  = '$new_file_name'
                WHERE id = '$this->id'");
            $this->backdrop_picture = $new_file_name;
        }
        if (strlen($this->company_picture) > 0) {
            $new_file_name = $this->changeFileName($this->company_picture);
            execute("UPDATE recruiting_token
                SET backdrop_picture  = '$new_file_name'
                WHERE id = '$this->id'");
            $this->company_picture = $new_file_name;
        }
    }

    private function update()
    {
        include 'config.php';
        $saved = new RecruitingToken($this->id);

        // Manage replacement of backdrop picture
        if (strlen($this->backdrop_picture) > 0) {
            if ($this->backdrop_picture !== $saved->backdrop_picture) {
                if (strlen($saved->backdrop_picture) > 0) {
                    unlink($file_storage_path.$saved->backdrop_picture);
                }
                $this->backdrop_picture = $this->changeFileName($this->backdrop_picture);
            }
        } else {
            if (strlen($saved->backdrop_picture) > 0) {
                unlink($file_storage_path.$saved->backdrop_picture);
            }
        }

        // Manage replacement of company picture
        if ((strlen($this->company_picture) > 0) && ($this->company_picture !== $saved->company_picture)) {
            if (strlen($saved->company_picture) > 0) {
                unlink($file_storage_path.$saved->company_picture);
            }
            $this->company_picture = $this->changeFileName($this->company_picture);
        }

        $comma = null;
        $sql = 'UPDATE recruiting_token SET ';
        foreach (get_object_vars($this) as $key => $value) {
            if ($key !== 'id') {
                $sql .= $comma.$key." = '".escape_string($value)."'";
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
