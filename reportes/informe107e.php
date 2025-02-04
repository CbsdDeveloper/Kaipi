<?php
session_start( );  
ob_start(); 
$id_rol 	= $_GET['r'];
$_SESSION['us']		= $_GET['us'];
'' 	= $_GET['db'];
$_SESSION['ac']		= $_GET['ac'];
$_SESSION['ruc_registro'] 	= $_GET['rd'];

require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

$obj    = 	new objects;
$bd     = 	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

		 $txtcodigo = $_GET['i'];
		 $sql1      	 = "SELECT *  FROM web_registro where ruc_registro = ".$bd->sqlvalue_inyeccion(trim($_SESSION['ruc_registro']), true);
 		 $resultado2     = $bd->ejecutar($sql1);
		 $datosGad       = $bd->obtener_array( $resultado2);
		 
		 $sql 			 = "SELECT *  FROM nom_redep  	 WHERE  id_redep = ".$bd->sqlvalue_inyeccion($txtcodigo, true);
 		 $resultado1 	 = $bd->ejecutar($sql);
		 $datosEmpleado  = $bd->obtener_array( $resultado1);


 ?>
<!DOCTYPE html>
<html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			
 <style>
	 
	body {
		font-size: 9px;
		color:#000;
	    margin: 2mm 4mm 8mm 4mm;
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
				 	font-size: 9px;
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
				margin:3px 0 3px 0;
			    border-collapse: collapse;
 				width: 100%  
 			  }
 
			table, th, td {
			   border: .40mm solid thin #909090;
			}

				
			</style>
			
</head>
	
