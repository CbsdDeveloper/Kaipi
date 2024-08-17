<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
	<meta http-equiv="Pragma" content="no-cache">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />

	<title>Plataforma de Gestión Empresarial</title>

	<?php require('Head.php')  ?>

	<script type="text/javascript" src="../js/xml_resumen.js"></script>


</head>

<body>

	<div class="col-md-12" role="banner">

		<div id="MHeader"></div>

	</div>

	<div id="mySidenav" class="sidenav">

		<div class="panel panel-primary">

			<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>

			<div class="panel-body">
				<div id="ViewModulo"></div>
			</div>

		</div>

	</div>


	<div class="col-md-12">

		<!-- Content Here -->

		<div class="row">

			<div class="col-md-12">

				<ul id="mytabs" class="nav nav-tabs">

					<li class="active"><a href="#tab1" data-toggle="tab"></span>
							<span class="glyphicon glyphicon-th-list"></span><b> TALON RESUMEN</b></a>
					</li>

				</ul>

				<!-- ------------------------------------------------------ -->

				<div class="tab-content">

					<!-- Tab 1 -->

					<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">

						<div class="panel panel-default">

							<div class="panel-body">

								<div class="col-md-12" style="padding: 1px">

									<div class="alert alert-info fade in">

										<div class="modal-body">

											<div class="col-md-2">

												<select name="mesc" id="mesc" class="form-control required">
													<option value="-"> Mes</option>
													<option value="01">Enero</option>
													<option value="02">Febrero</option>
													<option value="03">Marzo</option>
													<option value="04">Abril</option>
													<option value="05">Mayo</option>
													<option value="06">Junio</option>
													<option value="07">Julio</option>
													<option value="08">Agosto</option>
													<option value="09">Septiembre</option>
													<option value="10">Octubre</option>
													<option value="11">Noviembre</option>
													<option value="12">Diciembre</option>
												</select>

											</div>

											<div class="col-md-2">

												<input type="number" name="anioc" id="anioc" max="2050" min="2015" class="form-control required">

											</div>

											<div class="col-md-2">
												<button type="button" class="btn btn-primary btn-sm btn-block" onClick="BusquedaVisor();"><span class="glyphicon glyphicon-search"></span> Búsqueda</button>
											</div>

											<div class="col-md-2">

												<button type="button" class="btn btn-success btn-sm btn-block" onClick="genera_xml()"><span class="glyphicon glyphicon-edit"></span> Generar Xml</button>
											</div>

											<div class="col-md-2">
												<button type="button" class="btn btn-default btn-sm btn-block" onClick="genera_resumen()"><span class="glyphicon glyphicon-random"></span> Resumen IVA</button>
											</div>

											<div class="col-md-2">

												<div class="btn-group">
													<button type="button" data-toggle="dropdown" class="btn btn-warning btn-sm btn-block dropdown-toggle">&nbsp;&nbsp;Acciones&nbsp;&nbsp;
														<span class="caret"></span>
													</button>

													<ul class="dropdown-menu">

														<li><a href="#" onClick="genera_devolucion();">Devolución de IVA</a></li>


														<li><a href="#" onClick="genera_resumen_compras();">Credito Tributario</a></li>


														<li><a href="#" onClick="generaExcel('../model/comprasXls')">Resumen Compras</a></li>

														<li><a href="#" onClick="imprimir_comprobanteM('../reportes/resumen_renta')">Impuesto a la Renta</a></li>

														<li><a href="#" onClick="imprimir_comprobanteM('../reportes/resumen_iva')">Iva Retenido</a></li>

														<li><a href="#" onClick="imprimir_comprobanteM('../reportes/resumen_proveedor')">Resumen por proveedores</a></li>
														<li class="divider"></li>
														<li><a href="#" onClick="imprimir_comprobanteM('../reportes/resumen_cliente')">Ventas emitidas</a></li>
														<li><a href="#" onClick="imprimir_comprobanteM('../reportes/resumen_cliente1')">Ventas/Retencion</a></li>
														<li><a href="#" onClick="generaExcel('../reportes/ventasResumen')">Resumen Ventas</a></li>
														<li class="divider"></li>
														<li><a href="#" onClick="genera_resumen_ventas()">Generar Ventas para XML</a></li>
													</ul>
												</div>
											</div>

											<p></p>
										</div>

									</div>

								</div>



								<div class="col-md-12" align="center" style="padding-bottom:5px">

									<div class="col-md-8" align="center" style="padding-bottom:5px">

										<div id="ResumenDatos"></div>

									</div>

								</div>


							</div>

						</div>

					</div>


				</div>
			</div>

		</div>

	</div>


	<!-- Page Footer-->
	<div id="FormPie"></div>

</body>

</html>