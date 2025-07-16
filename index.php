<?php
header('Content-Type: application/json');
require_once('model/device.php');

$device = new Devices();
$method = $_SERVER["REQUEST_METHOD"];


switch ($method) {
    case 'GET':
        echo json_encode($device->getAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode([
            "success" => $device->create($data)
        ]);
        break;

    case 'PUT':
        $id = $_GET["id"];
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode([
            "success" => $device->update($id, $data)
        ]);
        break;

    case 'DELETE':
        $id = $_GET["id"];
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode([
            "success" => $device->delete($id)
        ]);
        break;

    default:
        throw new error("Method is not allowed.");
}
