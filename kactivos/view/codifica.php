<!DOCTYPE html>
<html lang="en">
	
<head>
	
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Administación-Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 

    <style type="text/css">
  		#mdialTamanio{
  					width: 90% !important;
		}
	    #mdialTamanio1{
  					width: 90% !important;
		}
	 #mdialTamanio2{
  					width: 50% !important;
		}
  </style>
    
 	<script type="text/javascript" src="../js/cod.js"></script> 
    
</head>
	
<body>
	
	<!-- MENU SUPERIOR INFORMACION DE SISTEMA Y USUARIO   -->	
 	
	<div class="col-md-12" role="banner">
 	   <div id="MHeader"></div>
 	</div> 
 	
	<!-- MENU LATERAL DE OPCIONES  -->	

    <div class="col-md-12"> 
		
       <!-- Content Here -->
	    
		<div class="row">
			
 		 	     <div class="col-md-12">
  					   	 
                    <ul id="mytabs" class="nav nav-tabs">      
						
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> Codificación de bienes</a>
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

						 
						  <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%">
								<thead> 
									 <tr> 
										<th width="10%">ID</th>
										<th width="15%">TIPO</th>
										<th width="15%">DESCRIPCION</th>
										<th width="12%">Acción</th> 
									</tr>
								</thead> 
							 </table>


						</div>  
			   </div>
		   </div>  
		 </div> 
	</div>

	    <!-- Tab 2 -->
								 
							   
				  
                     
   </div>

<div class="container"> 
  <div class="modal fade" id="modal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" id="mdialTamanio2">
	<div class="modal-content">
			  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h5 class="modal-title">Codificacion bienes</h5>
	  </div>
			  <div class="modal-body">
					   <div class="form-group" style="padding-bottom: 10px">
		         	   <div class="panel panel-default">
							 <div class="panel-body" id="vista">
							 </div>
							 
							 <table align="center">
							 	<tr>
					 		  <td>  <img src="Logocbsd.png"width="100px" height="70px"></td>
					 		  </tr>
					 		  <tr>
					 		  <td>  <input class=" form-control" type="hidden" id="idbien" > </td>
					 		  </tr>
					 		  <tr>
					 				<td> 	<img src="barras.jpg" align="center" width="100px" height="20px"> </td>
					 			</tr>
					 		  <tr>
					 			<td>  <input class=" form-group" align="center" type="label" id="cod" >
					 			 </td>
					 			</tr>
	
							 	
							 </table>
						
							
		
							
				        </div>   
					 </div>
			  </div>
	 		  <div class="modal-footer">
	 		 <button type="button" class="btn btn-sm btn-success" onclick="imprimir()" >Imprimir</button>
		 	<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
		  </div>
	</div><!-- /.modal-content --> 
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div> 
   
  	<!-- Page Footer-->

    <div id="FormPie"></div>  
  
 </body>
</html>
 