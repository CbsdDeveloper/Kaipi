<!DOCTYPE html>
<html lang="en"><head>
<?php  
   session_start( );  
?>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<title>Plataforma de Gestión Empresarial</title>
 
 <link href="../app/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Theme -->
	<link href="../app/assets/css/plugins.css" rel="stylesheet" type="text/css" />

	<link href="../app/assets/css/responsive.css" rel="stylesheet" type="text/css" />

	<link href="../app/assets/css/icons.css" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" href="../app/assets/css/fontawesome/font-awesome.min.css"/>

	<!-- Ionicons -->
	<link href="../app/ionicons.min.css" rel="stylesheet" type="text/css" />

	<!--=== JavaScript ===-->
 	
 	<script type="text/javascript" src="../app/assets/js/libs/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="../app/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>

	<script type="text/javascript" src="../app/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../app/assets/js/libs/lodash.compat.min.js"></script>

	<!-- General 
	<script type="text/javascript" src="../app/assets/js/libs/breakpoints.js"></script>
	<script type="text/javascript" src="../app/plugins/respond/respond.min.js"></script> <!-- Polyfill for min/max-width CSS3 Media Queries (only for IE8) -->
	<script type="text/javascript" src="../app/plugins/cookie/jquery.cookie.min.js"></script>
	<script type="text/javascript" src="../app/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<script type="text/javascript" src="../app/plugins/slimscroll/jquery.slimscroll.horizontal.min.js"></script>

	<!-- DataTables -->
	<script type="text/javascript" src="../app/plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="../app/plugins/datatables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="../app/plugins/datatables/bootstrap-table.js"></script>
   
    
  <!-- 
	Page specific plugins -->
	<!-- Charts -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="plugins/flot/excanvas.min.js"></script>
	<![endif]-->
	<script type="text/javascript" src="../app/plugins/sparkline/jquery.sparkline.min.js"></script>
	<script type="text/javascript" src="../app/plugins/flot/jquery.flot.min.js"></script>
	<script type="text/javascript" src="../app/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script type="text/javascript" src="../app/plugins/flot/jquery.flot.resize.min.js"></script>
  
	<!-- Noty -->
	<script type="text/javascript" src="../app/plugins/noty/jquery.noty.js"></script>
	<script type="text/javascript" src="../app/plugins/noty/layouts/top.js"></script>
	<script type="text/javascript" src="../app/plugins/noty/themes/default.js"></script>

	<!-- Forms -->
	<script type="text/javascript" src="../app/plugins/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="../app/plugins/select2/select2.min.js"></script>

	<!-- App -->
	<script type="text/javascript" src="../app/assets/js/app.js"></script>
	<script type="text/javascript" src="../app/assets/js/plugins.js"></script>
	<script type="text/javascript" src="../app/assets/js/plugins.form-components.js"></script>

 	<link rel="stylesheet" type="text/css" href="../js/default/easyui.css">
 	<script type="text/javascript" src="../js/jquery.easyui.min.js"></script>
 	
	<link rel="stylesheet" href="../app/plugins/datatables/bootstrap-table.css"/>
 	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
 
 	<link rel="stylesheet" href="../app/plugins/datatables/jquery.dataTables.css" />
 	<link href="../app/bootstrap/bootstrap.css" rel="stylesheet" type="text/css" />
 	<link rel="stylesheet" href="../app/bootstrap/css/jquery-ui.min.css" type="text/css" />
 	

    <!-- inicio de pantalla para ejecución -->
  	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
 	<script src="../app/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
 	<script type="text/javascript" src="http://getbootstrap.com/dist/js/bootstrap.js"></script>
 	<script type="text/javascript" src="../js/kaipi.js"></script> 
 	<script type="text/javascript" src="../js/inv_precios.js"></script> 
 	<!-- alerta JS -->
	<script type="text/javascript" src="../../kconfig/lib/alertify.js"></script>
 	<link rel="stylesheet" href="../../kconfig/themes/alertify.core.css" />
 	<link rel="stylesheet" href="../../kconfig/themes/alertify.default.css" />
 
 
</head>
  
</head>

<body>
  <div class="well">  
  
        <div class="modal-content">

        	<div class="modal-body"> 
                     
                      <form action="View-inv_precios?action=add" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                      
                  	   <div style="padding-top: 5px;" class="col-md-12"><h5> Actualizar Precio de Venta</h5></div>
                       			  <div style="padding-top: 5px;" class="col-md-2"> Nro.Producto</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="idproducto"  type="text" required="required"  class="form-control required" id="idproducto" readonly> 
                                   </div> 
                                  <div style="padding-top: 5px;" class="col-md-2"> Detalle</div>  
                                  <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="detalle"  type="text" required="required"  class="form-control required" id="detalle" > 
                                   </div> 
								   <div style="padding-top: 5px;" class="col-md-2"> Precio Venta</div> 
                                   <div style="padding-top: 5px;" class="col-md-4">
                                        <input name="monto"  type="number" step='0.01' value='0.00' placeholder='0.00' required="required"   class="form-control required" id="monto"> 
                                   </div> 
                   				   <div style="padding-top: 5px;" class="col-md-2"> Principal</div> 
									 <div style="padding-top: 5px;" class="col-md-4"> 
											<select name="principal"  class="form-control required"  required="required" id="principal">
											   <option value="S">Si</option>
											   <option value="N">No</option>
											</select>
									 </div>   
                                    <div style="padding-top: 5px;" class="col-md-2"> Activo</div> 
								   <div style="padding-top: 5px;" class="col-md-4">
											<select name="activo"  class="form-control required"  required="required" id="activo">
											   <option value="S">Si</option>
											   <option value="N">No</option>
											</select>
								   </div>  
                                   <div style="padding-top: 5px;" class="col-md-12">
                             			<button type="submit" class="btn btn-success btn-sm">
                            			<span class="glyphicon glyphicon-floppy-saved"></span> Guardar  </button>
 
										<button type="button" onClick="window.close();" class="btn btn-primary btn-sm">
										<span class="glyphicon glyphicon-log-out"></span> Cancelar </button>
 
					    		 </div> 
                     </form>
      </div>
   </div>
 </div> 
</body>
</html>
<?php  

  session_start( );  
  
   
   require 'SesionInicio.php';

   
   if (isset($_GET['action']))	{
           $action = $_GET['action'];
	   		if ($action == 'add'){
				Agregar($obj,$bd,$set );
			}  
            
     }  
	
   /*-----------------------------------------------------------------------------
  -------------------------------------------------------------------------------*/
   function Agregar($obj,$bd,$set  ){

			$id = @$_POST["idproducto"];
			
	         $InsertQuery = array(   
                                    array( campo => 'id_producto',   valor => @$_POST["idproducto"]),
                                    array( campo => 'monto',   valor => @$_POST["monto"]),
                                    array( campo => 'activo',   valor => @$_POST["activo"]),
                                    array( campo => 'detalle',   valor => @$_POST["detalle"]),
                                    array( campo => 'principal',   valor => @$_POST["principal"])
                                );
 
                                    
          $bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);

  		  DivPrecio('#precio_grilla','../model/Model-ajax_precio.php?id='.$id);
  
 	 	  $obj->var->kaipi_cierre_pop();

 }
 
 function DivPrecio($div,$url ){
 
  echo '<script type="text/javascript">';
  echo "  opener.$('".$div."').load('".$url."');   ";
  echo '</script>';  
 
  } 
 
?>
 