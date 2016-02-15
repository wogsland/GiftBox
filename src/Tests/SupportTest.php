<?php
namespace Sizzle\Tests;

use \Sizzle\{
  Support
};

/**
 * This class tests the Support classes
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/SupportTest
 */
class SupportTest extends \PHPUnit_Framework_TestCase
{
  /**
   * Requires the util.php file of functions
   */

  protected $id;
  public static function setUpBeforeClass()
  {
    include_once __DIR__.'/../../util.php';
  }

  /**
   * Tests the __construct function.
   */
  public function testCreate()
  {
    $Support = Support::create("fakeEmail@gosizzle.io", "This is also a fake message");
    $this->assertEquals('Sizzle\Support', get_class($Support));
    $this->assertTrue(isset($Support->id));
    $this->assertEquals("fakeEmail@gosizzle.io", $Support->email_address);
    $this->assertEquals("This is also a fake message", $Support->message);
    $this->id = $Support->id;
  }

  /**
   * Destroys the test data.
   */
  protected function tearDown()
  {
    $query = "DELETE FROM support WHERE id = '{$this->id}'";
    execute($query);
  }
}
