<?php 
session_start();  
ob_start();	
require_once('tcpdf/tcpdf.php'); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$id 		    = trim($_GET['id']);

$datos 		    = $gestion->Accion($id);
 
 
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
 			 padding: 5px;
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
			    ACCION DE PERSONAL<br> 
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
								  <td colspan="2"  align="center" class="opensans">ACCION DE PERSONAL</td>
							    </tr>
								<tr>
								  <td width="50%" class="celda1"  align="center">ACCION DE PERSONAL NO. <?php echo $datos['comprobante'] ?></td>
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
								  <td class="celda21" ><br><b>EXPLICACIÓN:</br><br><?php echo $datos['novedad'] ?><br></td>
 								</tr>
							  </tbody>
							</table>
						  
						    <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda21" ><br> <b>BASE LEGAL </b>
									  <?php 
												$pie_contenido = trim($datos['baselegal']); 
	
												$pie_contenido = str_replace('-ART','<br>-ART', $pie_contenido);
									  			
									  			echo $pie_contenido;
									  
									  ?><br>
								   </td>
 								</tr>
							  </tbody>
							</table>
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda21" ><br>  <b>REFERENCIA </b> <br><?php echo $datos['referencia'] ?><br></td>
 								</tr>
							  </tbody>
							</table>
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
 								<tr>
								  <td class="celda21"><br>&nbsp;&nbsp;<b>MOTIVO DE LA ACCION DE PERSONAL </b><br>&nbsp;&nbsp;<?php echo $datos['motivo'] ?><br>
 								    <?php 
										if  (trim($datos['finalizado']) == 'S'){
												echo 'ACCION DE PERSONAL FINALIZADA - '.$datos['ffinalizacion'];
											 }
									  ?>
									  <br>
									</td>
 								</tr>
							  </tbody>
							</table>
						  
						  
						   <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="50%" class="celda21"  align="center"><b>SITUACION ACTUAL</b></td>
								  <td width="50%" class="celda21"  align="center"><b>SITUACION PROPUESTA</b></td>
								</tr>
								 
								<tr>
								  <td width="50%" align="center">&nbsp;</td>
								  <td width="50%" align="center">&nbsp;</td>
								</tr>
								  
								<tr>
								  <td class="celda22"> 
									 <table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tbody>
											<tr>
											  <td width="30%" style="padding: 2px"><b>REGIMEN LABORAL</b></td>
											  <td width="70%"  style="padding: 2px"><?php echo $datos['regimen'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px;"><b>PROGRAMA</b></td>
											  <td  style="padding: 2px"><?php echo $datos['programa'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px"><b>DIRECCION</b></td>
											  <td  style="padding: 2px"><?php echo $datos['unidad'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px"><b>PUESTO</b></td>
											  <td  style="padding: 2px"><?php echo $datos['cargo'] ?></td>
											</tr>
											<tr>
											  <td  style="padding: 2px"><b>REMUNERACION MENSUAL</b></td>
											  <td  style="padding: 2px"><?php echo $datos['sueldo'] ?></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td>&nbsp;</td>
											</tr>
										  </tbody>
										</table>
  									</td>
								  <td class="celda22"> 
									 <table width="100%" border="0" cellspacing="0" cellpadding="0">
											  <tbody>
												<tr>
												  <td width="30%" style="padding: 2px"><b>REGIMEN LABORAL</b></td>
												  <td width="70%"  style="padding: 2px"><?php echo $datos['p_regimen'] ?></td>
												</tr>
												<tr>
												  <td  style="padding:2px"><b>PROGRAMA</b></td>
												  <td  style="padding: 2px"><?php echo $datos['p_programa'] ?></td>
												</tr>
												<tr>
												  <td  style="padding: 2px"><b>DIRECCION</b></td>
												  <td  style="padding: 2px"><?php echo $datos['p_unidad'] ?></td>
												</tr>
												<tr>
												  <td  style="padding: 2px"><b>PUESTO</b></td>
												  <td  style="padding: 2px"><?php echo $datos['p_cargo'] ?></td>
												</tr>
												<tr>
												  <td  style="padding: 2px"><b>REMUNERACION MENSUAL</b></td>
												  <td  style="padding: 2px"><?php echo $datos['p_sueldo'] ?></td>
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
								  <td  align="center" class="celda21"><b> DIRECCIÓN DE TALENTO HUMANO  
									  <br><br><br><br><br><br>    
									  <?php $info= $gestion->datos_cargos(17); 
									  echo $info['d1']; 
									  echo "<br>";
									  echo $info['d2']; ?><br></b> </td>
							    </tr>
  							  </tbody>
							</table>
						  
						  
						   <table width="100%" border="0"  cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
 								  <td width="100%" class="celda21"  align="center">DIOS, PATRIA Y LIBERTAD   
									  <br><br><br><br><br><br><b>    
									<?php 
 												
									    if ( trim($datos['idprovc']) == '-' ) {
												  $info = $gestion->datos_cargos(10); 
												  echo $info['d1'];
												  echo " <br>"; 
												  echo $info['d2'];  
										  }else {
												  
												  echo $datos['nombre_firma'];
												  echo " <br>"; 
												  echo $datos['responsable_firma'];  
										  }	
									  ?>   </b>
 									</td>
								</tr>
  							  </tbody>
							</table>
						   
						  
						  	 <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="50%" class="celda21"  align="center"><b>ADMINISTRACIÓN DEL TALENTO HUMANO
									 <br><br><br><br><br><br> 
									<?php echo $datos['nom_elabora'];?><br>  
									<?php echo $datos['car_elabora'];  ?><br>
									 RESPONSABLE DEL REGISTRO<br></b>
 									   <span style="font-size: 8px">ACCION No: <?php echo $datos['comprobante'] ?> FECHA:  <?php echo $datos['fecha'] ?></span> 
 								  </td>
								   
									<td width="50%" class="celda21"  align="center"><b>SERVIDOR PÚBLICO
								    <br><br><br><br><br><br> 
									 <?php  echo $datos['razon'];
									  		echo "<br>"; 
									  		echo"C.I. " .$datos['idprov'];?></b><br><br>
									  
									   <span style="font-size: 8px">FECHA:.........................HORA:...............</span> 
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
