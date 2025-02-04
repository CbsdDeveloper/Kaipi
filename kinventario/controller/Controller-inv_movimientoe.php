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
            dataType: 'json',  
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
				
            	  jQuery('#result').html(data.resultado);
 				  jQuery( "#result" ).fadeOut( 1600 );
 			 	  jQuery("#result").fadeIn("slow");

 			 	  jQuery("#action").val(data.accion); 
 			 	  jQuery("#id_movimiento").val(data.id );

 			 	  jQuery("#estado").val(data.estado); 
 			 	  jQuery("#comprobante").val(data.comprobante );
 			 	  
 			 	  DetalleMov(data.id,data.accion);
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
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
				$this->formulario = 'Model-inv_movimientoe.php'; 
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
         
        $tipo = $this->bd->retorna_tipo();
         
        $datos = array();
         
 
         
        $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
   
  		
        $this->BarraHerramientas();
        
        $tipo = $this->bd->retorna_tipo();
        
        $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                            from view_bodega_permiso
                                            where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                   sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)." order by 1"
            );
         
        
        $this->obj->list->listadb($resultado,$tipo,'Bodega','idbodega',$datos,'','','div-2-10');
        
 
        $MATRIZ = array(
            'E'    => 'Egreso'
        );
        
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
		    'Egreso Bodega'    => 'Egreso Bodega',
		    'traslado bodega'    => 'Traslado Bodega',
		    'devolucion'    => 'devolucion',
		    'donacion'    => 'donacion' ,
		    'nota credito'    => 'Nota de Credito'  
		);
		$this->obj->list->listae('Transaccion',$MATRIZ,'transaccion',$datos,'required','',$evento,'div-2-4');
		
		
		$this->obj->text->text('Documento','texto','documento',30,30,$datos ,'required','','div-2-4') ;
		
	
		 $this->obj->text->textautocomplete('Responsable',"texto",'razon',40,45,$datos,'required','','div-2-4');

		 $this->obj->text->text('Identificacion','texto','idprov',10,10,$datos ,'','readonly','div-2-4') ;
		 
		 
		 
		 $resultado = $this->bd->ejecutar("select 0 as codigo, '[ No aplica ]' as nombre  union 
                                          select id_departamento as codigo, nombre  
                                            from nom_departamento
                                            where  estado=". $this->bd->sqlvalue_inyeccion('S',true).' order by 2'
		     );
		 
		 
		
		 
		 $this->obj->list->listadb($resultado,$tipo,'Solicita','id_departamento',$datos,'','','div-2-4');
	 		 
		 
 
		 $this->set->div_label(12,'<h6> Detalle de Movimientos<h6>');
		 
		 $this->obj->text->textautocomplete('Busqueda Articulo',"texto",'articulo',40,45,$datos,'','','div-0-6');

         $this->obj->text->text_blue('Codigo Articulo','texto','idproducto',10,10,$datos ,'','','div-0-3') ;
		 
		 echo '<div class="col-md-3"  style="padding-bottom: 10px;padding-top: 10px">';
								 
	    	 $evento = ' onClick="InsertaProducto()" ';
		 
		      $cboton1 = ' <a href="#" class="btn btn-warning btn-sm" role="button" '.$evento.' > <span class="glyphicon glyphicon-plus"></span> Agregar</a>';
		   
              echo  $cboton1 ;
             
  		 echo '	</div>';
		 
		 
		 $this->obj->text->texto_oculto("action",$datos); 
		 
		 $this->set->_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas(){
   
     $evento = 'javascript:aprobacion()';
     
     $formulario_impresion = '../../reportes/comprobanteInventariose?idc=1';
     $eventoi = 'javascript:url_comprobante('."'".$formulario_impresion."')";
     
  
     
     $formulario_impresion = '../view/proveedor';
     $eventop = 'javascript:modalVentana('."'".$formulario_impresion."')";
     
    
     $eventoc3 ='javascript:RevertirDatos()';
     
     $ToolArray = array(
         array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
         array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
         array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
         array( boton => 'Comprobante Inventarios', evento =>$eventoi,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
         array( boton => 'Usuarios Externos', evento =>$eventop,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
         array( boton => 'Revertir Movimiento Transaccion', evento =>$eventoc3,  grafico => 'glyphicon glyphicon-warning-sign' ,  type=>"button_default") ,
         
         
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
													$("#idproducto").val(response);   
														  
												} 
										});
		 
	    });
  
  
  
  
</script>
  