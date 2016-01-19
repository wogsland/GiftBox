<?php
namespace Sizzle\Tests;

use Sizzle\Route;

/**
 * This class tests the Route class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/tests/RouteTest
 */
class RouteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // instantiation check
        $route = new Route(array());
        $this->assertEquals('Sizzle\Route', get_class($route));
    }

    /**
     * Tests the go function.
     */
    public function testGo()
    {
        $this->markTestIncomplete();
        // need to rewrite this function to process registered routes
        // and write a function to register routes
        // as it is, RoutingTest hits it's functionality
    }
}
