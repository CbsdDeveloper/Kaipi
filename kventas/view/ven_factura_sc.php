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
 
 	<script type="text/javascript" src="../js/ven_factura_sc.js"></script> 
 	 
	<style>
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		iframe { 
			display:block; 
			width:100%;  
			border:none;
			height: 550px;
			margin:0; 
			padding:0;
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
	<!-- Header -->
	  <div class="col-md-12" role="banner" style="padding: 1px"> 
		  <div id="MHeader"></div>
	 </div>
 	
  <!-- ------------------------------------------------------ -->  
   <div class="col-md-12"> 
        		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		     
			  		    <li class="active"><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span>Emisión Facturación</a>
                  		</li>
			   
                   		<li ><a href="#tab1" data-toggle="tab"></span>
                   		<span class="glyphicon glyphicon-th-list"></span> <b>DETALLE DE FACTURAS EMITIDAS</b>  </a>
                   		</li>
                  		
					   <li><a href="#tab4" data-toggle="tab">
											<span class="glyphicon glyphicon-cloud-download"></span> Búsqueda de comprobantes electrónicos</a>
					   </li>
	 
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
            
			   <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in active" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default" style="padding: 1px">
				        <div class="panel-body" style="padding: 1px"> 
 									<div id="ViewForm"> </div>
                		       </div>
                	  </div>

             	 </div>
           <!-- ------------------------------------------------------ -->
           <!-- Tab 1 -->
           <!-- ------------------------------------------------------ -->
       
            <div class="tab-pane fade in" id="tab1" style="padding-top: 3px">
                      <div class="panel panel-default">
						  <div class="panel-body" > 
 							<div class="col-md-12"  > 
                                	 	 
				         <div class="alert alert-info"><div class="row">
  													<div id = "ViewFiltro" > </div>
  										
  													<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 
													<div class="col-md-4" style="padding-top: 5px;">
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
												</div>
								 			 </div>
								  			</div>
   								     
 				  		     </div> 
			  		  	     
 			  		  	     <div class="col-md-12"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
													 <thead  bgcolor=#F5F5F5>
													   <tr>   
															 <th width="10%">Fecha</th>
															 <th width="10%">Nro.Factura</th>
															 <th width="20%">Cliente</th>
															 <th width="10%">Base Imponible</th>
															 <th width="10%">IVA</th>
															 <th width="10%">Base Tarifa 0</th>
															 <th width="10%">Total</th>
															 <th width="5%">Cerrado</th>
															 <th width="5%">Autorizacion</th>
															<th width="10%">Accion</th>
													   </tr> 
												</thead>
											 </table>
								 
								 <div id="ViewCuenta"> Contabilizar </div>
                             </div>  
			 						  
                          </div>  
                     </div> 
             </div>
           
			   <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
									  <div class="panel panel-default">
										  <div class="panel-body" > 
											  <div class="col-md-12" align="center"> 
												  	<small>Si no puedes visualizar presiona <a href="http://factura100.com:28080/ConsultaWeb/" target="_blank">aqui</a></small>
											  </div>
											  
											  
										    <div class="col-md-12"> 
										 	  
											 <iframe src="http://factura100.com:28080/ConsultaWeb/loginMunicipio.xhtml"></iframe>

											 

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
     <!-- Page Footer-->
   <div id="FormPie"></div>  
 </div>   
 </body>
</html>
