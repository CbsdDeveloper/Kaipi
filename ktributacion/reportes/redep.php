<?php

 session_start( );      

 
 require '../../kconfig/Db.class.php';
 
 require '../../kconfig/Obj.conf.php';


$obj   = 	new objects;

$bd     = 	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$txtANIO = $_GET['anio'];
		 // nivel actual


 $sql1 = "SELECT substr(PAR00RAZON,1,3) as SERIE,substr(PAR00CARA,1,13) as RUC,substr(PAR00RAZON,8,200) as MUNICIPIO
 	   FROM PAR00
	where PAR00CODI = -1";

 		 $resultado2 = $bd->ejecutar($sql1);

		 $datosGad  = $bd->obtener_array( $resultado2);


$sql = "SELECT   
		  COUNT(IDRET) AS NN ,
		   SUM(SUELSAL) AS SUELSAL, 
		   SUM(SOBSUELCOMREMU) AS SOBSUELCOMREMU, 
		   SUM(PARTUTIL) AS PARTUTIL, 
		   SUM(INTGRABGEN) AS INTGRABGEN, 
	 	   SUM(IMPRENTEMPL) AS IMPRENTEMPL, 
		   SUM(DECIMTER) AS DECIMTER, 
		   SUM(DECIMCUAR) AS DECIMCUAR, 
		   SUM(FONDORESERVA) AS FONDORESERVA, 
		   SUM(SALARIODIGNO) AS SALARIODIGNO,
		   SUM(OTROSINGRENGRAV) AS OTROSINGRENGRAV,
		   SUM(APOPERIESS) APOPERIESS, 
		   SUM(APORPERIESSCONOTROSEMPLS) AS APORPERIESSCONOTROSEMPLS, 
		   SUM(DEDUCVIVIENDA) AS DEDUCVIVIENDA, 
		   SUM(DEDUCSALUD) AS DEDUCSALUD, 
		   SUM(DEDUCEDUCA) AS DEDUCEDUCA, 
		   SUM(DEDUCALIEMENT) AS DEDUCALIEMENT, 
		   SUM(DEDUCVESTIM) AS DEDUCVESTIM ,
		   SUM(EXODISCAP) as EXODISCAP, 
		   SUM(EXOTERED) as EXOTERED,
		   sum(BASIMP) as BASIMP,
		   sum(IMPRENTCAUS) as IMPRENTCAUS,
		   sum(VALRETASUOTROSEMPLS) as VALRETASUOTROSEMPLS, 
		   sum(VALIMPASUESTEEMPL) as VALIMPASUESTEEMPL, 
		   sum(VALRET) as VALRET,
		   sum(REMUNCONTRESTEMPL) as REMUNCONTRESTEMPL,
		   sum(REMUNCONTROTREMPL) as REMUNCONTROTREMPL, 
		   sum(EXONREMUNCONTR) as EXONREMUNCONTR, 
		   sum(TOTREMUNCONTR) as TOTREMUNCONTR,
		   sum(NUMMESTRABCONTRESTEMPL) as NUMMESTRABCONTRESTEMPL,
		   sum(NUMMESTRABCONTROTREMPL) as NUMMESTRABCONTROTREMPL, 
		   sum(TOTNUMMESTRABCONTR) as TOTNUMMESTRABCONTR, 
		   sum(REMUNMENPROMCONTR) as REMUNMENPROMCONTR, 
		   sum(NUMMESCONTRGENESTEMPL) as NUMMESCONTRGENESTEMPL, 
		   sum(NUMMESCONTRGENOTREMPL) as NUMMESCONTRGENOTREMPL, 
		   sum(TOTNUMMESCONTRGEN) as TOTNUMMESCONTRGEN, 
		   sum(TOTCONTRGEN) as TOTCONTRGEN, 
		   sum(CREDTRIBDONCONTROTREMPL) as CREDTRIBDONCONTROTREMPL, 
		   sum(CREDTRIBDONCONTRESTEMPL) as CREDTRIBDONCONTRESTEMPL, 
		   sum(CREDTRIBDONCONTRNOESTEMPL) as CREDTRIBDONCONTRNOESTEMPL, 
		   sum(TOTCREDTRIBDONCONTR) as TOTCREDTRIBDONCONTR, 
		   sum(CONTRPAG) as CONTRPAG, 
		   sum(CONTRASUOTREMPL) as CONTRASUOTREMPL, 
		   sum(CONTRRETOTREMPL) as CONTRRETOTREMPL, 
		   sum(CONTRASUESTEMPL) as CONTRASUESTEMPL, 
		   sum(CONTRRETESTEMPL) as CONTRRETESTEMPL
		 FROM RDEP 
		 WHERE  ANIO = ".$txtANIO;

		   

 /*
		   , INGGRAVCONESTEEMPL, SISSALNET, 
		     
		   BASIMP, IMPRENTCAUS, VALRETASUOTROSEMPLS, 
		   VALIMPASUESTEEMPL, VALRET, IDREDEP, 
		   REMUNCONTRESTEMPL, 
		   REMUNCONTROTREMPL, EXONREMUNCONTR, 
		   TOTREMUNCONTR, NUMMESTRABCONTRESTEMPL, NUMMESTRABCONTROTREMPL, 
		   TOTNUMMESTRABCONTR, REMUNMENPROMCONTR, NUMMESCONTRGENESTEMPL, 
		   NUMMESCONTRGENOTREMPL, TOTNUMMESCONTRGEN, TOTCONTRGEN, 
		   CREDTRIBDONCONTROTREMPL, CREDTRIBDONCONTRESTEMPL, CREDTRIBDONCONTRNOESTEMPL, 
		   TOTCREDTRIBDONCONTR, CONTRPAG, CONTRASUOTREMPL, 
		   CONTRRETOTREMPL, CONTRASUESTEMPL, CONTRRETESTEMPL
 */
 		 $resultado1 = $bd->ejecutar($sql);
 
		 $datosEmpleado  = $bd->obtener_array( $resultado1);


 ?>
