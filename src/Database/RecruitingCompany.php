<?php
namespace Sizzle\Database;

/**
 * This class is for interacting with the recruiting_company table.
 */
class RecruitingCompany extends \Sizzle\DatabaseEntity
{
    protected $user_id;
    protected $name;
    protected $description;
    protected $logo;
    protected $website;
    protected $values;
    protected $facebook;
    protected $linkedin;
    protected $youtube;
    protected $twitter;
    protected $google_plus;
    protected $pinterest;

    /**
     * Gets all the companies
     *
     * @return array - an array of names & ids of companies
     */
    public function getAll()
    {
        return  execute_query("SELECT recruiting_company.id,
          CONCAT(recruiting_company.`name`, ' (',  COALESCE(organization.`name`, 'No organization'), ')') AS `name`
          FROM recruiting_company, user
          LEFT JOIN organization ON user.organization_id = organization.id
          WHERE recruiting_company.user_id = user.id
          ORDER BY `name`"
        )->fetch_all(MYSQLI_ASSOC);
    }
}
