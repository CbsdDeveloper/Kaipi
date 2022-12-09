<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>Plataforma de Gestion Empresarial</title>
<?php  
	require('Head.php');
	require('kreportes.php')  ;
?> 
</head>
<body>
	
<div class="col-md-12" style="padding-top: 20px;padding-left: 25px;padding-right: 30px"> 

 <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?> " width="140" height="110">
 <h5> <b> PRESUPUESTO <?php  if ( $_GET['tipo'] == 'I')   echo 'INGRESO'; else  echo 'GASTO'  ?> </b><br> 
 	  <?php  echo $_SESSION['ruc_registro'].' '.$_SESSION['razon']  ?> <br>
	  <?php  echo 'Periodo '. $_GET['fanio']  ?> </h5> 
<?php
$gestion   		  = 	new ReportePdf; 		
$tipo_presupuesto = $_GET['tipo'];
 

$gestion->cedula_presupuestaria_detalle($_GET['fanio'],$_GET['tipo']);

//---------------------------------------------------------------	

    echo '<script>javascript:window.print()</script>';
    echo '<script>javascript:window.close()</script>';	
	 
 
?>  
</div>			
</body>
</html> 
 