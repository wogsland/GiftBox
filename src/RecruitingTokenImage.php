<?php
namespace Sizzle;

/**
 * This class is for database interaction with the recruiting_token_image table.
 */
class RecruitingTokenImage
{
    protected $id;
    protected $file_name;
    protected $recruiting_token_id;
    protected $created;

    /**
     * This function constructs the class
     *
     * @param mixed  $value - optional id or name of the email list
     * @param string $key   - if $value is id or name
     */
    public function __construct($value = null, $key = 'id')
    {
        if ($value !== null) {
            if ($key == 'id' && (int) $value == $value) {
                $token = execute_query(
                    "SELECT * FROM recruiting_token_image
                    WHERE id = '$value'"
                )->fetch_object("Sizzle\RecruitingTokenImage");
            }
            if (isset($token) && is_object($token)) {
                foreach (get_object_vars($token) as $key => $value) {
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
     * @param string $file_name           - name of image file
     * @param int    $recruiting_token_id - recruiting token id
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($file_name, $recruiting_token_id)
    {
        $query = "INSERT INTO recruiting_token_image (file_name, recruiting_token_id)
                 VALUES ('$file_name', '$recruiting_token_id')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->file_name = $file_name;
            $this->recruiting_token_id = $recruiting_token_id;
        }
        return $id;
    }

    /**
     * This function gets the images for a given token
     *
     * @param int $recruiting_token_id - recruiting token id
     *
     * @return array - image(s) information
     */
    public function getByRecruitingTokenId($recruiting_token_id)
    {
        $query = "SELECT * FROM recruiting_token_image
                 WHERE recruiting_token_id = '$recruiting_token_id'";
        return execute_query($query)->fetch_all(MYSQLI_ASSOC);
    }
}
