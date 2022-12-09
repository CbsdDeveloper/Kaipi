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
        
                
               $this->formulario = 'Model-comprasc_emapa.php'; 
   
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
                   
                    
                
                $this->obj->text->text('Nro.Anexo',"number",'id_compras',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date",'fecharegistro',15,15,$datos,'required','','div-2-4');
                
                
                $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                
                
                $this->obj->text->text('Detalle','texto','detalle',100,100,$datos ,'required','','div-2-10') ;
         
                 
                echo '<h6>&nbsp;</h6>';
                
                $this->set->div_panel('<b> DATOS DEL COMPROBANTE FACTURA </b>');
                
                
                $this->set->nav_tab6("#tab_1_1",'Detalle del Gasto',
                    "#tab_1_2",'Valores Factura',
                    "#tab_1_3",'Montos Retencion',
                    "#tab_1_4",'Comprobante Retencion',
                    '#tab_1_5','Forma Pago',
                    '#tab_1_6','Notas de Credito'
                    );
                
                
                 $this->K_tab_1_1('Detalle del Gasto');
                
                 $this->K_tab_1_2('Valores Factura');
                 
                 $this->K_tab_1_3('Montos Retencion');
                 
                 $this->K_tab_1_4('Comprobante Retencion' );
                
                 $this->K_tab_1_5('Forma Pago' );
                 
                 $this->K_tab_1_6('Notas de credito' );
                
                 $this->set->nav_tab('/');
                 
                 $this->set->div_panel('fin');
                
                 
                 
        
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   function K_tab_1_1($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
       
 
       
 
       
       $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('01','02','03','04','05','08','09','11','15','19','20','21')"
                                );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante','tipocomprobante',$datos,'required','','div-2-10');
       
       
       $resultado = $this->bd->ejecutar("SELECT codigo,   substring(detalle,1,120) as nombre
    									  FROM co_catalogo
    									  where tipo = 'Sustento del Comprobante'"
           );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Sustento tributario','codsustento',$datos,'required','','div-2-10');
       
       $evento =  ' onblur="factura_codigo(this.value)" ';
       
       $this->obj->text->texte('Factura',"texto",'secuencial',9,9,$datos,'required','',$evento,'div-2-4');
       
       
       $this->obj->text->text('Emision',"date",'fechaemision',15,15,$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Nro.Serie',"texto",'serie',6,6,$datos,'required','','div-2-4');
       
       $this->obj->text->text('Autorizacion',"texto",'autorizacion',60,60,$datos,'required','','div-2-4');
       
   
       echo '<h5>&nbsp;</h5>';
       
      
       
       $this->set->nav_tabs_cierre();
   }
   
   //-------------------------------
   
   function K_tab_1_2($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_2",'');
       
        
 
      
       
       $evento =  ' onblur="monto_iva(this.value)" ';
       
     
       $this->obj->text->texte('Base Imponible diferente 0%',"number",'baseimpgrav',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $evento =  ' onblur="base_ir(this.value,1 )" ';
       
       $this->obj->text->texte('Base Imponible 0%',"number",'baseimponible',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $evento =  ' onblur="base_ir(this.value,2 )" ';
       
       $this->obj->text->texte('Base No objeta IVA',"number",'basenograiva',40,45,$datos,'required','',$evento,'div-2-2') ;
       
       $this->obj->text->text('Monto Iva',"number",'montoiva',40,45,$datos,'required','','div-2-2') ;
       
       $this->obj->text->text('Monto ICE',"number",'montoice',40,45,$datos,'required','','div-2-2') ;
       
   
       
       $this->set->nav_tabs_cierre();
   }
   //-----------------------
   function K_tab_1_3($titulo){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
 
       
       // lista de valores
       $MATRIZ = $this->obj->array->iva_compras();
       $evento =  'onChange="monto_riva(this.value)"';
       
     
       
       $this->obj->list->listae('% retencion IVA',$MATRIZ,'porcentaje_iva',$datos,'required','',$evento,'div-2-4');
       
       $this->obj->text->text('Bienes',"number",'valorretbienes',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('Servicios',"number",'valorretservicios',40,45,$datos,'required','','div-2-4') ;
       
       $this->obj->text->text('100% Servicios',"number",'valretserv100',40,45,$datos,'required','','div-2-4') ;
       
       
       
       $this->set->div_label(12,'<h6><b>Retencion Fuente</b> '.$cboton.'</h6>');
       
  
       
       $this->obj->text->texte('Base Imponible (+)',"number",'baseimpair',40,45,$datos,'','',$evento,'div-2-4') ;
       
       
       $resultado = $this->bd->ejecutar("SELECT codigo,
                                                trim(codigo) || ' ' || substring(trim(detalle) from 1 for 40) as nombre
    									  FROM co_catalogo
    									  where tipo = 'Fuente de Impuesto a la Renta' and activo = 'S' order by 1"
           );
       
       $evento =  'onChange="calculoFuente(this.value)"';
       
       $this->obj->list->listadbe($resultado,$tipo,'Retencion ','codretair',$datos,'required','',$evento,'div-2-4');
       
       
       
       
       echo '<div class="col-md-12">
                <br>
                <div id="retencion_fuente"><b>[ Detalle de  retencion en la fuente ]</b></div>
             </div>';
       
       
       
        
       $this->set->nav_tabs_cierre();
   }
   //---------------------------------------------------
   function K_tab_1_4($titulo ){
       
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
 
        
       $this->obj->text->text('Nro.Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-2-4') ;
       
       
       $evento =  '';
       
       $MATRIZ = array(
           '01'    => 'SIN UTILIZACION DEL SISTEMA FINANCIERO',
           '02'    => 'CHEQUE PROPIO',
           '06'    => 'DEBITO DE CUENTA',
           '07'    => 'TRANSFERENCIA PROPIO BANCO',
           '08'    => 'TRANSFERENCIA OTRO BANCO NACIONAL',
           '09'    => 'TRANSFERENCIA  BANCO EXTERIOR',
       );
      
       $this->obj->list->listae('Forma de pago',$MATRIZ,'formadepago',$datos,'required','',$evento,'div-2-4');
       
       
       
       $this->obj->text->text('Fecha Retencion',"date",'fechaemiret1',15,15,$datos,'','','div-2-4');
       
       
       $this->obj->text->text('Estab./Emisión',"texto",'serie1',6,6,$datos,'','','div-2-4');
       
       $this->obj->text->text('Comprobante',"texto",'secretencion1',41,41,$datos,'','','div-2-4');
       
       $this->obj->text->text('Autorizacion',"texto",'autretencion1',60,60,$datos,'','','div-2-4');
       
       echo '<h5> <img src="../../kimages/pregunta.png"/> <a href="#" onClick="VerNovedad()"><b>Novedades</b></a> </h5>';
       
       echo '<div id="data" align="center">&nbsp;</div>';
       
       
       $this->set->nav_tabs_cierre();
   }  
   
   function K_tab_1_5($titulo ){
       
       $this->set->nav_tabs_inicio("tab_1_5",'');
       
 
       
       $evento =  '';
       
       
       $MATRIZ = array(
           '01'    => 'PAGO LOCAL',
           '02'    => 'PAGO AL EXTERIOR'
       );
       $this->obj->list->listae('Pago Local o Exterior ',$MATRIZ,'pagolocext',$datos,'required','',$evento,'div-3-3');
       
       $MATRIZ = array(
           'NA'    => 'NO APLICA',
           '105'    => 'COLOMBIA',
           '118'    => 'PANAMA',
           '120'    => 'PERU',
           '110'    => 'ESTADOS UNIDOS',
           '108'    => 'CHILE',
           '116'    => 'MEXICO',
           '126'    => 'VENEZUELA',
           '106'    => 'COSTA RICA'
       );
       $this->obj->list->listae('País al que efectua el pago',$MATRIZ,'paisefecpago',$datos,'required','',$evento,'div-3-3');
       
       $MATRIZ = array(
           'NA'    => 'NO APLICA',
           'SI'    => 'SI'
       );
       $this->obj->list->listae('Aplica convenio de doble tributacion',$MATRIZ,'faplicconvdobtrib',$datos,'required','',$evento,'div-3-3');
       
       $MATRIZ = array(
           'NA'    => 'NO APLICA',
           'SI'    => 'SI'
       );
       $this->obj->list->listae('Pago sujeto a retención en aplicación de la norma legal?',$MATRIZ,'fpagextsujretnorLeg',$datos,'required','',$evento,'div-3-3');
       
         
        
       $this->set->nav_tabs_cierre();
   }  
   //--------------------------------------------
   function K_tab_1_6($titulo ){
       
       $this->set->nav_tabs_inicio("tab_1_6",'');
       
 
       
       $tipo = $this->bd->retorna_tipo();
       
       $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('01','02')"
           );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante Modificado','docmodificado',$datos,'','','div-3-3');
       
 
       $this->obj->text->texte('Comprobante modificado',"texto",'secmodificado',9,9,$datos,'','',$evento,'div-3-3');
       
       
       $this->obj->text->text('Nro.Serie modificado',"texto",'estabmodificado',6,6,$datos,'','','div-3-3');
 
       
       $this->obj->text->text('Autorizacion',"texto",'autmodificado',47,47,$datos,'','','div-3-3');
       
      
 
       
       $this->set->nav_tabs_cierre();
   }  
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       $eventof = "javascript:ComprobanteElectronico()";
       
       $eventoa = "AnularRetencion()";
   	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Emitir Comprobante electronico', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button"),
               array( boton => 'Anular Comprobante electronico', evento =>$eventof,  grafico => 'glyphicon glyphicon-alert' ,  type=>"button")
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
												$("#idprov").val('...');
											},
											success:  function (response) {
												$("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	       
</script>
  