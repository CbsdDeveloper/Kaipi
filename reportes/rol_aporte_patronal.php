<?php 
session_start();

ob_start(); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$programa			= trim($_GET['programa'] );

$id_rol 	     	= $_GET['id_rol'];

$gestion->QR_DocumentoDoc($id_rol);

$logo = $gestion->ImagenLogo();


$datos = $gestion->RolNomina_periodo($id_rol);

  
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
    @page { margin: 180px 50px; }
    
	#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 110px; background-color:#FFFFFF; text-align: center; }
	
    #footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 180px; background-color:#FFFFFF; }
	
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
	
	.col12_pantalla{
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
	
  </style>
	
	
</head>	
	
<body>
	
<div id="header">
	
   <div class="col12_pantalla round3" style="padding: 7px">
    
	   <table width="95%">
					  <tr> 
					    <td width="11%" rowspan="5" align="left" valign="top" style="font-size: 11px">
							<img src="../kimages/<?php echo $logo ?>" width="100" height="80">
						</td>
						<td colspan="3" align="left" style="font-size: 11px"><?php echo $gestion->Empresa(); ?></td>
							 <td width="6%" rowspan="5" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
						</tr>
						<tr>
						  <td colspan="3" align="left" style="font-size: 11px">RUC <?php echo $gestion->_Cab( 'ruc_registro' ); ?></td>
						</tr>
						<tr>
						  <td colspan="3" align="left" style="font-size: 10px">Direccion <?php echo $gestion->_Cab( 'direccion' ); ?></td>
						 </tr>
						<tr>
						  <td colspan="3" align="left" style="font-size: 10px">Telefono <?php echo $gestion->_Cab( 'telefono' ); ?></td>
						</tr>
						<tr>
						  <td colspan="3" align="left" style="font-size: 10px"><?php echo $gestion->_Cab( 'ciudad' ); ?> - Ecuador</td>
						</tr> 
		  </table>
  </div> 
 </div>
 
<div id="footer">
	
</div>
	
<div id="content" style="width:97%">
	 
   <div class="col12_pantalla">	
		 <h5> <?php echo $datos['novedad'].'/'. $programa; ?>/ APORTE PATRONAL</h5>
	   
 	
			 <?php      $gestion->RolNomina_Aporte($programa,$id_rol );  ?>
	    
	 
	     
   </div>
	
	 
		
  </div> 
</html>
<?php 
 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape portrait
 
$dompdf->load_html(utf8_encode(utf8_decode (ob_get_clean() ) ));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "RolPago".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 
 
?>
