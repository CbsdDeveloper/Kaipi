<?php 
session_start();

ob_start(); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$id 			= $_GET['codigo'];

$id_rol 		= $_GET['id_rol'];

$gestion->QR_DocumentoDoc($id_rol);

$logo = $gestion->ImagenLogo();

$gestion->RolNombre( $id,$id_rol );
 
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
	
     
	   <table width="95%">
					  <tr> 
					    <td width="11%" height="107" align="left" valign="top" style="font-size: 11px">
							<img src="../kimages/<?php echo $logo ?>" width="125" height="92">
						</td>
						<td colspan="3" align="left"  valign="top" style="font-size: 11px;padding-left: 10px;padding-right: 10px">
							<?php echo $gestion->Empresa(); ?><br>
							RUC 
							<?php echo $gestion->_Cab( 'ruc_registro' ); ?><br>Direccion 
							<?php echo $gestion->_Cab( 'direccion' ); ?><br>Telefono 
							<?php echo $gestion->_Cab( 'telefono' ); ?><br>
						<?php echo $gestion->_Cab( 'ciudad' ); ?> - Ecuador</td>
							 <td width="6%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
						</tr>
     </table>
  </div>
 
<div id="footer">
	
</div>
	
<div id="content" style="width: 87%">
	 
   <div class="col12_pantalla" >	
		 
	    <div style="font-size: 10px">	   
 	
			 <?php      $gestion->RolNomina( $id,$id_rol );  ?>
	    
	     </div>
	     
   </div>
	
	<div class="col12_pantalla" style="padding-bottom: 50px;padding-top: 50px;">	
		
		<?php  echo $gestion->pie_rol( $id ); ?>
		
 	</div>	
	
	<!--  <img width="80" height="80" src='logo_qr.png'/><br>		-->	
	<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php   $gestion->QR_Firma(); ?></span>	
		
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
