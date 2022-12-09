<?php
	session_start( );  
	 
?>
<!DOCTYPE html>
<html>
<head>
 
 <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
 
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
 
 <link rel="stylesheet" href="http://bootsnipp.com/dist/bootsnipp.min.css?ver=7d23ff901039aef6293954d33d23c066">
 
 <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
 
 <script src="../../app/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
 
 <script src="../js/jquery.modulo.js"></script>
 
 <script type="text/javascript" src="../../app/dist/js/bootstrap.js"></script>
 
 <script src="../../app/background.cycle.js" type="text/javascript"></script>
 
</head>
<body>
<div id="NavMod">  </div>

<div class="container">
	<div class="widget box">
         <div class="widget-content">
         
        	 <div class="col-md-10">
                  
           						    <div class="col-md-12"  style="text-align: center">
                          					<h4>   Empresa  <strong><?php echo trim($_SESSION['razon']) ?></strong> </h4>
               				        </div>  
                              	 	 
                              	 	 <div class="col-md-12">
                   				   	  &nbsp;
                   				   	 </div>
                               	 	 
                               		<div class="col-md-3"  title="GESTION ESTRATEGICA" align="center">
                              		 	   <strong>GESTION ESTRATEGICA</strong> 
                              		 	   <br> 		  		  
                               		 	  <img src="../../kimages/wk_admin.png"/> 
                               		</div> 
                               		
                               		  
                              		<div class="col-md-3"  title="ADMINISTRACIÓN" align="center">
                               		 	<strong>GESTION ADMINISTRATIVA</strong>
                               		 	  <br> 
										  <img src="../../kimages/wk_gestion.png"/> 
                   				   	</div> 
                   				   	
                   				 
                              		<div class="col-md-3"  title="FINANCIERO" align="center">
                               		 	<strong>GESTION FINANCIERA</strong>
                               		 	  <br> 
										 <img src="../../kimages/wk_fin.png"/> 
                   				   	</div> 
                   				   	
                   				   	 <div class="col-md-12">
                   				   	  &nbsp;
                   				   	  <br>
                   				   	  <br>
                   				   	 </div>
                   				    
                   				    
                   				 
                              		<div class="col-md-3"  title="TECNOLOGIA" align="center">
                               		 	<strong>GESTION TECNOLOGICA</strong>
                               		 	 <br> 
										 <img src="../../kimages/wk_tec.png"/> 
                   				   	</div> 	
                   				   	
                   				  
                              		<div class="col-md-3"  title="COMERCIALIZACION" align="center">
                                		 	<strong>GESTION COMERCIAL</strong>
                               		 	
										 <img src="../../kimages/wk_ventas.png"/> 
                   				   	</div> 	
                   				   	
                   					<div class="col-md-3"  title="ATENCION AL CLIENTE" align="center">
                               		 	<strong>ATENCION AL CLIENTE</strong>
                               		 	<br> 
										 <img src="../../kimages/wk_cli.png"/> 
                   				   	</div>  
									<div class="col-md-12">
											  &nbsp;
											  <br>
											  <br>
									</div>
                   				   		   	
                   		  		   	
             	</div>	    
             	
               <div class="col-md-2" style="padding-top: 100px">
 				  <div class="list-group">
					<a href="#" class="list-group-item active"><small>Usuario:  <?php
												 echo trim($_SESSION['email']).'   '. trim($_SESSION['login']);
					?></small></a>
					
					<a href="#" class="list-group-item list-group-item-warning" data-toggle="modal" data-target="#myModal">
												<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span><small>  Chat</small>
												 
					</a>
					
					<a href="#" class="list-group-item list-group-item-warning" data-toggle="modal" data-target="#myMiembro">
												<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><small>  Miembros</small>
												 
					</a>
					
					<a href="#" class="list-group-item list-group-item-warning">
												<span class="glyphicon glyphicon-user" aria-hidden="true"></span><small>  MI perfil</small>
												 
					</a>
					<a href="sesion" class="list-group-item list-group-item-warning">
											   <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span><small> Cerrar Sesion </small>
 					</a>
				</div>
			</div>		
            
       </div>
  </div> <!-- /.col-md-6 -->
  </div>	
   
   <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: black">Chat interno</h4>
      </div>
      <div class="modal-body">
 			<iframe width="100%" height="350" src="View-panelchat.php" frameborder="0"></iframe>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
   <!-- Modal -->
<div id="myMiembro" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="color: black">Miembros</h4>
      </div>
      <div class="modal-body">
 			<iframe width="100%" height="350" src="View-panelmiembros" frameborder="0"></iframe>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>   
   
    <div id="footer">
 		 <div class="single-sign-on">
								 <small>PLATAFORMA DE GESTION EMPRESARIAL KAIPI</small>
		 </div>
  		  <div class="single-sign-on">
								 <small>Copyright 2016 KAIPI  Rights Reserved. <a href="#" target="_blank">Privacy Policy</a> | Quito - Ecuador</small>
		 </div>
	</div> 			 
 </body>
</html>
 