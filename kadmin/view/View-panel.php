<?php
session_start( );  

    require '../model/ajax_inicio.php';   /*Incluimos el fichero de la clase Db*/

  
  	if (empty($_SESSION['usuario']))  {
	 
		header('Location: login' );
		
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
 

		.ejecutar{
				 font-size: 32px;
				 font-weight:bold;
				 font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
				 color:#338230
			 }



		 a:link {
			text-decoration: none;
			color: #A8A8A8;
		}
		a:visited {
			text-decoration: none;
			color: #A8A8A8;
		}
		a:hover {
			text-decoration: none;
			color: #A8A8A8;
		}
		a:active {
			text-decoration: none;
			color: #A8A8A8;
		}

		#mdialTamanio{
		  width: 65% !important;
		}

		#mdialTamanioWeb{
		  width: 55% !important;
		}

		 .opacity{
		   background-color:#2E2E2E;
		   opacity:0.85; /* Opacidad 60% */

		}
		
 </style>
	
 
	
</head>

<body>
 
 	<div class="col-md-12">
			 
		      <h3 style="color:#4A4A4A;font-weight: 150;" >K<b>G &nbsp;e  &nbsp;s </b>  &nbsp;t  &nbsp;i  &nbsp;o &nbsp;n &nbsp;a &nbsp;<b><?php echo trim($_SESSION['razon']) ?></b> <br>
					 <span style="font-weight: 100;font-size: 13px">Plataforma de Gestion para la Administración Pública</span>
			  </h3>
			 
  </div>	 
	
	
	<div class="col-md-12" style="background: #F4F4F4">
 							   <h5>
									<i class="glyphicon glyphicon-home">&nbsp; </i>      <?php echo trim($_SESSION['login']) ?>
									<small> <i class="glyphicon glyphicon-envelope"></i> <?php echo trim($_SESSION['email']) ?> </small>
							   </h5>
    </div>	 
       
	
    <div class="col-md-12">
			
							 <div class="col-md-2" style="padding-top: 15px">

										 <div id="kaipiMain"></div>

								 		
								   					 <script src="highcharts.js"></script>
													 <script src="exporting.js"></script>
													 <script src="export-data.js"></script>

													 <script type="text/javascript" src="../js/gestion_grafico.js"></script> 
												
													 <div id="Indicadores"  style="height: 350px"></div>

								 
							 </div>


							 <div class="col-md-7">

									 <div class="col-md-12">

											<div class="col-md-9" style="padding: 20px" align="center">

													 <div class="col-md-12">

															 <div id="idMod"></div>

													 </div> 

													 <div class="col-md-12" style="padding: 10px">

														 <img src="../../kimages/zgasto.png" width="7" height="9"  />

														 <a href="#" title="Más Información" onClick="MiPerfil();" style="font-size: 16px;font-weight: 600">PANEL DE ACCESO A USUARIOS</a>

														<?php  if ( $rol== '2') { ?>

															   &nbsp;&nbsp;   
																<img src="../../kimages/zgasto.png" width="7" height="9"  />
																<a href="#" title="Más Información" onClick="AccesoFinanciero();" style="font-size: 12px;font-weight: 500"> Acceso Rápido Proceso Financiero</a>

														<?php 	}  ?>

													  </div> 

											</div> 

											<div class="col-md-3">

												   <div style="background-image: url(../../kimages/01.png);padding-top: 3px" align="center">  
															 <img src="../../kimages/<?php echo trim($_SESSION['logo']) ?> " class="img-responsive">
												   </div> 

												  

										  </div> 

											<div class="col-md-3">

												   <div  style="padding-top: 3px" align="center"> 

											   <?php
													echo '<img id="ImagenUsuario" src="'.$imagen.'" class="img-responsive"> '. '<br>
													<a href="#"   data-toggle="modal" title="Registrar Firma Electronica" data-target="#myModalCorreo" > 
													<span style="font-size: 12px;color: #4A4A4A">';
																  
													echo $_SESSION['login']. '<br>';
													echo $_SESSION['email'].'</span>   </a><br><br>Periodo:
													 <h3><b><a href="#" title="Seleccionar periodo de gestion" data-toggle="modal" data-target="#myModalperiodo">'.$_SESSION['anio'] .'</a></b> </h3>';

												?>
													</div> 
												
													
											 </div>
										 
									

									 </div>

									 <div class="col-md-12">

											 <div class="col-md-3">

										   &nbsp; 

										 </div> 

											 <div class="col-md-12" align="center">


											  <a href="visor-tramite_fin" style="font-size: 12px" title="Busqueda Procesos Administrativos - Financieros"  >
														<img src="../../kimages/money.png">  
												</a>	 
												<a href="visor-tramite_doc" style="font-size: 12px" title="Busqueda de tramites de procesos - documentos">
														<img src="../../kimages/zdocume.png" width="48" height="47">  
												</a> 
												 
												   
												<a href="https://mail.cbsd.gob.ec/" style="font-size: 12px" target="_blank" title="Correo Institucional Zimbra">
														<img src="../../kimages/zimbra.png" width="54" height="56"  >  
												</a>  
