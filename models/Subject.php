<?php

require_once '../models/BaseModel.php';

class Subject extends BaseModel {
    protected $table = "subjects";

    public $id;
    public $class_id;
    public $name;
    public $description;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET class_id=:class_id, name=:name, description=:description";
        $stmt = $this->connection->prepare($query);

        $this->class_id = htmlspecialchars(strip_tags($this->class_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET class_id=:class_id, name=:name, description=:description WHERE id=:id";
        $stmt = $this->connection->prepare($query);

        $this->class_id = htmlspecialchars(strip_tags($this->class_id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":class_id", $this->class_id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id=:id";
        $stmt = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>