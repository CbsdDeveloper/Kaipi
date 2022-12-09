<?php 
session_start( );   
ob_start(); 
require 'inventarios.php';    

$g  			= 	new componente;

$codigo 		=   trim($_GET["id"]);

$empleado 		=   $g->FichaNomina($codigo);

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
	border: .20mm solid thin #909090;
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
	padding-bottom: 7px;
 	color:#000000;
		 background: #D7D7D7;
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
		  <tbody>
			<tr>
			  <td width="15%" valign="top"><img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
			  <td width="85%" style="padding-left: 10px" valign="top"><?php echo $g->Empresa(); ?><br><br><?php echo $g->_Cab( 'ruc_registro' ); ?><br>
				  <?php echo $g->_Cab( 'direccion' ); ?><br><?php echo $g->_Cab( 'telefono' ); ?><br>Modulo Talento Humano<br>
				  FICHA PERSONAL 
			  </td>
			</tr>
		  </tbody>
		</table>
	
<table border="0" cellpadding="0" cellspacing="0" class="tableCabecera">
  <tr>
    <td colspan="4" align="center" valign="middle"><img src="<?php echo '../archivos/user/'.trim($empleado['foto']) ?>" width="120" height="150" alt=""/></td>
  </tr>
  <tr>
    <td colspan="4" class="Mensaje1">INFORMACION PERSONAL</td>
  </tr>
  <tr>
    <td class="Mensaje">Identificacion</td>
    <td width="34%" class="Mensaje"><?php echo  trim($empleado['idprov']); ?></td>
    <td width="26%" align="right" valign="middle" class="Mensaje">Fecha Ingreso</td>
    <td width="27%" class="Mensaje"><?php echo  trim($empleado['fecha']); ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Funcionario</td>
    <td colspan="3" class="Mensaje"><?php echo  trim($empleado['razon']); ?>  </td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Direccion</td>
    <td colspan="3" class="Mensaje"><?php echo  trim($empleado['direccion']);?></td>
  </tr>
  <tr>
    <td class="Mensaje">Telefono</td>
    <td class="Mensaje" ><?php  echo  trim($empleado['telefono']);  ?></td>
    <td class="Mensaje" align="right" >Telefono Movil</td>
    <td class="Mensaje" ><?php  echo  trim($empleado['movil']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Email</td>
    <td class="Mensaje" ><?php  echo  trim($empleado['correo']);  ?></td>
    <td class="Mensaje" align="right" >Ciudad</td>
    <td class="Mensaje" ><?php  echo  trim($empleado['ciudad']);  ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Nacionalidad</td>
    <td class="Mensaje" ><?php  echo  trim($empleado['nacionalidad']);  ?></td>
    <td class="Mensaje" align="right" >Fecha nacimiento</td>
    <td class="Mensaje" ><?php echo  trim($empleado['fechan']); ?></td>
  </tr>
  <tr>
    <td colspan="4" class="Mensaje1">INFORMACION LABORAL</td>
  </tr>
  <tr>
    <td class="Mensaje">Unidad</td>
    <td class="Mensaje"><?php  echo  trim($empleado['unidad']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Programa</td>
    <td class="Mensaje"><?php  echo  trim($empleado['programa']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Regimen</td>
    <td class="Mensaje"><?php  echo  trim($empleado['regimen']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Cargo</td>
    <td class="Mensaje"><?php  echo  trim($empleado['cargo']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Sueldo/Remuneracion</td>
    <td class="Mensaje"><?php  echo  trim($empleado['sueldo']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">&nbsp;</td>
    <td class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="Mensaje1">INFORMACION ADICIONAL</td>
  </tr>
  <tr>
    <td class="Mensaje">Genero</td>
    <td class="Mensaje"><?php  echo  trim($empleado['genero']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">&nbsp;</td>
    <td class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td class="Mensaje">Estado Civil</td>
    <td class="Mensaje"><?php  echo  trim($empleado['ecivil']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Etnia</td>
    <td class="Mensaje"><?php  echo  trim($empleado['etnia']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Cargas Familiares</td>
    <td class="Mensaje"><?php  echo  trim($empleado['cargas']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Vive con</td>
    <td class="Mensaje"><?php  echo  trim($empleado['vivecon']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Tipo Sangre</td>
    <td class="Mensaje"><?php  echo  trim($empleado['tsangre']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">&nbsp;</td>
    <td class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td class="Mensaje">Nivel Estudio</td>
    <td class="Mensaje"><?php  echo  trim($empleado['estudios']);  ?></td>
    <td align="right" valign="middle" class="Mensaje"><label>Titulo Obtenido</label>
    <br></td>
    <td class="Mensaje"><?php  echo  trim($empleado['titulo']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Carrera</td>
    <td class="Mensaje"><?php  echo  trim($empleado['carrera']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">&nbsp;</td>
    <td class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="4" class="Mensaje1">INFORMACION FINANCIERA</td>
  </tr>
  <tr>
    <td class="Mensaje">Nro.Cuenta</td>
    <td class="Mensaje"><?php  echo  trim($empleado['codigo_banco']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Tipo de Cuenta</td>
    <td class="Mensaje"><?php  echo  trim($empleado['tipo_cuenta']);  ?></td>
  </tr>
  <tr>
    <td class="Mensaje">Banco</td>
    <td class="Mensaje"><?php  echo  trim($empleado['banco']);  ?></td>
    <td align="right" valign="middle" class="Mensaje">Codigo Banco</td>
    <td class="Mensaje"><?php  echo  trim($empleado['nro_banco']);  ?></td>
  </tr>
</table>
	
<h4>&nbsp; </h4>
 
 

<p>&nbsp;</p>
 
	 
 
	
<p></p>
 <p></p>		
<table>
					<tr>
					  <td   style="padding-bottom: 30px">&nbsp;</td>
				    </tr>
	
					<tr>
					  <td   style="font-size: 8px" align="left" valign="middle"><?php echo $datos['elaborado'] ?></td>
				   </tr>
	
					<tr>
					    <td   style="font-size: 8px" align="left" valign="middle"><?php echo $datos['unidad'] ?></td>
				    </tr>
	
					 
 </table>
 	
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
$filename = "FichaNomina.pdf";

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));

 

?>