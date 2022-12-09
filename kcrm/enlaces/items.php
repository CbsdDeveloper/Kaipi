<?php	
session_start( ); 	
require 'SesionInicio.php'; 
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
	<script>
		
 $(document).ready(function(){
	
	$('#articulo').typeahead({
 	    source:  function (query, process) {
				return $.get('../../kinventario/model/AutoCompleteProd.php', { query: query }, function (data) {
						console.log(data);
						data = $.parseJSON(data);
						return process(data);
					});
	    } 
	});
	//-------------------------------
	$("#articulo").focusout(function(){
		 
				    var itemVariable = $("#articulo").val();  
		 
	        		var parametros = {
												"itemVariable" : itemVariable 
										};
										 
										$.ajax({
												data:  parametros,
												url:   '../../kinventario/model/AutoCompleteIDProd.php',
												type:  'GET' ,
												beforeSend: function () {
													$("#idproducto").val('...');
												},
												success:  function (response) {
													$("#idproducto").val(response);   
														  
												} 
										});
		 
	    });
	
		var tramite = getParameterByName('task');
	 
	 	DetalleMov(tramite,'edit');
	 
	 
	 }); 
//----------------
/**
 * @param String name
 * @return String
 */
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}	
//-----------------------------------------		
function SeleccionBodega(valor)
{
	 var parametros = {
			 "idbodega" : valor 
	 };
										 
										$.ajax({
												data:  parametros,
												url:   '../../kinventario/model/ajax_bodega.php',
												type:  'GET' ,
 												success:  function (dato) {
													$("#bodega_selecciona").html(dato);   
												} 
										});
	
} 		
	 
function InsertaProducto()
{

	var tramite       = $('#tramite').val();
	
 	var idproducto    = $('#idproducto').val();
 	
	if (idproducto){
			
						var parametros = {
								"idproducto" : idproducto ,
				                "tramite" : tramite ,
 				                "accion" : 'add' 
						};
				          
						  $.ajax({
								data:  parametros,
								url:   '../../kinventario/model/Model-addproducto_proceso.php',
								type:  'GET' ,
								success:  function (data) {
									
										 $("#bodega_selecciona").html(data);  
										 
										  DetalleMov(tramite,'edit');
										  
								} 
						}); 
				//-----------------
 				  $('#idproducto').val('');
		
 				  $('#articulo').val('');
						  
			 	  
		}	
	 else{
	
		alert('Guarde información de la solicitud');

	}
 
}
 
