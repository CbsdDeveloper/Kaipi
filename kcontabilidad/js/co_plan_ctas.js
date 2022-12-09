"use strict";
 
var oTable;

var formulario = 'co_plan_ctas';

//-------------------------------------------------------------------------

$(document).ready(function(){

         oTable = $('#jsontable').dataTable(); 

		 

         $("#MHeader").load('../view/View-HeaderModel.php');

		 $("#FormPie").load('../view/View-pie.php');

		 modulo();

	     FormView();

	     FormArbolCuentas(1,'-');

 		 $('#load').on('click',function(){

 			 BusquedaGrilla(oTable);

			});
  	    
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			

			if (tipo =="confirmar"){			 

			

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

			       	

                    LimpiarPantalla();

                    

					$("#action").val("add");

					 

					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');

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
 				url:   '../model/Model-co_plan_ctas.php',
 				type:  'GET' ,
 				cache: false,
 				beforeSend: function () { 
 						$("#result").html('Procesando');
 					},
 				success:  function (data) {
 						 $("#result").html(data);  // $("#cuenta").html(response);
 					} 
 		}); 


 if ( accion == 'activa'){
	 
 }else{
        $('#myModal').modal('hide');
    	$( "#exitmodal" ).click();   
 }
 
 

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

   

	$("#action").val("add");


	$("#cuenta").val("");
	$("#cuentas").val("");
	$("#detalle").val("");
	$("#nivel").val("");
	$("#tipo").val("");
	$("#univel").val("N");

	$("#aux").val("N");
	$("#tipo_cuenta").val("-");
	$("#estado").val("S");
 	$("#documento").val("0");
	$("#comprobante").val("0");
	$("#idprov").val("-");

 

}
//---------------------------

function accion(id,modo,estado)

{

  

	$("#action").val(modo);
	$("#cuenta").val(id);
	BusquedaGrilla(oTable);



}



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

    

 

 

            

} 

function myFunctiona(codigo,objeto)

{
	   var accion = 'estado_cuenta';
		var estado = 'N';

	   if (objeto.checked == true){
			estado = 'S';
		} else {
			estado = 'N';
		}


	   var parametros = {
				 'accion' : accion ,
				'id'     : codigo ,
				'estado' : estado

	 };

	
	 
$.ajax({
				data:  parametros,
				url:   '../model/Model-co_plan_ctas.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
						$("#result").html('Procesando');
					},
				success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					} 
		}); 

}
//-----------------------------

 function myFunction(codigo,objeto)

 {
 	   var accion = 'impresion';
  	   var estado = '0';

	    if (objeto.checked == true){
 	    	estado = '1';
 	    } else {
 	    	estado = '0';
 	    }

 
	    var parametros = {
 				 'accion' : accion ,
                 'id'     : codigo ,
                 'estado' : estado

	  };

	 
      
 $.ajax({
 				data:  parametros,
 				url:   '../model/Model-co_plan_ctas.php',
 				type:  'GET' ,
 				cache: false,
 				beforeSend: function () { 
 						$("#result").html('Procesando');
 					},
 				success:  function (data) {
 						 $("#result").html(data);  // $("#cuenta").html(response);
 					} 
 		}); 
 
 }
