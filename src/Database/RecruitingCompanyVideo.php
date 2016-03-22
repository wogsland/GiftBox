<?php
namespace Sizzle\Database;

class RecruitingCompanyVideo extends \Sizzle\DatabaseEntity
{
    protected $recruiting_company_id;
    protected $source;
    protected $source_id;
    protected $created;

    /**
     * This function creates an entry in the recruiting_company_video table
     *
     * @param int    $recruiting_company_id - id of the token
     * @param string $source                - youtube or vimeo
     * @param string $source_id             - video id from their site
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
     * This function gets information from the recruiting_company_video table
     *
     * @param int $id - company id of the company to get videos for
     *
     * @return array - videos associated with the company
     */
    public function getByCompanyId($id)
    {
        $return = array();
        $query = "SELECT recruiting_company_video.id,
                  recruiting_company_video.source,
                  recruiting_company_video.source_id
                  FROM recruiting_company_video
                  WHERE recruiting_company_video.recruiting_company_id = '$id'";
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
