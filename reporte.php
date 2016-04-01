<!DOCTYPE html>
<html>
	<head>
	<title></title>
	<meta charset="UTF-8"/>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text"/>
        <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	</head>
	<body>
				<?php
				$con=mysqli_connect("localhost","root","lolMYSQL420","bd");
				if (mysqli_connect_errno())
				  {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				  }
				$sql="SELECT id,telefono,linea,mensaje,recepcion,campania,registro,tipo FROM entrantes";

				if ($result=mysqli_query($con,$sql))
				  {
 
				
				echo "<table class='table table-striped'>";
							echo "<tr>";
							echo "<td><label>ID :</label> </td>";
							echo "<td><label>Teléfono: </label></td>";
							echo "<td><label>Línea:</label> </td>";
							echo "<td><label>Mensaje Inicial:</label> </td>";
							echo "<td><label>Recepción: </label> </td>";
							echo "<td><label>Hora Entrada:</label> </td>";
							echo "<td><label>Campaña:</label> </td>";
							echo "<td><label>Registro: </label></td>";
							echo "<td><label>Tipo: </label></td>";
							echo "<td></td>";
							echo "</tr>";
					while ($reg=mysqli_fetch_object($result)){
							echo "<tr>";
							
							echo "<td>$reg->id</td>";
							echo "<td>$reg->telefono</td>";
							echo "<td>$reg->linea</td>";	
							echo "<td>$reg->mensaje</td>";	
							echo "<td>$reg->recepcion</td>";	
							echo "<td>$reg->campania</td>";
							echo "<td>$reg->registro</td>";	
							
							switch ($reg->tipo) {
							    case " ":
							        $Tipo="No clasificado";
							        break;
							    case "F":
							        $Tipo="Favorable";
							        break;
							    case "N":
							        $Tipo="Neutral";
							        break;
							        case "B":
							        $Tipo="Baja voluntaria";
							        break;
							         case "A":
							       $Tipo="Agresivo Baja";
							        break;
							         case "E":
							        $Tipo="Error en número";
							        break;
							        default:
							        	 $Tipo="No clasificado";
							        	 break;

							}
							echo "<td>$Tipo</td>";				
						echo "</tr>";
				}
				}
					echo "</table>";

 ?>
		 </body>
		 </html>