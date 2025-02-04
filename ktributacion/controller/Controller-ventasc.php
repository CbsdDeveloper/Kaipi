<script >

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
        
                
               $this->formulario = 'Model-ventasc.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
      
        $tipo = $this->bd->retorna_tipo();
         
        $titulo ='';
        
        $datos = array();
        
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                   
          
                $this->set->div_panel('<b> DATOS VENTAS MENSUAL </b>');
                      
                
                $this->obj->text->text('Nro.Anexo','number','id_ventas',10,10, $datos ,'','readonly','div-2-4') ;
                $this->obj->text->text('Referencia','number','id_asiento',10,10, $datos ,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha','date','fechaemision',10,10, $datos ,'required','','div-2-4') ;
                
                $MATRIZ = array(
                    'F'    => 'Factura',
                    'E'    => 'Electronico'
                );
                
                
                $evento = '';
                
                $this->obj->list->listae('Comprobante',$MATRIZ,'tipoemision',$datos,'required','',$evento,'div-2-4');
                
        
                    
                $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-4');
                $this->obj->text->text('Identificacion','texto','idcliente',10,10,$datos ,'','readonly','div-2-4') ;
                

                $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('18','04','05')"
                    );
                
                
                $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante','tipocomprobante',$datos,'required','','div-2-4');
              
                $this->obj->text->text('NumeroComprobantes','number','numerocomprobantes',10,10, $datos ,'required','','div-2-4') ;
                
                
                $evento =  ' onblur="factura_codigo(this.value)" ';
                
                $this->obj->text->texte('Secuencial',"texto",'secuencial',9,9,$datos,'required','',$evento,'div-2-4');
                
                $this->obj->text->text('Establecimiento','texto','codestab',3,3, $datos ,'required','','div-2-4') ;
                
                $this->set->div_panel('fin');
                
                
                $this->set->div_panel('<b> MONTOS BASES IMPONIBLES E IVA  </b>');
                 
                
                $evento =  ' onblur="monto_iva(this.value)" ';
                
                
                $this->obj->text->texte('Base Imponible diferente 0%',"number",'baseimpgrav',40,45,$datos,'required','',$evento,'div-2-2') ;
                
                $evento =  ' onblur="base_ir(this.value,1 )" ';
                
                $this->obj->text->texte('Base Imponible 0%',"number",'baseimponible',40,45,$datos,'required','',$evento,'div-2-2') ;
                
                $evento =  ' onblur="base_ir(this.value,2 )" ';
                
                $this->obj->text->texte('Base No objeta IVA',"number",'basenograiva',40,45,$datos,'required','',$evento,'div-2-2') ;
                
                $this->obj->text->text('Monto Iva',"number",'montoiva',40,45,$datos,'required','','div-2-2') ;
                
                $this->obj->text->text('Monto ICE',"number",'montoice',40,45,$datos,'required','','div-2-2') ;
                
                
                
                $this->set->div_panel('fin');
 
                $this->set->div_panel('<b> RETENCION FACTURA</b>');
                
                $this->obj->text->text('Bienes','number','valorretbienes',10,10, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Servicios','number','valorretservicios',10,10, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Renta','number','valorretrenta',10,10, $datos ,'required','','div-2-4') ;
                 // $this->obj->text->text('Valorretiva','number','valorretiva',10,10, $datos ,'required','','div-2-4') ;
               
                $this->set->div_panel('fin');
       
                
                $this->set->div_panel('<b> FORMA DE PAGO </b>');
               
                   
                $MATRIZ = array(
                    '01'    => 'SIN UTILIZACION DEL SISTEMA FINANCIERO',
                    '19'    => 'TARJETA DE CREDITO',
                    '20'    => 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO',
                    '17'    => 'DINERO ELECTRONICO' 
                );
                
                $this->obj->list->listae('Forma de pago',$MATRIZ,'formapago',$datos,'required','',$evento,'div-2-4');
             
                
   
                 
             
                
          
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   
   
   //-------------------------------
   
     //----------------------------------------------
   function BarraHerramientas(){
 
       $eventof = "javascript:goToURLAsiento(1)";
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
        array( boton => 'Emitir Asiento contable', evento =>$eventof,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button")
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
 <script type="text/javascript">

 jQuery.noConflict(); 
 
  
//--------------------------
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        	//	console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon").focusout(function(){
	 
	 var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idcliente").val('...');
											},
											success:  function (response) {
												$("#idcliente").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	       
</script>
  