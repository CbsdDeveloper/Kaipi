<!DOCTYPE html>
<html lang="en">
	
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ac_acta_trasf.js"></script> 
	
	
	 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 55% !important;
		}
 
		#mdialTamanio1{
      			width: 85% !important;
   			 }
		
		#mdialTamanio2{
      			width: 65% !important;
   			 }
	 
	 .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
</style>	
	
 	 		 
 </style>
	 
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
	
       <!-- Content Here -->
	
    <div class="col-md-12"> 
		
        		 <!-- Content Here -->
		
	        <ul id="mytabs" class="nav nav-tabs">       
 				 
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>INFORMACION DE CUSTODIOS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> GENERAR ACTA DE TRASFERENCIA ENTREGA RECEPCION</a>
                  		</li>
					 
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->

           <div class="tab-content">
            
           <!-- ------------------------------------------------------ -->
           <!-- Tab 1 -->
           <!-- ------------------------------------------------------ -->
			   
			  
					<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
						
		  			 		<div class="panel panel-default">
						 
								<div class="panel-body" > 

									 
										   <div class="col-md-3" style="background-color:#ededed;padding-bottom: 10px">

												 <h5><b>1. Filtro búsqueda</b></h5>
											   
											      <div id="ViewFiltro"></div> 
											   
											   <div class="col-md-12"  style="padding-top: 10px;padding-bottom: 10px">
											   
											   	   <button type="button" class="btn btn-sm btn-primary" id="load" onClick="BusquedaNombre()">  
																	<i class="icon-white icon-search"></i> Buscar parámetros</button>	
   												</div>
											   
										  </div>
									
										   <div class="col-md-4">
											   
											    <h5><b>2. Custodios Administrativos</b></h5>
											
											   <div style="height: 650px; overflow-y: scroll; padding: 5px">
												   
											   			<div id="ViewFiltroCiu"></div> 
												   
												   
											   </div> 
											   
											   
										
										  </div>  	 

										   <div class="col-md-5">

											<h5 id="custodio"><b>3. Custodio Administrativo</b></h5>
											   
											<table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="10%">Nro</th>
																									<th width="40%">Beneficiario/Tipo Acta</th>
																									<th width="30%">Acta/Documento</th>	
																									<th width="20%"> </th>
																									</tr>
																								</thead>
																	  </table>

											  </div>  
									
									
									 

							  </div>
						 
							  </div>
                    </div>
           
           
                    <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
  						  		   <div id="ViewForm"> </div>
						
									<div class="col-md-12" style="padding: 10px">
										
									  <div class="btn-group">
										<button type="button" class="btn btn-primary btn-sm">Seleccion de informacion</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
										  <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
										  <li><a onClick="MarcarTodo(1)"  href="#">Marcar todos los bienes</a></li>
										  <li><a onClick="MarcarTodo(0)" href="#">Desmarcar todos los bienes</a></li>
										</ul>
									  </div>
										</div>
										
										<div class="col-md-12" style="padding: 10px">
												<div id="DetalleActivosNoAsignado">Para visualizar los bienes pendientes de asignar debe agregar para crear el acta</div>
										</div>
             						
						
         						   <div id="GuardaDato"></div>
						
						
              	  </div>
			   
			         
			   
          	 </div>
		   
     </div>
	
    

<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    <div id="FormPie"></div>  
	
 </div>   


  </div>

       <!-- The Modal -->
       <div class="modal" id="myModal">
	  
			  <div class="modal-dialog" id="mdialTamanio">

						<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Busqueda por Custodio</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">

					 <div class="panel panel-default">

						 <div class="panel-body">

								<div class="col-md-9">
									 <input type="text" class="form-control" id="cnombre" name="cnombre">
								 </div>

								 <div class="col-md-3">
									 <button type="button" class="btn btn-sm btn-primary" id="loadcc"> <i class="icon-white icon-search"></i> Buscar</button>	
								 </div>

								<div style="padding-top: 10px;padding-bottom: 10px" class="col-md-12">

									<table id="jsontableCiu" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																										<thead>
																											<tr>
																											<th width="20%">Identificacion</th>
																											<th width="70%">Nombre</th>	
																											<th width="10%"> </th>
																											</tr>
																										</thead>
																			  </table>

													  </div>  

								</div>
						  </div>

					  </div>   

				</div>

						<!-- Modal footer -->
						<div class="modal-footer">
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>

			  </div>
		  
      </div>

      <div class="modal fade" id="myModalbienes" role="dialog">

			  <div class="modal-dialog" id="mdialTamanio1">

				<!-- Modal content-->
				 <div class="modal-content">
				 <div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Bienes Asignados en la Acta</h4>
				 </div>
				 <div class="modal-body">
					 <div class='row'>
							<div class="col-md-12" style="padding-top: 5px;">
								  <div style="height:400px;width:100%;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">

											<div id='VisorBIenes'></div>
								 </div>	
							 </div>	
					  </div>	 
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
	  
	  </div>

 </body>
</html>
