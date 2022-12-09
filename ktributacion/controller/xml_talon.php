<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
body,td,th {
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
	font-size: 10px;
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

  $anio = $_GET['ANIO'];
  $mes  = $_GET['MES'];


  echo '<table width="100%" border="0" cellspacing="5" cellpadding="0">
  <tbody>
    <tr>
      <td width="20%"><img src="../../kimages/sri_logo.png"/></td>
      <td width="80%" ><b> TALÓN RESUMEN <br>
                  SERVICIO DE RENTAS INTERNAS <br>
                  ANEXO TRANSACCIONAL <br>
                  '.$_SESSION['razon'].' <br>
                  RUC: '.$_SESSION['ruc_registro'].' <br>
                  Periodo: '.$mes.'-'.$anio.' </b>
       </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><h6><b>Certifico que la información contenida en el medio magnético del Anexo   Transaccional para el período '.$mes.'-'.$anio.', es fiel reflejo del siguiente reporte:<h6></b></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
    </tbody>
</table>';
		
    if (isset($_GET['MES']))	{
              
      $anio= $_GET["ANIO"];
      $mes = $_GET["MES"];

      $gestion->VentasResumen($anio,$mes);
      $gestion->ComprasResumen( $anio,$mes);
      $gestion->ComprasFuente($anio,$mes);
      $gestion->ComprasIva($anio,$mes);
      $gestion->VentasIva($anio,$mes);
            
         
               
            
 }
 
  ?>	
    </div>
  </body>
</html>