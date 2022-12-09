<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery(' #fo2' ).submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
 				    jQuery('#guardarDocumento').html(data);
            
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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
   
     function Formulario( ){
      
 
     	
     		$this->set->div_label(12,'<h6> Documentos del proceso<h6>');
     	 	
           
                
                 $this->obj->text->text('Documento',"texto",'documento',70,70,$datos,'required','','div-3-9') ;
                
                 $evento = ' ';
                 
                 $MATRIZ = array(
                 		'Oficio'    => 'Oficio',
                		'Memo'    => 'Memo',
                 		'Informe' => 'Informe'
                );
                
                $this->obj->list->listae('Tipo ',$MATRIZ,'tipo',$datos,'required','',$evento,'div-3-9');
       
               
 
                $MATRIZ = array(
                		'S'    => 'SI',
                		'N'    => 'NO',
                );
                $this->obj->list->listae('Activo',$MATRIZ,'estado',$datos,'required','',$evento,'div-3-9');
               
                 
                
	         $this->obj->text->texto_oculto("action2",$datos); 
	                
	         $this->obj->text->texto_oculto("idproceso2",$datos); 
	         
	         $this->obj->text->texto_oculto("idproceso_docu",$datos); 
 
	  //       $this->obj->text->text('Secuencia',"number",'idproceso_docu',40,45,$datos,'','readonly','div-3-9') ;
 
  
      
   }
 
   //----------------------------------------------
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
 
  