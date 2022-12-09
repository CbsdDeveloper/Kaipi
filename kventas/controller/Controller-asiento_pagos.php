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
        
                
               $this->formulario = 'Model-co_asiento_pagos.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
      
 
         $titulo = 'Asientos ';
         
         $this->set->evento_modal( $this->evento_form,'inicio','form' ); // activa ajax para insertar informacion
    
        
        $this->set->body_tab($titulo,'inicio');
 
        $datos = array();
    
                $this->BarraHerramientas();
                   
                
                $this->set->div_label(12,'<h6> Detalle de Pago<h6>');
                
                  
                
                $this->obj->text->text('Nro.Comprobante',"texto",'comprobantePago',15,15,$datos,'','readonly','div-2-4'); 
                
                $this->obj->text->text('<b>Identificacion</b>',"texto",'ruc_pago',15,15,$datos,'','readonly','div-2-4');
                
                   
                $this->obj->text->text('<b>Beneficiario</b>',"texto",'razon',15,15,$datos,'','readonly','div-2-10');
                
                
                $MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
                
                $java =  "busca_cheque($('#tipo').val());return false;";
                
                $evento = ' onChange="'.$java.'" ';
                
                
                $this->obj->list->listae('Forma pago',$MATRIZ,'tipo',$datos,'required','',$evento,'div-2-4');
                
                
                $this->obj->text->text('Nro.Cheque',"texto",'cheque',15,15,$datos,'required','','div-2-4');
                
                $this->obj->text->text('US $',"number",'monto_pago',0,30,$datos,'','readonly','div-2-4') ; 
                
         //       $this->obj->text->text('Nro.Retencion',"texto",'retencion',15,15,$datos,'required','','div-2-4'); 
 
                
                $this->obj->text->text('Generado',"texto",'pago',15,15,$datos,'','readonly','div-2-4'); 
                
                
                $this->obj->text->text('Cuenta',"texto",'idbancos',15,15,$datos,'','readonly','div-2-4'); 
               
          
                $this->obj->text->texto_oculto("action_pago",$datos); 
                    
                 
                $this->obj->text->texto_oculto("id_asiento_aux",$datos); 
                
                
                $this->obj->text->texto_oculto("asiento",$datos); 
                
         
                $this->obj->text->texto_oculto("cuenta",$datos); 
                      
         	  
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'aprobacion_pago()';
   	$formulario_impresion = '../reportes/ficherocomprobante?a=';
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	$eventoc = "javascript:_url('../view/co_asientos')";
   	
   	
   	
   	$formulario_impresion = '../reportes/ficheropago?a=';
   	$evento1 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
   	
   	$formulario_impresion = '../reportes/ficherocheque?a=';
   	$evento2 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
   	
   	$formulario_impresion = '../reportes/retencion?a=';
   	$evento3 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   	
    
    $ToolArray = array( 
    			array( boton => 'Generar Documento', evento =>$evento, grafico => 'glyphicon glyphicon-ok' ,  type=>"submit") ,
     	     	array( boton => 'Imprimir Diario Contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") ,
    		array( boton => 'Imprimir Comprobante de Pago', evento =>$evento1,  grafico => 'glyphicon glyphicon-tasks' ,  type=>"button") ,
    		array( boton => 'Imprimir Cheque', evento =>$evento2,  grafico => 'glyphicon glyphicon-save-file' ,  type=>"button") ,
    		array( boton => 'Imprimir Retencion', evento =>$evento3,  grafico => 'glyphicon glyphicon-cloud-download' ,  type=>"button") 
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