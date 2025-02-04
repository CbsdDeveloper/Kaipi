<?php 
	
session_start( );


require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

	$obj     = 	new objects;
	$bd	   =	new Db ;
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


	$usuario = 'SELECT id_movimiento, fechaa, detalle, comprobante, estado, tipo, idprov, identificacion, razon, correo, idproducto, cantidad, costo, total, unidad, producto, ingreso, egreso, anio, mes, idcategoria
FROM view_mov_aprobado';	
 


	$usuarios=$bd->ejecutar($usuario);
 
	require_once('tcpdf/tcpdf.php');
	
	$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Miguel Caro');
	$pdf->SetTitle($_POST['reporte_name']);
	
	$pdf->setPrintHeader(true); 
	$pdf->setPrintFooter(true);
	
	$pdf->SetHeaderData('', '0',  'dsdsdsd 021', 'hola');
	
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
	$pdf->SetAutoPageBreak(true, 20); 
	$pdf->SetFont('Helvetica', '', 7);
	$pdf->addPage();

	$content = '';
	
	$content .= '
		<div class="row">
        	<div class="col-md-12">
            	<h1 style="text-align:center;">'.$_POST['reporte_name'].'</h1>
       	
      <table border="1" cellpadding="3">
        <thead>
          <tr>
            <th width="10%">DNI</th>
            <th width="30%">A. PATERNO</th>
            <th width="30%">A. MATERNO</th>
            <th width="10%">NOMBRES</th>
            <th width="10%">AREA</th>
            <th width="10%">SUELDO</th>
          </tr>
        </thead>
	';
 
	
	while ($user=$bd->obtener_fila($usuarios)){
			if($user['modulo']=='P'){  $color= '#f5f5f5'; }else{ $color= '#fbb2b2'; }
	$content .= '
		<tr bgcolor="'.$color.'">
            <td width="10%">'.trim($user['idprov']).'</td>
            <td width="30%">'.trim($user['razon']).'</td>
            <td width="30%">'.trim($user['producto']).'</td>
            <td width="10%">'.trim($user['fechaa']).'</td>
            <td width="10%">'.trim($user['comprobante']).'</td>
            <td width="10%">'.trim($user['total']).'</td>
        </tr>
	';
	}
	
	$content .= '</table>';
	
	$content .= '
		<div class="row padding">
        	<div class="col-md-12" style="text-align:center;">
            	<span>Pdf Creator </span><a href="http://www.redecodifica.com">By Miguel Angel</a>
            </div>
        </div>
    	
	';
	
	$pdf->writeHTML($content, true, 0, true, 0);

	$pdf->lastPage();
	
	 // I PARA VISUALIZAR
	$pdf->output('Reporte.pdf', 'D');
 

?>
	 