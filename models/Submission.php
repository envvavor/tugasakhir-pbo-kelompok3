<?php

require_once '../config/Database.php';
require_once '../interfaces/CRUD.php';

class Submission implements CRUD {
    private $connection;
    private $table = "submissions";

    public $id;
    public $assignment_id;
    public $user_id;
    public $submission_date;
    public $content;

    public function __construct($db) {
        $this->connection = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET assignment_id=:assignment_id, user_id=:user_id, submission_date=:submission_date, content=:content";
        $stmt = $this->connection->prepare($query);

        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->submission_date = htmlspecialchars(strip_tags($this->submission_date));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(":assignment_id", $this->assignment_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":submission_date", $this->submission_date);
        $stmt->bindParam(":content", $this->content);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET assignment_id=:assignment_id, user_id=:user_id, submission_date=:submission_date, content=:content WHERE id=:id";
        $stmt = $this->connection->prepare($query);

        $this->assignment_id = htmlspecialchars(strip_tags($this->assignment_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->submission_date = htmlspecialchars(strip_tags($this->submission_date));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":assignment_id", $this->assignment_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":submission_date", $this->submission_date);
        $stmt->bindParam(":content", $this->content);
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