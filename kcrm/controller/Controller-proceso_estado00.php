<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $sesion 	    =  trim($_SESSION['email']);
    
    $accion         =  $_GET['accion'];
    
    $anio           =  date("Y");  
    
    $Aunidad        = $bd->query_array('par_usuario',  'id_departamento', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );
   
    $iddepartamento =  $Aunidad['id_departamento'];
     
    if ( $accion == '1'){

        $sql = 'SELECT  estado,count(*) as nn
                from flow.view_proceso_caso
                where anio = '.$bd->sqlvalue_inyeccion($anio,true)." and 
                      tipo_doc = 'proceso' and 
                      id_departamento_caso = ".$bd->sqlvalue_inyeccion($iddepartamento,true).' 
                      group by estado';
    }
    
 
    if ( $accion == '2'){

        $sql = 'SELECT  estado,count(*) as nn
                from flow.view_proceso_caso
                where  anio = '.$bd->sqlvalue_inyeccion($anio,true)." and 
                       tipo_doc = 'proceso' and 
                       unidad_actual = ".$bd->sqlvalue_inyeccion($iddepartamento,true).' 
                group by estado';
    }
    

    $x = $bd->query_array('flow.view_proceso_caso',   // TABLA
    'count(*) as nn',                        // CAMPOS
    'sesion_actual='.$bd->sqlvalue_inyeccion( $sesion,true) ." and  tipo_doc = 'proceso' and estado in ('2','3')"
);

$numero = '';

if ( $x['nn'] > 0 ) {
    $numero = '( '.$x['nn'].' )';
}	



    echo '<div class="col-md-12" style="padding: 2px">
        <a href="inicio" ><div class="bloque00" title="Dar un clic para visualizar informacion"> 
        <span style="font-size:12px;color: #ffffff;">TRAMITES POR DESPACHAR  '.$numero.' </span></a>
        </div>
    </div>';



    $resultado  = $bd->ejecutar($sql);
  
    while ($fetch=$bd->obtener_fila($resultado)){
        
         
        $estado  =   trim($fetch['estado']) ;
 
        if ( $estado == '1' ){
            
            echo '<div class="col-md-12" style="padding: 2px">
                  <a href="#" onClick="BusquedaGrilla(0,1)"><div class="bloque0" title="Dar un clic para visualizar informacion"> 
                     <span style="font-size:12px;color: #ffffff;">POR ENVIAR</span></a>
  		    </div>
         </div>';
        }
            
        if ( $estado == '2' ){
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,2)"> <div class="bloque1" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #ffffff;">ENVIADOS</span></a>
 						</div>	 
 				</div>	';
        }

        if ( $estado == '3' ){
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,3)"> <div class="bloque2" title="Dar un clic para visualizar informacion"> 
				     	<span style="font-size:12px;color: #ffffff;">EN EJECUCION</span></a>
 						</div>
 				  </div>';
        }
        
        
        if ( $estado == '4' ){
            echo '<div class="col-md-12" style="padding: 2px">
            <a href="#" onClick="BusquedaGrilla(0,4)"> 	<div  class="bloque3" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #ffffff;">FINALIZADOS</span></a>
 						</div>
				 </div>';
        }
        
    
    }
    
   
 
   

?>