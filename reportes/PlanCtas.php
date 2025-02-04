<?php 
	
session_start( );


require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

	$obj     = 	new objects;
	$bd	   =	new Db ;
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


	$usuario = "SELECT  cuenta, cuentas, detalle, nivel,  univel, aux 
				FROM co_plan_ctas  
				where registro = '". $_SESSION['ruc_registro']."'
				order by cuenta";	



	$usuarios=$bd->ejecutar($usuario);


 
	$AResultado = $bd->query_array('web_registro','razon', 
								   'ruc_registro='.$bd->sqlvalue_inyeccion($_SESSION['ruc_registro'],true)
								  ); 


 
	require_once('tcpdf/tcpdf.php');
	
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	
	$pdf->SetCreator(PDF_CREATOR);

	$pdf->SetAuthor('Kaipi');


    $titulo = 'Plan de Cuentas '.trim($_SESSION['ruc_registro']);
		
    $pdf->SetTitle( $titulo);
	
	$pdf->setPrintHeader(true); 
	$pdf->setPrintFooter(true);
	


	$pdf->SetHeaderData('', '0',  $AResultado['razon'], 'Contabilidad');
	
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
            	<h1 style="text-align:center;">'.'Plan de cuentas'.'</h1>
       	
      <table border="1" cellpadding="3">
        <thead>
          <tr>
            <th width="15%">Cuenta</th>
            <th width="15%"> - </th>
            <th width="40%">Detalle Cuenta</th>
            <th width="10%">Nivel</th>
            <th width="10%">Transaccion</th>
            <th width="10%">Auxiliar</th>
          </tr>
        </thead>
	';
 
	while ($user=$bd->obtener_fila($usuarios)){
		
			if($user['univel']=='S'){  $color= '#dedddd'; }else{ $color= '#fbf7f7'; }

		$content .= ' <tr bgcolor="'.$color.'">
            <td width="15%">'.trim($user['cuenta']).'</td>
            <td width="15%">'.trim($user['cuentas']).'</td>
            <td width="40%">'.trim($user['detalle']).'</td>
            <td width="10%">'.trim($user['nivel']).'</td>
            <td width="10%">'.trim($user['univel']).'</td>
            <td width="10%">'.trim($user['aux']).'</td>
        </tr>
	';
	}
	
	$content .= '</table>';
	
	 
	
	$pdf->writeHTML($content, true, 0, true, 0);

	$pdf->lastPage();
	
	 // I PARA VISUALIZAR
	$pdf->output('PlanCuentas.pdf', 'D');
 

?>
	 