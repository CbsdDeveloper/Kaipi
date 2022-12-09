<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
   
    <?php  require('Head.php')  ?> 
 
	<script type="text/javascript" src="../js/campana.js"></script> 
	
	
 	<script type="text/javascript" src="../js/ven_inicio.js"></script> 
 
    <style type="text/css">
        #mdialTamanio{
        width: 70% !important;
       }
 </style>
	
	
	
	
</head>
<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 
<!-- ------------------------------------------------------ -->
<div id="main">
	
  <!-- Header -->
	
  <header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 55px"> 
    
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> GESTIONAR CAMPAÑA</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-user"></span><b>  SELECCIONAR CLIENTES POTENCIALES</b> </a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-random"></span><b>  GESTIONAR CAMPAÑA </b> </a>
                  		</li>
	
						<li><a href="#tab4" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span><b>  SEGUIMIENTO CAMPAÑA </b> </a>
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
  		  	                <div class="col-md-5"  style="padding-top: 5px;">
 									<div class="panel panel-primary">
										  <div class="panel-heading"> <b> GRUPO DE TRABAJO </b></div>
										  <div class="panel-body"> 
											  
										    <select name="vgrupo" id="vgrupo" class="form-control" onChange="CargaCampana(this.value)"> </select>
										    <p>&nbsp;   </p>
											  <p>Grupo de trabajo asignado para la gestion de ventas</p>
									  </div>
										</div>
                                </div> 
							  
							   <div class="col-md-7"  style="padding-top: 5px;">
								 <div class="panel panel-default">
										  <div class="panel-heading"> <b> CAMPAÑAS ASIGNADAS </b></div>
										  <div class="panel-body">
											  
										    <div id="ViewFormCampana" > </div>
								   </div>
										</div>
                            </div> 
                        </div>  
                     </div> 
             </div>
              <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
    				 <div class="panel panel-default">
						  <div class="panel-body">
								<div class="col-md-12"> 
  									  <div class="alert alert-info">
 									  	<div class="row">
											  <div class="col-md-2"  style="padding-top: 5px;">
												  <select name="qestado"  id="qestado" class="form-control required">
													    <option value="-">Seleccionar Opcion</option>
													     <option value="0">No Asignados</option>
														 <option value="1">Por Verificar</option>
														 <option value="2">Verificado</option>
													
 													</select>
							                  </div> 
											   <div class="col-md-2"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
												   
												   <button type="button" class="btn btn-sm btn-default" title="informacion por Verificar" id="loadVerifica" onClick="GenerarPorVerificar()"><i class="icon-white icon-bitbucket-sign"></i></button>
												   
												   <button type="button" class="btn btn-sm btn-default" title="Informacion Verificada" id="loadok" onClick="GenerarPorVerificado()"><i class="icon-white icon-ok-sign"></i></button>
	   
					   			               </div> 
											  <div class="col-md-6"> 
													  <div id="vista"> Campaña</div> 
					   			               </div> 
								   		</div> 
							   	  </div> 		
  								  
 				  		     </div> 
 			  		  	     <div class="col-md-12"> 
							   
<table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
					 <thead  bgcolor=#F5F5F5>
									   <tr>   
										 <th width="10%">Codigo</th>
										 <th width="30%">Nombre</th>
										 <th width="10%">Telefono</th>
										 <th width="20%">Email</th>
										 <th width="10%">Movil</th>
										 <th width="20%">Accion</th>
									   </tr>
									</thead>
							 </table>
								 
								  <div id="ProcesoInformacion"> </div>
								 
                             </div>  	   
						</div>			 
				   </div>
               	 </div>
			   
		     <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
               <div class="panel panel-default">
						  <div class="panel-body" > 
	  		  	              <div id="ViewForm"> </div>
                          </div>  
                     </div> 
             </div>
			   
			   
			   <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
               <div class="panel panel-default">
						  <div class="panel-body" > 
	  		  	               <div class="col-md-12" style="padding:10px"> 
 								 <h4>Resumen de Campaña</h4>
 												  <button type="button" onClick="SegContactos();" class="btn btn-success">Actualizar</button>
								</div>				    
 								   <div class="col-md-12">
 										<div class="panel panel-success">
											  <div class="panel-heading">Seguimiento Campaña</div>
												  <div class="panel-body"> 
														<div id="ContactosCampana"> </div>
												  </div>
											</div>
									</div>
 				   				
                          </div>  
                     </div> 
             </div>
			   
   	  </div>
		   
  </div>
<input type="hidden" id="id_campana_temp" name="id_campana_temp">
<input type="hidden" id="medio_temp" name="medio_temp">  
		
	
  <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	    <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Selección Banco de clientes</h5>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormCliente"> var</div> 
							 
					 	   <label style="padding-top: 5px;text-align: right;" class="col-md-2"> </label>
						   <div style="padding-top: 5px;" class="col-md-10">
										<button type="button" class="btn btn-sm btn-primary" id="loadCliente">  <i class="icon-white icon-search"></i> Buscar  &nbsp; </button>	
								</div>
						   <table id="jsontableCliente" class="display table table-condensed table-hover datatable" width="100%">
																					<thead>
																						<tr>
																						 <th width="10%">Codigo</th>
																						<th width="20%">Identificación</th>
																						<th width="45%">Razon</th>
  																						<th width="15%">Correo</th>
																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
							  </table>
							 
				  		   <div id="guardarAux" ></div> 
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
 
  <div id="FormPie"></div>  
 </div>   
 </body>
</html>
