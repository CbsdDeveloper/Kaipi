<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<title>Plataforma de Gestión Empresarial</title>

	<?php require('Head.php')  ?>


	<script type="text/javascript" src="../js/modulo.js"></script>



</head>

<body>

	<div id="main">

		<div class="row">


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

			<!-- Content Here -->
			<div class="col-md-6">
				<!-- Content Here -->

				<div class="panel panel-default">
					<div class="panel-heading">Gestión de Archivo Institucional</div>
					<div class="panel-body" align="center">
						<div class="widget box">
							<div class="widget-content">
								<!--      <script type="text/javascript" src="../js/gestion.js"></script>-->
								<div id="div_gasto"></div>
							</div>
						</div> <!-- /.col-md-6 -->
					</div>
				</div>

				<!-- <div class="panel panel-default">
				<div class="panel-heading">Resumen de Movimientos Egresos </div>
				<div class="panel-body">
					<div id="div_egresos" style="width:100%; height:250px;"></div>
				</div>
			</div> -->


			</div>

			<div class="col-md-6">

				<!-- <div class="panel panel-success">
					<div class="panel-heading">Resumen Rotación de Articulos Bodegas</div>
					<div class="panel-body">
						<div id="div_articulos" style="width:100%; height:250px;"></div>
					</div>
				</div> -->


				<!-- <div class="panel panel-success">
				<div class="panel-heading">Resumen de Presupuestario de Existencias</div>
				<div class="panel-body">
					<div id="div_presupuesto" style="width:100%; height:250px;"></div>
				</div>
			</div>
			<div class="panel panel-warning">
				<div class="panel-heading">Resumen de Movimientos Ingresos</div>
				<div class="panel-body">
					<div id="div_ingresos" style="width:100%; height:250px;"></div>
				</div>
			</div> -->


			</div>

		</div>

		<!-- Page Footer-->
		<div class="row">
			<div id="FormPie"></div>
		</div>
		<!-- <div id="FormEmpresa"></div> -->
		<!-- <div id="listaActividad"></div> -->

		<!-- actividdes-->
		<!-- <div id="Notas_actividades"></div> -->

	</div>
</body>

</html>