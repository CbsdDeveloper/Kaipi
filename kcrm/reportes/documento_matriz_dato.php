<?php 
session_start( );  
ob_start(); 

require('kreportes.php'); 
$caso           	= $_GET['caso'];
$process            = $_GET['process'];
$doc           	    = $_GET['doc'];

$gestion   		= 	new kreportes; 	

$ADocumento 	=   $gestion->Reporte_Proceso($caso,$process,$doc  );
 
?>
<!DOCTYPE html>

<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
<link href="css/style.css" rel="stylesheet">
	
</head>		
	
<body>
 	
<div id="header">
    <div  style="padding: 2px">
		
 	   <?php    
		
			  $gestion->_Encabezado_1();
		
		?>
    </div> 
 </div>
 
<div id="footer">

	
	
	<?php echo $gestion->pie_cliente( $datos['nombre']); ?>
</div>
	
	<div id="content"> 
		
		 
	
	   <div class="col-md-12" align="right" style="font-size: 11px"> 
 		    <table width="90%" border="0" cellspacing="0" cellpadding="0">
			  <tbody>
 				  <tr>
				  <td align="center"> <?php   echo '<b>FORMULARIO: '. $ADocumento['secuencia'] ?></b> <br>
					   <?php   echo  $ADocumento['anio'] ?></td>
				</tr>
			  </tbody>
			</table>
  	   </div>	   
		
	  <div class="col-md-12" align="justify" > 
		  
		  <table width="90%" border="0" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td>  <?php      echo trim($ADocumento['editor']);  ?></td>
				</tr>
			  </tbody>
		</table>
 
      </div>	
  <br>	

		<table width="80%" border="0" cellspacing="0" cellpadding="0">
			  <tbody>
				<tr>
				  <td align="center" style="font-size: 11px;padding:5px"><b>EVIDENCIAS QUE SUSTENTA EL REPORTE</b></td>
				</tr>
				<tr>
				  <td style="padding: 10px"><img src="../../userfiles/files/<?php echo $gestion->imagen_caso( $caso ) ?>" width="220" height="125"/> 	 </td>
				</tr>
			  </tbody>
			</table>

 
 		  <?php $gestion->PersonalAsiganado( $caso ) ?>
	   
		  
 		  <?php $gestion->CarroAsiganado( $caso ) ?>

		  <?php $gestion->PacientesAsiganado( $caso ) ?>

 
		 

 		  
 
 	   

  <p>&nbsp;
	  
  </p>	

<table border="0" width="100%" cellspacing="2" cellpadding="5">
<tbody>
<tr>
<td style="text-align: center;" width="50%"><span style="font-size: 8pt; font-family: arial, helvetica, sans-serif;"><strong>AUTORIZADO<br />JEFE DE BOMBEROS</strong></span></td>
<td style="text-align: center;" width="50%"><span style="font-size: 8pt; font-family: arial, helvetica, sans-serif;"><strong>REGISTRADO<br />#SOLICITA&nbsp;<br /></strong></span></td>
</tr>
</tbody>
</table>


   </div> 
	
	 
	
	
</html>
<?php 
 /*
 
set_time_limit(0);
					  
ini_set("memory_limit",-1);
					  
ini_set('max_execution_time', 0);
												 
												 */

 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 
$filename = "DocumentoDigital".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
					 
  
?>
