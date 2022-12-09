<?php
session_start( );

if  (isset($_GET['status'])) {
 		
		
				$archivo =  @$_POST["userfile"];
     	
			    $filename = guarda_imagen('sas',$carpeta,$archivo  ); 
				
				$filename = trim($filename) ;
 	} 
?>		
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestión Empresarial</title>
	
    <?php  require('Head.php')  ?> 
 
 	<script type="text/javascript" src="../js/enlace_esigef.js"></script> 
 	 
	<style>
    	#mdialTamanio{
      			width: 55% !important;
   			 }
 
     
        #mdialTamanio2{
      			width: 65% !important;
   			 }
        
		
		#global {
			height: 350px;
			width: 500px;
			border: 1px solid #ddd;
			background: #f1f1f1;
			overflow-y: scroll;
}
		
		.highlight {
  background-color: #FF9;
}
		.ye {
  background-color:#93ADFF;
}
		 
  </style>
	
	<script type="text/javascript">

 
//----------------------
function procesa_informacion(archivo_file) {
 
      var archivo_file = document.getElementById('archivo_file').value;
       
    
 
 	 
      var parametros = {
		 			    'archivo' : archivo_file  ,
                        'id' : 1
       };
			  
      $.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-enlace_esigef.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado").html(data);   
                        
 		 				     
		 				} 
		 	});
  
  
 
	 
}    
	
    
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
     <div class="col-md-12" style="padding-top: 50px"> 
      
       		 <!-- Content Here -->
	       <ul id="mytabs" class="nav nav-tabs">          
                  		          
                 		<li class="active"><a href="#tab1" data-toggle="tab"></span>
											<span class="glyphicon glyphicon-th-list"></span> <b>ENLACE ESIGEF</b>  </a>
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
		  		  	     
		  		  	     
			  		  	     
 			  		  	      <div class="col-md-12"  >
										<form action="enlace_esigef.php?status=ok" method="post" enctype="multipart/form-data" id="forma">
								 
									   <div class="col-md-6" style="padding: 3px"> 
                                           
											 <select id="banio" class="form-control" >
											   <option value="2019">2019</option>
											   <option value="2020">2020</option>
											   <option value="2021">2021</option>
											 </select>
                                                 
									   </div>
											
									   <div class="col-md-8" style="padding: 3px"> 
                                           
												<input name="userfile" class="form-control"  type="file" id="userfile"  accept=".txt"   >
                                                 
									   </div>
								 
                                        <div class="col-md-4" style="padding: 3px"> 
												<input name="archivo_file" class="form-control" type="text" id="archivo_file" autocomplete="off" value="<?php 
													global $filename ;
													echo str_replace('"', '&quot;', trim($filename)); 
													?>" size="60" readonly />
									   </div>
                                            
									 
										<div class="col-md-12" style="padding: 2px"> 
										 		
                                                <input type="submit" class="btn btn-primary btn-sm" value="Cargar"  />
                                            
												<input name="enviar" type="button" class="btn btn-danger btn-sm" value="Procesar" onClick="javascript:procesa_informacion()" />
                                            
											  
                                            
                                              <input name="enviar" id="load" type="button" class="btn btn-success btn-sm" value="Buscar"  />
											
											 <input name="devengo" id="devengo" type="button" class="btn btn-info btn-sm" value="Generar devengado"  />
                                              
									   </div>
									   <div class="col-md-12" style="padding-top: 15px"> 
									 
										   
 										   <table id="jsontable" class="display table-condensed table-bordered" cellspacing="0" width="145%">
													 <thead  bgcolor=#F5F5F5>
													   <tr>   
														<th width="5%">Ejercicio</th>
														<th width="5%">Nro.Cur</th>
														<th width="5%">Nro.Original</th>
														<th width="5%">Clase Registro</th>
														<th width="40%">Descripcion</th>
														<th width="5%">Pago</th>
														<th width="10%">Aprobado</th>
														<th width="30%">Beneficiario</th>
														<th width="5%">Actividad</th>
														<th width="5%">Item</th> 
														<th width="5%">Fuente</th>
														<th width="5%">Monto</th>
														<th width="5%">Tramite</th>
														<th width="5%">Asiento</th>
 													   </tr>
												</thead>
											 </table>
											
									   </div>
											
                                    <div id="procesado_archivo">  </div>
                                            
									<div id="procesado">  </div>
									   
						       </form>    
							   </div>
                              
							 <div id="SaldoBodega"></div>
                          </div>  
                     </div> 
             </div>
           
             <!-- ------------------------------------------------------ -->
             <!-- Tab 2 -->
             <!-- ------------------------------------------------------ -->
    
          	 </div>
		   
 		</div>
	
	
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" id="mdialTamanio">
    
