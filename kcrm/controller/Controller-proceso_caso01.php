<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
	$obj     = 	new objects;
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $datos              = array();

    $datos['vestado']   = '1';
      
 

    $tipo = $bd->retorna_tipo();
  
        
    $AUsuario = $bd->query_array('par_usuario',
    'login, email,    cedula,    tarea, completo,   id_departamento', 
    'idusuario='.$bd->sqlvalue_inyeccion($_SESSION['usuario'],true)
);


    $id_departamento = $AUsuario['id_departamento'];

    $sqlunidad = "SELECT 0 AS codigo, ' -- 0. Seleccione proceso a gestionar -- ' as nombre union
                  SELECT  idproceso as codigo, proceso as nombre
                        FROM  flow.view_proceso_inicio
                       where  ambito_proceso = 'publico' and 
                              ambito = 'Externo' and  
                              tipo_doc <> 'documental'    ";
    
    $sqlunidad = $sqlunidad." union SELECT  idproceso as codigo, proceso as nombre
                        FROM  flow.view_proceso_inicio
                       where   ambito_proceso = 'privado' and 
                               ambito = 'Externo' and 
                               tipo_doc <> 'documental' and 
                               idunidad =".$id_departamento.' order by 2';
    
    
 
    
    $resultado = $bd->ejecutar($sqlunidad);

      
    $obj->text->texto_oculto("vidproceso_nombre",$datos); 

    $obj->text->texto_oculto("vestado",$datos); 
 
    
    $style = 'style="padding: 10px; background-color: #3de844;color: #ffffff;border-radius:20px; -moz-border-radius:20px; -webkit-border-radius:20px;"';
    
    echo  ' <div class="col-md-10" align="center" '.$style.'>';

    $novedad = '';
    $evento  = ' onChange="goToURL(this.value'.","."'".strtoupper($novedad)."'".')" ';

    $obj->list->listadbe($resultado,$tipo,'','vidproceso',$datos,'','',$evento,'div-0-12');

    echo '</div> ';
    
 



    $evento = "javascript:changeAction('confirmar','','Desea agregar nuevo registro')" ;
    
    echo '<div class="col-md-2" align="right"  style="padding-top: 5px;color: #767676">
                <button type="button" class="btn btn-info" id="button_nuevo1" name="button_nuevo1" onclick="'.$evento.'" >Nuevo 
                            <i class="icon-white icon-plus"></i>
                </button></div> ';
    
    

                            
 
 
?>