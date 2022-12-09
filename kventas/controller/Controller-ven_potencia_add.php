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
        
                
               $this->formulario = 'Model-ven_potencia.php'; 
   
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
                
                $this->set->div_panel6('<b> DATOS DE POTENCIAL CLIENTE </b>');
                
                $this->obj->text->text('Codigo','number','idvencliente',10,10, $datos ,'required','readonly','div-2-10') ;
                
                $this->obj->text->text('Identificacion',"texto",'idprov',13,13,$datos,'','','div-2-10') ;
          
                $this->obj->text->text('Nombre',"texto",'razon',80,95,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Direccion',"texto",'direccion',80,95,$datos,'required','','div-2-10') ;
                
                $this->obj->text->text('Email',"email",'correo',60,75,$datos,'required','','div-2-10') ;
                
                
                $MATRIZ = array(
                    '3'  => 'Muestra Interes',
                    '6'  => 'Negociacion aceptada' ,
                    '8'  => '(*) Orden de trabajo/Servicio' 
                );
                
                 $this->obj->list->listae('Estado',$MATRIZ,'estado',$datos,'required','',$evento,'div-2-10');
                
                
                $this->set->div_panel6('fin');
                
                $this->set->div_panel6('<b> DATOS INFORMATIVOS PARA UBICACION </b>');
                  
                
                $reg ="\d{2}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                $this->obj->text->textMask('Telefono',"tel",'telefono',18,20,$datos,'required','','',$reg,'div-2-10');
                
                $reg ="\d{3}[\-]\d{4}[\-]\d{3}";
                $reg ="";
                
                $this->obj->text->textMask('Movil',"tel",'movil',18,20,$datos,'required','','',$reg,'div-2-10');
                
                     
                $this->obj->text->text('Contacto ',"texto",'contacto',90,95,$datos,'required','','div-2-10') ;
                
                
                $this->obj->text->text('web ',"texto",'web',40,45,$datos,'required','','div-2-10') ;
                
        
                
                $resultado =$this->bd->ejecutar("select '-' as codigo, 'Seleccione zona' as nombre union
                                       SELECT  nombre as codigo, nombre
                                    FROM  par_catalogo
                                    where tipo = 'canton' order by 1" );
                
                $evento = '';
                
                $this->obj->list->listadbe($resultado,$tipo,'Zona','canton',$datos,'required','',$evento,'div-2-10');
 
              
                $MATRIZ = array(
                     'Redes Sociales'  => 'Redes Sociales',
                    'Base Datos'  => 'Base Datos',
                    'Otros Medios'  => 'Otros Medios'
                );
                
                $this->obj->list->listae('Medio de informacion',$MATRIZ,'medio',$datos,'','',$evento,'div-2-10');
                
                    
                
                    
                $this->set->div_panel6('fin');
                
                $this->obj->text->texto_oculto("id_campana",$datos);
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
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
 
  