<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 <script type="text/javascript" src="../js/nom_delegacion.js"></script> 
 
</head>
	
<body>

 
 <!-- ------------------------------------------------------ -->
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
	 
	    <div class="row">
			
 		 	 <div class="col-md-12">
					  
				 
                    <ul id="mytabs" class="nav nav-tabs">                    
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Reporte de Delegaciones de Personal</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Formulario de Registro de datos</a>
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
										  
                                                           <div class="col-md-12" style="background-color:#EFEFEF;padding-top: 10px;padding-bottom: 10px">
                                                                     <div id="ViewFiltro"></div> 

                                                                     <div style="padding-top: 5px;" class="col-md-2">
                                                                            <button type="button" class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
                                                                    </div>
                                                                    
                                                            </div>
										  
                                                           <div class="col-md-12">
                                                                <h5>Transacciones por periódo</h5>
															   
															 
															   
                                                               <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                                                            <thead>
                                                                                                <tr>
                                                                                                <th width="5%">Codigo</th>
                                                                                                <th width="5%">Fecha</th>
                                                                                                <th width="20%">Solicita</th>
                                                                                                <th width="10%">Tipo</th>
																								<th width="15%">Motivo</th>
																								<th width="10%">Rige</th>
																								<th width="10%">Finaliza</th>
 																								<th width="30%">Novedad</th>
                                                                                                <th width="5%">Acción</th>
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
                                       <div id="ViewForm"> </div>
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
 