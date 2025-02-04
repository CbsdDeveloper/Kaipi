<script>
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
  
class Controller_liquidaciones{
 
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
      function Controller_liquidaciones( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                 
               $this->formulario = 'Model_liquidaciones.php'; 
   
               $this->evento_form = '../model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
     function Formulario( ){
      
          
        $titulo = 'Liquidaciones de Compra';
        
        $datos = array();
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                   
             
                $this->set->div_panel('<b> DETALLE DEL GASTO (COMPRA) </b>');
                  
                
                $this->obj->text->text('Nro.Liquidacion',"number",'id_liquida',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date",'fecharegistro',15,15,$datos,'required','','div-2-4');
                
                
                $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text_yellow('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
         
                
                
                $this->obj->text->editor('Detalle','detalle',2,120,120,$datos,'required','','div-2-10') ;
                
                 
                $this->set->div_panel('fin');	
                
            
             
                
                $this->set->div_panel('<b> DATOS DE LA LIQUIDACION DE COMPRAS </b>');
                
                
                $this->set->nav_tab6("#tab_1_1",'1. Detalle del Gasto',
                    "#tab_1_2",'2. Detalle Bienes/Servicios',
                    "#tab_1_3",'3. Forma Pago/Emision',
                    '',
                    '',
                    ''
                    );
                
                
                 $this->K_tab_1_1('1. Detalle del Gasto');
                
                 $this->K_tab_1_2('2. Detalle Bienes/Servicios');
                 
                 $this->K_tab_1_3('3. Forma Pago/Emision');
                 
                 
                  
                
                
                 $this->set->nav_tab('/');
                 
                 $this->set->div_panel('fin');
                
                 
                
        
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   function K_tab_1_1($titulo){
       
       
        
       $this->set->nav_tabs_inicio("tab_1_1",'active');
       
 
       $datos = array();
 
     
       
       $evento = '';
       
       $this->obj->text->texte('Secuencia',"texto",'secuencial',9,9,$datos,'','',$evento,'div-2-4');
       
       
       $this->obj->text->text('Emision',"date",'fechaemision',15,15,$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Nro.Serie',"texto",'serie',6,6,$datos,'required','','div-2-4');
       
        
       $this->set->div_label(12,'MONTOS LIQUIDACION');	
       
       $evento =  ' onblur="monto_iva(this.value)" ';
       
       
       $this->obj->text->texte('Base Imponible diferente 0%',"number",'baseimpgrav',40,45,$datos,'required','readonly',$evento,'div-9-3') ;
       
       $evento =  ' onblur="base_ir(this.value,1 )" ';
       
       $this->obj->text->text('Monto Iva',"number",'montoiva',40,45,$datos,'required','readonly','div-9-3') ;
       
       $this->obj->text->texte('Base Imponible 0%',"number",'baseimponible',40,45,$datos,'required','readonly',$evento,'div-9-3') ;
       
        
       
      
       
       $this->set->nav_tabs_cierre();
   }
   
   //-------------------------------
   
   function K_tab_1_2($titulo){
       
       
 
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
       $evento = '';
        
       $datos = array();
         
       $this->obj->text->text_yellow('Cantidad',"number",'cantidad',40,45,$datos,'required','','div-2-4') ;
        
       $this->obj->text->text_blue('Monto Servicios($)',"number",'servicios',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Bien o Servicio',"texto",'detalle_d',100,100,$datos,'','','div-2-4');
       
       
       
       $MATRIZ = array(
           '-'    => '-- SELECCIONE TIPO TRIBUTACION',
           'S'    => 'CON IVA',
           'N'    => 'SIN IVA',
       );
       
       $evento =  ' onChange="Agrega_detalle(this.value )" ';
       
       $this->obj->list->listae('Tributa',$MATRIZ,'iva_si',$datos,'required','',$evento,'div-2-4');
       
       echo '<div class="col-md-12" style="padding: 10px">
                 <div class="alert alert-success">
                      <strong>NOTA!</strong> SI DESEEA GENERAR OTRO DETALLE SELECCIONE EL TIPO DE TRIBUTACION Y GUARDE LA INFORMACION.
                    </div>
             </div>';
       
       echo '<div class="col-md-12" style="padding: 10px">
                 <div id="retencion_fuente"><b>[ Detalle de servicios/bienes ]</b></div>
             </div>';
       
       
     
       
        
        
   
       
       $this->set->nav_tabs_cierre();
   }
   //-----------------------
   function K_tab_1_3($titulo){
       
       
       $datos = array();
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
 
       
          
       $evento =  '';
       
       $MATRIZ = array(
           '01'    => 'SIN UTILIZACION DEL SISTEMA FINANCIERO',
           '20'    => 'OTROS CON UTILIZACION DEL SISTEMA FINANCIERO',
           '02'    => 'CHEQUE PROPIO',
           '06'    => 'DEBITO DE CUENTA',
           '07'    => 'TRANSFERENCIA PROPIO BANCO',
           '08'    => 'TRANSFERENCIA OTRO BANCO NACIONAL',
           '09'    => 'TRANSFERENCIA  BANCO EXTERIOR',
       );
       
       $this->obj->list->listae('Forma de pago',$MATRIZ,'formadepago',$datos,'required','',$evento,'div-2-4');
       
      
       $this->obj->text->text('Autorizado',"texto",'transaccion',60,60,$datos,'','readonly','div-2-4');
       
       
       $this->obj->text->text('Autorizacion',"texto",'autorizacion',60,60,$datos,'','readonly','div-2-10');
       
   
       echo '<div class="col-md-12" style="padding: 10px">
                 <div id="data"><b>[ EMITIR COMPROBANTE ELECTRONICO ]</b></div>
             </div>';
       
       
       
        
       $this->set->nav_tabs_cierre();
   }
   //---------------------------------------------------
    
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       $eventof = "Anular_comprobante(1)";
       
       $eventoe = "goToURLElectronico(1)";

       $eventopp = "ImprimirRetencion(1)";

       $eventoff = "generar_comprobante(1)";
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Emitir Comprobante Electronico', evento =>$eventoe,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success"),
                array( boton => 'Generar Comprobante ELectronico', evento =>$eventopp,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_info")  ,
                array( boton => 'Anular transaccion', evento =>$eventof,  grafico => 'glyphicon glyphicon-trash' ,  type=>"button_danger"),
                array( boton => 'Generar nueva clave', evento =>$eventoff,  grafico => 'glyphicon glyphicon-remove-circle' ,  type=>"button_default"),
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
  
  $gestion   = 	new Controller_liquidaciones;
   
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
												$("#idprov").val('...');
											},
											success:  function (response) {
												$("#idprov").val(response);
													  
											} 
									});
	 
    });
	       
</script>