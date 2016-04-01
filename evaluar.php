<html>
<head> 
  <!-- Bootstrap -->
  <link href="bootstrap/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Material Design -->
 <link href="bootstrap/bootstrap-material-design.css" rel="stylesheet"/>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
  window.setTimeout(function() { // hide alert message
    $("#div").removeClass('in'); 

}, 5000);
  	</script>
  	
 
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
			echo "Conexión fallida a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
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
			$i++;
			if ($i > $nn + $n)
			{
				break;
			}
			$j = 0;
			echo "<tr>";
			while ($j < 7)
			{
				echo "<td>".$row[$j]."</td>";
				$j++;
			}
			$tipo = $row[7];
			echo "<td><form>
					<table>
					<tr>
					<td><input type=\"radio\" name=\"tipo\" value=\"\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "" ? "checked" : "")."> No clasificado</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"F\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "F" ? "checked" : "")."> Favorable</td></tr>
					<tr>
					<td><input type=\"radio\" name=\"tipo\" value=\"N\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "N" ? "checked" : "")."> Neutral</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"B\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "B" ? "checked" : "")."> Baja voluntaria</td></tr>
					<tr>
					<td><input type=\"radio\" name=\"tipo\" value=\"A\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "A" ? "checked" : "")."> Agresivo baja</td>
					<td><input type=\"radio\" name=\"tipo\" value=\"E\" onchange=\"cambioTipo(this.value, ".$i.")\" ".($tipo == "E" ? "checked" : "")."> Error en número</td></tr>
					</table>
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
<ul class='pagination' style='margin-left: 40%;'>
<?php
	if ($nn < $count)
	{
		echo "<li".((($n - $nn) >= 0) ? "><a href=\"evaluar.php?cuantos=".$nn."&n=".(0) : " class=\"page-item disabled\"><a href=\"#")."\">&lt;&lt;</a></li>";
		echo "<li".(($n > 0) ? "><a href=\"evaluar.php?cuantos=".$nn."&n=".max($n - $nn, 0) : " class=\"page-item disabled\"><a href=\"#")."\">&lt;</a></li>";
		$i = 1;
		$j = 0;
		while ($j < $count)
		{
			echo "<li".(($n == $j) ? " class=\"page-item active\"><a href=\"#" : "><a href=\"evaluar.php?cuantos=".$nn."&n=".$j)."\">".$i."</a></li>";
			$j = $j + $nn;
			$i = $i + 1;
		}
		echo "<li".((($n + $nn) < $count) ? "><a href=\"evaluar.php?cuantos=".$nn."&n=".($n + $nn) : " class=\"page-item disabled\"><a href=\"#")."\">&gt;</a></li>";
		echo "<li".(($count - $nn != $n) ? "><a href=\"evaluar.php?cuantos=".$nn."&n=".max($count - $nn, 0) : " class=\"page-item disabled\"><a href=\"#")."\">&gt;&gt;</a></li>";
	}
?>
</ul>
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
