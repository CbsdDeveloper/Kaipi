<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#form').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {

 
 	              jQuery('#result_pago').html(data);

				  jQuery( "#result_pago" ).fadeOut( 1600 );

			 	  jQuery("#result_pago").fadeIn("slow");

		    
	            	            
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-co_asiento_pagos.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        
               
               // eventos para ejecucion de editar eliminar y agregar 
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
      
         $titulo='';
 
         $datos = array();
         
         $this->set->evento_modal( $this->evento_form,'inicio','form' ); // activa ajax para insertar informacion
    
        
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                   
                
                $this->set->div_label(12,'<h6> Detalle de Pago<h6>');
                
                  
                
                $this->obj->text->text('Nro.Comprobante',"texto",'comprobantePago',15,15,$datos,'','readonly','div-2-4'); 
                
                $this->obj->text->text('<b>Identificacion</b>',"texto",'ruc_pago',15,15,$datos,'','readonly','div-2-4');
                
                   
                $this->obj->text->text('<b>Beneficiario</b>',"texto",'razon',15,15,$datos,'','readonly','div-2-10');
                
                
                $MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
                
                $java =  "busca_cheque($('#tipo_pago').val());return false;";
                
                $evento = ' onChange="'.$java.'" ';
                
                
                $this->obj->list->listae('Forma pago',$MATRIZ,'tipo_pago',$datos,'required','',$evento,'div-2-4');
                
                
                $this->obj->text->text('Cheque/Transaccion',"texto",'cheque',15,15,$datos,'required','','div-2-4');
                
                $this->obj->text->text('US $',"number",'monto_pago',0,30,$datos,'','readonly','div-2-4') ; 
   
                
                $this->obj->text->text('Generado',"texto",'pago',15,15,$datos,'','readonly','div-2-4'); 
                
                
                $this->obj->text->text('Cuenta',"texto",'idbancos',15,15,$datos,'','readonly','div-2-4'); 
               
          
                $this->obj->text->texto_oculto("action_pago",$datos); 
                    
                $this->obj->text->texto_oculto("enlace_pago",$datos); 
                
                $this->obj->text->texto_oculto("id_asiento_aux",$datos); 
                
                
                $this->obj->text->texto_oculto("asiento",$datos); 
               
         
                $this->obj->text->texto_oculto("cuenta_pago",$datos); 
                      
         	  
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'aprobacion_pago()';
   	
   	
   	/*
   	$formulario_impresion = $this->bd->_impresion_carpeta('54');
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
 
   	*/
   	
   	
   	$formulario_impresion = $this->bd->_impresion_carpeta('56');
   	$evento1 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
   	
   	$formulario_impresion = '../reportes/ficherocheque?a=';
   	$evento2 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
   	
   	 
    
    $ToolArray = array( 
    			array( boton => 'Generar Documento', evento =>$evento, grafico => 'glyphicon glyphicon-ok' ,  type=>"submit") ,
    		array( boton => 'Imprimir Comprobante de Pago', evento =>$evento1,  grafico => 'glyphicon glyphicon-tasks' ,  type=>"button_info") ,
    		array( boton => 'Imprimir Cheque', evento =>$evento2,  grafico => 'glyphicon glyphicon-save-file' ,  type=>"button") ,
                   );
                  
    $this->obj->boton->ToolMenuDivId( $ToolArray,'result_pago' ); 
 
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