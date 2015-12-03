<?php
namespace GiveToken\Tests;

use GiveToken\DatabaseEntity;
/**
 * This class tests the DatabaseEntity class
 *
 * phpunit --bootstrap src/tests/autoload.php src/tests/DatabaseEntityTest
 */
class DatabaseEntityTest extends \PHPUnit_Framework_TestCase
{
    private $existing_entity_id;
    private $inserted_entity;
    /**
     * Requires the util.php file of functions
     */
    public static function setUpBeforeClass()
    {
        include_once __DIR__.'/../../util.php';
    }

    protected function setUp()
    {
        $sql = "CREATE TABLE databaseentity ("
            . "id   INT(11) NOT NULL AUTO_INCREMENT,"
            . "name VARCHAR(100) NOT NULL,"
            . "PRIMARY KEY (id),"
            . "INDEX id_idx (id ASC)"
            . ")";
        execute($sql);

        $sql = "INSERT into databaseentity (name) VALUES ('test name')";
        $this->existing_entity_id = insert($sql);
    }

    /**
     * Tests the __construct function.
     */
    public function testConstructor()
    {
        // $id = null case
        $result = new DatabaseEntity();
        $this->assertEquals('GiveToken\DatabaseEntity', get_class($result));
        $this->assertFalse(isset($result->id));
        $this->assertFalse(isset($result->name));

        // $id specified case
        $entity = new DatabaseEntity($this->existing_entity_id);
        $this->assertEquals($this->existing_entity_id, $entity->id);
        $this->assertEquals('test name', $entity->name);
    }

    /**
     * Tests the save function when save inserts a new record
     */
    public function testSaveInsert()
    {
        // test save when inserting a new record
        $entity = new DatabaseEntity();
        $entity->name = 'test name';

        // id should be null before save
        $this->assertNull($entity->id);
        $entity->save();

        // id should be populated after save
        $this->assertGreaterThan(0, $entity->id);

        // make sure all properties were inserted correctly
        $saved_entity = new DatabaseEntity($entity->id);
        $this->assertEquals($entity->name, $saved_entity->name);

        // delete the inserted entity
        $saved_entity->delete();
    }

    /**
     * Tests the save function when save updates and existing record
     */
    public function testSaveUpdate()
    {
        // test save when updating an existing record
        $entity = new DatabaseEntity($this->existing_entity_id);
        $this->assertEquals('test name', $entity->name);
        $entity->name = 'new name';
        $entity->save();
        $entity = new DatabaseEntity($this->existing_entity_id);
        $this->assertEquals('new name', $entity->name);
    }

    /**
     * Tests the delete function
     */
    public function testDelete()
    {
        $entity = new DatabaseEntity($this->existing_entity_id);
        $this->assertEquals($this->existing_entity_id, $entity->id);
        $entity->delete();
        $entity = new DatabaseEntity($this->existing_entity_id);
        $this->assertNull($entity->id);
    }

    protected function tearDown()
    {
        $sql = "DROP TABLE databaseentity";
        execute($sql);
    }
}
