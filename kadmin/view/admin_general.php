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
 
 	<script type="text/javascript" src="../js/admin_general.js"></script> 
 	 		 
</head>
<body>

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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>DEFINICION VARIABLES </b>  </a>
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
								  <div class="col-md-4"> 
										<div class="panel panel-default">
											<div class="panel-heading">Periodo a parametrizar</div>
											<div class="panel-body"> 
													<input type="text" class="form-control" id="anio" name="anio" value="2021" required>
											</div>
										 </div>
								  </div> 
								  <div class="col-md-8"> 
											  <div id="resultado" style="font-size: 18px">  </div> 	 
								   </div> 	  
										
						  	</div> 	   
							  
							  <div class="col-md-12"> 
									  <div class="col-md-3"> 
											<div class="panel panel-default">
												<div class="panel-heading">Contabilidad</div>
												<div class="panel-body"> 
														 <button type="button" id="boton1" class="btn btn-info btn-block">Crear Periodos</button>  
 														 <button type="button" id="boton2" class="btn btn-default btn-block">Plan Cuentas</button>
													     <button type="button" id="boton21" class="btn btn-default btn-block">Crear Secuencias</button>
													     <button type="button" id="boton22" class="btn btn-default btn-block">Verificar enlaces</button>
												</div>
											 </div>
									  </div> 

								    <div class="col-md-3"> 
											<div class="panel panel-default">
												<div class="panel-heading">Enlaces Contabilidad</div>
												<div class="panel-body"> 
													
 													<a href="../../kcontabilidad/view/co_periodos" class="btn btn-info btn-block" role="button">Ir a Crear Periodos</a>
													<a href="../../kcontabilidad/view/co_plan_ctas" class="btn btn-default btn-block" role="button">Ir a Plan Cuentas</a>
													<a href="../../kcontabilidad/view/co_secuencias" class="btn btn-default btn-block" role="button">Ir a Crear Secuencias</a> 
											 </div>
									      </div> 
								    </div> 
								  
									  <div class="col-md-3"> 
											<div class="panel panel-default">
												<div class="panel-heading">Presupuesto</div>
												<div class="panel-body"> 
 														 <button type="button" id="boton3" class="btn btn-success btn-block">Crear Periodos</button>
														 <button type="button" id="boton4" class="btn btn-warning btn-block">Copiar presupuesto Ingreso</button>
													     <button type="button" id="boton5" class="btn btn-info btn-block">Copiar presupuesto Gasto</button>
													     <hr> 
													     <button type="button" id="boton6" class="btn btn-default btn-block">Descargar presupuesto Gasto</button>
													     <button type="button" id="boton7" class="btn btn-danger btn-block">Subir presupuesto Gasto</button>
												</div>
											 </div>
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
