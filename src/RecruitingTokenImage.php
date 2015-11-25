<?php
namespace GiveToken;

class RecruitingTokenImage
{
    protected $id;
    protected $recruiting_token_id;
    protected $file_name;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the city to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $result = execute_query(
                "SELECT * from recruiting_token_image
                WHERE id = '$id'"
            )->fetch_object("GiveToken\RecruitingTokenImage");
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
     * This function creates an entry in the recruiting_token_image table
     *
     * @param int $recruiting_token_id - id of the token
     * @param string $file_name  - name of image file
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_token_id, $file_name)
    {
        $query = "INSERT INTO recruiting_token_image (recruiting_token_id, file_name)
                  VALUES ('$recruiting_token_id', '$file_name')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->recruiting_token_id = $recruiting_token_id;
            $this->file_name = $file_name;
        }
        return $id;
    }

    /**
     * This function gets information from the recruiting_token_image table
     *
     * @param int $recruiting_token_id - id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenId($recruiting_token_id)
    {
        $return = array();
        $query = "SELECT id, file_name FROM recruiting_token_image
                  WHERE recruiting_token_id = '$recruiting_token_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
    }

    /**
     * This function gets information from the recruiting_token_image table
     *
     * @param int $long_id - long id of the token to get images for
     *
     * @return array - images associated with the token
     */
    public function getByRecruitingTokenLongId($long_id)
    {
        $return = array();
        $query = "SELECT recruiting_token_image.id, recruiting_token_image.file_name
                  FROM recruiting_token_image, recruiting_token
                  WHERE recruiting_token_image.recruiting_token_id = recruiting_token.id
                  AND recruiting_token.long_id = '$long_id'";
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
        if (isset($this->id)) {
            // delete from db
            $sql = "DELETE FROM recruiting_token_image WHERE id = {$this->id}";
            execute($sql);
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key=>$value) {
                unset($this->$key);
            }

            // delete from filesystem
            // TBD

            $success = true;
        }
        return $success;
    }
}
