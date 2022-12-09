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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	  jQuery('#result').html(data.resultado);
            	  
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
  
    require '../../kconfig/Db.class.php';  
 	
    require '../../kconfig/Obj.conf.php';  
    
    require '../../kconfig/Set.php';  
  
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
      private $anio;
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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-ac_bienes_seg.php'; 
   
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
      
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
 
        $datos = array();
    
            
                 
             
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       
       $formulario_impresion = '../reportes/fichaActivo';
       $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
 
    $ToolArray = array( 
                  array( boton => 'Ficha Tecnica', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
 
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>