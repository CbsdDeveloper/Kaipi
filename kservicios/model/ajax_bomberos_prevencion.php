<?php
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$id_renpago        = $_GET['id'];


$bd_local	   =	new Db;
$bd_local->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$servidor ='192.168.1.3';
$base_datos = 'db_cbsd';
$usuario = 'postgres';
$password = 'Cbsd2019';


$bd_cat	   =	new Db;
$bd_cat->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

 $sql = "select id_ren_movimiento, enlace,documento
		      from  rentas.ren_movimiento
	         where estado = 'P' and  
			 	   enlace > 0 and 
				   id_renpago =" .$bd_local->sqlvalue_inyeccion($id_renpago,true);


   $resultado  = $bd_local->ejecutar($sql);
       
     while ($x=$bd_local->obtener_fila($resultado)){

		$enlace   =   $x['enlace'] ;
		$documento=   trim($x['documento'] );
	    externo_bomberos($bd_cat	,$enlace,$documento);

	}	
 
    echo 'Datos actualizado...'.	trim($documento);
 //--------------------------------------------------------
 //--------------------------------------------------------
 function externo_bomberos($bd_cat	,$id_emite_externo,$documento){

	
  


	$documento1 = trim($documento);
	
    $hoy = date('Y-m-d');

	$sql = "UPDATE recaudacion.tb_ordenescobro
                      set orden_estado = 'DESPACHADA',
					      fecha_despachado = ".$bd_cat->sqlvalue_inyeccion($hoy,true).",
						  fk_despacha = 98
                 where orden_id= ".$bd_cat->sqlvalue_inyeccion($id_emite_externo,true).' and 
				 	   orden_codigo='.$bd_cat->sqlvalue_inyeccion($documento1,true);
	
	$bd_cat->ejecutar($sql);  
	
 

					 
						$sql1 = "update  prevencion.tb_definitivoglp    set definitivo_estado = 'PAGADO' where definitivo_codigo =".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql1);  

						$sql2 = "update  prevencion.tb_factibilidadglp  set factibilidad_estado = 'PAGADO' where factibilidad_codigo = ".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql2);  

						$sql3 = "update  prevencion.tb_habitabilidad    set habitabilidad_estado = 'PAGADO' where habitabilidad_codigo = ".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql3);  

						$sql4 = "update  prevencion.tb_inspecciones     set inspeccion_estado = 'PAGADO' where inspeccion_codigo =".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql4);  

						$sql5 = "update  prevencion.tb_ocasionales      set ocasional_estado = 'PAGADO' where ocasional_codigo = ".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql5);  

			 

						$sql6 = "update  prevencion.tb_planesemergencia set plan_estado = 'PAGADO' where plan_codigo = ".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql6);  

						$sql = "update  prevencion.tb_vbp set vbp_estado = 'PAGADO' where vbp_codigo = ".$bd_cat->sqlvalue_inyeccion($documento1,true);
						$bd_cat->ejecutar($sql);  
						




}	        

?>
 