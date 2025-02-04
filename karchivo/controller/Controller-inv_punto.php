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

   		 	       jQuery( "#result" ).fadeOut( 500 );

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
                
				$this->formulario = 'Model-inv_factura.php'; 
				
                $this->evento_form = '../model/'.$this->formulario;        
      }
     //---------------------------------------
     function Formulario( ){
      
    
         
       $datos = array();
       

       $tipo = $this->bd->retorna_tipo();
 
         
       $this->set->_formulario( $this->evento_form,'inicio' ); // activa ajax para insertar informacion
  
 
 
 	     
       $ACaja = $this->bd->query_array('par_usuario',
            'caja, supervisor, url,completo,tipourl',
            'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        $this->BarraHerramientas($ACaja['caja']);
        
        echo '<div class="col-md-8">  
                <div class="col-md-12">';
         
                  //          $this->set->div_label(12,'2. DETALLE DE ARTICULOS PARA FACTURACION ');
                    
                            $evento = ' onClick="InsertaProducto()" ';
                    
                            $cboton1 = ' <a href="#" '.$evento.' title="Agregar Articulo"><img src="../../kimages/if_cart_add.png" align="absmiddle"/></a>';
                    
                            $this->obj->text->textautocomplete($cboton1,"texto",'articulo',100,100,$datos,'','','div-2-6');
                            
                            $this->obj->text->texto_oculto("idproducto",$datos); 
                    
                            $evento =  ' ';
                            $this->obj->text->texte('','texto','idbarra',30,30,$datos ,'','',$evento,'div-0-4') ;
        
           echo  '<div id="DivMovimiento"> </div> 
                  <div id="DivProducto"> </div>
                    <div class="col-md-12"> 
                         <div class="alert alert-warning"> 
                            <div class="row"> 
                         <div id="ver_pago" align="center"  style="font-size: 34px;font-weight: bold;">$</div> 
                        <h4 align="center" id="div_sucambio"></h4> 

                        <div id="okCliente"> </div>

                      </div> </div> </div>
                  </div>
                     </div>';
        
           echo '<div class="col-md-4">
                  <div class="col-md-12" align="center"><div class="alert alert-info">
                        <div class="row">';
           
           $this->obj->text->textautocomplete('Identificacion','texto','idprov',13,13,$datos ,'',' ','div-3-9') ;
           
           $evento1 = ' onClick="LimpiarCliente()" ';
           $cboton2 = ' <a href="#" '.$evento1.' title="Limpiar Informacion">Cliente   <img src="../../kimages/cdel.png" align="absmiddle"/></a>';
           
           $this->obj->text->textautocomplete($cboton2,"texto",'razon',40,45,$datos,'','','div-3-9');
                   
                       $evento = ' onClick="ActualizaCliente()" ';
                       $cboton1 = '<a href="#" '.$evento.' title="Actualizar Cliente">Email <img src="../../kimages/okk.png" align="absmiddle"/></a>';
                       
                       $this->obj->text->text($cboton1,'texto','correo',120,120,$datos ,' ','','div-3-9') ;
                       
                     
                     
           echo       '</div></div></div>';
        
           echo '<div class="col-md-12">
                     <div class="alert alert-info">
                        <div class="row">';
        
                       echo '<ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Forma Pago</a></li>
                                <li><a data-toggle="tab" href="#menu1">Factura Emitida</a></li>
                                <li><a data-toggle="tab" href="#menu2">Bodegas Disponibles</a></li>
                             </ul>  
                            <div class="tab-content">
                                  <div id="home" class="tab-pane fade in active">';
                                  $this->Formulario_pago();
                                  
                           echo ' <div id="FacturaElectronica"  align="center"> </div>
                                   <div id="ver_factura"  align="center"></div>
                                 </div>';
        
                          echo '<div id="menu1" class="tab-pane fade">';
                          
                          $this->obj->text->text('Fecha','date','fecha',10,10,$datos ,'required','','div-2-10') ;
                          
                          $this->obj->text->text('Transaccion','number','id_movimiento',10,10,$datos ,'','readonly','div-2-10') ;
                          
                          $this->obj->text->text('Factura','texto','comprobante',10,10,$datos ,'','readonly','div-2-10') ;
                          
                          echo '</div>
                                <div id="menu2" class="tab-pane fade">';
                      
                          
                          $resultado = $this->bd->ejecutar("select idbodega as codigo, nombre
                                                                from view_bodega_permiso
                                                                where registro =". $this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                                       sesion=". $this->bd->sqlvalue_inyeccion($this->sesion,true)
                              );
           
                          $evento2 =' OnChange="AsignaBodega();"';
                          
                          $this->obj->list->listadbe($resultado,$tipo,'Bodega','idbodega',$datos,'','',$evento2,'div-2-10');
                          
                           
                          $evento = '';
                          
                     
                          
                          $MATRIZ = array(
                              'Normal'    => ' [ Normal ]',
                              'PorMayor'    => ' Al Por Mayor',
                              'efectivo'    => ' Pago Con Efectivo',
                              'minorista'    => ' Distribuidor Minorista',
                              'mayorista'    => ' Distribuidor Mayorista',
                              'VentaTarjeta'    => ' Venta Con Tarjeta',
                              'VentaComision'    => ' Venta Comision',
                          );
                          
                          $this->obj->list->listae('Precio',$MATRIZ,'tipoprecio',$datos,'required','',$evento,'div-2-10');
                          
        
                          
                          echo '</div></div></div></div>';
                      
     
 
         $this->obj->text->texto_oculto("estado",$datos); 
		 $this->obj->text->texto_oculto("action",$datos); 
         
          
 
       $this->set->_formulario('-','fin'); 
      
   }
 //----------------------------------------------
 function BarraHerramientas($autoriza){
   
   
     if ( $autoriza == 'S') {
       
             $formulario_impresion = '../view/cliente';
             $eventoc = 'javascript:openView('."'".$formulario_impresion."')";
         
         
             $evento = 'javascript:aprobacion()';
             
             $formulario_impresion = '../../reportes/reporteInv?tipo=51';
             $eventop = 'javascript:url_comprobante('."'".$formulario_impresion."')";
             
             $titulo = '<b><span style="font-size: 16px">[ 1 ]</span></b>';
             
             
             $eventof = "javascript:goToURLElectronicoTool(1)";
             
             $eventog = "javascript:goToURLElectronicoActualiza(1)";
             
               
             $ToolArray = array(
                 array( boton => 'Nuevo Regitros',    evento =>'', grafico => 'icon-white icon-plus' ,  type=>"add"),
                 array( boton => 'Guardar Registros', evento =>'', grafico => 'glyphicon glyphicon-floppy-saved' ,  type=>"submit") ,
                 array( boton => 'Aprobar Movimientos',  evento =>$evento,  grafico => 'glyphicon glyphicon-ok' ,  type=>"button_danger"),
                 array( boton => 'Impresion Factura', evento =>$eventop,  grafico => 'glyphicon glyphicon-print' ,  type=>"button_default") ,
                 array( boton => 'Lista de Clientes', evento =>$eventoc,  grafico => 'glyphicon glyphicon-user' ,  type=>"button_default") ,
                 array( boton => 'Emitir Factura Electronica', evento =>$eventof,  grafico => 'glyphicon glyphicon-globe' ,  type=>"button_success") ,
                 array( boton => 'Descargar Factura Electronica', evento =>$eventog,  grafico => 'glyphicon glyphicon-download-alt' ,  type=>"button_default")
             );
             
             $this->obj->boton->ToolMenuDivTitulo($ToolArray,$titulo); 
     
      }else{
          echo '<b>NO SE ENCUENTRA ASIGNADO COMO CAJERO(A)...</b>';
      }
    
    
    
    
   
  }  
  //----------------------------------------------
   function header_titulo($titulo){
          $this->set->header_titulo($titulo);
   }  
   //------------------------
   function Formulario_pago(){
    
       $datos = array();
       
       $tipo = $this->bd->retorna_tipo();
       
       $MATRIZ = array(
           '0'    => 'Factura',
           '9'    => 'Ingreso a Caja'
       );
       
       $this->obj->list->listae('',$MATRIZ,'carga',$datos,'required','','','div-2-10');
       
       $MATRIZ = array(
           '-'    => ' [ Seleccione Forma de Pago ] ',
           'contado'    => 'Contado',
           'credito'    => 'Cuenta X Cobrar(Credito)'
       );
       
       $evento = 'onChange="FormaPago_tipo(this.value)"';
       
       $this->obj->list->listae('Pago',$MATRIZ,'formapago',$datos,'required','',$evento,'div-2-10');
       
       $MATRIZ = array(
           'efectivo'    => 'Efectivo',
           'cheque'    => 'Cheque',
           'tarjeta'    => 'Tarjeta',
       );
       
       $evento = 'onChange="tipopagoshow(this.value)"';
       
       $this->obj->list->listae('Tipo',$MATRIZ,'tipopago',$datos,'required','',$evento,'div-2-10');
       
       $evento = 'onkeyup="cambio_dato(this.value)"';
       
       $this->obj->text->textLong('Pagar',"number",'efectivo',15,15,$datos,'','',$evento,'div-2-10');
       
     
       
       
       $this->obj->text->texte('Nro.Cuenta','texto','cuentaBanco',30,30,$datos ,'','','','div-2-10') ;
       $evento = '';
       
       $sql ="SELECT idcatalogo as codigo, nombre
                FROM  par_catalogo
               WHERE  tipo = 'bancos'"   ;
       
       $resultado = $this->bd->ejecutar($sql);
       
       $this->obj->list->listadbe($resultado,$tipo,'Institucion','idbanco',$datos,'','',$evento,'div-2-10');
       
       
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


jQuery('#idprov').typeahead({
	    source:  function (query, process) {
  return $.get('../model/AutoCompleteIDCedula.php', { query: query }, function (data) {
  		console.log(data);
  		data = $.parseJSON(data);
	            return process(data);
	        });
	    } 
	});



$("#razon").focusin(function(){
	 
	 		    var itemVariable = $("#razon").val();  
	 
     		var parametros = {
											"itemVariable" : itemVariable 
									};
									 
									$.ajax({
										    type:  'GET' ,
											data:  parametros,
											url:   '../model/AutoCompleteIDMultiple.php',
											dataType: "json",
											success:  function (response) {

	 											
													 $("#idprov").val( response.a );  
													 
													 $("#correo").val( response.b );  
													  
											} 
									});
	 
 });


$("#idprov").focusin(function(){
	 
	    var itemVariable = $("#idprov").val();  

		var parametros = {
									"itemVariable" : itemVariable 
							};
							 
							$.ajax({
								    type:  'GET' ,
									data:  parametros,
									url:   '../model/AutoCompleteIDMultipleID.php',
									dataType: "json",
									success:  function (response) {

										
											 $("#razon").val( response.a );  
											 
											 $("#correo").val( response.b );  
											  
									} 
							});

});

 jQuery("#idbarra").keypress(function(e) { var code = (e.keyCode ? e.keyCode : e.which); 
	if(code == 13){ 
		inserta_dfacturacodigo();
		return false; 
		} 
});

  
 //---------------------------------------------- focusin focusout
 
 
  jQuery('#articulo').typeahead({
 	    source:  function (query, process) {
        return $.get('../model/AutoCompleteProdFac.php', { query: query }, function (data) {
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
												url:   '../model/AutoCompleteIDProd.php',
												type:  'GET' ,
												beforeSend: function () {
														$("#idproducto").val('...');
												},
												success:  function (response) {
														 $("#idproducto").val(response);  // $("#cuenta").html(response);

														   if  (response > 0 ){
													    	  InsertaProducto();
													      }     
														 
												} 
										});
		 
	    });
  

  
  
  
</script>
 
  