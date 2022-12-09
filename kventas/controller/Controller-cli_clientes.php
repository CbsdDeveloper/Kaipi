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
        
                
               $this->formulario = 'Model-cli_clientes.php'; 
   
               $this->evento_form = '../model/'. $this->formulario ;        // eventos para ejecucion de editar eliminar y agregar 
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
                     
                $MATRIZ =  $this->obj->array->catalogo_tpIdProv();
                
                $this->obj->list->listae('identificacion',$MATRIZ,'tpidprov',$datos,'required','',$evento,'div-2-4');
                
                $evento = 'onBlur="javascript:validarCiu()"';
                
                $this->obj->text->texte('Identificacion',"texto",'idprov',20,15,$datos,'required','',$evento,'div-2-4') ; 
                
                
                $MATRIZ =  $this->obj->array->catalogo_naturaleza();
                
                $this->obj->list->listae('Naturaleza',$MATRIZ,'naturaleza',$datos,'required','',$evento,'div-2-4');
                
                $MATRIZ =  $this->obj->array->catalogo_activo();
                
                $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-4');
                
                
                $MATRIZ = array(
                		'C'    => 'Cliente'
                 );
                
                $this->obj->list->listae('Tipo',$MATRIZ,'modulo',$datos,'','',$evento,'div-2-4');
                
                $resultado = $this->bd->ejecutar("select idcatalogo as codigo, nombre
            			                     from par_catalogo
            								where tipo = 'canton' and publica = 'S' order by nombre ");
                
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->list->listadb($resultado,$tipo,'Ciudad','idciudad',$datos,'required','','div-2-4');
                
                
                $this->obj->text->text('Razon Social',"texto",'razon',40,45,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Direccion',"texto",'direccion',40,45,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('Email',"email",'correo',40,45,$datos,'required','','div-2-4') ;
                
                $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'required','','',$reg,'div-2-4');
                
                $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'required','','',$reg,'div-2-4');
                // lista de valores
                
                $this->obj->text->text('Contacto ',"texto",'contacto',40,45,$datos,'required','','div-2-4') ;
                
                $this->obj->text->text('Email',"email",'ccorreo',40,45,$datos,'required','','div-2-4') ;
                
                $reg ="";
                
                $this->obj->text->textMask('Telefono',"tel",'ctelefono',18,20,$datos,'required','','',$reg,'div-2-4');
                
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'cmovil',18,20,$datos,'required','','',$reg,'div-2-4');     
                
              
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->obj->text->texto_oculto("nacimiento",$datos); 
         
      
         
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
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
 
  