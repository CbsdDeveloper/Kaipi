<?php 
session_start( );   
 
 
ob_start();
require('kreportes.php');
$gestion   		= 	new ReportePdf;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 <style type="text/css">
 
	body {
		font-size: 13px;
		color:#000;
	    margin: 2mm 5mm 10mm 5mm;
	}

	  table {
				border-collapse: collapse;
		 		width: 100%
			  }
			  td {
				   border-width: 0.1em;
				   padding: 0.2em;
 			  }
			  td.solid  { 
				  border-style: solid; 
				  color:black;
				 border-width:thin
		      }
 
	.tableCabecera{
 	margin:2px 0 2px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
	width: 100%  
  	}
	 
 .tableFirmas{
 	margin:10px 0 10px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
  	}
	 
 .titulo{
	padding-left: 10px;
	padding-bottom: 2px;
	font-weight: bold;
	color: #5B5B5B
  	}
	 
 .titulo1{
	padding-left: 10px;
	padding-bottom: 2px;
 	color: #5B5B5B
  	}
	 
  .MensajeCab{
	padding-left: 10px;
	padding-bottom: 5px;
	font-weight:100;
	font-size: 11px;
	color:#636363
  	}
 
  .Mensaje{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
    
	 .grillaTexto{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
   	}	 
	 
	 .Mensaje1{
	font-size: 12px;
	padding-left: 5px;
	padding-right: 15px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
	 
  .linea{
		border: .40mm solid thin #909090;
	   padding: 20px;
  	}	

	 .linea1{
		border: .40mm solid thin #909090;
	   padding: 5px;
  	}	
	 
	 	.cabecera_font {
 	 font-size: 10px;
	 font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, "sans-serif";
	 color:#4B4B4B;
	 border-collapse: collapse;
	 width: 100%;
   	}
 </style>
    
</head>

<body>
	
 
<table class="cabecera_font">
 					  <tr>
					    <td style="border-collapse: collapse; border: 0px solid #AAAAAA;font-size: 13px" width="11%" align="left" valign="top">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
						</td>
						<td colspan="3" align="center" style="font-size: 12px">
							<?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?>
						</td>
							 <td width="6%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
			   </tr>
</table>
		 <h3><b>RESUMEN GENERAL DE ACTIVOS FIJOS</b></h3>
  
		  <?php      $gestion->RESUMEN_BIENES($codigo) ;   ?>
        
<p>&nbsp;</p>		
<p>&nbsp;</p>		
<table>
					<tr>
					  <td   style="font-size: 12px" align="center" valign="middle">______________________________<?php echo $datos['elaborado'] ?></td>
					  <td  style="font-size: 12px" align="center" valign="middle">______________________________<?php echo $datos['e10'] ?></td>
	 			   </tr>
	
					<tr>
					    <td   style="font-size: 12px" align="center" valign="middle">Elaborado<?php echo $datos['unidad'] ?></td>
					  <td   style="font-size: 12px" align="center" valign="middle">Revisado<?php echo $datos['e11'] ?></td>
	  				</tr>
	
					 
 </table>


 
 

</body>
</html>
<?php 
 /*
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = 'ResumenBienes.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 */

?>