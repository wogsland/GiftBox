<?php
namespace GiveToken;

class RecruitingTokenImage
{
    public $id;
    public $recruiting_token_id;
    public $image_file_name;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the city to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $user = execute_query(
                "SELECT * from recruiting_token_image
                WHERE id = '$id'"
            )->fetch_object("GiveToken\RecruitingTokenImage");
            foreach (get_object_vars($user) as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}
