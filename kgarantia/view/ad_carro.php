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
	
	
	
	
 <style type="text/css">
	 
	 
 	 
	 #mdialTamanio{
  					width: 75% !important;
		}
  		 
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#c3e1fb;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
	 
	
  </style>
	
 
 	<script type="text/javascript" src="../js/ad_carro.js"></script> 
 	 	
	
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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>  LISTA DE VEHICULOS DE LA INSTITUCIÓN </b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> FICHA TECNICA VEHICULO</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span> HISTORIAL ADMIN-FINANCIERO</a>
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
		  		  	     
		  		  	      			<div class="col-md-12" style="background-color:#ededed;padding: 10px">
   									     
							   			  <div class="col-md-2" style="padding: 10px"> 
											  
											  <button type="button" id="load" class="btn btn-success">Actualizar</button>
										 
     								      </div> 
 				  		    		 </div> 
 			  		  	     
													 <div class="col-md-12"> 
														 
														
														 
													  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
															 <thead  bgcolor=#F5F5F5>
															   <tr>   
																			<th width="5%">Codigo</th>
																			<th width="10%">Marca</th>
																			<th width="25%">Detalle</th>
																			<th width="10%">Placa</th>
																			<th width="10%">Año</th>
																   			<th width="10%">Codigo</th>
																  		    <th width="10%">Status</th>
																   			<th width="10%">Km(s)</th>
																   			<th width="5%">Matricula</th>
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
						    
								 
								
								    
								
								    <div class="panel panel-info">
									  <div class="panel-heading">Detalle Historial</div>
									  <div class="panel-body">
										  
										 <div id="ViewFormFin" style="padding: 10px"></div>
										
										</div>
									</div>
							 	 
						   
               		       </div>
                	  </div>
             	 </div>
			   
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
	
<!-- 	<a href="#" class="btn-flotante">Ayuda</a> --> 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
     
 </body>
</html>
