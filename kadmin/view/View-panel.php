<?php
session_start();
require '../model/ajax_inicio.php';   /*Incluimos el fichero de la clase Db*/
if (empty($_SESSION['usuario'])) {
	header('Location: login');
}
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="shortcut icon" href="../../app/kaipi-favicon.png">
	<title>CBSD - Plataforma de Gestion Empresarial</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link href="../../app/css/bootstrap.min.panel.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="../../app/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../app/css/bootsnipp.min.css">
	<script type="text/javascript" src="../../app/js/jquery-1.10.2.min.js"></script>
	<script src="../../app/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../js/kaipi.js"></script>
	<script type="text/javascript" src="../../app/dist/js/bootstrap.js"></script>
	<script type="text/javascript" src="../../app/js/jquery-1.10.2.min.js"></script>

	<!--
 <link rel="stylesheet" href="../js/shadowbox.css">
 <script src="../js/jquery-1.4.2.min.js"></script>
 <script src="../js/shadowbox.js"></script>
 <script type="text/javascript"> Shadowbox.init({ language: "es", players:  ['img', 'html', 'iframe', 'qt', 'wmp', 'swf', 'flv'] }); </script>
	  -->
	<script src="../js/jquery.modulo.js"></script>

	<meta charset="utf-8">

	<style type="text/css">
		.ejecutar {
			font-size: 32px;
			font-weight: bold;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			color: #338230
		}

		a:link {
			text-decoration: none;
			/* color: #A8A8A8; */
		}

		a:visited {
			text-decoration: none;
			/* color: #A8A8A8; */
		}

		.panel-heading a {
			color: black;
		}

		.panel-heading a:hover {
			color: #343a40;
			/* background: #343a40; */
			font-weight: bold;
		}

		a:hover {
			text-decoration: none;
			color: #A8A8A8;
		}

		a:active {
			text-decoration: none;
			color: #A8A8A8;
		}

		#mdialTamanio {
			width: 65% !important;
		}

		#mdialTamanioWeb {
			width: 55% !important;
		}

		.opacity {
			background-color: #2E2E2E;
			opacity: 0.85;
			/* Opacidad 60% */
		}

		/* .menu-grid {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-gap: 20px;
			padding: 20px;
			background-color: #f4f4f4;
		} */

		.menu-item {
			background-color: #007bff;
			color: white;
			padding: 20px;
			text-align: center;
			border-radius: 10px;
			transition: background-color 0.3s ease;
		}

		.menu-item:hover {
			background-color: #0056b3;
			color: #ffffff;
		}

		.menu-item i {
			font-size: 34px;
			font-weight: bold;
			display: block;
			margin-bottom: 10px;
		}

		.menu-item span {
			font-size: 12px;
			font-weight: bold;
		}

		@media (max-width: 1000px) {
			.img-responsive {
				max-width: 10%;
			}
		}

		@media (max-width: 800px) {
			.img-responsive {
				max-width: 80px;
			}
		}

		.grid-container {
			display: grid;
			grid-template-columns: auto auto auto;
			/* background-color: #f4f4f4; */
			grid-gap: 10px;
			/* padding: 10px; */
			margin-top: 10px;
		}

		.grid-item {
			/* background-color: rgba(255, 255, 255, 0.8); */
			/* border: 1px solid rgba(0, 0, 0, 0.8); */
			/* padding: 20px; */
			/* font-size: 30px; */
			text-align: center;
		}

		/* Ajuste para pantallas menores a 460px */
		@media (max-width: 460px) {
			.grid-container {
				grid-template-columns: 1fr;
				/* Una sola columna en dispositivos pequeños */
			}

			.grid-item {
				font-size: 14px;
				/* Reduce ligeramente el tamaño del texto */
				padding: 10px;
			}

			.grid-item i {
				font-size: 20px;
				/* Ajusta el tamaño del ícono */
			}
		}

		/* Alertas */
		.alert-box {
			color: #555;
			border-radius: 10px;
			font-family: Tahoma, Geneva, Arial, sans-serif;
			font-size: 13px;
			padding: 10px 36px;
			margin: 10px;
		}

		.alert-box span {
			font-weight: bold;
			text-transform: uppercase;
		}

		.error {
			background: #ffecec url('../../kimages/error.png') no-repeat 10px 50%;
			border: 1px solid #f5aca6;
		}

		.success {
			background: #e9ffd9 url("../../kimages/alert.png") no-repeat 10px 50%;
			border: 1px solid #a6ca8a;
		}

		.warning {
			background: #fff8c4 url('"../kimages/v_interes.png"') no-repeat 10px 50%;
			border: 1px solid #f2c779;
		}

		#footer {
			position: fixed;
			bottom: 0;
			width: 100%;
			background-color: #343a40;
			color: #ffffff;
			padding: 10px;
			text-align: center;
		}
	</style>

