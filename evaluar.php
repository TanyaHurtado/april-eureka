 
<html>
<head> 
  <!-- Bootstrap -->
  <link href="bootstrap/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Material Design -->
  <link href="bootstrap/bootstrap-material-design.css" rel="stylesheet"/>
  
  </head>
  <style type="text/css">
  .table-hover thead {
        background-color: #C4E3F3;
}
  .table-hover tbody {
        background-color: white;
}
 .table-hover tbody tr:hover td {
        /*background-color:#20D0D8;*/
         background-color: #C4E3F3;
}

  </style>
  	
 
 <body>
 <table class="table table-striped table-hover">
<thead>
	

 	  <tr class="x" >
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
		require_once("sql.php");
		$mysqli = new mysqli($servername, $username, $password, $dbname);
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
			echo "<tr>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$row[6]."</td>";
			echo "<td><form>
					<table><tr><td><input type=\"radio\" name=\"tipo\" value=\"\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "" ? "checked" : "")."> No clasificado</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"F\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "F" ? "checked" : "")."> Favorable</td></tr>
					<tr><td><input type=\"radio\" name=\"tipo\" value=\"N\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "N" ? "checked" : "")."> Neutral</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"B\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "B" ? "checked" : "")."> Baja voluntaria</td></tr>
					<tr><td><input type=\"radio\" name=\"tipo\" value=\"A\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "A" ? "checked" : "")."> Agresivo baja</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"E\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($row[7] == "E" ? "checked" : "")."> Error en número</td></tr></table>
					</form></td>";
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
</table >
<br>
<?php
	if ($nn < $count)
	{
		echo "<ul class='pagination'>";
		echo (($n - $nn) >= 0) ? "<li><a href=\"evaluar.php?cuantos=".$nn."&n=".(0)."\">&lt;&lt;</a></li>" : "&lt;&lt; ";
		echo (($n - $nn) >= 0) ? "<li><a href=\"evaluar.php?cuantos=".$nn."&n=".($n - $nn)."\">&lt;</a></li>" : "&lt; ";
		$i = 1;
		$j = 0;
		while ($j < $count)
		{
			echo ($n == $j) ? $i." " : "<li><a href=\"evaluar.php?cuantos=".$nn."&n=".$j."\">".$i."</a></li>";
			$j = $j + $nn;
			$i = $i + 1;
		}
		echo (($n + $nn) < $count) ? "<li><a href=\"evaluar.php?cuantos=".$nn."&n=".($n + $nn)."\">&gt;</a></li> " : "&gt; ";
		echo ($count - $nn != $n) ? "<li><a href=\"evaluar.php?cuantos=".$nn."&n=".max($count - $nn, 0)."\">&gt;&gt;</a></li>" : "&gt;&gt; ";

	}
	echo "</ul>";
?>
</body>
</html>
<script>
	function cambioTipo(val, id) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("tipoResponse").innerHTML = xmlhttp.responseText;
			}
		};
		document.getElementById("tipoResponse").innerHTML = "Actualizando tipo";
        xmlhttp.open("GET", "evaluartipo.php?tipo=" + val + "&id=" + id, true);
        xmlhttp.send();
	}
</script>
