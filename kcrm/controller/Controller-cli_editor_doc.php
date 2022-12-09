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
        
                
               $this->formulario = 'Model-cli_editor_doc.php'; 
   
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
                
               
                    
                    $this->obj->text->text('Referencia',"number" ,'id_docmodelo' ,80,80, $datos ,'','readonly','div-2-10') ;
                    
                    
                    $MATRIZ = array(
                         'Oficio'    => 'Oficio',
                         'Memo'    => 'Memo',
                         'Informe'    => 'Informe',
                         'Notificacion'    => 'Notificacion'
                     );
 
                    
                    $this->obj->list->lista('Tipo',$MATRIZ,'tipo',$datos,'','','div-2-10');
  
                    
                    $this->obj->text->text_yellow('Plantilla',"texto" ,'plantilla' ,100,100, $datos ,'required','','div-2-10') ;
                    
                     
                    $MATRIZ = array(
                        'S'    => 'SI',
                        'N'    => 'NO'
                    );
                    
                    
                    $this->obj->list->lista('Publicar',$MATRIZ,'visor',$datos,'','','div-2-10');
                    
                 
                  
                    $this->set->div_panel6('fin');
                    
                    
                    $this->set->div_panel6('<b> VARIABLES FIJAS  </b>');
                    
                    
                    echo '<ul class="list-group">';
                    
                    
                    echo ' <li class="list-group-item">TRAMITE [ #TRAMITE ]'.'</li>';
                    echo ' <li class="list-group-item">CASO [ #CASO ]'.'</li>';
                    echo ' <li class="list-group-item">FECHA_PROCESO [ #FECHA_PROCESO ]'.'</li>';
                    echo ' <li class="list-group-item">IDENTIFICACION [ #IDENTIFICACION ]'.'</li>';
                    echo ' <li class="list-group-item">SOLICITA [ #SOLICITA ]'.'</li>';
                    echo ' <li class="list-group-item">MOVIL [ #MOVIL ]'.'</li>';
                    echo ' <li class="list-group-item">EMAIL [ #EMAIL ]'.'</li>';
                    echo ' <li class="list-group-item">DIRECCION [ #DIRECCION ]'.'</li>';
                    echo ' <li class="list-group-item">PROCESO [ #PROCESO ]'.'</li>';
                    echo ' <li class="list-group-item">UNIDAD [ #UNIDAD ]'.'</li>';
                    
                    
                    echo '</ul>';
                    
                
                    
                    $this->set->div_panel6('fin');
 
                    
                    $this->set->div_panel6('<b> Procesos  </b>');
                    
                    
                    $sql1 = "SELECT nombre, idproceso    
                                FROM flow.view_proceso
                                where publica = 'S' order by nombre";
                    
                    $stmt1 = $this->bd->ejecutar($sql1);
                    
                    echo '<ul class="list-group">';
                           
                    while ($fila=$this->bd->obtener_fila($stmt1)){
                                 
                                 $nombre    =  trim($fila['nombre']);
                                 
                                 $idproceso =  $fila['idproceso'];
                                 
                                 echo ' <li class="list-group-item"><a href="#" onClick="PoneVariables('.$idproceso.')">'.$nombre.'</a></li>';
                                 
                             }
                    
                   echo '</ul>';
 
                   $this->set->div_panel6('fin');
                   
                   
                   $this->set->div_panel6('<b> Variables Disponibles  </b>');
                   
                        echo '<div id="view_variables"></div>';
                             
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
  