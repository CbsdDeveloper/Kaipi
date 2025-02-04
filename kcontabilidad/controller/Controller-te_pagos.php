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
      private $anio;
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
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->anio       =  $_SESSION['anio'];
                
                
               $this->formulario = 'Model-te_pagos.php'; 
   
               $this->evento_form = '../model/'.$this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
 
 
    
                $this->BarraHerramientas();
                    
                $tipo = $this->bd->retorna_tipo();
                
                echo '<div class="row">';
                
                $this->obj->text->text('Nro.Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-2-4') ;
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                $this->obj->text->editor('<b>Detalle</b>','detalle',3,45,300,$datos,'required','','div-2-10') ;
                
   
                $this->set->div_label(12,'<h5><b>FORMA Y DETALLE DE PAGO</b></h5>');
                
                echo '</div><div class="alert alert-warning"><div class="row">';
                
                $this->obj->text->text('<b>Beneficiario</b>',"texto",'beneficiario',15,15,$datos,'','readonly','div-2-4');
                
                $this->obj->text->text('<b>Identificacion</b>',"texto",'idprov',15,15,$datos,'','readonly','div-2-4');
                  
                
                $resultado = $this->bd->ejecutar("SELECT '' as codigo, '[ SELECCIONE BANCO ]' as nombre
                                        union
                                        SELECT cuenta as codigo, detalle as nombre
          											FROM co_plan_ctas
          											where tipo_cuenta = 'B' and univel = 'S' and
                                                          anio = ".$this->bd->sqlvalue_inyeccion($this->anio, true). " and 
                                                          registro =".$this->bd->sqlvalue_inyeccion($this->ruc , true). " order by 1"  );
                
               
                
                $this->obj->list->listadb($resultado,$tipo,'Banco','idbancos',$datos,'required','','div-2-10');  
                
                
                $MATRIZ =   $this->obj->array->catalogo_tipo_tpago();
                
                $java =  "busca_cheque($('#tipo').val());return false;";
                
                $evento = ' onChange="'.$java.'" ';
                
                
                $this->obj->list->listae('Forma pago',$MATRIZ,'tipo',$datos,'required','',$evento,'div-2-4');
                
                
                $this->obj->text->text('Nro.Documento',"texto",'cheque',15,15,$datos,'required','','div-2-4');
                
                $evento = 'onChange="ValidaMonto(this.value)"';
                
                $this->obj->text->texte('US $ ',"number",'apagar',0,30,$datos,'required','',$evento,'div-2-4') ; 
                
            //    $this->obj->text->text('Nro.Retencion',"texto",'retencion',15,15,$datos,'required','','div-2-4'); 
 
                echo '<div id="pago_valor"></div>';
           
                echo '</div></div>';
                
                $this->obj->text->text('Generado',"texto",'pago',15,15,$datos,'required','readonly','div-2-4'); 
               
                $this->obj->text->text('Nro.Comprobante',"texto",'comprobante',15,15,$datos,'','readonly','div-2-4'); 
          
                $this->obj->text->texto_oculto("action",$datos); 
                
                
                $this->obj->text->texto_oculto("cuenta",$datos); 
                
                $this->obj->text->texto_oculto("monto_valida",$datos); 
                
                $this->obj->text->texto_oculto("id_asiento_ref",$datos); 
                
                
                $this->obj->text->texto_oculto("pago_tipo",$datos); 
                
                $this->obj->text->texto_oculto("id_asiento_aux",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   
    $formulario_impresion = $this->bd->_impresion_carpeta('54');
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento_ref'."')";
   	
   	$eventoc = "javascript:_url('../view/co_pagos')";
   	
   	$formulario_impresion = $this->bd->_impresion_carpeta('56');
   	$evento1 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento_ref'."')";
   	
   	 
   	
   	
   	$formulario_impresion = '../reportes/ficherocheque?a=';
   	$evento2 = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento_ref'."')";
   	
   	
   	
   	
    
    $ToolArray = array( 
             array( boton => 'Generar Pago de Factura', evento =>'', grafico => 'glyphicon glyphicon-ok' ,  type=>"submit") ,
     	    array( boton => 'Imprimir Diario Contable', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
    		array( boton => 'Imprimir Comprobante de Pago', evento =>$evento1,  grafico => 'glyphicon glyphicon-tasks' ,  type=>"button_info") ,
    		array( boton => 'Imprimir Cheque', evento =>$evento2,  grafico => 'glyphicon glyphicon-save-file' ,  type=>"button") ,
     		array( boton => 'Comprobantes de pago', evento =>$eventoc,  grafico => 'glyphicon glyphicon-new-window' ,  type=>"button_success") 
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