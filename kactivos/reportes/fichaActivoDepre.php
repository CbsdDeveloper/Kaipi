<?php  
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$codigo 		=   $_GET['codigo'];
$cuenta 		=   $_GET['cuenta'];

$datos 			=	$gestion->CabReportesDepre($codigo);
 
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
	
<style>
    	
    
	.round3 {
    border: 1px solid #767676;
    border-radius: 5px;
    }
	
	.tabla_cab {
 	 border: #767676 0px solid;
	 margin: 3px;	
	 width : 100%;
	 padding: 3px;
  	}
	
	.tablaTotal {
 	 margin: 3px;	
	 padding: 3px;
  	}
	
	.tablaDet {
 	 margin: 3px;	
	 padding: 3px;
	 width : 100%;
	 border: #ccc 1px solid;
  	}
	
	.tablaPie {
 	 border: #767676 1px solid;
	 margin: 25px;	
	 padding: 25px;
  	}
	.tablaPie1 {
 	 border: #ccc 1px solid;
	 margin: 3px;	
	 width : 100%;
	 padding: 5px;
  	}
  </style>
	
</head>		
<body>
	
 
 
 

<div style="width: 100%">
 	 
         	  <table class ="tabla_cab">
        					 <tr>
        					 <td align="left" style="font-size: 11px"><?php echo $gestion->Empresa(); ?></td>
        					  <td rowspan="5" align="right" valign="top">  <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="80"></td>
        					</tr>
        					<tr>
        					  <td align="left" style="font-size: 11px">RUC <?php echo $gestion->_Cab( 'ruc_registro' ); ?></td>
        					  </tr>
        					<tr>
        					   <td align="left" style="font-size: 10px">Direccion <?php echo $gestion->_Cab( 'direccion' ); ?></td>
        					  </tr>
        					<tr>
        					   <td  align="left" style="font-size: 10px">Telefono <?php echo $gestion->_Cab( 'telefono' ); ?></td>
        					  </tr>
        					<tr>
        					 <td  align="left" style="font-size: 10px"><?php echo $gestion->_Cab( 'ciudad' ); ?> - Ecuador</td>
        					  </tr>
        		</table>
		
 				<h6>&nbsp;  </h6>
 
 			    <table  class ="tabla_cab">
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 12px"> 
					  <b>   Proceso de depreciacion de la cuenta  <?php  echo trim($cuenta) ?> del periodo <?php  echo $datos['anio']  ?>  </b>
				 </td>
				</tr>
				<tr>
				  <td  style="font-weight: normal;font-size: 11px"> 
					   Transaccion: <?php  echo $codigo ?>  
				 </td>
				</tr>
				 <tr>
				  <td  style="font-weight: normal;font-size: 11px"> 
					   Fecha: <?php  echo $datos['fecha2'] ?>  
				 </td>
				</tr>
				<tr>
				  <td  style="font-weight: normal;font-size: 11px"> 
					  <?php  echo $datos['detalle'] ?>  
				 </td>
				</tr>
			   </table>  
 	           
		         
				
 				<h6>&nbsp;  </h6>
		 		 <?php      $gestion->GrillaDetalleDepre($codigo); ?>
		  		 
<h6>&nbsp;  </h6>
		       <table class ="tablaPie1">
				 
				 <tr>
				   <td with="33%"  align="center" style="padding: 10px;font-size: 10px"><p>&nbsp;</p>
			       <p>&nbsp;</p></td>
				   <td with="33%" align="center" style="padding: 10px;font-size: 10px">&nbsp;</td>
				   <td with="33%"  align="center" style="padding: 10px;font-size: 10px">&nbsp;</td>
			     </tr>
				 <tr>
				   <td align="center" style="padding: 3px;font-size: 10px"> Elaborado </td>
				   <td align="center" style="padding: 3px;font-size: 10px">Revisado</td>
				   <td align="center" style="padding: 3px;font-size: 10px">Autorizado</td>
			     </tr>
				  
			   </table> 
		 
		  
 	 
	
 	  <p style="padding: 1px">&nbsp; </p>
	
 </div> 
	
	
	 
<div  style="width: 90%">

	<?php echo $gestion->pie_cliente( $datos['unidad']); ?>
	
</div>
	
	
	
</html>
<?php 
 /*
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

ini_set("memory_limit","128M");

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
$filename = "Anexo".time().'.pdf';
 
 
$dompdf->stream($filename, array("Attachment" => false));
 */
 

?>
