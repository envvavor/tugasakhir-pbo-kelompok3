<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;
        if ($user->create()) {
            http_response_code(201);
            echo json_encode(["message" => "User was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create user."]);
        }
        break;
    case 'GET':
        $stmt = $user->read();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $user->id = $data->id;
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = $data->password;
        if ($user->update()) {
            http_response_code(200);
            echo json_encode(["message" => "User was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update user."]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $user->id = $data->id;
        if ($user->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "User was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete user."]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed."]);
        break;
}
?>