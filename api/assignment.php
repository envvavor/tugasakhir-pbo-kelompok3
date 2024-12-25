<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/Assignment.php';

$database = new Database();
$db = $database->getConnection();

$assignment = new Assignment($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $assignment->subject_id = $data->subject_id;
        $assignment->title = $data->title;
        $assignment->description = $data->description;
        $assignment->due_date = $data->due_date;
        if ($assignment->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Assignment was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create assignment."]);
        }
        break;
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($assignment->findById($id)) {
                $assignment_arr = array(
                    "id" => $assignment->id,
                    "subject_id" => $assignment->subject_id,
                    "title" => $assignment->title,
                    "description" => $assignment->description,
                    "due_date" => $assignment->due_date
                );
                http_response_code(200);
                echo json_encode($assignment_arr);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Assignment not found."]);
            }
        } else {
            $stmt = $assignment->read();
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($assignments);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $assignment->id = $data->id;
        $assignment->subject_id = $data->subject_id;
        $assignment->title = $data->title;
        $assignment->description = $data->description;
        $assignment->due_date = $data->due_date;
        if ($assignment->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Assignment was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update assignment."]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $assignment->id = $data->id;
        if ($assignment->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Assignment was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete assignment."]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed."]);
        break;
}
?>