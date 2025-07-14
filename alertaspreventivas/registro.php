<<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Encripta la contraseña

  // Conexión a la base de datos (MySQL)
  $conn = new mysqli("localhost", "usuario_db", "password_db", "nombre_bd");

  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO usuarios (email, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $email, $password);

  if ($stmt->execute()) {
    echo "Usuario registrado exitosamente.";
  } else {
    echo "Error al registrar usuario: " . $conn->error;
  }

  $stmt->close();
  $conn->close();
}
?>
