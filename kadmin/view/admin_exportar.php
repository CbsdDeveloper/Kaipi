<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
		<link href="../../app/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="../../app/css/jquery-ui.min.css" type="text/css" />
      
    <link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
   
   <link rel="stylesheet" href="../../app/dist/css/bootstrap.min.css" />
    
   <link rel="stylesheet" href="../../app/dist/css/dataTables.bootstrap.min.css" />
                          
   <link rel="stylesheet" href="../../app/themes/alertify.core.css" />
 	
   <link rel="stylesheet" href="../../app/themes/alertify.default.css" />    
      
   
   <script type="text/javascript" src="../../app/js/jquery-1.10.2.min.js"></script>
	
	<script>
		
		function realizaProceso(tabla){
 
				 var parametros = {
							"tabla" : tabla,
							"action" : 'tabla'
					};
					$.ajax({
							data:  parametros,
							url:   '../model/a_exportar',
							type:  'post',
							beforeSend: function () {
									$("#resultado").html("Procesando, espere por favor...");
							},
							success:  function (response) {
									$("#resultado").html(response);
							}
					});
	 }
 </script>
</head>
<body>
 
	<div style="padding: 50px">
                     
                     <form action="../model/a_exportar" method="post" target="_blank" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
						 <h4> Exportar datos </h4> 
                  	   	
                       <select name="tabla" class="form-control" onChange="realizaProceso(this.value)" id="tabla" title="tabla">
						   <option value="-">Seleccionar tabla de informacion a generar</option>
                           <option value="co_asiento-id_asiento">co_asiento</option>
                           <option value="co_asiento_aux-id_asiento_aux">co_asiento_aux</option>
                           <option value="co_asientod-id_asientod">co_asientod</option>
						   <option value="co_periodo-id_periodo">co_periodo</option>
                           <option value="co_compras-id_compras">co_compras</option>
                           <option value="co_compras_f-id_compras"> co_compras_f</option>
                           <option value="co_plan_ctas-cuenta">co_plan_ctas</option>
						   <option value="co_ventas-id_ventas">co_ventas</option>
 						    <option value="inv_movimiento-id_movimiento">inv_movimiento</option>
						    <option value="inv_movimiento_det-id_movimientod">inv_movimiento_det</option>
						    <option value="inv_fac_pago-idfacpago">inv_fac_pago</option>
						    <option value="par_ciu-idprov">par_ciu</option>
						    <option value="web_producto-idproducto">web_producto</option>
						    <option value="web_categoria-idcategoria">web_categoria</option>
						   <option value="web_categoria_var-idcategoriavar">web_categoria_var</option>
                       </select>
                          <br>  <br>
						 (Limit) numero de registros
						 <input name="limite1" type="text" id="limite1" title="limite inicial" value="1000" size="20" maxlength="20" placeholder="numero de registros">
						  <br><br>
						 (offset) desde que numero de registro
						 <input name="limite2" type="text" id="limite2" title="limite Final" value="0" size="12" maxlength="12" placeholder="desde el registro">
						 <br><br><br>
	                  <input type="hidden" id="action" value="add" name="action">
						 
						  <br><br><br>
						  <div id='resultado'> </div>
						 
						 
								 
                     <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-floppy-saved"></span> Generar informacion  </button>

      </form>
		
  </div> 
 
</body>
</html>
 