<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	 <script type="text/javascript" src="../js/ac_bienes.js"></script> 
 	 
	<script src="../js/jquery.PrintArea.js" type="text/JavaScript" language="javascript">
	
	</script>
	
	 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
		}
 
		#mdialTamanio1{
      			width: 85% !important;
   			 }
		
		#mdialTamanio2{
      			width: 65% !important;
   			 }
		 
		 #mdialTamanio3{
      			width: 65% !important;
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>CARGAR DE BIENES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Detalle de información</a>
                  		</li>
						<li>
							<a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-arrow-right"></span> Ruta del Tramite
							</a>
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
													    
 														    <div id="ViewFiltro"></div> 
														   
 															<div class="col-md-3" style="padding-top: 8px">
																
																<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar parámetros</button>	
																
																
																<button type="button" class="btn btn-sm btn-success" id="load1">  
																	<i class="icon-white icon-search"></i> Ultimos bienes ingresados</button>	
																
																
																
																   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
															</div>
													 
						  
 
					 </div>
						
						
						
					  <div class="col-md-12"   id="jsontable_div" >
						  
 												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="4%">Activo</th>
																						<th width="7%">Cuenta</th>	
																						<th width="15%">Unidad</th>
																						<th width="15%">Custodio</th>
																						<th width="20%">Detalle</th>
																						<th width="10%">Nro.Serie</th>	
																						<th width="9%">Fecha</th>
																						<th width="5%">Acta Generada</th>						
																						<th width="5%">Costo</th>
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
              	  </div>
			   
			   
			      <!-- ------------------------------------------------------ -->
             <!-- Tab 3 -->
             <!-- ------------------------------------------------------ -->
             
 					 <div class="tab-pane fade in" id="tab3">
						 
						<div class="panel panel-default" style="padding: 1px">
							
								<div class="panel-body" style="padding: 1px"> 

									 <div class="col-md-12" style="padding: 10px" > 
											<h4>Ruta Tramite Administrativo -  Financiero</h4>
									
										 <button type="button" class="btn btn-sm btn-primary" id="loadt"><i class="icon-white icon-search"></i> Buscar</button>
									 </div>		 
									 
									<div class="col-md-12" style="padding: 10px" > 
										 
											<div id="ViewFormRuta"> </div>

									  </div>	 
								    
 									
							   </div>
						  </div>

					 </div>
			 	   
			   
          	 </div>
		   
 		</div>


	 <input type="hidden" id="cuenta_tmp" name="cuenta_tmp">

   	<div id="FormPie"></div>  
	
 

	<div class="modal fade" id="myModalDocVisor" role="dialog">
		
	  <div class="modal-dialog" id="mdialTamanio">

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Visor de Documento</h4>
			</div>
			<div class="modal-body">
 
				<embed src=""   width="100%"  height="450px" id="DocVisor" name ="DocVisor" />
			 
 
			</div>
			  
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		  </div>

		</div>
	  </div>

	<div class="modal fade" id="myModalTramite" role="dialog">

			  <div class="modal-dialog" id="mdialTamanio1">

				<!-- Modal content-->
				 <div class="modal-content">
				 <div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Tramites Disponibles</h4>
				 </div>
				 <div class="modal-body">
					 <div class='row'>
							<div class="col-md-12" style="padding-top: 5px;">
											<div id='VisorTramite'></div>

							 </div>	
					  </div>	 
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
	  </div>


	<div class="modal fade" id="myModalLote" role="dialog">

			  <div class="modal-dialog">

				<!-- Modal content-->
				 <div class="modal-content">
				 <div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Generar lote de informacion</h4>
				 </div>
				 <div class="modal-body">
					 <div class='row'>
							<div class="col-md-12" style="padding-top: 5px;">
								
								 <div class="form-group">
									<label>Detalle Bien Matriz</label>
							     	<input type="text" id="nombre_bien" name="nombre_bien" readonly class="form-control">
								  </div>
								
								 <div class="form-group">
									<label>Tipo Matriz</label>
							     	<input type="text" id="forma_bien" name="forma_bien" readonly class="form-control">
								  </div>
								
								<div class="form-group">
									<label>Nro.Tramite</label>
							     	<input type="text" id="tramite_bien" name="tramite_bien" readonly class="form-control">
								  </div>
								
								<div class="form-group">
									<label>Proveedor</label>
							     	<input type="text" id="proveedor_bien" name="proveedor_bien" readonly class="form-control">
								  </div>
								
								 
								<div class="form-group">
									<label>Nro. Registros a generar</label>
							     	 <input type="text" id="lote_bien" name="lote_bien" class="form-control" value="0" placeholder="Registre el numero de lotes">
								  </div>
 
							 </div>	
					  </div>	 
				</div>
				<div class="modal-footer">
					
					<button type="button" class="btn btn-danger" onClick="GeneraLotes_bien();" >Procesar informacion</button>
					
				  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			  </div>
			</div>
	  </div>


	<div class="modal fade" id="myModaladicional" role="dialog">
		
	  <div class="modal-dialog" id="mdialTamanio3">

		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Usuarios Co-Responsables</h4>
			</div>
			<div class="modal-body">
 
			   <div class="form-group">
				  <label class="col-sm-2 control-label">Usuario Co-Responsables</label>
				  <div class="col-sm-10">
					  
					  <select id="idexterno" name="idexterno" class="form-control"></select>
 				  </div>
				</div>
				
				 <div class="form-group">
				
						<div id="ViewFormLista"> </div>
					 
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
