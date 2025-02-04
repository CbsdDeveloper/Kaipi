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
      private $anio;
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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
               $this->formulario = 'Model-co_asientos.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        
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
         
          $this->set->_formulario( $this->evento_form,'inicio' );  
   
     
                $this->BarraHerramientas();
                
                
 
                
                $this->obj->text->texto_oculto("id_periodo",$datos); 
                
                 
                $this->obj->text->text_blue('Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-1-3') ;
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-1-3');
                
                
                $this->obj->text->text_blue('Orden',"date",'forden',15,15,$datos,'required','','div-1-3');
 
                
                
                $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'required','readonly','div-1-3');
                
                $this->obj->text->text_yellow('Referencia',"texto",'documento',15,15,$datos,'required','','div-1-3');
                
                $this->obj->text->text_yellow('Estado',"texto",'estado',15,15,$datos,'','readonly','div-1-3');
                
                $MATRIZ =  $this->obj->array->catalogo_con_tipoa();
                $evento =  '';
                $this->obj->list->listae('Tipo',$MATRIZ,'tipo',$datos,'required','',$evento,'div-1-7');
                
                
                $this->obj->text->text('Tramite',"texto",'id_tramite',15,15,$datos,'','readonly','div-1-3');
                
                $this->obj->text->editor('Detalle','detalle',3,45,300,$datos,'required','','div-1-11') ;
                 
 
                $this->obj->text->textautocomplete('Beneficiarios',"texto",'razon',40,45,$datos,'required','readonly','div-1-7');
                
                
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-1-3') ;
 
                
                $this->obj->text->text_blue('A Pagar',"number",'apagar',0,10,$datos,'','','div-1-3') ;
 
 
                $this->obj->text->texto_oculto("modulo",$datos); 
                
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         $this->obj->text->texto_oculto("nomina",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 	
    	
   	
   	$formulario_impresion = $this->bd->_impresion_carpeta('55');

   	$eventopp = 'impresion_pago()';
   	
    	$eventope = 'AbrirCiu()';
   	
    $ToolArray = array( 
                 array( boton => 'Orden de Gasto y Pago', evento =>$eventopp,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info") ,
                 array( boton => 'Proveedor', evento =>$eventope,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") 
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
 