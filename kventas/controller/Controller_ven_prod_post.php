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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				
                $this->formulario = 'Model-ven_prod_cli_post.php'; 
                
              	$this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $titulo = 'Productos';
         
        $this->set->evento_formulario_id( $this->evento_form,'inicio','formProducto' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 		
        $this->BarraHerramientas();
        
        echo '<h6> &nbsp; </h6>';
        
        $tipo = $this->bd->retorna_tipo();
		
        
        
        $resultado = $this->bd->ejecutar("select 0 as codigo , '  [ Seleccione el Bodega de Gestion ] ' as nombre union
                                         select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        
        $evento2 =' OnChange="AsignaBodega();"';
        
        $this->obj->list->listadbe($resultado,$tipo,'Bodega','idbodega',$datos,'','',$evento2,'div-2-10');
        
        
        $this->obj->text->textautocomplete('Producto Ofertado',"texto",'producto',100,100,$datos,'','','div-2-10');
        
        
        $this->obj->text->text('Codigo','texto','idproducto',30,30,$datos ,'','readonly','div-2-10') ;
        
        
        $this->obj->text->editor('Detalle','detalle',3,75,500,$datos,'required','','div-2-10') ;
        
        $this->obj->text->text('SALDO','texto','saldo',30,30,$datos ,'','readonly','div-2-10') ;
        
        
        $this->obj->text->text('Cantidad','number','cantidad',30,30,$datos ,'required','','div-2-4') ;
        
        $this->obj->text->text('Precio','number','precio',30,30,$datos ,'required','','div-2-4') ;
        

        
        $MATRIZ = array(
            'I'  => 'Tarifa 12%',
            'T' => 'Tarifa 0%'
         );
        
        $this->obj->list->listae('Tarifa',$MATRIZ,'tipo',$datos,'','',$evento,'div-2-4');
        
        
        $this->obj->text->text('% Descuento','number','descuento',30,30,$datos ,'required','','div-2-4') ;
   
        
        $this->obj->text->texto_oculto("idvengestion_pro",$datos); 
        
        $this->obj->text->texto_oculto("idven_prod",$datos); 
         
 	    $this->obj->text->texto_oculto("actionProducto",$datos); 
	    
        $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
       
     $eventoi = "javascript:agregar_producto()";
     
     $ToolArray = array(
         array( boton => 'Nuevo Ingreso', evento =>$eventoi,  grafico => 'icon-white icon-plus' ,  type=>"button"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit")
     );
     
     
     $this->obj->boton->ToolMenuDivId($ToolArray,'guardarProducto'); 
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
   
  
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   
?>
<script type="text/javascript">

    jQuery.noConflict(); 
  
	jQuery(document).ready(function() {
	// InjQueryerceptamos el evento submit
	jQuery('#formProducto').submit(function() {
		// Enviamos el formulario usando AJAX
    		jQuery.ajax({
    			type: 'POST',
    			url: jQuery(this).attr('action'),
    			data: jQuery(this).serialize(),
    			// Mostramos un mensaje con la respuesta de PHP
    			success: function(data) {
    
    				 jQuery('#guardarProducto').html(data);
    
    			}
    		})        
			return false;
		}); 
	})
	
 //----------------------------------------------------------------------
 	
  jQuery('#producto').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoProd.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

  $("#producto").focusout(function(){
		 
		 var itemVariable = $("#producto").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};


	        		$.ajax({
					    type:  'GET' ,
						data:  parametros,
						url:   '../model/AutoCompleteIDProdMulCot.php',
						dataType: "json",
						success:  function (response) {

							
								 $("#idproducto").val( response.a );  
								 
								 $("#precio").val( response.b );  

								 $("#saldo").val( response.c );  

								 
						} 
				});
										 
								/*		$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDProdMul.php',
												type:  'GET' ,
												beforeSend: function () {
														$("#idproducto").val('...');
												},
												success:  function (response) {
														 $("#idproducto").val(response);  // $("#cuenta").html(response);
														  
												} 
										});
		 */
	    });
</script>
