<?php
session_start( );

// retorna el valor del campo para impresion de pantalla

require '../../kconfig/Db.class.php';
require '../../kconfig/Obj.conf.php';
require '../../kconfig/Set.php';

$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



if (isset($_POST['seleccion'])){
    
    if ($_POST['seleccion'] == 'ok_periodo'){
        
        
        $id = @$_POST['ruc_registro'];
        
        
        $sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre
                 FROM web_registro a , par_catalogo b
                where b.idcatalogo =  a.idciudad and
                      a.ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
        
        
        
        $resultado = $bd->ejecutar($sql);
        $datos1 = $bd->obtener_array( $resultado);
        
        $_SESSION['ciudad'] = $datos1['nombre'];
        $_SESSION['razon'] = $datos1['razon'];
        $_SESSION['ruc_registro'] =$datos1['ruc_registro'];
        
        echo "<script>window.alert('Empresa seleccionada')</script>";
        
    }
}
?>
 <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                       
       <h4 class="modal-title">
        <?php 
              if (isset($_SESSION['ruc_registro'])){
                                     
										   $id = $_SESSION['ruc_registro'];
                                        
                                           $datos['ruc_registro'] = $id;
                                         
                                           $sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre  
                                                                          FROM web_registro a , par_catalogo b 
                                                                          where b.idcatalogo =  a.idciudad and 
                                                                                a.ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
                                         
                                          $resultado = $bd->ejecutar($sql);
										   
                                          $datos1 = $bd->obtener_array( $resultado);
                                        
                                          $_SESSION['ciudad'] = $datos1['nombre']; 
										   
                                          echo '<h4><b>Empresa seleccionada: '.$datos1['razon']. '  -  '.$_SESSION['ruc_registro'].'</b></h4>'; 
                                        }
                                        else{
                                         echo '<h5>No existe referencia...seleccione empresa para gestionar!!!</h5>';
                                       }
                                      ?>
                                    </h4>
                                </div>
                                
                              <div class="modal-body">
                                  <?php 
                                  
                                  $sesion 	 = $_SESSION['login'];
                                  
                                                
                                  $x = $bd->query_array('par_usuario',
                                      'empresas',
                                      'login='.$bd->sqlvalue_inyeccion( trim($sesion) ,true));
                                  
                                
                                  
                                  if  ( trim($x['empresas']) == '0000000000000'){
                                      
                                      $resultado = $bd->ejecutar("select ruc_registro as codigo, razon as nombre
                                                                from web_registro
                                                               where  estado = 'S' order by tipo desc ");
                                  }else{
                                      
                                      $resultado = $bd->ejecutar("select ruc_registro as codigo, razon as nombre
                                                                from web_registro
                                                               where  estado = 'S' and
                                                                      ruc_registro = ".$bd->sqlvalue_inyeccion(trim($x['empresas']) ,true)."  
                                                                      order by tipo desc ");
                                  }
                                  
                                 
                                   $tipo = $bd->retorna_tipo();
								  
                                   $obj->list->KP_listadb($resultado,$tipo,'','ruc_registro',$datos,'required','');
                                   
                                   echo '<h4><b>Periodo Disponible</b></h4>';
                                   
                                   $datos['anio_periodo'] = $_SESSION['anio'] ;
                                    
                                   $resultado = $bd->ejecutar("select anio as codigo, detalle as nombre
                                                                from presupuesto.view_periodo
                                                               where  estado in ( 'ejecucion','proforma') order by anio desc ");
                                   
                      
                                              
                                   $obj->list->KP_listadb($resultado,$tipo,'','anio_periodo',$datos,'required','');
                                  
								  ?>
                                 <br>
								  <div id="RucRegistro"></div>
                              </div>
                              
                              <div class="modal-footer">
                              	<input name="seleccionar" class="btn btn-primary" type="button" onClick="variableEmpresa()" id="seleccionar" value="Seleccionar">
                              	
                              	<input name="seleccionar" class="btn btn-default" type="button" onClick="javascript:location.reload()" id="seleccionar" value="Actualizar">
                              	
                              </div>
 