//----
//------------------------------------------------------------------------- 
function BusquedaGrilla(oTable){        	 

	   var GrillaCodigo =  $("#bcuenta").val();
       var detalle      =  $("#bdetalle").val();
	   var bitem      =  $("#bitem").val();
	   



       var parametros = {
    		    'GrillaCodigo' : GrillaCodigo  ,
				'detalle': detalle,
				'bitem':bitem
       };

     
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_plan_ctas.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
			if (s){
					for(var i = 0; i < s.length; i++) {
 							oTable.fnAddData([
								s[i][0]  ,
								s[i][1],
								'<input type="checkbox" id="myActivo'+ s[i][6] +'"   onclick="myFunctiona('+ "'"+ s[i][0] +"'" +',this)" '+ s[i][2]  + '>',
								s[i][3],
								s[i][4],
								'<input type="checkbox" id="myCheck'+ s[i][6] +'"   onclick="myFunction('+ "'"+ s[i][0] +"'" +',this)" '+ s[i][5]  + '>',
								'<button class="btn btn-xs" title="Editar Registro" onClick="javascript:goToURL('+"'editar'"+','+ "'" +s[i][0].trim() +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;' + 
								'<button class="btn btn-xs" title="Eliminar Registro" onClick="javascript:goToURL('+"'del'"+','+"'" +s[i][0].trim()+"'"+')"><i class="glyphicon glyphicon-remove"></i></button>&nbsp;&nbsp;'  +
								'<button class="btn btn-xs" title="Bloquear Cuenta" onClick="javascript:goToURL('+"'activa'"+','+"'" +s[i][0].trim()+"'"+')"><i class="glyphicon glyphicon-warning-sign"></i></button>'
							]);										
					} // End For
			}					
 		},
 		error: function(e){
			   console.log(e.responseText);	
		}
	});


}   
//------------------------------------------------------------------------- 
function modulo()
{

 	 var modulo =  'kcontabilidad';

 	 var parametros = {

			    'ViewModulo' : modulo 

    };

 	$.ajax({

			data:  parametros,

			 url:   '../model/Model-moduloOpcion.php',

			type:  'GET' ,

			cache: false,

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
 

	 $("#ViewForm").load('../controller/Controller-' + formulario);

 

 }

 

//----------------------
 

 function FormArbolCuentas(nivel,tipo)

 {

     var ttipo      =  $("#ttipo").val();
 
     var tipo1		 = '-';
      

     if (tipo == '-'){

    	 tipo1 = '-';

     }else
     	 {

    	 tipo1 = ttipo;

    	 }

 
	 $("#ViewFormArbol").load('../controller/Controller-plan_cuenta.php?nivel=' +nivel + '&tipo=' +tipo1 );

 

 }

 

 function goToURLArbol(vid) {



 

	    var accion = "'" + "editar" + "'";

	    var id  = "'" + vid + "'";

	     var parametros = {

						'accion' : accion ,

	                   'id' :id 

		  };

	 

	 	   $.ajax({

						data:  parametros,

				    	url:   '../model/Model-co_plan_ctas.php',

						type:  'GET' ,

						cache: false,

						beforeSend: function () { 

								$("#result").html('Procesando');

	 					},

						success:  function (data) {

								 $("#result").html(data);   

							     

	 					} 

				}); 

	 

	 	  $('#mytabs a[href="#tab2"]').tab('show');

	 	  

	}

//----------------------------------------- 

 function imprimir_informe(url) {



	 

	 window.open(url,'_blank');

	 	  

	}
//--------------
 function CreaPlanCuentas(  ) {


 	    var anio_selecciona   =  $("#anio_selecciona").val();
	 
 
	    alert(anio_selecciona);
	    
	   
 	     var parametros = {
 						'anio_selecciona' : anio_selecciona
 		  };

 		  alertify.confirm("Copiar Plan de Cuentas", function (e) {
 			  if (e) {
  				 	   $.ajax({
 									data:  parametros,
							    	url:   '../model/Model-co_plan_ctas_copiar.php',
									type:  'GET' ,
									cache: false,
									beforeSend: function () { 
 											$("#resultadoCta").html('Procesando');
 				 					},
									success:  function (data) {
 											 $("#resultadoCta").html(data);   
 			
				 					} 
			
							}); 
			  }

			 });  	   
 
 
 
 }
 //--------------
 function CreaMatriz(  ) {


 	    var anio_selecciona   =  $("#anio_selecciona").val();
	  
 	     var parametros = {
 						'anio_selecciona' : anio_selecciona
 		  };

 		  alertify.confirm("Trasladar Matriz de Estados Financieros", function (e) {
 			  if (e) {
  				 	   $.ajax({
 									data:  parametros,
							    	url:   '../model/Model-matriz_copiar.php',
									type:  'GET' ,
									cache: false,
									beforeSend: function () { 
 											$("#resultadoCta").html('Procesando');
 				 					},
									success:  function (data) {
 											 $("#resultadoCta").html(data);   
 			
				 					} 
			
							}); 
			  }

			 });  	   
 
  
 }
//--------------- 
function ValidaMatriz(  ) {


	var anio_selecciona   =  $("#anio_selecciona").val();
 
	 var parametros = {
					'anio_selecciona' : anio_selecciona,
					'tipo': 1
	  };

	  alertify.confirm("Verificar Matriz de Asociacion", function (e) {
		  if (e) {
					 $.ajax({
								data:  parametros,
							   url:   '../model/Model-matriz_valida_esigef.php',
							   type:  'GET' ,
							   cache: false,
							   beforeSend: function () { 
										$("#resultadoCta").html('Procesando');
								 },
							   success:  function (data) {
										 $("#resultadoCta").html(data);   
		
								} 
	   
					   }); 
		 }

		});  	   

	 

}
//-----
function ValidaEsigef(  ) {


	var anio_selecciona   =  $("#anio_selecciona").val();
 
	 var parametros = {
					'anio_selecciona' : anio_selecciona,
					'tipo': 2
	  };

	  alertify.confirm("Verificar Matriz de archivo esigef", function (e) {
		  if (e) {
					 $.ajax({
								data:  parametros,
							   url:   '../model/Model-matriz_valida_esigef.php',
							   type:  'GET' ,
							   cache: false,
							   beforeSend: function () { 
										$("#resultadoCta").html('Procesando');
								 },
							   success:  function (data) {
										 $("#resultadoCta").html(data);   
		
								} 
	   
					   }); 
		 }

		});  	   

	 

}
//---------------------
 function realizaProceso(codigo_cuenta)
{


	var accion = $("#action").val();

	var parametros = {
					'codigo_cuenta' :  codigo_cuenta 
			};

			
  if ( accion == 'add') {
			$.ajax({
					data:  parametros,
					url:   '../model/ajax_CodigoCuenta.php',
					type:  'GET' ,
					beforeSend: function () {
							$("#cuenta").val('Procesando');
					},
					success:  function (response) {
							 $("#cuenta").val(response);   

					} 

			});
			
	} 
			
}
/*
*/

function Filtra_cta(codigo_cuenta)
{

 
 

	var parametros = {
					'tipo' :  codigo_cuenta 
			};

			$.ajax({
				data: parametros,
				url: "../model/ajax_filtro_tipo.php",
				type: "GET",
				success: function(response)
				{
						$('#cuentas').html(response);
				}
				});
			
 
			 
			
 
			 
}