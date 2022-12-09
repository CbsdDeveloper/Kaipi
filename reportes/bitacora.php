<?php 
session_start( );   
ob_start(); 
require 'inventarios-factura.php';   /*Incluimos el fichero de la clase Db*/

$g  	 = 	new componente;
 
$id  = trim($_GET["id"]);
 

 
	 
$datos_parte = $g->bitacora_informe($id  ) ;
 

 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 
 <style type="text/css">
 
	body {
		font-size: 9px;
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
 	 font-size: 12px;
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
				  <?php echo $g->_Cab( 'direccion' ); ?><br><?php echo $g->_Cab( 'telefono' ); ?><br>MODULO GESTION BOMBEROS<br>
				  CONTROL DE BITACORA
			  </td>
			</tr>
		  </tbody>
		</table>
	
	  <br>
<table class="cabecera_font">
  <tbody>
    <tr>
      <td width="15%" style="padding: 5px">Nro.Bitacora</td>
      <td width="35%" style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['documento']; ?></span></td>
      <td width="15%" style="padding: 5px">Unidad/Estacion</td>
      <td width="35%" style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['unidad']; ?></span></td>
    </tr>
    <tr>
      <td style="padding: 5px">Peloton</td>
      <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['peloton']; ?></span></td>
      <td style="padding: 5px">Estado</td>
      <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['estado']; ?></span></td>
    </tr>
    <tr>
      <td style="padding: 5px">Nombre</td>
      <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['completo']; ?></span></td>
      <td style="padding: 5px">Cargo</td>
      <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['cargo']; ?></span></td>
    </tr>
	  <tr>
	    <td style="padding: 5px">Fecha</td>
	    <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['fecha']; ?></span></td>
	    <td style="padding: 5px">Periodo</td>
	    <td style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['anio']; ?></span></td>
    </tr>
	  <tr>
      <td style="padding: 5px">Novedad/Detalle</td>
      <td colspan="3" style="padding: 5px"><span style="padding-left: 10px"><?php echo $datos_parte['novedad']; ?></span></td>
    </tr>
  </tbody>
</table>

		 
 
 <h4>  PERSONAL DE TURNO </h4>
	
	<?php 	$g->bitacora_personal( $id  ) ; ?>

	
<h4> ACTIVIDADES DESARROLLADAS</h4>
	
	<?php 	$g->bitacora_actividad( $id  ) ; ?>
  
<h4> PARQUE AUTOMOTOR DE LA UNIDAD/ESTACION </h4>
	 
		<?php 	$g->bitacora_carros( $id  ) ; ?>
	
<h4> REPARACION/ EQUIPOS, HERRAMIENTAS</h4>
	  
 	<?php 	$g->bitacora_herramientas( $id  ) ; ?>
	
	
		
<h4> EVIDENCIA FOTOGRAFICA</h4>
	
	<p>
 
		<img src="<?php   echo $datos_parte['foto']; ?>" width="350" height="290" alt=""/>
		
  </p>
	
<p>&nbsp;</p>
 
	
<table class="tableFirmas" width="100%" >
   
  <tr>
    <td class="linea1" align="center" valign="middle">&nbsp; </td>
    <td class="linea1" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">Elaborado</td>
    <td width="50%" class="linea1" align="center" valign="middle">Autorizado</td>
  </tr>
	
</table>

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
 
 
$filename = "Bitacora".time().'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 
 
		 
?> 