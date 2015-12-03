<?php
namespace GiveToken;

class City extends DatabaseEntity
{
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
     * Overrides DatabaseEntity::__construct() to set created as read-only
     * after calling parent::__construct()
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->addReadOnly('created');
    }
    
    /**
     * Overrides DatabaseEntity::insert() to get the created date
     * after calling parent::insert()
     */
    protected function insert()
    {
        parent::insert();
        $sql = "SELECT created FROM {$this->tableName()} WHERE id = $this->id";
        $this->created = execute_query($sql)->fetch_object()->created;
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
        $sql = "SELECT id FROM city WHERE name = '$name'";
        $id = execute_query($sql)->fetch_object()->id;
        return $id;
    }

}
