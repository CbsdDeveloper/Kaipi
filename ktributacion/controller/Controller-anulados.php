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
        
                
               $this->formulario = 'Model-anulados.php'; 
   
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
                   
          
                $this->set->div_panel('<b> DATOS COMPROBANTES AUTORIZADOS </b>');
                      
                
                
                $MATRIZ = $this->obj->array->catalogo_anio();
                
                $this->obj->list->lista('Año',$MATRIZ,'anio',$datos,'required','','div-2-4');
                
                
                $MATRIZ =  $this->obj->array->catalogo_mes();
                $this->obj->list->lista('Mes',$MATRIZ,'mes',$datos,'required','','div-2-4');
                
                       
                $this->obj->text->text_yellow('Nro.Anexo','number','id_anulados',10,10, $datos ,'','readonly','div-2-4') ;
                    
                    
                $resultado = $this->bd->ejecutar("SELECT codigo,  detalle as nombre
    									  FROM co_catalogo
    									  where tipo = 'Tipos Comprobantes Autorizados' and
    									  codigo in ('01','02','03','07','18','04','05')"
                    );
                
                $this->obj->list->listadb($resultado,$tipo,'Tipo Comprobante','tipocomprobante',$datos,'required','','div-2-4');
         
              
                $evento ='onChange="ponedatos()"';
                $this->obj->text->texte('Establecimiento','texto','establecimiento',3,3, $datos ,'required','',$evento,'div-2-4') ;
                $this->obj->text->texte('Puntoemision','texto','puntoemision',3,3, $datos ,'required','',$evento,'div-2-4') ;
                
                $evento ='onChange="validadatos()"';
                $this->obj->text->texte('Secuencial Inicio',"texto",'secuencialinicio',9,9,$datos,'required','',$evento,'div-2-4');
                $this->obj->text->texte('Secuencial Final',"texto",'secuencialfin',9,9,$datos,'required','',$evento,'div-2-4');
                
                  
                $this->obj->text->text('Autorizacion','texto','autorizacion',47,47, $datos ,'required','','div-2-4') ;
   
                 
                
          
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 //-------------
   
   
   //-------------------------------
   
     //----------------------------------------------
   function BarraHerramientas(){
 
    	
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
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
 