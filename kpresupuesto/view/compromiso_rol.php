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
 
	
	<script language="javascript" src="../js/compromiso_rol.js?n=1"></script>
 
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
	
  
	
</head>
	
<body>
<!-- ------------------------------------------------------ -->
<!-- ------------------------------------------------------ -->
	
<div id="main">

 
 
  <!-- ------------------------------------------------------ -->  
	
        <div class="col-md-12"> 
			
 			<div class="row">

				 <div class="col-sm-3 col-md-2"> </div>

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
			<!--   -->
			<div class="row">
				
                  <div class="col-md-2">
                      
                       <ul class="nav nav-pills nav-stacked">
                        
						   <li  class="active">
                            <a href="#" onClick="javascript:BusquedaGrilla('','2','2. Tramites Autorizado',1);">2. (*) Tramites Autorizado
                            </a>
                           </li>
 
                          <li>
                             <a href="#" onClick="javascript:BusquedaGrilla('','3','3. (*) Emitir Certificacion',1);">3. Certificacion Presupuestaria
                             </a>
                         </li>
                         

						<li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','5','5. Emitir Compromiso',1);">5. Compromiso Presupuestario
                            </a>
                        </li>
						
						<li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','6','6. Tramites Devengado',1);">6. Tramites Devengado
                            </a>
                        </li>
						<hr>
						
                        <li>
                            <a href="#" onClick="javascript:BusquedaGrilla('','0','Anular proceso',1);">Anular proceso
                            </a>
                        </li>
                        </li>
                     </ul>
				
 					   <hr>
 					   <div class="col-md-12" style="padding-top: 15px;padding-left: 15px">
						  <input type="text" class="form-control" id="qbusqueda" placeholder="Busqueda por unidad">
 					   </div>
			
					   <div class="col-md-12" style="padding-top: 5px;padding-left: 15px">
						  <input type="text" class="form-control" id="qtramite" placeholder="Busqueda por tramite">
 					   </div>
					  
					   <div class="col-md-12" style="padding-left: 15px; padding-top: 5px">
 						  <button type="button" id="qbuton" onClick="BusquedaCliente()" class="btn btn-info btn-sm">Buscar</button> 
					  </div>
				
                 </div>
			
                  <!-- taba de informacion-->
                  <!--   -->	 
			
                  <div class="col-md-10">

                     <h5 id="etiqueta_estado">[ Seleccione estado tramite ] </h5>	

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


                        	  <div class="tab-pane fade in" id="fdoc">
								  
                                 <div class="col-md-12"> 
									
                                    <div class="panel-body" >
										
                                          <div class="col-md-12">  
											  
                                               <div style="padding-top:2px;" class="col-md-2">  
												   
                                                      <div class="btn-group btn-group-justified">  
	
															<div class="btn-group">
                                                           
																<!--	<button type="button"   onClick="PonePlantilla()" title="Plantilla documento" class="btn btn-default btn-sm" id="b2_planilla" >  
																				<span class="glyphicon glyphicon-paperclip"></span>  
																		</button>
																	 &nbsp; &nbsp;
																		<button type="button"   onClick="GuardarPedidoMemo()" title="Guardar Informacion" class="btn btn-warning btn-sm" id="b2_save" >  
																				<span class="glyphicon glyphicon-saved"></span>  
																		</button>
																-->
                                                           <button type="button"   onClick="ImprimirOrden()"  title="Documento requerimiento" class="btn btn-info btn-sm" id="b2_print" >  
                                                               <span class="glyphicon glyphicon-print"></span>  
                                                           </button>
																
                                             			  </div>	
                                                           
                                                      </div>	  
												   
                                                </div>	     
											 		
												<div  style="padding-top:1px;" class="col-md-3">
												 <input type="text" name="nro_memo" id="nro_memo"  class="form-control" placeholder="Nro.Memorandum" size="80" maxlength="80" >
											    </div>
 									 
                                                 <div style="padding-top:1px;" class="col-md-3">
												 <input type="text" name="comprobante" id="comprobante"  class="form-control" placeholder="Nro.Comprobante" size="80" maxlength="80" readonly>
											     </div>
												   
											     <div id="mensaje_proceso" style="padding-top: 5px;" class="col-md-6">   </div>
											 
											  
                                         </div> 
                                			
                                          <div class="col-md-12"> 
                                                  
                                                <h5><b>Asunto</b></h5>
                                                 <div class="col-md-10" align="center" style="padding: 7px;z-index: 800">
                                                         <textarea  id="editor6" name="editor6"   > </textarea>
                                                </div> 
                                          </div> 
    												 	 
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
                    
                        <!-- productos -->
						
                        <div class="tab-pane fade in" id="fproductos">
							
                      		   <div class="panel panel-default">
								   
                              	  <div class="panel-body" > 
									  
									    <!-- certificacion  -->
									  
 										<div class="col-md-12" id="visible1">
											
											   <div style="padding-top: 10px;" class="col-md-1" align="right">
													 Certificacion
												</div>
												
												<div  class="col-md-2">
												 <input type="date" name="fcertifica" id="fcertifica"  class="form-control" placeholder="Fecha Certificacion" size="80" maxlength="80" >
											    </div>
											
											    <div class="col-md-6">
													
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
																 <button type="button" id="p1_savec"  onClick="GenerarCertificacion()"  title="Generar Certificacion" class="btn btn-danger btn-sm" id="bpartida_nuevo" >  Generar Certificacion
																	   <span class="glyphicon glyphicon-ok-sign"></span>  
																 </button>
											 				</div> 
															
															<div class="btn-group">
																 <button type="button" id="p1_print_c"  onClick="ImprimirActa()"  title="Imprimir Certificacion" class="btn btn-info btn-sm" id="bpartida_imprime" >  Imprimir Comprobante
																	   <span class="glyphicon glyphicon-print"></span>  
																 </button>
														    </div> 		
													
 											 			 </div> 
													
 									     		 </div> 
											
										 </div> 	
											
											
									   <!-- compromiso  -->
									  
									     <div class="col-md-12" style="padding-top: 10px;" id="visible2">
										   
									 		   <div   style="padding-top: 10px;" class="col-md-1" align="right">
													 Compromiso
												</div>
												
												<div  class="col-md-2">
												 <input type="date" name="fcompromiso" id="fcompromiso"  class="form-control" placeholder="Fecha Compromiso" size="80" maxlength="80" >
											    </div>
										   
										   		<div class="col-md-7">
													
													 <div class="btn-group btn-group-justified">  
	
															<div class="btn-group">
 																 <button type="button" id="p1_nuevo"
																	 class="btn btn-default btn-sm" onClick="limpiaAux();"
																	 title="Ingresar beneficiarios"
																	  data-toggle="modal" data-target="#myModalAux"> Asignar Beneficiario
																	 <span class="glyphicon glyphicon-user"></span>  
															   </button>
												  			</div>
														 
														    <div class="btn-group">
															   <button type="button" id="p1_savecc"  onClick="GenerarCompromiso()"  title="Generar Compromiso" class="btn btn-success btn-sm" id="bpartida_nuevo" >  Generar Compromiso 
																	   <span class="glyphicon glyphicon-book"></span>  
																 </button>
													 		</div>
														 
														 <div class="btn-group">
															 <button type="button" id="p1_print_d"  onClick="ImprimirActa()"  title="Certificacion" class="btn btn-info btn-sm" id="bpartida_imprime" >  Certificacion
																   <span class="glyphicon glyphicon-print"></span>  
															 </button>
														</div>	 
													
														 <div class="btn-group">
															 <button type="button" id="p1_print_d"  onClick="ImprimirActac()"  title="Compromiso" class="btn btn-warning btn-sm" id="bpartida_imprime" >  Compromiso
																   <span class="glyphicon glyphicon-print"></span>  
															 </button>
													      </div>	
													 </div>
													
										        </div>
										   
									     </div> 
									       
                                         <div class="col-md-12"> 
                                            <table id="jsontable_partida" class="display table-condensed" cellspacing="0" width="100%">
                                                     <thead  bgcolor=#F5F5F5>
                                                       <tr>   
                                                            <th width="15%">Partida</th>
                                                            <th width="35%">Detalle</th>
                                                            <th width="10%">Fuente</th>    
                                                            <th width="10%">Certificacion</th>    
                                                            <th width="10%">Compromiso</th>    
                                                            <th width="10%">Devengado</th>    
                                                            <th width="10%">Acciones</th>
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
	
	<script type="text/javascript" src="../../tinymce/tinymce.min.js"></script>

    <script>
         tinymce.init({ 
                                                  selector: 'textarea',
                                                      height: 250,
                                                       plugins: [
                                                    "advlist autolink lists link image charmap print preview anchor",
                                                    "searchreplace visualblocks code fullscreen",
                                                    "insertdatetime media table contextmenu paste"
                                                ],
                                                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                                                 relative_urls: false,
                                                 remove_script_host : false,
                                                 file_browser_callback: openKCFinder

         });
         // function openKCFinder(field_name, url, type, win) {
		function openKCFinder(field_name, url, type, win) {
                                                    tinyMCE.activeEditor.windowManager.open({
                                                     file: '../../keditor/kcfinder3/browse.php?opener=tinymce4&field=' + field_name + '&type=' + type,
                                                 //	file: '../../keditor/ckfinder/ckfinder.html',
                                                        title: 'KCFinder',
                                                        width: 750,
                                                        height: 400,
                                                        resizable: true,
                                                        inline: true,
                                                        close_previous:  false
                                                    }, {
                                                        window: win,
                                                        input: field_name
                                                    });
                                                    return false;
                                                 }
  </script> 
	
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
      
 </div>   
	        
 <div id="FormPie"></div>
	
 </body>
</html>
