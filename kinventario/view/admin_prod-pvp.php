<?php
	session_start( );
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/admin_prod-pvp.js"></script> 
 	 
    
    
    <style>
        
    	#mdialTamanio{
      			width: 55% !important;
   			 }
     
        #mdialTamanio2{
      			width: 65% !important;
   			 }
        
				.highlight {
			  background-color: #FF9;
			}
		.ye {
			  background-color:#93ADFF;
			}
		
		 .ye0 {
 		 background-color:#FF9;
		}
		
		.ye1 {
 		 background-color:#bbcbff;
		}
		
		.ye2 {
 		 background-color:#e482dd;
		}
		
		.ye3 {
 		 background-color:#90ff99;
		}
		
		.sal {
 		 background-color: #33C927;
		}
        
  </style>
    
</head>
<body>

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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>DEFINICION PRODUCTOS </b>  </a>
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
                                	 	 
									 
									         <div class="alert alert-info"><div class="row">
  													<div id = "ViewFiltro" > </div>
  										
  													<div class="col-md-2" style="padding-top: 5px;">&nbsp;</div> 
													<div class="col-md-4" style="padding-top: 5px;">
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
														
														<button type="button" title="Saldos Bodega" class="btn btn-sm btn-default" id="loadSaldo" title="Saldos de bodega">  
													<i class="icon-white icon-ambulance"></i></button>
														
														
													 <button type="button" title="Variables Precio" data-toggle="modal" data-target="#myModal"  class="btn btn-sm btn-default" id="loads" title="Saldos de bodega">  
													<i class="icon-white icon-dollar"></i></button>
														
												</div>
								 			 </div>
								  			</div>
   								     
 				  		     </div> 
			  		  	     
 			  		  	     <div class="col-md-12"> 
								 
 					  				   <div id="ViewProceso"> </div>
 								 
									   <div id="SaldoBodega"></div>
								 
                             </div>  
                          </div>  
                     </div> 
             </div>
        
			    
			   
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   

<div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" id="mdialTamanio">
    
<!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Variables</h4>
        </div>
        <div class="modal-body">
			 <div class="row">
			
			 <div class="col-md-6" style="padding-top: 5px"> 
			<div class="form-group">
			  <label for="usr">Margen Utilidad:</label>
			  <input type="text" class="form-control" id="util" value="0.15">
			</div>
			
			<div class="form-group">
			  <label for="usr">Traslado/Movilizacion:</label>
			  <input type="text" class="form-control" id="trasporte" value="0.05">
			</div>
			
			<div class="form-group">
			  <label for="usr">Mercado Compentencia</label>
			  <input type="text" class="form-control" id="vip" value="0.10">
			</div>
			
			 <div class="form-group">
			  <label for="usr">Costo Operativo:</label>
			  <input type="text" class="form-control" id="integrador" value="0.05">
			</div>
			
			</div>
			
			
			
			 <div class="col-md-6" style="padding-top: 5px"> 
			 <div class="form-group">
			  <label for="usr"><b>% ESTIMADO DE UTILIDAD:</b></label>
			  <input type="text" class="form-control" disabled id="pvp1" value="0.35">
			</div>
			
		 
			
			 
           </div>
			
			 </div>
        </div>
        <div class="modal-footer">
			
			<button type="button" class="btn btn-success" onClick="Procesar();" data-dismiss="modal">Procesar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div class="modal fade" id="ViewCarga" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Visor de Carga Inicial</h4>
        </div>
        <div class="modal-body">
          <div class="row">
			  <div id = "ViewFiltroCarga" > </div>
			  
		  </div>
        </div>
        <div class="modal-footer">
			 <div id = "DatosCarga" > </div>
			
			<button type="button" class="btn btn-warning" onClick="CargaInicialDato()" data-dismiss="modal">Guardar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<div class="modal fade" id="ViewCodigo" role="dialog">
    
  <div class="modal-dialog" id="mdialTamanio2">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Codigo Externo Articulo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
               <div id = "DatosCarga1" align="center"> Mensaje </div>
              
			  <div id = "ViewFiltroCodigo"> </div>
			  
              	
		  </div>
        </div>
        <div class="modal-footer">
		
			
			<button type="button" class="btn btn-warning" onClick="ActualizaCodigo()" data-dismiss="modal">Guardar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


 </body>
</html>
