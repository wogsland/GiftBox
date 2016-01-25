<?php
namespace Sizzle;

class RecruitingTokenResponse
{
    public $id;
    public $recruiting_token_id;
    public $email;
    public $created;

    /**
     * This function creates a resonse in the database
     *
     * @param int    $recruiting_token_id - long id of the token
     * @param string $email               - email address of respondent
     * @param string $response            - Yes, No or Maybe
     * @param string $cookie              - unique cookie for this visitor
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($recruiting_token_id, $email, $response, $cookie = '')
    {
        $id = 0;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)
            && in_array($response, array('Yes', 'No', 'Maybe'))
        ) {
            $result = execute_query(
                "SELECT id from recruiting_token
                WHERE long_id = '$recruiting_token_id'"
            );
            if ($row = $result->fetch_assoc()) {
                $recruiting_token_id = $row['id'];
                $id = insert(
                    "INSERT into recruiting_token_response
                    (`recruiting_token_id`, `email`, `response`, `visitor_cookie`)
                    VALUES ('$recruiting_token_id', '$email', '$response', '$cookie')"
                );
            }
        }
        return $id;
    }

    /**
     * This function gets the responses to a token or all user tokens
     *
     * @param int $user_id - id of the user
     * @param int $long_id - optional long id of the token
     *
     * @return array - responses
     */
    public function get($user_id, $long_id = '')
    {
        $responses = array();
        if (isset($user_id) && $user_id == (int) $user_id) {
            if ('' != $long_id) {
                $result = execute_query(
                    "SELECT id from recruiting_token
                    WHERE long_id = '$long_id'"
                );
                if ($row = $result->fetch_assoc()) {
                    $recruiting_token_id = $row['id'];
                } else {
                    return $responses;
                }
            }
            $query = "SELECT recruiting_token_response.id,
                      recruiting_token_response.`email`,
                      recruiting_token_response.`response`,
                      recruiting_token_response.`created`,
                      recruiting_token.job_title,
                      recruiting_token.long_id
                      FROM recruiting_token_response, recruiting_token
                      WHERE recruiting_token_response.recruiting_token_id = recruiting_token.id
                      AND recruiting_token.user_id = '$user_id' ";
            $query .= isset($recruiting_token_id) ? "AND recruiting_token.id = '$recruiting_token_id'" : '';
            $result = execute_query($query);
            while ($row = $result->fetch_assoc()) {
                $responses[] = $row;
            }
        }
        return $responses;
    }

}
