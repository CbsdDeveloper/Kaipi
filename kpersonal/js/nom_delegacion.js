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
			   { "sClass": "de", "aTargets": [ 7 ] }  
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
					url:   '../model/Model-nom_delegacion.php',
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
    
	  var id = $('#id_delega').val();

	  
	  var ancho= 650;
	  var alto = 550;

 	  var posicion_x; 
	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id  ;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}
//------------------------------
function Revertir( ) {

	var id_accion = $("#id_delega").val();

    var estado = $("#estado").val();

	var parametros = {
					'accion' : 'revertir',  
					'id'   : id_accion 
 	  };

 

 alertify.confirm("Desea Revertir  el documento  solicitado", function (e) {
    
            			  if (e) {
            
								$.ajax({
												data:  parametros,
												url:   '../model/Model-nom_delegacion.php',
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
//-------------------------------------------------------------------------
function Aprobar( ) {

	var id_accion = $("#id_delega").val();

    var estado = $("#estado").val();

	var parametros = {
					'accion' : 'cierre',  
					'id'   : id_accion 
 	  };

		if ( estado == 'N'){

				alertify.confirm("Desea Aprobar el documento  solicitado", function (e) {
					
										if (e) {
							
												$.ajax({
																data:  parametros,
																url:   '../model/Model-nom_delegacion.php',
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
function Cierre( ) {

	var id_accion = $("#id_delega").val();

	var estado = $("#estado").val();

	var parametros = {
					'accion' : 'fin',  
					'id'   : id_accion 
 	  };

if ( estado == 'S'){
 alertify.confirm("Desea Aprobar el documento  solicitado", function (e) {
    
            			  if (e) {
            
								$.ajax({
												data:  parametros,
												url:   '../model/Model-nom_delegacion.php',
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

		$("#finalizacion").val(fecha);
 
		$("#id_delega").val("");
		$("#idprov").val("");
		$("#razon").val("");
 		$("#comprobante").val("");
		$("#fecha").val(fecha);
		$("#tipo").val("Reglamento");
		$("#motivo").val("Interno");
		$("#fecha_rige").val(fecha);
		$("#novedad").val("");
		$("#otro").val("otro");
		$("#estado").val("N");
		$("#regimen").val("");
		$("#programa").val("");
		$("#id_departamento").val("");
		$("#id_cargo").val("");
		$("#sueldo").val("");
		$("#p_regimen").val("");
		$("#p_programa").val("");
		$("#p_id_departamento").val("");
		$("#p_id_cargo").val("");
		$("#p_sueldo").val("");

		$("#finalizado").val("N");
		
		$("#ffinalizacion").val(fechaf);

		

		$("#referencia").val("");

		        
        

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
	
	$("#id_delega").val(id);

    BusquedaGrilla(oTable);
}
//---------------
function CrearPeriodo (){
	
	 $.ajax({
			url:   '../model/Model-co_periodos_anio.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
					$("#result").html('Procesando');
			},
			success:  function (data) {
					 $("#result").html(data);  // $("#cuenta").html(response);
				     alert(data);
			} 
}); 
    BusquedaGrilla(oTable);	
}
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
		 var fmes    = $("#fmes").val();
		 var festado = $("#festado").val();
 
    
     	
        var parametros = {
				'fanio' : fanio,
				'fmes' : fmes  ,
				'festado' : festado  
        };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_nom_delegacion.php',
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
   					'<button class="btn btn-xs btn-warning" title="EDITAR TRANSACCION..." onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;' + 

					'<button class="btn btn-xs btn-danger" title="ANULAR TRANSACCION..." onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 

				]);										

			} // End For
         }
       } 
      });
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
//-----------------
function FormView()
{
	 $("#ViewForm").load('../controller/Controller-nom_delegacion.php');
}
//----------------------
function FormFiltro()
{
	 $("#ViewFiltro").load('../controller/Controller-nom_delegacion_filtro.php');
}
