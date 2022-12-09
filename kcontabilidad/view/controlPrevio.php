<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
 
<script  type="text/javascript" language="javascript" src="../js/controlPrevio.js"></script>
	
 
	
	
 <style type="text/css">
	 	iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
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
	 
	 #mdialTamanio{
  					width: 90% !important;
		}
	 #mdialTamanio1{
  					width: 90% !important;
		}
	 
	  #mdialTamanio2{
  					width: 70% !important;
		}
	 
	 .form-control_asiento {  
		  display: block;
		  width: 100%;
		  height: 28px;
		  padding: 3px 3px;
		  font-size: 12px;
		  line-height: 1.428571429;
		  color: #555555;
		  vertical-align:baseline;
		  text-align: right;
		  background-color: #ffffff;
		  background-image: none;
		  border: 1px solid #cccccc;
		  border-radius: 4px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
				  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
   }
 
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
</style>		     	     	    		

	
</head>
	
<body>

	
	
 	
	
     <div class="col-md-12" role="banner">
		
 	   <div id="MHeader"></div>
 	
	</div> 
 	
	 <div id="mySidenav" class="sidenav" >
		
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
			
 		 	<div class="col-md-12" >
		  	 
				<ul id="mytabs" class="nav nav-tabs">  
					 
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>TRAMITES PENDIENTES CONTROL PREVIO</b></a>
										</li>
			
			 
										<li><a href="#tab2" data-toggle="tab">
											<span class="glyphicon glyphicon-forward"></span> FORMULARIO DE REGISTRO</a>
										</li>
			
										<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-duplicate"></span> Archivos y/o Documentos</a>
										</li>
			
										<li><a href="#tab4" data-toggle="tab">
											<span class="glyphicon glyphicon-duplicate"></span> Recorrido Documento</a>
										</li>
  			
				 </ul>
		 
                <!-- ------------------------------------------------------ -->
				<!-- Tab panes -->
				<!-- ------------------------------------------------------ -->
		 
				<div class="tab-content">
					
				
			       <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
					 
					     <div class="panel panel-default">
							 
										   <div class="panel-body" > 
											   
											   <div class="col-md-12" >
												   
												   <div class="col-md-4" >
													   <select id='vestado'  name ="vestado"  class="form-control" style="background-color:#e5e5ff">
														 <option value="-">- Tramites Financieros-</option>
														 <option value="N">En ejecución Control Previo</option>
														 <option value="S">Finalizado Control Previo</option>
													   </select>
												  </div>   
												   
												    <div class="col-md-4" >
													  <input type="text" id="idcasob" name="idcasob" class="form-control" placeholder="Nro.caso">
												   </div>  
												      <div class="col-md-4" >
													  <input type="text" id="idtramiteb" name="idtramiteb" class="form-control" placeholder="Nro.Tramite">
												   </div>  
												   
												
												    <div style="padding-top: 3px;" class="col-md-2">

																				<button type="button" onClick="Busqueda();"  class="btn btn-sm btn-primary" id="load">  
																				<i class="icon-white icon-search"></i> Buscar</button>	

													 </div>
												   
										     </div>
											   
											 <div class="col-md-12" >
										   
											  <div class="table-responsive" id="employee_table1">  
												  
											 
												  
													<table id="jsontable_tramite" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																							<thead>
																								<tr>
																								<th width="5%">Caso</th>
																								<th width="10%">Fecha</th>
																							    <th width="35%">Asunto</th>	
																								<th width="5%">Tramite</th>	
																								<th width="25%">Novedad</th>
																								<th  width="10%">Estado</th>
																								<th  width="5%">Dias</th>
																								<th width="5%">Acción</th>
																							  </tr>
																							</thead>
													</table>
												</div>    
										   
										   </div>
											   
										  </div>  	   
									  </div>
					 </div>
	 								
					<!-- Tab 2 -->
					
					<div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
											   <div class="col-md-12" >
												   <div id="ViewForm"> </div>
										       </div>
											   
											   
											     <div class="col-md-12"> 
													   
 													   <button type="button" class="btn btn-sm btn-danger" onClick="LimpiarVariable()" data-toggle="modal" data-target="#myModal" > Agregar Novedades</button>
 													 
													    <button type="button" class="btn btn-sm btn-primary" onclick="openFile('../../kdocumento/view/cli_editor_caso_add',1350,620)">  Elaborar Memo</button>
												   </div>
											   
											   <div class="col-md-6" style="padding-bottom: 10px;padding-top: 10px" >
												   
												   <div id="ViewFormControl"> </div>
										       </div>
											   
											     <div class="col-md-6" style="padding-bottom: 10px;padding-top: 10px" >
												   
												   <div id="ViewFormfileDoc"> </div>
										       </div>
											   
											   
											   
											   
		 										   
										   </div>
									  </div>
					 </div>
					
					<!-- Tab 3  -->
					
					<div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
 											
											     <div class="col-md-6"> 
													 
													     <div class="col-md-12">
  													
																 <div class="panel panel-info">  
																   <div class="panel-heading"><b> DOCUMENTOS  </b></div> 
																	<div class="panel-body">


																		  <div class="col-md-12"> 
																				<div id="ViewFormfile">  

																		   </div>	

																		 <div class="col-md-12" style="padding-bottom: 10px;padding-top: 10px"> 
																				<button type="button" class="btn btn-sm btn-danger" onclick="openFile('../../upload/uploadDoc_tramite',650,360)"> Cargar Documento</button>
																		  </div>

																		   </div> 

																	</div>
															   </div>
                       						 			 </div>
											   
 											             <div class="col-md-12">
													
													
																	  <div class="panel panel-info">  
																		  <div class="panel-heading"><b>COMPROBANTES ELECTRONICOS EMITIDOS  </b></div> 
																		   <div class="panel-body">
																				  <table id="jsontable_factura" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																													<th width="10%">Fecha</th> 
																													<th width="10%">Identificacion</th>
																													<th width="50%">Beneficiario</th>
																													<th width="15%">Factura</th>	
																													<th width="15%">Retencion</th>
																						</tr>
																					 </thead>
																					  </table>
																			   </div> 
																		</div>
												   			</div>
													 
												 </div>		
											   
											   
											    <div class="col-md-6"> 
													
													   <div class="col-md-12">
												   
															   <div class="panel panel-info">  
																   <div class="panel-heading"><b> RUTA DEL TRAMITE </b></div> 
																	<div class="panel-body">
																		   <div id="ViewFormRuta">  
																		   </div> 
																	</div>
															   </div>
												   
											  			 </div>
													 
												 </div>		
											   
 													
  										   </div>
									  </div>
					 </div>
					
					
					
					<div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
								  
									  <div class="panel panel-default">
								
										   <div class="panel-body" > 
										   
												   <div id="ViewRecorrido"> </div>
										   
		 										   
										   </div>
									  </div>
					 </div>
  									
	 			</div>
       
			 </div>	  
 		</div>
	
    
    </div>

     <!-- /.auxiliar -->  
    
	 
  <div class="container"> 
	  
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	   <div class="modal-dialog" id="mdialTamanio2">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Agregar novedades</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  	 
							 <div class="input-group" style="padding: 7px">
								 
								<span class="input-group-addon">Tipo Documento</span>
								 <select  id="tipo" class="form-control" name="tipo">
								     <option value="Memorandum">Memorandum</option>
									 <option value="Informe">Informe</option>
									 <option value="Factura">Factura</option>
									 <option value="Retencion">Retencion</option>
									 <option value="Oficio">Oficio</option>
									 <option value="Otros">Otros</option>
								 </select>
								 
						   </div>
							 
							 
							 	 <div class="input-group" style="padding: 7px">
									 
									<span class="input-group-addon">Descripción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
									 
									<input id="msg" type="text" class="form-control" name="msg" placeholder="Registre novedad">
									 
								  </div>
							 
							 
 					  		  <div align="center" style="padding: 10px;font-weight: 700px" id="guardarGasto"></div> 
							 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarNovedad()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>
	  <!-- /.modal -->
	  
   </div> 
	
  
	
	<div class="modal fade" id="myModalDocVisor" role="dialog">
		  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Visor de Documento</h4>
        </div>
        <div class="modal-body">
         
			<embed src="" width="100%" height="450" id="DocVisor">
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
  	<!-- Page Footer-->

  <div id="FormPie"></div>  
    
 

 </body>

</html>
 