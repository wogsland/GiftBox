<?php
namespace GiveToken;

class RecruitingTokenResponse
{
    public $id;
    public $recruiting_token_id;
    public $email;
    public $created;

    /**
     * This function constructs the class
     *
     * @param int $recruiting_token_id - long id of the token
     * @param string $email - email address of respondent
     * @param string $response - Yes, No or Maybe
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_token_id, $email, $response)
    {
        $id = 0;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)
        && in_array($response, array('Yes', 'No', 'Maybe'))) {
            $result = execute_query("SELECT id from recruiting_token
                WHERE long_id = '$recruiting_token_id'");
            if ($row = $result->fetch_assoc()) {
                $recruiting_token_id = $row['id'];
                $id = insert("INSERT into recruiting_token_response
                    (`recruiting_token_id`, `email`, `response`)
                    VALUES ('$recruiting_token_id', '$email', '$response')");
            }
        }
        return $id;
    }

}
