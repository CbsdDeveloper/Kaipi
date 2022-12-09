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
 
 	 <script type="text/javascript" src="../js/ac_bienes_soft.js"></script> 
 	 
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js"></script>   
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js"></script>
	
	 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
		}
	 
	  #mdialTamanio1{
  					width: 70% !important;
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b> CATALOGO  DE SOFTWARE </b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle de información</a>
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
											  
  					  <div class="col-md-12" style="background-color:#ededed;padding-bottom: 20px;padding-top: 20px">
													    
 														 
														   
 															<div class="col-md-3" style="padding-top: 8px">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
																
																   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
															</div>
						  
						 								    <div class="col-md-9" align="right" style="padding-top: 8px">
																	<button type="button" class="btn btn-sm btn-danger" onClick="LimpiarPantalla()"  data-toggle="modal" data-target="#myModal">  
																	<i class="icon-white icon-archive"></i> Nuevo</button>	
																
 																
															</div>
													 
						  
 
					 </div>
					  <div class="col-md-12" id="jsontable_div" >
				 		        <h5>Registro de Software</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="20%">Categoria</th>
																						<th width="30%">Detalle</th>
																						<th width="15%">Licencia</th>
																						<th width="10%">Usuario</th>
																						<th width="10%">Equipos</th>
																						<th width="10%">Acción</th>
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
                  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
					  
  						 <div id="ViewForm"> </div>
					  
					     <div class="col-md-12"   >
				 		         
													   <table id="jsontable_team" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="25%">Nombre Equipo</th>
																						<th width="20%">Usuario</th>
																						<th width="20%">Software</th>
																						<th width="10%">Version</th>
																						<th width="10%">Ip</th>
																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
														  </table>
						 
						 </div>  
					  
					  
					  
              	  </div>
          	 </div>
		   
 		</div>
		<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   		<div id="FormPie"></div>  
	
 </div>   

<div class="modal fade" id="myModalDocVisor" role="dialog">
  <div class="modal-dialog" id="mdialTamanio">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Asignar Equipo</h4>
        </div>
        <div class="modal-body">
         
		 	   		     <div id="ViewCatalogo"> </div>
						 
						 <div id="ViewGuarda"> </div>
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" id="mdialTamanio1">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Catalogo de Software</h4>
        </div>
        <div class="modal-body">
        		  <div class="panel panel-default">

					 <div class="panel-body">
						 
			 			   <div id="ViewCatalogo"> </div>
						 
						 <div id="ViewGuarda"> </div>
						 
		 			</div>
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
