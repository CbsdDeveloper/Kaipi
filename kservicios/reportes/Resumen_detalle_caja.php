<?php
session_start();
include ('kreportes.php');

if (isset($_GET['id']))	{
	        $gestion   = 	new ReportePdf;
			$id       = $_GET['id'];		
			$f1       = $_GET['f1']; 
			$empresa  = $gestion->EmpresaCab();
}

?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Reporte</title>
	
    <?php  require('../view/Head.php')  ?> 
	
  	<script type="text/javascript">
            function imprimir() {
                if (window.print) {
                       window.print();
					 
 					
                } else {
                    alert("La función de impresion no esta soportada por su navegador.");
                }
            }
        </script>
	
	<link rel="stylesheet" href="impresion.css"/>
	
	<style>
    .tabla {
 	 border: #767676 1px solid;
	 margin: 1px;	
	 padding: 1px;
  	}
	</style>
</head>
<body onload="imprimir();">
<!-- ------------------------------------------------------ -->
<div class="col-md-12">
	<!-- Header -->
	
	 <div class="col-md-12">
         <table width="95%">
					  <tr>
					    <td width="11%" align="left" valign="top" style="font-size: 11px">
							<img src="../../kimages/<?php echo trim($_SESSION['logo']) ?>" width="100" height="80">
						</td>
						  <td width="6%" align="center" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
						<td colspan="3" align="left" style="font-size: 11px">
							<?php 
								echo $gestion->EmpresaCab().'<br>';
								echo $gestion->_Cab( 'ruc_registro' ).'<br>';
							    echo $gestion->_Cab( 'direccion' ).'<br>';
							    echo $gestion->_Cab( 'telefono' ).'<br>';
								echo $gestion->_Cab( 'ciudad' ).'- Ecuador'.'<br>';
							?>
							</td>
							 
						</tr>
		  </table>
  </div> 
	 
    <div class="col-md-12">
		<h6><b>REPORTE DEL DIA <?php  echo $f1.' Nro Parte: '.$id  ?> </b></h6>
		
	   <?php    $gestion->ResumenCajaConta( $id,$f1 );  ?>  
	
	 </div>    
	
	<div class="col-md-12" style="padding-top:60px">
		Elaborado por :<br> 
	   <?php   $gestion->QR_Firma();  ?>  
      </div> 
	<div class="col-md-12">
 	   <?php   $gestion->QR_DocumentoDoc($id);  ?>  
		<img width="80" height="80" src='logo_qr.png'/><br>	
      </div>  
        
  </div>  
 
		
 
 </body>
</html>
 