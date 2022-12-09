<?php 
session_start( );  
ob_start(); 
require_once('tcpdf/tcpdf.php'); 
require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$id 		    =   $_GET['id'];

$datos 		    =  	$gestion->solicitud_anticipo($id);
					  	

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

 
 

 $pdf->AddPage();
 $pdf->SetFont('Helvetica', '', 10, '', true);
 $pdf->writeHTMLCell($w = 0, $h = 5, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = false, $align = 'L', $autopadding = true);
 
 

 

$pdf->SetFont("", "", 10);
 

// set margins
 $pdf->SetMargins(30, 15, 20, true);

 
// set auto page breaks
 $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 

?>
</head>	
	
 
	
<body>
	 
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
	
	
	<table width="90%" border="0" cellspacing="0" cellpadding="0"  >
			  <tbody>
				<tr>
				  <td>

					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="70%">&nbsp;</td>
								  <td width="30%" rowspan="2" align="right">
								  <img align="absmiddle" src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
								</tr>
								<tr>
								  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tbody>
									  <tr>
										<td width="9%" rowspan="4" valign="middle"  align="right">
											<img align="absmiddle"  src="barra.png" /></td>
										<td width="91%" align="left">&nbsp;</td>
									  </tr>
									  <tr>
										<td align="left" style="font-size:11px;color: #3E4CAD;font-family:Helvetica, Arial"><b>DIRECCION DE TALENTO HUMANO</b></td>
									  </tr>
									  <tr>
										<td align="left" style="font-size:9px;color: #3E4CAD;font-family:Helvetica, Arial">SOLICITUD DE ANTICIPO DE REMUNERACION</td>
									  </tr>
									  <tr>
										<td align="left"><span style="font-weight: normal;font-size: 8px">
										  <?php   	echo   trim($datos['documento'])   ?>
										</span></td>
									  </tr>
									</tbody>
								  </table></td>
								</tr>

							  </tbody>
				</table>


					</td>
				</tr>
				<tr>
				  <td style="font-size:8px" align="right">Fecha Solicitud: <?php     echo $datos['fecha_completa']; ?> </td>
				</tr>
				<tr>
				  <td> <?php echo  $datos['contenido'];
					  ?></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>  
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="70%">&nbsp;</td>
								  <td width="30%" rowspan="2" align="right">
								  <img align="absmiddle" src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="120" height="90"></td>
								</tr>
								<tr>
								  <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tbody>
									  <tr>
										<td width="9%" rowspan="4" valign="middle"  align="right">
											<img align="absmiddle"  src="barra.png" /></td>
										<td width="91%" align="left">&nbsp;</td>
									  </tr>
									  <tr>
										<td align="left" style="font-size:11px;color: #3E4CAD;font-family:Helvetica, Arial"><b>DIRECCION DE TALENTO HUMANO</b></td>
									  </tr>
									  <tr>
										<td align="left" style="font-size:9px;color: #3E4CAD;font-family:Helvetica, Arial">SOLICITUD DE ANTICIPO DE REMUNERACION</td>
									  </tr>
									  <tr>
										<td align="left"><span style="font-weight: normal;font-size: 8px">
										  <?php   	echo   trim($datos['documento'])   ?>
										</span></td>
									  </tr>
									</tbody>
								  </table></td>
								</tr>

							  </tbody>
				</table></td>
				</tr>
				<tr>
				  <td><?php     echo  $datos['contenido2']; ?></td>
				</tr>
			  </tbody>
		
</table>

 
 
 
	
</html>
<?php 
 
$html = ob_get_contents();	
ob_end_clean();

$pdf->writeHTML ( $html , true , false , true , false , '' ) ; 

$pdf->setPageMark();	  		 

$pdf->Image('fondo_agua_logo.png', 30, 55, 140, 100, 'PNG', '', '', true, 300, '', false, false, 0, false, false, true);
 
 
$archivo = 'solicitud_anticipo.pdf';

    
$pdf->Output($archivo,'I'); 

 
?>
