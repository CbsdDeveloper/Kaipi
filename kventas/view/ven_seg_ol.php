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
	
  
    <style type="text/css">
       #mdialTamanio{
        width: 65% !important;
       }
	
	#mdialEmail{
        width: 45% !important;
       }	
	
	 #mdialProducto{
        width: 55% !important;
       }	
		
	 #global {
	height: 390px;
	width: 100%;
	padding: 2px;
	overflow-y: scroll;
	}
		
	#calendar {
		max-width: 100%;
		margin: 0 auto;
	}
  </style>

 

 <link href='../../app/calendario/fullcalendar.min.css' rel='stylesheet' />
 <link href='../../app/calendario/fullcalendar.print.min.css' rel='stylesheet' media='print' />
 <script src='../../app/calendario/lib/moment.min.js'></script>
 <script src='../../app/calendario/fullcalendar.min.js'></script>
 
  <script type="text/javascript" src="../js/calendario_seg.js"></script> 	
	
 <script type="text/javascript" src="../js/ven_seg.js"></script> 
	
	

	
  <script >// <![CDATA[
 
  // a=jQuery.noConflict();
	 	
	$(document).ready(function() {
  		
		   // InjQueryerceptamos el evento submit
			$('#form_email').submit(function() {
				// Enviamos el formulario usando AJAX
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					// Mostramos un mensaje con la respuesta de PHP
					success: function(data) {

							$('#mensaje_enviado').html(data);

					}
				})        
				return false;
			}); 
	//-----------------------
 }); 
</script>	
	
</head>
<body>

<!-- ------------------------------------------------------ -->

<div id="mySidenav" class="sidenav">
 
  <div class="panel panel-primary">
	<div class="panel-heading"><b>OPCIONES DEL MODULO</b></div>
		<div class="panel-body">
			<div id="ViewModulo"></div>
 		</div>
	</div>
 
 </div>
 
