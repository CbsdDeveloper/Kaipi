<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
	$anio     = $_SESSION['anio'];
	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sesion 	 =  trim($_SESSION['email']);
    
    $accion    = $_GET['accion'];
    
   

    
    $Aunidad = $bd->query_array('par_usuario',
        'id_departamento',
        'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
        );
    
   
    $iddepartamento =  $Aunidad['id_departamento'];
     
    if ( $accion == '1'){
        $sql = 'SELECT  estado,count(*) as nn
                from flow.view_proceso_caso
                where id_departamento = '.$bd->sqlvalue_inyeccion($iddepartamento,true).' and 
                     anio = '.$bd->sqlvalue_inyeccion($anio,true). " and 
                     tipo_doc = 'proceso'   
                      group by estado";
    }
    
 
    if ( $accion == '2'){
        $sql = 'SELECT  estado,count(*) as nn
                from flow.view_proceso_caso
                where unidad_actual = '.$bd->sqlvalue_inyeccion($iddepartamento,true).' and
                             anio = '.$bd->sqlvalue_inyeccion($anio,true). " and 
                         tipo_doc = 'proceso'   
                  group by estado";
    }
    
 
    echo '<div class="col-md-12" style="padding: 2px">
    <a href="cli_incidencias" ><div class="bloque00" title="Dar un clic para visualizar informacion"> 
       <span style="font-size:12px;color: #ffffff;">NUEVO TRAMITE</span></a>
    </div>
    </div>';
 

 
    
    $resultado  = $bd->ejecutar($sql);
 

    while ($fetch=$bd->obtener_fila($resultado)){
    
        
        $estado  =   trim($fetch['estado']) ;
 

        if ( $estado == '1' ){
            
            echo '<div class="col-md-12" style="padding: 2px">
					<div  onclick="goToURLProceso(1,1)" class="bloque0" title="Dar un clic para visualizar informacion"> 
                    <span style="font-size:12px;color: #ffffff;">POR ENVIAR </span></a>
 		    </div>
         </div>';
        }
       
     
            
        if ( $estado == '2' ){
            
            echo '<div class="col-md-12" style="padding: 2px">
						<div  onclick="goToURLProceso(2,1)" class="bloque1" title="Dar un clic para visualizar informacion"> 
                                 <span style="font-size:12px;color: #ffffff;">ENVIADOS </span></a>
 						</div>	 
 				</div>	';
        }
 
    }
    
   
 
   

?>