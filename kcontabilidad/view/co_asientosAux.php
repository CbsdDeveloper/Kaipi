<!doctype html>
<html>
<head>

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
 	<!-- alerta JS -->
	<script type="text/javascript" src="../../kconfig/lib/alertify.js"></script>
 	<link rel="stylesheet" href="../../kconfig/themes/alertify.core.css" />
 	<link rel="stylesheet" href="../../kconfig/themes/alertify.default.css" />
   
 	 		 
</head>
<body>
<div class="well">
  <div class="modal" style="position: relative; top: auto; left: auto; margin: 0 auto; z-index: -3; width: 100%; box-sizing: border-box; display: inline;">
     <div class="modal-dialog" style="left: 0; width: 100%; padding-top: 0; padding-bottom: 10px; margin: 0; color: rgba(0,0,0,1);">
       <div class="modal-content">
        <div class="modal-header">
          
      		 <div class="modal-body"> 
		         <!-- pantalla de gestión -->
        		   <div class="tabbable tabbable-custom">
          			 <div class="row">
            			<!-- Contenido de Pantalla  -->
               			<div class="col-md-12">
                      	 <div class="panel panel-default">
						  <div class="panel-body" > 
							  <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                        	<thead>
                                                                <tr>
                                                                  <th width="5%">Id</th>
																<th width="8%">Fecha</th>
																<th width="10%">Comprobante</th>
																<th width="30%">Detalle</th>
																<th width="25%">Referencia</th>
																<th width="5%">Tipo</th>
																<th width="10%">Modulo</th>
																<th width="17%">Acción</th>
                                                                </tr>
															</thead>
                                                    	</table>
                     		 <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal">
                     		 <span class="glyphicon glyphicon-filter"></span>  Filtrar Datos</button>
                        
                       </div>  
                     </div> 
                </div>
                      
        </div>
    </div>
</div>
 <!-- pantalla de gestión -->
</div><!-- /.modal-content -->
  </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
         </div><!-- /.modal -->
              </div> <!-- /.well --> 
                         
 </body>
</html>