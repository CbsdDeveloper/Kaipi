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
 
 	 <script type="text/javascript" src="../js/ac_bienes_seg.js"></script> 
 	 
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js"></script>   
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js"></script>
	
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>SEGUIMIENTO Y NOVEDADES DEL BIEN</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> HISTORIAL DEL BIEN</a>
                  		</li>
	
						<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-alert"></span> HISTORIAL ACTAS EMITIDAS</a>
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
																	<i class="icon-white icon-search"></i> Buscar</button>	
																
																   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																	<i class="icon-white icon-download-alt"></i></button>	
																
															</div>
													 
						  
 
					 </div>
					  <div class="col-md-12" id="jsontable_div" >
						  
 												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="5%">Activo</th>
																						<th width="10%">Unidad</th>
																						<th width="15%">Custodio</th>
																						<th width="10%">Clase</th>
																						<th width="15%">Detalle</th>
																						<th width="10%">Marca</th>		
																						<th width="10%">Serie</th>		
																						<th width="7%">Fecha</th>
																						<th width="5%">Tiempo</th>
 																						<th width="5%">Costo</th>
																						<th width="8%">Acción</th>
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
			   
			   
			      <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px" >
					  
						   <div class="col-md-12" style="padding: 5px">

										 <h5><img src="../../kimages/mano.png" align="absmiddle" /> <b>HISTORIAL DOCUMENTOS EMITIDOS</b></h5>
							   	         <h4><b><div id="Etiqueta"></div></b></h4>
 
										 <div class="col-md-12" style="padding: 5px">

										   <table id="jsontable_doc" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																								<thead>
																									<tr>
																									<th width="10%">Nro.Acta</th>
																									<th width="15%">Tipo</th>
																									<th width="5%">Documento</th>	
																									<th width="5%">Fecha</th>
																									<th width="45%">Detalle</th>	
																									<th width="10%">Fecha Impresion</th>
																									<th width="10%"> </th>
																									</tr>
																								</thead>
																	  </table>
										 <div id="Actanegada"></div>  

											 </div>
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
          <h4 class="modal-title">Visor de Documento</h4>
        </div>
        <div class="modal-body">
         
			<embed src="" width="100%" height="450" id="DocVisor">
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


       <!-- The Modal -->

        <div class="modal" id="myModal">
	  
			  <div class="modal-dialog" id="mdialTamanio">

						<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Busqueda por Custodio</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">

					 <div class="panel panel-default">

						 <div class="panel-body">

								<div class="col-md-9">
									 <input type="text" class="form-control" id="cnombre" name="cnombre">
								 </div>

								 <div class="col-md-3">
									 <button type="button" class="btn btn-sm btn-primary" id="loadcc"> <i class="icon-white icon-search"></i> Buscar</button>	
								 </div>

								<div style="padding-top: 10px;padding-bottom: 10px" class="col-md-12">

									<table id="jsontableCiu" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																										<thead>
																											<tr>
																											<th width="20%">Identificacion</th>
																											<th width="70%">Nombre</th>	
																											<th width="10%"> </th>
																											</tr>
																										</thead>
																			  </table>

													  </div>  

								</div>
						  </div>

					  </div>   

				</div>

						<!-- Modal footer -->
						<div class="modal-footer">
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>

			  </div>
		  
      </div>

        <div class="modal fade" id="myModalbienes" role="dialog">

			  <div class="modal-dialog" id="mdialTamanio1">

				<!-- Modal content-->
				 <div class="modal-content">
				 <div class="modal-header">
				  <button type="button" class="close"  data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Bienes Asignados en la Acta</h4>
				 </div>
				 <div class="modal-body">
					 <div class='row'>
							<div class="col-md-12" style="padding-top: 5px;">
								  <div style="height:400px;width:100%;overflow:scroll;overflow-x:hidden;overflow-y:scroll;">

											<div id='VisorBIenes'></div>
								 </div>	
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
