<?php 
	
session_start( );


require '../kconfig/Db.class.php';   

require '../kconfig/Obj.conf.php';  

	$obj     = 	new objects;
	$bd	   =	new Db ;
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


 $caso           	= $_GET['caso'];
 $process           = $_GET['process'];
 $doc           	= $_GET['doc'];
 
 $Empresa = $bd->query_array('view_registro',
								  'ruc_registro, razon, direccion, telefono, ciudad', 
								  'estado      ='.$bd->sqlvalue_inyeccion('S',true) 
								 ); 

 



   $ADocumento = $bd->query_array('view_proceso_doc_editor',
								  'idcasodoc, sesion, idproceso_docu, documento, asunto, tipodoc,  editor, fecha,anio,dia,mes,
								  	departamento_de, email_de, nombre_de, departamento_para, email_para, nombre_para', 
								  'idproceso      ='.$bd->sqlvalue_inyeccion($process,true). ' and 
								   idcaso         ='.$bd->sqlvalue_inyeccion($caso,true). ' and 
								   idproceso_docu ='.$bd->sqlvalue_inyeccion($doc,true)
								 ); 

		   
	require_once('tcpdf/tcpdf.php');
	
//	$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Kaipi');
	$pdf->SetTitle('Informe de gestion ');
	
	$pdf->setPrintHeader(true); 
	$pdf->setPrintFooter(true);

	

	
    $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
    $pdf->setHeaderMargin(2);
 
$pdf->SetHeaderData('', '0',  $Empresa['razon'], $Empresa['direccion'], array(0,64,255), array(0,64,128));
 



	// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
	// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	$pdf->SetMargins(20, 20, 20, false); 
	$pdf->SetAutoPageBreak(true, 30); 
	$pdf->SetFont('Helvetica', '', 10);
	$pdf->addPage();

    $mes = $bd->_mesc($ADocumento['mes']);
	


    $oficio = trim($ADocumento['tipodoc']) .'-'. $ADocumento['documento'] ;
		
    $fecha =  trim($Empresa['ciudad']).', '.$ADocumento['dia'].' de '. $mes.' del '.$ADocumento['anio'];
	
     $content ='<div class="col-md-12">
	 				<div align="right"><h5>'.$fecha .'<br>'.$oficio .'</h5></div>
 						
	 				<h5>De :'.$ADocumento['nombre_de'].'<br>'.$ADocumento['departamento_de'].'
 					</h5>
					<h5>Para :'.$ADocumento['nombre_para'].'<br>'.$ADocumento['departamento_para'].'
 					</h5>
	 			</div> ';

     $content .= '<div class="col-md-12">Asunto :'. $ADocumento['asunto'].'</div>';

     $content .= '<div class="col-md-12">'. $ADocumento['editor'].'</div>';
 

	 
	
	$pdf->writeHTML($content, true, 0, true, 0);

	$pdf->lastPage();
	
	 // I PARA VISUALIZAR
	//$pdf->output('Reporte.pdf', 'D');
 
    $nombre_archivo = utf8_decode("Documento" . date("d") . "_" . date("m") . "_" . date("Y") . ".pdf");

    $pdf->Output($nombre_archivo, 'D');


?>
	 