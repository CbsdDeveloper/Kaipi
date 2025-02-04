<?php
session_start( );  

    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 
  	if (empty($_SESSION['usuario']))  {
	 
		header('Location: login' );
		
    } 
 
	$bd	     =	new Db;

	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

	$sesion 	=  trim($_SESSION['email']);

	$x 			=  $bd->query_array('par_usuario',  '*',  'email='.$bd->sqlvalue_inyeccion( $sesion ,true)); 

	$ACarpeta   =  $bd->query_array('wk_config',  'carpetasub',  'tipo='.$bd->sqlvalue_inyeccion(2,true). ' AND  registro = '.$bd->sqlvalue_inyeccion($_SESSION['ruc_registro'] ,true)  );

    $carpeta    =  trim($ACarpeta['carpetasub']);

	$imagen 	=  $carpeta.trim($_SESSION['foto']);
		
	$rol        =  trim($x['rol']);


	 if  ( $x['empresas'] == '0000000000000'){
		 
			if ($_SESSION['sesion_actual'] == 0){
				
				$id = $x['empresas'];
				
				$sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre, a.fondo  
						  FROM web_registro a , par_catalogo b 
						 WHERE b.idcatalogo =  a.idciudad and 
							   a.tipo =".$bd->sqlvalue_inyeccion('principal' ,true);

				$resultado				  = $bd->ejecutar($sql);
				$datos1 				  = $bd->obtener_array( $resultado);
				$_SESSION['ciudad']       = trim($datos1['nombre']); 
				$_SESSION['razon']        = trim($datos1['razon']); 
				$_SESSION['ruc_registro'] = $datos1['ruc_registro']; 
				$_SESSION['fondo']        = trim($datos1['fondo']); 
				$_SESSION['logo']		  = trim($datos1['url']); 

				$resultado 				   = $bd->ejecutar("select * from web_registro where  estado = 'S' order by tipo desc ");
				
				$_SESSION['sesion_actual'] = 1;		
								  
			} else {
				
				$resultado = $bd->ejecutar("select * from web_registro  where  estado = 'S' order by tipo desc");
				 
				$_SESSION['sesion_actual'] = 1;		
				
 			}
		     $empresa_seleccionada  = 1;
	  }else{
							   $id = $x['empresas'];
		 
							   $sql = "SELECT a.ruc_registro, a.url,a.razon, b.nombre ,a.url ,a.fondo
                                         FROM web_registro a , par_catalogo b 
                                        WHERE b.idcatalogo =  a.idciudad and a.ruc_registro =".$bd->sqlvalue_inyeccion($id ,true);
                                         
                    $resultado = $bd->ejecutar($sql);
		 			$datos1    = $bd->obtener_array( $resultado);
                             
					$_SESSION['ciudad']       = trim($datos1['nombre']); 
                    $_SESSION['razon']        = trim($datos1['razon']); 
					$_SESSION['fondo']        = trim($datos1['fondo']); 
				    $_SESSION['ruc_registro'] = trim($datos1['ruc_registro']); 
		  		    $_SESSION['logo']		  = trim($datos1['url']); 
							 
					$empresa_seleccionada =  '<div style="padding-left: 5px;color:#F5F5F5;">
							 		<h5>'.$daos1['ruc_registro'].' '.$_SESSION['razon'].'</h5> </div>';
		 }
						 

?>

<!DOCTYPE html>
<html>
	
<head>
	