</head>

<body style="margin-top: 0px;margin-bottom: 0px;">



	<div class="col-md-12" style="background-color: #343a40;">

		<div class="row center">
			<div class="col-md-1">
				<img src="../../kimages/Logocbsd.png " class="img-responsive">
			</div>
			<div class="col-md-11">
				<h4 style="color:#ffffff;font-weight: 150"> K<b>G &nbsp;e &nbsp;s </b> &nbsp;t &nbsp;i &nbsp;o &nbsp;n &nbsp;a &nbsp;<b><?php echo trim($_SESSION['razon']) ?></b> <br>
					<span style="font-weight: 200;font-size: 12px;">Plataforma de Gestion para la Administración Pública</span>
				</h4>
				<h5 style="color:#ffffff">
					<i class="fa fa-home"></i> <?php echo trim($_SESSION['login']) ?>
					<small> <i class="fa fa-envelope"></i> <?php echo trim($_SESSION['email']) ?> </small>
				</h5>
			</div>
		</div>

		<!-- <h3 style="color:#ffffff;font-weight: 150;">K<b>G &nbsp;e &nbsp;s </b> &nbsp;t &nbsp;i &nbsp;o &nbsp;n &nbsp;a &nbsp;<b><?php echo trim($_SESSION['razon']) ?></b> <br>
			<span style="font-weight: 100;font-size: 13px">Plataforma de Gestion para la Administración Pública</span>
		</h3> -->

	</div>


	<!-- <div class="col-md-12" style="background: #343a40">
		<h5>
			<i class="glyphicon glyphicon-home">&nbsp; </i> <?php echo trim($_SESSION['login']) ?>
			<small> <i class="glyphicon glyphicon-envelope"></i> <?php echo trim($_SESSION['email']) ?> </small>
		</h5>
	</div> -->


	<div class="row" style="margin-right: 0px;">

		<div class="col-md-2" style="padding-top: 0px">

			<div id="kaipiMain"></div>
			<script src="highcharts.js"></script>
			<script src="exporting.js"></script>
			<script src="export-data.js"></script>
			<!-- <script type="text/javascript" src="../js/gestion_grafico.js"></script> -->
			<!-- <div id="Indicadores" style="height: 350px"></div> -->
		</div>


		<div class="col-md-7">
			<?php
			$array   = $bd->__user(str_replace('@cbsd.gob.ec', '', $sesion));
			$perfil  = trim($array['tipo']);
			if ($perfil == 'tthh') {
				$xa = $bd->query_array('co_anticipo',     'count(*) as nn',  'estado=' . $bd->sqlvalue_inyeccion('tthh', true));
				if ($xa['nn'] > 0) {
					echo '<div class="alert-box success"><span> ' . $xa['nn'] . ' ANTICIPOS PENDIENTES: </span> <a href="requerimiento_a"> VER BANDEJA DE TRAMITES INTERNOS - ANTICIPOS</a></div>';
				}
			}
			if ($perfil == 'financiero') {
				$xa = $bd->query_array('co_anticipo',     'count(*) as nn',  'estado=' . $bd->sqlvalue_inyeccion('financiero', true));
				if ($xa['nn'] > 0) {
					echo '<div class="alert-box success"><span> ' . $xa['nn'] . ' ANTICIPOS PENDIENTES: </span> <a href="requerimiento_a"> VER BANDEJA DE TRAMITES INTERNOS - ANTICIPOS</a></div>';
				}
			}
			?>

			<!-- <div class="col-md-12"> -->
			<!-- <div class="col-md-12" style="padding: 20px" align="center"> -->
			<div class="col-md-12" align="center">
				<div id="idMod"></div>
			</div>
			<div class="col-md-12" style="padding: 10px" align="center">
				<img src="../../kimages/zgasto.png" width="7" height="9" />
				<a href="#" title="Más Información" onClick="MiPerfil();" style="font-size: 16px;font-weight: 600">PANEL DE ACCESO A USUARIOS</a>
				<?php if ($rol == '2') { ?>
					&nbsp;&nbsp;
					<img src="../../kimages/zgasto.png" width="7" height="9" />
					<a href="#" title="Más Información" onClick="AccesoFinanciero();" style="font-size: 12px;font-weight: 500"> Acceso Rápido Proceso Financiero</a>
				<?php 	}  ?>
			</div>
			<!-- </div> -->
			<!-- </div> -->

		</div>

		<div class="col-md-3" style="padding: 5px;">
			<div class="col-md-12">
				<div style="padding-top: 3px" align="center">
					<?php
					echo '<img id="ImagenUsuario" width="40%" src="' . $imagen . '" class="img-responsive"> ' . '
						<a href="#"   data-toggle="modal" title="Registrar Firma Electronica" data-target="#myModalCorreo" >
						<span style="font-size: 12px;color: #4A4A4A">';
					echo $_SESSION['login'] . '<br>';
					echo $_SESSION['email'] . '</span>   </a><br>Periodo:
					<h3><b><a href="#" title="Seleccionar periodo de gestion" data-toggle="modal" data-target="#myModalperiodo"> <span class="fa fa-calendar-check-o" aria-hidden="true"></span> ' . $_SESSION['anio'] . '</a></b> </h3>';
					?>
				</div>
			</div>
			<div class="col-md-12">
				<div style="background-image: url(../../kimages/01.png);padding-top:5px;padding-bottom: 5px;">
					<div class="panel-heading">
						<a href="../../kdocumento/view/inicio">
							<span class="fa fa-paperclip" aria-hidden="true"></span>&nbsp;&nbsp;Gestión Documental </a>
						</a>
					</div>


					<div class="panel-heading">
						<a href="../../kcrm/view/cli_incidencias">
							<span class="fa fa-cog" aria-hidden="true"></span>&nbsp;&nbsp;Gestión WK-Procesos </a>
						</a>
					</div>

					<div class="panel-heading">
						<a href="requerimiento_d">
							<span class="fa fa-calendar" aria-hidden="true"></span>&nbsp;&nbsp;Documentos/Formularios de interes </a>
						</a>
					</div>


					<div class="panel-heading">
						<a href="agenda">
							<span class="fa fa-calendar" aria-hidden="true"></span>&nbsp;&nbsp;Ver Agenda </a>
						</a>
					</div>


					<div class="panel-heading">
						<a href="#" data-toggle="modal" data-target="#myModal">
							<span class="fa fa-user" aria-hidden="true"></span>&nbsp;&nbsp;Mi Perfil </a>
						</a>
					</div>

					<div class="panel-heading">
						<a href="sesion">
							<span class="fa fa-sign-out" aria-hidden="true"></span>&nbsp;&nbsp;Cerrar Sesion </a>
						</a>
					</div>

				</div>

			</div>

			<div class="col-md-12">
				<div class="col-md-3">
					&nbsp;
				</div>
				<div class="col-md-12" align="center">
					<a href="visor-tramite_fin" style="font-size: 12px" title="Busqueda Procesos Administrativos - Financieros">
						<img src="../../kimages/money.png">
					</a>
					<a href="visor-tramite_doc" style="font-size: 12px" title="Busqueda de tramites de procesos - documentos">
						<img src="../../kimages/zdocume.png" width="48" height="47">
					</a>
					<a href="https://mail.cbsd.gob.ec/" style="font-size: 12px" target="_blank" title="Correo Institucional Zimbra">
						<img src="../../kimages/zimbra.png" width="54" height="56">
					</a>
					<!--

												<a href="https://web.gestiondocumental.gob.ec/" style="font-size: 12px" target="_blank" title="Quipux Gestión Documental ">
														<img src="../../kimages/quipux.png"  >
												</a>   -->

					<a href="https://esigef.finanzas.gob.ec/esigef/login/frmLogineSIGEF.aspx" style="font-size: 12px" target="_blank" title="ESIGEF PLATAFORMA FINANCIERA">
						<img src="../../kimages/z_sigef.png">
					</a>
					<a href="https://www.compraspublicas.gob.ec/ProcesoContratacion/compras/" style="font-size: 12px" target="_blank" title="COMPRAS PUBLICAS">
						<img src="../../kimages/z_compraspu.png">
					</a>
					<a href="https://g-kaipi.cloud/g-online/" style="font-size: 12px" title="Guias Visuales" target="_blank">
						<img src="../../kimages/candidate.png" width="48" height="48">
					</a>
				</div>
			</div>

			<!-- <div class="col-md-12">
				<div style="padding-top: 3px" align="center">
					<iframe width="100%" id="recordar" name="recordar" height="450px" src="../../notificaciones/index.php" border="0" scrolling="no" allowTransparency="true" frameborder="0"></iframe>
				</div>
			</div> -->

		</div>

	</div>





	<!-- <div class="col-md-12" style="background: #343a40"> -->
	<div id="footer" style="padding:5px;background: #343a40">
		<div class="single-sign-on" style="padding-left: 15px; padding-top: 5px;color:#ffffff;">
			<small>PLATAFORMA DE GESTION EMPRESARIAL </small><br>
			<small><i class="fa fa-copyright"></i> Copyright 2024 Cuerpo de Bomberos del Gobierno Autónomo Municipal de Santo Domingo - All Rights Reserved. <i class="fa fa-registered"></i> <a href="#" target="_blank">Privacy Policy</a> | Santo Domingo - Ecuador</small>
		</div>
	</div>
	<!-- </div> -->



	<!-- Modal -->

	<div class="modal fade" id="myModal" role="dialog">

		<div class="modal-dialog" id="mdialTamanio">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Perfil del usuario</h4>
				</div>
				<div class="modal-body" style="font-size:11px;padding: 1px">
					<div style="padding: 1px" id="perfilUser"> .</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>

	</div>



	<div class="modal fade" id="myModalperiodo" role="dialog">

		<div class="modal-dialog">

			<!-- Modal content-->

			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Seleccionar periodo</h4>
				</div>

				<div class="modal-body">

					<div class="col-md-12">

						<div class="col-md-7">
							<select id='ganio' name='ganio' class='form-control'> </select>
						</div>

						<div class="col-md-5" style="padding-top: 4px">
							<button type="button" onClick="PeriodoAnio()" class="btn btn-info btn-sm">Seleccionar Periodo</button>
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>

		</div>

	</div>


	<!-- Modal -->

	<div class="modal fade" id="myModalCorreo" role="dialog">

		<div class="modal-dialog" id="mdialTamanioWeb">

			<!-- Modal content-->

			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Configuracion Firma Electronica</h4>
				</div>

				<div class="modal-body" style="font-size:11px;padding: 1px">

					<form method="post" action="#" enctype="multipart/form-data">

						<div class="form-group" style="padding: 10px;padding-left: 25px;padding-right: 25px">
							<input type="file" class="btn btn-primary" name="userfile" id="userfile" accept=".p12">
						</div>

						<div class="form-group" style="padding: 10px;padding-left: 25px;padding-right: 25px">
							<input type="button" class="btn btn-primary upload" value="Subir">
						</div>
					</form>


					<div style="padding: 1px" id="perfilUserWeb"> .</div>

					<div align="center" id="ResultadoUserWeb"> </div>

					<input type="hidden" id="archivo" name="archivo">
				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-warning" onClick="GuardaEmail()">Actualizar</button>

					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

				</div>

			</div>

		</div>

	</div>



	<script>
		$(document).ready(function() {
			$(".upload").on('click', function() {

				var inputFileImage = document.getElementById("userfile");
				var file = inputFileImage.files[0];
				var data = new FormData();
				data.append('userfile', file);


				$.ajax({
					url: '../model/upload.php',
					type: 'post',
					data: data,
					cache: false, // To unable request pages to be cached
					contentType: false,
					processData: false,
					success: function(response) {
						$("#ResultadoUserWeb").html(response);
						$("#archivo").val(response);
						$("#smtp1").val(response);

					}
				});
				return false;
			});
		});
	</script>


	<!-- Modal -->

	<!-- <div class="modal fade" id="myModalChat" role="dialog">

		<div class="modal-dialog" id="mdialTamanio">

			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Chat Interno</h4>
				</div>
				<div class="modal-body" style="font-size:11px;padding: 1px">

					<iframe width="100%" id="chatlocal" name="chatlocal" height="470" src="View-panelchat" frameborder="0" allowfullscreen></iframe>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>

		</div>

	</div> -->



</body>

</html>