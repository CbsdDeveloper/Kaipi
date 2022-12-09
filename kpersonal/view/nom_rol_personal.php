<?php session_start( );  ?>
<!DOCTYPE html>
<html>
<?php
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

/*Creamos la instancia del objeto. Ya estamos conectados*/
global $bd;
global $obj;
global $datos;
global $formulario;

$obj   = 	new objects;
$bd	   =	new Db;

$set   = 	new ItemsController;

    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	$formulario = $obj->var->_formulario(0);
 	$obj->ajax->_inyeccion();	//previene full injection
 	
	 	
	 require 'head1.php';
	 	
?>
 
 <body>
  <?php 
   global $bd,$obj ;
   $id_rol		= $_GET['id_rol'];
   $sql = "SELECT novedad,id_periodo  FROM nom_rol_pago where id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true);
   $resultado = $bd->ejecutar($sql);
   $datos = $bd->obtener_array( $resultado);
	 
    $id_periodo = $datos['id_periodo'];
  	 
 	$id = $_SESSION['ruc_registro'];
    $set->box_tabs('#tab1','','',''); 
	$set->tab_panel('tab1'); 
    $set->tab_body('Rol de Pagos individual: '.$datos['novedad']);	

   $idprov		= $_GET['id'];
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
      <td>Nro.Identificación: <?php echo $datos['idprov']?></td>
    </tr>
    <tr>
      <td>Cargo laboral: <?php echo $datos['cargo'] ?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%" align="left" valign="top"> 
		 <?php	
		 $id_rol		= $_GET['id_rol'];
		 $idprov	    = $datos['idprov'];
		 $sql = 'SELECT nombre as "INGRESO",ingreso as "Monto"
   				   FROM view_rol_personal
		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov ,true)." and 
		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and 
						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true)." and 
						tipo = ".$bd->sqlvalue_inyeccion("I",true);
 																		
			$resultado = $bd->ejecutar($sql);
			$tipo	   = $bd->retorna_tipo();
			
			$obj->grid->KP_GRID_visor($resultado,$tipo,'100%'); 
			 ?></td>
      <td width="50%" align="left" valign="top">
      <?php		 
	  	 $sql = 'SELECT nombre as "DESCUENTO",descuento as "Monto"
   				   FROM view_rol_personal
		   		  where idprov = '.$bd->sqlvalue_inyeccion($idprov,true)." and 
		   			    id_rol = ".$bd->sqlvalue_inyeccion($id_rol,true)." and 
						id_periodo =".$bd->sqlvalue_inyeccion($id_periodo ,true)." and 
						tipo = ".$bd->sqlvalue_inyeccion("E",true);
 																		
			$resultado = $bd->ejecutar($sql);
			$tipo	   = $bd->retorna_tipo();
			
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
 ///////////////////////	
    $set->tab_footer()	;	
 	$set->tab_end('</form>');
	$set->tab_footer_end()	;	//Box Tabs --> 											  													
 ?>	
  </body>
</html>
<?php
//----------------------------------------------------......................-------------------------------------------------------------
// primera opcion para las ventanas operativas
//----------------------------------------------------......................-------------------------------------------------------------
function K_eventos( $vopcion,$vid){
   if (isset($vopcion)) {
		if (isset($vid)){
			$id 		= $vid;
			$opcion		= $vopcion;
  	    }
		else{
			$opcion		= $vopcion;	
			if ($opcion	== 'nuevo')
		 		$id 		= 0;
		}
 	}
   if (empty($tipo_accion)){
 
		if  ($opcion == 'actualizar'){
				K_editar($id);
		}	
		if  ($opcion == 'nuevo'){
				K_agregar( );
		}	
		if  ($opcion == 'eliminar'){
				//K_eliminar($id);
		}	
		if  ($opcion == 'anular'){
 	   		K_eliminar($id);
 	    }	
   	 
	}	
  } 
//----------------------------------------------------......................-------------------------------------------------------------
// primera opcion para las ventanas operativas
//----------------------------------------------------......................-------------------------------------------------------------
function K_tipo_evento( $tipo_evento,$formulario,$id_codigo,$tab){
	  if (isset($tipo_evento)){
				if ($tipo_evento == 'visor')
					$evento_form = $formulario.'?action=visor&tid='.$id_codigo.$tab;
				if ($tipo_evento == 'editar')
					$evento_form = $formulario.'?action=actualizar&tid='.$id_codigo.$tab;
				if ($tipo_evento == 'add')
					$evento_form = $formulario.'?action=nuevo'.$tab;
				if ($tipo_evento == 'del')
					$evento_form = $formulario.'?action=eliminar&tid='.$id_codigo.$tab;
		}	
	return 	$evento_form;
  }
	

//----------------------------------------------------......................-------------------------------------------------------------
// llena para eliminar
//----------------------------------------------------......................-------------------------------------------------------------

//----------------------------------------------------......................-------------------------------------------------------------
// retorna el valor del campo para impresion de pantalla
//----------------------------------------------------......................-------------------------------------------------------------
function K_campo($campo,$valor ){
 	 echo '<script type="text/javascript">';
	 echo 'filtro("'.$campo.'","'.$valor.'")';
	 echo '</script>'; 
 	 return 1; 
  } 
//----------------------------------------------------......................-------------------------------------------------------------
// condicion de busqueda
//----------------------------------------------------......................-------------------------------------------------------------

//----------------------------------------------------......................-------------------------------------------------------------
//aprobación de asientos
//----------------------------------------------------......................-------------------------------------------------------------
   
 ?>