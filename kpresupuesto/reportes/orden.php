<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['codigo']);
$datos 			= $gestion->Memorando($id);
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<!-- Bootstrap 
<link href="css/bootstrap.min.css" rel="stylesheet">-->
<link href="css/style.css" rel="stylesheet">
	
<style>
    @page { margin: 180px 50px; }
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 100px; background-color:#FFFFFF; text-align: center; }
	
    #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 50px; background-color:#FFFFFF; }
	
    #footer .page:after { 
	/*	content: counter(page, upper-roman); */
		counter-increment: section;
        content: "Pagina " counter(section) " ";
	
	}

	.round3 {
    /*border: 1px solid #767676;
    border-radius: 5px;*/
    }
	
	.tabla {
 	 border: #767676 1px solid;
	 margin: 3px;	
	 padding: 3px;
  	}
	
	.tablaTotal {
 	 margin: 3px;	
	 padding: 3px;
  	}
	
	
	.tablaPie {
 	 border: #767676 1px solid;
	 margin: 25px;	
	 padding: 25px;
  	}
	.tablaPie1 {
 	 border: #767676 1px solid;
	 margin: 3px;	
	 padding: 3px;
  	}
  </style>
	
</head>		
<body>
	
<div id="header">
   <div  style="padding: 1px">
	   
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tbody>
			<tr>
			  <td width="20%" align="left" valign="middle" style="font-size: 11px;padding_left: 5px" ><img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="80%" align="left" valign="middle" style="font-size: 11px;padding_left: 5px" ><br><?php echo $gestion->Empresa(); ?><br>RUC <?php echo $gestion->_Cab( 'ruc_registro' ); ?> <br>Direccion <?php echo $gestion->_Cab( 'direccion' ); ?><br>Telefono <?php echo $gestion->_Cab( 'telefono' ); ?><br> <?php echo $gestion->_Cab( 'ciudad' ); ?> - Ecuador</td>
		    </tr>
			 
		  </tbody>
	</table>
 
	    
  </div> 
 </div>
 
<div id="footer">
	<?php echo $gestion->pie_cliente( $datos['nombre']); ?>
</div>
	
<div id="content">
 	 
	  <div  style="padding: 5px">  
 			  <table width="100%">
				 <tr>
				  <td  align="right" style="font-size: 11px"> 
					    <?php   	echo trim($datos['nro_memo']) ?> 
				 </td>
				</tr>
				 <tr>
				  <td  align="right" style="font-size: 11px"> 
					    Fecha: <?php  echo $datos['fecha'] ?> 
				 </td>
				</tr>
			   </table>  
 	           <?php echo utf8_encode($datos['asunto'])  ?>
 		</div>
	
 	  <p style="padding: 1px">&nbsp; </p>
	
 </div> 
	
	
</html>
<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait');  
						  
						  
$dompdf->load_html(utf8_decode( ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "nota".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>
