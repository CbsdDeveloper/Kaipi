<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    

	 <script  type="text/javascript" language="javascript" src="../js/co_plan_ctas.js?n=1"></script>
	
 
 
<style type="text/css">
	
		.tree {
			min-height:20px;
			padding:1px;
			margin-bottom:10px;
			background-color:#fbfbfb;
			border:1px solid #D5D5D5;
		}
		.tree li {
			list-style-type:none;
			margin:0;
			padding:10px 5px 0 5px;
			position:relative
		}
		.tree li::before, .tree li::after {
			content:'';
			left:-20px;
			position:absolute;
			right:auto
		}
		.tree li::before {
			border-left:1px solid #D5D5D5;
			bottom:50px;
			height:100%;
			top:0;
			width:1px
		}
		.tree li::after {
			border-top:1px solid #D5D5D5;
			height:20px;
			top:25px;
			width:25px
		}
		.tree li span {
			display:inline-block;
			padding:3px 8px;
			text-decoration:none
		}
		.tree li.parent_li>span {
			cursor:pointer
		}
		.tree>ul>li::before, .tree>ul>li::after {
			border:0
		}
		.tree li:last-child::before {
			height:30px
		}
		.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
			  color:#000
		}
 
        
		.tree li ul > li ul > li {
				display: none;
		}
  
	#mdialTamanio{
  					width: 75% !important;
		}
 </style>
	
</head>
	
<body>
	
<div id="main">
	
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
	
	
	
    <div class="col-md-12"> 
		
       <!-- Content Here -->
  	
					 
                    <ul id="mytabs" class="nav nav-tabs">    
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Plan de Cuentas</a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Plan de cuentas</a>
                  		</li>
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-adjust"></span> Parámetros</a>
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
									 <label for="sel1">Seleccione el tipo:</label>
									  <select class="form-control" id="ttipo" name = "ttipo" onChange="javascript:FormArbolCuentas(0,'X')">
										<option value="-">-</option>
										<option value="A">ACTIVO</option>
										<option value="P">PASIVO</option>
										<option value="T">PATRIMONIO</option>
										<option value="I">INGRESO</option>
										<option value="G">GASTO</option>
										<option value="O">ORDEN</option>
										</select>
									  <br>
									 <div id="ViewFormArbol" style="padding: 7px"> </div>
							   </div>  
								  
							 </div> 
                </div>
					   
                 <!-- Tab 2 -->
						   
                 		  <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px" tabindex="1000" >
						  
								  <div class="panel panel-default">
									  <div class="panel-body" > 
										   <div id="ViewForm"> </div>
									  </div>
								  </div>
						  
                 		</div>
					   
					   
					   
				   		  <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px;">
								  
									 <?php
										require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
										require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 										 $bd	  =	new Db;

										 $obj     = 	new objects;
	
										 $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
	
										 $url_catalogo  = $bd->_url_externo( 73 );
		

									?>
								
 											   
										        <div class="col-md-4">
													
												     	<div class="col-md-12" style="padding:10px">
												    	   <h4> Parametros Adicionales</h4>
 														   <?php	
															$MATRIZ = $obj->array->catalogo_anio();

															$obj->list->lista('Periodo a Copiar',$MATRIZ,'anio_selecciona',$datos,'required','','div-3-9');

															?> 
 												  	   </div>		
													
											    
											   
															<div class="col-md-12" style="padding:10px">
																
																 <?php	echo '<h5>'.$_SESSION['ruc_registro'].' '.$_SESSION['razon'].'</h5>'; ?> 
																<h5> Copiar Cuentas Contables Periodo Actual</h5>
																<button type="button" onClick="CreaPlanCuentas()" class="btn btn-default">1. Trasladar Plan de Cuentas ($)</button>	   

 															 </div>
													
															<div class="col-md-12" style="padding:10px">
																		<button type="button" onClick="CreaMatriz()" class="btn btn-default">2. Trasladar Estados Financieros</button>	   
  															</div>
													
													   	   <div class="col-md-12" style="padding:10px">
																		<button type="button" onClick="ValidaMatriz()" class="btn btn-success">3. Enlazar asociacion presupuestaria</button>	   
  															</div>
													
													
															<div class="col-md-12" style="padding:10px">
																		<button type="button" onClick="ValidaEsigef()" class="btn btn-warning">4. Verificar cuenta Esigef</button>	   
  															</div>
													
															<div class="col-md-12" style="padding:10px">
																
																	<a href="co_asiento_val" class="btn btn-info" role="button">Matriz Validacion</a>
  
  															</div>
													
													
													 		<div class="col-md-12" style="padding:10px">
						 			 									<div id='resultadoCta'></div>
															 </div>	

												  </div>	
										 
										 					
									 
												  <div class="col-md-8">
										  
													  <object data=" <?php echo  $url_catalogo  ;	?> " type="application/pdf" width="100%" height="650">

														<p>Tu navegador no tiene el plugin para previsualizar documentos pdf.</p>
														<p>Puedes descargarte el archivo desde <a href="myfile.pdf">aquí</a></p>

														</object>
										  
 									            </div>
							</div>
								  
								
				  </div>
					   
					   
					    
   </div>		
 
      <!-- Modal -->
	
     <div class="container"> 
		 
	  <div class="modal fade" id="myModal"  role="dialog">
		  
  	  <div class="modal-dialog" id='mdialTamanio'>
		  
		<div class="modal-content">
			
 			<div class="modal-header">
       			 <h3 class="modal-title">BUSQUEDA PERSONALIZADA</h3>
      		</div>
			
		    <div style="padding:7px">   
				<div class="col-md-12"> 
  					     <div class="col-md-4"> 
 										<input id="bcuenta" type="text" class="form-control" name="bcuenta" placeholder="Ingrese el número de cuenta">
						  </div>
 						 
						 <div class="col-md-4"> 
 										<input id="bdetalle" type="text" class="form-control" name="bdetalle" placeholder="Ingreso de detalle de cuenta">
						   </div>
				
						  <div class="col-md-4"> 
 										<input id="bitem" type="text" class="form-control" name="bitem" placeholder="Ingreso item presupuestario">
						   </div>
					</div>	   
						  <div style="padding:5px">  
 					  		    <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
                                                        	<thead>
                                                                <tr>
                                                                     <th width="30%">Id</th>
                                                                     <th  width="40%">Detalle Cuenta</th>
																	 <th  width="5%">Activo</th>
                                                                     <th width="5%">Transacciona?</th>
																	 <th width="5%">Nivel</th>
																	 <th width="5%">Envio E-Sigef</th>
                                                                     <th width="10%">Acciones</th>
                                                                </tr>
															</thead> 
                                 </table>
                           </div>
				
				
		    	 <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
					<button type="button" class="btn btn-sm btn-danger" id="exitmodal" data-dismiss="modal">Salir</button>
				  </div>
	      </div>		  
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  
	
  	<!-- Page Footer-->
    
 </div>   

<div id="FormPie"></div>  

 </body>


</html>
 