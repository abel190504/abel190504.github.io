<?php
// Configuración de la base de datos (basado en tu captura)
$servername = "127.0.0.1";  // O "localhost"
$username = "root";         // Tu usuario de MySQL (suele ser "root")
$password = "";             // Tu contraseña de MySQL (suele estar vacía)
$dbname = "paciente";       // El nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar para que acepte tildes y eñes (UTF-8)
$conn->set_charset("utf8");
?>