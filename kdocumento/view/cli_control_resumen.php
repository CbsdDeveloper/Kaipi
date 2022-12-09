<?php
	session_start( );

 
   require '../model/resumen_panel.php';    

    $gestion   = 	new proceso;
 
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
	
<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>	
    
 <script type="text/javascript" src="../js/cli_control_resumen.js"></script> 
    
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
	 .di {
  			 background-color:#F5C0C1;
	  }
 	     	     	    		

 
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 3px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
	  #mdialTamanio{
  		width: 85% !important;
		}
     </style>
	
</head>
<body>


 <div id="mySidenav" class="sidenav hijo">
		<div class="panel panel-primary">
		  <div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
				<div class="panel-body">
					<div id="ViewModulo"></div>
				</div>
		</div>
   </div>
    

<div id="main">
	
	<!-- Header -->
	
   <div class="col-md-12" role="banner">
	   
 	   <div id="MHeader"></div>
	   
 	</div> 
		
 
    
    <div class="col-md-12" > 
	   
       <!-- Content Here -->
	   
	    <div class="row">
			   
  		 
								<!-- Nav tabs     <ul id="mytabs" class="nav nav-tabs" role="tablist">-->      	 
			
								<ul id="mytabs" class="nav nav-tabs">       
									
										<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b> GESTION TRAMITES</b></a>
										</li>
										 
										 
 								</ul>
	
								<!-- ------------------------------------------------------ -->
								<!-- Tab panes -->
								<!-- ------------------------------------------------------ -->
								<div class="tab-content">
											
									<!-- Tab 1 -->
									
							   			   <div class="tab-pane fade in active"   id="tab1" style="padding-top: 3px">
											   
											  <div class="panel panel-default">

												  <div class="panel-body" > 

																<div class="col-md-12" style="padding: 5px">
																			<div id="ViewFiltro"></div> 
 																</div>	
 
																<div class="col-md-12" style="padding: 7px">
																 

																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	


																	<button type="button" class="btn btn-sm btn-default" id="loadxls" title="Descargar archivo en excel">  
																	<i class="icon-white icon-download-alt"></i></button>	

																   <button type="button" class="btn btn-sm btn-default" id="loadprint" title="Imprimir Presupuesto de ingreso">  
																	<i class="icon-white icon-print"></i></button>	

															    </div>	
													 

																<div class="col-md-12" style="padding-bottom:5;padding-top:5px"> 

 
																		
																		
																		  <div id="ViewFormIngresos"> </div>
																	      
																	 

 
															   </div>

												</div>
												  
								    </div>  

											 </div> 
 									
									    
										   <!-- Tab 2 -->

										    
							 
									
				 				</div>
			 
 		</div>
	
    </div>
 
	
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
	
 </div>   
 

	<div class="container"> 
		
              <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog" id="mdialTamanio">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Verificacion de datos</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">
 												  
  												<div align="center"   id="ViewRecorrido" ></div> 
												  
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


	<div class="container"> 
		
              <div class="modal fade" id="myModalProducto_archivo" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog" id="mdialTamanio">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Detalle de archivos</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">
 												  
  												<div align="center"   id="ViewFormfileDoc" ></div> 
												  
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


     <div class="container"> 
		
              <div class="modal fade" id="myModalMemo" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Verificar secuencia</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
								  
											  <div class="panel-body">
 												   <div class="form-group">
													  <label for="Documento">Documento:</label>
													  <input type="text" class="form-control" id="doc" name="doc">
													</div>
												  
												   <div class="form-group">
													  <label for="sec">Secuencia:</label>
													  <input type="text" class="form-control" id="sec" name="sec">
													</div>
												  
												     <div class="form-group">
													  <label for="sec">Secuencia Actual:</label>
													  <input type="text" class="form-control" id="sec_actual" readonly name="sec_actual">
													</div>
												  
  												 
												   <div class="form-group">
													  <div id="datos_actualiza"></div>
 													</div>
												  
							  			     </div> 
								 
								  
								      <input type="hidden" id="cod_doc">
								  
								   <input type="hidden" id="cod_doc_ca">
								  
									  <div class="modal-footer">
										  
										  
										   <button type="button" onClick="ProcesoDoc(1)" class="btn btn-sm btn-default"  >Anular Doc</button>
										  
										   <button type="button"  onClick="ProcesoDoc(3)" class="btn btn-sm btn-success"  >Actualizar Documento</button>
										  
										  
										   <button type="button"  onClick="ProcesoDoc(2)" class="btn btn-sm btn-warning"  >Actualizar Secuencia</button>
										  
										 
 
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

 </body>
</html>
 