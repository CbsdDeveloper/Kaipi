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
	
	$bd->KPcontador_usuario($formulario,$_SESSION['email'] ); //cuenta veces ingresado a la ventana por el usuario
	
 	$obj->ajax->_inyeccion();	//previene full injection
	////////////////
	if (isset($_SESSION['ruc_registro'])){
	}else{
		 $obj->var->_enlace('inicio');
	}
	////////////////
	// eventos de gestión action=procesa&id_rol=1&id_config=4
	if (isset($_GET['action']))
	 {
 			$id_rol 		= $_GET['id_rol'];
			$id_config		= $_GET['id_config'];
			$id_departamento= $_GET['id_departamento'];
			$action			= $_GET['action'];
			$tid 		= $_GET['tid'];
    	 	K_eventos($action,$id_rol,$id_config,$id_departamento,$tid );
  	}	
	
	  require 'head1.php';
?>
 
	 <script type="text/javascript">
    function imprSelec(muestra)
    {
		var ficha=document.getElementById(muestra);
		var ventimp=window.open(' ','popimpr');
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		var css = ventimp.document.createElement("link");
		css.setAttribute("href", "../kconfig/bootstrap/css/bootstrap.min.css");
		css.setAttribute("href", "../kconfig/assets/css/main.css");
		css.setAttribute("rel", "stylesheet");
		css.setAttribute("type", "text/css");
		css.setAttribute("media", "print");
		ventimp.document.head.appendChild(css);
		
		ventimp.print();
		ventimp.close();
	}
    </script>  
    <script src="../kconfig/tableToExcel.js"></script>
 
 <body>
  <?php 
   global $bd,$obj ;
	 
	$id = $_SESSION['ruc_registro'];
    $set->box_tabs('#tab1','#tab2','',''); 
    $set->tab_panel('tab1'); 
   
    $id_departamento = 0;
	 
	if (isset($_GET['rol']))	{
         $id_rol = $_GET['rol'] ;
         $datos['rolp'] = $id_rol;
         $obj->text->texto_oculto('rolp',$datos);
     } 	
  	 if (isset($_POST['id_departamento1']))	{
         $id_rol =  @$_POST["rolp"];
         $datos['rolp'] = $id_rol;
         $obj->text->texto_oculto('rolp',$datos);
         $id_departamento =  @$_POST["id_departamento1"];
         
         K_campo('id_departamento1', $id_departamento);
   
     } 	 
   
 	 $sql = 'SELECT estado,novedad FROM nom_rol_pago where id_rol ='.$bd->sqlvalue_inyeccion($id_rol,true);
	 $resultado = $bd->ejecutar($sql);
  	 $periodo = $bd->obtener_array( $resultado);
 
     if($periodo["estado"] == 'N')
        $cadena = ' ESTADO: NO APROBADO';
     else
        $cadena = ' ESTADO: APROBADO';
    
     $novedad = TRIM(strtoupper($periodo["novedad"]));
    $set->tab_body('RESUMEN GENERAL DEL ROL DE PERSONAL '.$novedad.$cadena);	
    $set->form_buscar($formulario); // forms para buscar	      
    $set->table_inicio('100%');
     
      $id_departamento = 0;
	if (isset($_GET['rol']))	{
         $id_rol = $_GET['rol'] ;
         $datos['rolp'] = $id_rol;
         $obj->text->texto_oculto('rolp',$datos);
     } 	
  	 if (isset($_POST['id_departamento1']))	{
         $id_rol =  @$_POST["rolp"];
         $datos['rolp'] = $id_rol;
         $obj->text->texto_oculto('rolp',$datos);
         $id_departamento =  @$_POST["id_departamento1"];
         
         K_campo('id_departamento1', $id_departamento);
   
     } 
     
          $sql = 'SELECT nombre as "Ingreso",sum(ingreso) as "Total"
                  FROM view_rol
                  where id_rol='.$bd->sqlvalue_inyeccion($id_rol, true)." and tipo = 'I'  
                group by nombre";
					
  			$resultado = $bd->ejecutar($sql);
			$tipo	   = $bd->retorna_tipo();
	
      echo '<tr><td colspan="2"><b>ROL DE PAGOS - RESUMEN POR CONCEPTO INGRESO - DESCUENTO</b></td> </tr>
	 		<tr><td>';
  	 	
            $obj->grid->KP_sumatoria(2,"Total","", "","");
 			$obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  

          $sql = 'SELECT nombre as "Descuento",sum(descuento) as "Total"
                  FROM view_rol
                   where id_rol='.$bd->sqlvalue_inyeccion($id_rol, true)." and tipo = 'E'  
                group by nombre";
					
  			$resultado = $bd->ejecutar($sql);
			$tipo	   = $bd->retorna_tipo();
		echo '</td><td>';	 	
            $obj->grid->KP_sumatoria(2,"Total","", "","");
 			$obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  
       echo '</td></tr>';      	 
       ///////
        $sql = 'SELECT unidad as "Unidades Administrativas", sum(ingreso) as "Ingreso", 
                      sum(descuento) as "Descuento", 
                      sum(ingreso) - sum(descuento) as "Saldo"
              FROM view_rol_impresion
              where  id_rol= '.$bd->sqlvalue_inyeccion($id_rol, true)." 
              group by unidad";
 					
  			$resultado = $bd->ejecutar($sql);
			$tipo	   = $bd->retorna_tipo();
			
	   echo '<tr><td colspan="2"><b>ROL DE PAGOS - RESUMEN POR UNIDADES ADMINISTRATIVAS</b></td> </tr>';
       echo '<tr><td>';
            $obj->grid->KP_sumatoria(2,"Ingreso","Descuento", "Saldo","");
 			$obj->grid->KP_GRID_visor($resultado,$tipo,'70%');  
     echo '</td><td>';	 	
     echo '</td></tr><tr>';
     echo '<td colspan="2"><b>ROL DE PAGOS - DETALLE POR UNIDAD</b></td>';
     echo '</td></tr><tr>';
     $sql = "select id_departamento as codigo,nombre from nom_departamento order by 1";
	
    $resultado = $bd->ejecutar($sql);
 	$tipo = $bd->retorna_tipo();
    echo '<td colspan="2">';
	$obj->list->listadb($resultado,$tipo,'','id_departamento1',$datos,'','',''); 
    echo '</td></tr>';
     echo '<tr><td colspan="2">';
     //-------------------------------------------------------------------------
     //// detalle del rol
     //-------------------------------------------------------------------------
     echo '<div id="myPrintArea" style="max-width:980px; overflow-x: scroll; white-space: nowrap;">';
     echo '<table id="rolp" class="table table-striped table-bordered table-hover " width="100%" border="0">';
     echo '<thead><tr>';
      echo '<th>Nro.</th>';
      echo '<th>Identificacion</th>';
      echo '<th>Empleado</th>';
      /// pone ingresos
       $sql = "SELECT  nombre,id_config
                from view_rol_impresion
                  where tipo = 'I' and id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).'    
                  group by id_config,nombre
                  order by nombre desc';
    	/*Ejecutamos la query*/
				    $stmt = $bd->ejecutar($sql);
					/*Realizamos un bucle para ir obteniendo los resultados*/
                    $ncolumnai = 1;
               		while ($x=$bd->obtener_fila($stmt)){
					$header = trim($x['nombre']);
				    echo '<th>'.$header.'</th>';
                    $datos_ingreso[ $ncolumnai ] = $x['1'];
                    $ncolumnai++;
 					}
                    echo '<th>Total Ingresos</th>';
                     
      /// pone descuentos
         $sql = "SELECT  nombre ,id_config 
                from view_rol_impresion
                  where tipo = 'E' and id_rol=".$bd->sqlvalue_inyeccion($id_rol ,true).'    
                  group by id_config,nombre
                  order by nombre desc';
    	/*Ejecutamos la query*/
				    $stmt = $bd->ejecutar($sql);
					/*Realizamos un bucle para ir obteniendo los resultados*/
                     $ncolumnad = 1;
 					while ($x=$bd->obtener_fila($stmt)){
					$header = trim($x['nombre']);
				    echo '<th>'.$header.'</th>';
                     $datos_descuento[ $ncolumnad ] = $x['1'];
                     $ncolumnad++; 
 					}  
                     echo '<th>Total Descuentos</th>';
                     echo '<th>A pagar</th>';  
                      
      echo "</tr></thead><tbody>";	
      
      /// pone empleados
      $sql = "SELECT idprov, empleado
      FROM view_rol_impresion
      where id_departamento=".$bd->sqlvalue_inyeccion($id_departamento ,true)." and id_rol =".$bd->sqlvalue_inyeccion($id_rol ,true).'
      group by unidad,empleado,idprov,id_departamento';
       	/*Ejecutamos la query*/
	   $stmt = $bd->ejecutar($sql);
	   /*Realizamos un bucle para ir obteniendo los resultados*/
       K_campo('id_departamento1', $id_departamento);
       $id = 1;
       while ($x=$bd->obtener_fila($stmt)){
        echo "<tr>";
					$idprov = trim($x['idprov']);
                    $empleado = trim($x['empleado']);
                    echo '<td>'.$id.'</td>';
                    echo '<td>'.$idprov.'</td>';
                    echo '<td>'.$empleado.'</td>';
                    $ntotal = K_consulta($id_rol,$datos_ingreso,$idprov,'I',$ncolumnai);
                    echo '<td align="right">'.$ntotal.'</td>';
                    $dtotal = K_consulta($id_rol,$datos_descuento,$idprov,'E',$ncolumnad);
                    echo '<td align="right">'.$dtotal.'</td>';
                    $pago = $ntotal - $dtotal ;
                    echo '<td align="right">'.$pago.'</td>';
                     
		$id++;		     
        echo "</tr>";
      }
      
      
 	echo "</tbody></table>";
    echo '</div>';
    echo '</td></tr>';  
    echo '<tr><td colspan="2">'; 
    echo ' <a href="javascript:imprSelec('."'myPrintArea'".')">Imprimir Tabla</a> | 
	       <a href="javascript:tableToExcel('."'rolp'".', '."'Rol de Pagos'".')">Export to Excel</a>
  		';
    echo '</tr>';  
   	 
 $set->table_fin();  
 $set->tab_footer()	;	
 $formulario = 'nom_roles';
 $obj->boton->KP_button( $formulario,'Regresar');
  $obj->boton->KP_button_search();
 $set->tab_end('</form>'); 
 $set->tab_footer_end()	;	//Box Tabs --> 											  													
 ?>	
 </body>
