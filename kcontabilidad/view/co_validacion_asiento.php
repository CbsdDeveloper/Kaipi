<?php
session_start( );
require '../model/ajax_valida_asientos.php';    
$gestion   = 	new componente;

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
  					width: 75% !important;
		}
	 
	#mdialTamanio4{
  					width: 65% !important;
		}
	 
	  .highlight {
 			 background-color: #FF9;
	   }
	  .de {
  			 background-color:#A8FD9E;
	  }
	  .ye {
  			 background-color:#EDECF0;
	  }
	  .sa {
  			 background-color:#FFACAD;
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
			padding: 5px;
			line-height: 1.42857143;
			vertical-align: top;
			border-top: 1px solid #ddd;
     }
	 
	 
  </style>
	
	

    
	
</head>
<body>

       <!-- Content Here -->
     <div class="col-md-12" style="padding-bottom: 5px;padding-top: 5px"> 
 				 <?php 	$gestion->Formulario($_GET['codigo'] );		 ?> 	 
    </div>	
	
     <div class="col-md-12" style="padding-bottom: 5px;padding-top: 5px"> 
	   
	  <div class="col-md-6" style="padding: 20px"> 
		  <h4>Tramite presupuesto </h4>
		   <?php 	$gestion->tramite_presupuesto();  ?> 	
	   </div>	 
	   
	    <div class="col-md-6" style="padding: 20px"> 
		  <h4>Resumen Contable </h4>
		   <?php 	$gestion->tramite_contable();  ?> 	
	   </div>
 				 
    </div>	

     <div class="col-md-12"  style="padding: 20px"> 
	  <?php 	$gestion->detalle_asiento();  ?> 	
    </div>		
	
	   <input type="hidden" value="0" id="xid_asientod" name="xid_asientod">
 
<div class="container"> 
	  <div class="modal fade" id="myModalAsistente" tabindex="-1" role="dialog">
  	  <div class="modal-dialog" id="mdialTamanio">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3  class="modal-title">Auxilar </h3>
		  </div>
				  <div class="modal-body">
				   <div class="form-group" style="padding-bottom: 10px">
			          <div class="panel panel-default">
			          
 				         <div class="panel-body">
 					  		 <div id="ViewFiltroIngreso"> var</div> 
 					  		  <div id="guardarIngreso"></div> 
					     </div>
					     </div>   
  					 </div>
				  </div>
				
		  <div class="modal-footer" >
			  
			  <button type="button" class="btn btn-sm btn-primary"  onClick="AgregaCuenta_enlace()">
								<i class="icon-white icon-search"></i> Guardar</button> 
		   
			<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Salir</button>
 		  </div>
		</div><!-- /.modal-content --> 
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
   </div>  


	<script>
		  function goToURLAsiento(id_asientod,cuenta,grupo) {
		 	    $('#xid_asientod').val( id_asientod );
			  	   var	id_asiento     =  $('#id_asiento').val( );
		 	 	   var parametros = {
						    'id_asiento' : id_asiento ,
						    'cuenta' 	 : cuenta ,
						    'grupo' 	 : grupo 
 			       };
			 	
                   $.ajax({
						data:  parametros,
						url:   '../controller/Controller-co_asiento_enlace.php',
						type:  'GET' ,
						cache: false,
						success:  function (data) {
								 $('#ViewFiltroIngreso').html(data);   
							} 
				});
			  } 
//-----------------------------------------------------------------
		function AgregaCuenta_enlace() 
		{
 	     var id_asiento = $("#id_asiento").val();
	 	 var cuenta11    = $("#cuenta1").val();
		 var partidad1   = $("#partidad").val();
		 var cuenta01    = $("#cuenta0").val();

		 var xid_asientod    = $("#xid_asientod").val();
		 var tipo_copia      = $("#tipo_copia").val();
		 var estado    		 = $("#estado").val();
	 
 
			
	  if (id_asiento > 0){

 
		  var parametros = {
	 			    'id_asiento' : id_asiento ,
	 			    'cuenta0' : cuenta01,
	 			    'estado' : estado,
	 			    'cuenta1' : cuenta11,
	 			    'partidad'   : partidad1, 
					'tipo_copia' : tipo_copia,
					'xid_asientod' : xid_asientod 
	     };
		  
		  	if ( tipo_copia == 'H'){

					$.ajax({
						data:  parametros,
						url:   '../model/Model-co_dasientos_enlace.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarIngreso").html('Procesando');

							},
						success:  function (data) {
								 $("#guardarIngreso").html(data);   
							} 
				});
				
		  	}else {
				  	$.ajax({
				 			data:  parametros,
				 			url:   '../model/Model-co_dasientos_enlace.php',
				 			type:  'GET' ,
				 			cache: false,
				 			beforeSend: function () { 
				 						$("#guardarIngreso").html('Procesando');
		
				 				},
				 			success:  function (data) {
				 					 $("#guardarIngreso").html(data);   
				 				} 
				 	});
		  	 }		  			
	  }else{

		  alert('Guarde la información del asiento');

	  }

 
		 
 
  }
		
///----------------
function BuscaPartida(cuenta){
	 
	
	 var id_asiento = $("#id_asiento").val();
	 
    var parametros = {
    		'cuenta' : cuenta  ,
    		'id_asiento' : id_asiento
    		}; 

    		$.ajax({
    			data: parametros,
    			url: "../model/ajax_contracuenta_partida.php",
    			type: "GET",
    			success: function(response)
    			{
    			$('#partidad').html(response);
    			}
    		});
     
}
//---------------
function BuscaContra(cuenta){
	 
	 var id_asiento = $("#id_asiento").val();
	 
	    var parametros = {
	    		'cuenta' : cuenta  ,
	    		'id_asiento' : id_asiento
		}; 
	    
    		$.ajax({
    			data: parametros,
    			url: "../model/ajax_contracuenta_grupo.php",
    			type: "GET",
    			success: function(response)
    			{
    			$('#cuenta1').html(response);
    			}
    		});
     
}
	       </script>
 

 </body>

</html>
 