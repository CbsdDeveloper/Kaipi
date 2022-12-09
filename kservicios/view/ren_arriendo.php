<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/ren_arriendo.js"></script> 
	
		
 <style type="text/css">
	#mdialTamanio{
  					width: 85% !important;
		}
    
	 
	 	 .form-control_asiento {  
		  display: block;
		  width: 85%;
		  height: 28px;
		  padding: 3px 3px;
		  font-size: 12px;
		  line-height: 1.428571429;
		  color: #555555;
		  vertical-align:baseline;
		  text-align: right;
		  background-color: #ffffff;
		  background-image: none;
		  border: 1px solid #cccccc;
		  border-radius: 4px;
		  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
				  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		  -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
				  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
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
		
	    <div class="row" >
 		 	     <div class="col-md-12">
                  
					   
                  <ul id="mytabs" class="nav nav-tabs">    
                      
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Lista Arrendatarios</a>
                   		</li>
            
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Informacion Arrendatarios</a>
                  		</li>
						
						<li><a href="#tab4" data-toggle="tab">
											<span class="glyphicon glyphicon-user"></span> Factura/Emision de Arriendo</a>
						 </li>
			
						<li><a href="#tab3" data-toggle="tab">
											<span class="glyphicon glyphicon-dashboard"></span> Convenios-Facilidades de Pago</a>
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
								  
									 
										   <div class="col-md-12" style="background-color:#EFEFEF;padding-top: 5px;padding-bottom: 5px">
										
													   <div class="col-md-9">
 														   
																<div id="ViewFiltro"></div> 
														   
												    	</div>	   
											   
											   		    <div class="col-md-3" style="padding-top: 5px" align="left">
 
																 <button type="button"  class="btn btn-sm btn-primary" id="load">  <i class="icon-white icon-search"></i> Buscar</button>	
														 
														 </div>	 
										 </div>
										
										
										  <div class="col-md-12">
											  
															<h5>Transacciones por periódo</h5>
															 
															
															 
												<table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																						<thead>
																							<tr>
																						    <th width="10%">Fecha</th>
																							<th width="5%">Nro.Contrato</th>
																							<th width="5%">No.Local</th>
																							<th width="10%">Identificacion</th>
																							<th width="20%">Nombre</th>
																							<th width="20%">Detalle</th>
																							<th width="10%">No.Dias</th>
																							<th width="10%">No.Facturas</th>
																							<th width="10%">Acción</th>
																							</tr>
																						</thead>
															  </table>
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
					   
					  
					   			   
					   <!-- Tab 3 -->
					   
					   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">

										  <div class="panel panel-default">

											   <div class="panel-body" > 
 
												   <div id="ViewFormAux"> </div>
												   
												     <button type="button" onClick="PoneSeleccion()" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalfactura">Generar Abono</button>
												   
												   
												     <button type="button" onClick="ListaAuxvisor()" class="btn btn-default btn-sm"  >Actualizar Informacion</button>


											   </div>
											
										  </div>
						    			  <div id="ViewSeleccionPago"> </div>
						</div>
					   
                        <!-- Tab 4 -->
					   
					    <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">

										  <div class="panel panel-default">

											   <div class="panel-body" > 
 
												   <div id="ViewFormGestion"> </div>

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

  <!-- /. costos  -->  

<script language="javascript">// <![CDATA[
$(document).ready(function() {
     

	
   // Interceptamos el evento submit
    $('#foxx').submit(function() {
  // Enviamos el formulario usando AJAX
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
                $('#guardarIngreso').html(data);
				
				
				
            }
        })        
		
 		
        return false;
    });
})
// ]]></script>

  <div class="container"> 
	  
	  <div class="modal fade" id="myModalfactura" tabindex="-1" role="dialog">
		  
  		  <div class="modal-dialog" id="mdialTamanio">
		  
				<div class="modal-content">

					<form accept-charset="UTF-8" id="foxx" name="foxx" action="../model/ajax_a_abono_arriendo.php" method="post" >
								    <div class="modal-header">

									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h5 class="modal-title">Creacion de Abono - Arrendatario</h5>

								  </div>

									<div class="modal-body">

										   <div class="form-group" style="padding-bottom: 5px">

												<div class="panel panel-default">

													   <div class="panel-body">
																 <div id="ViewFiltroIngreso"> var</div> 
																 <div id="guardarIngreso"></div> 
														    	 <div align="right" id="totalIngresoabono"></div> 
														   		 <input type="hidden" id='idprov_abono' name='idprov_abono'>
													   </div>

												 </div> 

											 </div>

								  </div>
								
									<div class="modal-footer">
								<button type="submit" class="btn btn-sm btn-primary">
								<i class="icon-white icon-search"></i> Guardar</button> 
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							</div>
					</form>	

				</div>
			  
		  <!-- /.modal-content --> 
	  	  
		  </div>
		  
		  <!-- /.modal-dialog -->
	  </div>
	  
  </div> 



 </body>
</html>
 