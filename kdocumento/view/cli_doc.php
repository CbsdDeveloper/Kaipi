<!DOCTYPE html>
<html lang="en">
	
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ;	?> 
       
 
 
	 <script language="javascript" src="../js/cli_doc.js?n=1"></script>
	
 
	
</head>

<body>

 
<div id="main">
	
    <div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
		
 	</div> 
 	
	<div id="mySidenav" class="sidenav" style="z-index: 100" >
		
		 <div class="panel panel-primary">
			
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
			
				<div class="panel-body">
					
					<div id="ViewModulo"></div>
					
				</div>
			
		  </div>
		
   </div>
	
       <!-- Content Here -->
	
  	<div class="col-md-12">
		

<div class="col-md-3">
      <h4>Tipos de Documentos</h4>  
								  
								      <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
											 <div id="listaDoc"></div> 
										   
										   </div>
									  </div>
								  
								  	  
	  </div>  
							
	  <div class="col-md-9">
								  
								    <h4>Lista de Documentos emitidos por unidad</h4>  
								  
								 			 <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;"> 
																
																 <div class="col-md-3"> 
																	 <input type="date" id="f1_v" name="f1_v" class="form-control">
																 </div> 
																<div class="col-md-3"> 
																	 <input type="date" id="f2_v" name="f2_v" class="form-control">
																 </div> 
																	
   															 
 															 
											  </div> 
								  
								 			  <div class="col-md-12"> 
 
												    <div class="panel panel-default">

													   <div class="panel-body" > 

														  <div style="width:100%; height:550px;" id="Visor_documentos"></div> 

													   </div>
												  </div>
												  
															
 
											  		 
							  				 </div>  
  	 		 				 </div>  
  </div>

	</div>
	
	<!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->	
	
	<div class="container"> 
		  <div class="modal fade" id="myModalCiu" tabindex="-1" role="dialog">
				<div class="modal-dialog" id="mdialTamanioCliente">
					<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Actualizacion Clientes</h5>
							  </div>
							  <div class="modal-body">
								  <div class="panel panel-default">
 									 <div class="panel-body">
											<div class="row">
												 <div id="ViewFormProv"> var</div> 
												  <div id="guardarCliente" ></div> 
											 </div>	
									 </div>
								 </div>
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					</div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div> 
<!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->	
	
  
   
	
 <!-- ---------------------------------------------------------------------------------------  -->
 <!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->	
<div class="container"> 
	 	 <div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog">
				<div class="modal-dialog" id="mdialEmail">
						<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Actividad</h5>
							  </div>
							  <div class="modal-body">
									<div class="panel panel-default">
  										  <div style="padding: 5px" id="e_actividad"></div> 
 									 </div>   
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					 </div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div>  
  
 
 
	
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
    
</body>
</html>
 