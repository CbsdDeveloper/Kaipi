<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/inv_punto.js"></script> 
 
 	 
	<style>
        
    	#mdialTamanio{
      			width: 55% !important;
   			 }
     
        #mdialTamanioPrecio{
      			width: 50% !important;
   			 }
        
		#mdialTamanioPago{
      			width: 75% !important;
   			 }
		
		
		
		 #mdialTamaniopvp{
      			width: 50% !important;
   			 }
        .casillero {
			 width: 80px;
   			 padding: 2px;
			text-align:right; 
			border:rgba(193,193,193,1.00)
		}
  </style>
	
 
	
</head>
<body>
 
 
<!-- ------------------------------------------------------ -->
 <div id="main">
 
 
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
                   		<span class="glyphicon glyphicon-user"></span> <b>USUARIO CAJA <?php echo strtoupper($_SESSION['login']); ?>/ <?php echo  ($_SESSION['email']); ?></b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span>DETALLE DE FACTURACION DIARIA</a>
                  		</li>
	   
	 
	 
            </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
                   <!-- ------------------------------------------------------ -->
                   <!-- Tab 1 -->
                   <!-- ------------------------------------------------------ -->
                     <div class="tab-pane fade in active" id="tab1">
 								<div class="col-md-12"> 
                         			   <div id="ViewForm"> </div>
						        </div>
 
							<input type="hidden" id="banderadd" name="banderadd" value="0">
						 
                     </div>
 
                     <!-- ------------------------------------------------------ -->
                     <!-- Tab 2 -->
                     <!-- ------------------------------------------------------ -->
			   
                      <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px"> 
						 
                            <div class="panel panel-default">
                                  <div class="panel-body" > 

                                        <div class="col-md-12" > 
                                             <div class="alert alert-info">
                                                   <div class="row">
                                                            <div id = "ViewFiltro" > </div>

                                                            <div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 

                                                            <div class="col-md-4" style="padding-top: 5px;">
                                                                    <button  type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
                                                            </div>
                                                    </div>
                                              </div>
                                         </div> 

                                        <div class="col-md-12"> 
                                                <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
                                                                         <thead  bgcolor=#F5F5F5>
                                                                           <tr>   
                                                                                 <th width="10%" >Fecha</th>
                                                                                 <th width="10%">Nro.Factura</th>
                                                                                 <th width="20%">Cliente</th>
                                                                                 <th width="10%">Base Imponible</th>
                                                                                 <th width="5%">IVA</th>
                                                                                 <th width="10%">Base Tarifa 0</th>
                                                                                 <th width="10%">Total</th>
                                                                                 <th width="5%">Cerrado</th>
                                                                                 <th width="5%">Autorizacion</th>
                                                                                <th width="15%">Accion</th>
                                                                           </tr> 
                                                                    </thead>
                                                    </table>
                                         </div>  

                                  </div>  
                             </div> 

                        </div> 
 			   
          	 </div>
		   
 	</div>
 	    
    <div id="respuesta"></div>
 	
    <div id="SaldoBodega"> </div>  
 
	<div class="modal fade" id="myModalSerie" role="dialog">
		  <div class="modal-dialog" id="mdialTamanio1">
			<!-- Modal content-->
			 <div class="modal-content">
			 <div class="modal-header">
			  <button type="button" class="close"  data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Articulo</h4>
			 </div>
			 <div class="modal-body">
				 <div class='row'>
						 <div class="alert alert-info">
							 <div class="row">
								<div class="col-md-2" style="padding-top: 5px;">Cargar Series de articulos</div> 
								<div class="col-md-4" style="padding-top: 5px;">

									<input type="hidden" id="idproducto_serie" name="idproducto_serie">
								 <input type="text" class="form-control" name="serie" id="serie" value="0" readonly>
								 </div>  

							 </div>
						 </div>
						<div class="col-md-12" style="padding-top: 5px;">
							  <div id='global' >
										<div id='VisorSerie'></div>
										<div id='GuardaSerie'></div>
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
	 
	
    <!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
			  <div class="modal-dialog" id="mdialTamanio">
 				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close"  data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Articulo</h4>
					</div>
					<div class="modal-body">
						
						  <div id="VisorArticulo"  style="overflow-y:scroll; overflow-x:hidden; height:400px; padding: 5px;width:100% "> </div>
 				 
						
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
 			</div>
		  </div>
	<!-- Modal -->
	<div class="modal fade" id="myModalPrecio" role="dialog">
			  <div class="modal-dialog" id="mdialTamanioPrecio">
 				  <div class="modal-content">
					<div class="modal-header">
					  <button type="button" class="close"  data-dismiss="modal">&times;</button>
					  <h4 class="modal-title">Articulo</h4>
					</div>
					<div class="modal-body">
					 <div id='VisorArticuloPrecios'></div>
					</div>
					<div class="modal-footer">
					  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				  </div>
 			</div>
	 </div>
	
	<!-- Modal -->
 
 
     <!-- Page Footer-->
   <div id="FormPie"></div>  
    
 </div>   

 </body>

</html>
