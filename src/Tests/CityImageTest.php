<?php
namespace Sizzle\Tests;

use Sizzle\City;
use Sizzle\CityImage;

/**
 * This class tests the City class
 *
 * ./vendor/bin/phpunit --bootstrap src/tests/autoload.php src/tests/CityImageTest
 */
class CityImageTest extends \PHPUnit_Framework_TestCase
{
  protected $existing_city_with_images;
  protected $existing_city_with_no_images;
  protected $nonexisting_city;

  /**
   * Requires the util.php file of functions
   */
  public static function setUpBeforeClass()
  {
    include_once __DIR__.'/../../util.php';
  }

  private function generateCity()
  {
    // create a city for testing
    $city = new City();
    $city->name = "Test City";
    $city->population = rand(10000, 10000000);
    $city->longitude = rand(0, 100);
    $city->latitude = rand(0, 100);
    $city->county = "County " . rand(0, 100);
    $city->country = "CT";
    $city->timezone = "Awesome Standard Time";
    $city->temp_hi_spring = rand(0, 100);
    $city->temp_lo_spring = rand(0, 100);
    $city->temp_avg_spring = rand(0, 100);
    $city->temp_hi_summer = rand(0, 100);
    $city->temp_lo_summer = rand(0, 100);
    $city->temp_avg_summer = rand(0, 100);
    $city->temp_hi_fall = rand(0, 100);
    $city->temp_lo_fall = rand(0, 100);
    $city->temp_avg_fall = rand(0, 100);
    $city->temp_hi_winter = rand(0, 100);
    $city->temp_lo_winter = rand(0, 100);
    $city->temp_avg_winter = rand(0, 100);
    return $city;
  }

  protected function setUp()
  {
    // grab existing city with images
    // This is fragile, needs to be updated once the database is imported
    $this->existing_city_with_images = new City(51975);

    // create new city
    $this->nonexisting_city = $this->generateCity();
  }

  public function testGetAllImagesForCity()
  {
    $imagesForCityWithImages = CityImage::getAllImageUrlsForCity($this->existing_city_with_images->id);
    $this->assertEquals(4, count($imagesForCityWithImages));

    $imagesForCityWithNoImages = CityImage::getAllImageUrlsForCity(99999);
    $this->assertEquals(0, count($imagesForCityWithNoImages));
  }
}
