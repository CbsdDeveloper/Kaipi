<?php 
session_start();  
ob_start();	
require_once('tcpdf/tcpdf.php'); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$id 		    = trim($_GET['id']);

$datos 		    = $gestion->Delegacion($id);
 
 
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
 $pdf->SetMargins(30, 15, 30, true);

 
// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



	
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
 
 	  
	   <table width="100%" class="logo_header" >
		  <tbody>
			<tr>
			   
				 <td width="40%"  class="eti_header1"><br>
				   DIRECCION DE TALENTO HUMANO <br>
			    DELEGACION DE PERSONA<br> 
		        Fecha:<?php echo $datos['fecha'] ?> <br>
			    </td>
		        <td width="35%"   style="padding: 5px">
				    <?php // echo $gestion->Empresa(); ?><br>
 				</td>
 				 <td width="25%" >
				  <img align="absmiddle" src="logo.png">
				</td>
		      </tr>
		  </tbody>
		</table>
 	
 
	
           <table style="font-size:10px;" width="100%">
			  <tr>
					  <td>
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td colspan="2"  align="center" class="opensans">DELEGACIÓN DE PERSONAL</td>
							    </tr>
								<tr>
								  <td width="50%" class="celda1"  align="center">DELEGACIÓN DE PERSONAL NO. <?php echo $datos['comprobante'] ?></td>
								  <td width="50%" class="celda1"  align="center">FECHA: <?php echo $datos['fecha'] ?></td>
								</tr>
								<tr>
								  <td class="celda10"  align="center"><?php echo $datos['apellido']  ?> <br>APELLIDOS</td>
								  <td class="celda10"  align="center"><?php echo $datos['nombre']    ?> <br>NOMBRE</td>
								</tr>
								<tr>
								  <td class="celda10"  align="center"><span style="color: #000000;font-weight: 800"><?php echo $datos['idprov'] ?></span><br>NUMERO DE IDENTIFICACION</td>
								  <td class="celda10"  align="center"><span style="color: #000000;font-weight: 800"><?php echo $datos['fecha_rige'] ?></span><br>RIGE A PARTIR DE</td>
								</tr>
								 
							  </tbody>
							</table>
 						   
 				      		<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda1" ><br><span style="color: #000000;font-weight: 800">BASE LEGAL</span><br><?php echo $datos['baselegal'] ?><br></td>
 								</tr>
							  </tbody>
							</table>
						  
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda1" ><br><span style="color: #000000;font-weight: 800">DESCRIPCIÓN: </span><br><?php echo $datos['novedad'] ?><br></td>
 								</tr>
							  </tbody>
							</table>
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda1" ><br><span style="color: #000000;font-weight: 800">REFERENCIA</span><br><?php echo $datos['referencia'] ?><br></td>
 								</tr>
							  </tbody>
							</table>
						  
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="50%" class="celda1"  align="center"><span style="color: #000000;font-weight: 800">SITUACION ACTUAL</span></td>
								  <td width="50%" class="celda1"  align="center"><span style="color: #000000;font-weight: 800">SITUACION PROPUESTA</span></td>
								</tr>
								 
								<tr>
								  <td width="50%" align="center">&nbsp;</td>
								  <td width="50%" align="center">&nbsp;</td>
								</tr>
								  
								<tr>
								  <td class="celda1"> 
									 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px">
										  <tbody>
											<tr>
											  <td width="30%" style="padding: 2px"><span style="color: #000000;font-weight: 800">REGIMEN LABORAL</span></td>
											  <td width="70%"  style="padding: 2px"><?php echo $datos['regimen'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px;"><span style="color: #000000;font-weight: 800">PROGRAMA</span></td>
											  <td  style="padding: 2px"><?php echo $datos['programa'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px"><span style="color: #000000;font-weight: 800">DIRECCION</span></td>
											  <td  style="padding: 2px"><?php echo $datos['unidad'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px"><span style="color: #000000;font-weight: 800">PUESTO</span></td>
											  <td  style="padding: 2px"><?php echo $datos['cargo'] ?></td>
											</tr>
											 
											<tr>
											  <td>&nbsp;</td>
											  <td>&nbsp;</td>
											</tr>
										  </tbody>
										</table>
  									</td>
								  <td class="celda1"> 
									 <table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:9px">
											  <tbody>
												<tr>
												  <td width="30%" style="padding: 2px"><span style="color: #000000;font-weight: 800">REGIMEN LABORAL</span></td>
												  <td width="70%"  style="padding: 2px"><?php echo $datos['p_regimen'] ?></td>
												</tr>
												<tr>
												  <td  style="padding:2px"><span style="color: #000000;font-weight: 800">PROGRAMA</span></td>
												  <td  style="padding: 2px"><?php echo $datos['p_programa'] ?></td>
												</tr>
												<tr>
												  <td  style="padding: 2px"><span style="color: #000000;font-weight: 800">DIRECCION</span></td>
												  <td  style="padding: 2px"><?php echo $datos['p_unidad'] ?></td>
												</tr>
												<tr>
												  <td  style="padding: 2px"><span style="color: #000000;font-weight: 800">PUESTO</span></td>
												  <td  style="padding: 2px"><?php echo $datos['p_cargo'] ?></td>
												</tr>
												 
												<tr>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
											  </tbody>
										</table>	
 									</td>
								</tr>
 							  </tbody>
							</table>
						  
						  
						 	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td  align="center" class="celda1"><span style="color: #000000;font-weight: 800"> DIRECCIÓN DE TALENTO HUMANO  
									  <br>  <br>  <br>  <br> <br>    <br><u> 
									  <?php $info= $gestion->datos_cargos(17); 
									  echo $info['d1']; 
									  echo "</u><br>";
									  echo $info['d2']; ?><br> </span> </td>
							    </tr>
  							  </tbody>
							</table>
						  
						  
						   <table width="100%" border="0"  cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  
								  <td width="100%" class="celda1"  align="center"><span style="color: #000000;font-weight: 800"> DIOS, PATRIA Y LIBERTAD   
									  <br>  <br>  <br>  <br>  <br> <u>
									<?php 
 												
									    
												  $info = $gestion->datos_cargos(10); 
												  echo $info['d1'];
												  echo "</u><br>"; 
												  echo $info['d2'];  
										 
									  ?>   </span>
 									</td>
								</tr>
  							  </tbody>
							</table>
						  
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="50%" class="celda1"  align="center"><span style="color: #000000;font-weight: 800">ADMINISTRACIÓN DEL TALENTO HUMANO
									 <br>  <br>  <br>    <br><u>
									<?php echo $datos['nom_elabora'];?></u><br>
									<?php echo $datos['car_elabora'];  ?><br>
									 RESPONSABLE DEL REGISTRO<br>
									   <span style="font-size: 8px">DELEGACION No: <?php echo $datos['comprobante'] ?> FECHA:  <?php echo $datos['fecha'] ?></span> 
									    </span>
								  </td>
								  <td width="50%" class="celda1"  align="center"><span style="color: #000000;font-weight: 800">SERVIDOR PÚBLICO
								    <br><br><br>  <br>  <br>  <u>
									 <?php  echo $datos['razon'];
									  		echo "</u><br>"; 
									  		echo"C.I" .$datos['idprov'];?><br><br>
									  
									   <span style="font-size: 8px">FECHA:.........................HORA:...............</span> </span>
 									</td>
								</tr>
  							  </tbody>
							</table>
						  
						  
						  
						  
					</td>	  
			      </tr>	
			 
		</table>	 
	

 
 
	
</html>
<?php 
  
 
	 
	

$html = ob_get_contents();	
ob_end_clean();
$pdf->writeHTML ( $html , true , false , true , false , '' ) ; 

  
 

  $pdf->setPageMark();	  		 
 $pdf->Image('fondo_agua_logo.png', 30, 55, 140, 100, 'PNG', '', '', true, 300, '', false, false, 0, false, false, true);
 
 
$archivo = 'accionpersonal.pdf';

 

    
$pdf->Output($archivo,'I');

 //$pdf->Output($archivo,'FI');
 


 
 
?>
