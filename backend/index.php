<?php 
// index.php (API entry)
declare(strict_types=1);
require_once('car.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header('Content-Type: application/json');
$method = $_SERVER["REQUEST_METHOD"];
$car = new Car();

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET["id"])) {
                $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);
                if ($id === false) throw new Exception("Invalid ID format");
                $result = $car->getCarByID($id);
                if (empty($result)) {
                    http_response_code(404);
                    echo json_encode(["error" => "Car not found"]);
                } else {
                    echo json_encode($result);
                }
            } else {
                echo json_encode($car->getAll());
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['make'], $data['model'], $data['year'], $data['price'])) {
                throw new Exception("Missing required fields");
            }
            if ($car->create($data)) {
                http_response_code(201);
                echo json_encode(["success" => true, "message" => "Car created successfully"]);
            } else {
                throw new Exception("Failed to create car");
            }
            break;

        case 'PUT':
            $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);
            if ($id === false || $id === null) throw new Exception("Invalid or missing ID");
            $data = json_decode(file_get_contents("php://input"), true);
            if (empty($data)) throw new Exception("No data provided for update");
            if ($car->update($id, $data)) {
                echo json_encode(["success" => true, "message" => "Car updated successfully"]);
            } else {
                throw new Exception("Failed to update car");
            }
            break;

        case 'DELETE':
            $id = filter_var($_GET["id"] ?? null, FILTER_VALIDATE_INT);
            if ($id === false || $id === null) throw new Exception("Invalid or missing ID");
            if ($car->delete($id)) {
                echo json_encode(["success" => true, "message" => "Car deleted successfully"]);
            } else {
                throw new Exception("Failed to delete car");
            }
            break;

        default:
            http_response_code(405);
            throw new Exception("Method not allowed");
    }
} catch (Exception $e) {
    if (http_response_code() === 200) http_response_code(400);
    echo json_encode(["error" => $e->getMessage()]);
    exit();
}
?>