<?php
namespace Sizzle\Database;

class WebRequest extends \Sizzle\DatabaseEntity
{
    protected $visitor_cookie;
    protected $user_id;
    protected $host;
    protected $user_agent;
    protected $uri;
    protected $remote_ip;
    protected $script;


    /**
     * Is this a new visitor?
     *
     * @param string $visitor_cookie - the visitor cookie from the user's browser
     *
     * @return boolean - is it?
     */
    public function newVisitor($visitor_cookie)
    {
        $visitor_cookie = escape_string($visitor_cookie);
        $sql = "SELECT COUNT(*) requests FROM web_request
                WHERE visitor_cookie = '$visitor_cookie'";
        $result = execute_query($sql);
        if (($row = $result->fetch_assoc()) && $row['requests'] > 3) {
            return false;
        } else {
            return true;
        }
    }
}
