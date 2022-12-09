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
                   
                $this->bd	   =	new Db;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-ven_plantillas.php'; 
   
               $this->evento_form = '../model/'. $this->formulario;       
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
                
                
                    $this->set->div_panel6('<b> PLANTILLA  </b>');
                
                    
                    $this->obj->text->text('Id_plantilla',"number" ,'id_plantilla' ,80,80, $datos ,'','readonly','div-2-10') ;
                    
                    
                    $MATRIZ = array(
                         '6'    => 'Documento',
                         '1'    => 'Publicidad',
                         '2'    => 'Promocion',
                         '3'    => 'Evento',
                         '4'    => 'Oferta',
                         '5'    => 'Noticia'
                    );
                      
                    
                    $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-10');
                    
                    
                    $this->obj->text->text('Titulo',"texto" ,'titulo' ,100,100, $datos ,'required','','div-2-10') ;
                    
                     
                    $MATRIZ = array(
                        'S'    => 'SI',
                        'N'    => 'NO'
                    );
                    
                    
                    $this->obj->list->lista('Publicar',$MATRIZ,'publicar',$datos,'','','div-2-10');
                    
                 
                  
                    $this->set->div_panel6('fin');
                      
                    
                    $this->set->div_panel6('<b> VARIABLES ADICIONALES</b>');
                    
                  
                    $MATRIZ = array(
                        'Publico'    => 'Publico',
                        'Privado'    => 'Privado'
                    );
                    
                    
                    $this->obj->list->lista('Ambito',$MATRIZ,'ambito',$datos,'','','div-2-10');
                    
                   
                    $MATRIZ = array(
                        'Formulario'    => 'Formulario de datos',
                        'Suscribete'    => 'Suscribete',
                        'Mas informacion'    => 'Mas informacion'
                    );
                     
                    $this->obj->list->lista('Variable',$MATRIZ,'variable',$datos,'','','div-2-10');
                    
                    
                    echo 'Variables Web<br>$nombre_email = Nombre de Cliente<br>
                          Variables Formularios <br>
                          $mas_informacion  <br>
                          $suscribete  <br>
                          $formulario ';
     
                    $this->set->div_panel6('fin');
                    
                    
 
         
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   $eventoi = "javascript:window.print();";
    
 
   
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
   //----------------------------------------------
   
  
  
///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }    

 
   $gestion   = 	new componente;
    
   $gestion->Formulario();
   
   ?>
  