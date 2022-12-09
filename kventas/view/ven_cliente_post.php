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
    
 	<script type="text/javascript" src="../js/ven_cliente_post.js"></script> 
    
</head>
<body>

 

<div id="main">
	<!-- Header -->
	 
    <div class="col-md-12" > 
      
                   <!-- ------------------------------------------------------ -->
                    <!-- Tab 1 -->
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
																					   <th width="20%">Identificación</th>
																						<th  width="50%">Cliente</th>
																						<th width="20%">Email</th>
 																						<th width="10%">Acción</th>
																						</tr>
																					</thead>
														  </table>
													</div>  
  								 </div>
							  
							   <div align="center" id="BandejaDatoClientes"> </div>
                       </div>  
                     </div> 
                  <!-- Tab 2 -->
    					 
			 </div>	  
    </div>   
 </body>
</html>
 