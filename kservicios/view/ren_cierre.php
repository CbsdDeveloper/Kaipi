<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/ren_cierre.js"></script> 
	
	
	<script type="text/javascript" src="../js/facturae.js"></script> 
 	 
	<style>
		
    	#mdialTamanio{
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
                                                                <div id = "ViewFiltro" > </div>

                                                                <div class="col-md-2" style="padding-top: 5px;">&nbsp;
                                                                </div> 
                                                                <div class="col-md-8" style="padding-top: 5px;">
                                                                <button type="button" class="btn btn-sm btn-primary" id="load">
                                                                    <i class="icon-white icon-search"></i> Buscar</button>
 
                                                                	
													  
													 			  
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
													    <th width="10%">Emitido</th>
                                                         <th width="5%">Nro.Factura</th>
                                                         <th width="5%">Nro. Doc.</th>
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
                                         
                                          <div class="col-md-12">   
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

                         
                     

                         
	
          	 </div>
		   
 		</div>
	 
    
	

     <!-- Page Footer-->
     <div id="FormPie"></div>  
    
 </div>   


	
    <div class="modal fade" id="myModalFac_view" role="dialog">
                             <div class="modal-dialog" id="mdialTamanio">
                                 <!-- Modal content-->
										 <div class="modal-content">
											<div class="modal-header">
											  <button type="button" class="close"  data-dismiss="modal">&times;</button>
											  <h4 class="modal-title">Emitir Comprobante electronico</h4>
											</div>
											<div class="modal-body">
												 
													<div class="row">
														
														<div class="col-md-12"> 
															
															<div id="lista_datos"> </div>	
														 
														</div>	
														
														 <div align="center" id="Resultado_facturae_id"> </div>	
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
