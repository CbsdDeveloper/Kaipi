 <?php
 
    session_start( );   

    require 'inventarios.php';   /*Incluimos el fichero de la clase Db*/
 	
    $g  = 	new componente;

    $g->ConsultaCertificacion($_GET["codigo"]);
  

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 
 
 <style type="text/css">
 
	body {
		font-size: 9px;
		color:#000;
	    margin: 10mm 20mm 20mm 20mm;
	}

 
	.tableCabecera{
 	margin:10px 0 10px 0;
	border-collapse:collapse;
	border: .40mm solid thin #909090;
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
	font-size: 9px;
	color:#636363
  	}
 
  .Mensaje{
	font-size: 9px;
	padding-left: 10px;
	padding-right: 5px;  
	padding-bottom: 5px;
 	color:#000000
  	}	 
	 .Mensaje1{
	font-size: 11px;
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
	
<img src="http://190.152.220.237/gestiona/archivos/encabezado.jpg"  />
	
<table class="tableCabecera"  width="100%">
  <tr>
    <td colspan="2" class="titulo"><?php echo $g->_getEmpresa('NOMBRE'); ?></td>
  </tr>
  <tr>
    <td colspan="2" class="MensajeCab">PLATAFORMA DE GESTIÓN DE PLANIFICACION INSTITUCIONAL</td>
  </tr>
  <tr>
    <td colspan="2" class="titulo1">GESTION DE PLANIFICACION - GESTION PRESUPUESTARIO</td>
  </tr>
  <tr>
    <td width="35%" >&nbsp;</td>
    <td  width="65%"  >&nbsp; </td>
  </tr>
  <tr>
    <td  width="35%" class="titulo1">SOLICITUD DE CERTIFICACIÓN</td>
    <td width="65%" class="titulo"><?php echo  $g->_getId(); ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<h4 align="center">INFORMACION DEL SOLICITANTE</h4>
<table class="tableCabecera"  width="100%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Mensaje">Fecha</td>
    <td class="Mensaje"><?php echo $g->_getSolicita('FECHAINICIO'); ?></td>
  </tr>
  <tr>
    <td width="15%" class="Mensaje">Unidad Solicita</td>
    <td  width="85%" class="Mensaje"><?php echo $g->_getSolicita('UNIDAD'); ?></td>
  </tr>
  <tr>
    <td width="15%" class="Mensaje">De</td>
    <td  width="85%" class="Mensaje" ><?php echo $g->_getSolicita('DE'); ?></td>
  </tr>
  <tr>
    <td width="15%" class="Mensaje">Para</td>
    <td  width="85%" class="Mensaje"><?php echo $g->_getSolicita('PARA'); ?></td>
  </tr>
  <tr>
    <td width="15%" class="Mensaje">Asunto</td>
    <td width="85%" class="Mensaje"><?php echo $g->_getSolicita('ASUNTO'); ?></td>
  </tr>
  <tr>
    <td width="15%">&nbsp;</td>
    <td width="85%"></td>
  </tr>
</table>
	<h4 align="center">DETALLE DEL REQUERIMIENTO</h4>
<table class="tableCabecera"  width="100%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="15%" class="Mensaje">Actividad planificada</td>
    <td width="85%" class="Mensaje"><?php echo $g->_getSolicita('TAREA'); ?></td>
  </tr>
  <tr>  
    <td width="15%" class="Mensaje">Detalle</td>
    <td width="85%" align="left" valign="middle" class="Mensaje"><?php echo $g->_getSolicita('EDITOR'); ?></td>
  </tr>
	  <tr>
	    <td align="left"  class="Mensaje" valign="middle">Monto Solicitado</td>
	    <td align="left"  class="Mensaje" valign="middle"><b>$ <?php echo $g->_getSolicita('MONTO'); ?></b></td>
  </tr>
	  <tr>
	    <td colspan="2" align="left" valign="middle">&nbsp;</td>
  </tr>
	 
</table>
<p class="Mensaje1" align="justify">Al respecto y en base a lo expuesto anteriormente me permito hacer extensivo la presente Solicitud de Certificación Presupuestaria para cubrir con el proceso antes mencionado, dicho valor incluye el IVA. </p>
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