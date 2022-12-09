 <?php
 
    session_start( );   

    require 'inventarios-factura.php';   /*Incluimos el fichero de la clase Db*/
 	
    $g  = 	new componente;

    $codigo = $_GET["codigo"];

    $g->ConsultaMovimiento($codigo);
  

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
	
 
<table class="tableCabecera">
  <tr>
    <td colspan="4" class="Mensaje">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle" class="Mensaje">FACTURA</td>
  </tr>
  <tr>
    <td class="Mensaje">Fecha</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('fecha'); ?></td>
    <td align="right" valign="middle" class="Mensaje">Nro Factura </td>
    <td class="Mensaje"><span class="titulo"><?php echo  $g->_getId(); ?></span></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Cliente</td>
    <td  width="36%" class="Mensaje"><?php echo $g->_getSolicita('razon'); ?></td>
    <td  width="28%" align="right" valign="middle" class="Mensaje">Nro.Identificación</td>
    <td  width="23%" class="Mensaje"><?php echo $g->_getSolicita('idprov'); ?></td>
  </tr>
  <tr>
    <td width="13%" class="Mensaje">Dirección</td>
    <td class="Mensaje" ><?php  echo $g->_getSolicita('direccion'); ?></td>
    <td align="right" valign="middle" class="Mensaje" >Telefono</td>
    <td class="Mensaje" ><?php  echo $g->_getSolicita('telefono'); ?></td>
  </tr>
  <tr>
    <td width="13%">&nbsp;</td>
    <td colspan="3"></td>
  </tr>
</table>
  
 <table width="100%" border="1" cellpadding="2" cellspacing="0" >
      <tbody>
        <tr>
          <td align="center" valign="middle">Codigo</td>
          <td align="center" valign="middle">Detalle</td>
          <td align="center" valign="middle">Unidad</td>
          <td align="center" valign="middle">Cantidad</td>
          <td align="right" valign="middle">Costo</td>
          <td align="right" valign="middle">Total</td>
 		  <?php      $g->_getDetalle($codigo) ;   ?>
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
    <td width="50%" class="linea1" align="center" valign="middle">Firma Autorizada</td>
    <td width="50%" class="linea1" align="center" valign="middle">Recibi Conforme</td>
  </tr>
	
</table>

</body>
</html>