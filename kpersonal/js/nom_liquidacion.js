var oTable;

$(function(){
 
    $(document).bind("contextmenu",function(e){

        return false;

    });
 
});

//-------------------------------------------------------------------------

$(document).ready(function(){

         oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "ye", "aTargets": [ 0 ] },
 		      { "sClass": "highlight", "aTargets": [ 2 ] },
			   { "sClass": "de", "aTargets": [ 6 ] }  
 		    ] 
	  } );
	  

		 $("#MHeader").load('../view/View-HeaderModel.php');
		 $("#FormPie").load('../view/View-pie.php');


		modulo();

	    FormView();

	    FormFiltro();

 
 
 	   $('#load').on('click',function(){
            BusquedaGrilla(oTable);
		});
 	    //-----------------------------------------------------------------
 	   $('#recargar').on('click',function(){
          BusquedaGrilla(oTable);
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
  
return false;	  

}
/*-------------------
*/

function ValidaAccion(tipo) {

	var parametros = {
		"tipo" : tipo 
};
 
	$.ajax({
			type:  'GET' ,
			data:  parametros,
			url:   '../model/ajax_busca_accion.php',
			dataType: "json",
			 success:  function (response) {

				  
					 $("#baselegal").val( response.a );  
					 
					if (response.b == 'S' ) {
						$('#ffinalizacion').attr('readonly', false);						
 
					}else {
						$('#ffinalizacion').attr('readonly', true);
					}

					
					if (response.c == 'S' )
					{
					   $('#idprovc').attr('readonly', false);						
 
					}else {
						$('#idprovc').attr('readonly', true);
					}

					  
					 
			} 
	});

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
					url:   '../model/Model_nom_liquidacion.php',
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
//------------------
///---------------
function openFile(url) {
    
    var id_liqcab = $("#id_liqcab").val();

	  
	  var ancho= 650;
	  var alto = 550;

 	  var posicion_x; 
	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id_liqcab  ;
	 
	  if ( id_liqcab) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
//------------------------------
function Calcular( ) {



    var estado = $("#estado").val();

    var idprov = $("#idprov").val();
    var salario = $("#salario").val();
    var ingreso = $("#ingreso").val();
    var salida = $("#salida").val();
    var motivo = $("#motivo").val();
    var discapacidad = $("#discapacidad").val();
    var A1 = $("#A1").val();
    var A7 = $("#A7").val();
    var A9 = $("#A9").val();

 

	var parametros = {
 					'idprov'   : idprov ,
                     'salario'   : salario ,
                     'ingreso'   : ingreso ,
                     'salida'   : salida ,
                     'motivo'   : motivo ,
                     'discapacidad'   : discapacidad ,
                     'A1'   : A1 ,
                     'A7'   : A7 ,
                     'A9':A9
 	  };



                $.ajax({
                    data:  parametros,
                    url:   '../model/ajax_liquida01.php',
                    type:  'POST' ,
                    dataType: "json",
                    success:  function (response) {
                        
                            $("#A2").val( response.a );  
                            $("#A3").val( response.b );  
                            $("#A4").val( response.c );  
                            $("#A5").val( response.d );  
                            $("#A6").val( response.e );  
                            $("#A8").val( response.f );  

                            $("#I5").val( response.g );  
                            $("#I1").val( response.h );  
                            $("#I2").val( response.i );  
                            $("#I3").val( response.j );  
                            $("#I4").val( response.k );  

                            $("#I6").val( response.l );  

                            $("#I7").val( response.m );  
                            $("#I8").val( response.n );  
                            
                           
alert('Datos calculados... verificar informacion');
                                
                    } 
            });

 
            calcula_dato( );
 
 
}
//-------------------------------------------------------------------------
function Aprobar( ) {

	var id_liqcab = $("#id_liqcab").val();

    var estado = $("#estado").val();

	var parametros = {
					'accion' : 'aprobar',  
					'id'   : id_liqcab 
 	  };

		if ( estado == 'digitado'){

				alertify.confirm("Desea Aprobar el documento  solicitado", function (e) {
					
										if (e) {
							
												$.ajax({
																data:  parametros,
																url:   '../model/Model_nom_liquidacion.php',
																type:  'GET' ,
																cache: false,
																beforeSend: function () { 
																		$("#result").html('Procesando');

																},
																success:  function (data) {
																		$("#result").html(data);  // $("#cuenta").html(response);
																} 
														}); 

														BusquedaGrilla(oTable);
							
										}
								}); 
		}
 
}
//------
function calcula_dato( ) {
 
 

    var i1 = $("#I1").val();
    var i2 = $("#I2").val();
    var i3 = $("#I3").val();
    var i4 = $("#I4").val();
    var i5 = $("#I5").val();
    var i6 = $("#I6").val();
    var i7 = $("#I7").val();
    var i8 = $("#I8").val();

    var j1 = $("#J1").val();
    var j2 = $("#J2").val();
    var j3 = $("#J3").val();

   
    var e1 = $("#E1").val();
    var e2 = $("#E2").val();
    var e3 = $("#E3").val();
    var e4 = $("#E4").val();
    var e5 = $("#E5").val();
    var e6 = $("#E6").val();


    var suma_ingreso =  parseFloat(i1)  + parseFloat(i2) + parseFloat(i3)  + parseFloat(i4)  +
                        parseFloat(i5)  + parseFloat(i6)  + parseFloat(i7)  + parseFloat(i8) ;

    var suma_adi =  parseFloat(j1)  + parseFloat(j2) + parseFloat(j3)   ;

    var suma_egreso =  parseFloat(e1)  + parseFloat(e2) + parseFloat(e3)  + parseFloat(e4)  +
                        parseFloat(e5)  + parseFloat(e6) ;                      

      suma_ingreso = parseFloat(suma_ingreso)  +  parseFloat(suma_adi);

      var total    = suma_ingreso - suma_egreso;

      total        = parseFloat(total).toFixed(2)  ;

      suma_ingreso =  parseFloat(suma_ingreso).toFixed(2)  ;

      suma_egreso  =  parseFloat(suma_egreso).toFixed(2)  ;
       
                          
     $("#tingreso").val(suma_ingreso);      
     
     $("#tdescuento").val(suma_egreso);    

          
     $("#tpago").val(total);    

}
//--------------------------------------------------------
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
		
		var fecha = fecha_hoy();

		var fechaf = fecha_fin();

		$("#salida").val(fecha);

        
 
		$("#id_liqcab").val("");
		$("#idprov").val("");
		$("#razon").val("");
 		$("#comprobante").val("");
		$("#fecha").val(fecha);
		$("#motivo").val("");
		$("#fecha_rige").val(fecha);
		$("#discapacidad").val("");
		$("#estado").val("digitado");
		$("#regimen").val("");
		$("#programa").val("");
		$("#unidad").val("");
		$("#cargo").val("");
		$("#salario").val("");
	 

        $("#I1").val("0.00");
        $("#I2").val("0.00");
        $("#I3").val("0.00");
        $("#I4").val("0.00");
        $("#I5").val("0.00");
        $("#I6").val("0.00");
        $("#I7").val("0.00");
        $("#I8").val("0.00");

        $("#A2").val("0.00");
        $("#A3").val("0.00");
        $("#A4").val("0.00");
        $("#A5").val("0.00");
        $("#A6").val("0.00");
         $("#A8").val("0.00");
      
        $("#E1").val("0.00");
        $("#E2").val("0.00");
        $("#E3").val("0.00");
        $("#E4").val("0.00");
        $("#E5").val("0.00");
        $("#E6").val("0.00");     
        
        $("#J1").val("0.00");
        $("#J2").val("0.00");
        $("#J3").val("0.00");

        
 
		        
        

}
//-----------
function ShowSelected()
{
            /* Para obtener el texto */
            var combo = document.getElementById("id_periodo");
            var selected = combo.options[combo.selectedIndex].text;
            var resultado = selected.split("-");
             
            $("#anio").val(resultado[2]);
            $("#mes").val(resultado[1]);
            $("#novedad").val( 'Rol Periodo ' + resultado[0] + '-' + resultado[2]);

}
//------------
function accion(id,modo,estado)
{
	$("#action").val(modo);
	
	$("#id_liqcab").val(id);

   // BusquedaGrilla(oTable);
}
//---------------
 
//---------------
 function fecha_hoy()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd;
    } 

    if(mm < 10){
        mm='0'+ mm;
    } 

    var today = yyyy + '-' + mm + '-' + dd;

return today;
            

} 
//-----------------------------
 function fecha_fin()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd;
    } 

    if(mm < 10){
        mm='0'+ mm;
    } 

    var today = yyyy + '-12-31';

