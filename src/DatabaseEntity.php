<?php
namespace GiveToken;

/**
 * This class implements basic database access functionality.
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/DatabaseEntityTest
 */
class DatabaseEntity
{
    use \GiveToken\Traits\CamelToUnderscore;

    protected $read_only = ['id'];
    public $id;

    /**
     * Constructs the class
     *
     * @param int $id - the id of the record to pull from the database
     */
    public function __construct($id = null)
    {
        if ($id !== null && strlen($id) > 0) {
            $sql = "SELECT * FROM {$this->tableName()} WHERE id = '$id'";
            $object = execute_query($sql)->fetch_object(get_class($this));
            if (isset($object)) {
                foreach (get_object_vars($object) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Returns the class name without the namespace as the table name
     */
    protected function tableName()
    {
        return $this->fromCamelCase(substr(get_class($this), strrpos(get_class(), '\\')+1));
    }

    /**
     * Appends to the list of read-only columns
     */
    protected function addReadOnly($column)
    {
        array_push($this->read_only, $column);
    }

    /**
     * Inserts into the database, setting $this->id
     */
    protected function insert()
    {
        $comma = null;
        $columns = null;
        $values = null;
        $sql = "INSERT INTO {$this->tableName()} (";
        foreach (get_object_vars($this) as $key => $value) {
            if ($key !== 'read_only' && !in_array($key, $this->read_only) && isset($value)) {
                $columns .= $comma.$key;
                $values .= $comma."'".escape_string($value)."'";
                $comma = ', ';
            }
        }
        $sql .= $columns.') VALUES (';
        $sql .= $values.')';
        $this->id = insert($sql);
    }

   /**
     * Updates the database using $this->id
     */
    protected function update()
    {
        $comma = null;
        $sql = "UPDATE {$this->tableName()} SET ";
        foreach (get_object_vars($this) as $key => $value) {
            if ($key !== 'read_only' && !in_array($key, $this->read_only)) {
                $sql .= $comma.$key." = ";
                if (strlen($value) > 0) {
                    $sql .= "'".escape_string($value)."'";
                } else {
                    $sql .= 'NULL';
                }
                $comma = ', ';
            }
        }
        $sql .= " WHERE id = '$this->id'";
        execute($sql);
    }

   /**
     * Deletes from the database using $this->id
     */
    public function delete()
    {
        $table_name = substr(get_class(), strrpos(get_class(), '\\')+1);
        $sql = "DELETE FROM {$this->tableName()} WHERE id = '$this->id'";
        execute($sql);
    }

   /**
     * Inserts into or updates the database
     */
    public function save()
    {
        if (!$this->id) {
            $this->insert();
        } else {
            $this->update();
        }
    }
}
