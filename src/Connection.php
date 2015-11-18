<?php
namespace GiveToken;

class Connection
{
    public static $mysqli;

    /**
     * Creates a database connection if parameters defined
     */
    public function __construct($mysqli = null)
    {
        if (isset($mysqli)) {
            self::$mysqli = $mysqli;
        } elseif (defined('MYSQL_HOST') && defined('MYSQL_USER')
        && defined('MYSQL_PASSWORD') && defined('MYSQL_DB')) {
            self::$mysqli = new \mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
        }
    }
}
