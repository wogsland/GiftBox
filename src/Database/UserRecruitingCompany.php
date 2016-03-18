<?php
namespace Sizzle\Database;

class UserRecruitingCompany extends \Sizzle\DatabaseEntity
{
    protected $user_id;
    protected $recruiting_company_id;
    protected $permissions;
    protected $created;

    /**
     * This function constructs the class from an $id
     *
     * @param int $id - id of the user_recruiting_company link
     */
    public function __construct($id)
    {
    }

    /**
     * Creates a relationship between a user and a company and sets the class
     * properties
     *
     * @param int $user_id - id of the user
     * @param int $recruiting_company_id - id of the recruiting_company
     * @param string $permissions - (optional) Owner, Edit, or Read Only
     *
     * @return mixed - false if fail or id if success
     */
    public static function create($user_id, $recruiting_company_id, $permissions = 'Read Only')
    {

    }

    /**
     * Updates permissions user has on a company
     *
     * @param string $permissions - Owner, Edit, or Read Only
     *
     * @return boolean - success of update
     */
    public static function updatePermissions($permissions)
    {

    }

    /**
     * Deletes a relationship between a user and a company
     *
     * @return boolean - success of deletion
     */
    public static function delete()
    {

    }
}
