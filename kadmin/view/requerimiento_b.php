<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<title>Plataforma de Gestion Empresarial</title>

	<?php require('Head.php')  ?>

	<link rel="stylesheet" href="../../app/css/sweetalert2.min.css">

	<style type="text/css">
		#mdialTamanio {
			width: 85% !important;
		}

		.col-lg-1,
		.col-lg-10,
		.col-lg-11,
		.col-lg-12,
		.col-lg-2,
		.col-lg-3,
		.col-lg-4,
		.col-lg-5,
		.col-lg-6,
		.col-lg-7,
		.col-lg-8,
		.col-lg-9,
		.col-md-1,
		.col-md-10,
		.col-md-11,
		.col-md-12,
		.col-md-2,
		.col-md-3,
		.col-md-4,
		.col-md-5,
		.col-md-6,
		.col-md-7,
		.col-md-8,
		.col-md-9,
		.col-sm-1,
		.col-sm-10,
		.col-sm-11,
		.col-sm-12,
		.col-sm-2,
		.col-sm-3,
		.col-sm-4,
		.col-sm-5,
		.col-sm-6,
		.col-sm-7,
		.col-sm-8,
		.col-sm-9,
		.col-xs-1,
		.col-xs-10,
		.col-xs-11,
		.col-xs-12,
		.col-xs-2,
		.col-xs-3,
		.col-xs-4,
		.col-xs-5,
		.col-xs-6,
		.col-xs-7,
		.col-xs-8,
		.col-xs-9 {
			position: relative;
			min-height: 1px;
			padding-right: 10px;
			padding-left: 10px;
			font-style: normal;
			font-weight: normal;
			font-size: 13px;
			font-family: "Segoe UI", "Trebuchet MS", sans-serif;
		}

		span.blue {
			background: #5178D0;
			border-radius: 0.8em;
			-moz-border-radius: 0.8em;
			-webkit-border-radius: 0.8em;
			color: #ffffff;
			display: inline-block;
			font-weight: bold;
			line-height: 1.6em;
			text-align: center;
			width: 1.6em;
		}


		.bloque1 {
			display: inline-block;
			font-weight: 400;
			width: 100%;
			color: #ffffff;
			text-align: justify;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: #0090e7 !important;
			padding: 10px;
			line-height: 1;
			border-radius: 1.1875rem;
			-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		}


		.bloque0 {
			display: inline-block;
			font-weight: 400;
			color: #ffffff;
			text-align: justify;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: #ffab00 !important;
			padding: 10px;
			width: 100%;
			line-height: 1;
			border-radius: 1.1875rem;
			-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		}

		.bloque2 {
			display: inline-block;
			font-weight: 400;
			width: 100%;
			color: #ffffff;
			text-align: justify;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: #00d25b !important;
			padding: 10px;
			line-height: 1;
			border-radius: 1.1875rem;
			-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		}

		.bloque3 {
			display: inline-block;
			font-weight: 400;
			width: 100%;
			color: #ffffff;
			text-align: justify;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: #8f5fe8 !important;
			padding: 10px;
			line-height: 1;
			border-radius: 1.1875rem;
			-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		}

		.bloque4 {
			display: inline-block;
			font-weight: 400;
			width: 100%;
			color: #ffffff;
			text-align: justify;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: #fc424a !important;
			padding: 10px;
			line-height: 1;
			border-radius: 1.1875rem;
			-webkit-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			-moz-box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
			box-shadow: 1px 1px 5px 0px rgba(50, 50, 50, 0.32);
		}

		.sidenav_proceso {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #FFFFFF;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 10px;
		}

		.sidenav_proceso a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 12px;
			color: #818181;
			display: block;
			transition: 0.3s;
		}

		.sidenav_proceso a:hover {
			color: #0A0A0A;
		}

		#myModalProductos .modal-dialog {
			max-width: 90%;
			/* Ajuste opcional del ancho */
			max-height: 90vh;
			/* Altura máxima del modal al 90% de la altura de la ventana */
		}

		#myModalProductos .modal-body {
			max-height: 70vh;
			/* Ajusta la altura máxima de la sección del cuerpo */
			overflow-y: auto;
			/* Activa el desplazamiento vertical si es necesario */
		}

		/* altertas */
		.colored-toast.swal2-icon-success {
			background-color: #00d25b !important;
		}

		.colored-toast.swal2-icon-error {
			background-color: #f27474 !important;
		}

		.colored-toast.swal2-icon-warning {
			background-color: #f8bb86 !important;
		}

		.colored-toast.swal2-icon-info {
			background-color: #3fc3ee !important;
		}

		.colored-toast.swal2-icon-question {
			background-color: #87adbd !important;
		}

		.colored-toast .swal2-title {
			color: white;
		}

		.colored-toast .swal2-close {
			color: white;
		}

		.colored-toast .swal2-html-container {
			color: white;
		}
	</style>


	<script language="javascript" src="../js/requerimiento_b.js"></script>

	<script type="text/javascript" src="../../app/bootstrap-wysihtml5/wysihtml5.min.js"></script>

	<script type="text/javascript" src="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.min.js"></script>

	<link href="../../app/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet">

	<link href="tabi.css" rel="stylesheet" type="text/css" />

