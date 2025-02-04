<?php

 session_start( );      

 
 require '../../kconfig/Db.class.php';
 
  
 require '../../kconfig/Obj.conf.php';


$obj   = 	new objects;
$bd     = 	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

 
$txtcodigo = $_GET['idred'];
		 // nivel actual

$sql = "SELECT NUMRUC, ANIO, BENGALPG, 
		   TIPIDRET, IDRET, APELLIDOTRAB, 
		   NOMBRETRAB, ESTAB, RESIDENCIATRAB, 
		   PAISRESIDENCIA, APLICACONVENIO, TIPOTRABAJDISCAP, 
		   PORCENTAJEDISCAP, TIPIDDISCAP, IDDISCAP, 
		   SUELSAL, SOBSUELCOMREMU, PARTUTIL, 
		   INTGRABGEN, IMPRENTEMPL, DECIMTER, 
		   DECIMCUAR, FONDORESERVA, SALARIODIGNO, 
		   OTROSINGRENGRAV, INGGRAVCONESTEEMPL, SISSALNET, 
		   APOPERIESS, APORPERIESSCONOTROSEMPLS, DEDUCVIVIENDA, 
		   DEDUCSALUD, DEDUCEDUCA, DEDUCALIEMENT, 
		   DEDUCVESTIM, EXODISCAP, EXOTERED, 
		   BASIMP, IMPRENTCAUS, VALRETASUOTROSEMPLS, 
		   VALIMPASUESTEEMPL, VALRET, IDREDEP, 
		   REMUNCONTRESTEMPL, REMUNCONTROTREMPL, EXONREMUNCONTR, 
		   TOTREMUNCONTR, NUMMESTRABCONTRESTEMPL, NUMMESTRABCONTROTREMPL, 
		   TOTNUMMESTRABCONTR, REMUNMENPROMCONTR, NUMMESCONTRGENESTEMPL, 
		   NUMMESCONTRGENOTREMPL, TOTNUMMESCONTRGEN, TOTCONTRGEN, 
		   CREDTRIBDONCONTROTREMPL, CREDTRIBDONCONTRESTEMPL, CREDTRIBDONCONTRNOESTEMPL, 
		   TOTCREDTRIBDONCONTR, CONTRPAG, CONTRASUOTREMPL, 
		   CONTRRETOTREMPL, CONTRASUESTEMPL, CONTRRETESTEMPL
		 FROM RDEP 
		 WHERE  IDREDEP = ".$bd->sqlvalue_inyeccion($txtcodigo ,true);

 		 $resultado1 = $bd->ejecutar($sql);

		 $datosEmpleado  = $bd->obtener_array( $resultado1);


 $sql1 = "SELECT substr(PAR00RAZON,1,3) as SERIE,substr(PAR00CARA,1,13) as RUC,substr(PAR00RAZON,8,200) as MUNICIPIO
 	   FROM PAR00
	where PAR00CODI = -1";

 		 $resultado2 = $bd->ejecutar($sql1);

		 $datosGad  = $bd->obtener_array( $resultado2);


     
    



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
					font-weight: bold
					 
				}
				.nombre1{
				 	font-size: 8px;
					font-weight: bold;
					text-align:center 
					 
				}
				.nombre11{
				 	font-size: 8px;
					text-align: center
 					 
				}
				.nombre111{
				 	font-size: 9px;
  					 
				}
				.nombre2{
				 	font-size: 10px;
					font-weight: bold;
					
					 
				}
				.nombre21{
				 	font-size: 10px;
 					 
				}
				.descripcion{
					font-size: 24px;
					padding: 30px 0px;
				}
				.logoEmpresa{
					font-size: 11px;
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
		
				<table width="100%" border="1" cellspacing="0" cellpadding="0">
		  <tbody>
		    <tr>
		      <td colspan="2" align="center" valign="middle" class="nombre1"><img src="sri.png" width="108" height="54" alt=""/></td>
		      <td colspan="4" align="center" valign="middle" class="nombre">COMPROBANTE DE RETENCION DE LA CONTRIBUCIÃ“N SOLIDARIA SOBRE LAS REMUNERACIONES</td>
	        </tr>
		    <tr>
		      <td colspan="2" rowspan="2" align="center" class="nombre1" valign="middle">FORMULARIO 107 A<br>
	          RESOLUCIÃ“N No. NAC-DGERCGC16-00000276</td>
		      <td width="369" rowspan="2">&nbsp;</td>
		      <td width="142" colspan="-1" class="nombre2" >AÃ‘O</td>
		      <td width="132" colspan="-1" class="nombre2" >MES</td>
		      <td width="122" colspan="-1" class="nombre2" >DIA</td>
	        </tr>
		    <tr>
		      <td colspan="-1" class="nombre2" >2017</td>
		      <td colspan="-1" class="nombre2" >01</td>
		      <td colspan="-1" class="nombre2" >31</td>
	        </tr>
		    </tbody>
	    </table>
		<br>
		
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
		  <tbody>
		    <tr>
		      <td colspan="8" bgcolor="#C7D2EB" class="nombre" >100 IdentificaciÃ³n del Empleador o Contratante (Agente de RetenciÃ³n)</td>
	        </tr>
		    <tr>
		      <td width="3%" class="nombre2" rowspan="2" bgcolor="#C7D2EB">105</td>
		      <td colspan="2" class="nombre21" >RUC</td>
		      <td width="3%" colspan="-1" rowspan="2" class="nombre2" bgcolor="#C7D2EB" >106</td>
		      <td width="52%" colspan="4" class="nombre21" >RAZÃ“N SOCIAL O APELLIDOS Y NOMBRES COMPLETOS</td>
	        </tr>
		    <tr>
		      <td colspan="2" class="nombre2" ><?php echo $datosGad['RUC']?></td>
		      <td colspan="4" class="nombre2" ><?php echo $datosGad['MUNICIPIO']?></td>
	        </tr>
		    <tr>
		      <td colspan="8" bgcolor="#C7D2EB" class="nombre" >200 IdentificaciÃ³n del Sujeto Pasivo de la ContribuciÃ³n</td>
	        </tr>
		    <tr>
		      <td rowspan="2" class="nombre2" bgcolor="#C7D2EB" >201</td>
		      <td colspan="2" class="nombre21" >CÃ‰DULA O PASAPORTE</td>
		      <td colspan="-1" rowspan="2" class="nombre2" bgcolor="#C7D2EB">202</td>
		      <td colspan="4" class="nombre21" >APELLIDOS Y NOMBRES COMPLETOS</td>
	        </tr>
		    <tr> 
		      <td colspan="2" class="nombre2" ><?php echo $datosEmpleado['IDRET']?></td>
		      <td colspan="4" class="nombre2" ><?php echo $datosEmpleado['APELLIDOTRAB'].' '.$datosEmpleado['NOMBRETRAB'] ?></td>
	        </tr>
	      </tbody>
	    </table>
	    <br> 
	    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td colspan="4" bgcolor="#C7D2EB" class="nombre">LiquidaciÃ³n de la contribuciÃ³n</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">INGRESOS CON ESTE EMPLEADOR (MATERIA GRAVADA DE LA CONTRIBUCIÃ“N)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >310</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['REMUNCONTRESTEMPL'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">INGRESOS CON OTROS EMPLEADORES (MATERIA GRAVADA DE LA CONTRIBUCIÃ“N)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >320</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">EXONERACIONES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >330</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">TOTAL INGRESOS (MATERIA GRAVADA DE LA CONTRIBUCIÃ“N)     (310 + 320 - 330)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >350</td>
      <td width="5%" align="center" class="nombre11">=</td> 
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTREMUNCONTR'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">NÃšMERO DE MESES TRABAJADOS CON ESTE EMPLEADOR (DURANTE LA VIGENCIA DE LA CONTRIBUCIÃ“N)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >360</td>
      <td width="5%" align="center" class="nombre11">+</td> 
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['NUMMESTRABCONTRESTEMPL'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111"> NÃšMERO DE MESES TRABAJADOS CON OTROS EMPLEADORES (DURANTE LA VIGENCIA DE LA CONTRIBUCIÃ“N)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >370</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
   
    <tr>
      <td width="70%" class="nombre111">NÃšMERO DE MESES TRABAJADOS (360 + 370)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >380</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTNUMMESTRABCONTR'],2,",",".")?></td>
    </tr>
    <tr>   
      <td width="70%" class="nombre111">INGRESO MENSUAL PROMEDIO DURANTE EL PERÃ�ODO DE VIGENCIA (350 / 380)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >399</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle">  <?php echo number_format($datosEmpleado['REMUNMENPROMCONTR'] ,2,",",".")?>
      </td>
    </tr>
    <tr>
    <td width="70%" class="nombre111">NÃšMERO DE MESES DE CONTRIBUCIÃ“N GENERADA CON OTROS EMPLEADORES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >410</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
      <tr>
    <td width="70%" class="nombre111">NÃšMERO DE MESES DE CONTRIBUCIÃ“N GENERADA CON ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >420</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['NUMMESCONTRGENESTEMPL'] ,2,",",".")?></td>
    </tr>
     <tr>
    <td width="70%" class="nombre111">NÃšMERO DE MESES DE CONTRIBUCIÃ“N GENERADA (410 + 420)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >430</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTNUMMESCONTRGEN'] ,2,",",".")?></td> 
    </tr> 
     <tr>
    <td width="70%" class="nombre111">TOTAL DE CONTRIBUCIÃ“N GENERADA (399 x 430 x 3,33%)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >499</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['TOTCONTRGEN'] ,2,",",".")?></td>
    </tr> 
       <tr>
    <td width="70%" class="nombre111">CRÃ‰DITO TRIBUTARIO POR DONACIÃ“N UTILIZADO POR OTROS EMPLEADORES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >530</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
     <tr>
    <td width="70%" class="nombre111">CRÃ‰DITO TRIBUTARIO POR DONACIÃ“N UTILIZADO POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >540</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
      <tr>
    <td width="70%" class="nombre111">CRÃ‰DITO TRIBUTARIO POR DONACIÃ“N NO UTILIZADO POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >550</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>    
        <tr>
    <td width="70%" class="nombre111"> CRÃ‰DITO TRIBUTARIO POR DONACIÃ“N (530+540)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >560</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>      
    
       <tr>
    <td width="70%" class="nombre111"> CONTRIBUCIÃ“N A PAGAR Si (499 - 560) > 0 = (499 - 560)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >599</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['CONTRPAG'] ,2,",",".")?></td>
    </tr>   
    
        <tr>
    <td width="70%" class="nombre111"> CONTRIBUCIÃ“N ASUMIDA POR OTROS EMPLEADORES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >610</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
  
       <tr>
    <td width="70%" class="nombre111"> CONTRIBUCIÃ“N RETENIDA POR OTROS EMPLEADORES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >620</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
    
    <tr>
    <td width="70%" class="nombre111"> CONTRIBUCIÃ“N ASUMIDA POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >630</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
      
     <tr>
    <td width="70%" class="nombre111"> CONTRIBUCIÃ“N RETENIDA POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >640</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>    
      
  </tbody>