<link rel="shortcut icon" href="../../app/kaipi-favicon.png">
  
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
									<i class="glyphicon glyphicon-home">&nbsp; </i>
								<?php echo trim($_SESSION['login']) ?>
								<small>
									<i class="glyphicon glyphicon-envelope"></i>
									<?php echo trim($_SESSION['email']) ?>
								</small>
							</h5>
    </div>	 
       
	
    <div class="col-md-12">
			
			 <div class="col-md-2" style="padding-top: 15px">
				 
				 		 <div id="kaipiMain"></div>
				 
			 </div>
		
			
			 <div class="col-md-7">
				   
				     <div class="col-md-12">
						 
						    <div class="col-md-9" style="padding: 20px" align="center">
								
							   <div class="col-md-12">
								   
							  		 <div id="idMod"></div>
							       
 							    </div> 
								
								 <div class="col-md-12" style="padding: 10px">
								
										 <img src="../../kimages/zgasto.png" width="7" height="9"  />

										 <a href="#" title="Más Información" onClick="MiPerfil();" style="font-size: 12px;font-weight: 500"> Información Unidad</a>

										<?php  if ( $rol== '2') { ?>
											   &nbsp;&nbsp;   <img src="../../kimages/zgasto.png" width="7" height="9"  />
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
							  
                            <div  style="background-image: url(../../kimages/01.png);padding-top: 3px" align="center"> 
								
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
						 
				    </div>
 				  
 
			 </div>	 
			
			 <div class="col-md-3" style="padding: 5px">
                        
				 	      	
				 
                            <div class="col-md-12">
							   
							 <div  style="padding-top:5px;padding-bottom: 5px;">  
								 
								 
								 
								      <div class="panel-heading">
										   <a href="../../kdocumento/view/cli_incidencias" style="color: #232323">
											   <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span>&nbsp;&nbsp;Iniciar Documento </a>
									       </a>
									   </div>

							          <div class="panel-heading">
										   <a href="../../kcrm/view/cli_incidencias" style="color: #232323">
											   <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;&nbsp;Iniciar WK-Proceso  </a>
									       </a>
									   </div>
 							   
							   
									  <div class="panel-heading">
										   <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="color: #232323"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>&nbsp;&nbsp;Requerimientos Internos</a>
										  <div id="collapse2" class="panel-collapse collapse">
										  <div class="panel-body">
											  
											    <ul class="list-group">
												  <li class="list-group-item"><a href="../../kpresupuesto/view/requerimiento" style="color: #232323"> - Requerimiento Adquisición Bienes/Servicios </a></li>
												  <li class="list-group-item"><a href="requerimiento_b" style="color: #232323"> - Solicitud a Bodega </a></li>
												  <li class="list-group-item"><a href="requerimiento_a" style="color: #232323"> - Solicitud de Anticipo</a></li>
												  <li class="list-group-item"><a href="requerimiento_p" style="color: #232323"> - Solicitud de Permisos/Vacaciones</a></li>	
													
													
												 <?php	
													 $sesion 	         =  trim($_SESSION['email']);

													 $Aunidad            = $bd->query_array('view_nomina_user',  'idprov', 'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)   );

													 $idprovjefe         =  trim($Aunidad['idprov']);
													
													 $tele               = $bd->query_array('view_tele_jefe_fun',  'count(*) as nn ', 
																						    'idprov_jefe='.$bd->sqlvalue_inyeccion(trim($idprovjefe),true)  ." and estado = 'SI'"
																			);
 												 
													 if (  $tele['nn']  > 0 )  {
														 
													/*	 echo 	  ' <li class="list-group-item"><a href="teletrabajo_jefe" style="color: #232323"> - Crear Actividades TeleTrabajo</a></li>';
													
													
													 <li class="list-group-item"><a href="teletrabajo_user" style="color: #232323"> - Registro TeleTrabajo</a></li>	
													*/
														 
													   }	 
													
													
													?>
												  
													
													
													
													
												</ul>
											  
  											  </div>
										</div>
									  </div>


									  <div class="panel-heading">
										   <a href="agenda" style="color: #232323">
											   <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>&nbsp;&nbsp;Ver Agenda    </a>
									       </a>
									   </div>
									  
									   <div class="panel-heading">
										   <a href="cartelera" style="color: #232323">
											   <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;&nbsp;Ver Cartelera    </a>
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
								  
 								  <iframe width="100%" id="recordar" name = "recordar" height="150px" src="../../notificaciones/" border="0" scrolling="no" allowTransparency="true" frameborder="0"></iframe>
								  
					     	  </div>     	
							
                           </div> 

 
 							<div class="col-md-12">
							 
							 
							  <a href="visor-tramite_fin" title="Busqueda Procesos Administrativos - Financieros"  >
										<img src="../../kimages/money.png"> 
 								</a>	
 							    <a href="visor-tramite_doc" title="Busqueda de tramites de procesos - documentos">
										<img src="../../kimages/user.png">  		
								</a>
							 
							 
							 
								<a href="../../ksoporte/view/inicio" title="Soporte Tecnico">
										<img src="../../kimages/customer.png"  > 	
								</a>

								<a href="https://g-kaipi.cloud/g-online/" title="Guias Visuales"  target="_blank">
										<img src="../../kimages/candidate.png" width="48" height="48" > 
												
								</a>	
							 
							   
							 
							 
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
 