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
 
 	<script type="text/javascript" src="../js/ven_asignar.js"></script> 
 
    <style type="text/css">
        #mdialTamanio{
        width: 70% !important;
       }
 </style>
	
	
</head>
<body>

 
 
<!-- ------------------------------------------------------ -->
<div id="main">
	
 	<!-- Header -->
 
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
                   			<span class="glyphicon glyphicon-th-list"></span><b> ASIGNAR POTENCIAL CLIENTES A VENTAS</b></a>
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
  		  	                <div class="col-md-7"  style="padding-top: 5px;">
 									<div class="panel panel-primary">
										  <div class="panel-heading"> <b> GRUPO DE TRABAJO </b></div>
										  <div class="panel-body"> 
											  
										    <div id="ViewFormGrupo" > </div>
									  </div>
										</div>
                                </div> 
							  
							  <input type="hidden" id="idusuario_temp" name="idusuario_temp">
							  
							   <div class="col-md-5"  style="padding-top: 5px;">
								 <div class="panel panel-default">
										  <div class="panel-heading"> <b> CAMPAÑAS ASIGNADAS </b></div>
										  <div class="panel-body">
											 <div class="col-md-12">   
										  		  <div id="ViewFormCampana" > </div>
											 </div>  
  								   </div>
										</div>
                            </div> 
                        </div>  
                     </div> 
             </div>
           
           
                  
			   
		      
			   
   	  </div>
		   
  </div>
	
	
  <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	    <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
			
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h5  class="modal-title">Re-asignacion de contactos</h5>
			  </div>
			
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
							 
  					  		 <div id="ViewForAsigna"> var</div> 
							 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer">
	 			<button type="button" class="btn btn-sm btn-success" id="loadCliente">  
					<i class="icon-white icon-save"></i> Generar innformacion  &nbsp; </button>	
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
			
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
  </div>  
 
  <div id="FormPie"></div>  
 </div>   
 </body>
</html>
