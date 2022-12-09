var oTable;
var modulo1 =  'kservicios';
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
  
		modulo();
  		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');

		$("#MHeader").load('../view/View-HeaderModel.php');
     
		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 6 ] },
			      { "sClass": "de", "aTargets": [ 2 ] }
			    ] 
	      } ); 
	    
		
		 BusquedaGrilla(oTable,'0');
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable,'1');
           
 		});
         
	
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
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
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ren_rubro.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {

							 $("#result").html(data);  
						     
							 PoneCuenta( id );
  					} 
			}); 

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
  
 
               
	$("#id_rubro").val("");
	$("#estado").val("");
	$("#detalle").val("");
	$("#resolucion").val("");
	
	$("#acceso").val("");
	$("#id_departamento").val("");
	$("#modulo").val("");
                  

	PoneCuenta( 0 );
        			   
    }
//-------------   
function LimpiarMatriz() {
	  
	 
	   
	  var id_rubro        =  $('#id_rubro').val();
 
    
	$("#id_rubro1").val(id_rubro);
	$("#estado1").val("");
	$("#idproducto_ser").val("");
    
	$("#action_servicios").val("add");
                  
        			   
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
  function BusquedaGrilla(oTable,tipo){        
  
   
	  
            
	   var vmodulo = $("#vmodulo_q").val();
       
	   if ( tipo == '0'){
		   vmodulo = '-'; 
	   } 		   
		   
    
      var parametros = {
               'vmodulo' : vmodulo  
      };

 
			$.ajax({
				data:  parametros,  
 			    url: '../grilla/grilla_ren_rubro.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								'<b>' + s[i][2] + '</b>',
       	                        s[i][3],
       	                        s[i][4],
       	                        s[i][5],
       	                        s[i][6],
                               	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
		 
 }   
 /*
 */
function modulo()
{
 
 		 
	 var parametros = {
			    'ViewModulo' : modulo1
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//-----------------
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_rubros.php');
     
	 $("#ViewAsientoAnticipo").load('../controller/Controller-ren_rubros_ser.php');

}
//----------------------
 
//--- 
function PoneDoc( id ) {
	 	 
	$('#action_servicios').val('edit');
	
 
    var parametros = {
		'id' : id  ,
		'action' : 'visor'
		}; 

		$.ajax({
			data: parametros,
			url: "../model/Model-ren_rubro_matriz.php",
			type:  'GET' ,
			dataType: 'json',  
		}).done(function(respuesta){
		 
				$('#id_rubro_matriz').val(respuesta.id_rubro_matriz);
				$('#estado1').val(respuesta.estado);
				$('#id_rubro1').val(respuesta.id_rubro);
				$('#idproducto_ser').val(respuesta.idproducto_ser);
				
	           
		});
	 
 
		
}
//------------------------
function PoneCuenta( id ) {
	 
 	
    var parametros = {
		'id' : id  ,
		'accion' : 'visor'
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_ren_matriz.php",
			type: "GET",
			success: function(response)
			{
				$('#ViewFormDetalle').html(response);
			}
		});
 
		
}
//-----GuardarMatriz 
function GuardarMatriz(   ) {
	 
	
	      
	   
	  var id_rubro        =  $('#id_rubro').val();
	  var idproducto_ser  =  $('#idproducto_ser').val();   
	  var estado 		  =  $('#estado1').val();  
	  var id 		      =  $('#id_rubro_matriz').val();  
	  
 	  var action 		  =  $('#action_servicios').val();  
	  
	  
	   
	   $('#id_rubro1').val(id_rubro);
	  
	   if ( id_rubro >  0){
		   
			   alertify.confirm("Guardar Registro Matriz", function (e) {
			   if (e) {
		 	
			    var parametros = {
					'id' : id  ,
					'id_rubro' : id_rubro,
					'idproducto_ser' : idproducto_ser,
					'estado' : estado,
					'action' : action
					}; 
			
					$.ajax({
						data: parametros,
						url: "../model/Model-ren_rubro_matriz.php",
						type: "POST",
						success: function(response)
						{
							$('#guardarAnticipo').html(response);
							
							PoneCuenta( id_rubro );
						}
					});
					
				   }
				 }); 
	   }		   
			   
}
/*
*/
function goToURLDocdel( id_rubro_matriz ) {
	 
	
	var id_rubro  =  $('#id_rubro').val();

	var parametros = {
			  'id_rubro_matriz' :  id_rubro_matriz,
		 	  'id' : id_rubro,
			  'accion' :  'elimina'
			 }; 

			 $.ajax({
				 data: parametros,
				 url: "../model/ajax_ren_matriz.php",
				 type: "GET",
				 success: function(response)
				 {
					 $('#ViewFormDetalle').html(response);
				 }
			 });
	  

}
/*
*/
function VisorPartida( cuenta, partida ) {
	 
	
	   var parametros = {
 				'partida' :  partida,
				'cuenta' : cuenta,
 				'tipo' :  'partida_visor'
				}; 

				$.ajax({
					data: parametros,
					url: "../model/ajax_cuenta_partida.php",
					type: "GET",
					success: function(response)
					{
						$('#cuenta_ing').html(response);
					}
				});
		 
 
}
//------------------
function openFile(url,ancho,alto) {
    
	  var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  
  enlace = url  ;

  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
  