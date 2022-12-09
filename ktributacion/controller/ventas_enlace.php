<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
 td,th {
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-size: 11px;
}
</style>
<?php 
require('../view/Head.php')
?>
</head>
 <body>
 <div class="col-md-12" style="padding: 30px">
 <?php 
 	
	 session_start( );
	 
	header('Content-Type: text/html; charset=UTF-8'); 

	 require '../model/model_xml_talon.php';   
	 
     
	$gestion   = 	new proceso;

  $anio = $_GET['anio'];
  $mes  = $_GET['MES'];


  echo '<table width="100%" border="0"   cellspacing="5" cellpadding="0">
  <tbody>
    <tr>
       <td width="100%" ><h5><b> TALÓN RESUMEN <br>
                  FACTURACION - ENLACE <br>
                  ANEXO TRANSACCIONAL <br>
                  '.$_SESSION['razon'].' <br>
                  RUC: '.$_SESSION['ruc_registro'].' <br>
                  Periodo: '.$mes.'-'.$anio.' </b></h5>
       </td>
    </tr>
    <tr>
   
    <td>&nbsp;</td>
    </tr>
 
    <tr>
    
    <td>&nbsp;</td>
    </tr>
    </tbody>
</table>';
		   
echo '<div class="col-md-12">';

               $gestion->Facturacion($_GET["anio"],$_GET["MES"]);

echo '</div>';          

echo '<div class="col-md-4">';

               $gestion->FacturacionTotal($_GET["anio"],$_GET["MES"]);
               
echo '</div>';
  
  ?>	
    </div>
  </body>
</html>
 