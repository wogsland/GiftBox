<?php
namespace GiveToken;

/**
 * This class implements basic database access functionality.
 */
class DatabaseEntity
implements \JsonSerializable
{
    use \GiveToken\Traits\CamelToUnderscore;

    protected $id;
    protected $readOnly = ['id','readOnly'];

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
     * This function gets a protected property
     *
     * @param string $property - the class property desired
     *
     * @return mixed - the class property
     */
    public function __get($property)
    {
        if (isset($this->$property)) {
            return $this->$property;
        }
    }

    /**
     * This function sets a protected property if it's not read only
     *
     * @param string $property - the class property to set
     * @param mixed  $value    - the value to set the property to
     */
    public function __set($property, $value)
    {
        if (!in_array($property, $this->readOnly)) {
            $this->$property = $value;
        }
    }

    /**
     * This function checks if a protected property is set
     *
     * @param string $property - the class property to check
     *
     * @return bool - if the property is set
     */
    public function __isset($property)
    {
        return isset($this->$property);
    }

    /**
     * Returns the class name without the namespace as the table name
     */
    protected function tableName()
    {
        return $this->fromCamelCase(substr(get_class($this), strrpos(get_class(), '\\')+1));
    }

    /**
     * Appends to the list of read only columns
     */
    protected function addReadOnly($column)
    {
        array_push($this->readOnly, $column);
    }

    /**
     * Inserts into the database, setting $this->id
     */
    protected function insert()
    {
        $comma = '';
        $columns = '';
        $values = '';
        foreach (get_object_vars($this) as $key => $value) {
            if ($key !== 'readOnly' && !in_array($key, $this->readOnly) && isset($value)) {
                $columns .= $comma.$key;
                $values .= $comma."'".escape_string($value)."'";
                $comma = ', ';
            }
        }
        $sql = "INSERT INTO {$this->tableName()} ($columns) VALUES ($values)";
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
            if ($key !== 'readOnly' && !in_array($key, $this->readOnly)) {
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

    /**
     * Specifies json_encode behavior with magic methods
     */
    public function jsonSerialize()
    {
        return (object) get_object_vars($this);
    }
}