<!-- 

												<a href="https://web.gestiondocumental.gob.ec/" style="font-size: 12px" target="_blank" title="Quipux Gestión Documental ">
														<img src="../../kimages/quipux.png"  >  
												</a>   -->

												<a href="https://esigef.finanzas.gob.ec/esigef/login/frmLogineSIGEF.aspx" style="font-size: 12px" target="_blank" title="ESIGEF PLATAFORMA FINANCIERA">
														<img src="../../kimages/z_sigef.png"  >  
												</a>  

											   <a href="https://www.compraspublicas.gob.ec/ProcesoContratacion/compras/" style="font-size: 12px" target="_blank" title="COMPRAS PUBLICAS">
														<img src="../../kimages/z_compraspu.png"  >  
												</a>  

												<a href="https://g-kaipi.cloud/g-online/" style="font-size: 12px"  title="Guias Visuales"  target="_blank">
														<img src="../../kimages/candidate.png" width="48" height="48" >  
												</a>	

										 </div> 

									</div>


							 </div>	 

							 <div class="col-md-3" style="padding: 5px">

											<div class="col-md-12">

											 <div  style="padding-top:5px;padding-bottom: 5px;">  



														<div class="panel-heading">

														   <a href="../../kdocumento/view/inicio" style="color: #232323">
															   <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbsp;&nbsp;Gestión Documental </a>
														   </a>

													   </div>


														<div class="panel-heading">

														   <a href="../../kcrm/view/cli_incidencias" style="color: #232323">
															   <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;Gestión WK-Procesos  </a>
														   </a>

													   </div>

														<div class="panel-heading">

														   <a href="requerimiento_d" style="color: #232323">
															   <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;&nbsp;Documentos/Formularios de interes   </a>
														   </a>

													   </div>


														<div class="panel-heading">

														   <a href="agenda" style="color: #232323">
															   <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;&nbsp;Ver Agenda    </a>
														   </a>

													   </div>


														<div class="panel-heading">

														   <a href="#"  data-toggle="modal" data-target="#myModal" style="color: #232323">
															   <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;Mi Perfil  </a>
														   </a>

													   </div>

														<div class="panel-heading">

														   <a href="sesion"    style="color: #232323">
															   <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;Cerrar Sesion  </a>
														   </a>

													   </div>




												  </div>


											</div> 	 

										   <div class="col-md-12">

											  <div  style="background-image: url(../../kimages/01.png);padding-top: 3px" align="center"> 

												  <iframe width="100%" id="recordar" name = "recordar" height="450px" src="../../notificaciones/index.php" border="0" scrolling="no" allowTransparency="true" frameborder="0"></iframe>

											  </div>     	

										   </div> 

							   </div> 

  </div>	
	 
  
 
	
	
    <div class="col-md-12">
	
		<div id="footer" style="padding:10px">
			
								 <div class="single-sign-on" style="padding-left: 15px; padding-top: 15px;color:#3B3B3B;">
									   <small>PLATAFORMA DE GESTION EMPRESARIAL </small><br>
									   <small>Copyright 2018 KAIPI  Rights Reserved. <a href="#" target="_blank">Privacy Policy</a> | Quito - Ecuador</small>
								 </div>
			
 		</div>
		
	</div> 	
	
	
	
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
		
       <div class="modal-dialog" >
		   
				  <!-- Modal content-->

				  <div class="modal-content">

					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Seleccionar periodo</h4>
					</div>

					<div class="modal-body">

					   <div class="col-md-12">

							<div class="col-md-7">
							<select id='ganio' name='ganio' class='form-control'>  </select>
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
						data.append('userfile',file);


				$.ajax({
					url: '../model/upload.php',
					type: 'post',
					data:data,
					cache: false,             // To unable request pages to be cached
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

  <div class="modal fade" id="myModalChat" role="dialog">
	  
       <div class="modal-dialog" id="mdialTamanio">
		   
      <!-- Modal content-->
			  <div class="modal-content">
				  
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Chat Interno</h4>
				</div>
 					  <div class="modal-body" style="font-size:11px;padding: 1px">
					
						 <iframe width="100%" id="chatlocal" name = "chatlocal" height="470" src="View-panelchat" frameborder="0" allowfullscreen></iframe>
 						  
					 </div>	
 				  
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				  
			  </div>
      
    </div>
	  
  </div>
	
 	 
  	
</body>
</html>
 