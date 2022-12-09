<?php 
session_start( );   
ob_start(); 
 
require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
$g  = 	new componente;

$codigo = $_GET["id"];

$dato = $g->Conciliar($codigo);

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
	
 
	
<table   width="100%">
  <tr>
    <td width="100%" colspan="2" class="titulo"><?php echo utf8_encode ($g->_getEmpresa('razon')); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="MensajeCab">PLATAFORMA DE GESTION DE ADMINISTRACION - FINANCIERA<br> MODULO FINANCIERO - CONCILIACION BANCARIA</td>
  </tr>
   
</table>
<?php 	
	
	
		
	$content = ' <h2 style="text-align:center;">'.'GESTION FINANCIERA CONCILIACION BANCARIA'.'</h2>
  			 
					 <table width="100%"  class="titulo"  border="0" cellpadding="0" cellspacing="3">
					  <tbody>
						<tr>
						  <td width="20%">Nro. Referencia</td>
						  <td width="80%">'.$dato['id_concilia'].' Periodo: '.$dato['mes'].'-'.$dato['anio'].'</td>
						</tr>
						<tr>
						  <td>Fecha</td>
						  <td>'.$dato['fecha'].'</td>
						</tr>
						<tr>
						  <td>Detalle</td>
						  <td>'.$dato['detalle'].'</td>
						</tr>
						<tr>
						  <td>Nombre Banco</td>
						  <td><strong>'.$dato['banco'].'</strong></td>
						</tr>
						<tr>
						  <td>Banco Cuenta</td>
						  <td><strong>'.$dato['cuenta'].'</strong></td>
						</tr>
						<tr>
						  <td>Estado</td>
						  <td>'.$dato['estado'].'</td>
						</tr>
					  </tbody>  
					</table>
					 
					  	  <h6> &nbsp; </h6>
			<table class="first" width="100%"  border="0" cellpadding="0" cellspacing="3">
		 <tr>
		   <td>SALDO BANCOS </td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['saldobanco'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(+) Notas Credito</td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['notacredito'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(-) Notas Debito</td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['notadebito'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(=) Saldo Conciliar</td>
		   <td bgcolor="#F4F4F4">0.00</td>
      </tr>
		 <tr>
		   <td>&nbsp;</td>
		   <td bgcolor="#F4F4F4">&nbsp;</td>
      </tr>
		 <tr>
		   <td>SALDO ESTADO CUENTA </td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['saldoestado'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(-) Cheques Girados/No girados</td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['cheques'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(+) Depositos en transito</td>
		   <td bgcolor="#F4F4F4">'. number_format($dato['depositos'],2,",",".").'</td>
      </tr>
		 <tr>
		   <td>(=) Saldo Conciliar</td>
		   <td bgcolor="#F4F4F4">0.00</td>
      </tr>
 		 </table>
		 
   ';
	
	echo $content;
?>	
	<table width="50%" border="0" cellspacing="0" cellpadding="0" style="font-size: 12px">
  <tbody>
    <tr>
      <td colspan="2"><b>MOVIMIENTO BANCARIO PERIODO</b></td>
    </tr>
    <tr>
      <td width="20%">INGRESOS</td>
      <td width="30%">$. <?php echo number_format($dato['debeb'],2) ?></td>
    </tr>
    <tr>
      <td width="20%">EGRESOS</td>
      <td  width="30%">$. <?php echo number_format($dato['haberb'],2) ?></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;  </p>	
  
	 <?php     $g->pie_rol('TT-CC', $datos['sesion']); ?>	
<p>&nbsp;  </p>	
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