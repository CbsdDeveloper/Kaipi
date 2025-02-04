<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<title>Plataforma de Gestión Empresarial</title>
	<link rel="stylesheet" href="../view/lib/css/estilos.css">
	<?php require('Head.php')  ?>


	<script type="text/javascript" src="../js/modulo.js"></script>

	<!-- <style>
		#mdialTamanio {
			width: 75% !important;
		}

		resumen {
			border-collapse: collapse;
			width: 100%;
			font-size: 14px;
			text-align: center;
		}

		.resumen_td {
			padding-top: 6px;
			text-align: center;
			font-size: 10px;
			color: #FFFFFF
		}

		.resumen_tt {
			padding-bottom: 10px;
			padding-top: 1px;
			text-align: center;
			font-size: 22px;
			font-weight: 700;
			color: #FFFFFF
		}
	</style> -->

</head>

<body>

	<div id="main">

		<div class="col-md-12" role="banner">
			<div id="NavMod"></div>
		</div>

		<div id="mySidenav" class="sidenav">
			<div class="panel panel-primary">
				<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">GESTIÓN EMERGENCIAS</div>
					<div class="panel-body">
						<!-- <div class="container"> -->
							<div class="top-bar">
								<!-- añadir formulario -->
								<a href="../view/formulario_incidentes" class="btn blue cuadrado"><i class="fa fa-plus"></i> Crear Nuevo Registro</a>

								<!-- Formulario para subir archivos -->
								<!-- <form id="uploadForm" enctype="multipart/form-data" method="POST" action="tu_script_de_subida.php">
									<label class="btn green cuadrado" for="file-upload">
										<i class="fa fa-lg fa-upload"></i>
									</label>
									<input id="file-upload" type="file" name="file" accept=".sci,.zip" style="display: none;" />
								</form> -->
							</div>
							<hr>
							<!-- Tabla -->
							<table id="ViewIncidentes" class="ViewIncidentes" width="100%" border="0" cellspacing="0" cellpadding="0">
								<thead>
									<tr>
										<th>Codigo</th>
										<th>Nombre del Incidente</th>
										<th>Inicio</th>
										<th>Fin</th>
										<th>Estatus</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<!-- aquí se muestran los datos automaticamente -->
								</tbody>
							</table>
						<!-- </div> -->
					</div>
				</div>
			</div>

			<!-- <div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">RESUMEN GENERAL DE EMERGENCIAS</div>
					<div class="panel-body">
						<div class="widget-content">

							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="resumen">
								<tbody>
									<tr>
										<td width="25%" align="right" valign="middle" bgcolor="#51A2C5" class="resumen_td">NUMERO DE EMERGENCIAS</td>
										<td width="25%" bgcolor="#3886A7" class="resumen_td">EMERGENCIAS FINALIZADAS</td>
										<td width="25%" align="right" valign="middle" bgcolor="#00D3C2" class="resumen_td">PERSONAS ATENDIDAS</td>
									</tr>
									<tr>
										<td align="right" valign="middle" class="resumen_tt" bgcolor="#51A2C5">
											<div id="nvence"></div>
										</td>
										<td bgcolor="#3886A7" class="resumen_tt">
											<div id="nutil"></div>
										</td>
										<td align="right" valign="middle" class="resumen_tt" bgcolor="#00D3C2">
											<div id="nmalo"></div>
										</td>
									</tr>
								</tbody>
							</table>


						</div>

						<div class="widget box">
							<div class="widget-content">

								<div id="ViewGrupo"></div>

							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div>



		<!-- <div class="col-md-12">
			<script src="https://code.highcharts.com/highcharts.js"></script>
			<script src="https://code.highcharts.com/modules/exporting.js"></script>
			<script src="https://code.highcharts.com/modules/export-data.js"></script>

			<script type="text/javascript" src="../js/gestion_grafico.js"></script>


			<div class="col-md-6">
				<div class="panel panel-success">
					<div class="panel-heading">CONTROL DE EMERGENCIAS POR MES</div>
					<div class="panel-body">


						<div id="ViewUnidad" style="height: 350px"> </div>



					</div>
				</div>
			</div>


			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">RESUMEN POR TIPO DE EMERGENCIA</div>
					<div class="panel-body">
						<div class="widget box">
							<div class="widget-content">

								<div id="ViewSede"></div>

							</div>
						</div> 
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">RESUMEN AFECTACION HAS MENSUAL</div>
					<div class="panel-body">
						<div class="widget box">
							<div class="widget-content">

								<div id="ViewSedeHAS"></div>

							</div>
						</div>
					</div>
				</div>
			</div>

		</div> -->

	</div>
	<!-- Page Footer-->

	<div id="FormPie"></div>


	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog" id="mdialTamanio">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Detalle de Emergencias</h4>
				</div>
				<div class="modal-body">
					<p>
					<div id="detallef"></div>
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
</body>

