<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
require '../../kconfig/Set.php';      /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$tipo = $bd->retorna_tipo();

$id_rol = $_GET['id_rol'] ;
$idprov = $_GET['idprov'] ;
 

 
   $sql = "SELECT novedad,id_periodo  FROM nom_rol_pago where id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true);
   $resultado = $bd->ejecutar($sql);
   $datos = $bd->obtener_array( $resultado);
   $id_periodo = $datos['id_periodo'];
  	 
   
   $sql = "SELECT *  FROM view_nomina_rol where idprov = ".$bd->sqlvalue_inyeccion($idprov,true);
   $resultado = $bd->ejecutar($sql);
   $datos = $bd->obtener_array( $resultado);	
  	
?>
 <table class="table table-striped table-hover" width="100%">
  <tbody>
    <tr>
      <td colspan="2" class="alert-info"> <?php echo $_SESSION['razon'] ?></td>
    </tr>
    <tr>
      <td>Empleado:	<?php echo $datos['razon'] ?></td>
      <td><?php echo utf8_encode('Nro.Identificaci�n: '.$datos['idprov']) ?></td>
    </tr> 
    <tr>
      <td>Cargo laboral: <?php echo $datos['cargo'] ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" align="left" valign="top"> 
		 <?php	
		 $sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
   				   FROM view_rol_personal
		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov ,true)." and 
		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and 
						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true)." and 
                        ingreso > 0 and 
						tipo = ".$bd->sqlvalue_inyeccion("I",true);
 																		
			$resultado = $bd->ejecutar($sql);
 			$obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
?></td>
      <td width="50%" align="left" valign="top">
<?php		 
	  	 $sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
   				   FROM view_rol_personal
		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov,true)." and 
		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and 
                        descuento > 0 and 
						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true)." and 
						tipo = ".$bd->sqlvalue_inyeccion("E",true);
 																		
			$resultado = $bd->ejecutar($sql);
			$obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
?></td>
    </tr>
   <tr>
   <?php		 
	  	 $sql = 'SELECT sum(ingreso) as ingreso,sum(descuento) as egreso
   				   FROM view_rol_personal
		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov ,true)." and 
		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and 
						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true);
    $resultado = $bd->ejecutar($sql);
    $datos1 = $bd->obtener_array( $resultado);
			
 	?>
      <td style="font-style: normal; color: #121212; font-weight: bold; font-size: 13px;">Total   Ingreso: <?php echo $datos1['ingreso'] ?></td>
      <td style="font-style: normal; color: #121212; font-weight: bold; font-size: 13px;"><span style="font-size: 13px; color: #050505; font-weight: bold;">Total Descuento: <?php echo $datos1['egreso'] ?></span></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size: 13px; color: #050505; font-weight: bold;">A pagar: <?php echo $datos1['ingreso'] -  $datos1['egreso'];?></td>
    </tr>
   </tbody>
</table>
<?php

 

 

$x = $bd->query_array('nom_rol_pago',   // TABLA
    'estado',                        // CAMPOS
    'id_rol='.$bd->sqlvalue_inyeccion($id_rol,true)  
    );
  
if ( trim($x['estado']) == 'S' ){
    
}else{ 
    
    $evento = 'onclick="ver_parametro_rol('.$id_rol.','."'".trim($idprov)."'".')"';
     $evento1 = 'onclick="go_actualiza1('."'".trim($idprov)."'".')"';
    
     echo '<div class="col-md-12" style="padding-bottom:5;padding-top:5px">
            <button type="button" '.$evento.'  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModalCambio" >Editar informacion</button>
            <button type="button" '.$evento1.'  class="btn btn-primary btn-sm">Actualizar informacion</button>
       </div>';
 }


?>