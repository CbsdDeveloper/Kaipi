<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form, #fat, #fo3').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
			 			
               jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');
               jQuery( "#result" ).fadeOut( 1600 );
               jQuery("#result").fadeIn("slow");
              
             
			}
        })        
        return false;
    }); 
 })
</script>	
<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
  	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
  
      private $obj;
      private $bd;
      private $set;
      
       private $formulario;
       private $evento_form;
          
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){ 
          
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_distributivo_bom.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      
      
     function Formulario( ){
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $datos = array();

        $tipo 		= $this->bd->retorna_tipo();
 
        $sql = "select idprov,completo || '  - ' || cargo as nombre
        from view_nomina_user
        where orden like 'G%' and cargo is not null
        order by 2 asc";

 

    
                $this->BarraHerramientas();
                
                $this->set->div_panel6('<h6> PASO 1.- INFORMACION PRINCIPAL<h6>');
             
                        
                                 $this->obj->text->text('Codigo',"number",'id_asigna_dis',20,15,$datos,'required','readonly','div-2-4') ; 

                                 $this->obj->text->text('Estado',"texto",'estado',20,15,$datos,'required','readonly','div-0-6') ; 


                                 $this->obj->text->text_yellow('Fecha',"date",'fecha_solicitud',20,15,$datos,'required','','div-2-4') ; 

                                 $this->obj->text->text_blue('Documento',"texto",'doccumento',50,50,$datos,'required','','div-0-6') ; 
      
                                 $this->obj->text->editor('Comentario','detalle',5,350,350,$datos,'required','','div-2-10') ;
    
 
                $this->set->div_panel6('fin');

                $this->set->div_panel6('<h6> PASO 2.- ASIGNAR RESPONSABLES<h6>');

                                 $resultado = $this->bd->ejecutar("select '-' as codigo , '  ---  00. Seleccionar Responsable  --- ' as nombre union ".$sql);

                                 $this->obj->list->listadb($resultado,$tipo,'UNIDAD OPERACIONES','operaciones',$datos,'required','','div-3-9');

                                 $resultado1 = $this->bd->ejecutar("select '-' as codigo , '  ---  00. Seleccionar Responsable  --- ' as nombre union ".$sql);

                                 $this->obj->list->listadb($resultado1,$tipo,'SUBJEFE DE BOMBEROS','autoriza',$datos,'required','','div-3-9');

                                 $this->set->div_label(12,'Seleccionar Unidad/Estacion');


                                

                                 echo '<div class="col-md-3" style="padding-top:7px;padding-bottom: 10px"> 
                                        <button type="button" onClick="VerUnidad()" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search"></span> Generar Información para distribución</button>   
                                     </div>';


                $this->set->div_panel6('fin');





                $this->set->div_panel12('<h6> PASO 3.- LISTA DE ESTACIONES ASIGANADAS<h6>');

                        echo '<div id="listafun"> </div>';

                $this->set->div_panel12('fin');

                $this->set->div_panel12('<h6> PASO 4.- LISTA DE PERSONAL X ESTACION<h6>');

                         echo '<div id="listafuncionarios"> </div>';

                $this->set->div_panel12('fin');
 
 
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    
   $formulario_reporte = '../../reportes/distributivo_estacion';
   
   $eventoi = "imprimir_informe('".$formulario_reporte."')";
    
   $evento1 = "Autorizardistribucion()";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Autorizar cambio',  evento =>$evento1,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
                );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    //----------------------------------------------
   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  