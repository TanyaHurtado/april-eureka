<?php
$servername = "localhost";
$username = "root";
$password = "lolMYSQL420"; //AQUÍ VA LA NUEVA CONTRASEÑA.
$dbname = "bd"; //AQUÍ VA EL NOMBRE DE LA BASE DE DATOS.

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = sprintf("INSERT INTO entrantes (telefono, linea, mensaje, recepcion, campania, registro, tipo) VALUES ('%s', '%s', '%s', '%s', '%s', %s, '');", $_GET['telefono'], $_GET['linea'], $_GET['mensaje'], $_GET['recepcion'], $_GET['campania'], "NOW()");

if ($conn->query($sql) === TRUE) {
    echo "Nuevo registro creado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>