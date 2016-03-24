<?php
namespace Sizzle\Tests\Traits;

use Sizzle\Database\Organization;

/**
 * Functions to create & tear down test Organizations
 */
trait Organization
{
    protected $organizations = array();

    /**
     * Create a organization for testing
     *
     * @return Organization - the new organization
     */
    protected function createOrganization()
    {
        // create an organization for testing
        $organization = new Organization();
        $organization->name = 'The '.rand().' Corporation';
        $organization->website = 'http://www.'.rand().'.org';
        $organization->save();
        $this->$organizations[] = $organization->id;
        return $organization;
    }

    /**
     * Deletes Organizations created for testing
     */
    protected function deleteOrganizations()
    {
        foreach($this->$organizations as $id) {
            $sql = "DELETE FROM organization WHERE id = '$id'";
            execute($sql);
        }
    }
}
