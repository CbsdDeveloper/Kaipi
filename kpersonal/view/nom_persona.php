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
 
 	<script type="text/javascript" src="../js/nom_persona.js"></script> 
 

	
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
	
	
		<script src="../js/jquery.PrintArea.js" type="text/JavaScript"></script>
 	    <script src="../js/prin.js" type="text/JavaScript"></script>
	    
 
 	 		 
</head>
<body>
 <!-- ------------------------------------------------------ -->
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
 	
  <!-- ------------------------------------------------------ -->  
 <div class="col-md-12"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
 							<span class="glyphicon glyphicon-th-list"></span> <b> Nòmina de Personal</b></a>
         				     </li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Ficha Personal Talento Humano</a>
                  		</li>
     
                         <li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Documentos Complementarios</a>
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
                                
  									  <div class="alert alert-info">
 									    	<div class="row">
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qunidad"  id="qunidad" class="form-control required">
													</select>
											   </div> 
												
												<div class="col-md-3"  style="padding-top: 5px;">
													<select name="qregimen"  id="qregimen" class="form-control required">
													</select>
											   </div> 
												
											  <div class="col-md-2"  style="padding-top: 5px;">
												<select name="qestado"  id="qestado" class="form-control required">
															 <option value="S">Activo</option>
															 <option value="N">Desactivo</option>
												</select>
											   </div> 
												
											 
												
											   <div class="col-md-2"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
												   
												     <div class="btn-group">
													 <div class="btn-group">
													  <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown">
													  Reportes/Descarga <span class="caret"></span></button>
													  <ul class="dropdown-menu" role="menu">
														  <li><a href="#">Decimo Cuarto</a></li>
														<li><a href="#">Decimo Tercero</a></li>
														<li><a href="#">Aporte Patronal/Personal</a></li>
													  </ul>
													</div>
												  </div>
												   
									   			</div> 
									   		</div> 
									   	 </div> 		
  								 
 				  		     </div> 
		  		  	      
		  		  	     
			  		  	     <div class="col-md-12"> 
								 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="10%">Identificación</th>
										    <th width="20%">Nombre</th>
											<th width="20%">Cargo</th>
 											<th width="15%">Email</th>    
											<th width="10%">Ingreso</th>
										    <th width="8%">Año(s)</th>
											<th width="7%">Remuneración</th>
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
						    
						  		   <div id="ViewForm"> </div>
						   
               		       </div>
                	  </div>
             	 </div>
               
                 <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
						        <div class="panel panel-default">
                                  <div class="panel-heading">Documentos complementarios</div>
                                    <div class="panel-body"> 
                                        <button type="button" class="btn btn-sm btn-default" id="loadDoc" >  
										  Agregar Documentos funcionario</button>	
                                    </div>
                                  </div>
                                
                                 <div class="panel panel-default">
                                  <div class="panel-heading">Detalle de Documentos</div>
                                    <div class="panel-body"> 
                                        <div id="ViewFormfile"> </div>
                                    </div>
                                  </div>
						  		  
						   
               		       </div>
                	  </div>
             	 </div>          
               
               
          	 </div>
		   
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
	
<div class="modal fade" id="myModalCarga" role="dialog">
  <div class="modal-dialog" id="mdialTamanio1">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cargas Familiares y/o Retencion Judicial </h4>
        </div>
        <div class="modal-body">
         
 					<form id="forma_carga" action="../model/Model-nom_ingreso_carga.php" method="post" name="forma_carga">
					 <fieldset>
					 <label style="padding-top: 12px;text-align: right;" class="col-md-3">Identificacion</label>
					 <div   style="padding-top: 5px;" class="col-md-9">	
						  <input name="idprov_carga" id="idprov_carga" type="text" required="required" class="form-control" size="13" maxlength="13" id="idprov_carga" />
					 </div>	
						
						
					  <label style="padding-top: 12px;text-align: right;" class="col-md-3">Nombre</label>
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <input name="nombre_carga" id="nombre_carga" type="text" required="required" class="form-control" placeholder="Nombre Beneficiario" size="50" maxlength="50" id="nombre_carga"/>
					 </div>	
						
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Año Nacimiento</label>	
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <input name="anio_carga1" id="anio_carga1" type="number" required="required" class="form-control" max="2019" min="1985" size="30" />
					 </div>	
						
					
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Retencion Judicial?</label>		
					  <div  style="padding-top: 5px;" class="col-md-9">	
						  <select name="retencion_carga"  id="retencion_carga" required="required" class="form-control"  id="retencion_carga">
						  <option value="N">NO</option>
						  <option value="S">SI</option>
						</select> 
					   </div>		  
						  
					<label style="padding-top: 12px;text-align: right;" class="col-md-3">Monto Retencion</label>	
					  <div   style="padding-top: 5px;" class="col-md-9">		
					<input name="anio_carga" id="anio_carga" type="number" required="required" class="form-control" id="anio_carga" max="2019" >   </div>	
						
					 	<label style="padding-top: 12px;text-align: right;" class="col-md-3"></label>	
						   <div   style="padding-top: 5px;" class="col-md-9">
								<input  class="btn btn-warning btn-sm" name="mysubmit" type="submit" value="Guardar" /> 
					       </div>	
					</fieldset>	 
				</form> 
				
				<div id="result_carga"></div>
		 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
	  <script language="javascript">
		  
 
	
		$(document).ready(function() {
 
			$('#forma_carga').submit(function() {
		  // Enviamos el formulario usando AJAX
				$.ajax({
					type: 'POST',
					url: $(this).attr('action'),
					data: $(this).serialize(),
					// Mostramos un mensaje con la respuesta de PHP
					success: function(data) {
						$('#result_carga').html(data);
					}
				})        
				return false;
			});
	       
		}); 
 
		 </script>
	  
	  
    </div>
  </div>	
	
	
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
