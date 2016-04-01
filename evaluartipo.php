<?php
	$tipo = $_GET["tipo"];
	$id = $_GET["id"];
	require_once("sql.php");

	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Conexión fallida: " . $conn->connect_error);
	}

	$sql = "UPDATE entrantes SET tipo='".$tipo."' WHERE id=".$id;

	if ($conn->query($sql) === TRUE) {
		echo "Tipo registrado exitosamente";
	} else {
		echo "Error de registro: " . $conn->error;
	}

	$conn->close();
?>
