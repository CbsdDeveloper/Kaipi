<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 

	<script type="text/javascript" src="../js/ad_combustible_in.js"></script> 
 	 	
	
</head>
	
<body>

<div id="main">
	
   <!-- ------------------------------------------------------ -->  
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
      
       		 <!-- Content Here -->
	 
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 							<span class="glyphicon glyphicon-th-list"></span> <b> Control de Combustible Uso Interno</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Registro de Combustibles </a>
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
												 
												 <div class="col-md-2"  style="padding-top: 5px;">
 													 <input type="month"  name="qmes"  id="qmes" class="form-control required">
  												 
										          </div> 
									 			
											   
											   <div class="col-md-2"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
												   
												   <button type="button" class="btn btn-sm btn-info" id="excelload"><i class="glyphicon glyphicon-download-alt"></i>  </button>
												   
								   			  </div> 
									   		</div> 
						   	   </div> 		
  								 
 				  		     </div> 
		  		  	      
		  		  	     
			  		  	     <div class="col-md-12"> 
								 
 								
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
										 <th width="5%">Id</th>
									     <th width="5%">Fecha</th>
										 <th width="5%">Hora</th>
										 <th width="10%">Comprobante</th>    
										 <th width="45%">Motivo</th>
										 <th width="10%">Combustible</th>
									     <th width="5%">Cantidad</th>
										 <th width="5%">Costo</th>
										 <th width="5%">Total</th>
										 <th width="5%">Acciones</th>
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
 						
						  <div class="col-md-12" style="padding: 10px"> 
							  <div class="panel panel-default">
								  
									<div class="panel-body" > 
										
										<div id="ViewForm"> </div>
 										
									 </div>
						       </div>
							  
						    </div> 
						  
						    
  					 
           	 </div>
              
               
			        <!-- ------------------------------------------------------ -->
                 <!-- Tab 3 -->
                 <!-- ------------------------------------------------------ -->
                
			 
              
               
   		  </div>
		   
		</div>
   	  
    </div>
  </div>	
	
	
<div class="modal fade" id="myModalContrato" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ordenes de movilizacion</h4>
        </div>
        <div class="modal-body">
           <form>
 				  <div class="input-group" style="padding: 5px">
					<span class="input-group-addon">Nro.Orden Movilizacion</span>
					<input id="vorden" type="text" class="form-control" name="vorden" placeholder="Ingrese orden de movilizacion">
				  </div>
			   
			    <div class="input-group" style="padding: 5px">
					<span class="input-group-addon">Buscar Nro.Placa </span>
					<input id="vcarro" type="text" class="form-control" name="vcarro" placeholder="Ingrese Vehiculos/Maquinaria">
				  </div>
			   
			    <div class="input-group" style="padding: 5px">
					<span class="input-group-addon">Conductor/Responsable</span>
					<input id="vchofer" type="text" class="form-control" name="vchofer" placeholder="Ingrese Conductor/Responsable">
				  </div>
			   
				</form>
			
			     <div class="input-group" style="padding: 5px">
			
				  <div id="matriz_orden"></div>
				 
				 
				  </div>
		  
        </div>
		 
		  
        <div class="modal-footer">
			
			 <button type="button" class="btn btn-warning" onClick="LimpiarOrden()">Limpiar Informacion</button>
			
			 <button type="button" class="btn btn-success" onClick="BuscarOrden()">Buscar Informacion</button>
			
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
