<?php 
session_start( );   
ob_start(); 
require 'kreportes.php';   /*Incluimos el fichero de la clase Db*/
$g           = new ReportePdf;
$codigo      = $_GET["cod"];
$ADocumento  = $g->ConsultaPoliza($codigo);

$g->QR_DocumentoDoc($codigo);  
$datos = $g->FirmasPie();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 <style type="text/css">
 
	body {
		font-size: 11px;
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
	 .cabecera_conta {
 	 font-size: 14px;
 	 color:#090808;
	 border-collapse: collapse;
	 width: 100%;
   	} 
	 
	 
 </style>
    
</head>

<body>
	
 
<table class="cabecera_font">
		  <tbody>
			<tr>
			  <td width="15%" valign="top"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="85%" style="padding-left: 10px" valign="top"><?php echo $g->Empresa(); ?><br><?php echo $g->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $g->_Cab( 'direccion' ); ?><br><?php echo $g->_Cab( 'telefono' ); ?><br>Modulo Tesoreria
			  </td>
			</tr>
		  </tbody>
		</table>
	
<table class="cabecera_font">
  <tr>
    <td align="right" valign="middle"><?php  echo trim($g->_Cab( 'ciudad' )).', '.$ADocumento['dia_emision'].' de '. $ADocumento['mes'].' del '.$ADocumento['anio_emision'] ?></td>
  </tr> 
  <tr>
     <td  align="right" ><?php echo 'Documento '.$ADocumento['documento']  ?></td>
  </tr>
</table>
 	
<p align="justify" style="font-size: 14px">Sr.(s)<br><b><?php echo $ADocumento['aseguradora']  ?></b><br><?php echo 'RUC '.$ADocumento['idprov_aseguradora']  ?><br><?php echo $ADocumento['sucursal']  ?><br><br>De mi consideración:<br><br><br><br>Por el presente solicito a usted comedidamente realizar la renovación de la siguiente póliza:<br>
</p>		
<table class="cabecera_conta">
  <tbody>
    <tr>
      <td width="10%" align="justify" valign="middle">Contratista</td>
      <td width="90%"><?php echo $ADocumento['razon']  ?></td>
    </tr>
    <tr>
      <td align="justify" valign="middle">Identificación</td>
      <td><?php echo $ADocumento['idprov']  ?></td>
    </tr>
    <tr>
      <td align="justify" valign="middle">Nro.Poliza</td>
      <td><?php echo $ADocumento['nro_poliza']  ?></td>
    </tr>
    <tr>
      <td align="justify" valign="middle">Ramo</td>
      <td><?php echo $ADocumento['tipo_poliza']  ?></td>
    </tr>
    <tr>
      <td align="justify" valign="middle">Valor</td>
      <td><?php echo $ADocumento['monto']  ?></td>
    </tr>
  </tbody>
</table>


 <p align="justify" style="font-size: 14px"><br>Por la atención que dén al presente, le agradezco.<br><br><br>
 Cordialmente,<br><br><br><br><br><?php echo $ADocumento['f10']  ?><br><?php echo $ADocumento['f11']  ?>
</p>	
<img width="80" height="80" src='logo_qr.png'/><br>			
<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $g->QR_Firma(); ?></span>	
 

</body>
</html>
<?php 
 
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "ComprobanteInventarios".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
 

?>