<?php
  /* Clase encargada de gestionar botones y eventos */

class objects_boton  {
    
   // private $tipo;
  // private $stmt;
  // private $array;
  
private static $_instance;
 


function ToolMenu($ToolArray){	
 
    /*
 echo '<div class="col-md-12">
           <div align="right">
               <div style="padding-top:5px; padding-bottom:5px; padding-right:10px">';
 
 */
 echo ' <div class="col-md-12" style="background-image:url(../../kimages/b1.png)">
                 <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#696969" id="result">
                    <b>FORMULARIO DE GESTION DE DATOS</b>
                </div>
                <div class="col-md-4" style="padding: .5em;" >
                     <div align="right"> ';
           
   $longitud = count($ToolArray);
    
    // columnas                                       
    for ($row = 0; $row < $longitud; $row++)
    {
     
     //  <button class="btn btn-primary btn-primary" onClick=""><i class="icon-white icon-list"></i></button>
     /*  $ToolArray = array( 
                        array( boton => 'Busqueda',        evento =>'',  grafico => 'glyphicon glyphicon-search' ,  type=>"submit"),
                        array( boton => 'Impresion Libro', evento =>'',  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
                        array( boton => 'Exportar Excel',  evento =>'',  grafico => 'glyphicon glyphicon-export' ,  type=>"button") 
                        );
       */     
          $idrandom    = rand(1,100);
        
        
          $evento = '';
          $name = 'button'.$idrandom;
          $grafico = $ToolArray[$row][grafico];
          $clase = 'btn btn-primary btn-primary';
          
           if ( $ToolArray[$row][type] == 'submit' ){
            
               $name = ' id="guardaicon_'.$idrandom.'" name="guardaicon_'.$idrandom.'" ';
              $clase = 'btn btn-primary btn-warning';   
           }
             
           if ( !empty($ToolArray[$row][evento])){
               $evento = 'onClick="'.$ToolArray[$row][evento].'"';
               
           }
           
           if ( $ToolArray[$row][type] == 'add' ){
            
              $name = ' ';
              $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
              $evento  = 'onClick="'.$accion.'"';
              $grafico = "icon-white icon-plus"   ;  
              $clase = 'btn btn-primary btn-info';
           } 
           
           echo '&nbsp;<button  type="'.$ToolArray[$row][type].'" '.$name.'
                          class="'.$clase.'" '.$evento.' 
                          title="'.$ToolArray[$row][boton].'">
                          <i class="'.$grafico.'"></i>
                </button>';
           
    }
 
                                 
     echo ' </div> 
            </div>
              </div>';
              
 return true;									  
}	
//----------------
function ToolMenuDivSet($ToolArray){
    /*
     echo ' <div class="col-md-12"
     style="background-color:#ededed;-webkit-box-shadow: -5px 16px 21px -21px rgba(10,10,10,1);
     -moz-box-shadow: -5px 16px 21px -21px rgba(10,10,10,1); box-shadow: -5px 16px 21px -21px rgba(10,10,10,1);">
     
     <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#696969" id="result">
     <b>FORMULARIO DE GESTION DE DATOS</b>
     </div>
     <div class="col-md-4" style="padding: .5em;" >
     <div align="right"> ';
     
     */
    
    echo ' <div class="col-md-12">
                  <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#68737d;font-size: 13px" id="result">
                    <b><img src="../../kimages/if_error_36026.png" align="absmiddle"/> FORMULARIO DE DATOS... <span style="color: #BA0D0F">AGREGAR UN NUEVO REGISTRO PRESIONE (+) NUEVO</span>   </b>
                </div>
                <div class="col-md-4" style="padding: .5em;" >
                     <div align="right"> ';

    $longitud = count($ToolArray);
    
    // columnas
    for ($row = 0; $row < $longitud; $row++)
    {
        
       
        
        $idrandom    = rand(1,100);
        
        $evento       = '';
        $name         = "id="."'button".$idrandom."'";
        $grafico      = $ToolArray[$row][grafico];
        $clase        = 'btn btn-primary';
        $tipo_bton    = $ToolArray[$row][type];
        $clase_nombre = '';
        $texto        = '';
        
        if ( $ToolArray[$row][type] == 'submit' ){
            $name     = ' id="guardaicon_'.$idrandom.'" name="guardaicon_'.$idrandom.'" ';
            $clase    = 'btn btn-success';
            $tipo_bton = 'submit';
            $clase_nombre =' Enviar Informacion';
        }
        
        if ( !empty($ToolArray[$row][evento])){
            $evento   = 'onClick="'.$ToolArray[$row][evento].'"';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'modal' ){
            $name            = ' ';
            $modaltipo       = $ToolArray[$row][evento];
            $modaltipoA      = explode('-',$modaltipo);
            $evento_control  = $modaltipoA[1];
            $evento_modal    = '';
            
            if (!empty($evento_control) ) {
                $evento_modal = ' onClick="'.$evento_control.'" ';
            }
            
            $evento  = $evento_modal.' data-toggle="modal" data-target="'.$modaltipoA[0].'" ';
            $clase = 'btn btn-success';
            $tipo_bton = 'button';
        }
        
        
        if ( $ToolArray[$row][type] == 'add' ){
            $name    = ' ';
            $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
            $evento  = 'onClick="'.$accion.'"';
            $grafico = "icon-white icon-plus"   ;
            $clase   = 'btn btn-info';
            $tipo_bton = 'button';
            $texto = 'Nuevo';
        }
        
        //---------------------------------------------------------
        
        if ( $ToolArray[$row][type] == 'button_danger' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-danger';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_success' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-success';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_default' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-default';
            $name = "id="."'button".$idrandom."'";
        }
        
        
        if ( $ToolArray[$row][type] == 'button_info' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-info"';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_warning' ){
            
            $clase = 'btn btn-warning';
            $tipo_bton = 'button';
            $name = "id="."'button".$idrandom."'";
        }
        
        echo '&nbsp;<button  type="'.$tipo_bton.'" '.$name.'
                             class="'.$clase.'" '.$evento.'
                             title="'.$ToolArray[$row][boton].'">
                            <i class="'.$grafico.'"></i> '.$clase_nombre.
                            $texto.'</button>';
        
    }
    
    echo ' </div>  </div></div>';
    
    return true;
}
/*
MENSAJE QUE DESPLIEGA EN LA BARRA DE HERRAMIENTAS 
FORMULARIO DE INGRESO DE DATOS
*/

function mensaje_crud($tipo,$accion,$id){

    if ($tipo == 0){
        if ($accion == 'editar')

          $resultado = '<div class="alert alert-info">
          <img src="../../kimages/if_bullet_blue_35773.png" align="absmiddle" />&nbsp;<strong>EDITAR REGISTRO TRANSACCION</strong>   PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION ( '.$id.' )
          </div>';

        if ($accion == 'del')    

        $resultado = '<div class="alert alert-danger">
        <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle" />&nbsp;<strong>ELIMINAR REGISTRO TRANSACCION</strong>   PRESIONE EL ICONO DE GUARDAR PARA PROCESAR ESTA ACCION ( '.$id.' )
        </div>';
   }

    if ($tipo == 1){
           $resultado = '<div class="alert alert-warning">
                            <img src="../../kimages/if_bullet_yellow_35791.png" align="absmiddle" />&nbsp;<strong>ACTUALIZACION</strong> INFORMACION GUARDADA CON EXITO ( '.$id.' ) 
                        </div>';
    }

    if ($tipo == 4){
      $resultado = '<div class="alert alert-info">
                       <img src="../../kimages/if_bullet_green_35779.png" align="absmiddle" />&nbsp;<strong>ACTUALIZACION</strong> INFORMACION APROBADA CON EXITO ( '.$id.' ) 
                   </div>';
    }


    if ($tipo == 3){
      $resultado = '<div class="alert alert-danger">
      <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle" />&nbsp;<strong>INFORMACION ELIMINADA TRANSACCION</strong>   ACTUALICE EL FORMULARIO PARA VERIFICAR INFORMACION ( '.$id.' )
      </div>';
    }

    if ($tipo == -1){
      $resultado = '<div class="alert alert-danger">
      <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle" />&nbsp;<strong>INFORMACION NO VALIDA</strong>   VERIFIQUE LOS ESTADOS Y LA INFORMACION DE LA TRANSACCION ( '.$id.' )
      </div>';
    }

    if ($tipo == 99){
      $resultado = '<div class="alert alert-danger">
      <img src="../../kimages/if_bullet_red_35785.png" align="absmiddle" />&nbsp;<strong>INFORMACION</strong> '.$accion.' ( '.$id.' )
      </div>';
    }

    return  $resultado;

}
/*
BARRA DE HERRAMIENTAS 
FORMULARIO DE INGRESO DE DATOS
*/
function ToolMenuDiv($ToolArray){
 
    
    echo ' <div class="col-md-12">
                  <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#68737d;font-size: 13px" id="result">
                    <b><img src="../../kimages/if_error_36026.png" align="absmiddle"/> FORMULARIO DE DATOS... <span style="color: #BA0D0F">AGREGAR UN NUEVO REGISTRO PRESIONE (+) NUEVO</span>   </b>
                </div>
                <div class="col-md-4" style="padding: .5em;" >
                     <div align="right"> ';
	 
	$longitud = count($ToolArray);

	// columnas
	for ($row = 0; $row < $longitud; $row++)
	{
                        
                        $texto = '';

                        $idrandom    = rand(1,100);
                          
                        $evento       = '';
                        $name         = "id="."'button".$idrandom."'";
                        $grafico      = $ToolArray[$row][grafico];
                        $clase        = 'btn btn-primary';
                        $tipo_bton    = $ToolArray[$row][type];
                        

                        if ( $ToolArray[$row][type] == 'submit' ){
                            $name     = ' id="guardaicon_'.$idrandom.'" name="guardaicon_'.$idrandom.'" ';
                          $clase    = 'btn btn-warning';
                          $tipo_bton = 'submit';
                        }
                        
                        if ( !empty($ToolArray[$row][evento])){
                          $evento   = 'onClick="'.$ToolArray[$row][evento].'"';
                          $name = "id="."'button".$idrandom."'";
                        }
                        
                        if ( $ToolArray[$row][type] == 'modal' ){
                          $name            = ' ';
                          $modaltipo       = $ToolArray[$row][evento];
                          $modaltipoA      = explode('-',$modaltipo);
                          $evento_control  = $modaltipoA[1];
                          $evento_modal    = '';
                          
                          if (!empty($evento_control) ) {
                              $evento_modal = ' onClick="'.$evento_control.'" ';
                          }
                          
                          $evento  = $evento_modal.' data-toggle="modal" data-target="'.$modaltipoA[0].'" ';
                          $clase = 'btn btn-success';
                          $tipo_bton = 'button';
                          }
                          
                        
                        if ( $ToolArray[$row][type] == 'add' ){
                          $name    = ' ';
                          $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
                          $evento  = 'onClick="'.$accion.'"';
                          $grafico = "icon-white icon-plus"   ;
                          $clase   = 'btn btn-info';
                          $tipo_bton = 'button';
                          $texto     = ' Nuevo';
                        }
                        
                        //---------------------------------------------------------
                        
                        if ( $ToolArray[$row][type] == 'button_danger' ){
                            $tipo_bton = 'button';
                            $clase = 'btn btn-danger';
                            $name = "id="."'button".$idrandom."'";
                        }
                        
                        if ( $ToolArray[$row][type] == 'button_success' ){
                            $tipo_bton = 'button';
                            $clase = 'btn btn-success';
                            $name = "id="."'button".$idrandom."'";
                        }
                        
                        if ( $ToolArray[$row][type] == 'button_default' ){
                            $tipo_bton = 'button';
                            $clase = 'btn btn-default';
                            $name = "id="."'button".$idrandom."'";
                        }
                        
                        
                        if ( $ToolArray[$row][type] == 'button_info' ){
                            $tipo_bton = 'button';
                            $clase = 'btn btn-info"';
                            $name = "id="."'button".$idrandom."'";
                        }
                        
                        if ( $ToolArray[$row][type] == 'button_warning' ){
                            
                            $clase = 'btn btn-warning';
                            $tipo_bton = 'button';
                            $name = "id="."'button".$idrandom."'";
                        }
                        
                        echo '&nbsp;<button  type="'.$tipo_bton.'" '.$name.'
                                                class="'.$clase.'" '.$evento.'
                                                title="'.$ToolArray[$row][boton].'">
                                                <i class="'.$grafico.'"></i> '.$texto.'
                                    </button>';
		 
	}
 	 
	echo ' </div>  </div></div>';

	return true;
}
//---------------------------------
function ToolMenuDivCrm($ToolArray){
    
    
    echo ' <div class="col-md-12">
                  <div class="col-md-7" style="vertical-align: middle;padding: 15px;color:#68737d;font-size: 13px" id="result">
                  <b><img src="../../kimages/if_error_36026.png" align="absmiddle"/> FORMULARIO DE INFORMACION... <span style="color: #BA0D0F">AGREGAR UN NUEVO REGISTRO PRESIONE (+) NUEVO</span>   </b>
                 </div>
                <div class="col-md-5" style="padding: .5em;" >
                     <div align="right"> ';
    
    $longitud = count($ToolArray);
    
    // columnas
    for ($row = 0; $row < $longitud; $row++)
    {
        
        /*  $ToolArray = array(
         array( boton => 'Busqueda',        evento =>'',  grafico => 'glyphicon glyphicon-search' ,  type=>"submit"),
         array( boton => 'Exportar Excel',  evento =>'',  grafico => 'glyphicon glyphicon-export' ,  type=>"button")
         );
         */
        
        $evento       = '';
        $name         = "id="."'button".$row."'";
        $grafico      = $ToolArray[$row][grafico];
        $clase        = 'btn btn-primary';
        $tipo_bton    = $ToolArray[$row][type];
        
        
        if ( $ToolArray[$row][type] == 'submit' ){
            $name     = ' id="guardaicon" name="guardaicon" ';
            $clase    = 'btn btn-warning';
            $tipo_bton = 'submit';
        }
        
        if ( !empty($ToolArray[$row][evento])){
            $evento   = 'onClick="'.$ToolArray[$row][evento].'"';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'modal' ){
            $name            = ' ';
            $modaltipo       = $ToolArray[$row][evento];
            $modaltipoA      = explode('-',$modaltipo);
            $evento_control  = $modaltipoA[1];
            $evento_modal    = '';
            
            if (!empty($evento_control) ) {
                $evento_modal = ' onClick="'.$evento_control.'" ';
            }
            
            $evento  = $evento_modal.' data-toggle="modal" data-target="'.$modaltipoA[0].'" ';
            $clase = 'btn btn-success';
            $tipo_bton = 'button';
        }
        
        
        if ( $ToolArray[$row][type] == 'add' ){
            $name    = ' ';
            $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
            $evento  = 'id = "button_nuevo" name = "button_nuevo" onClick="'.$accion.'"';
            $grafico = "icon-white icon-plus"   ;
            $clase   = 'btn btn-info';
            $tipo_bton = 'button';
        }
        
        //---------------------------------------------------------
        
        if ( $ToolArray[$row][type] == 'button_danger' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-danger';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_success' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-success';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_default' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-default';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        
        if ( $ToolArray[$row][type] == 'button_info' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-info"';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_warning' ){
            
            $clase = 'btn btn-warning';
            $tipo_bton = 'button';
            $name = "id="."'button".$row."' name="."'button".$row."'";
        }
        
        echo '&nbsp;<button  type="'.$tipo_bton.'" '.$name.'
                             class="'.$clase.'" '.$evento.'
                             title="'.trim($ToolArray[$row][boton]).'">'.trim($ToolArray[$row][boton]).'
                            <i class="'.$grafico.'"></i>
                </button>';
        
    }
    
    echo ' </div>  </div></div>';
    
    return true;
}
//---------------------
function ToolMenuDivId($ToolArray,$Id){
    
    
    echo ' <div class="col-md-12"
                style="background-color:#ffffff;">
        
                 <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#696969" id="'.$Id.'">
                    <b>FORMULARIO DE GESTION DE DATOS</b>
                </div>
                <div class="col-md-4" style="padding: .5em;" >
                     <div align="right"> ';
    
 
    $longitud = count($ToolArray);
    
    // columnas
    for ($row = 0; $row < $longitud; $row++)
    {
        
        //  <button class="btn btn-primary btn-primary" onClick=""><i class="icon-white icon-list"></i></button>
        /*  $ToolArray = array(
         array( boton => 'Busqueda',        evento =>'',  grafico => 'glyphicon glyphicon-search' ,  type=>"submit"),
         array( boton => 'Impresion Libro', evento =>'',  grafico => 'glyphicon glyphicon-print' ,  type=>"button"),
         array( boton => 'Exportar Excel',  evento =>'',  grafico => 'glyphicon glyphicon-export' ,  type=>"button")
         );
        
         <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-filter"></span></button>
         
         */
        $idrandom    = rand(1,100);
        
        $evento = '';
        $name = "id="."'button".$row."'";
        $grafico = $ToolArray[$row][grafico];
        $clase = 'btn btn-primary btn-primary';
        
        
        $tipo_bton = $ToolArray[$row][type];
        
        
        if ( $ToolArray[$row][type] == 'submit' ){
            $tipo_bton =  'submit';
            $name = ' id="guardaicon_'.$idrandom.'" name="guardaicon_'.$idrandom.'" ';
            $clase = 'btn btn-primary btn-warning';
        }
        
        if ( !empty($ToolArray[$row][evento])){
            $evento = 'onClick="'.$ToolArray[$row][evento].'"';
            
        }
        
        if ( $ToolArray[$row][type] == 'modal' ){
            $name = ' ';
            $modaltipo = $ToolArray[$row][evento];
            $modaltipoA = explode('-',$modaltipo);
            
            $evento_control = $modaltipoA[1];
            $evento_modal = '';
            
            if (!empty($evento_control) ) {
                $evento_modal = 'onClick="'.$evento_control.'" ';
            }
            
            $evento  = $evento_modal.' data-toggle="modal" data-target="'.$modaltipoA[0].'" ';
            
            $clase = 'btn btn-primary btn-success';
            $tipo_bton = 'button';
        }
        
        
        
        if ( $ToolArray[$row][type] == 'add' ){
            
            $name = ' ';
            $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
            $evento  = 'onClick="'.$accion.'"';
            $grafico = "icon-white icon-plus"   ;
            $clase = 'btn btn-primary btn-info';
        }
        
        if ( $ToolArray[$row][type] == 'addDetalle' ){
            
            $name = ' ';
            $tipo_bton = 'button';
            $grafico = "icon-white icon-plus"   ;
            $clase = 'btn btn-primary';
        }
        
        if ( $ToolArray[$row][type] == 'button_danger' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-danger';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_success' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-success';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_default' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-default';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_info' ){
            $tipo_bton = 'button';
            $clase = 'btn btn-info"';
            $name = "id="."'button".$idrandom."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_warning' ){
            
            $clase = 'btn btn-warning';
            $tipo_bton = 'button';
            $name = "id="."'button".$idrandom."'";
        }
        
        echo '&nbsp;<button  type="'.$tipo_bton.'" '.$name.'
                          class="'.$clase.'" '.$evento.'
                          title="'.$ToolArray[$row][boton].'">
                          <i class="'.$grafico.'"></i>
                </button>';
        
    }
    
    
    echo ' </div>
               </div></div>';
    
    return true;
}
/*
*/
function ToolMenuDivTitulo($ToolArray,$titulo){
    
    echo ' <div class="col-md-12">
        
                 <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#68737d;font-size: 13px" id="result">
                    <b>PARA CREAR UNA NUEVA FACTURA PRESIONE EL ICONO DE AGREGAR</b>
                </div>
                <div class="col-md-4" style="padding: .5em;" >
                     <div align="right"> 
 <div style="padding-top:5px; padding-bottom:5px; padding-right:10px">'.$titulo.'&nbsp;';
 
    
    $longitud = count($ToolArray);
    
    // columnas
    for ($row = 0; $row < $longitud; $row++)
    {
        
       
        $evento = '';
        $name = 'button'.$row;
        $grafico = $ToolArray[$row][grafico];
        $clase = 'btn btn-primary btn-primary';
        $tipo  = $ToolArray[$row][type]; 
         
        if ( $ToolArray[$row][type] == 'submit' ){
            
            $name = ' id="guardaicon" name="guardaicon" ';
            $clase = 'btn btn-primary btn-warning';
            $tipo  = 'submit';
        }
        
        if ( !empty($ToolArray[$row][evento])){
            $evento = 'onClick="'.$ToolArray[$row][evento].'"';
            
        }
        if ( $ToolArray[$row][type] == 'modal' ){
            $name = ' ';
            $modaltipo = $ToolArray[$row][evento];
            $evento  = ' data-toggle="modal" data-target="'.$modaltipo.'" ';
            $grafico = "glyphicon glyphicon-filter"   ;
            $clase = 'btn btn-primary btn-success';
            $name = "id="."'button".$row."'";
            $tipo  = 'button';
        }
        
        if ( $ToolArray[$row][type] == 'button_danger' ){
            
             $clase = 'btn btn-danger';
             $tipo  = 'button';
             $name = "id="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_success' ){
            
            $clase = 'btn btn-success';
            $tipo  = 'button';
            $name = "id="."'button".$row."'";
        }
       
        if ( $ToolArray[$row][type] == 'button_default' ){
            
            $clase = 'btn btn-default';
            $tipo  = 'button';
            $name = "id="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_warning' ){
            
            $clase = 'btn btn-warning';
            $tipo  = 'button';
            $name = "id="."'button".$row."'";
        }
        
        if ( $ToolArray[$row][type] == 'button_info' ){
            $tipo = 'button';
            $clase = 'btn btn-info"';
            $name = "id="."'button".$row."'";
        }

        if ( $ToolArray[$row][type] == 'add' ){
            
            $name = ' ';
            $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
            $evento  = 'onClick="'.$accion.'"';
            $grafico = "icon-white icon-plus"   ;
            $clase = 'btn btn-info';
            $tipo  = 'button';
        }
        
        
        echo '&nbsp;<button  type="'.$tipo.'" '.$name.'
                          class="'.$clase.'" '.$evento.'
                          title="'.$ToolArray[$row][boton].'">
                          <i class="'.$grafico.'"></i>
                </button>';
        
    }
    
    
    
    echo ' </div>  </div> </div></div>';
    
    return true;
}
/*
*/
function ToolMenuDivTitulo_punto($ToolArray,$titulo){
    
  echo ' <div class="col-md-12">
      
               <div class="col-md-8" style="vertical-align: middle;padding: 15px;color:#68737d;font-size: 13px" id="result">
                  <b>PARA CREAR UNA NUEVA FACTURA PRESIONE EL ICONO DE AGREGAR</b>
              </div>
              <div class="col-md-4" style="padding: .5em;" >
                   <div align="right"> 
<div style="padding-top:5px; padding-bottom:5px; padding-right:10px">'.$titulo.'&nbsp;';

  
  $longitud = count($ToolArray);
  
  // columnas
  for ($row = 0; $row < $longitud; $row++)
  {
      
     
      $evento = '';
      $name = 'button'.$row;
      $grafico = $ToolArray[$row][grafico];
      $clase = 'btn btn-primary btn-lg';
      $tipo  = $ToolArray[$row][type]; 
       
      if ( $ToolArray[$row][type] == 'submit' ){
          
          $name = ' id="guardaicon" name="guardaicon" ';
          $clase = 'btn btn-warning btn-lg';
          $tipo  = 'submit';
      }
      
      if ( !empty($ToolArray[$row][evento])){
          $evento = 'onClick="'.$ToolArray[$row][evento].'"';
          
      }
      if ( $ToolArray[$row][type] == 'modal' ){
          $name = ' ';
          $modaltipo = $ToolArray[$row][evento];
          $evento  = ' data-toggle="modal" data-target="'.$modaltipo.'" ';
          $grafico = "glyphicon glyphicon-filter"   ;
          $clase = 'btn btn-success btn-lg';
          $name = "id="."'button".$row."'";
          $tipo  = 'button';
      }
      
      if ( $ToolArray[$row][type] == 'button_danger' ){
          
           $clase = 'btn btn-danger btn-lg';
           $tipo  = 'button';
           $name = "id="."'button".$row."'";
      }
      
      if ( $ToolArray[$row][type] == 'button_success' ){
          
          $clase = 'btn btn-success btn-lg';
          $tipo  = 'button';
          $name = "id="."'button".$row."'";
      }
     
      if ( $ToolArray[$row][type] == 'button_default' ){
          
          $clase = 'btn btn-default btn-lg';
          $tipo  = 'button';
          $name = "id="."'button".$row."'";
      }
      
      if ( $ToolArray[$row][type] == 'button_warning' ){
          
          $clase = 'btn btn-warning btn-lg';
          $tipo  = 'button';
          $name = "id="."'button".$row."'";
      }
      
      if ( $ToolArray[$row][type] == 'button_info' ){
          $tipo = 'button';
          $clase = 'btn btn-info btn-lg';
          $name = "id="."'button".$row."'";
      }

      if ( $ToolArray[$row][type] == 'add' ){
          
          $name = ' ';
          $accion  = "javascript:changeAction('confirmar','".$ToolArray[$row][evento]."','Desea agregar nuevo registro')";
          $evento  = 'onClick="'.$accion.'"';
          $grafico = "icon-white icon-plus"   ;
          $clase = 'btn btn-info btn-lg';
          $tipo  = 'button';
      }
      
      
      echo '&nbsp;<button  type="'.$tipo.'" '.$name.'
                        class="'.$clase.'" '.$evento.'
                        title="'.$ToolArray[$row][boton].'">
                        <i class="'.$grafico.'"></i>
              </button>';
      
  }
  
  
  
  echo ' </div>  </div> </div></div>';
  
  return true;
}
// boton buscar
function KP_button_search(){	
?>    
    <button id="guardai" name="guardai" class="btn btn-warning btn-notification" data-loading-text="Loading..." title="Busqueda de registro">Busqueda</button>
<?php
 return true;									  
}	
function button_search($fila,$salto){	
  if (!empty($fila))  {
    echo '<td align="left">';
  }   
?>    
    <button id="guardai" name="guardai" class="btn btn-warning btn-notification"  title="Busqueda de registro">Busqueda</button>
<?php
  if (!empty($fila))  {
     echo '</td>';
  } 
  if (!empty($salto))  {
     echo '</tr>';
  } 
 return true;									  
}
function KP_button_searchc($titulo){	
 
 $titulo = utf8_encode(utf8_decode($titulo));    
 
 echo '<button class="btn btn-warning btn-notification"  title="'.$titulo.'">'.$titulo.'</button>';
 
 return true;									  
}
// boton guardar
function KP_button_generar(){	
    
 $titulo = utf8_encode(utf8_decode('Generar transacci�n'));     
 
 echo '<button class="btn btn-warning btn-notification"  title="Generar registro">'.$titulo.'</button>';
 
 return true;									  
}
function KP_button_proceso(){	

 $titulo = utf8_encode(utf8_decode('Procesar transaccion')); 
      
 echo '<button class="btn btn-inverse"  title=">Procesar transaccion">'.$titulo.'</button>';
 return true;									  
}
 // boton añaidr
function KP_button_add($url){
?>
  <button type="button"  class="btn btn-primary"  onclick="javascript:changeAction('confirmar','<?php echo $url; ?>','Desea agregar nuevo registro')" 
  title ="Nuevo Registro">Nuevo registro</button>
<?php  
  return true;									  
}
 // boton añaidr con evento javascript
function KP_button_evento($url,$evento,$mensaje){	
  $titulo = utf8_encode(utf8_decode($mensaje)); 
?>  
   <button type="button"  class="btn btn-primary" onclick="<?php echo $evento ?>" title ='Procesos'><?php echo $titulo ?></button>
<?php   
  return true;									  
}
function button_evento($url,$evento,$mensaje,$fila,$salto){	
  
  $titulo = utf8_encode(utf8_decode($mensaje)); 
  
  if (!empty($fila))  {
    echo '<td align="left">';
  } 
  
?>  
   <button type="button"  class="btn btn-primary" onclick="<?php echo $evento ?>" title ='Procesos'><?php echo $titulo ?></button>
<?php 

 if (!empty($fila))  {
     echo '</td>';
  } 
  if (!empty($salto))  {
     echo '</tr>';
  }   
  return true;									  
}
// boton de aprobación
function KP_button_ok($url,$mensaje){	
 
     
 $evento ="javascript:changeAction('confirmar','".$url."','Desea aprobar la trasancción')";
 echo '<button type="button" ';
 echo 'class="btn btn-inverse" '; 
 echo 'onclick="'.$evento.'"';
 echo "title '$mensaje'>$mensaje";
 echo "</button>";
 return true;									  
}
// boton de anulacion
function KP_button_anula($url,$mensaje){	

 
  
 $evento ="javascript:changeAction('confirmar','".$url."','Desea anular/eliminar la trasancción')";
 echo '<button type="button" ';
 echo 'class="btn btn-danger" '; 
 echo 'onclick="'.$evento.'"';
 echo "title '$mensaje'>$mensaje";
 echo "</button>";
 return true;									  
}
// boton de aprobacion de procesos
function KP_button_gestion($titulo,$mensaje){	
  
  $titulo = utf8_encode(utf8_decode($titulo)); 
    
  $evento = "return confirm('".$titulo."')";
  $onclick = 'onclick="'.$evento.'"';

  echo '<button id="guardai" name="guardai" '.$onclick.' class="btn btn-warning btn-notification"  title="'.$mensaje.'">'.$mensaje.'</button>';
} 
// boton evento url	
function KP_button($url,$titulo){	

  $titulo = utf8_encode(utf8_decode($titulo)); 
  
?> 
  <a class="btn btn-primary" title="<?php  echo $titulo ?>" href="<?php  echo $url ?>"><?php  echo $titulo ?> </a>

<?php 

 return true;									  
} 
// boton evento url	
function KP_buttonBack($url,$titulo){	

  $titulo = utf8_encode(utf8_decode($titulo)); 
  
?> 
  <a class="btn btn-primary" title="<?php echo $titulo ?>" href="<?php  echo $url ?>" data-toggle="tab"><?php  echo $titulo ?> </a>

<?php 
 return true;									  
} 
//------------------------------------------------------------------
//------------------------------------------------------------------
//------------------------------------------------------------------
function icon_button_left($url,$titulo){	
  $titulo = utf8_encode(($titulo)); 
  
?>  
 <button type="button"  class="btn btn" onclick="javascript:changeAction('confirmar','<?php echo $url; ?>','Regresar')" 
  title ="<?php echo $titulo ?>">
  <i class="icon-arrow-left"></i>
  </button>
<?php 
 return true;									  
} 
//------------------------------------------------------------------
//------------------------------------------------------------------
//------------------------------------------------------------------
function icon_button_add($url){
?>
  <button class="btn btn-primary"  onclick="javascript:changeAction('confirmar','<?php echo $url; ?>','Desea agregar nuevo registro')" 
  title ="Nuevo Registro"><i class="icon-white icon-plus"></i></button>
<?php  
  return true;									  
}
function icon_button_addE($url){
?>
  <button class="btn btn-primary"  onclick="javascript:changeActionE('confirmar','<?php echo $url; ?>','Desea agregar nuevo registro')" 
  title ="Nuevo Registro"><i class="icon-white icon-plus"></i></button>
<?php  
  return true;									  
}	
 // boton añaidr con evento javascript
function icon_button_reporte($url,$evento,$mensaje){	
  $titulo = utf8_encode(($mensaje)); 
?>  
   <button type="button"  class="btn btn" onclick="<?php echo $evento ?>" title ='<?php echo $titulo ?>'>
    <i class="icon-print"></i>
   </button>
<?php   
  return true;									  
}	
 // boton añaidr con evento javascript
function icon_button_back($url,$evento,$mensaje){	
  $titulo = utf8_encode(($mensaje)); 
?>  
   <button type="button"  class="btn btn" onclick="<?php echo $evento ?>" title ='<?php echo $titulo ?>'>
    <i class="icon-share-alt"></i>
   </button>
<?php   
  return true;									  
}	
function icon_button_save($mensaje='Guardar cambios'){	
?>

<button class="btn btn-warning" type="submit" id="guardaicon" name="guardaicon" title="Guardar registro" ><i class="icon-white icon-save"></i></button>

<?php
 return true;									  
}
function icon_button_process($mensaje='Guardar cambios'){	
?>
<button type="submit" id="guardaicon" name="guardaicon" class="btn btn"  title="Ejecutar procesos">
 <i class="icon-download-alt"></i>  
 </button>

<?php
 return true;									  
}
function icon_button_search($mensaje='Guardar cambios'){	
?>
<button type="submit" id="guardaicon" name="guardaicon" class="btn btn"  title="Buscar registros">
 <i class="icon-white icon-search"></i>  
 </button>

<?php
 return true;									  
}
 // boton añaidr con evento javascript
function icon_button_evento($url,$evento,$mensaje){	
  $titulo = utf8_encode(utf8_decode($mensaje)); 
?>  
   <button type="button"  class="btn btn" onclick="<?php echo $evento ?>" title ='<?php echo $titulo ?>'>
    <i class="icon-bolt"></i>
   </button>
<?php   
  return true;									  
}
 // boton añaidr con evento javascript
function icon_button_grafico($url,$evento,$mensaje,$tipo){	
  $titulo = utf8_encode(utf8_decode($mensaje)); 
?>  
   <button type="button"  class="btn btn" onclick="<?php echo $evento ?>" title ='<?php echo $titulo ?>'>
    <i class="<?php echo $tipo; ?>"></i>
   </button>
<?php   
  return true;									  
}
 // boton añaidr con evento javascript
function icon_button_editor($url,$evento,$mensaje){	
  $titulo = utf8_encode(utf8_decode($mensaje)); 
?>  
   <button type="button"  class="btn btn" onclick="<?php echo $evento ?>" title ='<?php echo $titulo ?>'>
    <i class="icon-th-list"></i>
   </button>
<?php   
  return true;									  
}
// boton eliminar
function icon_button_del(){	
?>  
   <button type="button" class="btn btn-danger"  title ="Eliminar registro"><i class="icon-white icon-trash"></i></button>
 
<?php     
 
 return true;									  
}
// boton eliminar
function KP_button_del(){	
 echo '<button class="btn btn-warning btn-notification"  title="Eliminar registro">Eliminar registro</button>';
 return true;									  
}	
// boton guardar
function KP_button_save($mensaje='Guardar cambios'){	
?>
 <button id="guardai" name="guardai" class="btn btn-warning btn-notification"  title="Guardar registro"><?php echo $mensaje; ?></button>
<?php
 return true;									  
}	
// boton guardar
function KP_button_cerrar($mensaje='Guardar cambios'){	
?>
 <button class="btn btn-primary" onclick="javascript:window.close()"  title="Guardar registro">Cerrar ventana</button>
<?php
 return true;									  
}
// boton guardar
function KP_button_save_web($mensaje='Guardar cambios'){	
 
   $titulo = utf8_encode(utf8_decode($titulo));     
 //$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 echo '<button id="guardai" name="guardai" class="btn btn-primary btn-lg"  title="Guardar registro">'.$mensaje.'  <i class="icon-angle-right"></i></button>';
 return true;									  
}	

// boton guardar
// boton evento url	
function KP_button_black($url,$titulo){	
  
   $titulo = utf8_encode(utf8_decode($titulo)); 
     
 //$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 echo '<a class="btn btn-inverse" title="'.$titulo.'" href="'.$url.'">'.$titulo.'</a>';
 return true;									  
}	
// boton evento url	
function KP_button_efecto($url,$titulo){	
 
 $titulo = utf8_encode(utf8_decode($titulo));  
//$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 echo '<a id="btn-load-then-complete" class="btn btn-success" data-loading-text="Loading..." data-complete-text="Procesando" title="'.
 	   $titulo.'" href="'.
 	   $url.'"><i class="icon-barcode"></i> '.
	   $titulo.'</a>&nbsp;&nbsp;';
 return true;									  
}	
// boton evento de añadir url	
function KP_button_iconadd($url,$titulo){	
 $titulo = utf8_encode(utf8_decode($titulo));  
 echo '<a class="btn" title="'.$titulo.'" href="'.$url.'"><i class="icon-folder-open"></a>';
 return true;									  
}	
// boton evento fondo rojo
function KP_button_red($url,$titulo){	
 
  $titulo = utf8_encode(utf8_decode($titulo));  
// KP_button_add('admin_empresa?action=add#tab2');
 
 echo '<a class="btn btn-danger" title="'.$titulo.'" href="'.$url.'">'.$titulo.'</a>';
 
 return true;									  
}		  
// boton evento url	
function KP_button_addi($url,$titulo){	
    
 $titulo = '';
 // KP_button_add('admin_empresa?action=add#tab2');
 echo '<a class="btn btn-success" title="'.$titulo.'" href="'.$url.'">'.$titulo.' <i class="icon-plus icon-white"></i></a>';
 return true;									  
}		  
// boton guardar
function KP_button_onclic($evento,$titulo){	
    $titulo = utf8_encode(utf8_decode($titulo));  
?>    
 <button class="btn btn-primary"  onclick="<?php echo $evento ?>"><?php echo $titulo ?></button> 
<?php 
 return true;									  
}		
function KP_button_excel(){	
 //$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 
 $evento = 'javascript:imprimir_excel()';
 //echo '<button class="btn btn-info"  onclick="'.$evento.'">'.$titulo.'</button>';
 echo '&nbsp;<button class="btn" title="Exportar información a excel"  onclick="'.$evento.'"><i class="icon-download-alt"></i></button>&nbsp;';
 return true;									  
}		
function KP_button_reporte() {	
 // KP_button_add('admin_empresa?action=add#tab2');
 //$titulo = 'Exportar Excel';
 $evento = 'javascript:imprimir_reporte()';
 echo '<button class="btn" title="Impresion de datos"  onclick="'.$evento.'"><i class="icon-print"></i></button>';
 return true;									  
}		  	  	  		  
function KP_button_comprobante($url){	
    
 	//$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 	$evento = "javascript:imprimir_comprobante('".$url."')";
	echo '<button class="btn" title="Impresion de datos"  onclick="'.$evento.'"><i class="icon-print"></i></button>';
	return true;									  
}	
function KP_button_printer($url,$titulo){	
    
     $titulo = utf8_encode(utf8_decode($titulo)); 
 	//$evento ="javascript:changeAction('confirmar','".$url."','Desea agregar nuevo registro')";
 	$evento = "javascript:imprimir_comprobante('".$url."')";
	echo '<button class="btn" title="'.$titulo.'"  onclick="'.$evento.'"><i class="icon-print"></i></button>';
	return true;									  
}
}
?>