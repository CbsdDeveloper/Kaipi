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
        
                $this->evento_form = '../model/Model-co_caja_cxp.php';        // eventos para ejecucion de editar eliminar y agregar
                
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
         
         $tipo = $this->bd->retorna_tipo();
         
         
         $this->BarraHerramientas();
         
         $this->set->div_panel('<b> FACTURAS POR PAGAR CAJA </b>');
         
                 echo '<div style="padding:10px" id="DetallePago"> </div>';
         
                 echo ' <div align="right" id="mensajeEstado"></div>  ';
                 
         $this->set->div_panel('fin');	
         
         
          
         
         $this->set->div_panel9('<h5><b>FORMA Y DETALLE DE PAGO</b></h5>');
         
          
         
         $this->obj->list->listadb($resultado,$tipo,'Responsable','idprov',$datos,'required','','div-2-10');  
         
          
         $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
         
         
         $this->obj->text->text('Nro.Cheque',"texto",'cheque',15,15,$datos,'required','','div-2-4');
         
 
         $this->obj->text->text('Comprobante',"texto",'documento',15,15,$datos,'required','','div-2-4');
         
         $this->set->div_label(12,'Informacion Adicional');	 
         
         
         $this->obj->text->editor('<b>Detalle</b>','detalle',2,45,300,$datos,'required','','div-2-10') ;
         
         
           
         $this->set->div_panel9('fin');	
         
   
       
         
         
         $this->obj->text->texto_oculto("idbancos",$datos);
            
         $this->obj->text->texto_oculto("action",$datos);
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:CrearPeriodo();';
   
     
   
    $ToolArray = array( 
        array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-ok' ,  type=>"submit")
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
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 
  