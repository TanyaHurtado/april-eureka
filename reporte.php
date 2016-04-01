 
<html>
<head> <meta charset="UTF-8"/>
  <!-- Bootstrap -->
  <link href="bootstrap/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Material Design -->
  <link href="bootstrap/bootstrap-material-design.css" rel="stylesheet"/>

  </head>
  <style type="text/css">
  	.table-hover thead {
        background-color: #7ECFF5;
	}
	  .table-hover tbody {
	        background-color: white;
	}
	 .table-hover tbody tr:hover td {
	        /*background-color:#20D0D8;*/
	         background-color: #B1E2F9;
	}
	body{
	  	     background-color: white;
  }
  </style>
  <script type="text/javascript">
  		$(document).ready(function() {
	    setTimeout(function() {
	        $(".alert").alert('close');
	    }, 2000);
	});
  </script>
 <body>
 <table class="table table-striped table-hover ">
 <thead>
 	 <tr>
    <th>ID</td>
    <th>Teléfono</td>
    <th>Línea</td>
    <th>Mensaje</td>
    <th>Recepción</td>
    <th>Campaña</td>
    <th>Registro</td>
    <th>Tipo</td>
  </tr>
 </thead>
 <tbody>
 	
  <tr class="x">
    <?php
		$mysqli = new mysqli("localhost", "root", "", "bd");
		if ($mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		if (is_null($_GET) || !isset($_GET["cuantos"]))
		{
			$nn = 50;
		}
		else
		{
			$nn = $_GET["cuantos"];
		}
		$count = mysqli_fetch_assoc($mysqli->query("select count(*) from entrantes"))["count(*)"];
		if (is_null($_GET) || !isset($_GET["n"]))
		{
			$n = $i = 0;
		}
		else
		{
			$i = $_GET["n"];
			if ($i != $count - $nn)
			{
				$n = $i - ($i % $nn);
				$i = $n;
			}
			else
			{
				$n = $i;
			}
		}
		if (!$q = $mysqli->query("select * from entrantes where id > ".$n)) {
			echo "Query Failed!: (" . $mysqli->errno . ") ". $mysqli->error;
		}
		
		while ($row = mysqli_fetch_array($q)) {
			$i = $i + 1;
			if ($i > $nn + $n)
			{
				break;
			}
			echo "<tr >";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$row[6]."</td>";
			switch ($row[7]) {
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
			echo "<td>".$Tipo."</td>";

		}
		$q->free();
		$mysqli->close();
	?>
	</tr>
	</tbody>
</table>
<table>
	<tr>
		<td id="tipoResponse"></td>
	</tr>
</table>
<br>
<ul class='pagination' style='margin-left: 40%;'>
<?php
	if ($nn < $count)
	{
		echo "<li".((($n - $nn) >= 0) ? "><a href=\"reporte.php?cuantos=".$nn."&n=".(0)."\">&lt;&lt;</a>" : " class=\"page-item disabled\"><a href=\"#\">&lt;&lt;</a>")."</li>";
		echo "<li".(($n > 0) ? "><a href=\"reporte.php?cuantos=".$nn."&n=".max($n - $nn, 0)."\">&lt;</a>" : " class=\"page-item disabled\"><a href=\"#\">&lt;</a>")."</li>";
		$i = 1;
		$j = 0;
		while ($j < $count)
		{
			echo "<li".(($n == $j) ? " class=\"page-item active\"><a href=\"#\">".$i."</a>" : "><a href=\"reporte.php?cuantos=".$nn."&n=".$j."\">".$i."</a>")."</li>";
			$j = $j + $nn;
			$i = $i + 1;
		}
		echo "<li".((($n + $nn) < $count) ? "><a href=\"reporte.php?cuantos=".$nn."&n=".($n + $nn)."\">&gt;</a>" : " class=\"page-item disabled\"><a href=\"#\">&gt;</a>")."</li>";
		echo "<li".(($count - $nn != $n) ? "><a href=\"reporte.php?cuantos=".$nn."&n=".max($count - $nn, 0)."\">&gt;&gt;</a>" : " class=\"page-item disabled\"><a href=\"#\">&gt;&gt;</a>")."</li>";
	}
?>
</body>
</html>
