<?php
namespace Sizzle\Database;

/**
 * This class is for database interaction with email_open.
 */
class EmailOpen extends \Sizzle\DatabaseEntity
{
    protected $email_template_id;
    protected $email_address;
    protected $recruiting_token_id;
    protected $created;

    /**
     * This function creates an entry in the email_open table
     *
     * @param int    $template - id of the email template
     * @param string $email    - email recipient that opened the email
     * @param int    $token    - (optional) recruiting token id
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($template, $email, $token = null)
    {
        $query = isset($token) ?
                "INSERT INTO email_open (email_template_id, email_address, recruiting_token_id)
                 VALUES ('$template', '$email', '$token')"
                :
                "INSERT INTO email_open (email_template_id, email_address)
                 VALUES ('$template', '$email')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->email_template_id = $template;
            $this->email_address = $email;
            $this->recruiting_token_id = $token;
        }
        return $id;
    }

}
