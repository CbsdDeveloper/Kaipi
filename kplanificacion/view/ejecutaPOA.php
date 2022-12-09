<?php
 	 session_start();
	 require '../controller/Controller-FiltroAgendaMain.php';  
     $gestion   = 	new componente;
?>	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
      <?php  require('HeadPanel.php')  ?> 
  	 
	<link href="../../kplanificacion/view/articula.css" rel="stylesheet">
   
    <style type="text/css">
 	
		   
	
		.sidenav {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
		  /*  background-color: #111;*/
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
			font-size: 11px;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 11px;
			color:#322E2E;
			display: block;
			transition: 0.3s;
		}

		.sidenav a:hover, .offcanvas a:focus{
			color:#BFBFBF;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 0;
			right: 25px;
			font-size: 11px;
			margin-left: 50px;
		}

		#main {
				transition: margin-left .5s;
				padding: 16px;
		}

 
 
 		.ex1 {
			  width: 1990px;
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
			padding-bottom: 6px; 
			padding-top: 6px;
		}
	
		.derecha {
 
    		 border-right: 1px solid #ddd;
	  
		 }
	
  		#mdialTamanio{
      width: 70% !important;
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
		  
	  
	.resumen {
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
 
 div.ex1 {
  width: 100%;
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
	 
</style>	
 	
	<script language="javascript" src="../js/EjecutaPOA.js"></script>
    
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
		
 		  <div class="panel panel-default">
				<div class="panel-heading">Unidad de Gestión</div>
					<div class="panel-body">
						 <div class="widget box">
                              <div class="widget-content">
                                     <?php
                                      $gestion->FiltroFormularioProceso( ); 
								    ?>
                              	     
                               </div>
                           </div> <!-- /.col-md-6 -->
 					</div>
			 </div>
		
		
	  	  <div class="panel-group">
			<div class="panel panel-default">
				
			  <div class="panel-heading">ACTIVIDADES PENDIENTES DE EJECUCION</div>
				
			  <div class="panel-body">
				  
				    <div class="col-md-3" style="padding-bottom: 10px;padding-top: 15px"> 
 	  
						<div class="list-group">
						  <a href="#" class="list-group-item active">EJECUCIÓN DE PROCESOS</a>
						  <a href="#" onClick="busqueda_proceso('requerimiento')" class="list-group-item">PROCESO DE CONTRATACIÓN</a>
						  <a href="#" onClick="busqueda_proceso('viaticos')"  class="list-group-item">GESTIÓN DE CONTROL DE VIÁTICOS</a>	
						  <a href="#"   onClick="busqueda_proceso('nomina')"  class="list-group-item">GESTIÓN DE PAGOS DE NÓMINA E INGRESOS COMPLEMENTARIOS</a>
						  <a href="#"  onClick="busqueda_proceso('caja')"  class="list-group-item">GESTIÓN DE OTROS GASTOS PLANIFICADOS (sin contratación)</a>
						</div>
				 		 
  				   </div>
				  
				  <div class="col-md-9" style="padding-bottom: 10px;padding-top: 10px"> 
					  
					  <div class="col-md-12"> 
							  <div class="alert alert-success">
								  <strong>Nota!</strong> Seleccione el tipo de proceso y Verifique la información para registrar el evento asignado
								</div>
 						</div>
					  
					   <div class="col-md-12"> 
				     		<div id="PendientesVisor"></div>
					  </div>
					  
				  </div>
				  
				 
				  
				 
				  
				</div>
			</div>
		</div> 	
  		 
</div>
	
	
<input type="hidden" id="idtarea1" name="tarea1">
<input type="hidden" id="idtarea_seg" name="idtarea_seg">
<input type="hidden" id="idtarea_segcom" name="idtarea_segcom">


 
  	<!-- Page Footer-->
      <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Kaipi &copy; 2017-2019</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Design by <a href="#">JASAPAS</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
 </footer>
 
    <input type="hidden" name="proceso_nombre" id="proceso_nombre">
	
	
	
 <!---------------  FORMULARIO MODAL DE COMPRAS  ----------------->	
 
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">ACTIVIDAD PLANIFICADA</h4>
		   </div>
			 
			 
			  
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormTarea"> var</div> 
								   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									 <div id="guardarCompras" style="padding: 15px;" align="center"></div>   

									   
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div>
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

	
	

	<!-- /.modal-content --> 
	 
 <div class="modal fade" id="myModalActualiza" tabindex="-1" role="dialog">
		  
		  <div class="modal-dialog" id="mdialTamanio1">
		 <div class="modal-content">
		   <div class="modal-header">
			 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			 <h4 class="modal-title">Siguiente Paso</h4>
		   </div>
			 
			 
			  
				   <div class="modal-body">
				   
					   <div class="panel panel-default">
				  
						  <div class="panel-body">
							  
							   <div class="col-md-12">

							   				<div id="ViewFormComentario"> var</div> 
								   
								   			 <div id="guardarDatosCom" style="padding: 15px;" align="center"></div>   
  				
							   </div>
							  
								<div class="col-md-12" style="padding: 8px" align="right">
								
									

									    <button type="button" class="btn btn-sm btn-success" onClick="SiguienteProceso()" >Guardar / Enviar Proceso</button>
									
									 <button type="button" class="btn btn-sm btn-danger" id='saliraux2' data-dismiss="modal">Salir</button>
							  </div>
							  
							  
						   </div>
					  </div>   
						
				   </div>
 		 
			 
		 </div><!-- /.modal-content --> 
	   </div><!-- /.modal-dialog -->
	 </div><!-- /.modal -->

	
 
</body>
</html> 