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
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-inv_importaciones.php'; 
   
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
      
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab('Importacion','inicio');
 
        $datos = array();
    
                $this->BarraHerramientas();
                 
                echo '<h6> &nbsp;  </h6>';
               
                $this->set->div_panel('<b> INFORMACION GENERAL </b>');
                
                    $this->obj->text->text('Id importacion',"number" ,'id_importacion' ,80,80, $datos ,'required','readonly','div-2-4') ;
                     
                    $this->obj->text->text('Fecha',"date" ,'fecha' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text('Numero DAI',"texto" ,'dai' ,80,80, $datos ,'required','','div-2-10') ;
                    
                    $this->obj->text->text('Codigo Distrito',"texto" ,'distrito' ,80,80, $datos ,'required','','div-2-4') ;
                    $this->obj->text->text('Codigo Regimen',"texto" ,'regimen' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text('Tipo despacho',"texto" ,'tipodespacho' ,80,80, $datos ,'required','','div-2-4') ;
                    $this->obj->text->text('Nro despacho',"texto" ,'nrodespacho' ,80,80, $datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text('Tipo Pago',"texto" ,'tipopago' ,80,80, $datos ,'required','','div-2-4') ;
                    $this->obj->text->text('Fecha Aceptacion',"date" ,'fechaaceptacion' ,80,80, $datos ,'required','','div-2-4') ;
               
              $this->set->div_panel('fin');
            
                    
              
              $this->set->div_panel8('<b> INFORMACION RESUMEN IMPORTACION </b>');
           
              $this->obj->text->text('<b>VALOR FOB</b>',"number" ,'fob' ,80,80, $datos ,'','readonly','div-2-4') ;
              $this->obj->text->text('Valor Aduana',"number" ,'aduana' ,80,80, $datos ,'required','readonly','div-2-4') ;
              $this->obj->text->text('<b>FLETE</b>',"number" ,'flete' ,80,80, $datos ,'required','readonly','div-2-4') ;
              $this->obj->text->text('Items Declarados',"number" ,'items' ,80,80, $datos ,'required','readonly','div-2-4') ;
              $this->obj->text->text('<b>SEGURO</b>',"number" ,'seguro' ,80,80, $datos ,'required','readonly','div-2-4') ;
              $this->obj->text->text('Peso Neto (kg)',"number" ,'peso' ,80,80, $datos ,'required','readonly','div-2-4') ;
             
              $this->obj->text->text('<b>MONTO CIF</b>',"number" ,'cif' ,80,80, $datos ,'required','','div-2-4') ;
              
              $this->set->div_panel8('fin');
              
              
              $this->set->div_panel4('<b> INFORMACION ESTADO TRAMITE </b>');
              
              $MATRIZ = array(
                  'N'    => 'No',
                  'S'    => 'Si'
              );
              $evento='';
              $this->obj->list->listae('Finalizado?',$MATRIZ,'cierre',$datos,'','',$evento,'div-2-4');
              
              
             echo '<div style="padding-top: 5px;" class="col-md-8">
                      <button type="button" onClick="ResumenTotalIMportacion()" class="btn btn-sm btn-primary" >  
                            <i class="icon-white icon-ok"></i> Procesar informacion</button>	
                     </div>';
             
              $this->set->div_panel4('fin');
           
              
              $this->set->div_panel6('<b> INFORMACION RESUMEN DETALLE IMPORTACION </b>');
                   echo '<div id="resumen01"></div>'	;
              $this->set->div_panel6('fin');
              
              
              $this->set->div_panel6('<b> INFORMACION RESUMEN DETALLE FINANCIERO </b>');
                      echo '<div id="resumen02"></div>'	;
              $this->set->div_panel6('fin');
              
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("codigodeclarante",$datos); 
         $this->obj->text->texto_oculto("identificaciondeclarante",$datos); 
         $this->obj->text->texto_oculto("nombredeclarante",$datos); 
         $this->obj->text->texto_oculto("direcciondeclarante",$datos); 
         $this->obj->text->texto_oculto("paisprocede",$datos); 
         $this->obj->text->texto_oculto("codigoendoso",$datos); 
         $this->obj->text->texto_oculto("doctrasporte",$datos); 
         $this->obj->text->texto_oculto("nrocarga",$datos); 
          
         $this->obj->text->texto_oculto("unidadfisica",$datos);
         $this->obj->text->texto_oculto("tributo",$datos);
         $this->obj->text->texto_oculto("unidadcomercial",$datos); 
         
 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $formulario_reporte ='';
       
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
    
    $ToolArray = array( 
                 array( boton => 'Imprimir Informe', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button")
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
 
  