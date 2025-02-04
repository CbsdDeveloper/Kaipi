<script >// <![CDATA[

   jQuery.noConflict(); 
	
	jQuery(document).ready(function() {
  		
   // InjQueryerceptamos el evento submit
    jQuery('#formItems').submit(function() {
  		// Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: 'POST',
            url: jQuery(this).attr('action'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
 				
             	 jQuery('#resultItems').html(data);

            	 jQuery( "#resultItems" ).fadeOut( 1600 );

            	 jQuery("#resultItems").fadeIn("slow");
            
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
        
                
               $this->formulario = 'Model-inv_importaciones_Items.php'; 
   
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
      
 
         
        $this->set->evento_formulario_id( $this->evento_form,'inicio','formItems' ); // activa ajax para insertar informacion
   
          
                $this->BarraHerramientas();
                 
                $this->set->div_panel('<b> INFORMACION GENERAL </b>');
                       
                     
                $cboton1 = ' <a href="#"  title="Agregar Articulo">Articulo</a>';
               
                $this->obj->text->textautocomplete($cboton1,"texto",'articulo',50,50,$datos,'','','div-2-10');
                
                $this->obj->text->text('Idproducto',"number" ,'idproducto' ,80,80, $datos ,'required','readonly','div-2-10') ;
                
                $this->obj->text->text('Partida',"texto" ,'partida' ,80,80, $datos ,'required','','div-2-10') ;
               
                $this->obj->text->text('Cantidad',"number" ,'cantidad' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Peso',"number" ,'peso_item' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Costo',"number" ,'costo' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Advalorem',"number" ,'advalorem' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Infa',"number" ,'infa' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Iva',"number" ,'iva' ,80,80, $datos ,'required','','div-2-4') ;
                
                $this->obj->text->text('Salvaguardia',"number" ,'salvaguardia' ,80,80, $datos ,'required','','div-2-4') ;
                $this->obj->text->text('Aranceles',"number" ,'aranceles' ,80,80, $datos ,'required','','div-2-4') ;
                       
                    
              $this->set->div_panel('fin');
             
              
              
         $this->obj->text->texto_oculto("action_items",$datos); 
         
         $this->obj->text->texto_oculto("id_importacionfacitem",$datos); 
         
         $this->obj->text->texto_oculto("id_importacionfac_key",$datos); 
         
         $this->obj->text->texto_oculto("id_importacion_item",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
   
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
  
    $eventoi = "javascript:nueva_items()";
       
    $ToolArray = array( 
        array( boton => 'Nuevo Regitros',    evento =>$eventoi, grafico => 'icon-white icon-plus' ,  type=>"button"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")  
                 );
                  
    $this->obj->boton->ToolMenuDivId($ToolArray,'resultItems'); 
 
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
 <script type="text/javascript">

 jQuery.noConflict(); 

 
  
 //---------------------------------------------- focusin focusout
 
 
  jQuery('#articulo').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoCompleteProdFacItems.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

  $("#articulo").focusin(function(){
		 
		 var itemVariable = $("#articulo").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDProdItems.php',
												type:  'GET' ,
												success:  function (response) {
														 $("#idproducto").val(response);  // $("#cuenta").html(response);

														  
														 
												} 
										});
		 
	    });
  

  
  
  
</script>
  