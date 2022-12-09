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
 
 	<script type="text/javascript" src="../js/ac_acta_inicial.js"></script> 
 	 		 
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>INFORMACION DE CUSTODIOS</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> GENERAR ACTA ENTREGA RECEPCION</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-dashboard"></span> DETALLE ACTAS GENERADAS</a>
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
											  
			 		    <div class="col-md-12" style="padding: 1px">
 					           <div class="col-md-3" style="background-color:#ededed;">
													    
														    <h5>Filtro búsqueda</h5>
														    <div id="ViewFiltro"></div> 
														   
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label>
															<div style="padding-top: 5px;" class="col-md-9">
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
															</div>
															<label style="padding-top: 5px;text-align: right;" class="col-md-3"> </label> 
					   </div>
							
					           <div class="col-md-9">
												        <h5>Transacciones por periódo</h5>
 						  
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Identificacion</th>
																						<th width="30%">Custodio</th>
																						<th width="30%">Unidad</th>
																						<th width="10%">Acta Generada</th>						<th width="10%">Nro.Bienes</th>
																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
														  </table>
						     
						          </div>  
  						</div>
					
				  </div>
				  </div>
                 </div>
           
			   
			   
           
                    <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px" >
  						  		   <div id="ViewForm"> </div>
              	     </div>
			   
			        <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" >
					  
					    <div class="col-md-12" style="padding: 5px">
							
					         <h5>DOCUMENTOS EMITIDOS</h5>
							
							<h4 id="nombre_doc">NOMBRE FUNCIONARIO</h4>
  						  		   
							 <div class="col-md-12" style="padding: 5px">
								 
					           <table id="jsontable_doc" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="10%">Nro.Acta</th>
																						<th width="15%">Tipo</th>
																						<th width="10%">Documento</th>	
																						<th width="10%">Fecha</th>
																						<th width="25%">Detalle</th>	
																						<th width="10%">Impreso</th>						
																						<th width="10%">Fecha Impresion</th>
																						<th width="10%"> </th>
																						</tr>
																					</thead>
														  </table>
							 
								 
								 </div>
					    </div>
              	  </div>
			   
          	 </div>
		   
 		</div>
	
    

<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    <div id="FormPie"></div>  
	
 </div>   


 </body>
</html>
