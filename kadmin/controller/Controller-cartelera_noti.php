<script type="text/javascript" src="../../app/bootstrap-wysihtml5/wysihtml5.min.js"></script>
<script type="text/javascript" src="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>
<link href="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">
<script >// <![CDATA[

 var editor;

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
 		}) ;
 
	editor  = new jQuery('.textarea').wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": false, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": true //Button to change color of font  
    });
    
	 
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
          
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
                
                $this->hoy 	     =  $this->bd->hoy();
        
                
               $this->formulario = 'Model-cartelera_noti.php'; 
   
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
      
         $tipo = $this->bd->retorna_tipo();
 
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $datos = array();
 
    
                $this->BarraHerramientas();
                
                $this->set->div_panel8('CARTELERA INFORMATIVO');
                  
                
                
                $this->obj->text->text('Codigo',"number",'id_cartelera',20,15,$datos,'required','readonly','div-2-4') ; 
               
                $this->obj->text->text_yellow('Fecha',"date",'fecha',15,15,$datos,'required','','div-2-4');
                
                
                $this->obj->text->text_blue('Asunto',"texto",'asunto',65,65,$datos,'required','','div-2-10') ; 
                
                 
                  
                $this->obj->text->editor_area('Notificacion','notificacion',4,45,350,$datos,'','','div-2-10') ;
                  
                $MATRIZ = array(
                    'N'    => 'NO',
                    'S'    => 'SI' 
                );
                
                $this->obj->list->lista('Publicar',$MATRIZ,'estado',$datos,'required','','div-2-4');
                
                
             
                
                $this->set->div_panel8('fin');
                
                
                
                $this->set->div_panel4('ENVIO DE INFORMACON');
           
               
                
                $this->obj->text->text_blue('Sesion',"texto",'sesion',65,65,$datos,'','readonly','div-2-10') ; 
                
                 
                $resultado =  $this->combo_lista("ven_plantilla");
                $this->obj->list->listadb($resultado,$tipo,'Plantilla','plantilla',$datos,'required','','div-2-10');
                
                $this->set->div_label(12,'DESTINATARIOS ');	 


                $resultado =  $this->combo_lista("nom_departamento");
                $this->obj->list->listadb($resultado,$tipo,'Unidades','unidades',$datos,'required','','div-2-10');


                
                $resultado =  $this->combo_lista("nom_regimen");
                $this->obj->list->listadb($resultado,$tipo,'Regimen','regimen',$datos,'required','','div-2-10');
                

              
                


                echo ' <div class="col-md-12" style="padding: 25px" > 
                            <button type="button" onClick="EnviarNotificacion()"  class="btn btn-danger">Enviar Notificacion</button>  
                      </div>
                      
                      <div id="ViewEnvio" style="padding: 20px" align="center"> </div> ';
                

                
                
                $this->set->div_panel4('fin');
                
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->_formulario('-','fin'); 
 
  
      
   }
     //----------------------------------------------------......................-------------------------------------------------------------
 // retorna el valor del campo para impresion de pantalla
   //----------------------------------------------
   function combo_lista($tabla ){
       
 
       
       if  ($tabla == 'ven_plantilla'){
           
           $resultado =  $this->bd->ejecutarLista("id_plantilla,titulo",
               $tabla,
               "tipo = ".$this->bd->sqlvalue_inyeccion( '3' ,true),
               "order by 2");
               
       }
       
       if  ($tabla == 'nom_cargo'){
           
           $resultado =  $this->bd->ejecutarLista("id_cargo,nombre",
               $tabla,
               "-",
               "order by 2");
               
       }
       
       
       if  ($tabla == 'nom_regimen'){
           
           $resultado =  $this->bd->ejecutarLista("regimen,regimen",
               $tabla,
               "activo = ".$this->bd->sqlvalue_inyeccion('S' ,true),
               "order by 2");
               
       }
       
       if  ($tabla == 'nom_departamento'){
           
        $resultado = $this->bd->ejecutar_unidad();  // catalogo de unidades
    }
       
       
       
       return $resultado;
       
       
   }   
   //----------------------------------------------
   function BarraHerramientas(){
 
 
 
   
   $eventoi = "javascript:imprimir_informe()";
    
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                array( boton => 'Visor de Notificacion', evento =>$eventoi,  grafico => 'glyphicon glyphicon-new-window' ,  type=>"button_info")
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
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  
   
  $gestion->Formulario( );
  
 ?>
 <script>
 function dato_editor( htmldato ){
	
 

	 
    var editorInstance = editor.data('wysihtml5').editor;
    
    editorInstance.setValue(htmldato, true);


}
</script>
  