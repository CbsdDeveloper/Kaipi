<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/inv_cierre_pillaro.js"></script> 
 	 
	<style>
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		
		#mdialTamanio1{
      			width: 85% !important;
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
	
	
</head>
<body>
 
 
	
   <!-- ------------------------------------------------------ -->  
	
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
	
	
       <!-- Content Here -->
	
    <div class="col-md-12"> 
      
       		 <!-- Content Here -->
		
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   				<span class="glyphicon glyphicon-th-list"></span> <b> DETALLE DE VENTAS</b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-modal-window"></span> Cierre de Caja - Ventas</a>
                  		</li>
	 					<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-bell"></span>  Notas de Credito - Ventas</a>
                  		</li>
     
                        <li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-bookmark"></span>  Lista Notas de Credito </a>
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

                                         <div class="col-md-12"> 
											 
                                              <div class="alert alert-info">
												  
                                                  <div class="row">
													  
													  <div class="col-md-12"> 
														  
                                                                <div id = "ViewFiltro"> </div>
														  
													  </div>	
													  
													  <div class="col-md-12"> 
														  
                                                                <div class="col-md-2"  style="padding-top: 5px;"></div>
																	  
                                                                <div class="col-md-10"   style="padding-top: 5px;">
																	
																	 <button type="button" class="btn btn-sm btn-danger" id="loadFacInicio">
                                                                        <i class="icon-white glyphicon-usd"></i> 1. Generar Informacion</button>
																	
                                                                     <button type="button" class="btn btn-sm btn-primary" id="load">
                                                                        <i class="icon-white icon-search"></i> Buscar</button>
  																	
                                                                     <button type="button" class="btn btn-sm btn-info" id="loadFac">
                                                                        <i class="icon-white glyphicon-usd"></i> 2. Generar Comprobantes</button>
                                                                    
                                                                     <button type="button" class="btn btn-sm btn-success" id="loadFaca">
                                                                         <i class="icon-white icon-archive"></i> 3.  Autorizar Comprobantes</button>    
                                                               
																	
																	
																	  <div class="btn-group">
																		<button type="button" class="btn btn-sm btn-default">Novedades</button>
																		<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
																		  <span class="caret"></span>
																		</button>
																		<ul class="dropdown-menu" role="menu">
																		  <li><a href="#" id="loadno1">Comprobantes No emitidos</a></li>
																		  <li><a href="#"  id="loadno2">Comprobantes No enviados</a></li>
																		  <li><a href="#"  id="loadno3">Limpiar Comprobantes No enviados</a></li>
																		</ul>
																	  </div>		
													  
															 		  <button type="button" data-toggle="modal" data-target="#myModalEnlace" class="btn btn-sm btn-info">
                                                                         <i class="icon-white icon-archive"></i> Instituciones</button>   
													 			  
											 			 </div>
											           </div>
													  
                                                    </div>
                                               </div>
                                          </div> 

                                         <div class="col-md-12"> 
											 
													  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
															 <thead  bgcolor=#F5F5F5>
															   <tr>   
																	 <th width="10%">Id</th>
																	 <th width="10%">Pagado</th>
																	<th width="10%">Enlace</th>
																	 <th width="10%">Nro.Factura</th>
																	 <th width="10%">Identificacion</th>
																	 <th width="20%">Cliente</th>
																	  <th width="10%">Total</th>
																	 <th width="5%">Cerrado</th>
																	 <th width="5%">Envio</th>
																	<th width="10%">Accion</th>
															   </tr> 
														</thead>
													 </table>
											 
                                         </div>  
										  
                                         
                                          <div class="col-md-12" style="font-size: 16px;font-weight: 800">   
                                               <div id="data"> </div>
                                               <div id="FacturaFirma"> </div>
                                               <div id="FacturaElectronica"> </div>
                                               <div id="FacturaContador"> </div>
                                              
                                          </div>  
										  
                                       </div>  
                                 </div> 
                         </div>

                         <!-- ------------------------------------------------------ -->
                         <!-- Tab 2 -->
                         <!-- ------------------------------------------------------ -->

                        <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
							
                                  <div class="panel panel-default">

                                    <div class="panel-body" > 

                                              <div id="ViewForm"> </div>

                                       </div>
                                  </div>

                             </div>

                           <!-- ------------------------------------------------------ -->
                         <!-- Tab 3 -->
                         <!-- ------------------------------------------------------ -->

                        <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">

                                  <div class="panel panel-default">

                                    <div class="panel-body" > 

                                              <div id="ViewForm1"> </div>

                                              <div id="resultadoNota"> </div>

                                              <div id="FacturaElectronica"> </div>


                                       </div>
                                  </div>

                             </div>
			   
			            <!-- ------------------------------------------------------ -->
                         <!-- Tab 4 -->
                         <!-- ------------------------------------------------------ -->

                        <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">

                                  <div class="panel panel-default">

                                    <div class="panel-body" > 
                                        <div class="col-md-12"> 
											  <h4> Lista de Notas de Creditas Emitidas </h4>
											
                                              <div class="col-md-6" style="padding: 10px">
                                                                <button type="button" class="btn btn-sm btn-primary" id="loadNota">
                                                                    <i class="icon-white icon-search"></i> Buscar</button>
  
                                              </div>
 
                                            <div class="col-md-12"> 
                                              <table id="jsontableNota" class="display table-condensed" cellspacing="0" width="100%">
                                                     <thead  bgcolor=#F5F5F5>
                                                       <tr>   
                                                             <th width="10%">Fecha</th>
														     <th width="10%">Identificacion</th>
														     <th width="20%">Cliente</th>
														     <th width="10%">NotaCredito</th>
                                                             <th width="30%">Autorizacion</th>
                                                             <th width="20%">Documento Modificado</th>
                                                       </tr> 
                                                </thead>
                                             </table>
                                         </div>  
                                            
                                            
                                           </div> 
                                              


                                       </div>
                                  </div>

                             </div>
	
          	 </div>
		   
 		</div>
	 
     <!-- Modal -->

	 <div class="modal fade" id="myModal" role="dialog">
		 
			  <div class="modal-dialog" id="mdialTamanio">

		<!-- Modal content-->
				  
			  <div class="modal-content">
				  
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Articulo</h4>
				</div>
				<div class="modal-body">
				 <div id='VisorArticulo'></div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				  
			  </div>

			</div>
		  </div>

     <div class="modal fade" id="myModalEnlace" role="dialog">
		 
			  <div class="modal-dialog" id="mdialTamanio1">

		<!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Articulo</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="nombre_agua" name="nombre_agua" class="form-control" placeholder="Nombre de cliente">
 					
				   <table id="jsontableDato" class="display table-condensed" cellspacing="0" width="100%">
                                                     <thead  bgcolor=#F5F5F5>
                                                       <tr>   
                                                             <th width="10%">Codigo</th>
														     <th width="20%">Usuario</th>
														     <th width="10%">Cedula</th>
														     <th width="25%">Direccion</th>
                                                             <th width="10%">Año</th>
                                                             <th width="10%">Periodo</th>
														     <th width="5%">Accion</th>
                                                        </tr> 
                                                </thead>
                                             </table>
				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-info" onClick="BuscarNombreAgua()" >Buscar</button>
					
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>

			</div>
		  </div>

	 <div class="modal fade" id="myModalDetalle" role="dialog">
		 
			  <div class="modal-dialog" id="mdialTamanio">

		<!-- Modal content-->
				  
			  <div class="modal-content">
				  
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Detalle</h4>
				</div>
				<div class="modal-body">
				 <div id='VisorArticuloDetalle'></div>
				</div>
				<div class="modal-footer">
					
					 <button type="button" class="btn btn-success" onClick="CambiarSecuencia()" >Generar Secuencia</button>
					
					
					 <button type="button" class="btn btn-danger" onClick="EliminarSecuencia()" >Eliminar Doc</button>
					
					
					
					
					
					
					 <input type="hidden" value="0" id="mov_sq" name="mov_sq">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
				  
			  </div>

			</div>
		  </div>


     <!-- Page Footer-->
     <div id="FormPie"></div>  
    
 </div>   
 </body>
</html>
