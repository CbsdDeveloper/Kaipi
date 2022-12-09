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
	 
	 	#mdialTamanio_aux_d{
  					width: 80% !important;
		}
	 
	 
	 #mdialTamanio_aux1{
  					width: 70% !important;
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
    padding: 4px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
	 
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#c3e1fb;
	  }
	  .ye {
  			 background-color:#93ADFF;
	  }
	 .di {
  			 background-color:#F5C0C1;
	  }
  </style>
 
 	<script type="text/javascript" src="../js/ren_rubros.js"></script> 
 	 		 
</head>
<body>

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
	
       <!-- Content Here -->
    <div class="col-md-12"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span> <b>  IMPUESTO/TASA/SERVICIOS </b>  </a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Formulario de Informacion </a>
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
		  		  	     
		  		  	       <div class="col-md-12" style="background-color:#ededed;padding: 10px">
							   <div class="col-md-4">
								   <select name="vmodulo_q" id="vmodulo_q" class="form-control">
									    <option value="-">-- Todos los Servicios -- </option>
									   <option value="servicios">Servicio</option>
									   <option value="impuesto">Impuesto</option>
									   <option value="tasa">Tasa</option></select>
							   </div>
							   
   												<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Buscar</button>
     								     
 				  		     </div> 
			  		  	     
 			  		  	     <div class="col-md-12">
								 
								 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
													<th width="10%">Codigo</th>
													<th width="10%">Tipo</th>
													<th width="20%">Detalle</th>
										   			<th width="20%">Resolucion</th>
							   		    		    <th width="10%">Activo</th>
													<th width="10%">Acceso</th>
										   			<th width="10%">#Componentes</th>
  													<th width="10%">Acciones</th>
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
           
                 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						       <div class="col-md-12"> 
						  		   <div id="ViewForm"> </div>
 								</div>
								<div class="col-md-2"> 
									<button type="button" class="btn btn-sm btn-success" data-toggle="modal"  onClick="LimpiarMatriz()" data-target="#myModalServicios">
										<i class="icon-white icon-search"></i> Agregar</button>
								</div>	
								<div class="col-md-10"> 
								  <div id="ViewFormDetalle"> </div>
						        </div>
               		       </div>
                	  </div>
             	 </div>
          	 </div>
		   
 		</div>
 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   


  <div class="modal fade" id="myModalServicios" tabindex="-1" role="dialog">
  	 	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 class="modal-title">Asistente de Asignar servicios</h3>
		  </div>
				  <div class="modal-body">
					  
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewAsientoAnticipo"> var</div> 
 					  		 
					     </div>
					     </div>   
  					 </div>
					  
				  </div>
				
			  <div class="modal-footer">
				  <div id="guardarAnticipo"></div> 
				<button type="button" class="btn btn-sm btn-primary"  onClick="GuardarMatriz()">
				<i class="icon-white icon-search"></i> Guardar</button> 
				<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
			  </div>
			
		</div>
			  <!-- /.modal-content --> 
	  </div>
		  <!-- /.modal-dialog -->
	</div>

 </body>
</html>