//------------------
function DetalleMov(tramite,accion1)
{
 
    var parametros = {
             'id' : tramite,  
             'accion': accion1
     };
    
	$.ajax({
 			url:   '../../kinventario/controller/Controller-inv_movimientoDet_proceso.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#DivMovimiento").html('Procesando');
				},
			   success:  function (data) {
					 $("#DivMovimiento").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}		
//--------------------
function calcular(id) {
    
	
	var estado 			= 'digitado';
 	var ingreso_egreso 	= 'E';
	/// COSTO
	var objeto 					 =  '#costo_' + id;
	var costo 					 = $(objeto).val();
	var	lcosto                   = parseFloat (costo).toFixed(4);

	//------------------------------------------------------------
	objeto 			=  '#saldo_' + id;
	var sal1 		=  $(objeto).val();
	var saldo 		=  parseFloat (sal1).toFixed(2);
	
	objeto 			=   '#cantidad_' + id;
	var cantidad 	=   $(objeto).val();
	var cantidad 		=  parseFloat (cantidad).toFixed(2);
 

	objeto 				=  '#tipo_' + id;
	var tipo_mov1 		= $(objeto).val();
	var tipo_movimiento = $.trim(tipo_mov1);
	
 
	if(parseInt(cantidad) > parseInt(saldo)){
		
		  alert('Saldo No Disponible');
 		  objeto =  '#cantidad_' + id;
 		  $(objeto).val(0);
 		  
	}else{
		
		 
		    baseiva     =   0 ;
		    monto_iva   =   0;
		    
			tarifa_cero 	=   lcosto * cantidad	;
 			tempBase  		=   lcosto * cantidad;
			total 			=   parseFloat (tempBase).toFixed(2);
		 
			objeto =  '#total_' + id;
			total = parseFloat (total).toFixed(2);
			$(objeto).val(total);
			
			guarda_detalle(baseiva,monto_iva,tarifa_cero,cantidad,total,estado,ingreso_egreso,id,0,0);
			
			
	}
 
 
    
}		
//------------------------------------
function guarda_detalle(baseiva,monto_iva,tarifa_cero,lcantidad,total,estado,ingreso_egreso,id,p1,descuento)
{
  
 
 
	 
	var parametros = {
 			"baseiva" : baseiva  ,
			"monto_iva" : monto_iva,  
			"tarifa_cero" : tarifa_cero  ,
			"lcantidad" : lcantidad  ,
			"total" : total  ,
			"ingreso_egreso": ingreso_egreso,
 			"id" : id ,
 			"p1": 0,
 			"descuento":0	
	};
	
 
		
 
		
			$.ajax({ 
		 			url:   '../../kinventario/model/Model-editproductoe.php',
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#DivProducto").html('Procesando');
						},
					success:  function (data) {
							 $("#DivProducto").html(data);   
						
						      
						} 
			});
	
 

}	
//----------------------
		
function EliminarDet(id) {
	 
	var tramite 	  = $('#tramite').val();
 	var estado    	  = $('#estado').val();
	
	if (id){
 		var parametros = {
				"id" : id ,
                "accion" : 'eliminar' ,
                "tramite": tramite 
		};
	   
		$.ajax({
				data:  parametros,
			    url:   '../../kinventario/model/Model-addproducto_proceso.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#DivProducto").html(data);  
						 DetalleMov(tramite,'edit');
				} 
		}); 
			
		 	 $('#idproducto').val('');
			 $('#articulo').val('');

	}else{
	
		alert('No se puede eliminar');

	}
}	
		
		
</script>	
	
</head>
<body>
  
                     
                       
                  	   <div class="col-md-12" align="center" style="padding:5px"><h4><b>Selección de Artículos</b></h4></div>
                       
                                   <?php  
 									  $tipo      = $bd->retorna_tipo();
	
 									  $resultado = $bd->ejecutar("select 0 as codigo, '- Seleccione Bodega - ' nombre union 
									  							  select idbodega as codigo, nombre
																			from view_bodega where activo = 'S'
																		    group by idbodega, nombre order by 1"
											);
	
									 $evento = " Onchange='SeleccionBodega(this.value)'";
 									 $obj->list->listadbe($resultado,$tipo,'Seleccione Bodega','idbodega',$datos,'','',$evento,'div-2-10');
	
 								  
 		 
									  $obj->text->textautocomplete('Buscar Articulo',"texto",'articulo',40,45,$datos,'','','div-2-4');
 		
									  $evento = ' onClick="InsertaProducto()" ';
									  $cboton1 = 'Agregar Articulo <a href="#" '.$evento.' ><img src="../../kimages/cnew.png" align="absmiddle" /></a>';
	
		 							  $obj->text->text($cboton1,'texto','idproducto',10,10,$datos ,'','readonly','div-2-4') ;
                			 		
						 			?>
						 
						 
						 			<input type="hidden" id="id_movimiento" name="id_movimiento">
						 			<input type="hidden" id="tramite" name="tramite" value="<?php echo $_GET["task"]; ?>"> 
								    <input type="hidden" id="accion" name="accion"  value="<?php echo $_GET["accion"]; ?>">
						 
						  		   
					 
	
								    <div id="DivMovimiento"  class="col-md-12"> </div> 
 	
									<div id="bodega_selecciona" align="center" style="padding: 5px"  class="col-md-12"> </div> 
						 
						 
								   <div style="padding-top:25px;" align="center" class="col-md-12">
 									   
										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cerrar Pantalla </button>
 
								 </div> 
    
                 
 
 
</body>
</html>
 