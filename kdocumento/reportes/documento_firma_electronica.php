<?php
session_start();  

set_time_limit(0);

ini_set("memory_limit",-1);

ini_set('max_execution_time', 0);

ob_start();	

require('kreportes.php'); 
$caso           	= $_GET['caso'];
$process            = $_GET['process'];
$doc           	    = $_GET['doc'];
$tipo				= trim($_GET['tipo']);
	
$gestion   		= 	new ReportePdf; 	

$gestion->QR_Documento();

$ADocumento 	=   $gestion->Documento_Proceso_user($caso,$process,$doc  );
$mes 			=   $gestion->conocer_mes($ADocumento['mes']);
$razon			=   $gestion->Empresa();
$nombre_usuario =   $gestion->UserFirma();
$unidad			=   $gestion->_Cab('depa');

$archivo_pem   =   $gestion->_Cab('archivo');
$cert_password =   $gestion->_Cab('acceso1');


$ciudad = 	trim($gestion->_Cab( 'ciudad' ));
$ciudad = 	strtolower($ciudad);
$ciudad = 	ucwords($ciudad);

$dia    =   $ADocumento['dia'].' de '. $mes.' del '.$ADocumento['anio'];
$doc    = 	'<b>'.trim($ADocumento['documento']) .'</b><br>'.$ciudad.','.$dia ;
$depa   = strtolower($ADocumento['departamento_de']);


$mensaje =  $nombre_usuario;
$mensaje1 = 'Firma Electronica';
$mensaje2 =  $unidad;
$mensaje3 =  date("Y-m-d H:i");
 

$url =  $gestion->_carpeta(); // path archivos
 
$archivopdf =  trim($url).trim($ADocumento['documento']).'.pdf';     

$htmlEncabezado=   $gestion->_Encabezado_1(trim( $depa),$doc);

$_SESSION['cabeza_contenido']  = $htmlEncabezado  ;

$htmlpie 		=   $gestion->_pie_documento();

require_once('tcpdf/tcpdf.php');

   

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	
 		 public function Header() {

						$this->SetY(15);

						$this->SetFont( 'times', '', 8 );

						$htmlcabe = $_SESSION['cabeza_contenido'] ;

						$this->writeHTML($htmlcabe, true, 0, true, 0);

				}
 	
			   public function Footer() {

						$this->setPageMark();

						$this->Image('pie_pagina.png', 0, 200, 210, 100, 'PNG');

						$this->SetY(-24);

						$this->SetFont( 'times', '', 8 );

						$htmlpie = $_SESSION['pie_contenido'] ;

						$this->writeHTML($htmlpie, true, 0, true, 0);

				   		$this->SetFont( 'times', '', 8 );
						// Page number
						$this->Cell(0, 5, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

				}
}

	
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
 

 $pdf->SetMargins(30, 60, 20);
 $pdf->AddPage();
 $pdf->SetFont('times', '', 12, '', true);
 

	$pdf->SetFont("", "", 11);

	$PDF_HEADER_TITLE = $gestion->_Encabezado_firma() ;
	$PDF_HEADER_STRING= trim( $gestion->_Cab('ciudad'))."-Ecuador";
	$PDF_HEADER_LOGO = "logo.png"; 
	$PDF_HEADER_LOGO_WIDTH = "20";
	$PDF_HEADER_TITLE = "Documento Digital";
	$PDF_HEADER_STRING = $gestion->_Cab('correo');

	$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
 
 // set margins
 
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

 $info = array(
            'Name' => 'Institucion',
            'Location' => $ciudad,
            'Reason' => 'Documental',
            'ContactInfo' => 'http://www.gk-innova.com',
        );
        
 
 

$certificate =  'file://'.realpath('./'. $archivo_pem);

$primaryKey =  'file://'.realpath('./'. $archivo_pem);

 

?>
<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
</head>		
<body>
 		   <div  align="justify" style="font-size:11px;font-family: Times;" > 
 				  <?php   echo $ADocumento['editor']; ?>
	      </div>	 
</body>	
</html>
<?php 

$html = ob_get_contents();	

ob_end_clean(); 
 
$pdf->writeHTML ( $html , true, 0, true, 0);
 
$lheight = $pdf->GetY() - 10;

$pdf->setSignature($certificate, $primaryKey,  $cert_password, '', 2, $info);


 
$pdf->Image('logo_qr.png', 30, $lheight, 18, 18, 'PNG');
 
$font = 'courier';
$pdf->SetFont($font, '', 7, '', false);
$pdf->Text(47, $lheight + 4, $mensaje);
$pdf->Text(47, $lheight + 7, $mensaje2);
$pdf->Text(47, $lheight + 10, $mensaje3);
  
$pdf->setSignatureAppearance(5, $lheight, 50, 25);


 $pdf->Output($archivopdf, 'FI');

//$pdf->Output($archivopdf, 'I');


 
 
///-------------------------------------------
 
?>