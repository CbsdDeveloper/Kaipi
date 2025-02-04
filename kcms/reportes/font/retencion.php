 <?php  session_start( );   ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css" media="print">
#Imprime {
 height: auto;
 width: 800px;
 margin: 0px;
 padding: 0px;
 float: left;
 font-family: Arial, Helvetica, sans-serif;
 font-size: 13px;
 font-style: normal;
 line-height: normal;
 font-weight: normal;
 font-variant: normal;
 text-transform: none;
 color: #000;
}
@page{
   margin: 0;
}
small { 
    font-size: smaller;
}
</style>
</head>
<body>
<script type="text/javascript">
    window.print(this); //dialogo de impresion
	window.onfocus = function(){
		window.close();
	};//cuando regrese el control de foco, cerramos la ventana
 </script>

<div id="Imprime">
 <?php 

   	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
	require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/ 
 
 	/*Creamos la instancia del objeto. Ya estamos conectados*/
	global $bd,$obj,$datos, $formulario,$set;
  
    $obj   = 	new objects;
	$bd	   =	Db::getInstance();
 
 	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

  
  $fecha = date("Y/m/d H:i:s"); 
  $idSucursal = 'sas'; //se obtiene la sucursal respecto al usuario que inicio sesion
  $totalV = 0;
  $totalCosto =0;
  $totalImporte=0;
  
  $id_ingreso		= $_GET['a'];
  $sesion 	    = $_SESSION['login'];
  
  // detalle
   $sql1 = "SELECT  V.MATERIAL, V.CANTENTREGA, V.COSTTOTAL,V.IDMOVIMI
				FROM VIEW_EG_FAC V
				WHERE V.IDMOVIMI = ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
 
				
	 /*Ejecutamos la query*/
	// $stmt = $bd->ejecutar($sql1);
  
    // cabecera del comprobante
	  $fecha = "to_char(I.FECINGRESO,'DD/MM/RRRR') as ";

  	 
  	  $sql = "SELECT  I.IDMOVIMI, ".$fecha." FECINGRESO, G.GEN01RUC as IDCLIENTE, G.GEN01COM as CLIENTE,  I.DETALLE,  
					   I.COMPEGRESO, I.ESTADO, I.COMPINGRESO, 
					   I.BASE AS TOTAL_BASE,
					   I.IVA AS IVA_IMPRIME, 
					   I.TARIFA0 AS TOTAL_BASE0,   
					   I.VALFACTURA,
					   I.GEN01CODI as IDEMPLEARETIRA,ESTAMOVI
					FROM IB10_MOVIMIENTOS I, GEN01 G
					where  G.GEN01CODI = I.GEN01CODI AND  I.IDMOVIMI = ".$bd->sqlvalue_inyeccion($id_ingreso ,true);
			   
 // 	  $resultado_cab = $bd->ejecutar($sql);
//      $cabecera = $bd->obtener_array( $resultado_cab); 
  
 ?>
 <img src="espacio.png" width="6" height="165"/>
    <br>
   <img src="espacio.png" height="14" width="105"/><?php echo 'nombre proveedor'//$cabecera['FECINGRESO'] ?><img src="espacio.png" width="350"/><?php echo '15/07/2018'//$cabecera['FECINGRESO'] ?>
  <br>
  <img src="espacio.png" height="14" width="95"/><?php echo '171140756700'; //$cabecera['FECINGRESO'] ?><img src="espacio.png" width="470"/><?php echo 'FACTURA'// $cabecera['FECINGRESO'] ?>
   <br>
  <img src="espacio.png" height="16" width="120"/><?php echo 'DIRECCION' //$cabecera['FECINGRESO'] ?><img src="espacio.png" width="470"/><?php echo '001001-0123123'// $cabecera['FECINGRESO'] ?>
   <br>
  <img src="espacio.png" height="14" width="165"/><?php echo '12312321212321' //$cabecera['FECINGRESO'] ?><img src="espacio.png" width="220"/><?php echo '022898721'//$cabecera['FECINGRESO'] ?>
    <br>
  <table width="800" border="0">
  <tr>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp; </td>
    <td width="100">&nbsp; </td>
    <td width="100">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="150">&nbsp;</td>
  </tr>
   
   <tr>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td align="right" valign="middle">2015</td>
     <td align="right" valign="middle">500</td>
     <td align="right" valign="middle">RENTA</td>
     <td align="right" valign="middle">342</td>
     <td align="right" valign="middle">5%</td>
     <td align="center" valign="middle">50</td>
   </tr>
   <tr>
     <td colspan="5" align="right">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5" align="right">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5" align="right">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5" align="right">&nbsp;</td>
     <td align="center" valign="middle">&nbsp;</td>
   </tr>
   <tr>
      <td colspan="5" align="right">&nbsp; </td>
      <td align="center" valign="middle"><b><?php echo $totalCosto ?></b></td>
   </tr>
  </table> 
</div>
 
</body>
</html>
