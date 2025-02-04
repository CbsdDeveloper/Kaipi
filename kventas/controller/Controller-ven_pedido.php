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
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_pedido.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function fecha( ){
          $todayh =  getdate();
          $d = $todayh[mday];
          $m = $todayh[mon];
          $y = $todayh[year];
          return '<h6>'.$d.'/'.$m.'/'.$y.'</h6>';
      }
      //---------------------------------------
      
     function Formulario( ){
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
 
            
                
                $this->obj->text->text('<b>TRAMITE</b>',"texto",'idvengestion',80,95,$datos,'','readonly','div-2-10') ;
                
                 
                $this->obj->text->text('<b>NOMBRE</b>',"texto",'razon_nombre',80,95,$datos,'','readonly','div-2-10') ;
                  
                $MATRIZ = array(
                    '6'  => 'En Proceso de Negociacion',
                    '7'  => 'Condiciones Comerciales',
                    '8'  => '(*) Orden de trabajo/Servicio',
                    '10'  => 'Cierre de negocio',
                     '9'  => 'Anulada transaccion'
                 );
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'','',$evento,'div-2-4');
                
 
                $MATRIZ = array(
                    'llamar'  => 'llamar',
                    'reunion'  => 'reunion',
                    'email'  => 'email',
                     'whastapp'  => 'whastapp',
                     'no aplica'  => 'no aplica',
                );
                
                $this->obj->list->listae('<b>Evento</b>',$MATRIZ,'canal',$datos,'','',$evento,'div-2-4');
                
                
                $this->obj->text->editor('Novedad','novedad',3,45,300,$datos,'required','','div-2-10') ;
                
                 
                $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
                
                
                $this->obj->text->text('Hora','time','hora',10,10,$datos ,'','','div-2-4') ;
                
   
      	 $this->obj->text->texto_oculto("action",$datos); 
      	 
      
         
         $this->obj->text->texto_oculto("idprov_tarea",$datos);
         
    
            
           
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
    $ToolArray = array( 
                array( boton => 'Enviar informacion', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
   //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
    
  
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
    
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 