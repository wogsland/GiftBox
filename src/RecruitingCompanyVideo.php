<?php
namespace GiveToken;

class RecruitingCompanyVideo
{
    protected $id;
    protected $recruiting_company_id;
    protected $source;
    protected $source_id;
    protected $created;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the city to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $result = execute_query(
                "SELECT * from recruiting_company_video
                WHERE id = '$id'"
            )->fetch_object("GiveToken\RecruitingCompanyVideo");
            if (isset($result)) {
                foreach (get_object_vars($result) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    public static function getTokenVideos($recruiting_token_id)
    {
        $results =  execute_query(
            "SELECT recruiting_company_video.id, recruiting_company_video.`source`, recruiting_company_video.source_id
            FROM recruiting_company_video, recruiting_token
            WHERE recruiting_token.id = $recruiting_token_id
            AND recruiting_company_video.recruiting_company_id =  recruiting_token.recruiting_company_id");
        $token_videos = array();
        while($token_video = $results->fetch_object()) {
            $token_videos[count($token_videos)] = $token_video;
        }
        $results->free();
        return $token_videos;
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
     * This function creates an entry in the recruiting_company_video table
     *
     * @param int    $recruiting_company_id - id of the token
     * @param string $source              - youtube or vimeo
     * @param string $source_id           - video id from their site
     *
     * @return int - id of inserted row or 0 on fail
     */
    public function create($recruiting_company_id, $source, $source_id)
    {
        $query = "INSERT INTO recruiting_company_video (recruiting_company_id, source, source_id)
                  VALUES ('$recruiting_company_id', '$source', '$source_id')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->recruiting_company_id = $recruiting_company_id;
            $this->source = $source;
            $this->source_id = $source_id;
        }
        return $id;
    }

    /**
     * This function gets information from the recruiting_company_video table
     *
     * @param int $long_id - long id of the token to get images for
     *
     * @return array - videos associated with the token
     */
    public function getByRecruitingTokenLongId($long_id)
    {
        $return = array();
        $query = "SELECT recruiting_company_video.id,
                  recruiting_company_video.source,
                  recruiting_company_video.source_id
                  FROM recruiting_company_video, recruiting_token
                  WHERE recruiting_company_video.recruiting_company_id = recruiting_token.recruiting_company_id
                  AND recruiting_token.long_id = '$long_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row;
        }
        return $return;
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
            $sql = "DELETE FROM recruiting_company_video WHERE id = {$this->id}";
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
