<?php
if(isset($_POST["interes"]))
{
	$_POST["interes"]=str_replace(",",".",$_POST["interes"]);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>cálculo de hipotecas/préstamos</title>
</head>
 
<style>
form {width:250px;}
form>div>span {width:100px;display: inline-block;text-align:left;}
form input {width:150px;}
form>div {text-align:center;}
</style>
 
<body>
 
<h1>Cálculo de hipotecas/préstamos</h1>
<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="POST">
	<div>
		<span>Importe :</span>
		<span><input type="text" name="importe" maxlength=9 value="<?php echo $_POST["importe"]?>"></span>
	</div>
	<div>
		<span>Años :</span>
		<span><input type="text" name="anos" maxlength=2 value="<?php echo $_POST["anos"]?>"></span>
	</div>
	<div>
		<span>Interés :</span>
		<span><input type="text" name="interes" maxlength=9 value="<?php echo $_POST["interes"]?>"></span>
	</div>
	<div>
		<p><input type="submit" value="Calcular"></p>
	</div>
</form>
 
<?php
if($_POST["importe"] && $_POST["anos"] && $_POST["interes"])
{
	$deuda=$_POST["importe"];
	$anos=$_POST["anos"]/12;
	$interes=$_POST["interes"];
 
	// hacemos los calculos...
	$interes=($interes/100)/12;
	
	$m=($deuda*$interes*(pow((1+$interes),($anos*12))))/((pow((1+$interes),($anos*12)))-1);
 
	echo "<div>Capital Inicial: ".number_format($deuda,2,",",".")." €";
	echo "<br>Cuota a pagar mensualmente: ".number_format($m,2,",",".")." €</div>";
	?>
	<table border=1 cellpadding=5 cellspacing=0>
		<tr>
			<th>Mes</th>
			<th>Intereses</th>
			<th>Amortización</th>
			<th>Capital Pendiente</th>
		</tr>
		<?php
		// mostramos todos los meses...
		for($i=1;$i<=$anos*12;$i++)
		{
			echo "<tr>";
				echo "<td align=right>".$i."</td>";
				$totalint=$totalint+($deuda*$interes);
				echo "<td align=right>".number_format($deuda*$interes,2,",",".")."</td>";
				echo "<td align=right>".number_format($m-($deuda*$interes),2,",",".")."</td>";
 
				$deuda=$deuda-($m-($deuda*$interes));
				if ($deuda<0)
				{
					echo "<td align=right>0</td>";
				}else{
					echo "<td align=right>".number_format($deuda,2,",",".")."</td>";
				}
			echo "</tr>";
		}
		?>
	</table>
	Pago total de intereses : <?php echo number_format($totalint,2,",",".")?> €
	<?php
}
?>
 
</body>
</html>