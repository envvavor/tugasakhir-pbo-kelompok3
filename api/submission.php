<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/Database.php';
require_once '../models/Submission.php';

$database = new Database();
$db = $database->getConnection();

$submission = new Submission($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $submission->assignment_id = $data->assignment_id;
        $submission->user_id = $data->user_id;
        $submission->submission_date = $data->submission_date;
        $submission->content = $data->content;
        if ($submission->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Submission was created."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to create submission."]);
        }
        break;
    case 'GET':
        $stmt = $submission->read();
        $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($submissions);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $submission->id = $data->id;
        $submission->assignment_id = $data->assignment_id;
        $submission->user_id = $data->user_id;
        $submission->submission_date = $data->submission_date;
        $submission->content = $data->content;
        if ($submission->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Submission was updated."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to update submission."]);
        }
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $submission->id = $data->id;
        if ($submission->delete()) {
            http_response_code(200);
            echo json_encode(["message" => "Submission was deleted."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Unable to delete submission."]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed."]);
        break;
}
?>