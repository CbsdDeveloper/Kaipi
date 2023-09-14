<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/inv_nota_creditop.js"></script> 
 	 
	<style>
    	#mdialTamanio{
      			width: 55% !important;
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
                   				<span class="glyphicon glyphicon-th-list"></span> <b> NOTAS DE CREDITO GENERADAS</b>  </a>
                   		</li>
                  	 
	
	
	 					<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-bell"></span>  Emision Notas de Credito </a>
                  		</li>
     
                      
	 
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content" >
            
                       <!-- ------------------------------------------------------ -->
                       <!-- Tab 1 -->
                       <!-- ------------------------------------------------------ -->

                        <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
							
                                  <div class="panel panel-default">

                                    <div class="panel-body" > 
                                        <div class="col-md-12"> 
											  <h4> Lista de Notas de Creditas Emitidas </h4>
											
											  			 <div class="col-md-3" style="padding: 10px">
												  
																<input name="nc_anio" type="number" class="form-control" id="nc_anio" max="2050" min="2010"> 
															 
														  </div>
											
											
														  <div class="col-md-6" style="padding: 10px">

																			<button type="button" class="btn btn-sm btn-primary" id="loadNota">
																				<i class="icon-white icon-search"></i> Buscar</button>

														  </div>
											
								      </div> 
 
                                            <div class="col-md-12"> 
                                              <table id="jsontableNota" class="display table-condensed" cellspacing="0" width="100%">
                                                     <thead  bgcolor=#F5F5F5>
                                                       <tr>   
                                                             <th width="10%">Fecha</th>
														     <th width="10%">Identificacion</th>
														     <th width="20%">Cliente</th>
														     <th width="5%">N/C</th>
                                                             <th width="25%">Autorizacion</th>
                                                             <th width="15%">Documento Modificado</th>
														     <th width="5%">Asiento </th>
														     <th width="5%">Fecha</th>
														     <th width="5%"></th>
                                                       </tr> 
                                                </thead>
                                             </table>
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

										<div class="col-md-12" style="padding-top: 5px"> 
 		  						  				<div id="ViewForm1"> </div>
											    <div id="ViewNotaDetalle"> </div>
									    </div>
							
									<div class="col-md-12" style="padding-top: 5px"> 

											 <div id="resultadoNota"> </div>
 
                                              <div id="FacturaElectronicaNc">Generar comprobante </div>
									 </div>
										
										<div class="col-md-12" style="padding-top: 5px"> 

											  <button type="button" class="btn btn-info btn-sm" onClick="DetalleOriginal()" data-toggle="modal" data-target="#myModalOriginal">Detalle de Factura Original</button>

 
                                            
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
	
	
	     <!-- Modal -->
	
	      <div class="modal fade" id="myModalweb" role="dialog">
		 
			  <div class="modal-dialog" id="mdialTamanio">

		<!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Articulo</h4>
				</div>
							<div class="modal-body">
								  <div class="modal-header">
										 <div id='VisorArticuloWeb'></div>
									  
									     <div id='VisorArticuloWebDato'></div>
								</div>
							</div>
				<div class="modal-footer">
					 <button type="button" title="Transaccion cambia al estado digitado" class="btn btn-danger" onClick="ActualizaFac('1')" >Digitado</button>
					 <button type="button" title="Cambia las fechas de la factura sin modificar valores" class="btn btn-success" onClick="ActualizaFac('2')" >Fechas</button>
					 <button type="button" title="Permite generar nuevamente el comprobante electronico, limpiando las variables" class="btn btn-info" onClick="ActualizaFac('3')" >Limpiar Autorizacion</button>
					
					<button type="button" title="Quita el enlace del asiento contable generado desde el modulo de facturacion" class="btn btn-warning" onClick="ActualizaFac('4')" >Quitar Enlace</button>
					
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>

			</div>
		  </div>
	
	
		 <div class="modal fade" id="myModalArqueo" role="dialog">
			 
			  <div class="modal-dialog" id="mdialTamanio">

		<!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Arqueo de caja</h4>
				</div>
				<div class="modal-body">
				
					<div  class="col-md-12">
					    <div id='VisorArticuloArqueo'></div>
			   	    </div>
					
					<div  class="col-md-12" align="center" id="total_caja" style="padding: 16px;font-size: 18px;font-weight:800 ">
					</div>
					
				</div>
				<div class="modal-footer">
					
					<button type="button" onClick="Resumenarqueo()" class="btn btn-info" >Resumen Arqueo Caja</button>
					
					<button type="button"  onClick="GuardaArqueo()" class="btn btn-danger">Guardar Arqueo Caja</button>
					
				    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
				</div>
			  </div>

			</div>
		  </div>
	
	
	    <div class="modal fade" id="myModalOriginal" role="dialog">
		 
			  <div class="modal-dialog" id="mdialTamanio">

		<!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Articulo</h4>
				</div>
				<div class="modal-body">
				 <div id='VisorArticuloOriginal'></div>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>

			</div>
		  </div>
	
	
	
	<input type="hidden" id="movi" name="movi">
	
     <!-- Page Footer-->
     <div id="FormPie"></div>  
    
 </div>   
 </body>
</html>
