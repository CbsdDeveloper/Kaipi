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
        
                
               $this->formulario = 'Model-inv_guia.php'; 
   
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
      
        $datos = array();
 
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab('Titulo','inicio');
 
    
                $this->BarraHerramientas();
                 
                
                $this->set->div_panel6('<b> INFORMACION TRIBUTARIA </b>');
                
                    $this->obj->text->text('Movimiento','number','cab_codigo',10,10,$datos ,'','readonly','div-2-4') ;
                    $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
                    
                    $this->obj->text->text('Secuencial',"texto" ,'secuencial' ,80,80, $datos ,'','readonly','div-2-4') ;
                    $this->obj->text->text('Establecimiento',"texto" ,'estab' ,80,80, $datos ,'','readonly','div-2-4') ;
                    
                    $this->obj->text->text('PtoEmision',"texto" ,'ptoemi' ,80,80, $datos ,'','readonly','div-2-4') ;
                    $this->obj->text->text('Estado',"texto" ,'estado' ,80,80, $datos ,'','readonly','div-2-4') ;
                    
                    
                    $this->obj->text->text('Autorizacion',"texto" ,'claveacceso' ,80,80, $datos ,'','readonly','div-2-10') ;
                    $this->obj->text->text('Matriz',"texto" ,'dirmatriz' ,120,120, $datos ,'required','','div-2-10') ;
                    
                 $this->set->div_panel6('fin');
                    
 
               
                 
                 $this->set->div_panel6('<b> INFORMACION GUIA DE REMISION</b>');
              
                     $this->obj->text->text('Partida(Direcc.)',"texto" ,'dirpartida' ,80,80, $datos ,'required','','div-2-10') ;
                     $this->obj->text->text('Trasportista',"texto" ,'razonsocialtransportista' ,80,80, $datos ,'required','','div-2-10') ;
                     $this->obj->text->text('Identificacion',"texto" ,'ructransportista' ,80,80, $datos ,'required','','div-2-4') ;
                     $this->obj->text->text('Placa',"texto" ,'placa' ,80,80, $datos ,'required','','div-2-4') ;
                     $this->obj->text->text('Fecha Inicio',"date" ,'fechainitransporte' ,80,80, $datos ,'required','','div-2-10') ;
                     $this->obj->text->text('Fecha Final',"date" ,'fechafintransporte' ,80,80, $datos ,'required','','div-2-10') ;
                    
                    
                  $this->set->div_panel6('fin');
                  
               
                  $this->set->div_panel6('<b> DATOS DE LA FACTURA </b>');
                  
                  $this->obj->text->text('Nro Factura',"texto" ,'factura' ,80,80, $datos ,'required','','div-2-10') ;
                  $this->obj->text->text('Codigo',"texto" ,'codestabdestino' ,80,80, $datos ,'','readonly','div-2-10') ;
                   
                  $this->obj->text->editor('Novedad','observacion',2,75,500,$datos,'required','','div-2-10') ;
                  
                  echo ' <button type="button" class="btn btn-info" onClick="PoneDato();" >Ver factura</button>  ';
                  
                  
                  $this->set->div_panel6('fin');
                  
                  
                  
                  $this->set->div_panel6('<b> DATOS TRASLADO Y DESTINATARIO </b>');
                     
                  $this->obj->text->text('Identificacion',"texto" ,'identificaciondestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                  $this->obj->text->text('Destinatario',"texto" ,'razonsocialdestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                  $this->obj->text->text('Direccion',"texto" ,'dirdestinatario' ,80,80, $datos ,'required','','div-2-10') ;
                  
                  $this->obj->text->text('Motivo',"texto" ,'motivotraslado' ,80,80, $datos ,'required','','div-2-10') ;
                   $this->obj->text->text('Ruta',"texto" ,'ruta' ,80,80, $datos ,'required','','div-2-10') ;
                  
                  $this->set->div_panel6('fin');
                    
                   
                   $this->set->div_panel6('<b> DETALLE DE LA FACTURA </b>');
                   
                    
                   echo '<div id="det_factura"> </div>  ';
                   
                   $this->set->div_panel6('fin');
                 
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $eventog = "javascript:ElectronicoImprime(1)";
    
   $eventof = "javascript:ElectronicoTool()";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success"),
                array( boton => 'Imprimir Informe', evento =>$eventog,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default")
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
 
  