<body> 
			
		 
		
	<table>
		
  		    <tr>
		      <td colspan="2" width="20%"  align="center" valign="middle" class="nombre1"><img src="../ktributacion/reportes/sri.png" width="108" height="54" alt=""/></td>
		      <td colspan="4" width="80%" align="center" valign="middle" class="nombre">COMPROBANTE DE RETENCIONES EN LA FUENTE DEL IMPUESTO A LA RENTA POR INGRESOS DEL TRABAJO EN RELACIÓN DE DEPENDENCIA</td>
	        </tr>
		    <tr>
		      <td colspan="2" rowspan="2" align="center" class="nombre1" valign="middle">FORMULARIO 107  </td>
		      <td rowspan="2">&nbsp;</td>
		      <td class="nombre2" align="center"  >AÑO</td>
		      <td class="nombre2" align="center"  >MES</td>
		      <td class="nombre2" align="center"  >DIA</td>
	        </tr>
		    <tr>
		      <td class="nombre2" align="center"  ><?php echo $datosEmpleado['anio']?></td>
		      <td class="nombre2" align="center"  >12</td>
		      <td class="nombre2" align="center"  >31</td>
	        </tr>
 	    </table>
		<br>
		
	<table>
		
 		    <tr>
		      <td colspan="8" width="100%" bgcolor="#C7D2EB" class="nombre" >100 Identificación del Empleador o Contratante (Agente de Retención)</td>
	        </tr>
		    <tr>
		      <td width="2%"  class="nombre2" rowspan="2" bgcolor="#C7D2EB">105</td>
		      <td colspan="2" width="30%"  class="nombre21" >RUC</td>
		      <td width="2%"  rowspan="2" class="nombre2" bgcolor="#C7D2EB" >106</td>
		      <td width="25%" colspan="4" class="nombre21" >RAZÓN SOCIAL O APELLIDOS Y NOMBRES COMPLETOS</td>
	        </tr>
		    <tr>
		      <td colspan="2" width="30%" class="nombre2" ><?php echo $datosGad['ruc_registro']?></td>
		      <td colspan="4" width="30%" class="nombre2" ><?php echo $datosGad['razon']?></td>
	        </tr>
		    <tr>
		      <td colspan="8" bgcolor="#C7D2EB" class="nombre" >200 Identificación del Sujeto Pasivo de la Contribución</td>
	        </tr>
		    <tr>
		      <td rowspan="2" class="nombre2" bgcolor="#C7D2EB" >201</td>
		      <td colspan="2" class="nombre21" >CéDULA O PASAPORTE</td>
		      <td rowspan="2" class="nombre2" bgcolor="#C7D2EB">202</td>
		      <td colspan="4" class="nombre21" >APELLIDOS Y NOMBRES COMPLETOS</td>
	        </tr>
		    <tr> 
		      <td colspan="2" class="nombre2" ><?php echo $datosEmpleado['idret']?></td>
		      <td colspan="4" class="nombre2" ><?php echo $datosEmpleado['apellidotrab'].' '.$datosEmpleado['nombretrab'] ?></td>
	        </tr>
 	    </table>
	    <br> 
	
	<table>
		
  <tbody>
    <tr>
      <td colspan="4" bgcolor="#C7D2EB" class="nombre">Liquidación de la contribución</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">SUELDOS Y SALARIOS</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >301</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['suelsal'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">SOBRESUELDOS, COMISIONES, BONOS Y OTROS INGRESOS GRAVADOS</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >303</td>
      <td width="5%" align="center" class="nombre11">+</td>     
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['sobsuelcomremu'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">PARTICIPACIÓN UTILIDADES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >305</td>
      <td width="5%" align="center" class="nombre11">+</td>                           
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['partutil'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">INGRESOS GRAVADOS GENERADOS CON OTROS EMPLEADORES</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >307</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['intgrabgen'],2,",",".") ?></td>
 
    </tr>
    <tr>
      <td width="70%" class="nombre111"> DÉCIMO TERCER SUELDO</td>
	  <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11">311</td> 
      <td width="5%" align="center" class="nombre11"></td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['decimter'],2,",",".") ?></td>
    </tr>
   
    <tr>
      <td width="70%" class="nombre111">DÉCIMO CUARTO SUELDO</td>  
		<td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >313</td>
      <td width="5%" align="center" class="nombre11">.</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['decimcuar'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">FONDO DE RESERVA</td>  
		<td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >313</td>
      <td width="5%" align="center" class="nombre11">.</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['fondoreserva'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">OTROS INGRESOS EN RELACIÓN DE DEPENDENCIA QUE NO CONSTITUYEN RENTA GRAVADA</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11">317</td>
      <td width="5%" align="center" class="nombre11"></td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
    <tr>
    <td width="70%" class="nombre111">(-) APORTE PERSONAL IESS CON ESTE EMPLEADOR (Únicamente pagado por el trabajador)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >351</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['apoperiess'],2,",",".")  ?></td>
    </tr>
      <tr>
    <td width="70%" class="nombre111">(-) APORTE PERSONAL IESS CON OTROS EMPLEADORES (Únicamente pagado por el trabajador)</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >353</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
     <tr>
    <td width="70%" class="nombre111">(-) DEDUCCIÓN GASTOS PERSONALES - VIVIENDA</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >361</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducvivienda'],2,",",".")  ?></td>
    </tr> 
     <tr>    
    <td width="70%" class="nombre111">(-) DEDUCCIÓN GASTOS PERSONALES - SALUD</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >363</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducsalud'],2,",",".")  ?></td>
    </tr> 
	  
	  
     <tr>
    <td width="70%" class="nombre111"> (-) DEDUCCIÓN GASTOS PERSONALES - EDUCACIÓN Y CULTURA</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >365</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deduceducartcult'],2,",",".")  ?></td>
    </tr> 
     <tr>
    <td width="70%" class="nombre111">(-) DEDUCCIÓN GASTOS PERSONALES - ALIMENTACIÓN</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >367</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducaliement'],2,",",".")  ?></td>
    </tr> 
      <tr>
    <td width="70%" class="nombre111">(-) DEDUCCIÓN GASTOS PERSONALES - VESTIMENTA</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >369</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducvestim'],2,",",".")  ?></td>
    </tr>    
        <tr>
    <td width="70%" class="nombre111"> (-) EXONERACIÓN POR DISCAPACIDAD</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >371</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>      
    
       <tr>
    <td width="70%" class="nombre111"> (-) EXONERACIÓN POR TERCERA EDAD</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >373</td>
      <td width="5%" align="center" class="nombre11">-</td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>   
    
        <tr>
    <td width="70%" class="nombre111"> IMPUESTO A LA RENTA ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >381</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php echo '0.00' ?></td>
    </tr> 
  
       <tr>
    <td width="70%" class="nombre111">BASE IMPONIBLE GRAVADA
301+303+305+307-351-353-361-363-365-367-369-371-373+381 mayor o igual a 0</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >399</td>
      <td width="5%" align="center" class="nombre11">+</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['basimp'],2,",",".")  ?></td>
    </tr> 
    
    <tr>
    <td width="70%" class="nombre111"> IMPUESTO A LA RENTA CAUSADO</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >401</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['imprentcaus'],2,",",".")  ?></td>
    </tr> 
      
     <tr>
    <td width="70%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO Y ASUMIDO POR OTROS EMPLEADORES DURANTE EL PERÍODO DECLARADO</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >403</td>
      <td width="5%" align="center" class="nombre11"></td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>    
     
        <tr>
    <td width="70%" class="nombre111"> VALOR DEL IMPUESTO ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >405</td>
      <td width="5%" align="center" class="nombre11"></td>
      <td width="20%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr> 
     
        <tr>
    <td width="70%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO AL TRABAJADOR POR ESTE EMPLEADOR</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >407</td>
      <td width="5%" align="center" class="nombre11"></td>
      <td width="20%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['valret'],2,",",".")  ?></td>
    </tr>
	  
        <tr>
    <td width="70%" class="nombre111"> INGRESOS GRAVADOS CON ESTE EMPLEADOR (informativo)
