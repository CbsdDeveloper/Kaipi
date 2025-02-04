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
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
        
      }
   
     function Formulario( ){
      
 
            $datos = array();
            
            $evento = ' ';
            
     		$this->set->div_label(12,'<h6> PERIODO PRESUPUESTARIO<h6>');
     	 	
           
     		$this->obj->text->text('Periodo',"number" ,'idperiodo' ,80,80, $datos ,'','readonly','div-2-10') ;
     		
     	 
     		//---------- catalogo de a�os matriz
     		$MATRIZ = $this->obj->array->catalogo_anio();
     		
     		$this->obj->list->listae('Anio ',$MATRIZ,'anio',$datos,'required','',$evento,'div-2-4');
     		
     		$MATRIZ = array(
     		    'proforma'    => 'proforma',
     		    'ejecucion'    => 'ejecucion',
     		    'cierre' => 'cierre'
     		);
     		$this->obj->list->listae('Estado ',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
     		
     		$this->obj->text->text('Detalle',"texto" ,'detalle' ,80,80, $datos ,'','readonly','div-2-10') ;
     		
     	  
     		$this->obj->text->text('Modificado',"texto" ,'sesionm' ,80,80, $datos ,'','readonly','div-2-4') ;
     		$this->obj->text->text('Fecha',"date" ,'modificacion' ,80,80, $datos ,'','readonly','div-2-4') ;
     	         
                
	         $this->obj->text->texto_oculto("action2",$datos); 
	         
	          
 
      
   }
 
   //----------------------------------------------
  //----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
///------------------------------------------------------------------------
}
///------------------------------------------------------------------------
  $gestion   = 	new componente;
 
  $gestion->Formulario( );
  
 ?>
 
  