</html>
<?php
//----------------------------------------------------......................-------------------------------------------------------------
// primera opcion para las ventanas operativas
//----------------------------------------------------......................-------------------------------------------------------------
function K_eventos($action,$id_rol,$id_config,$id_departamento,$tid){
  		if  ($action == 'procesa'){
				K_procesa($id_rol,$id_config,$id_departamento);
		}
  		if  ($action == 'del'){
				K_eliminar($tid,$id_rol,$id_config,$id_departamento);
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
// llena datos de la consulta individual
//----------------------------------------------------......................-------------------------------------------------------------
 function K_consulta($id_rol,$datos_arreglo,$idprov,$tipo,$numero_campos ){
	 global $datos;
 	 global $bd;	
	 global $obj;	 	  
    
    $ntotal = 0;
	 
    for ($i = 1; $i<= $numero_campos - 1  ; $i++){

		$id_config = $datos_arreglo[$i];
        
        if ($tipo == 'I')
            $cadena = 'ingreso as total ';
        else
             $cadena = 'descuento as total ';
        
        $sql = 'SELECT '.$cadena.' 
                from view_rol_impresion
                  where idprov='.$bd->sqlvalue_inyeccion($idprov,true).' and 
                        id_config = '.$bd->sqlvalue_inyeccion($id_config,true).' and 
                        id_rol ='.$bd->sqlvalue_inyeccion($id_rol,true);
   
         $resultado = $bd->ejecutar($sql);
  	     $total = $bd->obtener_array( $resultado);
         echo '<td align="right">'.$total['total'].'</td>';
         $ntotal = $ntotal + $total['total'];
    }	
    return $ntotal;
   
}	
//----------------------------------------------------......................-------------------------------------------------------------
/// llena para consultar
//----------------------------------------------------......................-------------------------------------------------------------
 function K_editar($id_rol,$id_config,$id_departamento ){
  	 global $bd;	 
	 global $obj;	 
	 global $formulario;
 
    	 
   }	
//----------------------------------------------------......................-------------------------------------------------------------
// llena datos de la consulta individual
//----------------------------------------------------......................-------------------------------------------------------------
function K_agregar( ){
  	 global $bd;	 
	 global $obj;	 	 
     global $formulario;
	// parametros kte 

   
  }	
//----------------------------------------------------......................-------------------------------------------------------------
// llena para eliminar
//----------------------------------------------------......................-------------------------------------------------------------
function K_eliminar($tid,$id_rol,$id_config,$id_departamento){
  	 global $bd;
	 global $obj;	 
	 global $formulario;
  
}
 
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
function K_where( $var1 ,$var2  ){
 	 global $obj;
	 global $bd;	 
	 
	 $cadena = '';
	 $cadena1 = '';
	 $cadena2 = '';
	 $cadena3 = '';
	 $cadena4 = '';
	 $cadena5 = '';
	 
	    
      $cadena1 = '( a.idprov=b.idprov) and ';
	  
	 if (  ($var1) >= 1){
		  $cadena2 = '( a.id_rol ='.$bd->sqlvalue_inyeccion(trim($var1),true).") and ";
	   }	 
 	 
	 if ( ($var2) >= 1){
		  $cadena3 = '( a.id_departamento ='.$bd->sqlvalue_inyeccion(trim($var2),true).") and ";
	   }
   	   
 	   K_campo('id_rol1',$var1 );
 	   K_campo('id_departamento1',$var2 );
 
	  $where    =  $cadena1.$cadena2.$cadena3.$cadena4;
	  $longitud = strlen($where); 
	  $where    = substr( $where,0,$longitud - 5);
	 
   	 return   $where; 
  }
//----------------------------------------------------......................-------------------------------------------------------------
// condicion de busqueda
//----------------------------------------------------......................-------------------------------------------------------------
function K_where1( $var1  ){
 	 global $obj;
	 global $bd;	 
	 
	 $cadena = '';
	 $cadena1 = '';
	 $cadena2 = '';
	 $cadena3 = '';
	 $cadena4 = '';
	 $cadena5 = '';
	 
	    
      $cadena1 = '( tipo='.$bd->sqlvalue_inyeccion(trim('I'),true).") and ";
	  
	  if (  ($var1) >= 1){
		  $cadena2 = '( id_rol ='.$bd->sqlvalue_inyeccion(trim($var1),true).") and ";
	   }	 
  
   	   
 	   K_campo('id_rol1',$var1 );
 	   
	  $where    =  $cadena1.$cadena2.$cadena3.$cadena4;
	  $longitud = strlen($where); 
	  $where    = substr( $where,0,$longitud - 5);
	 
   	 return   $where; 
  } 
//----------------------------------------------------......................-------------------------------------------------------------
//aprobación de asientos
//----------------------------------------------------......................-------------------------------------------------------------
function K_aprobacion($id ){
  	 global $bd;	 
	 global $obj;	 
	 global $formulario;
	 global $datos;
 
 }
//----------------------------------------------------......................-------------------------------------------------------------
// genera comprobante
//----------------------------------------------------......................-------------------------------------------------------------
 function K_comprobante($nombre ){
  	 global $bd;	 
	 global $obj;	 
	 global $formulario;
  
   }	
 
//----------------------------------------------------......................-------------------------------------------------------------
// llena para consultar
//----------------------------------------------------......................-------------------------------------------------------------
function K_procesa($id_rol,$id_config,$id_departamento){
  	 global $bd;	 
	 global $obj;	 
	 global $formulario;
	 global $datos;
 
  } 	  
//----------------------------------------------------......................-------------------------------------------------------------
// llena para eliminar
//----------------------------------------------------......................-------------------------------------------------------------
function K_eliminar_aux($tid,$ref ){
  	 global $bd;
	 global $obj;	 
	 global $formulario;
	  /// 
      $obj->var->_enlace($formulario.'?action=editar&tid='.$ref.'#tab2');
  }       
 ?>