<?php   
 
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
	$bd	   =	new Db;	
	$obj     = 	new objects;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $datos = array();
    
    
      
    $id='0';
  
    
    $evento = 'onChange="BusquedaGrilla('.$id.', this.value)"';
    
    $MATRIZ = array(
        '1'    => '1. Por Enviar',
        '2'    => '2. Enviados',
        '3'    => '3. En ejecucion',
        '4'    => '4. Terminados',
        '5'    => '5. Finalizados',
        '6'    => '6. Anulados',
    );
 
    $datos['vidproceso'] = '999';
    $datos['vidproceso_nombre'] = 'Control Documental';
   
    $obj->text->texto_oculto("vidproceso",$datos); 
     
    $obj->text->texto_oculto("vidproceso_nombre",$datos); 
 
    
 
    
    $obj->list->listae('',$MATRIZ,'vestado',$datos,'required','',$evento,'div-0-4');
    
    
    $evento = "javascript:changeAction('confirmar','','Desea agregar nuevo registro')" ;
    
    echo '<div class="col-md-8" align="right"  style="padding-top: 5px;color: #767676">
                <button type="button" class="btn btn-info btn-sm" id="button_nuevo1" name="button_nuevo1" onclick="'.$evento.'" >Nuevo 
                            <i class="icon-white icon-plus"></i>
                </button></div> ';
    
    

                            
 
 
?>