<!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Variables</h4>
        </div>
        <div class="modal-body">
			 <div class="row">
			
			 <div class="col-md-6" style="padding-top: 5px"> 
			<div class="form-group">
			  <label for="usr">ISD:</label>
			  <input type="text" class="form-control" id="isd" value="0.05">
			</div>
			
			<div class="form-group">
			  <label for="usr">TRASPORTE:</label>
			  <input type="text" class="form-control" id="trasporte" value="0.15">
			</div>
			
			<div class="form-group">
			  <label for="usr">VIP:</label>
			  <input type="text" class="form-control" id="vip" value="1.15">
			</div>
			
			 <div class="form-group">
			  <label for="usr">INTEGRADOR:</label>
			  <input type="text" class="form-control" id="integrador" value="1.25">
			</div>
			
			</div>
			
			
			
			 <div class="col-md-6" style="padding-top: 5px"> 
			 <div class="form-group">
			  <label for="usr">PVP1:</label>
			  <input type="text" class="form-control" id="pvp1" value="1.3">
			</div>
			
			 <div class="form-group">
			  <label for="usr">PVP2:</label>
			  <input type="text" class="form-control" id="pvp2" value="1.4">
			</div>
			
			
			 <div class="form-group">
			  <label for="usr">PVP3:</label>
			  <input type="text" class="form-control" id="pvp3" value="1.5">
			</div>
			
           </div>
			
			 </div>
        </div>
        <div class="modal-footer">
			
			<button type="button" class="btn btn-success" onClick="Procesar();" data-dismiss="modal">Procesar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
	
	  <!-- Modal -->
  <div class="modal fade" id="myModalSerie" role="dialog">
      <div class="modal-dialog" id="mdialTamanio1">
    
<!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Articulo</h4>
        </div>
        <div class="modal-body">
			 <div class='row'>
					 <div class="alert alert-info">
						 <div class="row">
							<div class="col-md-2" style="padding-top: 5px;">Cargar Series de articulos</div> 
							<div class="col-md-4" style="padding-top: 5px;">

								<input type="hidden" id="idproducto_serie" name="idproducto_serie">
							 <input type="text" class="form-control" name="serie" id="serie" value="0" readonly>
							 </div>  
							 
						 </div>
					 </div>
				 	<div class="col-md-12" style="padding-top: 5px;">
						  <div id='global' >
									<div id='VisorSerie'></div>
							        <div id='GuardaSerie'></div>
						  </div>
					 </div>	
			  </div>	 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	

 <div class="modal fade" id="ViewCodigo" role="dialog">
    
  <div class="modal-dialog" id="mdialTamanio2">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Codigo Externo Articulo</h4>
        </div>
        <div class="modal-body">
          <div class="row">
              
              <div class="col-md-12" style="padding: 10px"> 
                  <input type="text" id="producto_busca" class="form-control">
                  
                  <input type="hidden" id="codigo_busca">
                  
               </div>
              
               <div class="col-md-12" style="padding: 10px"> 
                   <div id = "DatosCarga1" align="center">   </div>
               </div>
                   
			  <div id = "ViewFiltroCodigo"> </div>
			  
              	
		  </div>
        </div>
        <div class="modal-footer">
		
			
			<button type="button" class="btn btn-warning" onClick="BuscaCodigo()">Buscar</button>
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>    
     <!-- Page Footer-->
   <div id="FormPie"></div>  
 </div>   
 </body>
</html>
 <?php
//-------------------------------------
function guarda_imagen($sesion_variable,$carpeta_variable,$archivo   ){
 		
	
		   global $filename;
	   
	       $folder = '../../archivos/';
	   
		
			$archivo_temporal = $_FILES["userfile"]['tmp_name'];
			$archivo = $_FILES["userfile"]['name'];
			$subir = $_FILES["userfile"]['name'];
  			
			$prefijo = substr(md5(uniqid(rand())),0,6);
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
  		   
			if($copiado==false){ 
				return "error"; 
			}else{ 
			    return $subir;
			}
 	
		 
	}
    
 
?>
