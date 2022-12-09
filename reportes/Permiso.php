<?php 
session_start();  
ob_start();	
require_once('tcpdf/tcpdf.php'); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		
$id 		    = trim($_GET['id']);
$datos 		    = $gestion->Permiso($id);
 
?>
<!DOCTYPE html>
<html>
	
<head lang="en">
	
<meta charset="UTF-8">

	
	
	
<?php 

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

  public function Footer() {
	  
  	   
	        $this->SetY(-20);
    
	  		$this->SetFont( 'times', '', 8 );
  	   
        	// Page number
	  		$this->Cell(0, 5, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	    
     
    }
}

	
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);

 
 
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

 $pdf->AddPage();
 $pdf->SetFont('Helvetica', '', 10, '', true);
 $pdf->writeHTMLCell($w = 0, $h = 5, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = false, $align = 'L', $autopadding = true);
 
 

 

$pdf->SetFont("", "", 10);
/*
//$PDF_HEADER_TITLE = $gestion->_Encabezado_firma() ;
$PDF_HEADER_STRING= trim( $gestion->_Cab('ciudad'))."-Ecuador";
$PDF_HEADER_LOGO = "logo.png"; 
$PDF_HEADER_LOGO_WIDTH = "20";
$PDF_HEADER_TITLE = "Documento Digital";
$PDF_HEADER_STRING = $gestion->_Cab('correo');
 
$pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
  */

// set margins
 $pdf->SetMargins(30, 15, 20);

 
// set auto page breaks
 $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



	
	?>
  
	
</head>	
	
	<style>
		
		.logo_header{
						border-collapse: collapse; 
					   /* border: 0px solid #AAAAAA; */
						font-size: 10px; 
						padding: 5px;
			}
		
		.eti_header1{
					 font-family: 'Helvetica Neue', Helvetica, Arial, 'sans-serif';
		    		 font-size: 10px; 
			}
		 .opensans{	 
 			 font-size: 12px; 
 			 padding: 2px;
			 font-weight: bold;
	  	}	
		
		.celda1{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
 			 font-size: 9px; 
 			 padding: 3px;
			 border-style: ridge; 
	  	}	
		
		.celda10{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
 			 font-size: 9px; 
		     font-weight:bold;
 			 padding: 3px;
			 border-style: ridge; 
	  	}	
	
		.celda21{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
 			 font-size: 8px; 
 			 padding: 3px;
			 border-style: ridge; 
	  	}	
		
		.celda22{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
 			 font-size: 7px; 
 			 padding: 3px;
			 border-style: ridge; 
	  	}	
	</style>
 
 
	
<body>
	 
    	
 	  
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tbody>
					<tr>
					  <td width="65%">&nbsp;</td>
					  <td width="35%">&nbsp;</td>
					</tr>
					<tr>
					  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
						  <tr>
						    <td width="9%" rowspan="4" valign="middle"  align="right"><img align="absmiddle"  src="barra.png" /></td>
						    <td width="91%" align="left">&nbsp;</td>
					      </tr>
						  <tr>
						    <td align="left" style="font-size:10px;color: #3E4CAD;"><b>DIRECCION DE TALENTO HUMANO</b></td>
					      </tr>
						  <tr>
						    <td align="left" style="font-size:10px;color: #3E4CAD;">SOLICITUD DE  
								<?php  
										if ( strtoupper(trim($_GET['tipoo'])) == 'VACACION') 
											echo 'VACACION';
										else
											echo 'PERMISO';	
								?></td>
					      </tr>
						  <tr>
						    <td align="left"><span style="font-weight: normal;font-size: 9px">
						      <?php   	echo 'CBSD'.str_pad($id, 5, "0", STR_PAD_LEFT) .'-'. $datos['anio']   ?>
						    </span></td>
					      </tr>
					    </tbody>
					  </table></td>
					  <td align="right" valign="top"><img  align="absmiddle"src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
					</tr>
					 
				  </tbody>
			</table>
 	
 		<div style="padding: 10px">
	
		   <table width="90%" border="0" cellspacing="0" cellpadding="0"  >
			  <tbody>
				<tr>
				  <td><?php  $gestion->cuerpo_permiso(trim($_GET['tipoo']),$datos);  ?></td>
				</tr>
			  </tbody>
			</table>
	
	   </div>
 
		 <br>
		 		 
	
		   <table style="font-size:10px;" width="100%">
			  <tbody>
				<tr>
				  <td> <?php      
				
					// BOMBEROS
					$cargo = trim($datos['tipo_cargo']);
							
 				  
			 
					if ( 	$cargo == 'B')	 {		
						
							if ( trim($datos['jefe']) == 1 ) {		
									$gestion->firma_reportes('TT-BE',$datos['idprov']); 
							}else {
								
								if ( trim($datos['jefe']) == 2 ) {		
									$gestion->firma_reportes('TT-OP',$datos['idprov']); 
								}else {
								
									$gestion->firma_reportes('TT-BB',$datos['idprov']); 
								}
							}
				   }else
						   if ( 	$cargo == 'A')	 {		
									$gestion->firma_reportes('TT-PD',$datos['idprov']); 
							}
							else{	
								
								if ( $datos['apoyo'] == 0 ) {	
									
										 $gestion->firma_reportes('TT-PA',$datos['idprov']); 
									
								  }	else 	 {
									
								 
								 
										 if (  trim($datos['apoyo_tipo']) == 1 ) {
											 $gestion->firma_reportes_apoyo('TT-PA',$datos['idprov'], $datos['apoyo_completo'], $datos['apoyo_cargo']) ; 
										  }	else{
											 
										 
											 
											 $gestion->firma_reportes_apoyo('TH-AA',$datos['idprov'], $datos['apoyo_completo'], $datos['apoyo_cargo']); 
										  }
									 
			 
																			
									}
							}	  
					 
 							 
				?></td>
				</tr>
			  </tbody>
			</table>
	
</html>
<?php 
  
 
	 
	
 $pdf->SetMargins(30, 15, 20);
	
$html = ob_get_contents();	
ob_end_clean();
$pdf->writeHTML ( $html , true , false , true , false , '' ) ; 

  
 
  $pdf->setPageMark();	  		 
	
 $pdf->Image('fondo_agua_logo.png', 30, 55, 140, 100, 'PNG', '', '', true, 300, '', false, false, 0, false, false, true);
 
 
$archivo = 'solicitud_permiso.pdf';

 

    
$pdf->Output($archivo,'I');
 

 
 
?>
