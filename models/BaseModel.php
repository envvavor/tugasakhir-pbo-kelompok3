<?php

require_once '../config/Database.php';
require_once '../interfaces/CRUD.php';

class BaseModel implements CRUD {
    protected $connection;
    protected $table;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function create() {
        // Implement in derived classes
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        // Implement in derived classes
    }

    public function delete() {
        // Implement in derived classes
    }
}
?>