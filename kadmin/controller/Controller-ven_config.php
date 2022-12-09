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
        
                
               $this->formulario = 'Model-ven_config.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;        // eventos para ejecucion de editar eliminar y agregar 
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
                     
                $tipo = $this->bd->retorna_tipo();
                
                  
                $this->set->div_panel6('<b> ACCESO PARA ENVIO DE CORREO </b>');
                               
                
                $this->obj->text->text('Codigo','number','idven_registro',10,10, $datos ,'required','readonly','div-2-10') ;
                
                $this->obj->text->text('Sitio Web',"texto",'web',100,100,$datos,'required','','div-2-10') ; 
                
                $this->obj->text->text('Telefono',"texto",'telefono',100,100,$datos,'required','','div-2-10');
              
                $this->obj->text->text('Directorio',"texto",'directorio',80,85,$datos,'','','div-2-10');
                
                
                $this->set->div_panel6('fin');
                
                
                
                $this->set->div_panel6('<b> CONFIGURACION DE CORREO SMTP GMAIL </b>');
                
                
                $this->obj->text->text('Email',"email",'email',100,100,$datos,'required','','div-2-10');
            
                $this->obj->text->text('Host SMTP',"texto",'smtp',40,45,$datos,'','','div-2-10');
                  
                $this->obj->text->text('Puerto',"texto",'puerto',40,45,$datos,'','','div-2-10');
                
                $this->obj->text->text('Acceso',"password",'acceso',80,80,$datos,'','','div-2-10');
                
                
               
                $this->set->div_panel6('fin');
                
                
                $this->set->div_panel6('<b> CONFIGURACION DE CORREO SMTP  EMPRESARIAL </b>');
                
                
                $this->obj->text->text('Email',"email",'email1',100,100,$datos,'required','','div-2-10');
                
                $this->obj->text->text('Host SMTP',"texto",'smtp1',40,45,$datos,'','','div-2-10');
                
                $this->obj->text->text('Puerto',"texto",'puerto1',40,45,$datos,'','','div-2-10');
                
                $this->obj->text->text('Acceso',"password",'acceso1',80,80,$datos,'','','div-2-10');
                
                
                
                $this->set->div_panel6('fin');
                
 
   
                $this->set->div_panel6('<b> ACCESO VARIABLES REDES SOCIALES </b>');
                
                
                $this->obj->text->editor('MuroFacebook','facebook',3,75,500,$datos,'required','','div-2-10') ;
                
                $this->obj->text->editor('GoogleMaps','mapagoogle',3,75,500,$datos,'required','','div-2-10') ;
                
                $this->obj->text->editor('MuroTwiter','twiter',3,75,500,$datos,'required','','div-2-10') ;
       
                
                $this->set->div_panel6('fin');
                
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   $evento = 'javascript:open_editor();';
   
   $formulario_reporte = 'reportes/informe?a=';
   
   $eventoi = "javascript:imprimir_informe('".$formulario_reporte."')";
    
   $formulario_reporte ="goToURL('editar',1)";
   
   $eventop =   $formulario_reporte ;
   
   
    $ToolArray = array( 
                 array( boton => 'Actualizar Datos', evento =>$eventop,  grafico => 'glyphicon glyphicon-search' ,  type=>"button"),
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
 
  