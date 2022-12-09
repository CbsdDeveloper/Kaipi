 <script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
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
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
       }
     //---------------------------------------
     function Formulario( ){
         
 
  		
        $this->BarraHerramientas();
 
 
		 $this->set->div_label(12,'<h4> Detalle de Tramite</h4>');
		 
	 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
    
     
     $formulario_impresion = '../reportes/fichaActivoCompra';
     $evento = 'javascript:url_ficha('."'".$formulario_impresion."')";
 
 
     $formulario_impresion = '../reportes/fichaActivoCompra';
     $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
     
     $ToolArray = array(
         array( boton => 'Detalle Mensual de compra de bienes', evento =>$evento,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button_success") ,
         array( boton => 'Comprobante De Ingreso de Activos', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
        
         
     );
    
    
    
    
    
    $this->obj->boton->ToolMenuDiv($ToolArray); 
  }  
  //----------------------------------------------
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>  