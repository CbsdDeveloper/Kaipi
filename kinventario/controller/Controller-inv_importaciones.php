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
   
        $this->set->body_tab($titulo,'inicio');
 
    
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
            
                    
              $this->set->div_panel6('<b> INFORMACION DEL DECLARANTE </b>');
                   
              $this->obj->text->text('Codigo',"texto" ,'codigodeclarante' ,80,80, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Identificacion',"texto" ,'identificaciondeclarante' ,13,13, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Nombre',"texto" ,'nombredeclarante' ,80,80, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Direccion',"texto" ,'direcciondeclarante' ,80,80, $datos ,'required','','div-2-10') ;
    
              
              $this->set->div_panel6('fin');
                   
                  
              $this->set->div_panel6('<b> INFORMACION CARGA </b>');
              
              $this->obj->text->text('Pais Procede',"texto" ,'paisprocede' ,80,80, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Codigo Endoso',"texto" ,'codigoendoso' ,80,80, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Doc Trasporte',"texto" ,'doctrasporte' ,80,80, $datos ,'required','','div-2-10') ;
              $this->obj->text->text('Nro Carga',"texto" ,'nrocarga' ,80,80, $datos ,'required','','div-2-10') ;
              
                  
              $this->set->div_panel6('fin');
                   
              
              $this->set->div_panel('<b> INFORMACION TOTALES </b>');
           
              $this->obj->text->text('Fob',"number" ,'fob' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Flete',"number" ,'flete' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Seguro',"number" ,'seguro' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Valor Aduana',"number" ,'aduana' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Items Declarados',"number" ,'items' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Peso Neto (kg)',"number" ,'peso' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Unidad Fisica',"number" ,'unidadfisica' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Total Tributo',"number" ,'tributo' ,80,80, $datos ,'required','','div-2-4') ;
              $this->obj->text->text('Unidad Comercial',"number" ,'unidadcomercial' ,80,80, $datos ,'required','','div-2-4') ;
              
              
              $this->set->div_panel('fin');
              
              
              $this->set->div_panel6('<b> INFORMACION ESTADO TRAMITE </b>');
              
              $MATRIZ = array(
                  'N'    => 'No',
                  'S'    => 'Si'
              );
              
              $this->obj->list->listae('Finalizado?',$MATRIZ,'cierre',$datos,'','',$evento,'div-2-4');
              
              
              $this->set->div_panel6('fin');
              
              
              
         $this->obj->text->texto_oculto("action",$datos); 
         
          
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
    
    $ToolArray = array( 
               array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
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
 
  