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
	
 
 	<script type="text/javascript" src="../js/ad_chofer.js"></script> 
 	 	
	
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
 							<span class="glyphicon glyphicon-th-list"></span> <b> Lista de Personal Conductores</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ficha Personal </a>
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
												<select name="qestado"  id="qestado" class="form-control required">
															 <option value="S">Activo</option>
															 <option value="N">Desactivo</option>
												</select>
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
										 <th width="10%">Identificación</th>
									     <th width="20%">Nombre</th>
										 <th width="15%">Cargo</th>
										 <th width="15">Email</th>    
										 <th width="20%">Vehiculo Asignado</th>
										 <th width="10%">Documentos</th>
										 <th width="10%">Acciones</th>
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
					 
					  <div class="panel panel-default">
                                  <div class="panel-heading">Documentos complementarios</div>
                                    <div class="panel-body"> 
                                        <button type="button" class="btn btn-sm btn-default" id="loadDoc" >  
										  Agregar Documentos Complementarios</button>	
										 
										
                                    </div>
        </div>
                                
                                 <div class="panel panel-default">
                                  <div class="panel-heading">Detalle de Documentos</div>
                                    <div class="panel-body"> 
                                        <div id="ViewFormfile"> </div>
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
	
<div class="modal fade" id="myModalCarga" role="dialog">
	
  <div class="modal-dialog" id="mdialTamanio1">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Asignar vehiculo disponible </h4>
        </div>
        <div class="modal-body">
           <div class="row"> 
 				 <div class="col-md-12"> 
 					    <div id="asigna_vehiculo"></div> 
 						<div id="result_carga"></div>
					 </div>	  
		 		</div>
        </div>
        <div class="modal-footer">
		 <button type="button" class="btn btn-danger" onClick="AsignarVehiculo()" data-dismiss="modal">Asignar Vehiculo</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
          <h4 class="modal-title">Historial</h4>
        </div>
        <div class="modal-body">
          <p>
		     <div id="ViewFormContrato"> </div>
		  </p>
        </div>
        <div class="modal-footer">
			
			 <button type="button" class="btn btn-success" onClick="GenerarHistorial()" data-dismiss="modal">Procesar Informacion</button>
			
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
