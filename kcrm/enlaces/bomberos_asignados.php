<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
	 <script language="javascript" src="asigna_bomberos.js"></script>
	
</head>
<body>
 
               
						  <div class="modal-body">

						  
							  <div class="panel panel-default">

								 <div class="panel-body">
									 
									 <div class="col-md-12">
										 		
										 		 <div class="col-md-6">
													
													 
 															 <div class="alert alert-success">
																 
																 
																   <h4>Lista de Bomberos activos </h4>
																 
																   <div id="Vehiculo_view"> </div> 

															 </div>
 											     </div>
										 
										 		 <div class="col-md-6">
													 
													  <div class="alert alert-info">
														  
														  
														  
														    <h4>Bomberos Asignados </h4>
																 
																   <div id="Vehiculo_asigna"> Seleccionar Bomberos</div> 

															 </div>
													 
											     </div>
										 
									 
										
									  </div>

									  <div class="col-md-12">
										  
									   <div id="ViewVariables">  </div> 
										  
									  </div>	  
									 
									  <div class="col-md-12" style="padding: 8px" align="right">
									 
										
										  
										  <button type="button" onClick="cerrar()" class="btn btn-sm btn-danger" >Salir</button>
										  
									  </div>

								 </div>
							 </div>   
						 

						  </div>
 
	  <input type="hidden" id="proceso" name="proceso"> 
			
  
 
 
</body>
</html> 
 