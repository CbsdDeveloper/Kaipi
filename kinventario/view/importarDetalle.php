<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
<?php   require('Head.php')  ?>  	
   
	<style>
		
    	#mdialTamanio{
      			width: 85% !important;
   			 }
	 
		
 
		#global {
			height: 350px;
			width: 750px;
			border: 1px solid #ddd;
			background: #f1f1f1;
			overflow-y: scroll;
		}
		#casillero {
			 width: 10px;
   			 padding: 2px;
		}
	</style>
    
<script type="text/javascript">

    function procesa_informacion(archivo_file) {
 
      var archivo_file = document.getElementById(archivo_file).value;
      var id 		   = document.getElementById('id_movimiento').value;
      var bodega       = document.getElementById('bodega').value;
 	 
      var parametros = {
		 			    'archivo' : archivo_file  ,
                        'id' : id,
                        'bodega' : bodega,
		  				'tipo' : 1
      };
			  
      $.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado").html(data);   
		 				     
		 				} 
		 	});
  
     alert(id) ;
		
		 var parametros1 = {
 		  				'tipo' : 2
          };
			
		
		  $.ajax({
		 			data:  parametros1,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado_archivo").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado_archivo").html(data);   
		 				     
		 				} 
		 	});
 
	 
}
	/*
	categoria
	*/
    function Refarticulo(nombre,codigo)
{
 
 	var parametros = {
			"nombre" : nombre  ,
		    "codigo" :codigo
	};
	
	$.ajax({
 			 url:   '../controller/Controller-categoria_articulo_xml.php',
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#VisorArticulo").html('Procesando');
				},
			success:  function (data) {
					    $("#VisorArticulo").html(data);   
				     
				} 
	});

}
    /*
	CopiarProducto
	*/
  function CopiarProducto(id,codigo)
{
 
 	  var parametros = {
                         'id' : id,
                        'codigo' : codigo,
		  				'tipo' : 3
      };
			  
      $.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado").html(data);   
		 				     
		 				} 
		 	});

	alert(id);
	
	 var parametros1 = {
 		  				'tipo' : 2
          };
			
		
		  $.ajax({
		 			data:  parametros1,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado_archivo").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado_archivo").html(data);   
		 				     
		 				} 
		 	});
	
	 
	
}
  /*
	Verdatos
	*/
  function Verdatos()
{
  
	
	 var parametros1 = {
 		  				'tipo' : 2
          };
			
		
		  $.ajax({
		 			data:  parametros1,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado_archivo").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado_archivo").html(data);   
		 				     
		 				} 
		 	});
	
	 
}
/*
agregar
*/
   function articulo(archivo_file,codigo,costo) {
 
      var bodega       = document.getElementById('bodega').value;
 	 
      var parametros = {
		                'bodega' : bodega,
		  				'producto' : archivo_file,
		  				'codigo': codigo,
		  				'costo' : costo,
		  				'tipo' : 4
      };
			  
      $.ajax({
		 			data:  parametros,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado").html(data);   
		 				     
		 				} 
		 	});
  
     alert(codigo) ;
		
		 var parametros1 = {
 		  				'tipo' : 2
          };
			
		
		  $.ajax({
		 			data:  parametros1,
		 			 url:   '../model/Model-xmlingreso.php',
		 			type:  'GET' ,
		 			cache: false,
		 			beforeSend: function () { 
		 						$("#procesado_archivo").html('Procesando');
		 				},
		 			success:  function (data) {
		 					 $("#procesado_archivo").html(data);   
		 				     
		 				} 
		 	});
 
	 
}
/*

*/
	function generar_movimiento( ) {
 
      var id 		   = document.getElementById('id_movimiento').value;
      var bodega       = document.getElementById('bodega').value;
 	 
      var parametros = {
                        'id' : id,
                        'bodega' : bodega,
		  				'tipo' : 5
      };
		
		
		    var opcion = confirm("Desea generar los detalles al movimiento " +id );

		   if (opcion == true) {
			  
				  $.ajax({
								data:  parametros,
								 url:   '../model/Model-xmlingreso.php',
								type:  'GET' ,
								cache: false,
								beforeSend: function () { 
											$("#procesado").html('Procesando');
									},
								success:  function (data) {
										 $("#procesado").html(data);   

									} 
						});

				 alert(id) ;
		}
	 
	 
}
	