<!DOCTYPE html>
<html>
		<head lang="en">
			<meta charset="UTF-8">
		<title>Modulo de Reportes </title>
			<style>
				body{
 				     font-family:Segoe, Segoe UI, DejaVu Sans, Trebuchet MS, Verdana," sans-serif";
					color: #000;
					background: #fff;
 				}
				.logo{
					font-size: 30px;
				}
				.orange{
					color:orange;
				}
				.titulo{
					font-size:11px;
   				}
				.nombre{
				 	font-size: 12px;
					font-weight: bold;
					text-align: center	
					 
				}
				.nombre1{
				 	font-size: 8px;
					font-weight: bold;
					text-align:center 
					 
				}
				.nombre11{
				 	font-size: 11px;
					text-align:right
  					 
				}
				.nombre111{
				 	font-size: 11px;
  					 
				}
				.nombre2{
				 	font-size: 12px;
					font-weight: bold;
					text-align: justify; 
					 
				}
				.nombre21{
				 	font-size: 10px;
 					 
				}
				.descripcion{
					font-size: 12px;
					padding: 0px 0px;
				}
				.logoEmpresa{
						font-size: 12px;
					font-weight: bold;
 				}
				
			 table {
				border-collapse: collapse;
			  }
			  th, td {
			border: 1px solid #ccc;
			padding: 3px;
			text-align: left;
			font-style: 8;
			  }
			  

				
			</style>
		</head>
		<body> 
		<div style="padding-left:15px;padding-right:15px">
		
				<table width="800" border="1" cellspacing="0" cellpadding="0">
		  <tbody>
		    <tr>
		      <td width="153" rowspan="7" align="center" valign="middle" class="nombre1"><img src="sri.png" width="108" height="54" alt=""/> </td>
		      <td colspan="2" align="center" valign="middle" class="nombre">TALÓN RESUMEN DE RETENCIONES EN LA FUENTE DE</td>
	        </tr>
		    <tr>
		      <td colspan="2" align="center" valign="middle" class="nombre">IMPUESTO A LA RENTA BAJO RELACIÓN DE DEPENDENCIA</td>
	        </tr>
		    <tr>
		      <td colspan="2" align="center" valign="middle" class="nombre">SERVICIO DE RENTAS INTERNAS</td>
	        </tr>
		    <tr>
		      <td width="155" class="logoEmpresa">RAZÓN SOCIAL:</td>
		      <td width="942" class="descripcion" ><?php echo $datosGad['MUNICIPIO']?></td>
	        </tr>
		    <tr>
		      <td class="logoEmpresa">RUC:</td>
		      <td class="descripcion" ><?php echo $datosGad['RUC']?></td>
	        </tr>
		    <tr>
		      <td class="logoEmpresa">PERÍODO:</td>
		      <td class="descripcion" >ENERO - DICIEMBRE <?php echo $txtANIO ?></td>
	        </tr>
		    <tr>
		      <td class="logoEmpresa">FECHA:</td>
		      <td class="descripcion" >31-01-<?php echo $txtANIO ?></td>
	        </tr>
		    <tr>
		      <td colspan="3" class="nombre2">Certifico que la información contenida en el medio magnético adjunto sobre la Retención en la Fuente de Impuesto a la Renta<br>
	          bajo Relación de Dependencia realizadas durante el periodo indicado, es el fiel reflejo de lo registrado en este anexo:</td>
	        </tr>
		    </tbody>
	    </table>
		 
		<br> 
	    <table width="800" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#C7D2EB" class="nombre">INFORMACIÓN ORIGINAL</td>
    </tr>
    <tr class="nombre">
      <td>DESCRIPCION</td>
      <td>VALOR</td>
    </tr>
    <tr>
      <td class="nombre111">NUMERO DE REGISTROS</td>
      <td class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['NN'],0,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">SUELDOS Y SALARIOS</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['SUELSAL'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">SOBRESUELDOS, COMISIONES, BONOS Y OTROS INGRESOS GRAVADOS</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['SOBSUELCOMREMU'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">PARTICIPACIÓN UTILIDADES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['PARTUTIL'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">INGRESOS GRAVADOS GENERADOS CON OTROS EMPLEADORES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['INTGRABGEN'],2,",",".") ?></td>
 
    </tr>
    <tr>
      <td width="82%" class="nombre111"> DÉCIMO TERCER SUELDO</td>
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['DECIMTER'],2,",",".") ?></td>
    </tr>
   
    <tr>
      <td width="82%" class="nombre111">DÉCIMO CUARTO SUELDO</td>  
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DECIMCUAR'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">FONDO DE RESERVA</td>  
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['FONDORESERVA'],2,",",".")  ?></td>
    </tr>
     <tr>
      <td width="82%" class="nombre111">COMPENSACION ECONOMICA DEL SALARIO DIGNO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['SALARIODIGNO'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">OTROS INGRESOS EN RELACIÓN DE DEPENDENCIA QUE NO CONSTITUYEN RENTA GRAVADA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['OTROSINGRENGRAV'],2,",",".")  ?></td>
    </tr>
       <tr>
      <td width="82%" class="nombre111">Ingresos gravados con este empleador (Informativo)</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['SUELSAL'],2,",",".")  ?></td>
    </tr>
    <tr>
    <td width="82%" class="nombre111"> APORTE PERSONAL IESS CON ESTE EMPLEADOR (Únicamente pagado por el trabajador)</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['APOPERIESS'],2,",",".")  ?></td>
    </tr>
      <tr>
    <td width="82%" class="nombre111">APORTE PERSONAL IESS CON OTROS EMPLEADORES (Únicamente pagado por el trabajador)</td>
      <td width="18%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
     <tr>
    <td width="82%" class="nombre111"> DEDUCCIÓN GASTOS PERSONALES - VIVIENDA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DEDUCVIVIENDA'],2,",",".")  ?></td>
    </tr> 
     <tr>    
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - SALUD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DEDUCSALUD'],2,",",".")  ?></td>
    </tr> 
       <tr>
    <td width="82%" class="nombre111"> DEDUCCIÓN GASTOS PERSONALES - EDUCACIÓN</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DEDUCEDUCA'],2,",",".")  ?></td>
    </tr> 
     <tr>
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - ALIMENTACIÓN</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DEDUCALIEMENT'],2,",",".")  ?></td>
    </tr> 
      <tr>
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - VESTIMENTA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['DEDUCVESTIM'],2,",",".")  ?></td>
    </tr>    
        <tr>, 
    <td width="82%" class="nombre111"> EXONERACIÓN POR DISCAPACIDAD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['EXODISCAP'],2,",",".")  ?></td>
    </tr>      
    
       <tr>
    <td width="82%" class="nombre111"> EXONERACIÓN POR TERCERA EDAD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['EXOTERED'],2,",",".")  ?></td>
    </tr>   
    
        <tr>
    <td width="82%" class="nombre111"> IMPUESTO A LA RENTA ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo '0.00' ?></td>
    </tr> 
  
       <tr>
    <td width="82%" class="nombre111">BASE IMPONIBLE GRAVADA </td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['BASIMP'],2,",",".")  ?></td>
    </tr> 
    
    <tr>
    <td width="82%" class="nombre111"> IMPUESTO A LA RENTA CAUSADO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['IMPRENTCAUS'],2,",",".")  ?></td>
    </tr> 
      
     <tr> 
    <td width="82%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO Y ASUMIDO POR OTROS EMPLEADORES DURANTE EL PERÃ�ODO DECLARADO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['VALRETASUOTROSEMPLS'],2,",",".")  ?></td>
    </tr>    
     
        <tr>
    <td width="82%" class="nombre111"> VALOR DEL IMPUESTO ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['VALIMPASUESTEEMPL'],2,",",".")  ?></td>
    </tr> 
     
        <tr>
          <td width="82%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO AL TRABAJADOR POR ESTE EMPLEADOR</td>
          <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['VALRET'],2,",",".")  ?></td>
    </tr>
	  
        </tbody>