</table>


  <br> 
	    <table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td bgcolor="#C7D2EB" class="nombre">IMPORTANTE: SÃ­rvase leer cada una de las siguientes instrucciones.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">1.- La informaciÃ³n a ser registrada en este formulario corresponde a la generada exclusivamente en el perÃ­odo de vigencia de la ContribuciÃ³n por RemuneraciÃ³n; es decir, desde el 1 de junio de 2016 al 31 de enero de 2017.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">2.- El trabajador que, en el mismo perÃ­odo fiscal haya reiniciado su actividad con otro empleador, estarÃ¡ en la obligaciÃ³n de entregar el formulario 107-A entregado por su anterior empleador a su nuevo empleador, para que este Ãºltimo,<br>
      efectÃºe el cÃ¡lculo de las retenciones a realizarse en lo que resta de la vigencia de la contribuciÃ³n.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">3.- En los campos 310 y 320 se deberÃ¡ considerar que, si con posterioridad al mes de abril de 2016, el empleador y empleado pactaron la disminuciÃ³n de la remuneraciÃ³n fija a travÃ©s de cualquier figura jurÃ­dica, se deberÃ¡ aplicar la base<br>
      imponible del mes de abril de 2016, de acuerdo a los seÃ±alado en el tercer inciso del artÃ­culo 2 del Reglamento para la aplicaciÃ³n de la Ley de Solidaridad.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">4.- El campo 320 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 310 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr>
    <tr>
         <td width="70%" class="nombre111">5.- El campo 330 corresponde a lo seÃ±alado en el artÃ­culo 3 del Reglamento para la aplicaciÃ³n de la Ley orgÃ¡nica de solidaridad y de corresponsabilidad ciudadana para la reconstrucciÃ³n y reactivaciÃ³n de las zonas afectadas por el<br>
         terremoto de 16 de abril de 2016.</td>
    </tr>
    <tr>
       <td width="70%" class="nombre111">6.- El campo 370 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 360 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr>
   
    <tr>
      <td width="70%" class="nombre111">7.- El nÃºmero de meses registrados en los campos 380 y 430 no deberÃ¡n ser mayor a los 8 meses de vigencia de esta contribuciÃ³n.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">8.- En los campos 410 y 420 se deberÃ¡ contar como contribuciÃ³n generada, el valor antes de aplicar crÃ©dito tributario por donaciones.</td>
    </tr>
    <tr>
    <td width="70%" class="nombre111">9.- El campo 410 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 420 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr>
      <tr>
    <td width="70%" class="nombre111">10.- El campo 530 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 540 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr>
     <tr>
    <td width="70%" class="nombre111">11.- El campo 540 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 550 del Formulario 107-A entregado por el anterior empleador, mÃ¡s las donaciones adicionales que presente el trabajador.</td>
    </tr> 
     <tr>
    <td width="70%" class="nombre111">12.- El valor registrado en el campo 599 no deberÃ¡n ser menor a cero (0).</td>
    </tr> 
       <tr>
    <td width="70%" class="nombre111">13.- El campo 610 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 630 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr> 
     <tr>
    <td width="70%" class="nombre111">14.- El campo 620 deberÃ¡ ser llenado con la informaciÃ³n registrada en el campo 640 del Formulario 107-A entregado por el anterior empleador.</td>
    </tr> 
      <tr>
    <td width="70%" class="nombre111">15.- Si la suma de los campos 610, 620, 630 y 640 es menor al campo 599, el trabajador deberÃ¡ pagar el valor pendiente de la contribuciÃ³n a travÃ©s del formulario 106.</td>
    </tr>    
        <tr>
    <td width="70%" class="nombre111">16.- Si la suma de los campos 610, 620, 630 y 640 es mayor al campo 599, no procede devoluciÃ³n ni crÃ©dito tributario posterior de acuerdo a lo establecido en el Ãºltimo inciso del artÃ­culo 4 del Reglamento para la aplicaciÃ³n de la Ley de<br>
      Solidaridad</td>
    </tr>      
    
       <tr>
         <td width="70%" class="nombre111">DECLARO QUE LOS DATOS PROPORCIONADOS EN ESTE DOCUMENTO SON EXACTOS Y VERDADEROS, POR LO QUE ASUMO LA RESPONSABILIDAD LEGAL QUE DE ELLA SE DERIVEN (Art. 101 de la L.R.T.I.) </td>
    </tr>   
    
        </tbody>
</table>
<br>

<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tbody>
    <tr class="nombre2">
      <td>FIRMA DEL AGENTE DE RETENCIÃ“N</td>
      <td>FIRMA DEL TRABAJADOR CONTRIBUYENTE</td>
      <td>FIRMA DEL CONTADOR</td>
    </tr>
    <tr>
      <td><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="right" valign="middle">&nbsp;</td>
      <td class="nombre1">RUC CONTADOR</td>
    </tr>
  </tbody>
</table>
</body>
	</div>
</html>	