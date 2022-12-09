<?php
//require '../model/_resumen_inicio.php'; /*Incluimos el fichero de la clase objetos*/
//$gestion   = 	new proceso;
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
       
    <script type="text/javascript" src="../js/modulo.js"></script>
 
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

				   <!-- Content Here -->
				<div class="col-md-12"> 
				   <!-- Content Here -->

						  <div class="col-md-7">

									   <div class="panel panel-default">

										 <div class="panel-heading">Gestión Medica</div>

										  <div class="panel-body">

												<div class="col-md-12" align="center">

												  <div class="col-md-3" align="center" style="padding: 25px">
													  <img src="../../kimages/me_paciente.png"  width="64" height="64" /> 
													   <h5 style="font-weight: bolder" align="center"><a href="me_paciente">Historia Clinica de Pacientes</a></h5>
												  </div> 



												  <div class="col-md-3" align="center" style="padding: 25px">
													  <img src="../../kimages/me_medico.png"   width="64" height="64" /> 
													   <h5 style="font-weight: bolder" align="center"><a href="me_atencion">Atención Médica</a></h5>
												  </div> 

												   <div class="col-md-3" align="center" style="padding: 25px">
													  <img src="../../kimages/me_certificado.png"  width="64" height="64" /> 
														<h5 style="font-weight: bolder" align="center"><a href="ad_mante">Certificados Médicos</a></h5>
												  </div> 

												  <div class="col-md-3" align="center" style="padding: 25px">
													  <img src="../../kimages/me_pato.png"  width="64" height="64" /> 
													  <h5 style="font-weight: bolder" align="center"><a href="ad_combustible">Antecedentes Patologicos</a></h5>
												  </div> 

											   <div class="col-md-3" align="center" style="padding: 25px">
													  <img src="../../kimages/me_cer.png" width="64" height="64" /> 
													  <h5 style="font-weight: bolder" align="center"><a href="ad_combustible_in">Consultas Medicas</a></h5>
												  </div> 
 

											   </div>  

											  


											  <div class="col-md-12" style="padding-top: 50px;padding-bottom: 50px">
											  </div> 
										 </div>
									 </div>	   
							 </div>


						  <div class="col-md-5">
									   <div class="panel panel-default">
										 <div class="panel-heading">RESUMEN MEDICO</div>
										  <div class="panel-body">
											 <div class="col-md-12" align="center">	   
											  <?php  // $gestion->_tipo_vehiculos() ?>

											  <?php // $gestion->_estado_vehiculo() ?>
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