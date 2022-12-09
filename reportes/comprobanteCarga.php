 <?php
 
    session_start( );   

    require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
 	
    $g  = 	new componente;

    $codigo = $_GET["codigo"];

    $g->ConsultaMovimientoCarga($codigo);
  

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 
 
 <style type="text/css">
 
	body {
		font-size: 11px;
		color:#000;
	    margin: 10mm 20mm 20mm 20mm;
	}

 
	.tableCabecera{
 	margin:3px 0 3px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
	width: 100%  
  	}
	 
 .tableFirmas{
 	margin:10px 0 10px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
  	}
	 
 .titulo{
	padding-left: 10px;
	padding-bottom: 2px;
	font-weight: bold;
	color: #5B5B5B
  	}
	 
 .titulo1{
	padding-left: 10px;
	padding-bottom: 2px;
 	color: #5B5B5B
  	}
	 
  .MensajeCab{
	padding-left: 10px;
	padding-bottom: 5px;
	font-weight:100;
	font-size: 11px;
	color:#636363
  	}
 
  .Mensaje{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
    
	 .grillaTexto{
	font-size: 11px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
   	}	 
	 
	 .Mensaje1{
	font-size: 12px;
	padding-left: 5px;
	padding-right: 15px;  
	padding-bottom: 5px;
 	color:#000000
  	}	
	 
  .linea{
		border: .40mm solid thin #909090;
	   padding: 20px;
  	}	

	 .linea1{
		border: .40mm solid thin #909090;
	   padding: 5px;
  	}	
	 
 </style>
    
</head>

<body>
	
 
	
<table   width="100%">
  <tr>
    <td width="100%" colspan="2" class="titulo"><?php echo $g->_getEmpresa('razon'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="MensajeCab">PLATAFORMA DE GESTIÓN DE PLANIFICACION INSTITUCIONAL</td>
  </tr>
  <tr>
    <td colspan="2" class="titulo1">MODULO DE INVENTARIOS - MOVIMIENTO DE BODEGA</td>
  </tr>
</table>
<table class="tableCabecera">
  <tr>
    <td colspan="4" class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle" class="Mensaje">CARGA Y TOMA DE INVENTARIOS</td>
  </tr>
  <tr>
    <td class="Mensaje">Fecha</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('fecha'); ?></td>
    <td align="right" valign="middle" class="Mensaje">&nbsp; </td>
    <td class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Categoria</td>
    <td  width="34%" class="Mensaje"><?php echo $g->_getSolicita('detalle'); ?></td>
    <td  width="26%" align="right" valign="middle" class="Mensaje">Usuario</td>
    <td  width="27%" class="Mensaje"><?php echo $g->_getSolicita('sesion'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Estado</td>
    <td colspan="3" class="Mensaje" ><?php  echo $g->_getSolicita('estado'); ?></td>
  </tr>
  <tr>
    <td width="13%">&nbsp;</td>
    <td colspan="3"></td>
  </tr>
</table>
<h5>LISTA DE ARTICULOS</h5>
 
		<table width="100%" border="1" cellpadding="2" cellspacing="0" >
      <tbody>
        <tr>
          <td align="center" valign="middle">Codigo</td>
          <td align="center" valign="middle">Detalle</td>
          <td align="center" valign="middle">Saldo</td>
          <td align="center" valign="middle">Cantidad</td>
          <td align="right" valign="middle">Costo</td>
          <td align="right" valign="middle">Total</td>
		   <td align="center" valign="middle">Novedad</td>	
        </tr>
		  <?php      $g->_getDetalleCarga($codigo) ;   ?>
       </tbody>
    </table> 

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>	
	
<table class="tableFirmas" width="100%" >
  <tr>
    <td class="linea" >&nbsp; </td>
    <td class="linea" >&nbsp; </td>
  </tr>
  <tr>
    <td width="50%" class="linea1" align="center" valign="middle">Elaborado</td>
    <td width="50%" class="linea1" align="center" valign="middle">Autorizado</td>
  </tr>
	
</table>

</body>
</html>