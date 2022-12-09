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
	
		<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
 
 	<script type="text/javascript" src="../js/ren_especies.js"></script> 
 	 		 
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>  LISTA DE ESPECIES </b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion  Especies</a>
                  		</li>
	
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Resumen de Conciliación</a>
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
  									 
   										        <div id = "ViewFiltro" > </div>
 												
 												<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
     								     
 				  		     </div> 
			  		  	     
 			  		  	     <div class="col-md-12"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
													<th width="10%">Codigo</th>
													<th width="30%">Concepto</th>
													<th width="12%">Ingreso</th>
										   			<th width="12%">Cta. x Cobrar</th>
							   		    		    <th width="16%">Partida</th>
													<th width="10%">Activo</th>
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
             	 </div>
			   
			   
			    <!-- ------------------------------------------------------ -->
             <!-- Tab 3 -->
             <!-- ------------------------------------------------------ -->
           
                 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
								
								 <div class="col-md-12">
 								  			   <div class="col-md-2">
 													   <select name="mesc" id="mesc" class="form-control required" >
																<option value="-"> Mes</option>
																			  <option value="1">Enero</option>
																			  <option value="2">Febrero</option>
																			  <option value="3">Marzo</option>
																			  <option value="4">Abril</option>
																			  <option value="5">Mayo</option>
																			  <option value="6">Junio</option>
																			  <option value="7">Julio</option>
																			  <option value="8">Agosto</option>
																			  <option value="9">Septiembre</option>
																			  <option value="10">Octubre</option>
																			  <option value="11">Noviembre</option>
																			  <option value="12">Diciembre</option>
														 </select>  
 												   </div>
 													   <div class="col-md-2">
 														   <input type="number" name="anioc" id="anioc" max="2050" min="2015"   class="form-control required">
 												  	   </div>
									 
													   <div class="col-md-8">
														 <button type="button" class="btn btn-primary btn-sm" onClick="BusquedaVisor(1);"><span class="glyphicon glyphicon-print"></span> Reporte Diario</button>


														 <button type="button" class="btn btn-info btn-sm" onClick="BusquedaVisor(2);"><span class="glyphicon glyphicon-print"></span> Reporte Mensual</button>
														   
														    <button type="button" class="btn btn-warning btn-sm" onClick="BusquedaVisor(3);"><span class="glyphicon glyphicon-print"></span> Reporte Anual</button>
														   
														   
														   	<button  id="printButton" type="button" class="btn btn-default btn-sm">Impresion</button>

															 <button  id="ExcelButton" type="button" class="btn btn-default btn-sm">Excel</button>
														   
														   
													   </div>
									 
								    </div>
									<div class="col-md-12">
											<div class="col-md-7">
						  		   				<div id="ViewForm_resumen"> </div>
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
 </body>
</html>
