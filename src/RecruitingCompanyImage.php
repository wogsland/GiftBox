<?php
namespace Sizzle;

class RecruitingCompanyImage
{
    protected $id;
    protected $recruiting_company_id;
    protected $file_name;
    protected $created;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the recruiting company image to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $result = execute_query(
                "SELECT id, recruiting_company_id, file_name, created
                FROM recruiting_company_image
                WHERE id = '$id'"
            )->fetch_object("Sizzle\RecruitingCompanyImage");
            if (isset($result)) {
                foreach (get_object_vars($result) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * This function gets a protected property
     *
     * @param string $var - the class property desired
     *
     * @return mixed - the class property
     */
    public function __get($var)
    {
        if (isset($this->$var)) {
            return $this->$var;
        }
    }

    /**
     * This function checks if a protected property is set
     *
     * @param string $var - the class property to check
     *
     * @return bool - if the property is set
     */
    public function __isset($var)
    {
        return isset($this->$var);
    }

    /**
     * This function creates an entry in the recruiting_company_image table
     *
     * @param int    $recruiting_company_id - id of the company
     * @param string $file_name             - name of image file
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_company_id, $file_name)
    {
        $query = "INSERT INTO recruiting_company_image (recruiting_company_id, file_name)
                  VALUES ('$recruiting_company_id', '$file_name')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->recruiting_company_id = $recruiting_company_id;
            $this->file_name = $file_name;
            $this->created = date('Y-m-d H:i:s'); //close enough
        }
        return $id;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param int $recruiting_token_id - id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenId($recruiting_token_id)
    {
        $return = array();
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image, recruiting_token
                  WHERE recruiting_company_image.recruiting_company_id = recruiting_token.recruiting_company_id
                  AND recruiting_token.id = '$recruiting_token_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param string $long_id - long id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenLongId($long_id)
    {
        $return = array();
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image, recruiting_token
                  WHERE recruiting_company_image.recruiting_company_id = recruiting_token.recruiting_company_id
                  AND recruiting_token.long_id = '$long_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function gets information from the recruiting_company_image table
     *
     * @param int $id - company id of the company to get images for
     *
     * @return array - images associated with the company
     */
    public function getByCompanyId($id)
    {
        $return = array();
        $query = "SELECT recruiting_company_image.id, recruiting_company_image.file_name
                  FROM recruiting_company_image
                  WHERE recruiting_company_image.recruiting_company_id = '$id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function deletes the database entry & the image file
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;

        // Delete from file system
        $cwd = getcwd();
        $full_path = FILE_STORAGE_PATH.$this->file_name;
        if (file_exists($full_path)) {
            $success = unlink($full_path);
        }

        // Delete from database
        if (isset($this->id)) {
            // delete from db
            $sql = "DELETE FROM recruiting_company_image WHERE id = {$this->id}";
            execute($sql);
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key=>$value) {
                unset($this->$key);
            }
        }
        return $success;
    }
}