</table>

 <table width="800" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#C7D2EB" class="nombre">SECCIÓN CONTRIBUCIÓN SOLIDARIA SOBRE REMUNERACIONES</td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">NÚMERO DE REGISTROS "CONTRIBUCIONES GENERADAS"</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['REMUNCONTRESTEMPL'],0,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">INGRESOS CON ESTE EMPLEADOR (MATERIA GRAVADA DE LA CONTRIBUCIÓN)</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['REMUNCONTRESTEMPL'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">TOTAL INGRESOS (MATERIA GRAVADA DE LA CONTRIBUCIÓN)     </td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTREMUNCONTR'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">TOTAL DE CONTRIBUCIÓN GENERADA </td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTCONTRGEN'] ,2,",",".")?></td>
    </tr> 
     <tr>
       <td width="82%" class="nombre111"> CRÉDITO TRIBUTARIO POR DONACIÓN</td>
       <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRPAG'] ,2,",",".")?></td>
    </tr>      
    
       <tr>
    <td width="82%" class="nombre111"> CONTRIBUCIÓN A PAGAR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRPAG'] ,2,",",".")?></td>
    </tr>   
    
        <tr>
    <td width="82%" class="nombre111"> CONTRIBUCIÓN ASUMIDA POR OTROS EMPLEADORES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRASUOTREMPL'] ,2,",",".")?></td>
    </tr> 
  
       <tr>
    <td width="82%" class="nombre111"> CONTRIBUCIÓN RETENIDA POR OTROS EMPLEADORES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRRETOTREMPL'] ,2,",",".")?></td>
    </tr> 
    
    <tr>
    <td width="82%" class="nombre111"> CONTRIBUCIÓN ASUMIDA POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRASUESTEMPL'] ,2,",",".")?></td>
    </tr> 
      
     <tr>
    <td width="82%" class="nombre111"> CONTRIBUCIÓN RETENIDA POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRRETESTEMPL'] ,2,",",".")?></td>
    </tr>    
      
  </tbody>
</table>
 
<br>

<table width="800" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr class="descripcion">
      <td colspan="3">Declaro que los datos contenidos en este anexo son verdaderos, por lo que asumo la responsabilidad correspondiente, de acuerdo a lo establecido<br>
      en el Art. 101 de la Codificación de la Ley de Régimen Tributario Interno.</td>
    </tr>
    <tr class="nombre2">
      <td colspan="3"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    </tr>
    <tr class="nombre2">
      <td width="298" class="nombre">Firma del Contador</td>
      <td width="162">&nbsp;</td>
      <td width="332" class="nombre">Firma del Representante Legal</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" class="nombre111">El talÃ³n resumen generado por el DIMM no significa que el archivo se encuentre presentado y cargado en el SRI. </td>
    </tr>
  </tbody>
</table>
</body>
	</div>
</html>	