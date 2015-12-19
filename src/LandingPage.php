<?php
namespace GiveToken;

use \GiveToken\LandingPageView;

/**
 * This class is for database interaction with landing pages.
 */
class LandingPage
{
    protected $id;
    protected $script;
    protected $created;

    /**
     * This function constructs the class from a random landing page
     * the specified id.
     *
     * @param int $id - optional id of the landing_page
     */
    public function __construct($id = null)
    {
        if ($id !== null && (int) $id == $id) {
            $condition = "AND id = '$id'";
        } else {
            $condition = "ORDER BY RAND() LIMIT 1";
        }
        $page = execute_query(
            "SELECT * FROM landing_page
            WHERE deleted IS NULL
            $condition"
        )->fetch_object();
        if (is_object($page)) {
            foreach (get_object_vars($page) as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    /**
     * This function gets a protected property
     *
     * @param string $var - the class property desired
     *
     * @return mixed - the class property
     */
    public function __get($var)
    {
        if (isset($this->$var)) {
            return $this->$var;
        }
    }

    /**
     * This function checks if a protected property is set
     *
     * @param string $var - the class property to check
     *
     * @return bool - if the property is set
     */
    public function __isset($var)
    {
        return isset($this->$var);
    }

    /**
     * Records a hit on the landing page represented by this class
     *
     * @param string $visitor_cookie - cookie identifying the visitor
     *
     * @return boolean - success of recording
     */
    public function recordHit($visitor_cookie)
    {
        $LandingPageView = new LandingPageView();
        $LandingPageView->create($this->id, $visitor_cookie);
    }
}