</head>

<body>



	<div id="main">


		<div class="col-md-12" role="banner">

			<div id="MHeader"></div>

		</div>


		<div id="mySidenav" class="sidenav" style="z-index: 100">

			<div class="panel panel-primary">

				<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>

				<div class="panel-body">

					<div id="ViewModulo"></div>

				</div>

			</div>

		</div>


		<div class="col-md-12">

			<ul id="mytabs" class="nav nav-tabs">

				<li class="active"><a href="#tab1" data-toggle="tab">
						<span class="glyphicon glyphicon-th-list"></span> Lista de Solicitudes</a>
				</li>

				<li><a href="#tab2" data-toggle="tab">
						<span class="glyphicon glyphicon-link"></span> Formulario Orden Bodega </a>
				</li>



			</ul>



			<!-- ------------------------------------------------------ -->
			<!-- Tab panes -->
			<!-- ------------------------------------------------------ -->

			<div class="tab-content">


				<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

					<div class="panel panel-default">

						<div class="panel-body">





							<div class="col-md-2">

								<div id="ViewEstado"></div>

							</div>


							<div class="col-md-10">

								<div id="mySidenav_proceso" class="sidenav_proceso">

									<div id="ViewFormProceso" style="padding:10px"></div>

								</div>


								<div class="col-md-12" id="main_proceso">

									<div class="col-md-12">
										<div id="ViewFormArbol"></div>
									</div>

									<div class="col-md-12">
										<table id="json_variable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th style="background-color: #f8f8f8" width="10%">Nro</th>
													<th style="background-color: #f8f8f8" width="10%">Fecha</th>
													<th style="background-color: #f8f8f8" width="10%">Comprobante</th>
													<th style="background-color: #f8f8f8" width="40%">Detalle/Justificacion</th>
													<th style="background-color: #f8f8f8" width="20%">Modificado</th>
													<th style="background-color: #f8f8f8" width="10%">Acción</th>
												</tr>
											</thead>
										</table>
									</div>

								</div>


							</div>


						</div>

					</div>

				</div>


				<div class="tab-pane fade in" id="tab2" style="padding-top: 3px">

					<div class="panel panel-default">

						<div class="col-md-12">

							<div class="col-md-12" id="main_proceso" style="padding-bottom: 5px;padding-top: 5px">
								<div class="alert alert-success">
									<h4><b>INSTRUCCIONES PARA ELABORAR SOLICITUD DE REQUERIMIENTO DE BODEGA</b></h4> </br>
									<b>Paso 1.-</b> Presione el icono de nuevo y/o agregar registre la informacion y la justificacion del pedido. </br>
									<b>Paso 2.-</b> Guarde la transaccion presionando el icono de guardar.</br>
									<b>Paso 3.-</b> Seleccione los articulos que desea solicitar y envie este requerimiento a la unidad administrativa
									</br></br>
									<b>NOTA:</b></br>
									<p>Las cantidades de los artículos solicitados pueden ser cambiadas por el Guarda Almacén en base a la disponibilidad de los mismos.</p>
								</div>
							</div>

						</div>

						<div class="col-md-12">

							<div id="ViewFormularioTarea"> </div>

							<div class="col-md-12">
								<div id="DivMovimiento"></div>
								<div id="DivProducto"></div>
							</div>

						</div>

					</div>

				</div>





			</div>

		</div>

		<input name="vestado" type="hidden" id="vestado" value="solicitado">
		<input name="bandera2" type="hidden" id="bandera2" value="N">

	</div>


	<div id="FormPie"></div>


	<div class="modal fade" id="myModalDocVisor" role="dialog">

		<div class="modal-dialog" id="mdialTamanio">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Visor de Documento</h4>
				</div>
				<div class="modal-body">

					<embed src="" width="100%" height="450" id="DocVisor">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>

	<!-- MODAL PARA LISTAR INVENTARIO -->
	<div class="modal fade" id="myModalProductos" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-fullscreen" role="document">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Inventario Institucional</h4>
				</div>
				<div>
					<input type="text" class="form-control" id="searchInput" onkeyup="filterTable()" placeholder="Buscar...">
				</div>
				<div class="modal-body" id="listaProductos">
				</div>
				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-danger" onClick="ActualizaProveedor()" data-dismiss="modal">Actualiza Identificacion</button> -->
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		</div>

	</div>

	<script language="javascript" src="../../app/js/sweetalert2@11.js"></script>

</body>

</html>