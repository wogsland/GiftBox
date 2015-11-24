<?php
namespace GiveToken;

class RecruitingTokenImage
{
    protected $id;
    protected $recruiting_token_id;
    protected $image_file_name;

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

    public static function getTokenImages($recruiting_token_id) {
        $results =  execute_query("SELECT * FROM recruiting_token_image where recruiting_token_id = $recruiting_token_id");
        $token_images = array();
        while($token_image = $results->fetch_object()) {
            $token_images[count($token_images)] = $token_image;
        }
        $results->free();
        return $token_images;
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
     * @param string $image_file_name  - name of image file
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_token_id, $image_file_name)
    {
        $query = "INSERT INTO recruiting_token_image (recruiting_token_id, image_file_name)
                  VALUES ('$recruiting_token_id', '$image_file_name')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->recruiting_token_id = $recruiting_token_id;
            $this->image_file_name = $image_file_name;
        }
        return $id;
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
        $full_path = FILE_STORAGE_PATH.$this->image_file_name;
        $success = unlink($full_path);

        // Delete from database
        if ($success) {
            if (isset($this->id)) {
                // delete from db
                $sql = "DELETE FROM recruiting_token_image WHERE id = {$this->id}";
                execute($sql);
                $vars = get_class_vars(get_class($this));
                foreach ($vars as $key=>$value) {
                    unset($this->$key);
                }
            }
        }
        return $success;
    }
}