301+303+305+381</td>
      <td width="5%" align="center"  bgcolor="#C7D2EB" class="nombre11" >349</td>
      <td width="5%" align="center" class="nombre11">=</td>
      <td width="20%" class="nombre11" align="right" valign="middle">
		  <?php 
				$var = $datosEmpleado['suelsal'];
				$var2 = $datosEmpleado['sobsuelcomremu']; 
				  
				$vartotal =   $var2 + $var;
				
				echo number_format($vartotal ,2,",",".")
		  
		  ?></td>
    </tr> 
      
  </tbody>
</table>

      <br> 
	
 	<table>
	 
  <tbody>
    <tr>
      <td bgcolor="#C7D2EB" class="nombre">IMPORTANTE: Sírvase leer cada una de las siguientes instrucciones.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111"> 1.- El trabajador que, en el mismo periódo fiscal haya reiniciado su actividad con otro empleador, estará en la obligación de entregar el formulario 107 entregado por su anterior empleador a su nuevo empleador, para que aquel, efectúe el cálculo de las retenciones a realizarse en lo que resta del año.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">2.- El campo 307 deberá ser llenado con la información registrada en el campo 349 del Formulario 107 entregado por el anterior empleador, y/o con la proyección de ingresos de otros empleadores actuales, en caso de que el empleador
</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">3.- La deducción total por gastos personales no deberá superar el 50% del total de ingresos gravados, y en ningún caso será mayor al equivalente a 1.3 veces la fracción básica exenta de Impuesto a la Renta de personas naturales.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">4.- A partir del año 2011 debe considerarse como cuantía máxima para cada tipo de gasto, el monto equivalente a la fracción básica exenta de Impuesto a la Renta en:
vivienda 0.325 veces, educación 0.325 veces, alimentación 0.325 veces, vestimenta 0.325, salud 1.3 veces.</td>
    </tr>
    <tr>
         <td width="70%" class="nombre111">5.- El trabajador deberá presentar el Anexo de Gastos Personales que deduzca, de cumplir las condiciones establecidas por el Servicio de Rentas Internas.</td>
    </tr>
    <tr>
       <td width="70%" class="nombre111">6.- De conformidad con la Resolución No. NAC-DGER2008-0566 publicada en el Registro Oficial No. 342 el 21 de mayo del 2008, el beneficio de la exoneración por tercera edad se configura a partir del ejercicio en el cual el beneficiario
