<?php 
session_start( );   
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
class componente{
  
      private $obj;
      private $bd;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario($id ){
      
       
          $sql = "select
		  count(idret) as nn ,
		   sum(suelsal) as suelsal,
		   sum(sobsuelcomremu) as sobsuelcomremu,
		   sum(partutil) as partutil,
		   sum(intgrabgen) as intgrabgen,
	 	   sum(imprentempl) as imprentempl,
		   sum(decimter) as decimter,
		   sum(decimcuar) as decimcuar,
		   sum(fondoreserva) as fondoreserva,
		   sum(salariodigno) as salariodigno,
		   sum(otrosingrengrav) as otrosingrengrav,
		   sum(apoperiess) apoperiess,
		   sum(aporperiessconotrosempls) as aporperiessconotrosempls,
		   sum(deducvivienda) as deducvivienda,
		   sum(deducsalud) as deducsalud,
		   sum(deduceducartcult) as deduceduca,
		   sum(deducaliement) as deducaliement,
		   sum(deducvestim) as deducvestim ,
		   sum(exodiscap) as exodiscap,
		   sum(exotered) as exotered,
		   sum(basimp) as basimp,
		   sum(imprentcaus) as imprentcaus,
		   sum(valretasuotrosempls) as valretasuotrosempls,
		   sum(valimpasuesteempl) as valimpasuesteempl,
		   sum(valret) as valret
		 from nom_redep
		 where  anio = ".$this->bd->sqlvalue_inyeccion($id, true);
          
        
           
           
          $resultado1 =  $this->bd->ejecutar($sql);
          
          $datosEmpleado  =  $this->bd->obtener_array( $resultado1);
           
 
          return $datosEmpleado;
      
      }
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 }    
   $gestion   = 	new componente;
  
   $id            		= $_GET['anio'];
   
   $datosEmpleado = $gestion->FiltroFormulario(  $id );

 ?>
  <h4><b>Resumen Relacion de Dependencia <?php echo $id ?> </b></h4>
  
<table border="1">
  <tbody>
    <tr>
      <td colspan="2" bgcolor="#C7D2EB" class="nombre111">INFORMACIÓN ORIGINAL</td>
    </tr>
    <tr class="nombre">
      <td>DESCRIPCION</td>
      <td>VALOR</td>
    </tr>
    <tr>
      <td class="nombre111">NUMERO DE REGISTROS</td>
      <td class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['nn'],0,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">SUELDOS Y SALARIOS</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['suelsal'],2,",",".")?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">SOBRESUELDOS, COMISIONES, BONOS Y OTROS INGRESOS GRAVADOS</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['sobsuelcomremu'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">PARTICIPACIÓN UTILIDADES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['partutil'],2,",",".") ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">INGRESOS GRAVADOS GENERADOS CON OTROS EMPLEADORES</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['intgrabgen'],2,",",".") ?></td>
 
    </tr>
    <tr>
      <td width="82%" class="nombre111"> DÉCIMO TERCER SUELDO</td>
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php echo number_format($datosEmpleado['decimter'],2,",",".") ?></td>
    </tr>
   
    <tr>
      <td width="82%" class="nombre111">DÉCIMO CUARTO SUELDO</td>  
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['decimcuar'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">FONDO DE RESERVA</td>  
	  <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['fondoreserva'],2,",",".")  ?></td>
    </tr>
     <tr>
      <td width="82%" class="nombre111">COMPENSACION ECONOMICA DEL SALARIO DIGNO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['salariodigno'],2,",",".")  ?></td>
    </tr>
    <tr>
      <td width="82%" class="nombre111">OTROS INGRESOS EN RELACIÓN DE DEPENDENCIA QUE NO CONSTITUYEN RENTA GRAVADA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['otrosingrengrav'],2,",",".")  ?></td>
    </tr>
       <tr>
      <td width="82%" class="nombre111">Ingresos gravados con este empleador (Informativo)</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['suelsal'],2,",",".")  ?></td>
    </tr>
    <tr>
    <td width="82%" class="nombre111"> APORTE PERSONAL IESS CON ESTE EMPLEADOR (Únicamente pagado por el trabajador)</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['apoperiess'],2,",",".")  ?></td>
    </tr>
      <tr>
    <td width="82%" class="nombre111">APORTE PERSONAL IESS CON OTROS EMPLEADORES (Únicamente pagado por el trabajador)</td>
      <td width="18%" class="nombre11" align="right" valign="middle">0.00</td>
    </tr>
     <tr>
    <td width="82%" class="nombre111"> DEDUCCIÓN GASTOS PERSONALES - VIVIENDA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducvivienda'],2,",",".")  ?></td>
    </tr> 
     <tr>    
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - SALUD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducsalud'],2,",",".")  ?></td>
    </tr> 
       <tr>
    <td width="82%" class="nombre111"> DEDUCCIÓN GASTOS PERSONALES - EDUCACIÓN</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deduceducartcult'],2,",",".")  ?></td>
    </tr> 
     <tr>
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - ALIMENTACIÓN</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducaliement'],2,",",".")  ?></td>
    </tr> 
      <tr>
    <td width="82%" class="nombre111">DEDUCCIÓN GASTOS PERSONALES - VESTIMENTA</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['deducvestim'],2,",",".")  ?></td>
    </tr>    
    <tr>
    <td width="82%" class="nombre111"> EXONERACIÓN POR DISCAPACIDAD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['exodiscap'],2,",",".")  ?></td>
    </tr>      
    
       <tr>
    <td width="82%" class="nombre111"> EXONERACIÓN POR TERCERA EDAD</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['exotered'],2,",",".")  ?></td>
    </tr>   
    
        <tr>
    <td width="82%" class="nombre111"> IMPUESTO A LA RENTA ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php echo '0.00' ?></td>
    </tr> 
  
       <tr>
    <td width="82%" class="nombre111">BASE IMPONIBLE GRAVADA </td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['basimp'],2,",",".")  ?></td>
    </tr> 
    
    <tr>
    <td width="82%" class="nombre111"> IMPUESTO A LA RENTA CAUSADO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['imprentcaus'],2,",",".")  ?></td>
    </tr> 
      
     <tr> 
    <td width="82%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO Y ASUMIDO POR OTROS EMPLEADORES DURANTE EL PERIODO DECLARADO</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['valretasuotrosempls'],2,",",".")  ?></td>
    </tr>    
     
        <tr>
    <td width="82%" class="nombre111"> VALOR DEL IMPUESTO ASUMIDO POR ESTE EMPLEADOR</td>
      <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['valimpasuesteempl'],2,",",".")  ?></td>
    </tr> 
     
        <tr>
          <td width="82%" class="nombre111"> VALOR DEL IMPUESTO RETENIDO AL TRABAJADOR POR ESTE EMPLEADOR</td>
          <td width="18%" class="nombre11" align="right" valign="middle"><?php   echo number_format($datosEmpleado['valret'],2,",",".")  ?></td>
    </tr>
	  
        </tbody>
</table>

 
  