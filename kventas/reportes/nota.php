<?php 
session_start( );  
ob_start(); 
require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		
//$gestion->QR_Documento();
$id 		    = trim($_GET['codigo']);
$cotiza 		= trim($_GET['cotiza']);
$idvengestion 	= trim($_GET['idvengestion']);

$datos 		= $gestion->Cotizacion($cotiza);
//   var enlace = url + '?codigo='+variable +'&cotiza=' + id_cotizacion +'&idvengestion=' + idvengestion     ;?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
	
<style>
    @page { margin: 180px 50px; }
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 110px; background-color:#FFFFFF; text-align: center; }
	
    #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 50px; background-color:#FFFFFF; }
	
    #footer .page:after { 
	/*	content: counter(page, upper-roman); */
		counter-increment: section;
        content: "Pag " counter(section) " ";
	
	}

	.round3 {
    border: 1px solid #767676;
    border-radius: 5px;
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
   <div class="col-md-12 round3" style="padding: 7px">
         <table width="100%">
					 <tr>
					 <td align="left" style="font-size: 11px"><?php echo $gestion->Empresa(); ?></td>
					  <td rowspan="5" align="right" valign="top">  <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="70"></td>
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
  </div> 
 </div>
 
<div id="footer" style="width: 90%">
	<?php echo $gestion->pie_cliente( $datos['nombre']); ?>
</div>
	
<div id="content" style="width: 90%">
 	 
  <div class="col-md-12" style="padding: 7px">
 			 <table width="95%">
				 <tr>
				  <td bgcolor="#EDEDED" align="center" style="font-weight: normal;font-size: 14px"> 
					  <b>   NOTA DE ENTREGA NRO. <?php   	echo $datos['documento'] ?> </b>
				 </td>
				</tr>
				 <tr>
				  <td  align="right" style="font-weight: normal;font-size: 10px"> 
					  <b>   Fecha: <?php  echo $datos['fecha'] ?> </b>
				 </td>
				</tr>
			   </table>  
	  
	           <?php echo utf8_encode($datos['cabecera'])  ?>
   </div>
    <p style="padding: 1px">&nbsp; </p>
	
     
  </div> 
	
	
</html>
<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html(utf8_decode(ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

 //$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "nota".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>
