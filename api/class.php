<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/ClassModel.php';

$database = new Database();
$db = $database->getConnection();

$class = new ClassModel($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $class->name = $data->name;
        $class->description = $data->description;
        if ($class->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Class was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create class."]);
        }
        break;
    case 'GET':
        $stmt = $class->read();
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($classes);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $class->id = $data->id;
        $class->name = $data->name;
        $class->description = $data->description;
        if ($class->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Class was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update class."]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $class->id = $data->id;
        if ($class->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Class was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete class."]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed."]);
        break;
}
?>