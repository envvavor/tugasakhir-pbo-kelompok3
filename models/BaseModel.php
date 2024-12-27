<?php

require_once '../config/Database.php';
require_once '../interfaces/CRUD.php';

abstract class BaseModel implements CRUD {
    protected $connection;
    protected $table;

    public function __construct($db) {
        $this->connection = $db;
    }

    // Abstract methods to be implemented in derived classes
    abstract public function create();
    abstract public function update();
    abstract public function delete();

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>