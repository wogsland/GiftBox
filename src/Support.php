<?php
namespace Sizzle;

/**
 * This class is for database interaction with sent support email.
 */
class Support
{
  public $id;
  public $email_address;
  public $message;
  public $created;

  /**
   * This function constructs the class and saves a receipt of the sent support mail.
   *
   * @param string $email_address - email address of customer
   * @param string $message - support message from customer
   */
  public function __construct($email_address, $message)
  {
    $this->email_address = $email_address;
    $this->message = $message;

    $sql = "INSERT INTO `giftbox`.`support`
                    (`email_address`, `message`)
                    VALUES ('$this->email_address', '$this->message')";
    $this->id = insert($sql);
  }

}
