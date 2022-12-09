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
    
 <script type="text/javascript" src="../js/inv_importaciones_li.js"></script> 
    
    <style>
        
    	#mdialTamanio{
      			width: 55% !important;
   			 }
		 .highlight {
		  background-color: #FF9;
		}
		 .ye {
		  background-color:#93ADFF;
		}
      
        
  </style>
    
</head>
<body>
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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
	 <!-- Content Here -->
	    <div class="row">
 		 	     <div class="col-md-12">
					  	 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>IMPORTACIONES LISTA EMITIDAS </b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Importacion</a>
                  		</li>
                        <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-import"></span> GENERAR PROCESO DE COSTOS Importacion</a>
                  		</li>
                       
            	    </ul>
		 
                     <!-- ------------------------------------------------------ -->
                   <!-- Tab panes -->
                   <!-- ------------------------------------------------------ -->
                   <div class="tab-content">
                           <!-- Tab 1 -->
                           <div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                              <div class="panel panel-default">
                                  <div class="panel-body" > 
                                    <div class="col-md-12" style="padding: 1px">
                                                           <div class="col-md-3" style="background-color:#EFEFEF">
                                                                    <h5>Filtro búsqueda</h5>
                                                                    <div id="ViewFiltro"></div> 

                                                                    <label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
                                                                    <div style="padding-top: 5px;" class="col-md-9">
                                                                            <button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
                                                                    </div>
                                                                    <label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
                                                            </div>
                                                             <div class="col-md-9">
                                                                <h5>Transacciones por periódo</h5>
                                                               <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                                  
                                                                                            <thead>
                                                                                                <tr>
                                                                                                <th width="10%">Codigo</th>
                                                                                                <th  width="10%">Fecha</th>
                                                                                                <th width="10%">DAI</th>
                                                                                                <th width="10%">Distrito</th>
                                                                                                <th width="10%">Regimen</th>
                                                                                                <th width="10%">Procedencia</th>
                                                                                                <th width="10%">FOB</th>
                                                                                                <th width="10%">Flete</th>
                                                                                                <th width="10%">Seguro</th>
                                                                                                <th width="10%">Acción</th>
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
                                       <div id="ViewForm"  > </div>
                                       <div id="FacturaElectronica"  > </div>
                                  </div>
                              </div>
                           </div>
                     
                           <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                              <div class="panel panel-default">
                                    <div class="panel-body" > 
 									       <div class="panel panel-info">
                                          		<div class="panel-heading">Detalle de Pagos Efectuados a la Importacion</div>
  											       <div id="DetalleGasto"> </div>
 											      <div class="col-md-12" style="padding: 15px">
													  
													  <div class="col-md-4">
														 <button id="bprocesof" type="button" class="btn btn-success">Procesar costo financiero</button>
												       </div>
 													  <div class="col-md-4" align="right">
														  Total gasto a distribuir
												       </div>
													  <div class="col-md-4">
												   			<input type="number" id="total_gasto_resumen" readonly class="form-control">
													  </div>
											      </div>
											     <div id="DistribuyeGasto"> </div>
                                           </div>
										
									     
 
										   <div class="panel-heading">Detalle de items facturas Importacion</div>
                                        	<div class="panel-body">
                                                                <table id="jsontable_items" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                                  
                                                                                            <thead>
                                                                                                <tr>
                                                                                                <th width="10%">Partida</th>
                                                                                                <th  width="15%">Mercaderia</th>
                                                                                                <th width="10%">Costo</th>
                                                                                                <th width="10%">Advalorem</th>
                                                                                                <th width="10%">Otros Aranceles</th>
                                                                                                <th width="10%">Costo Importacion</th>
                                                                                                <th width="10%">% Peso</th>
																								<th width="10%">Costo Financiero</th>	
																								<th width="10%">Costo Item</th>		
                                                                                                <th width="5%">Acción</th>
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
    </div>
   
  	<!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
     <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Facturas</h4>
        </div>
        <div class="modal-body">
          
              <div id="ViewFactura"  > </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

 <!-- Modal -->
  <div class="modal fade" id="myModalItems" role="dialog">
     <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Items Facturas</h4>
        </div>
        <div class="modal-body">
          
              <div id="ViewFacturaItems"  > </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 </body>
</html>
 