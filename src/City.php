<?php
namespace GiveToken;

class City
{
    public $id;
    public $name;
    public $image_file;
    public $population;
    public $longitude;
    public $latitude;
    public $county;
    public $country;
    public $timezone;
    public $temp_hi_spring;
    public $temp_lo_spring;
    public $temp_avg_spring;
    public $temp_hi_summer;
    public $temp_lo_summer;
    public $temp_avg_summer;
    public $temp_hi_fall;
    public $temp_lo_fall;
    public $temp_avg_fall;
    public $temp_hi_winter;
    public $temp_lo_winter;
    public $temp_avg_winter;
    public $created;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the city to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $city = execute_query(
                "SELECT * from city
                WHERE id = '$id'"
            )->fetch_object("GiveToken\City");
            if (isset($city)) {
                foreach (get_object_vars($city) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Gets all the cities sorted by name
     */
    public static function getAll() {
		$cities = array();
        $results = execute_query("SELECT * FROM city ORDER BY name");
		if ($results) {
			while($object = $results->fetch_object()) {
				$cities[count($cities)] = $object;
			}
			$results->free();
			return $cities;
        }
	}

    /**
     * Gets the city id given the city name
     *
     * @param string $name - the name of the city to pull from the database
     */
    public static function getIdFromName($name) {
        $id = execute_query("SELECT id FROM city WHERE name = '$name'")->fetch_object()->id;
        return $id;
    }

}
