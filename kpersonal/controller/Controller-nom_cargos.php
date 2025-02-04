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
			 			
           	 jQuery('#result').html(data);

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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-nom_cargos.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      
      
     function Formulario( ){
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $datos = array();
 
    
                $this->BarraHerramientas();
                
           
                  
                $this->obj->text->text('Codigo',"number",'id_cargo',20,15,$datos,'required','readonly','div-2-10') ; 
                
                $this->obj->text->text_yellow('Nombre',"texto",'nombre',65,65,$datos,'required','','div-2-10') ; 
                
                 
                $this->obj->text->editor('Productos','productos',3,45,350,$datos,'required','','div-2-10') ;
                
                $this->obj->text->editor('Competencias','competencias',3,45,350,$datos,'required','','div-2-10') ;
                
                  
                $MATRIZ = array(
                    'N'    => 'NO',
                    'S'    => 'SI' 
                );
                
                $this->obj->list->lista('Nivel jerarquico',$MATRIZ,'jerarquico',$datos,'required','','div-2-4');
                
     
                $MATRIZ = array(
                    '-'    => 'No Aplica',
                    'C'    => 'Movilidad/Trasporte (Chofer,Operador)',
                    'G'    => 'Bienes/Inventarios',
                    'T'    => 'Tecnico/Mecanica',
                    'A'    => 'Administrativo/Financiero',
                    'B'    => 'Bomberos',
                );

            
                $this->obj->list->lista('Naturaleza',$MATRIZ,'tipo',$datos,'required','','div-2-4');

                $this->obj->text->text_blue('Siglas',"texto",'sigla',65,65,$datos,'required','','div-2-4') ; 


                $this->set->div_label(12,'VARIABLES DIA DESCUENTO PARA VACACIONES'); 


                $this->obj->text->text_blue('Descuento días vacaciones (1 - 1.63)',"number",'dia_vaca',20,15,$datos,'required','','div-8-4') ; 
                $this->obj->text->text_blue('Descuento días permiso (1 - 1.63)',"number",'dia_permiso',20,15,$datos,'required','','div-8-4') ; 

                

                $this->set->div_label(12,'VARIABLES PERMISOS Y VACACIONES'); 

             
                      $this->obj->text->text_blue('Max.Permiso Dia (1-15)',"entero",'dia_max',20,15,$datos,'required','','div-2-4') ; 
                      $this->obj->text->text_blue('Max.Permiso Hora (1-8)',"entero",'hora_max',20,15,$datos,'required','','div-2-4') ; 
                      

                      $this->obj->text->text_yellow('Dias Vacaciones (15-30)',"entero",'dias_vacacion',20,15,$datos,'required','','div-2-4') ; 

                      $this->obj->text->text_blue('Dias Acumula (60)',"entero",'dias_acumula',20,15,$datos,'required','','div-2-4') ; 


                       
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
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
 
  