<!-- ------------------------------------------------------ -->
<div id="main">
	
  <!-- Header -->
	
  <header class="header navbar navbar-fixed-top" role="banner">
 	   <div id="MHeader"></div>
 	</header> 
 	
  <!-- ------------------------------------------------------ -->  
    <div class="col-md-12" style="padding-top: 35px"> 
    
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> BANDEJA DE  SEGUIMIENTO DE PRE VENTA</b></a>
                   		</li>
	
					    <li><a href="#tab2" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> EMAILS</b></a>
                   		</li>
	
						<li><a href="#tab3" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> AGENDA</b></a>
                   		</li>

						<li><a href="#tab4" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> DETALLE DE PRODUCTOS</b></a>
                   		</li>

						<li><a href="#tab5" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> DOCUMENTOS</b></a>
                   		</li>


     
           </ul>
                    
           <!-- ------------------------------------------------------ -->
           <!-- Tab panes -->
           <!-- ------------------------------------------------------ -->
           <div class="tab-content">
 			<div class="tab-pane fade in active" id="tab1" style="padding-top: 3px">
                <div class="panel panel-default">
						  <div class="panel-body" > 
							  <div class="col-md-12"> 
								     <div class="col-md-4"> 
  										 <h4>Bandeja de Entrada</h4>
										 <div class="row">
														  <div class="alert alert-info">
															   <div id="global">
 																	  <div id="ViewFormLista"> </div>
															</div>   
										   </div>
 										 </div>	 
							        </div> 	 
								  
									<div class="col-md-5"> 
										  <h4>Ultimas Actividades</h4>
										   <div class="well">
												   <div class="btn-group btn-group-sm">
													  <button type="button" 
															 class="btn btn-default" onClick="goToURL();"
															 title="Realizar seguimiento preventa"
															 data-toggle="modal" data-target="#myModal"> 
															<span class="glyphicon glyphicon-edit"></span>  
													   </button>



													</div>
													 <div class="row">
																  <div id="ViewFormActividad"> </div>
															  </div>
											 </div>	 
											 <input name="idcliente" type="hidden" id="idcliente" >
											 <input name="nombre" type="hidden" id="nombre" >
										    
 									</div> 
								  
								   <div class="col-md-3"> 
  										 <h4>Avance </h4>
										 <div class="row">
													<div class="progress">
														  <div id="ViewAvance"> </div>
  													 </div>	 
							      		  </div> 
                           		  </div> 
                         </div>  
        			</div> 
             </div>
    	  </div>
			   
		 <div class="tab-pane fade in" id="tab2"  style="padding-top: 3px">
             <div class="panel panel-default">
 				<div class="panel-body" > 
				   <div class="col-md-8"> 
					   	  
					   <form action="../model/EnvioEmail.php" method="post" enctype="application/x-www-form-urlencoded" id="form_email" accept-charset="UTF-8">
							
						  <div class="col-md-10">  
						    <div class="form-group">
						       <input name="bnuevo" type="button" onClick="limpiaEmail()" class="btn btn-info btn-sm" id="bnuevo" value="Nuevo"> &nbsp; 
						       <input type="submit" class="btn btn-default btn-sm">
					        </div>		
				         </div>
						   
						 <div class="col-md-10">  
								     <div class="form-group">
 										  <input name="temail" type="email" required="required" class="form-control" id="temail" placeholder="Email">
									   </div>
										<div class="form-group">
 										  <input name="tasunto" type="text" required="required" class="form-control" id="tasunto" placeholder="Asunto">
										</div>
								 </div>  
								
							   <div class="col-md-12">
									 <div id="mensaje_enviado"></div> 
							   </div>   
								  
								  
					     <div class="col-md-12">
									 <textarea cols="80" id="editor1" name="editor1" rows="7" > </textarea>
							   </div> 
				  		 <script src="../../keditor/ckeditor/ckeditor.js"></script>
						 <script>
												CKEDITOR.replace( 'editor1', {
													height: 250,
													width: '90%',
												} );
									 </script>
								 
							<input name="idtransaccion" type="hidden" id="idtransaccion" value="0">	
					     <input name="para_email" type="hidden" id="para_email" value="">	
				 						 
					  </form>
                  </div> 		
			      <div class="col-md-4"> 
  								  <h4>Bandeja de Enviados</h4>
									 <div class="row">
										 <div id="lista_enviados">  </div> 
 		      	    </div> 
                  </div> 
               </div>
           </div>
        </div>
	 

		
	    <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
             <div class="panel panel-default">
 				<div class="panel-body" > 
					 <h4>Calendario Personal</h4>
 					  
				   <div class="col-md-10"> 
 					     <div id='calendar'> </div>
 					     <div id='warning_c'> </div>
                   </div> 		
			      
               </div>
           </div>
        </div>	   
			   
		 <div class="tab-pane fade in" id="tab4"  style="padding-top: 3px">
             <div class="panel panel-default">
 				<div class="panel-body" > 
  					       <h4>Detalle de productos ofertados</h4>
 					       <div class="col-md-10">  
						    <div class="form-group">
								<button type="button" 
										 class="btn btn-info" onClick="limpiaProducto();"
										 title="Ingresar producto ofertar"
										  data-toggle="modal" data-target="#myModalProducto"> 
										 <span class="glyphicon glyphicon-edit"></span>  
								   </button>
 						      
					        </div>		
				         </div>
					
					     <div class="col-md-10"> 
					      <table id="jsontable_producto" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="10%">Fecha</th>
											<th width="10%">Codigo</th>
											<th width="20%">Producto</th>
										    <th width="35%">Detalle</th>
											<th width="15%">Responsable</th>    
 											<th width="10%">Acciones</th>
									   </tr>
									</thead>  
							 </table>
                        </div> 		
			      
               </div>
           </div>
        </div>	   	   
	
			   
		<div class="tab-pane fade in" id="tab5"  style="padding-top: 3px">
             <div class="panel panel-default">
 				<div class="panel-body" > 
  					       <h4>Detalle de documentos</h4>
 					       <div class="col-md-10">  
						     <div class="form-group">
						    
							<button type="button"   onClick="llamadoc()" class="btn btn-info btn-sm" id="bnuevo" >  <span class="glyphicon glyphicon-edit"></span>  
						       </button>
								 
							<button type="button"   onClick="Grilladoc()" class="btn btn-default btn-sm" id="bprunter" >  <span class="glyphicon glyphicon-refresh"></span>  
						       </button>	 
								 
					        </div>		
				         </div>
					
					     <div class="col-md-10"> 
					      <table id="jsontable_doc" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
										 	<th width="10%">Codigo</th>
										    <th width="10%">Fecha</th>
											<th width="50%">Documento</th>
										  	<th width="20%">Responsable</th>    
 											<th width="10%">Acciones</th>
									   </tr>
									</thead>  
							 </table>
                        </div> 		
			      
               </div>
           </div>
        </div>	 	   
			   
   </div>
           <!-- mensaje -->
  <!-- ------------------------------------------------------ -->
  <div class="container"> 
	  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  	    <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Actividades</h5>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormCliente"> var</div> 
 				  		  
 				  		  
					     </div>
					     </div>   
  					 </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
  </div>  
	
<!-- ------------------------------------------------------ -->
  
 <!-- ------------------------------------------------------ -->
  <div class="container"> 
	  <div class="modal fade" id="myModaltarea" tabindex="-1" role="dialog">
  	    <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Actividades</h5>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormCliente"> var</div> 
 				  		     <div id="guardarAux" ></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
  </div>  	


<div class="container"> 
	 	 <div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog">
				<div class="modal-dialog" id="mdialEmail">
						<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Actividad</h5>
							  </div>
							  <div class="modal-body">
									<div class="panel panel-default">
										
 										  <div style="padding: 10px" id="e_actividad"></div> 
 
									 </div>   
							  </div>
							  <div class="modal-footer">
								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					 </div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div>  


 <div class="container"> 
	  <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
  	 	<div class="modal-dialog" id="mdialProducto">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h5  class="modal-title">Productos ofertados</h5>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFormProducto"> var</div> 
 				  		     <div id="guardarProducto" ></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
				  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
  </div>  	

  <div id="FormPie"></div>  
 </div>   


 </body>
</html>