</script> 
	
</head>
	
<body>
	
<?php

			if  (isset($_GET['status'])) {

							$carpeta =  $_GET['file'] ;

							$archivo =  $_POST["userfile"];

							$filename = guarda_imagen('sas',$carpeta,$archivo,$bd  ); 

							$filename = trim($filename) ;
				} 
	
?>
	
 <div class="panel panel-default">
	 
	   <div class="panel-body" > 
                              
         <ul class="nav nav-tabs">
			 
            <li class="active"><a data-toggle="tab" href="#home">Importar xml compras</a></li>
            <li><a data-toggle="tab" href="#menu2">Validar codigo producto externo</a></li>
			 
           </ul>


        <div class="tab-content">
			
                <div id="home" class="tab-pane fade in active">
					
					     <div class="col-md-12">
							 
							   		<h4>Importando archivo xml - SOLO MOVIMIENTO DE INGRESOS</h4>
							 
										<form action="importarDetalle.php?status=ok&file=<?php echo $_GET['file'] ?>&id=<?php echo $_GET['id'] ?>&bodega=<?php echo $_GET['bodega'] ?>" method="post" enctype="multipart/form-data" id="forma">
								 
									   <div class="col-md-10" style="padding: 2px"> 
												<input name="userfile" type="file" id="userfile"  accept=".xml"   >
									   </div>
								 
										<div class="col-md-10" style="padding: 2px"> 
											 <input type="submit" class="btn btn-success" value="Cargar XML "  />
									   </div>

										<div class="col-md-10" style="padding: 2px"> 
												<input name="enviar" type="button" class="btn btn-info" value="Procesar XML " onClick="javascript:procesa_informacion('archivo_file')" />
									   </div>
									   
									   <div class="col-md-10" style="padding: 2px"> 
												<input class="form-control" name="archivo_file" 
													   type="text" 
													   id="archivo_file" 
													   autocomplete="off" 
													   value="<?php  global $filename ; 
											  					echo str_replace('"', '&quot;', trim($filename));  ?>" 
													   size="60" readonly />
									   </div>
									   
									
									   <input type="hidden" id="id_movimiento" name="id_movimiento" value=<?php echo $_GET['id'] ?>>
										 <input type="hidden" id="bodega" name="bodega" value=<?php echo $_GET['bodega'] ?>>	
											
						       </form>    
							   </div>
					
					    <div class="col-md-12">
                  			 	<h4>  <div id="procesado"> </div></h4>
                        </div>
                </div>
			
                
                <div id="menu2" class="tab-pane fade">
					
                 			 <div class="col-md-12"  >
							   		<h4>Validar archivo xml - SOLO MOVIMIENTO DE INGRESOS</h4>
 								 
								 <div class="col-md-10" style="padding: 2px"> 
												<input name="enviar" type="button" class="btn btn-success" value="Buscar datos XML" onClick="javascript:Verdatos()" />
									   </div>
								 
									   
										<div class="col-md-10" style="padding: 2px"> 
												<input name="enviar" type="button" class="btn btn-info" value="Generar detalles " onClick="generar_movimiento()" />
									   </div>
  									   
									  
									   
						       
							   </div>
					
								 <div class="col-md-12">
                  			  				<div id="procesado_archivo">  </div>
                        		 </div>
					
                </div>
                 
        </div>
 
    </div>
</div>
    
 
    
  </body>
	
		
  <!-- Modal -->
  
  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog" id="mdialTamanio">
    
<!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Articulo</h4>
        </div>
        <div class="modal-body">
         <div id='VisorArticulo'></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
	
</html>

<?php 
session_start( );  
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
 
$bd	   =	new Db ;
											  
$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

$ruc_registro =   $_SESSION['ruc_registro'] ;
											  
     
function guarda_imagen($sesion_variable,$carpeta_variable,$archivo ,$bd   ){
 		
		
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
