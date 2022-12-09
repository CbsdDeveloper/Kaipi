<?php   
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
	$bd	     =	new Db;	
    
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $sesion 	 =  trim($_SESSION['email']);

    $accion      = $_GET['accion'];
    
    $anio        =  date("Y");  
    
    $Aunidad = $bd->query_array('par_usuario',
        'id_departamento',
        'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
        );
   
    $iddepartamento =  $Aunidad['id_departamento'];
     
          
   $sql = 'SELECT  estado,count(*) as nn
                from flow.view_proceso_caso
                where anio = '.$bd->sqlvalue_inyeccion($anio,true).' and
                      sesion = '.$bd->sqlvalue_inyeccion($sesion,true)." and
                      tipo_doc = 'documental'
                      group by estado";
   
    
    $resultado  = $bd->ejecutar($sql);
     
    echo '<div class="col-md-12" style="padding: 2px">
					<div   class="bloque2" title="ENCUENTRE SUS TRAMITES ASIGNADOS EN SU BANDEJA DE DOCUMENTOS PARA SU AGREGAR SU RESPUESTA">
                    <a href="inicio">	 <span style="font-size:18px;color: #ffffff;"><b>MIS TRAMITES</b></span>
					<span style="font-size:12px;color: #ffffff;">ASIGNADOS</span></a>
 		    </div>
         </div><p>&nbsp;</p>';
    
 
 
    
    while ($fetch=$bd->obtener_fila($resultado)){
        
        $nn      =   $fetch['nn'] ;
        
        $estado  =   trim($fetch['estado']) ;
 
        if ( $estado == '1' ){
           
            echo '<div class="col-md-12" style="padding: 2px">
					<div  onclick="BusquedaGrilla(0, 1)" class="bloque5" title="Dar un clic para visualizar informacion"> 
                    <span style="font-size:12px;color: #FFFFFF;">POR ENVIAR</span>
					<span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
 		    </div>
         </div>';
        }
       
       
            
        if ( $estado == '2' ){

            echo '<div class="col-md-12" style="padding: 2px">
						<div  onclick="BusquedaGrilla(0, 2)"   class="bloque4" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #FFFFFF;">ENVIADOS</span>
                        <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
						</div>	 
 				</div>	';
        }

        if ( $estado == '3' ){
            echo '<div class="col-md-12" style="padding: 2px">
					<div onclick="BusquedaGrilla(0, 3)"    class="bloque3" title="Dar un clic para visualizar informacion"> 
                    <span style="font-size:12px;color: #FFFFFF;">EN EJECUCION</span>
                    <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
						</div>
 				  </div>';
        }
        
        
        if ( $estado == '4' ){
            echo '<div class="col-md-12" style="padding: 2px">
						<div onclick="BusquedaGrilla(0, 4)"  class="bloque0" title="Dar un clic para visualizar informacion"> 
                        <span style="font-size:12px;color: #FFFFFF;">DOCUMENTOS TERMINADOS</span>
                        <span style="font-size:10px;color: #cccccc;">( '.$nn.' )</span> 
						</div>
				 </div>';
        }
        
        if ( $estado == '5' ){
            echo '<div class="col-md-12" style="padding: 2px">
							<div onclick="BusquedaGrilla(0, 5)"    class="bloque5" title="Dar un clic para visualizar informacion"> 
                            <span style="font-size:15px;color: #FFFFFF;">Documento Finalizados</span>
                            <span style="font-size:13px;color: #cccccc;">( '.$nn.' )</span> 
						</div>	
				</div>';
        }
        
        
    }
    
   
 
   

?>