<?php 
session_start( );  
	 
	require 'SesionInicio.php';   /*Incluimos el fichero de la clase Db*/
 
 
   $ruc_registro  = $_SESSION['ruc_registro'];

   $sesion 	      = $_SESSION['login'];
 

   if (isset($_POST["asunto"])) 
	{

			 $mensaje      = @$_POST["asunto"];
			 $fecha_asunto =  date("Y-m-d");    	
 			 $tipo_asunto  = 'publico';
	   	     $usuarioc     =  $sesion;

			 $mensaje   = (trim($mensaje));


			 if (!empty($mensaje)){
 

				// $timestamp = date('Y-m-d G:i:s');

				  $Avalida = $bd->query_array('web_chat_directo',
							'count(*) ya',
							'sesion='.$bd->sqlvalue_inyeccion( $sesion ,true). ' and 
							 registro='.$bd->sqlvalue_inyeccion( $ruc_registro ,true). ' and 
							 modulo='.$bd->sqlvalue_inyeccion( 'cartelera' ,true). ' and 
							 mensaje='.$bd->sqlvalue_inyeccion($mensaje,true)
							);

						$carpeta = $Avalida['ya'];

					   if ( $carpeta == 0) {

							 $cadena = "to_date('".$fecha_asunto."','yyyy/mm/dd')";

						  $sql = "INSERT INTO web_chat_directo( sesion, modulo,mensaje ,tipo, para,registro,estado,fecha) values (".
									  $bd->sqlvalue_inyeccion($sesion, true).",".
									   $bd->sqlvalue_inyeccion('cartelera', true).",".
									   $bd->sqlvalue_inyeccion($mensaje, true).",".
									   $bd->sqlvalue_inyeccion(trim($tipo_asunto), true).",".
 							   		  $bd->sqlvalue_inyeccion($usuarioc, true).",".
							          $bd->sqlvalue_inyeccion($ruc_registro, true).",".
									  $bd->sqlvalue_inyeccion('A', true).",".$cadena.")";   

						  $bd->ejecutar($sql);



						 }

			  }
	     }
	 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
       
    <script type="text/javascript" src="../js/cartelera.js"></script>
    
     <style type="text/css">
     #mdialTamanio{
        width: 70% !important;
       }
	#mdialTamanioCliente{
        width: 65% !important;
       }
		
		#mdialTamanioAgenda{
        width: 35% !important;
       }
		
		#mdialProducto{
        width: 75% !important;
       }
		
		
	
		body{ margin-top:50px;}
.nav-tabs .glyphicon:not(.no-margin) { margin-right:10px; }
.tab-pane .list-group-item:first-child {border-top-right-radius: 0px;border-top-left-radius: 0px;}
.tab-pane .list-group-item:last-child {border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;}
.tab-pane .list-group .checkbox { display: inline-block;margin: 0px; }
.tab-pane .list-group input[type="checkbox"]{ margin-top: 2px; }
.tab-pane .list-group .glyphicon { margin-right:5px; }
.tab-pane .list-group .glyphicon:hover { color:#FFBC00; }
a.list-group-item.read { color: #222;background-color: #F3F3F3; }
hr { margin-top: 5px;margin-bottom: 10px; }
.nav-pills>li>a {padding: 5px 10px;}

.ad { padding: 5px;background: #F5F5F5;color: #222;font-size: 80%;border: 1px solid #E5E5E5; }
.ad a.title {color: #15C;text-decoration: none;font-weight: bold;font-size: 110%;}
.ad a.url {color: #093;text-decoration: none;}
		
	#global {
	height: 390px;
	width: 100%;
	padding: 2px;
	overflow-y: scroll;
	}
		
 	#calendar {
    max-width: 900px;
    margin: 0 auto;
  }

 </style>
 
</head>

<body>

 <div id="main">
	
	<div class="col-md-12" role="banner">
 	   <div id="NavMod"></div>
 	</div> 
	
   	 <div class="col-md-12" style="background-color: #000000"> 
	    <div id="Cartelera"></div>
	 	
    </div>	 
 
 
	<div class="container"> 
	 	 <div class="modal fade" id="myModalEmail" tabindex="-1" role="dialog">
				<div class="modal-dialog" id="mdialEmail">
						<div class="modal-content">
							  <div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h5  class="modal-title">Agrega informacion importante</h5>
							  </div>
							  <div class="modal-body">
									<div class="panel panel-default">
										
 										<form class="form-horizontal row-border" id="validate-1" action="cartelera" method="post">
									
									
 										<label class="col-md-2 control-label">Cartelera</label>
										<div class="col-md-10" style="padding: 3px">
											<textarea rows="3" cols="5" required name="asunto" id="asunto" class="form-control"></textarea>
										</div>
  	  	 
									
							 		<div class="form-actions" style="padding: 5px">
										<input type="submit" value="Crear" class="btn btn-primary  btn-sm pull-right">
									</div>
											
											<label class="col-md-3 control-label"> &nbsp;  </label>
 									    <div class="col-md-9"  style="padding: 3px">  &nbsp; 
 										</div>
								</form>  
										
										 
 
									 </div>   
							  </div>
							  <div class="modal-footer">
 								<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
							  </div>
					 </div><!-- /.modal-content --> 
			  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
  </div>  
 
	
	
	
  	<!-- Page Footer-->
      <div id="FormPie"></div>    
    </div>   
</body>
</html>