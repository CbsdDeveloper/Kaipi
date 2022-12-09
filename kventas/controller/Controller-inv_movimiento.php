 <script >// <![CDATA[
    jQuery.noConflict(); 
 	jQuery(document).ready(function() {
    // InjQueryerceptamos el evento submit
    jQuery('#fo3').submit(function() {
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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				$this->formulario = 'Model-inv_movimiento.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
        $this->set->evento_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
        $this->set->body_tab($titulo,'inicio');
 		
        $this->BarraHerramientas();
        
        $tipo = $this->bd->retorna_tipo();
        
        $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        
        $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega',$datos,'','','div-2-10');
        
 
        $MATRIZ = $this->obj->array->inven_tipo();
        
        $evento = 'OnChange="AsignaBodega();"';
        $this->obj->list->listae('Referencia',$MATRIZ,'tipo',$datos,'required','',$evento,'div-2-4');
        
		$this->obj->text->text('Movimiento','number','id_movimiento',10,10,$datos ,'','readonly','div-2-4') ;

		$datos['fecha'] =  date("Y-m-d");
		$this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-4') ;
		$this->obj->text->text('Estado','texto','estado',10,10,$datos ,'','readonly','div-2-4') ;
		
		$this->obj->text->text('Comprobante','texto','comprobante',10,10,$datos ,'','readonly','div-2-4') ;
		$this->obj->text->text('Aprobado','date','fechaa',10,10,$datos ,'','readonly','div-2-4') ;
		
		
		$this->obj->text->editor('Detalle','detalle',2,75,500,$datos,'required','','div-2-10') ;
		
		
		$MATRIZ = array(
		    'compra'    => 'Compra',
		    'salida mercaderia'    => 'salida mercaderia',
		    'devolucion'    => 'devolucion',
		    'donacion'    => 'donacion' ,
		    'carga inicial'    => 'Carga inicial'  
		);
		$this->obj->list->lista('Transaccion',$MATRIZ,'transaccion',$datos,'required','','div-2-4');
		
		
		$this->obj->text->text('Documento','texto','documento',10,10,$datos ,'required','','div-2-4') ;
		
	
		 $this->obj->text->textautocomplete('Proveedor/Responsable',"texto",'razon',40,45,$datos,'required','','div-2-4');

		 $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
		 
		 
 
		 $this->set->div_label(12,'<h6> Detalle de Movimientos<h6>');
		 
		 $this->obj->text->textautocomplete('Articulo',"texto",'articulo',40,45,$datos,'','','div-2-4');
		 
		
		 $evento = ' onClick="InsertaProducto()" ';
		 
		 $cboton1 = 'Referencia <a href="#" '.$evento.' ><img src="../../kimages/cnew.png"/></a>';
		 
		 $this->obj->text->text($cboton1,'texto','idproducto',10,10,$datos ,'','readonly','div-1-2') ;
		 
		 $this->obj->text->text('CodBarra','texto','idbarra',50,50,$datos ,'','','div-1-2') ;
		 
		  
		 
		 echo '<div class="col-md-12">
                             	<div class="alert al1ert-info fade in">
                                		<div id="DivMovimiento"></div>
                                </div>
                  <div id="DivProducto"></div>
                </div>';
		 
		 
		 $this->obj->text->texto_oculto("action",$datos); 
         $this->set->evento_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
     $evento = 'javascript:aprobacion()';
     
     $formulario_impresion = '../../reportes/reporteInv?tipo=50';
     $eventoi = 'javascript:url_comprobante('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/cliente';
     $eventoc = 'javascript:modalVentana('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/proveedor';
     $eventop = 'javascript:modalVentana('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/co_xpagar?transacionID=';
     $eventof = 'javascript:enlace_contabilidad('."'".$formulario_impresion."')";
     
     $formulario_impresion = '../view/importarDetalle';
     $eventoc2 = 'javascript:modalImportar('."'".$formulario_impresion."')";
     
     
     $formulario_impresion = '../view/Productos';
     $eventopp = 'javascript:modalProducto('."'".$formulario_impresion."')";
 
     
     
     
     $ToolArray = array(
         array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
         array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button"),
         array( boton => 'Comprobante Inventarios', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button") ,
         array( boton => 'Ingreso de Producto', evento =>$eventopp,  grafico => 'glyphicon glyphicon-eye-open' ,  type=>"button") ,
         array( boton => 'Detalle Factura', evento =>$eventof,  grafico => 'glyphicon glyphicon-list-alt' ,  type=>"button") ,
         array( boton => 'Importar Detalles', evento =>$eventoc2,  grafico => 'glyphicon glyphicon-list' ,  type=>"button_default") ,
         array( boton => 'Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
         array( boton => 'Proveedor', evento =>$eventop,  grafico => 'glyphicon glyphicon-pawn' ,  type=>"button_default") 
       
         
     );
    
    
    
    
    
    $this->obj->boton->ToolMenuDiv($ToolArray); 
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
    
   //----------------------------------------------
   function ListaValores($sql,$titulo,$campo,$datos){
    
   	$resultado = $this->bd->ejecutar($sql);
   	
   	$tipo = $this->bd->retorna_tipo();
   	
   	$this->obj->list->listadb($resultado,$tipo,$titulo,$campo,$datos,'required','','div-2-4');
 
 
  }    
  //----------------------------------------------
 }    
   $gestion   = 	new componente;
   
   $gestion->Formulario( );
   
   //----------------------------------------------
   //----------------------------------------------
   
?>

<script type="text/javascript">

 jQuery.noConflict(); 
 
 jQuery('#razon').typeahead({
	    source:  function (query, process) {
        return $.get('../model/AutoCompleteCIU.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});
	
 jQuery("#razon").focusout(function(){
	 
	 var itemVariable = $("#razon").val();  
	 
        		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
											data:  parametros,
											url:   '../model/AutoCompleteIDCIU.php',
											type:  'GET' ,
											beforeSend: function () {
												$("#idprov").val('...');
											},
											success:  function (response) {
												$("#idprov").val(response);  // $("#cuenta").html(response);
													  
											} 
									});
	 
    });
 
 //----------------------------------------------
 	jQuery('#articulo').typeahead({
 	 	
 	    source:  function (query, process) {
 	 	    
        return $.get('../model/AutoCompleteProd.php', { query: query }, function (data) {
        		console.log(data);
        		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});

	jQuery("#articulo").focusout(function(){
		 
		 var itemVariable = $("#articulo").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../model/AutoCompleteIDProd.php',
												type:  'GET' ,
												beforeSend: function () {
													$("#idproducto").val('...');
												},
												success:  function (response) {
													$("#idproducto").val(response);  // $("#cuenta").html(response);
														  
												} 
										});
		 
	    });
  
  
  
  
</script>
  