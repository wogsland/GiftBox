<?php
namespace Sizzle\Database;

/**
 * This class is for database interaction with the recruiting_token_image table.
 */
class RecruitingTokenImage extends \Sizzle\DatabaseEntity
{
    protected $file_name;
    protected $recruiting_token_id;
    protected $created;

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
