<?php

require_once '../models/BaseModel.php';

class Assignment extends BaseModel {
    protected $table = "assignments";

    public $id;
    public $subject_id;
    public $title;
    public $description;
    public $due_date;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " SET subject_id=:subject_id, title=:title, description=:description, due_date=:due_date";
        $stmt = $this->connection->prepare($query);

        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));

        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":due_date", $this->due_date);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " SET subject_id=:subject_id, title=:title, description=:description, due_date=:due_date WHERE id=:id";
        $stmt = $this->connection->prepare($query);

        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->due_date = htmlspecialchars(strip_tags($this->due_date));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":due_date", $this->due_date);
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

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->connection->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->subject_id = $row['subject_id'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->due_date = $row['due_date'];
            return true;
        }

        return false;
    }
}
?>