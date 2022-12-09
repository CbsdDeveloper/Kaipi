<?php
session_start( );
require '../model/ajax_valida_asientos.php';    
$gestion   = 	new componente;
$gestion->Asiento($_GET['codigo'] );		 
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
	
 <style type="text/css">
  	#mdialTamanio{
  					width: 75% !important;
		}
	 
	#mdialTamanio4{
  					width: 65% !important;
		}
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#EDECF0;
	  }
	  .sa {
  			 background-color:#FFACAD;
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
 
   .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
			padding: 5px;
			line-height: 1.42857143;
			vertical-align: top;
			border-top: 1px solid #ddd;
     }
	 
	 
  </style>
	
 
</head>
	
<body>

 
	
     <div class="col-md-12" style="padding-bottom: 5px;padding-top: 5px"> 
	   
		 <div class="panel-group" id="accordion">
			 
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h4 class="panel-title">
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Presupuesto Por Programa</a>
						</h4>
					  </div>
					  <div id="collapse1" class="panel-collapse collapse in">
						<div class="panel-body">
						    <?php 	$gestion->tramite_presupuesto();  ?> 	
						  </div>
					  </div>
					</div>
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h4 class="panel-title">
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Presupuesto Por Clasificadores</a>
						</h4>
					  </div>
					  <div id="collapse2" class="panel-collapse collapse">
						<div class="panel-body">
						   <?php 	$gestion->tramite_presupuesto_clasificador();  ?> 
						  
						  </div>
					  </div>
					</div>
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h4 class="panel-title">
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Enlace Contabilidad / Presupuesto</a>
						</h4>
					  </div>
					  <div id="collapse3" class="panel-collapse collapse">
						<div class="panel-body">
						  
						   <?php 	$gestion->tramite_contable();  ?> 	
							
						</div>
					  </div>
					</div>
			 
			 
			 <div class="panel panel-default">
					  <div class="panel-heading">
						<h4 class="panel-title">
						  <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Detalle Contabilidad / Presupuesto</a>
						</h4>
					  </div>
					  <div id="collapse4" class="panel-collapse collapse">
						<div class="panel-body">
						  
						   <?php 	$gestion->tramite_contable_detalle();  ?> 	
							
						</div>
					  </div>
					</div>
			 
			 
  			</div> 
		 
		 
	 
	    
 				 
    </div>	

    
	   <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">
	
	  <input type="hidden" value="<?php  echo $_GET['codigo'] ?>" id="id_asiento" name="id_asiento">
	
	
	
	
	
	
 
<div class="container"> 
	  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Auxilar </h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroIngreso"> var</div> 
 					  		  <div id="guardarIngreso"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer" >
			  
			  <button type="button" class="btn btn-sm btn-primary"  onClick="AgregaCuenta_enlace()">
								<i class="icon-white icon-search"></i> Guardar</button> 
		   
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  
 

 </body>

</html>
 