return today;
            

} 
//------------------------------------------------------------------------- 
function BusquedaGrilla(oTable){        	 

		 var fanio   = $("#fanio").val();
 		 var festado = $("#festado").val();
 
    
     	
        var parametros = {
				'fanio' : fanio,
 				'festado' : festado  
        };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_nom_liquidacion.php',
			dataType: 'json',
			cache: false,
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
                        s[i][7],
                        s[i][8],
   					'<button class="btn btn-xs btn-warning" title="EDITAR TRANSACCION..." onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;' + 

					'<button class="btn btn-xs btn-danger" title="ANULAR TRANSACCION..." onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 

				]);										

			} // End For
         }
       } 
      });
}   

//----------

function BuscaDatos()
{

   var prove =  $("#idprov").val();

   var fecha =  $("#fecha").val();
 
   const periodo = new Date(fecha);

   var anio = periodo.getFullYear();

 	 var parametros = {

			    'prove' : prove ,
                'cuenta':'-',
                'bandera':'N',
                'anio': anio

    };

    if (prove){
 
                $.ajax({

                        data:  parametros,

                        url:   '../../kcontabilidad/model/Model_listaAuxq.php',

                        type:  'GET' ,

                        cache: false,

                        beforeSend: function () { 

                                    $("#ViewFormAUX").html('Procesando');

                            },
                        success:  function (data) {

                                $("#ViewFormAUX").html(data);  // $("#cuenta").html(response);

                            } 

                });
      }
}
//------------------------------------------------------------------------- 
function modulo()
{

 	 var modulo =  'kpersonal';
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
//----------------- nom_liquidacion.js
function FormView()
{
	 $("#ViewForm").load('../controller/Controller_nom_liquidacion.php');
}
//----------------------
function FormFiltro()
{
	 $("#ViewFiltro").load('../controller/Controller_nom_liquidacion_filtro.php');
}
