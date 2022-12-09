<?php 
session_start( );   
ob_start(); 
require 'inventarios-factura.php';   /*Incluimos el fichero de la clase Db*/

$g  	 = 	new componente;

  
$fecha 	 = $_GET["fecha"];

 

$cajero  =  trim($_SESSION['email']);

$frubro   = trim($_GET["frubro"]);
 
$g->_get_caja();

$g->_cajero($cajero );

$g->QR_DocumentoDoc($cajero); 

	 
/*
$datos_parte = $g->parte_cierre($parte,$cajero ) ;

$fecha_caja  = $datos_parte["fecha_pago"];
*/
 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 
 <style type="text/css">
 
	body {
		font-size: 10px;
		color:#000;
	  /*  margin: 10mm 20mm 20mm 20mm;*/
	}

	.tableCabecera{
 	margin:3px 0 3px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
	width: 100%  
  	}
	 
	.tableForm{
 /*	margin:3px 0 3px 0; */
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
	 
	 table {
    border-collapse: collapse;
}

table, th, td {
   border: .40mm solid thin #909090;
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
	
		  <tbody>
			<tr>
			  <td width="15%" valign="top"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="85%" style="padding-left: 10px" valign="top"><?php echo $g->Empresa(); ?><br><br><?php echo $g->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $g->_Cab( 'direccion' ); ?><br><?php echo $g->_Cab( 'telefono' ); ?><br>Modulo RECAUDACIÓN<br>
				  CONTROL DE ESPECIES VALORADAS
				</td>
			</tr>
		  </tbody>
		</table>
	
	<h3>  	DETALLE DIARIO CONTROL DE ESPECIES VALORADAS	</h3>
	 
	 <h4>
		
		CAJA DEL DIA <?php echo $fecha ; ?><br>
		USUARIO <?php echo $g->_get_cajero('completo') ; ?><br><br>
 	     
		<?php echo $g->Especie_nombre($frubro,$fecha,$cajero) ; ?>
			 
	 </h4>

 
	
	
	<h4>  DETALLE DE COMPROBANTES EMTIDOS </h4>
	   <table  width="100%" style="font-size: 10px">
      <tbody>
        <tr>
          <td align="center" valign="middle">Fecha</td>
		  <td align="center" valign="middle">Identificacion</td>	
          <td align="center" valign="middle">Nombres</td>
	   	  <td align="center" valign="middle">Nro.Especie</td>
			  <td align="center" valign="middle">Pago</td>
		      <td align="center" valign="middle">Cantidad</td>	
              <td align="center" valign="middle">Total</td>
			</tr>
 		  <?php   $g->resumenClientes_especie($fecha,$cajero,$frubro);  ?>
       </tbody>
    </table> 
 
	
 <p align="justify" style="font-size: 14px">CERTIFICO: Que el efectivo y justificantes de caja arriba indicados, fueron verificados en mi presencia y devueltos a mi poder. No existiendo otros fondos,
valores o documentos en mi poder que no hayan sido mostrados en el reporte diario. </p>
	
 
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>	
	
<table class="tableFirmas" width="100%" >
  <tr>
    <td class="linea" >&nbsp; </td>
    <td class="linea" >&nbsp; </td>
  </tr>
  <tr>
    <td class="linea1" align="center" valign="middle">  </td>
    <td class="linea1" align="center" valign="middle"><?php echo $g->_get_cajero('completo') ; ?></td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">Supervisor de Recaudación</td>
    <td width="50%" class="linea1" align="center" valign="middle">Recaudador</td>
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

 
$filename = "Cierre_Caja".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 
 
		 
?> 