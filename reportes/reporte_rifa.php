<?php 
session_start( );   
ob_start(); 
 
require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/

$g  = 	new componente;

$codigo = $_GET["codigo"];

$_dato = $g->rifa($codigo);

 $g->QR_DocumentoDoc($codigo );
 
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
	 
 
 table.first {
        color: #000000;
        font-family: helvetica;
        font-size: 9pt;
        border-left: 1px solid #C4C4C4;
        border-right: 1px solid #C4C4C4;
        border-top: 1px solid #C4C4C4;
        border-bottom: 1px solid #C4C4C4;
        background-color: #ccffcc;
    }
	 table.titulo {
        color: #000000;
        font-family: helvetica;
        font-size: 9pt;
		font-weight: 100;
        border-left: 1px solid #C4C4C4;
        border-right: 1px solid #C4C4C4;
        border-top: 1px solid #C4C4C4;
        border-bottom: 1px solid #C4C4C4;
     }
	 
	 
 </style>
    
</head>

<body>
	
 
	 
<table   width="800px" >
  <tr>
    <td colspan="2"><p><img src="cabecera_ch.jpg" width="650" height="244"/></p></td>
  </tr>
  <tr>
    <td  align="left"   valign="middle">NRO. BOLETO DIGITAL: <b><?php echo $_dato["id_par_ti"]; ?></b> </td>
  </tr>
  <tr>
    <td  align="left" valign="middle">NRO.IDENTIFICACION: <?php echo $codigo ; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">CONTRIBUYENTE: <?php echo $_dato["razon"]; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">DIRECCION: <?php echo $_dato["direccion"]; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">TELEFONO: <?php echo $_dato["telefono"]; ?></td>
   </tr>
  <tr>
     <td  align="left" valign="middle">CORREO: <?php echo $_dato["correo"]; ?></td>
   </tr>
  <tr>
    <td colspan="2"  align="left" valign="middle"><img src="pie_ch.jpg" /></td>
  </tr>
	
</table>
<hr>	
	 
	
	<table   width="800px" >
  <tr>
    <td colspan="2">ZONA EXCLUSIVA PARA EL SORTEO</td>
  </tr>
  <tr>
    <td  align="left"   valign="middle">NRO. BOLETO DIGITAL: <b><?php echo $_dato["id_par_ti"]; ?></b> </td>
  </tr>
  <tr>
    <td  align="left" valign="middle">NRO.IDENTIFICACION: <?php echo $codigo ; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">CONTRIBUYENTE: <?php echo $_dato["razon"]; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">DIRECCION: <?php echo $_dato["direccion"]; ?></td>
   </tr>
  <tr>
    <td  align="left" valign="middle">TELEFONO: <?php echo $_dato["telefono"]; ?></td>
   </tr>
  <tr>
     <td  align="left" valign="middle">CORREO: <?php echo $_dato["correo"]; ?></td>
   </tr>
 
</table>
	
	
<p>&nbsp;  </p>	
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
$filename = "Conciliacion".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>