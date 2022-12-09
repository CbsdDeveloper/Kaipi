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

		         jQuery('#result').slideUp( 300 ).delay( 0 ).fadeIn( 400 ); 
	            	            
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
        
                
               $this->formulario = 'Model-co_solicitupago.php'; 
   
               $this->evento_form = '../model/Model-co_solicitupago.php';        // eventos para ejecucion de editar eliminar y agregar 
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
                   
             
                
                $this->obj->text->text('Solicitud',"number",'id_solpagos',0,10,$datos,'','readonly','div-1-3') ;
                
                $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','','div-1-3');
                
                $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'','readonly','div-1-3');
                
                
                $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-1-3');
                
                $this->obj->text->text('Pagado',"texto",'estado_pago',15,15,$datos,'','readonly','div-1-3');
                
                $this->obj->text->text('Elaborado',"texto",'sesion',15,15,$datos,'required','readonly','div-1-3');
                
                
                $this->obj->text->text('Asunto',"texto",'asunto',100,100,$datos,'required','','div-1-11');
                
                
                $this->obj->text->textautocomplete('Beneficiario',"texto",'txtidprov',15,15,$datos,'required','','div-1-5');
                
                    
                $this->obj->text->text('Identificación',"texto",'idprov',15,15,$datos,'required','readonly','div-1-5');
                
                $this->obj->text->text('Monto',"number",'apagar',0,10,$datos,'','','div-1-11') ;
                
                 
                $sql = "SELECT  email as codigo, completo as nombre
					  FROM par_usuario
					  where supervisor = 'S'";
                
                $resultado = $this->bd->ejecutar($sql);
                
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->list->listadb($resultado,$tipo,'Revisado','sesionr',$datos,'required','','div-1-11');
                
                
                $sql = "SELECT  email as codigo, completo as nombre
					  FROM par_usuario 
					  where supervisor = 'S'";
					                
                $resultado = $this->bd->ejecutar($sql);
                
                $tipo = $this->bd->retorna_tipo();
                
                $this->obj->list->listadb($resultado,$tipo,'Autoriza','sesiona',$datos,'required','','div-1-11');
                
                
                echo '<div class="col-md-12">
		             <div class="hero-unit" style="margin-top:40px">
		                <textarea id ="detalle" name="detalle" class="textarea" placeholder="Enter text ..." style="width: 810px; height: 200px;">
						</textarea>
		            </div>
		        </div>';
		                
          
                      
         $this->obj->text->texto_oculto("action",$datos); 
         
         $this->set->evento_formulario('-','fin'); 
 
  
      
   }
 
   //----------------------------------------------
   function BarraHerramientas(){
 
 
   	$evento = 'javascript:aprobacion('."'".$this->formulario.'?action=aprobacion'."'".')';
   	
   	$formulario_impresion = '../reportes/ficherocomprobante?a=';
   	
   	$eventop = 'javascript:impresion('."'".$formulario_impresion."','".'id_asiento'."')";
   
    $ToolArray = array( 
                array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
    		    array( boton => 'Aprobar asientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
    	     	array( boton => 'Imprimir comprobante', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") 
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
 
 <script type="text/javascript">

 
	$('#txtidprov').typeahead({
	    source:  function (query, process) {
        return $.get('../model/ajax_NomCiu.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 $("#txtidprov").focusout(function(){
	 
	 var itemVariable = $("#txtidprov").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/ajax_IdCiu.php',
											type:  'GET' ,
											beforeSend: function () {
													$("#idprov").val('...');
											},
											success:  function (response) {
													 $("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
	    
</script>

<script src="../app/plugins/bootstrap-wysihtml5/wysihtml5.js"></script>
<script src="../app/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script>

 		   var jQuery;
  
           jQuery.noConflict(); 
	
           jQuery('.textarea').wysihtml5({
                "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
                "emphasis": true, //Italics, bold, etc. Default true
                "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
                "html": true, //Button which allows you to edit the generated HTML. Default false
                "link": true, //Button to insert a link. Default true
                "image": true, //Button to insert an image. Default true,
                "color": true //Button to change color of font  
            });
           
</script>
  