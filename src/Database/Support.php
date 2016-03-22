<?php
namespace Sizzle\Database;

/**
 * This class is for database interaction with sent support email.
 */
class Support extends \Sizzle\DatabaseEntity
{
    protected $email_address;
    protected $message;
    protected $created;

    /**
     * Saves a receipt of the sent support mail..
     *
     * @param $email_address
     * @param $message
     */
    public static function create($email_address, $message)
    {
        $Support = new Support();
        $Support->email_address = $email_address;
        $Support->message = $message;

        $sql = "INSERT INTO `giftbox`.`support` (`email_address`, `message`)
                VALUES ('$Support->email_address', '$Support->message')";
        $Support->id = insert($sql);
        return $Support;
    }
}
