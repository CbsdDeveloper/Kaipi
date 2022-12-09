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
 
 	<script type="text/javascript" src="../js/cli_editor_doc.js"></script> 
 

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
    <div class="col-md-12" style="padding-top: 60px"> 
    
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                   		<li class="active"><a href="#tab1" data-toggle="tab"></span>
                   			<span class="glyphicon glyphicon-th-list"></span><b> PLANTILLAS DISPONIBLES</b></a>
                   		</li>
                  		<li><a href="#tab2" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Configuracion Plantilla</a>
                  		</li>
	 
	 					<li><a href="#tab3" data-toggle="tab">
                  			<span class="glyphicon glyphicon-link"></span> Editor Plantilla</a>
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
	  		  	         
		  		  	        	 <div class="col-md-3" style="background-color:#ededed;-webkit-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);-moz-box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);
box-shadow: 5px 20px 21px -24px rgba(10,10,10,1);">
                                      
 				   
											  <div class="col-md-12"  style="padding-top: 15px;">
												<select name="qtipo"  id="qtipo" class="form-control required">
													 <option value="-">Seleccionar Plantilla</option>
													 <option value="Oficio">Oficio</option>
												     <option value="Memo">Memo</option>
												     <option value="Informe">Informe</option>
												     <option value="Notificacion">Notificacion</option>
 												</select>
											   </div> 
											   <div class="col-md-12"  style="padding-top: 5px;"> 
													<button type="button" class="btn btn-sm btn-primary" id="load"><i class="icon-white icon-search"></i> Búsqueda</button>
									   			</div> 
									 
									 			<h6>&nbsp;  </h6>
  				  		           </div> 
 

			  		  	     <div class="col-md-9"> 
					  		  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">
									 <thead  bgcolor=#F5F5F5>
									   <tr>   
											<th width="15%">Cod</th>
										    <th width="25%">Plantilla</th>   
											<th width="25%">Tipo</th>
										    <th width="25%">Visor</th>   
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
 					  <div class="panel-body"> <div id="ViewForm"> </div></div>
					</div>
 
               	 </div>
			   
			   <div class="tab-pane fade in" id="tab3"  style="padding-top: 3px">
                      <div class="panel panel-default">
						
					        <div class="panel-body" > 
  						   
						 	<iframe src="editor.php" width="100%" height="550px" frameborder="0" id="ieditor" name="ieditor"></iframe>

               		       </div>
                	  </div>
             	 </div>	
			   
          	 </div>
		   
 		</div>
 
 
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
