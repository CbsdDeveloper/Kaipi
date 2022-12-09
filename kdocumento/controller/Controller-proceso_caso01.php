<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$obj     = 	new objects;
$bd	   =	new  Db ;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$datos   = array();
    
    $id                     ='0';
    $datos['vidproceso']    =  21;
    $sesion 	            =  trim($_SESSION['email']);
    $anio = date('Y');


    $Documento1  = $bd->query_array('flow.view_proceso_caso',
                                         'count(*) as nn',  
                                         "sesion = ".$bd->sqlvalue_inyeccion(  $sesion  ,true). " and 
                                         modulo_sistema=".$bd->sqlvalue_inyeccion( 'D'  ,true). " and 
                                          estado = '1' and 
                                          anio =".$bd->sqlvalue_inyeccion( $anio  ,true)
                                         );


$Documento  = $bd->query_array('flow.view_proceso_caso',
                                         'count(*) as nn',  
                                         "sesion = ".$bd->sqlvalue_inyeccion(  $sesion  ,true). " and 
                                         modulo_sistema=".$bd->sqlvalue_inyeccion( 'D'  ,true). " and 
                                          estado in ('2','3')  and 
                                          anio =".$bd->sqlvalue_inyeccion( $anio  ,true)
                                         );


$Documento2  = $bd->query_array('flow.view_doc_tarea',
                                         'count(*) as nn',  
                                         "sesion_actual = ".$bd->sqlvalue_inyeccion(  $sesion  ,true). " and 
                                         modulo_sistema=".$bd->sqlvalue_inyeccion( 'D'  ,true). " and 
                                         finaliza = 'N' and 
                                          anio =".$bd->sqlvalue_inyeccion( $anio  ,true)
                                         );                                         
 

    
    $obj->text->texto_oculto("vidproceso",$datos); 
  
    $obj->text->texto_oculto("vestado",$datos); 
  
    $evento = "javascript:changeAction('confirmar','','Desea agregar nuevo registro')" ;

    $style = 'style="padding-top: 5px;padding-bottom: 5px;background-color: #e0e0e0;color: #5d5d5d;"';        
    
    echo  '   <div id="nombre_proceso_se"> </div>  ';
 
    echo '<div class="col-md-12" style="padding: 2px">
                <button type="button" class="btn btn-info btn-block" id="button_nuevo1" name="button_nuevo1" onclick="'.$evento.'" > Nuevo Documento
                            <i class="icon-white icon-plus"></i>
                </button></div> ';


      echo '<div class="col-md-12" style="padding: 2px">
                <div  onclick="BusquedaGrilla(21, 1)" class="bloque5" title="Dar un clic para visualizar informacion"> 
                <span style="font-size:12px;color: #FFFFFF;">Por Enviar ('.$Documento1['nn'] .')</span>
          </div>
     </div>';

     echo '<div class="col-md-12" style="padding: 2px">
     <div  onclick="BusquedaGrillaSesion(21, 2)"   class="bloque4" title="Dar un clic para visualizar informacion"> 
     <span style="font-size:12px;color: #FFFFFF;">Solicitados ('.$Documento['nn'] .')</span>
      </div>	 
    </div>	';

    echo '<div class="col-md-12" style="padding: 2px">
    <div onclick="BusquedaGrillaSeg(21, 3)"    class="bloque3" title="Dar un clic para visualizar informacion"> 
    <span style="font-size:12px;color: #FFFFFF;">Recibidos / En Ejecución ('.$Documento2['nn'] .')</span>
         </div>
   </div>';

   echo '<div class="col-md-12" style="padding: 2px">
    <div onclick="BusquedaGrillaSesion(21, 4)"    class="bloque2" title="Dar un clic para visualizar informacion"> 
    <span style="font-size:12px;color: #FFFFFF;">Documentos Finalizados</span>
    </div>	
</div>';


    echo '<div class="col-md-12" style="padding: 2px">
    <div onclick="BusquedaGrillaSesion(21, 6)"    class="bloque1" title="Dar un clic para visualizar informacion"> 
    <span style="font-size:12px;color: #FFFFFF;">Documentos Anulados</span>
    </div>	
    </div>';
 
?>