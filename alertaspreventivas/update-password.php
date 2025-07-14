<?php
header('Content-Type: application/json');
require 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$newPassword = $data['newPassword'] ?? '';

if (!$email || !$newPassword || strlen($newPassword) < 8) {
    http_response_code(400);
    echo json_encode(['message' => 'Datos inválidos']);
    exit;
}

$hash = password_hash($newPassword, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("UPDATE usuarios SET password = ? WHERE email = ?");
$stmt->execute([$hash, $email]);

echo json_encode(['message' => 'Contraseña actualizada correctamente']);
?>
