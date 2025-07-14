<?php
header('Content-Type: application/json');
require 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode(['message' => 'Login correcto']);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Usuario o contraseña incorrectos']);
}
?>
