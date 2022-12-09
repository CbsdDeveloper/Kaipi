<?php
	session_start( );

    if (empty($_SESSION['usuario']))  {
	
	    header('Location: ../../kadmin/view/login');
 		
	}
 
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 
    
   <script  src="../js/modulo.js?n=1"></script>
	
     
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
	
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
		
	   <div class="row">
		   
		  <div class="col-md-12">
			  
		   	    <div class="col-md-6">
				   
						 <div class="panel panel-success">
							 <div class="panel-heading">Gestión Contable</div>
								  <div class="panel-body">
										 
									  <div id="ParametroContable"></div>	 
									  
							     		   <div class="col-md-12" style="color:#303030" align="right">
											   
											    		<div class="col-md-6">
													
														</div>		
 										
														 <div class="col-md-2" align="center">
																<a href="controlArchivo">		 
																  <img src="../../kimages/archivo_con.png" title="Control Archivo"  align="absmiddle"/>  
																  </a>
															 <br>Archivo
														</div>	

															 <div class="col-md-2" align="center">
															<a href="controlPrevio">		 
															  <img src="../../kimages/control_previo.png" title="Control Previo"  align="absmiddle"/> 
															 </a>
															 <br>Control de Previo
														</div>		 

														<div class="col-md-2" align="center">
															<a href="controlAnticipo">		 
															  <img src="../../kimages/n_salario.png" title="Revisión de Anticipos"  align="absmiddle"/>
															 </a>
															 <br>Enlace Anticipos
														</div>	
 										 </div>	 
									  
							   		 </div>
							 
							  </div>
				 </div>
		   
			  
		         <div class="col-md-6">
						 <div class="panel panel-success">
							 <div class="panel-heading">Identificacion Empresa</div>
							  <div class="panel-body">
									 <div id="FormEmpresa"></div>	 
									  
							  </div>
							  </div>
				 </div>

		    </div>
		   
		   	 <script src="https://code.highcharts.com/highcharts.js"></script>
			 <script src="https://code.highcharts.com/modules/exporting.js"></script>
			 <script src="https://code.highcharts.com/modules/export-data.js"></script>
 
		     <div class="col-md-12">
				 
 		 		<div class="col-md-6">
					
						 <div class="panel panel-default">
							 <div class="panel-heading">Gestion Financiera</div>
							  <div class="panel-body">
									  <div class="widget box">
                                         <div class="widget-content">
                                            <script type="text/javascript" src="../js/gestion.js"></script>
                                            
											 <div id="div_gasto" style="width:100%; height:350px;"> </div>    
											 
 											 
                                         </div>
                                      </div>  
 							  </div>
						  </div>
					
				 </div>
		   
		   
		        <div class="col-md-6">
					
						  <div class="panel panel-warning">
							 <div class="panel-heading">Cartelera Mensajes</div>
							  <div class="panel-body">
									<iframe width="100%" height="350" src="View-panelchat" frameborder="0" allowfullscreen></iframe>
							  </div>
						  </div>
				 </div> 
				 
		      </div> 
		   
				
					
		</div>
    </div>
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
    </div>   
</body>
</html>
 