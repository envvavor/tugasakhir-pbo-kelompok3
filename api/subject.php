<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/Subject.php';

$database = new Database();
$db = $database->getConnection();

$subject = new Subject($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $subject->class_id = $data->class_id;
        $subject->name = $data->name;
        $subject->description = $data->description;
        if ($subject->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Subject was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create subject."]);
        }
        break;
    case 'GET':
        $stmt = $subject->read();
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($subjects);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $subject->id = $data->id;
        $subject->class_id = $data->class_id;
        $subject->name = $data->name;
        $subject->description = $data->description;
        if ($subject->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Subject was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update subject."]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $subject->id = $data->id;
        if ($subject->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Subject was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete subject."]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed."]);
        break;
}
?>