<?php
namespace Sizzle;

class CityImage extends DatabaseEntity
{
  protected $city_id;
  protected $image_file;
  protected $created;

  /**
   * Overrides DatabaseEntity::__construct() to set created as read-only
   * after calling parent::__construct()
   */
  public function __construct($id = null)
  {
    parent::__construct($id);
    $this->addReadOnly('created');
  }

  /**
   * Gets all the images for a city sorted by filename
   *
   * @return array(success - did the query succeed, data - image urls) -
   */
  public static function getAllImageUrlsForCity($city_id)
  {
    $imageUrls = array();
    $results = execute_query("SELECT * FROM city_image WHERE city_id='$city_id' ORDER BY image_file");
    if ($results) {
      while ($object = $results->fetch_object()) {
        $imageUrls[count($imageUrls)] = $object;
      }
      $results->free();
    }
    return $imageUrls;
  }
}
