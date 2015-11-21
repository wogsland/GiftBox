<?php
namespace GiveToken;

class RecruitingTokenVideo
{
    protected $id;
    protected $recruiting_token_id;
    protected $url;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the city to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $result = execute_query(
                "SELECT * from recruiting_token_video
                WHERE id = '$id'"
            )->fetch_object("GiveToken\RecruitingTokenVideo");
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
     * This function creates an entry in the recruiting_token_video table
     *
     * @param int $recruiting_token_id - id of the token
     * @param string $url  - url of video file
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_token_id, $url)
    {
        $query = "INSERT INTO recruiting_token_video (recruiting_token_id, url)
                  VALUES ('$recruiting_token_id', '$url')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->recruiting_token_id = $recruiting_token_id;
            $this->url = $url;
        }
        return $id;
    }

    /**
     * This function deletes the database entry
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;
        if (isset($this->id)) {
            $sql = "DELETE FROM recruiting_token_video WHERE id = {$this->id}";
            execute($sql);
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key=>$value) {
                unset($this->$key);
            }
            $success = true;
        }
        return $success;
    }
}
