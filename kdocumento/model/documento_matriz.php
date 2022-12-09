<?php 
session_start();  
ob_start();	
require_once('tcpdf/tcpdf.php'); 
require('kreportes.php'); 
$caso           	= $_GET['caso'];
$process            = $_GET['process'];
$doc           	    = $_GET['doc'];

$gestion   		= 	new ReportePdf; 	
$ADocumento 	=   $gestion->Documento_Proceso_user($caso,$process,$doc  );
$mes 			=   $gestion->conocer_mes($ADocumento['mes']);
$razon			=   $gestion->Empresa();
$nombre_usuario =   $gestion->UserFirma();
$archivo		=   $gestion->_Cab('archivo');
$unidad			=   $gestion->_Cab('depa');
$clave          =   $gestion->_Cab('acceso1');

 $gestion->QR_Documento();
	
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);


 $pdf->SetDefaultMonospacedFont('times');  
 
$info = array(
            'Name' => $razon,
            'Location' => $gestion->_Cab('ciudad'),
            'Reason' => $gestion->_Cab('razon'),
            'ContactInfo' =>$gestion->_Cab('correo')
);
        

$certificate =  'file://'.realpath('./'.$archivo);
$primaryKey =  'file://'.realpath('./'.$archivo);

$pdf->SetMargins(20, 15, 20, true);
$pdf->AddPage();

 $pdf->SetFont('times', '', 12, '', true);

 
 
 $html =   $gestion->_Encabezado_1();

//$pdf->writeHTMLCell($w = 0, $h = 50, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = false, $align = 'C', $autopadding = true);
// $pdf->setPageMark();

$pdf->SetFont("", "", 11);
$PDF_HEADER_TITLE = $gestion->_Encabezado_firma() ;
$PDF_HEADER_STRING= trim( $gestion->_Cab('ciudad'))."-Ecuador";
   


$PDF_HEADER_LOGO = "logo.png";//any image file. check correct path.
$PDF_HEADER_LOGO_WIDTH = "20";
$PDF_HEADER_TITLE = "Documento Digital";
$PDF_HEADER_STRING = $gestion->_Cab('correo');

$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);


 
//$pdf->SetHeaderData($PDF_HEADER_LOGO,'',  $PDF_HEADER_TITLE, $PDF_HEADER_STRING);

$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
  
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">

</head>		
<body>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="68%">&nbsp;</td>
      <td  width="32%"rowspan="4"><img src="logo_encabezado.png"/></td>
    </tr>
    <tr>
      <td style="font-size: 16px"><b>DIRECCION DE</b> </td>
    </tr>
    <tr>
      <td style="font-size: 14px"><b>PLANIFICACION Y GESTION ESTRATEGICA</b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>

	
 	   <div align="right" style="font-size: 11px"> 
		  <?php   echo   $ADocumento['documento'] ?><br><?php  echo trim($gestion->_Cab( 'ciudad' )).', '.$ADocumento['dia'].' de '. $mes.' del '.$ADocumento['anio'] ?>
		   
	   </div>	
	
<div  align="justify" style="font-size:11px;font-family: Times"> 
 				  <?php   $Documento  = $ADocumento['editor'];
						  echo $Documento;
				 ?>
	   </div>	   
</body>	
</html>
<?php 


$html = ob_get_clean() ; 

$pdf->writeHTML ( $html , true , false , true , false , '' ) ; 

 /*
$pdf->setSignature($certificate, $primaryKey,  $clave , '', 2, $info);

$mensaje =  $nombre_usuario;
$mensaje1 = 'Firma Electronica';
$mensaje2 =  $unidad;
$mensaje3 =  date("Y-m-d H:i");

$lheight = $pdf->GetY() - 10;
  

$pdf->Image('logo_qr.png', 10, $lheight, 20, 20, 'PNG');
 
$font = 'courier';
$pdf->SetFont($font, '', 7, '', false);
$pdf->Text(30, $lheight + 4, $mensaje);
$pdf->Text(30, $lheight + 7 , $mensaje1);
$pdf->Text(30, $lheight + 10, $mensaje2);
$pdf->Text(30, $lheight + 13, $mensaje3);
 

$pdf->SetTextColor(131,126,126);

$pie1 = $gestion->pie_cliente_firma_ec(1);
$pie2 = $gestion->pie_cliente_firma_ec(2);
$pdf->Text(5, $lheight + 20, $pie1);
$pdf->Text(5, $lheight + 23, $pie2);

*/

//$pdf->setSignatureAppearance(10, $lheight, 50, 25);

 
 
$pdf->Output(trim($ADocumento['documento']).'.pdf', 'I');
 
?>
