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
 
 	<script type="text/javascript" src="../js/visor-tramite_fin.js"></script> 
 	 		 
	
   <style>
	   
    #mdialTamanio{
      width: 80% !important;
    }
 
	   	  resumen {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    text-align: center;
		  }
	.resumen_td {
	padding-top: 6px;
    text-align: center;
	font-size: 10px;	
	color: #FFFFFF
		  }
	  
	.resumen_tt {
    padding-bottom: 10px;
	padding-top: 1px;
    text-align: center;
	font-size: 22px;
	font-weight: 700;
	color: #FFFFFF
		  }  
	   
	   
.actividad {
    border-collapse: collapse;
    width: 100%;
	font-size: 12px;
   }
 
 .ex1 {
  width: 1950px;
  overflow-y: hidden;
  overflow-x: auto;
  }
	  
	 
 
	
.table1 {
  border-collapse: collapse;
}
	
 .filasupe {
 
 	border-bottom: 1px solid #ddd;
	border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
	border-top: 1px solid #ddd;
	padding-bottom: 4px; 
}
	
.derecha {
 
     border-right: 1px solid #ddd;
	  
 }
	
  #mdialTamanio{
      width: 80% !important;
    }

	
 #mdialTamanio1{
      width: 80% !important;
    }

	
  .bigdrop{
		
        width: 750px !important;

     }
		  
  .bigdrop1{
		
        width: 750px !important;

     }
		  
	  
	  resumen {
    border-collapse: collapse;
    width: 100%;
    font-size: 14px;
    text-align: center;
		  }
	.resumen_td {
	padding-top: 6px;
    text-align: center;
	font-size: 10px;	
	color: #FFFFFF
		  }
	  
	.resumen_tt {
    padding-bottom: 10px;
	padding-top: 1px;
    text-align: center;
	font-size: 22px;
	font-weight: 700;
	color: #FFFFFF
		  }  
  </style>
	
</head>
<body>

<!-- ------------------------------------------------------ -->
 
 
	
	
 <div id="main">
	
 
	  <div class="col-md-12" role="banner"> 
		  
		  <div id="MHeader"></div>
		  
	 </div>
	 
 
  <!-- ------------------------------------------------------ -->  
	 
	 
		<div class="col-md-12"> 
			<h3>BUSQUEDA DE TRAMITES ADMINISTRATIVOS FINANCIEROS</h3>
	   </div>	
	 
 	 
 
	 
	     <div class="col-md-12"> 
			 <div class="panel panel-info">
      				<div class="panel-heading">Búsqueda de trámites</div>
    			   <div class="panel-body">
				 				<div class="col-md-8" style="padding: 5px"> 
									
														      <div class="col-md-4"> 
																  <input type="text" id="ccedula" name="ccedula" class="form-control" placeholder="Busqueda Nro.Identificacion">
															  </div>
									
															 <div class="col-md-3"> 
																  <input type="text" id="ccaso" name="ccaso" class="form-control" placeholder="Busqueda Nro.Tramite">
															  </div>
									
									
															  <div class="col-md-5"> 
																  <input type="text" id="ccodigo" name="ccodigo" class="form-control" placeholder="Busqueda Nombre Solicita">
															  </div>
													 
														      <div class="col-md-4" style="padding-top: 5px;padding-bottom: 5px"> 
															
 									
															 
																  <button type="button" id="bcodigo" name="bcodigo" class="btn btn-success">Busqueda</button>
																  
																  
																  	  <button type="button" id="blimpiar" name="blimpiar" class="btn btn-default">Limpiar</button>

												    		  </div>
									
								</div>
 				   </div>
             </div>
  			 
		  </div>	 
		
	 		<td >
				
		  <div class="col-md-12" style="padding: 5px"> 
				  <div   style="width:100%; height:550px;">
							  <div id="unidad_file" > </div>
				  </div>	  
		 </div>
	 
       	  
 
	<div class="container"> 
		
              <div class="modal fade" id="myModalProducto" tabindex="-1" role="dialog">
				  
                <div class="modal-dialog" id="mdialTamanio">
					
               			 <div class="modal-content">
                  		  
							 <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Verificacion de datos</h5>
                  		  	  </div>
							 
							  <div class="modal-body">
											  <div class="panel-body">
 												  
  												<div align="center"   id="ViewRecorrido" ></div> 
												  
							  			   </div> 
                          <div class="modal-footer">
							  
							
							  
                               <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
                          </div>
                </div>
					<!-- /.modal-content --> 
                </div>
				  <!-- /.modal-dialog -->
              </div>
			
			  <!-- /.modal -->
        </div>  	
	
	</div>  

 
   
  <!-- Page Footer-->
    <div id="FormPie"></div>  
 </div>   
 </body>
</html>
