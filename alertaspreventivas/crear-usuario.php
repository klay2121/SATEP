<?php
header('Content-Type: application/json');
require 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Email y contraseña requeridos']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    http_response_code(409);
    echo json_encode(['message' => 'Usuario ya existe']);
    exit;
}

$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
$stmt->execute([$email, $hash]);

echo json_encode(['message' => 'Usuario creado']);
?>
