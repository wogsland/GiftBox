<?php
namespace Sizzle\Database;

class Milestone extends \Sizzle\DatabaseEntity
{
    protected $name;
    protected $created;

    /**
     * This function constructs the class from a valid id or name.
     * Fails silently for invalid input.
     *
     * @param mixed $milestone - name or id of milestone
     */
    public function __construct($milestone)
    {
        $this->addReadOnly('created');
        // see if it's a name or id
        if ((int)$milestone > 0) {
            $query = "SELECT id, name, created
                      FROM milestone
                      WHERE id = '$milestone'";
        } else {
            $query = "SELECT id, name, created
                      FROM milestone
                      WHERE name = '$milestone'";
        }

        $result = execute_query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->created = $row['created'];
        }
    }
}
