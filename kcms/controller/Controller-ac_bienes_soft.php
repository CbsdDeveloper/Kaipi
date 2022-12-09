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

 			 	  jQuery("#action").val(data.accion); 
 			 	  
 

            
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
      
 
  
               $datos = array();
    
                $this->BarraHerramientas();
           
                $this->set->div_panel('<b> DETALLE DE EQUIPOS INFORMATICOS - CONTROL DE SOFTWARE </b>');
                
               
                
     
      				
		                   
         $this->obj->text->texto_oculto("id_software_dato",$datos); 
         
 
          
         
 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
       $formulario_impresion = '../view/proveedor';
       $eventop = 'javascript:modalVentana('."'".$formulario_impresion."')";
       
      
       
       $formulario_impresion = '../reportes/fichaActivo';
       $eventoi = 'javascript:url_ficha('."'".$formulario_impresion."')";
 
       $ToolArray = array( 
               array( boton => 'Proveedor', evento =>$eventop,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                array( boton => 'Ficha Tecnica', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") 
                 );
                  
   $this->obj->boton->ToolMenuDiv($ToolArray); 
 
  }  
//----------------------------------------------
   function header_titulo($titulo){
 
         $this->set->header_titulo($titulo);
 
  }  
 //--------------------
  
 
}
  
 $gestion   = 	new componente;
  
 $gestion->Formulario( );
  
?>
 