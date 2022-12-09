<?php 
session_start();  

ob_start(); 

require('kreportes.php'); 

$gestion   		= 	new ReportePdf; 		

$id 		    = trim($_GET['id']);
$periodo        = $_GET['periodo'];
 

 
?>
<!DOCTYPE html>
<html>
	
<head lang="en">
	
<meta charset="UTF-8">

 
<style>
  		
	 	@page { margin: 150px 40px 150px 40px; }  
 
		body { 
		    position: relative;
		    width: 20cm;  
		    margin: 0 auto; 
		    font-family: 'Helvetica Neue', Helvetica, Arial, 'sans-serif';
		    font-size: 11px; 
			/*z-index: 30000;*/
		}
 
 		#header { position: fixed; left: 0px; top: -110px; right: 0px; height: 110px;   text-align: center; }
	
   		#footer { position: fixed; left: 0px; bottom: -125px; right: 0px; height: 60px;   }
	
		#footer .page:after { 
			counter-increment: section;
			content: "Pag " counter(section) " ";

		}

		.round3 {
				border: 1px solid #000000;
				border-radius: 5px;
		}
	
		.tabla {
			 border: #000000 1px solid;
			 margin: 3px;	
			 padding: 3px;
			 border-style: ridge; 
  		}
	
		.tablaTotal {
	 	 margin: 3px;	
		border-style: ridge; 	
 		 }

	   .cabecera_font {
		 font-size: 11px;
 		 color:#2D2D2D;
		}
	
	
		.tablaPie {
		 border: #000000 1px solid;
		 margin: 25px;	
		 padding: 25px;
		}
		.tablaPie1 {
		 border: #000000 1px solid;
		 margin: 3px;	
		 padding: 3px;
		}

		.tablap {
			 border: #000000 1px solid;
			 margin: 3px;	
			 padding: 3px;
			 border-collapse: collapse;
			}

 
		.lado {
		 border: #000000 1px solid;
		 margin: 1px;	
		 padding: 1px;
		 border-collapse: collapse;
		}

	  .logo_header{
						border-collapse: collapse; 
					   /* border: 0px solid #AAAAAA; */
						font-size: 10px; 
						padding: 5px;
			}

	
 
	 
   	 	 .opensans{	 
 			 color:#2F2F2F;
			 font-size: 12px; 
 			 padding: 2px;
			 font-weight: bold;
	  	}	
		
		 
   	 	 .celda1{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
			 color:#545454;
			 font-size: 10px; 
 			 padding: 2px;
			 border-style: ridge; 
	  	}	
	
	 .celda10{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000;
			 color:#000000;
			 font-size: 11px; 
		     font-weight:900;
 			 padding: 2px;
			 border-style: ridge; 
	  	}	
	
		  .celda13{	 
			 border-collapse: collapse; 
			 border: 1px solid #000000 ;
			 color:#000000;
			 font-size: 10px; 
 			 padding: 2px;
			  border-style: ridge; 
	  	}	
			 
		  .celda11{	 
			 border-collapse: collapse; 
			 border: 1px solid #AAAAAA;
			 font-size: 10px; 
			 color:#2F2F2F;
 			 padding: 2px;
			  border-style: ridge; 
	  	}	
			 
		 .celda3{	 
			 border-collapse: collapse; 
			 color:#2F2F2F;
 			 font-size: 11px; 
			 padding: 2px;
			 border-style: ridge; 
	  	}	
 
	
	
.actividad {
    border-collapse: collapse;
    width: 90%;
	font-size: 11px;
	table-layout: fixed;
 }
 
 div.ex1 {
  width: 100%;
  overflow-x: auto;
}
	
.table1 {
  border-collapse: collapse;
}
	
 .filasupe {
 
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
	border-top: 1px solid #ddd;
	padding-bottom: 4px; 
}
	
.derecha {
 
     border-right: 1px solid #ddd;
	  
 } 
	</style>
	
</head>	
	
 
	
<body>
 
	
<div id="header">
	
 	  
	   <table width="90%" class="logo_header" >
		  <tbody>
			<tr>
			   
				<td width="15%" valign="top" >
				  <img src="../kimages/<?php echo trim($_SESSION['logo']) ?>" width="160" height="95">
				</td>
				 
		        <td width="75%" align="justify" style="padding: 5px" class="cabecera_font">
				    <?php  echo $gestion->Empresa(); ?><br>
					<?php  echo $gestion->_Cab( 'ruc_registro' ); ?><br>
				    <?php   echo $gestion->_Cab( 'direccion' ); ?><br>
					<?php  echo $gestion->_Cab( 'telefono' ); ?>
				</td>
			 
				
				 
		      </tr>
		  </tbody>
		</table>
 	
 </div>
 
<div id="footer">
	
	 		
	<span style="font-size: 8px;color:#8F8F8F;font-style: italic"> <?php  $gestion->QR_Firma(); ?></span>	
 
</div>
	
<div id="content" >  
	
            
						  <?php  $gestion->_ActividadesPOA($id,$periodo) ;  ?>
						  
						   <table width="90%" border="0" cellspacing="0" cellpadding="0">
							  <tbody>
								<tr>
								  <td width="45%"   align="center"><span style="color: #000000;font-weight: 800"> 
									 <br>  <br>  <br>   <br> 
									 RESPONSABLE UNIDAD
 								  </td>
								  <td width="45%"  align="center"><span style="color: #000000;font-weight: 800"> 
								  <br>  <br>  <br>   <br> 
									 <?php  echo 'AUTORIZADO';   ?>  
									  
									   
 									</td>
								</tr>
  							  </tbody>
							</table>
						  
					 

 
	
</div> 
	
	
</html>
<?php 
 
  ini_set('memory_limit', '384M');
  ini_set('max_execution_time', 300);
	
 
$html = ob_get_contents();	
 
ob_end_clean();
	
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();

$dompdf->set_option('isPhpEnabled', true);

$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape
	
$dompdf->load_html($html);
  
	
$dompdf->render(); // Generar el PDF desde contenido HTML
   

	 
 
	$registro = trim($_SESSION['ruc_registro']);

	$filename = "AccionPersonal".$registro.".pdf";



	$dompdf->stream($filename, array("Attachment" => false));
 
 
	 

 
 
?>
