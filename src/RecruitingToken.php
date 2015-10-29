<?php
namespace GiveToken;

class RecruitingToken
{
    var $id;
    var $user_id;
    var $job_title;
    var $job_description;
    var $skills_required;
    var $responsibilities;
    var $perks;
    var $job_locations;
    var $company;
    var $salary_range;
    var $full_time_part_time;
    var $ask_interested;
    var $ask_salary;
    var $ask_remote;
    var $company_video;
    var $company_picture;
    var $company_tagline;
    var $company_values;
    var $backdrop_picture;
    var $backdrop_color;
    var $style;
    var $special_size;
    var $company_facebook;
    var $company_linkedin;
    var $company_twitter;
    var $company_youtube;

    public function __construct($id = null)
    {
        if ($id !== null) {
            $token = execute_query("SELECT * from recruiting_token where id = '$id'")->fetch_object("GiveToken\RecruitingToken");
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
            execute("UPDATE recruiting_token SET backdrop_picture  = '$new_file_name' WHERE id = $this->id");
            $this->backdrop_picture = $new_file_name;
        }
        if (strlen($this->company_picture) > 0) {
            $new_file_name = $this->changeFileName($this->company_picture);
            execute("UPDATE recruiting_token SET backdrop_picture  = '$new_file_name' WHERE id = $this->id");
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
        $sql .= " WHERE id = $this->id";
        execute($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM recruiting_token WHERE id = $this->id";
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
}
