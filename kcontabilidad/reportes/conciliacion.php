<?php 
session_start( );  
include('phpqrcode/qrlib.php'); 
	$content = $_SESSION['ruc_registro'];
    $name = $_SESSION['razon'] ; 
    $elaborador = $_SESSION['login']; 
    $sesion = $_SESSION['email'];
     
    // we building raw data 
    $codeContents  .= 'Comprobante Financiero'."\n"; 
    $codeContents .= $name."\n"; 
	$codeContents .= 'Elaborado '.$elaborador."\n"; 
    $codeContents .= 'https://g-kaipi.com/'."\n"; 

 
 
QRcode::png($codeContents,"documento.png",QR_ECLEVEL_L,10,2);

ob_start(); 
 require('kreportes.php'); 
$gestion   		= 	new ReportePdf; 		 
$idasiento 		= $_GET['id'];
$datos 			=	$gestion->Conciliacion($idasiento);
?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

 
	
	 <link rel="stylesheet" href="impresion.css" />
	
	
	<style>
	 table.first {
        color: #003300;
        font-family: helvetica;
        font-size: 8pt;
        border-left: 1px solid #C4C4C4;
        border-right: 1px solid #C4C4C4;
        border-top: 1px solid #C4C4C4;
        border-bottom: 1px solid #C4C4C4;
        background-color: #ccffcc;
    }
	</style>
	 
</head>		
<body>
  
<table>
			    <tr bgcolor=#ECECEC><td width="100%" colspan="4" align="center" style="font-size: 10px"><?php echo $gestion->Empresa(); ?></td> </tr>
			    <tr bgcolor=#ECECEC>
			      <td colspan="4" align="center" style="font-size: 10px">CONCILIACION BANCARIA</td> </tr>
				<tr bgcolor=#ECECEC> <td class="solid" colspan="4"  style="font-size: 9px">Nro Transaccion <?php echo $idasiento ?></td></tr>
				<tr > <td  class="solid"   colspan="4" style="font-size: 9px"><?php echo $datos['detalle'] ?></td> </tr>
			
 </table>
	
	 <table  style="font-size: 10px">
					  <tbody>
						<tr>
						  <td width="20%">Nro. Referencia</td>
						  <td width="80%"><?php echo $datos['id_concilia'].' Periodo: '.$datos['mes'].'-'.$datos['anio'] ?> </td>
						</tr>
						<tr>
						  <td>Fecha</td>
						  <td><?php echo $datos['fecha'] ?></td>
						</tr>
						 
						<tr>
						  <td><strong>Banco Cuenta</strong></td>
						  <td><?php echo $datos['cuenta'] .' '.  $datos['banco'] ?></td>
						</tr>
						<tr>
						  <td>Estado</td>
						  <td><?php echo $datos['estado'] ?></td>
						</tr>
	   </tbody>  
</table>
	<p></p>
<table class="first" width="100%"  border="0" cellpadding="0" cellspacing="3">
		 <tr>
		   <td>SALDO BANCOS </td>
		   <td bgcolor="#F4F4F4"><?php echo number_format($datos['saldobanco'],2,",",".")  ?></td>
      </tr>
		 <tr>
		   <td>(+) Notas Credito</td>
		   <td bgcolor="#F4F4F4"><?php echo  number_format($datos['notacredito'],2,",",".")  ?></td>
      </tr>
		 <tr>
		   <td>(-) Notas Debito</td>
		   <td bgcolor="#F4F4F4"><?php echo  number_format($datos['notadebito'],2,",",".")  ?></td>
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
		   <td bgcolor="#F4F4F4"><?php echo  number_format($datos['saldoestado'],2,",",".") ?></td>
      </tr>
		 <tr>
		   <td>(-) Cheques,Documentos Girados/No Efectivizados</td>
		   <td bgcolor="#F4F4F4"><?php echo  number_format($datos['cheques'],2,",",".") ?></td>
      </tr>
		 <tr>
		   <td>(+) Depositos en transito</td>
		   <td bgcolor="#F4F4F4"><?php echo  number_format($datos['depositos'],2,",",".")  ?></td>
      </tr>
		 <tr>
		   <td>(=) Saldo Conciliar</td>
		   <td bgcolor="#F4F4F4">0.00</td>
      </tr>
 		 </table>
 <p></p>
 <p></p>
 <p></p>
 <p></p>
 <p></p>
 <p></p>	
 	<table>
					<tr>
					  <td class="solid"   style="padding-bottom: 30px">&nbsp;</td>
					  <td class="solid"  style="padding-bottom: 30px">&nbsp;</td>
				    </tr>
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle"><?php echo $datos['elaborado'] ?></td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle"><?php echo $datos['t10'] ?></td>
	  </tr>
					<tr>
					  <td rowspan="2" align="center" valign="middle" class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px">Elaborado </td>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle"><?php echo $datos['t11'] ?></td>
	  </tr>
					<tr>
					  <td class="solid"  style="padding-bottom: 5px; padding-top: 5px;font-size: 8px" align="center" valign="middle">Autorizado</td>
				    </tr>
				</table>
<p></p>
 <p></p>	
  <p style="font-size: 8px;color: #7B7B7B">Documento digital generado <?php echo trim($_SESSION['email']) ?></p>
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
$filename = "ComprobanteAsiento".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
 
?>
