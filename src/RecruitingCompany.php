<?php
namespace Sizzle;

class RecruitingCompany
{
    public $id;
    public $user_id;
    public $name;
    public $logo;
    public $website;
    public $values;
    public $facebook;
    public $linkedin;
    public $youtube;
    public $twitter;
    public $google_plus;
    public $pinterest;
    public $created;

    /**
     * This function constructs the class
     *
     * @param int $id - optional id of the company
     */
    public function __construct($id = null)
    {
        if ($id !== null) {
            $company = execute_query(
                "SELECT * FROM recruiting_company WHERE id = '$id'"
            )->fetch_object("Sizzle\RecruitingCompany");
            if ($company) {
                foreach (get_object_vars($company) as $key => $value) {
                    if (isset($value)) {
                        $this->$key = $value;
                    }
                }
            }
        }
    }

    /**
     * This function inserts information from the class into the database
     */
    private function insert()
    {
        $omitted = ['id','created'];
        $comma = null;
        $columns = null;
        $values = null;
        $sql = 'INSERT INTO recruiting_company (';
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $omitted) && isset($value)) {
                $columns .= $comma.'`'.$key.'`';
                $values .= $comma."'".escape_string($value)."'";
                $comma = ', ';
            }
        }
        $sql .= $columns.') VALUES (';
        $sql .= $values.')';
        $this->id = insert($sql);
        $query = "SELECT created FROM recruiting_company WHERE id = '{$this->id}'";
        $result = execute_query($query);
        $row = $result->fetch_assoc();
        $this->created = $row['created'];
    }

    /**
     * This function updates information from the class into the database
     */
    private function update()
    {
        $saved = new RecruitingToken($this->id);

        $omitted = ['id','created'];
        $comma = null;
        $sql = 'UPDATE recruiting_company SET ';
        foreach (get_object_vars($this) as $key => $value) {
            if (!in_array($key, $omitted)) {
                $sql .= $comma.'`'.$key.'`'." = ";
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

    /**
     * This function saves information from the class into the database
     */
    public function save()
    {
        if (!$this->id) {
            $this->insert();
        } else {
            $this->update();
        }
    }
}
