<?php
namespace GiveToken;

class RecruitingTokenImage
{
    public $id;
    public $recruiting_token_id;
    public $file_name;

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
}
