 var oTable;
  
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


//-------------------------------------------------------------------------
$(document).ready(function(){
    
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		modulo();
 		
	    FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
   		
	     oTable = $('#jsontable').dataTable(); 
	    
	    BusquedaGrilla( oTable);
 		
	 var j = jQuery.noConflict();
		j("#printButton").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};
			    j("#ViewForm1").printArea( options );
		});
 
    
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
			  		$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
			  		
			  		
                    LimpiarPantalla();
                    
					$("#action").val("add");
					 
			  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
//-------------------------------------------------------------------------

function GenerarProceso( ) {
	
		
                	

var idbodega = $("#idbodega").val();
var anio     = $("#canio1").val();

alertify.confirm("DESEA GENERAR PROCESO DE TRASLADO DE SALDOS? ", function (e) {
	
			  if (e) {
				 
			 
		 	   var parametros = {
							'idbodega' : idbodega ,
		                    'anio' : anio 
		 	  };

		if ( idbodega > 0 ){
			
			if ( anio > 0 ){
				
			  $.ajax({
							data:  parametros,
							url:   '../model/_saldos_periodo_cierre.php',
							type:  'GET' ,
		 					beforeSend: function () { 
		 							$("#resultado_fin").html('Procesando');
		  					},
							success:  function (data) {
								   $("#resultado_fin").html(data);  
								   alert(data);
 							  	   BodegaSaldoAnual();
		  					} 
					}); 
			
 			  }else{
					alert('Seleccione periodo a generar');
			  }
 		 }else{
					alert('Seleccione bodega a generar');
			  }
	 }	

 }); 
		
  };	

// ir a la opcion de editar
function goToURL(accion,id) {
 
 
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-inv_bodega.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
						var a = $("#idbodega").val();
						var b = $("#nombre").val();
					
					    $("#idbodega1").val(a);
				  		$("#nombre1").val(b);

						


  					} 
			}); 
	  
	  
	  UserBodegaLista(id);

    }
 
//-------------------------------------------------------------------------
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
  
	$("#idbodega").val(0);
	$("#nombre").val("");
	$("#idprov").val("");
	$("#ubicacion").val("");
	$("#activo").val("");
	$("#competencias").val("");
       			   
    }
   
 
 //---------------------------
 function fecha_hoy()
{
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    
    if(dd < 10){
        dd='0'+ dd
    } 
    if(mm < 10){
        mm='0'+ mm
    } 
  
    
    var today = yyyy + '-' + mm + '-' + dd;
    
    document.getElementById('fechatarea').value = today ;
    
    document.getElementById('fechafinal').value = today ;
    
    $("#tarea").val("");
	
    $("#tareaproducto").val("");
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

 
 	  
		var user = $(this).attr('id');
      
 
		if(user != '') 
		{ 
		$.ajax({
 		    url: '../grilla/grilla_bodega.php',
			dataType: 'json',
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			
			if (s) {
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
 	                        s[i][3],
                          s[i][4],
                          s[i][5],
                          s[i][6],
                        	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
						]);										
					} // End For
			}						
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
		
		 
	
 		 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 function modulo()
 {
  
   

	 var modulo =  'kinventario';
		 
  var parametros = {
			    'ViewModulo' : modulo 
    };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
      

 }
 
//-----------------------------------------
 function accion(id,modo)
 {
   
 			$("#action").val(modo);
 			
 			$("#idbodega").val(id);          

 			BusquedaGrilla(oTable );

 }
//-----------------------------------------
 function UserBodega(sesion,tipo)
 {
   
	var idbodega =  $("#idbodega").val( );   
 	 
	 var parametros = {
			    'idbodega' : idbodega ,
			    'tipo' : tipo ,
			    'sesion': sesion
    };
	  
	if (idbodega)  {
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-inv_bodega_user.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#ViewUser").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewUser").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	 }
 
 }
//---------------------
 function UserBodegaDel(id,tipo)
 {
   
	var idbodega =  $("#idbodega").val( );   
 	 
	 var parametros = {
			    'idbodega' : idbodega ,
			    'tipo' : tipo ,
			    'sesion': id
    };
	  
	if (idbodega)  {
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-inv_bodega_user.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#ViewUser").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewUser").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	 }
 
 }
//-----------------------------------------
 function UserBodegaLista(idbodega)
 {
   
 	 
	 var parametros = {
			    'idbodega' : idbodega ,
			    'tipo' : 99 
    };
	  
	if (idbodega)  {
			$.ajax({
					data:  parametros,
					 url:   '../model/Model-inv_bodega_user.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#ViewUser").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewUser").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	 }
 
 }
//---------------------------------------
 
//-----------------------
 function BodegaSaldoAnual()
 {
   

var idbodega =  $("#idbodega").val( );   
var anio     =  $("#canio1").val( );   

 	 
	 var parametros = {
			    'idbodega' : idbodega ,
			    'anio' : anio
    };

   var parametros1 = {
			    'idbodega' : idbodega ,
			    'anio' : anio
    };
	  
	if (idbodega)  {
			$.ajax({
					data:  parametros,
					 url:   '../model/ajax_inicial_carga01.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#ViewFormIniciaCuenta").html('Procesando');
						},
					success:  function (data) {
							 $("#ViewFormIniciaCuenta").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
			
			//------------------------------------------
			
			$.ajax({
					data:  parametros1,
					 url:   '../model/ajax_inicial_carga02.php',
					type:  'GET' ,
						beforeSend: function () { 
								$("#resultado_detalle").html('Procesando');
						},
					success:  function (data) {
							 $("#resultado_detalle").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
	 }
 
 }
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-inv_bodega.php');


     $("#ViewFormInicia").load('../controller/Controller-inv_bodega_inicio.php');
      

 }
    
  