cumpla los 65 años de edad. El monto de la exoneración será el equivalente al doble de la fracción básica exenta de Impuesto a la Renta.td>
    </tr>
   
    <tr>
      <td width="70%" class="nombre111">7.- A partir del año 2013, conforme lo dispuesto en la Ley Orgánica de Discapacidades el monto de la exoneración por discapacidad sería el equivalente al doble de la fracción básica exenta de Impuesto a la Renta.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">8.- El presente formulario constituye la declaración de Impuesto a la Renta del trabajador, siempre que durante el período declarado la persona únicamente haya prestado sus servicios en relación de dependencia con el empleador que
entrega este formulario, y no existan valores de gastos personales que deban ser reliquidados. En caso de pérdida de este documento el trabajador deberá solicitar una copia a su empleador.
Por el contrario, el trabajador deberá presentar obligatoriamente su declaración de Impuesto a la Renta cuando haya obtenido rentas en relación de dependencia con dos o más empleadores o haya recibido además de su remuneración
ingresos de otras fuentes como por ejemplo: rendimientos financieros, arrendamientos, ingresos por el libre ejercicio profesional, u otros ingresos, los cuales en conjunto superen la fracción básica exenta de Impuesto a la Renta de
personas naturales, o cuando tenga que reliquidar gastos personales con aquellos efectivamente incurridos, teniendo presente los trámites referidos en las notas 3 y 4 de este documento.</td>
    </tr>
    <tr>
      <td width="70%" class="nombre111">DECLARO QUE LOS DATOS PROPORCIONADOS EN ESTE DOCUMENTO SON EXACTOS Y VERDADEROS, POR LO QUE ASUMO LA RESPONSABILIDAD LEGAL QUE DE ELLA SE DERIVEN (Art. 101 de la L.R.T.I.) </td>
    </tr>   
    
        </tbody>
</table>
		
	<br>

<table>
	
  <tbody>
    <tr class="nombre2">
      <td align="center">FIRMA AGENTE DE RETENCIÓN</td>
      <td align="center">FIRMA TRABAJADOR CONTRIBUYENTE</td>
      <td align="center">FIRMA  CONTADOR</td>
    </tr>
    <tr>
      <td align="center"><img src="../kimages/firma1.png" width="104" height="60"/></td>
      <td>&nbsp;</td>
      <td align="center"><img src="../kimages/firma.png" width="104" height="60"/></td>
    </tr>
    <tr>
      <td align="center">GERENTE GENERAL</td>
      <td align="center" valign="middle"><span class="nombre21"><?php echo $datosEmpleado['idret']?> / <?php echo $datosEmpleado['apellidotrab'].' '.$datosEmpleado['nombretrab'] ?></span></td>
      <td align="center"  class="nombre21">CONTADOR(A)</td>
    </tr>
  </tbody>
</table>
	
</body>
	 
</html>	
<?php
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new DOMPDF();


$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientaciónl landscape

$dompdf->load_html( (ob_get_clean()));

$dompdf->render(); // Generar el PDF desde contenido HTML

$pdf = $dompdf->output(); // Obtener el PDF generado

//$dompdf->stream(); // Enviar el PDF generado al navegador
 
//$filename = "Anexo".time().'.pdf';
$filename = "Formulario_107".'.pdf';

file_put_contents($filename, $pdf);
 
$dompdf->stream($filename, array("Attachment" => false));
		 
?> 