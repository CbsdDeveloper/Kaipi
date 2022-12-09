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

                jQuery('#result').html('<div class="alert alert-info">'+ data + '</div>');

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
        
                
               $this->formulario = 'Model-comprasc.php'; 
   
               $this->evento_form = '../../ktributacion/model/'.$this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
      }
       //-----------------------------------------------------------------------------------------------------------
     function Formulario(  $codigo ){
      
        $datos = array();
         
        $titulo = 'Compra';
         
        $this->set->_formulario( $this->evento_form,'inicio' );  
   
        $datos = $this->bd->query_array('view_anexos_compras',   // TABLA
        '*',                        // CAMPOS
        'id_tramite='.$this->bd->sqlvalue_inyeccion($codigo,true)
        );

        if (   $datos['id_tramite'] > 0  ) {

             $datos['action'] = 'editar';

 
        }    
         

 
        $xx = $this->bd->query_array('presupuesto.view_pre_tramite',   // TABLA
        '*',                        // CAMPOS
        'id_tramite='.$this->bd->sqlvalue_inyeccion($codigo,true) // CONDICION
        );
      
        $datos['id_tramite'] = $xx['id_tramite'];
        $datos['detalle'] = $xx['detalle'];
        $datos['idprov'] = $xx['idprov'];
        $datos['razon']  = $xx['proveedor'];

                $this->BarraHerramientas();
                   
      
                
                $this->obj->text->text('Nro.Anexo',"number",'id_compras',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date",'fecharegistro',15,15,$datos,'required','','div-2-4');
                
           
                $this->obj->text->editor('Detalle','detalle',2,45,300,$datos,'required','','div-2-10') ;
                
                 
                $this->obj->text->textautocomplete('Proveedor',"texto",'razon',40,45,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
                 
                 
                $this->obj->text->text_yellow('Nro.Tramite',"number",'id_tramite',0,10,$datos,'required','','div-2-4') ;
                
                  
                 
                $this->set->div_label(12,'Ingrese informacion para la declaracion de impuestos');	 
                
                
                
                $this->set->div_panel('<b> DATOS DEL COMPROBANTE FACTURA </b>');
                
                
                $this->set->nav_tab6("#tab_1_1",'Detalle del Gasto',
                    "#tab_1_2",'Valores Factura',
                    "#tab_1_3",'Montos Retencion',
                    "#tab_1_4",'Comprobante Retencion',
                    '#tab_1_5','Forma Pago',
                    '#tab_1_6','Notas de Credito'
                    );
                
                
                 $this->K_tab_1_1('Detalle del Gasto',$datos);
                
                 $this->K_tab_1_2('Valores Factura',$datos);
                 
                 $this->K_tab_1_3('Montos Retencion',$datos);
                 
                 $this->K_tab_1_4('Comprobante Retencion',$datos);
                
                 $this->K_tab_1_5('Forma Pago' ,$datos);
                 
                 $this->K_tab_1_6('Notas de credito' ,$datos);
                
                 $this->set->nav_tab('/');
                 
                 $this->set->div_panel('fin');
                
                 
                
                 
                 $this->obj->text->texto_oculto("unidad",$datos);         
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 //-------------
   function K_tab_1_1($titulo,$datos){
       
       
       $tipo = $this->bd->retorna_tipo();
       
       $this->set->nav_tabs_inicio("tab_1_1",'active');
       
 
  
       
       $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('01','02','03','04','05','08','09','11','15','19','20','21')"
                                );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante','tipocomprobante',$datos,'required','','div-2-10');
       
       
       $resultado = $this->bd->ejecutar("SELECT codigo,   substring(detalle,1,180) as nombre
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
   
   function K_tab_1_2($titulo,$datos){
       
       
        
       
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
   function K_tab_1_3($titulo,$datos){
       
       
       $tipo = $this->bd->retorna_tipo();
       
        
       $cboton='';
       
       $this->set->nav_tabs_inicio("tab_1_3",'');
 
       
       // lista de valores
       $MATRIZ = $this->obj->array->iva_comprass();
       $evento =  'onChange="monto_riva(this.value)"';
       
     
       $this->obj->text->text('IVA(*)',"number",'bservicios',40,45,$datos,'required','','div-1-3') ;
       $this->obj->list->listae('% IVA',$MATRIZ,'porcentaje_iva',$datos,'required','',$evento,'div-1-3');
       $this->obj->text->text('Servicios',"number",'valorretservicios',40,45,$datos,'required','','div-1-3') ;
     
       
       
       $MATRIZ = $this->obj->array->iva_compras();
       $evento =  'onChange="monto_rivab(this.value)"';
       
       $this->obj->text->text('IVA',"number",'bbienes',40,45,$datos,'required','','div-1-3') ;
       $this->obj->list->listae('% IVA',$MATRIZ,'porcentaje_iva2',$datos,'required','',$evento,'div-1-3');
       $this->obj->text->text('Bienes',"number",'valorretbienes',40,45,$datos,'required','','div-1-3') ;
      
       
       $this->obj->text->text('100% Servicio(*)',"number",'valretserv100',40,45,$datos,'required','','div-5-3') ;
       
       
       
       $this->set->div_label(12,'<h6><b>Retencion Fuente</b> '.$cboton.'</h6>');
       
  
       
       $this->obj->text->texte('Base Imponible (+)',"number",'baseimpair',40,45,$datos,'','',$evento,'div-2-4') ;
       
       
       $resultado = $this->bd->ejecutar("SELECT codigo,
                                                trim(codigo) || ' ' || substring(trim(detalle) from 1 for 100) as nombre
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
   function K_tab_1_4 ($titulo,$datos){
       
       $this->set->nav_tabs_inicio("tab_1_4",'');
       
         
       $this->obj->text->text('Nro.Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-2-4') ;
       
       
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
       
       
       
       $this->obj->text->text('Fecha Retencion',"date",'fechaemiret1',15,15,$datos,'required','','div-2-4');
       
       
       $this->obj->text->text('Estab./Emisión',"texto",'serie1',6,6,$datos,'required','','div-2-4');
       
       $this->obj->text->text('Comprobante',"texto",'secretencion1',41,41,$datos,'','','div-2-4');
       
       $this->obj->text->text('Autorizacion',"texto",'autretencion1',60,60,$datos,'','','div-2-4');
       
 
       echo '<div id="data" ></div>';
       
       $this->set->nav_tabs_cierre();
   }  
   
   function K_tab_1_5 ($titulo,$datos){

       $this->set->nav_tabs_inicio("tab_1_5",'');
       
 
       
       $evento =  '';
       
       
       $MATRIZ = array(
           '01'    => 'PAGO LOCAL',
           '02'    => 'PAGO AL EXTERIOR'
       );
       $this->obj->list->listae('Pago Local o Exterior ',$MATRIZ,'pagolocext',$datos,'required','',$evento,'div-3-3');
       
       $MATRIZ = array(
           'NA'    => 'NO APLICA',
           '101'    => 'ARGENTINA',
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
           'SI'    => 'SI',
           'NO'    => 'NO'
       );
       $this->obj->list->listae('Aplica convenio de doble tributacion',$MATRIZ,'faplicconvdobtrib',$datos,'required','',$evento,'div-3-3');
       
       $MATRIZ = array(
           'NA'    => 'NO APLICA',
           'SI'    => 'SI',
           'NO'    => 'NO'
       );
       $this->obj->list->listae('Pago sujeto a retención en aplicación de la norma legal?',$MATRIZ,'fpagextsujretnorLeg',$datos,'required','',$evento,'div-3-3');
       
         
        
       $this->set->nav_tabs_cierre();
   }  
   //--------------------------------------------
   function K_tab_1_6($titulo ,$datos){
       
       $this->set->nav_tabs_inicio("tab_1_6",'');
       
 
        
       $tipo = $this->bd->retorna_tipo();
       
       $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('01','02')"
           );
       
       
       $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante Modificado','docmodificado',$datos,'','','div-3-3');
       
       $evento='';
 
       $this->obj->text->texte('Comprobante modificado',"texto",'secmodificado',9,9,$datos,'','',$evento,'div-3-3');
       
       
       $this->obj->text->text('Nro.Serie modificado',"texto",'estabmodificado',6,6,$datos,'','','div-3-3');
 
       
       $this->obj->text->text('Autorizacion',"texto",'autmodificado',47,47,$datos,'','','div-3-3');
       
      
 
       
       $this->set->nav_tabs_cierre();
   }  
   //----------------------------------------------
   function BarraHerramientas(){
 
 
       $eventof        = "_ImprimirRetencion()";
       
       $eventoe        = "_genera_comprobante(1)";
   	
       $eventox        = "EnviarRetencion()";
       
       $evento_anular  = "AnularRetencion()";

       $evento_ciu     = "ActualizaRuc()";
       
       $formulario_impresion = '../view/proveedor';
     
       $eventop = 'javascript:modalVentana('."'".$formulario_impresion."')";
        

       $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Comprobante Electronico', evento =>$eventoe,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success"),
                array( boton => 'Imprimir Comprobante', evento =>$eventof,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default"),
                array( boton => 'Enviar Email Proveedor', evento =>$eventox,  grafico => 'glyphicon glyphicon-envelope' ,  type=>"button_default"),
                  array( boton => 'Actualizar Identificacion de proveedor', evento =>$evento_ciu,  grafico => 'glyphicon glyphicon-eye-close' ,  type=>"button_default")
                
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

  $codigo       = trim($_GET['codigo']) ;
   
  $gestion->Formulario(  $codigo  );
  
 ?>
  