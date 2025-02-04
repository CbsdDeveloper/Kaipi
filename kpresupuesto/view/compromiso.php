<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
   
    <?php  require('Head.php')  ?> 
 
	
	<script language="javascript" src="../js/compromiso.js?n=1"></script>
	<link rel="stylesheet" href="../../app/css/sweetalert2.min.css">
 
    <style type="text/css">
		
     #mdialTamanio{
        width: 70% !important;
       }
	#mdialTamanioCliente{
        width: 65% !important;
       }
		
		#mdialTamanioAgenda{
        width: 35% !important;
       }
		
		#mdialProducto{
        width: 75% !important;
       }
		
	 #mdialEmail{
        width: 75% !important;
       }
		
	.btn-group-justified1 {
     width: 100%;
    table-layout: fixed;
    border-collapse: separate;
   }	
		
	
 body{ margin-top:50px;}
.nav-tabs .glyphicon:not(.no-margin) { margin-right:10px; }
.tab-pane .list-group-item:first-child {border-top-right-radius: 0px;border-top-left-radius: 0px;}
.tab-pane .list-group-item:last-child {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;}
.tab-pane .list-group .checkbox { display: inline-block;margin: 0px; }
.tab-pane .list-group input[type="checkbox"]{ margin-top: 2px; }
.tab-pane .list-group .glyphicon { margin-right:5px; }
.tab-pane .list-group .glyphicon:hover { color:#FFBC00; }
a.list-group-item.read { color: #222;background-color: #F3F3F3; }
hr { margin-top: 5px;margin-bottom: 10px; }
.nav-pills>li>a {padding: 5px 10px;}

.ad { padding: 5px;background: #F5F5F5;color: #222;font-size: 80%;border: 1px solid #E5E5E5; }
.ad a.title {color: #15C;text-decoration: none;font-weight: bold;font-size: 110%;}
.ad a.url {color: #093;text-decoration: none;}
		
	#global {
	height: 390px;
	width: 100%;
	padding: 2px;
	overflow-y: scroll;
	}
		
 	#calendar {
    max-width: 900px;
    margin: 0 auto;
  }

 </style>
	
	
	<style type="text/css">
		 
	 
	 
	 
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
<!-- ------------------------------------------------------ -->
	
<div id="main">

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
  <!-- ------------------------------------------------------ -->  
	
        <div class="col-md-12"> 
			
 			<div class="row">

				 <div class="col-sm-3 col-md-2" > </div>

				 <div class="col-md-9">

					<!-- Split button -->
					 <button type="button" class="btn btn-default" data-toggle="tooltip" title="Refresh" onClick="location.reload()">
						&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;
					 </button>

					 <span style="color: #d9534f;padding:12px;font-weight:bold;font-size: 14px" id="nombre_actual">
						<b> &nbsp; [ Seleccionar tramite ] </b>
					 </span>

					<div class="pull-right">

						<div class="btn-group btn-group-sm">
							<button type="button" class="btn btn-default" onClick="javascript:PaginaGrilla(-1)">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</button>
							<button type="button" class="btn btn-default" onClick="javascript:PaginaGrilla(1)">
								<span class="glyphicon glyphicon-chevron-right"></span>
							</button>
						</div>

					</div>  

				</div>
			
			</div>
		  
			<hr>
			
 			<!--   -->
			<!-- estado de bandeja de entrada -->
			<!--    -->
			
			<div class="row">
				
            
				
				<div class="col-md-2">
                      
                       <ul class="nav nav-pills nav-stacked">
                        
						   <li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','2','2. Autorizado x Emitir Certificacion',1);">2. (*) Autorizado x Emitir Certificacion</a></li>
                            <li>
                             <a href="#" onClick="javascript:BusquedaGrilla('','3','3. Certificacion Presupuestaria',1);">3. Certificacion Presupuestaria
                             </a></li>
 						     <li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','5','5. Compromiso Presupuestario',1);">5. Compromiso Presupuestario
                            </a></li>
 						   <li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','6','6. Tramites Devengado',1);">6. Tramites Devengado
                            </a></li>
 						   <hr>
						   <li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','0','Anular proceso',1);">Anular proceso
                            </a> </li>
                       </ul>
				       <hr>
				
 					   <div class="col-md-12" style="padding-top: 15px;padding-left: 15px">
						  <input type="text" class="form-control" id="qbusqueda" placeholder="Busqueda por unidad">
 					   </div>
			
					   <div class="col-md-12" style="padding-top: 5px;padding-left: 15px">
						  <input type="text" class="form-control" id="qtramite" placeholder="Busqueda por tramite">
 					   </div>
				
					   <div class="col-md-12" style="padding-top: 5px;padding-left: 15px">
						  <input type="text" class="form-control" id="qdetalle" placeholder="Busqueda por detalle">
 					   </div>
			
						<div class="col-md-12" style="padding-top: 5px;padding-left: 15px">
							
							<select class="form-control" id="qmes"  >
							 	  <option value="-">Busqueda por mes</option>
								  <option value="1">Enero</option>
								  <option value="2">Febrero</option>
								  <option value="3">Marzo</option>
								  <option value="4">Abril</option>
								  <option value="5">Mayo</option>
								  <option value="6">Junio</option>
								  <option value="7">Julio</option>
								  <option value="8">Agosto</option>
								  <option value="9">Septiembre</option>
								  <option value="10">Octubre</option>
								  <option value="11">Noviembre</option>
								  <option value="12">Diciembre</option>
							</select>
						  
 					   </div>
				
					  
					   <div class="col-md-12" style="padding-left: 15px; padding-top: 15px">
 						  <button type="button" id="qbuton" onClick="BusquedaCliente()" class="btn btn-info btn-sm">Buscar Tramite </button> 
					  </div>
					
					<div class="col-md-12" style="padding-left: 15px; padding-top: 5px">
 						  <button type="button" onClick="modalVentana('proveedor')" class="btn btn-default btn-sm">Ir Proveedores</button> 
					  </div>
					
					<div class="col-md-12" style="padding-left: 15px; padding-top: 5px">
 						  <button type="button"id="loadSaldosg" class="btn btn-success btn-sm"><i class="icon-white icon-ambulance"></i> Actualizar </button> 
					  </div>
				
                 </div>
			
                   <!-- taba de informacion-->
                  <!--   -->	 
			
                  <div class="col-md-10" style="min-width: 80%;display:list-item">
					  
					    <div class="col-md-12" style="background: #dee7ea">
                      	<h5    id="etiqueta_estado">[ Seleccione estado tramite ] </h5>	
 						</div>
					  
					   <div class="col-md-12" style="padding-top: 5px" ></div>
 
                   	    <!-- Nav tabs -->
					  
						<ul class="nav nav-tabs" id="mytabs">
							<li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-inbox">
							</span>Bandeja de Entrada</a></li>


							<li><a href="#fproductos" data-toggle="tab"><span class="glyphicon glyphicon-apple">
							</span>  Partidas Presupuestarias</a></li>


							<li><a href="#fdoc" data-toggle="tab"><span class="glyphicon glyphicon-file">
							</span>  Informacion del tramite</a></li>


							 <li><a href="#femail" data-toggle="tab"><span class="glyphicon glyphicon-earphone">
							</span>  Notificaciones Electronicas</a></li>

						</ul>
					  

                         <!-- Tab panes  -->
					  
                 		   <div class="tab-content">
						
						 
                      		  <div class="tab-pane fade in active" id="home">
 
                       		    <div class="list-group" id = "BandejaDatos">  </div>

                       	      </div>


							   <!-- INFORMACION DEL TRAMITE  -->
					  
							   
                        	  <div class="tab-pane fade in" id="fdoc">
								  
                                 <div class="col-md-12"> 
									
                                    <div class="panel-body" >
										
                                          <div class="col-md-12">  
											  
                                                <div style="padding-top:2px;" class="col-md-2">  
												   
                                                      <div class="btn-group btn-group-justified">  
	
															<div class="btn-group">
                                                           
												 
                                                           <button type="button"   onClick="ImprimirOrden()"  title="Documento requerimiento" class="btn btn-info btn-sm" id="b2_print" >  
                                                               <span class="glyphicon glyphicon-print"></span>  
                                                           </button>
																
                                             			  </div>	
                                                           
                                                      </div>	  
												   
                                                </div>	     
											  
 											    <div style="padding-top:2px;" class="col-md-2">  
												   
                                                      <div class="btn-group btn-group-justified">  
	
															<div class="btn-group">
                                                           
												 
                                                           <button type="button"   onClick="impresion_orden_pago()"  title="GENERAR ORDEN DE PAGO" class="btn btn-danger btn-sm" id="b21_print" >  
                                                               <span class="glyphicon glyphicon-print"></span>  
                                                           </button>
																
                                             			  </div>	
                                                           
                                                      </div>	  
												   
                                            </div>	   
 											 		
										    	<div  style="padding-top:1px;" class="col-md-2">
												 <input type="text" name="nro_memo" id="nro_memo"  class="form-control" placeholder="Nro.Memorandum" size="80" maxlength="80" >
											    </div>
   									 
                                                 <div style="padding-top:1px;" class="col-md-2">
												 <input type="text" name="comprobante" id="comprobante"  class="form-control" placeholder="Nro.Comprobante" size="80" maxlength="80" readonly>
											     </div>
											  
										  </div> 
										
										  <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px">  
										
										        <div style="padding-top:1px;" class="col-md-2">
												 <input type="text" name="idasiento1" id="idasiento1"  class="form-control" placeholder="Nro.Asiento" size="80" maxlength="80" readonly>
											     </div>
											  
											    <div style="padding-top:1px;" class="col-md-4">
												 <input type="text" name="proveedor" id="proveedor"  class="form-control" placeholder="Proveedor" size="280" maxlength="280" readonly>
											     </div>
											  
											    <div style="padding-top:1px;" class="col-md-2">
												 <input type="text" name="idproveedor" id="idproveedor"  class="form-control" placeholder="Proveedor" size="280" maxlength="280" readonly>
											     </div>
											  
										   </div>   
												   
									      <div class="col-md-12"> 
                                                  
											   <div class="panel panel-default">
															  <div class="panel-heading">Detalle de Documentos</div>
																<div class="panel-body"> 
																	<div id="ViewFormfile"> </div>
																</div>
												</div>
											  
                                              
 											  
                                          </div> 
										
										
										
    									
										  <div id="mensaje_proceso" style="padding-top: 5px;" class="col-md-6">   </div>
										
                                    </div> 
									
									
                                 </div> 
								  
                              </div>
							   
						
								<!------------------------------------------------------------------------------------------------------   -->
								<!-- correo  -->
								<!------------------------------------------------------------------------------------------------------   -->
						
								<div class="tab-pane fade in" id="femail">
							
 								<div class="col-md-12"  style="padding: 5px"> 

								     <div class="col-md-12"> 
 										 
											  <h6>Mensaje Whatsapp</h6>
													 <div class="col-md-2" style="padding: 3px">  
														  <input name="bnuevow" type="button" onClick="EnviarWhatsapp()" style="font-size:12px;padding:5px 12px;border-radius:5px;background-color:#189D0E;color:white;text-shadow:none;"id="bnuevow" value=">> Enviar WhatsApp"> 
													 </div> 	 
													 <div class="col-md-10"  style="padding: 3px"> 
														 <input name="tfono" type="text"   class="form-control" id="tfono" placeholder="593">
													  </div> 	
													 <div class="col-md-12"  style="padding: 3px"> 
														  <input name="tmensajee" type="text"   class="form-control" id="tmensajee" placeholder="Mensaje a enviar"> 
													 </div> 	  
										  		 
									 </div>  
									
									 <div class="col-md-12" > 
										    <h5> <b>PROVEEDOR SELECCIONADO</b></h5>
											<div class="row" style="padding: 2px">
												
												<div id="lista_enviados">  </div> 
											</div> 
									 </div> 	  
									
							    </div> 	
							
						 </div>
                    
                       			 <!-- PARTIDAS PRESUPUESTARIAS  -->
						
                       		   <div class="tab-pane fade in" id="fproductos">
							
                      		   <div class="panel panel-default">
								   
                              	  <div class="panel-body" > 
									  
									    <!-- opciones  -->
									   <div class="col-md-12">

											   <div  class="col-md-2" style="color: #878787">
													   Certificacion
														 <input type="date" name="fcertifica" id="fcertifica"  readonly class="form-control" placeholder="Fecha Certificacion" size="80" maxlength="80" >
												   </div>

											   <div  class="col-md-2" style="color: #878787">
													   Compromiso
														 <input type="date" name="fcompromiso" id="fcompromiso" readonly  class="form-control" placeholder="Fecha Compromiso" size="80" maxlength="80" >
														</div>
 										   
										       <div  class="col-md-6" style="padding-top: 20px">
										   
												 <div class="btn-group btn-group-justified">  

															 <div class="btn-group">
																		<button type="button" id="p1_nuevo"
																			 class="btn btn-warning btn-sm" onClick="limpiaPartida();"
																			 title="Ingresar partidas presupuestarias"
																			  data-toggle="modal" data-target="#myModalProducto"> Seleccionar Partidas
																			 <span class="glyphicon glyphicon-bell"></span>  
																	   </button>
															 </div>
													 
													 		 <div class="btn-group">
																		 <button type="button" id="p2_nuevo"
																			 class="btn btn-default btn-sm" onClick="limpiaAux();"
																			 title="Ingresar beneficiarios"
																			  data-toggle="modal" data-target="#myModalAux"> Asignar Beneficiario
																			 <span class="glyphicon glyphicon-user"></span>  
																	   </button>
															 </div>

															 <div class="btn-group">
																	  <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown">
																	  Tramite a Emitir <span class="caret"></span></button>
																	  <ul class="dropdown-menu" role="menu">
																		<li><a href="#" onClick="GenerarCertificacion()" >Certificacion Presupuestaria</a></li>
																		<li><a href="#" onClick="GenerarCompromiso()"  >Compromiso Presupuestaria</a></li>
																	  </ul>
															 </div>

															

															<div class="btn-group">
																	  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
																	  Comprobantes <span class="caret"></span></button>
																	  <ul class="dropdown-menu" role="menu">
																		<li><a href="#" onClick="ImprimirActa()" >Certificacion Presupuestaria</a></li>
																		<li><a href="#" onClick="ImprimirActac()"  >Compromiso Presupuestaria</a></li>
																	  </ul>
															 </div>
												</div>
										</div>
								       </div>		   
									  
  	      
									       
                                         <div class="col-md-12"> 
                                            <table id="jsontable_partida" class="display table-condensed" cellspacing="0" width="100%">
                                                     <thead>
                                                       <tr>   
                                                            <th width="15%">Partida</th>
                                                            <th width="30%">Detalle</th>
                                                            <th width="10%">Fuente</th>    
                                                            <th width="10%">Certificacion</th>    
                                                            <th width="10%">Compromiso</th>    
                                                            <th width="10%">Devengado</th>    
                                                            <th width="15%">Acciones</th>
                                                       </tr>
                                                    </thead>  
                                             </table>
                                        </div> 	
									  
                                  </div>
                         	   </div>
                        </div>
							   
                        <!-- DOCUMENTOS -->
                        <!-- ---------------------------------------------------------------------------------------  -->
					  
					      <div class="col-md-8"> 
                         		 <h5>Avance </h5>
								<div class="progress">
									<div id="ViewAvance"> </div>
								</div>	 
                    	  </div> 
							   
							   
                   		  <div class="col-md-8"> 
                            <div style="padding: 10px">
                                <div align="left" id="ViewAvancedias" style="color: #747474"> </div>
                            </div>	 
							  
							  <div style="padding: 10px">
								
								  <div class="alert alert-warning">
										  <img src= "../../kimages/alert.png" align="absmiddle" /><strong>  Para seleccionar el registro de un clic en el codigo del trámite que esta a lado de la unidad que solicita...</strong>
										</div>
								  
								    <div class="alert alert-danger">
										  <img src= "../../kimages/alert.png" align="absmiddle" /><strong>  Si no existe proveedor/beneficiario debe ir a la opción del panel lateral izquierdo para crear la información...</strong>
										</div>
								  
								   <div class="alert alert-success">
										  <img src= "../../kimages/alert.png" align="absmiddle" /><strong>  Si desea verificar los saldos de las partidas, presione el icono de la figura de ambulancia de color verde a su izquierda...</strong>
										</div>
								  

							  </div>	
							  
							  
                  		 </div> 
							   
							   
							   
							   
                    </div>
                  </div>
         </div>
</div>  

<input name="idtramite1" type="hidden" id="idtramite1" >	
<input name="solicita1" type="hidden" id="solicita1" >
<input name="nombre" type="hidden" id="nombre" >
<input name="pag" type="hidden" id="pag" value="0">
<input name="estado1" type="hidden" id="estado1">
	
	


 <!-- ---------------------------------------------------------------------------------------  -->
<!-- ---------------------------------------------------------------------------------------  -->	

		<div class="container"> 
			
                  <div class="modal fade" id="myModalCiu" tabindex="-1" role="dialog">
                        <div class="modal-dialog" id="mdialTamanioCliente">
                            <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5  class="modal-title">Actualizacion Beneficiarios</h5>
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
                            </div>
							<!-- /.modal-content --> 
                       
					    </div>
					    <!-- /.modal-dialog -->
                  </div>
			
			  	  <!-- /.modal -->
          </div> 
	
        <!-- ---------------------------------------------------------------------------------------  -->
        <!-- ---------------------------------------------------------------------------------------  -->	
    
		<div class="container"> 
                  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" id="mdialTamanio">
                            <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5  class="modal-title">Actividades</h5>
                                      </div>
                                      <div class="modal-body">
                                            <div class="panel panel-default">
                                                      <div id="ViewFormCliente"> var</div> 
                                             </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
                                      </div>
                            </div>
							<!-- /.modal-content --> 
                        </div>
					  <!-- /.modal-dialog -->
                  </div>
				  <!-- /.modal -->
        </div>
	

        <!-- ---------------------------------------------------------------------------------------  -->	
      
		<div class="container"> 
              <div class="modal fade" id="myModalAgenda" tabindex="-1" role="dialog">
                    <div class="modal-dialog" id="mdialTamanioAgenda">
                        <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h5  class="modal-title">Agregar Recordatorio</h5>
                              </div>
                              <div class="modal-body">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
											
                                                     <div class="form-group" >
                                                        <div class="col-md-12"   style="padding: 2px">
 
                                                            <input type="text" placeholder="Recordatorio" name="textarea" id="textarea" class="form-control" >

                                                        </div>
                                                    </div>
													 <div class="form-group" >
																		<div class="col-md-12"  style="padding: 2px">
																			<div class="input-group">
																				<input type="date" class="form-control" placeholder="Fecha Evento">
																				<span class="input-group-addon"><i class="icon-time"></i></span>
																			</div>
																		</div>
													 </div>
													 <div class="form-group" >
																		<div class="col-md-12"  style="padding: 2px">
																			<div class="input-group">
																				<input type="time" class="form-control"  >
																				<span class="input-group-addon"><i class="icon-ticket"></i></span>
																			</div>
																		</div>
													 </div>
													 <div class="form-group">
																<div class="col-md-12"  style="padding: 2px">
																		<label class="checkbox">
																			<input type="checkbox" class="uniform" value=""> Envio por correo
																		</label>
																</div>
														</div>
													 <div class="modal-footer">
															 <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Crear Recordatorio</button>
															 <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
													   </div>
                                     	</div>
                                    </div>
                              </div>
                  	    </div>
						<!-- /.modal-content --> 
                    </div>
				  <!-- /.modal-dialog -->
              </div>
			  <!-- /.modal -->
        </div> 	
        <!-- ---------------------------------------------------------------------------------------  -->	
	
          <!-- /.auxiliar -->  
	
	    <div class="container"> 
		  <div class="modal fade" id="myModalAux" tabindex="-1" role="dialog">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3  class="modal-title">Selección de Auxilar (Beneficiario)</h3>
			  </div>
					  <div class="modal-body">
						 
 								 <div id="ViewFiltroAux"> var</div> 
								 <div id="Viewdetalle" style="padding-top: 5px"> </div> 
 								 <div align="center" style="padding: 10px" id="guardarAux"></div> 
						 
					  </div>
 					  <div class="modal-footer">
						<button type="button" class="btn btn-sm btn-primary"  onClick="agregar_beneficiario()">
						<i class="icon-white icon-search"></i> Guardar</button> 
						<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
					  </div>
			</div><!-- /.modal-content --> 
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	   </div> 
	
	
	
        <!-- /.PRODUCTOS --> 
	
        <div class="container"> 
              <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
                <div class="modal-dialog" id="mdialProducto">
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Productos ofertados</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">

												 <div id="ViewFormProducto"> var</div> 
												 <div id="guardarProducto" ></div> 
											 </div>

							   </div>
                          <div class="modal-footer">
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
	
	<div class="modal fade" id="myModalDocCertifica" role="dialog">
			  <div class="modal-dialog">

				  <!-- Modal content-->
				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Proceso de Liquidacion</h4>
					</div>
					<div class="modal-body">
							<div class="form-group">
							  <label for="usr">Monto Certificacion</label>
							  <input type="text" class="form-control" readonly id="mcertifica">
							</div>
							<div class="form-group">
							  <label for="pwd">Monto Devengado</label>
							  <input type="text" class="form-control" readonly id="mdevenga">
							</div>
						<div class="form-group">
						  <label for="comment">Justificacion:</label>
						  <textarea class="form-control" rows="3" id="comment"></textarea>
						</div>

						 <input type="hidden" id="mid"> 
							<div id="liquida_proceso"></div>
					</div>
					<div class="modal-footer">
						
						<button type="button" class="btn btn-danger" onClick="GuardarDatosLiquida()" >Guardar</button>
						
					    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>

				</div>
  	</div>
	
      
 </div>   
	        
 <div id="FormPie"></div>
	
 <script language="javascript" src="../../app/js/sweetalert2@11.js"></script>

 </body>
</html>
