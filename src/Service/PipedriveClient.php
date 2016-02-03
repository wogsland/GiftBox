<?php
namespace Sizzle\Service;

use Devio\Pipedrive\Pipedrive;
use Devio\Pipedrive\Exceptions\PipedriveException;

/**
 * This class is for sending mail messages through Pipedrive
 */
class PipedriveClient
{

    protected $pipedrive;

    function __construct($api_key)
    {
        $this->pipedrive = new Pipedrive($api_key);
    }

    /**
     * Makes a dummy request to the Pipedrive API to verify
     * that the API Key successfully authorizes requests
     *
     * @return boolean - api key is authorized
     */
    public function isAuthorized()
    {
        try {
            $this->pipedrive->globalMessages->all();
            return true;
        } catch (PipedriveException $exception) {
            // This may be a fragile way to verify authentication error.
            $PIPEDRIVE_AUTH_ERROR_MESSAGE = "You need to be authorized to make this request.";
            if ($PIPEDRIVE_AUTH_ERROR_MESSAGE === $exception->getMessage()) {
                return false;
            }

            throw new \Exception("(Possibly) Broken Error Check. Auth Error message '".$exception->getMessage() +"'");
        }
    }

    /**
     * Find's a Person in Pipedrive or creates them.
     *
     * @param array $newSignup - associative array of a new signup's information
     * @return array[0,1] - 0 = Person data, 1 = true if created, false if found
     * @throws Exception - Pipedrive errors
     */
    private function findOrCreatePerson($newSignup)
    {
        $findPersonResponse = $this->pipedrive->persons()->findByName($newSignup['email_address'], ["search_by_email" => true]);
        $foundPerson = $findPersonResponse->getData()[0];
        if (!$findPersonResponse->isSuccess()) {
            throw new \Exception("Pipedrive request failed: ".$findPersonResponse->error);
        } else if (is_null($foundPerson)) {
            // No Person found in Pipedrive. Create Person and return Person data
            // TODO
        } else {
            // Person found in Pipedrive, return Person data
            return array($foundPerson, false);
        }
    }

    private function createOrganizationAndUpdatePerson($person)
    {
        // TODO
    }

    /**
     * Creates or finds a Deal associated with a Person. We only want to create a Deal
     * if the Person was created and to find a Dael if the Person was found. All other
     * flows are undefined behavior.
     *
     * @param mixed $person - Person data from Pipeline
     * @param boolean $personWasCreated - true if the $person was created in this flow, else false
     * @return mixed - deal associated with $person
     * @throws \Exception - Pipedrive errors
     */
    private function createOrFindDeal($person, $personWasCreated)
    {
        $personsDealsResponse = $this->pipedrive->persons()->deals($person->id);
        $foundDeals = $personsDealsResponse->getData();
        $ideaStageId = 1; // This is the sale pipeline idea stage id
        $retVal = null;
        if (!$personsDealsResponse->isSuccess()) {
            throw new \Exception("Pipedrive request failed: ".$personsDealsResponse->getContent()->error);
        } else if (count($foundDeals) == 0) {
            // No deal was found in Pipedrive. If the person was just created
            // we should create the Deal and return Deal data. Otherwise,
            // a person should have an existing deal and so this is undefined
            // behavior
            if (!$personWasCreated) {
                throw new \Exception("Undefined behavior. An existing person should have an existing deal.");
            }
            // TODO
        } else {
            // Deal found. Assume first/only deal is associated deal
            $retVal = $foundDeals[0];
        }
        return $retVal;
    }

    /**
     * Updates an Organization's status in Pipedrive to "FreeTrial"
     *
     * @param string $organizationId - the Organization's id in Pipedrive
     * @throws \Exception - Pipedrive errors
     */
    private function setOrganizationStatusToFreeTrial($organizationId)
    {
        // "6a06247b91272ae63df08657bd3fe5e716a7f519" == status
        $updateData = array("6a06247b91272ae63df08657bd3fe5e716a7f519" => "FreeTrial");
        $response = $this->pipedrive->organizations()->update($organizationId, $updateData);
        if (!$response->isSuccess()) {
            // Pipedrive failed
            throw new \Exception("Pipedrive request failed: ".$response->getContent()->error);
        }
    }

    /**
     * Takes a new signup payload and sets up a FreeTrial status in Pipedrive.
     *
     * @param mixed $newSignup - (email_address => ..., first_name => ..., last_name => ...)
     * @return bool - success
     */
    public function createFreeTrial($newSignup)
    {
        try {
            list($person, $personWasCreated) = $this->findOrCreatePerson($newSignup);
            $personHasAssociatedOrganization = array_key_exists('org_id', $person);
            $shouldCreateOrganization = $personWasCreated || !$personHasAssociatedOrganization;
            if ($shouldCreateOrganization) {
                // Create Organization and link to Person
                $organizationId = $this->createOrganizationAndUpdatePerson($person);
            } else {
                $organizationId = $person->org_id;
            }
            $this->createOrFindDeal($person, $personWasCreated);
            $this->setOrganizationStatusToFreeTrial($organizationId);
            return true;
        } catch (\Exception $e) {
            // There was a problem with the Pipedrive API
            return false;
        }
    }
}
