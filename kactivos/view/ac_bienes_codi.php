<?php session_start( ); ?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
		 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js"></script>   
	     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js"></script>
 	     <script type="text/javascript" src="../js/ac_bienes_codi.js"></script> 
	
		 <style type="text/css">
		 
	 #mdialTamanio{
  					width: 75% !important;
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
                   			<span class="glyphicon glyphicon-th-list"></span> <b>CONTROL DE BIENES</b></a>
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
											  
			 		    <div class="col-md-12"  >
 					  <div class="col-md-12" style="background-color:#ededed; padding-bottom: 10px;padding-top: 10px">
													    
 														   
														   <div id="ViewFiltro"></div> 
														   
 															<div class="col-md-12" style="padding-top: 8px">
																
																
																	<button type="button" class="btn btn-sm btn-success" id="load1">  
																	<i class="icon-white icon-search"></i> Ultimos bienes ingresados</button>	
																
																	<button type="button" class="btn btn-sm btn-primary" id="load">  
																	<i class="icon-white icon-search"></i> Buscar</button>	
																
																   <button type="button" class="btn btn-sm btn-default" id="saveAsExcel">  
																	<i class="icon-white icon-download-alt"></i> Exportar</button>	
																
																
																
																
																
															</div>
															 
														 
					 </div>
					  <div class="col-md-12">
												        <h5>Transacciones por periódo</h5>
													   <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
																					<thead>
																						<tr>
																					    <th width="5%">Activo</th>
																						<th width="20%">Unidad</th>
																						<th width="15%">Custodio</th>
																						<th width="20%">Detalle</th>
																						<th width="10%">Serie</th>	
																						<th width="25%">Codigo</th>
																						<th width="5%">Acta</th>						
																						<th width="5%">Costo</th>
																						<th width="5%">Acción</th>
																						</tr>
																					</thead>
														  </table>
						 
						 </div>  
  						</div>
					
				  </div>
				  </div>
                 </div>
           
               
          	 </div>
		   
 		</div>
	
    

<input type="hidden" id="cuenta_tmp" name="cuenta_tmp">
   
 
    <div id="FormPie"></div>  

  <div id="ViewForma"></div> 
	
 </div>   


<div class="container"> 
	
	  <div class="modal fade" id="myModalbarra" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Codigo de barras </h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
							 <div class="panel-body">
								 
								  <div id="ViewBarras"></div>

								  <input type="hidden" name="cod" id="cod">
								  <input type="hidden" name="nom" id="nom">

							 </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer" >
		   	 
			  <button type="button" class="btn btn-sm btn-warning" onclick="imprimir2()" >Formato QR / Barras</button>
			  
			  <button type="button" class="btn btn-sm btn-success" onclick="imprimir()" >Formato Grafico Barras </button>
			  
			   <button type="button" class="btn btn-sm btn-info" onclick="imprimir3()" >Formato Lineal Barras </button>
			  
			     <button type="button" class="btn btn-sm btn-primary" onclick="imprimir4()" >Formato QR </button>
			  
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  


 </body>
</html>
