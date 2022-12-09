<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	     =	new Db;	
 
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sesion 	 =  trim($_SESSION['email']);
    
    $accion    = $_GET['accion'];
    
   
     
    $Aunidad = $bd->query_array('par_usuario',
        'id_departamento,responsable',
        'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
        );
    
   
    $iddepartamento =  $Aunidad['id_departamento'];
      
 
 $sql = "SELECT  estado,count(*) as nn
                from flow.view_doc_tarea
                where estado in ('1','2','3') and finaliza = 'N' and sesion_actual= ".$bd->sqlvalue_inyeccion($sesion,true).'
                group by estado';
       
        
 
    echo '<div class="col-md-12" style="padding: 2px">
    <div   class="bloque2" title="Dar un clic para BUSCAR tramite">
    <a href="cli_incidencias">	 <span style="font-size:14px;color: #ffffff;"><b> NUEVO</b></span>
    <span style="font-size:12px;color: #ffffff;">TRAMITE</span></a>
</div>
</div><p>&nbsp;</p>';

    
    
 
    
    $resultado  = $bd->ejecutar($sql);
 
    
    
    while ($fetch=$bd->obtener_fila($resultado)){
        
        $nn      =   $fetch['nn'] ;
        
        $estado  =   trim($fetch['estado']) ;
 
        if ( $estado == '1' ){
            

            echo '<div class="col-md-12" style="padding: 2px">
                <div  onclick="goToURLProceso(1,1)" class="bloque5" title="Dar un clic para visualizar informacion"> 
                <span style="font-size:12px;color: #FFFFFF;">POR ENVIAR</span>
                <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
            </div>
            </div>';
         
        }
       
       
            
        if ( $estado == '2' ){


            echo '<div class="col-md-12" style="padding: 2px">
            <div  onclick="goToURLProceso(2, 1)"   class="bloque4" title="Dar un clic para visualizar informacion"> 
            <span style="font-size:12px;color: #FFFFFF;">MIS RECIBIDOS</span>
            <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
            </div>	 
           </div>	';

 
        }

        if ( $estado == '3' ){

            echo '<div class="col-md-12" style="padding: 2px">
            <div  onclick="goToURLProceso(3, 1)"   class="bloque3" title="Dar un clic para visualizar informacion"> 
            <span style="font-size:12px;color: #FFFFFF;">EJECUCION</span>
            <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
            </div>	 
           </div>	';
 
        }
        
        
        if ( $estado == '4' ){

            echo '<div class="col-md-12" style="padding: 2px">
            <div  onclick="goToURLProceso(4, 1)"   class="bloque0" title="Dar un clic para visualizar informacion"> 
            <span style="font-size:12px;color: #FFFFFF;">DOCUMENTOS TERMINADOS</span>
            <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
            </div>	 
           </div>	';

 
        }
        
        if ( $estado == '5' ){

            echo '<div class="col-md-12" style="padding: 2px">
            <div  onclick="goToURLProceso(5, 1)"   class="bloque5" title="Dar un clic para visualizar informacion"> 
            <span style="font-size:12px;color: #FFFFFF;">FINALIZADOS</span>
            <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
            </div>	 
           </div>	';

           
        }
        
        
    }
    
   
 
   

?>