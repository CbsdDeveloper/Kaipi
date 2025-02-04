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
        
                
               $this->formulario = 'Model-co_xcobrar.php'; 
   
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
         
         
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 
    
                $this->BarraHerramientas();
                
                 
                $resultado = $this->bd->ejecutar("select id_periodo as codigo, (mesc || '-' || anio)  as nombre
                    							       from co_periodo
                    							      where estado = 'abierto' and
                                                            registro=".$this->bd->sqlvalue_inyeccion($this->ruc, true).'
                                                    order by 1 desc');
               
                
                $this->obj->list->listadb($resultado,$tipo,'Periodo','id_periodo',$datos,'required','','div-2-4');
                
                $this->obj->text->text('Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'required','readonly','div-2-4');
                  
         
                
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
          
                $this->obj->text->textautocomplete('Cliente',"texto",'razon',40,45,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                
                
                $this->obj->text->textautocomplete('Cuenta Ingreso',"texto",'txtcuenta',15,15,$datos,'','','div-2-4');
               
                
                $this->obj->text->text('Cuenta',"texto",'cuenta',15,15,$datos,'','readonly','div-2-4');
             		
                
                 
                $this->set->nav_tab("#tab_1_1",'Detalle del Ingreso',
                    "#tab_1_2",'Valores Factura',
                    "#tab_1_3",'Asiento Cuenta por cobrar',
                    "#tab_1_4",'Montos Retencion'
                      );
                
                
                 $this->K_tab_1_1('Detalle del Ingreso');
                  
                 $this->K_tab_1_2('Valores Factura');
                 
                 $this->K_tab_1_3('Asiento Cuenta por cobrar' );
                  
                 $this->K_tab_1_4('Montos Retencion');
                
               
                
                 $this->set->nav_tab('/');
                
                 
 
                 
          
       
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   function K_tab_1_1($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
       
       $this->set->div_label(12,'<h6><b>Detalle Factura</b> '.$cboton.'</h6>');
       
       echo '<h5>&nbsp;</h5>';
       
       $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-2-10');
       
       $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('18')"
                                );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante','tipocomprobante',$datos,'required','','div-2-10');
       
       
       $evento =  ' onblur="factura_codigo(this.value)" ';
       
       $this->obj->text->texte('Factura',"texto",'secuencial',9,9,$datos,'required','',$evento,'div-2-4');
       
       
       $this->obj->text->text('Emision',"date",'fechaemision',15,15,$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Establecimiento',"texto",'codestab',3,3,$datos,'required','','div-2-4');
       
        
   
       echo '<h5>&nbsp;</h5>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   
   //-------------------------------
   
   function K_tab_1_2($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
       $this->set->frame_inicio();
       
       $this->set->div_label(12,'<h6><b>Montos Factura</b> '.$cboton.'</h6>');
       
       echo '<h5>&nbsp;</h5>';
       
       $evento =  ' onblur="monto_iva(this.value)" ';
       
     
       $this->obj->text->texte('Base Imponible diferente 0%',"number",'baseimpgrav',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $evento =  ' onblur="base_ir(this.value,1 )" ';
       
       $this->obj->text->texte('Base Imponible 0%',"number",'baseimponible',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $evento =  ' onblur="base_ir(this.value,2 )" ';
       
       $this->obj->text->texte('Base No objeta IVA',"number",'basenograiva',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $this->obj->text->text('Monto Iva',"number",'montoiva',40,45,$datos,'required','','div-2-2') ;
       
       $this->obj->text->text('Monto ICE',"number",'montoice',40,45,$datos,'','','div-2-2') ;
       
      
       
 
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //-----------------------
   function K_tab_1_3($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
       $this->set->frame_inicio();
 
       
  
       
       $this->set->div_label(12,'<h6><b>Retencion IVA</b> '.$cboton.'</h6>');
       
       // lista de valores
       $MATRIZ = $this->obj->array->iva_compras();
       $evento =  'onChange="monto_riva(this.value)"';
       
       echo '<div class="col-md-6">';
       
       $this->obj->list->listae('% retencion IVA',$MATRIZ,'porcentaje_iva',$datos,'required','',$evento,'div-2-10');
       
       $this->obj->text->text('Bienes',"number",'valorretbienes',40,45,$datos,'','','div-2-10') ;
       
       $this->obj->text->text('Servicios',"number",'valorretservicios',40,45,$datos,'','','div-2-10') ;
       
       echo '</div><div class="col-md-6">&nbsp;</div>';
       
       $this->set->div_label(12,'<h6><b>Retencion Fuente</b> '.$cboton.'</h6>');
       
       
 
       $this->obj->text->texte('Base Imponible (+)',"number",'baseimpair',40,45,$datos,'','',$evento,'div-2-4') ;
       
       
       $resultado = $this->bd->ejecutar("SELECT codigo,
                                                trim(codigo) || ' ' || substring(trim(detalle) from 1 for 40) as nombre
    									  FROM co_catalogo
    									  where tipo = 'Fuente de Impuesto a la Renta' and activo = 'S' order by 1"
           );
       
       $evento =  'onChange="calculoFuente(this.value)"';
       
       $this->obj->list->listadbe($resultado,$tipo,'Retencion '.$cboton,'codretair',$datos,'required','',$evento,'div-2-4');
       
       $this->obj->text->text('Valor Retenido',"texto",'valorretrenta',40,45,$datos,'required','','div-2-4') ;
       
       $this->set->div_label(12,' GENERAR PROCESOS DE RETENCION ');
       
       echo '<div class="col-md-6">';
       
       echo '  <button type="button" onclick="aprobacion_retencion();" class="btn btn-default">Generar proceso de valores retencion</button>';
       
       echo '</div>';
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }
   //---------------------------------------------------
   function K_tab_1_4($titulo ){
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
       
       $this->set->frame_inicio();
       
       
       $this->obj->text->text(' ',"number",'id_ventas',0,10,$datos,'','readonly','div-0-12') ;
       
      
       
       $variable = 'action=add&ref='.$id_asiento;
       
       $cadena = 'javascript:open_spop_parametro('."'".'co_asientosd_cxp'."','".$variable."'".",780,470,"."'id_asiento'".')';
       
       $cboton = '  <a href="'.$cadena.'"><img src="../../kimages/3p.png"/></a> Agregar cuenta';
       
       
       $this->set->div_labelmin(12,$cboton0.' '. $cboton.'</h5>');
       
      
       
       echo '<h5>&nbsp;</h5>
                 <div class="col-md-12">
                  
                         <div id="DivAsientosTareas"></div>

                         <div id="montoDetalleAsiento"></div>
                   
             </div>';
       
       
      
       
       $this->set->frame_fin();
       
       $this->set->nav_tabs_cierre();
   }  
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion('."'".$this->formulario.'?action=aprobacion'."'".')';
   	
   	$formulario_impresion = '../reportes/ficherocomprobante?a=';
   	
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   
   	
   	$eventoc = "javascript:_url('../view/co_pagos')";
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Aprobar asientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
    	     	array( boton => 'Reporte diario contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default")  
    		
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
 
 jQuery('#txtcuenta').typeahead({
	    source:  function (query, process) {
        return $.get('../model/ajax_CtaContableCxC.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 $("#txtcuenta").focusout(function(){
	 
	 var itemVariable = jQuery("#txtcuenta").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/ajax_Cuenta.php',
											type:  'GET' ,
											beforeSend: function () {
													$("#cuenta").val('...');
											},
											success:  function (response) {
													 $("#cuenta").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
 
//--------------------------
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
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
												$("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	       
</script>
  