<!-- modal del formulario de incidentes  -->
<link rel="stylesheet" href="./lib/css/styleModal.css">
<div id="modalEditar" class="modal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<form id="formEditar" action="#" enctype="multipart/form-data">
			<input type="hidden" name="id_incidentes" id="id_incidentes">
			<div class="row">
				<div class="col-xl-6 col-md-6 col-sm-12">
					<label for="nombre">Nombre del Incidente*</label>
					<input class="bordado" type="text" name="nombre" id="nombre" required>
				</div>
				<div class="columnas">
					<label for="lugar">Lugar del Incidente*</label>
					<input class="bordado" type="text" name="lugar" id="lugar" required>
				</div>
				<div class="columnas">
					<label for="municipio">Municipio/Cantón*</label>
					<select class="bordado" name="municipio" id="municipio" required>
					<option value="" disabled selected>Seleccione una provincia</option>
                            <option value="azuay">Azuay</option>
                            <option value="bolivar">Bolívar</option>
                            <option value="canar">Cañar</option>
                            <option value="carchi">Carchi</option>
                            <option value="chimborazo">Chimborazo</option>
                            <option value="cotopaxi">Cotopaxi</option>
                            <option value="el-oro">El Oro</option>
                            <option value="esmeraldas">Esmeraldas</option>
                            <option value="galapagos">Galápagos</option>
                            <option value="guayas">Guayas</option>
                            <option value="imbabura">Imbabura</option>
                            <option value="loja">Loja</option>
                            <option value="los-rios">Los Ríos</option>
                            <option value="manabi">Manabí</option>
                            <option value="morona-santiago">Morona Santiago</option>
                            <option value="napo">Napo</option>
                            <option value="orellana">Orellana</option>
                            <option value="pastaza">Pastaza</option>
                            <option value="pichincha">Pichincha</option>
                            <option value="santa-elena">Santa Elena</option>
                            <option value="santo-domingo">Santo Domingo de los Tsáchilas</option>
                            <option value="sucumbios">Sucumbíos</option>
                            <option value="tungurahua">Tungurahua</option>
                            <option value="zamora-chinchipe">Zamora Chinchipe</option>
					</select>
				</div>
				<div class="columnas">
					<label for="localidad">Localidad</label>
					<input class="bordado" type="text" name="localidad" id="localidad">
				</div>
				<div class="columnas">
					<label for="estatus">Estado</label>
					<select class="bordado" name="estatus" id="estatus">
						<option value="ACTIVO">ACTIVO</option>
						<option value="CERRADO">CERRADO</option>
					</select>
				</div>
				<div class="columnas">
					<label for="fecha_incidente">Fecha incidente*</label>
					<input class="bordado" type="datetime-local" name="fecha_incidente" id="fecha_incidente" required>
				</div>
				<div class="columnas">
					<label for="fecha_cierre">Fecha Cierre Operacional</label>
					<input class="bordado" type="datetime-local" name="fecha_cierre" id="fecha_cierre" required>
				</div>
				<div class="form-buttons">
					<button type="button" class="btn-regresar">Cerrar</button>
					<button type="button" class="btn-guardar" onClick="GuardaIncidente()">Guardar Cambios</button>
				</div>
			</div>
		</form>
	</div>
</div>


<script>
	// clic en el botón de cerrar
	$('.close').on('click', function() {
		$('#modalEditar').css('display', 'none');
	});

	//  clic fuera del botón
	$(window).on('click', function(event) {
		if (event.target.id === 'modalEditar') {
			$('#modalEditar').css('display', 'none');
		}
	});

	// clic en el botón "Cerrar"
	$('.btn-regresar').on('click', function() {
		$('#modalEditar').css('display', 'none');
	});
</script>


</html>