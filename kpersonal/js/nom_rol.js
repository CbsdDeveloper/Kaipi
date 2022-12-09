var oTable;

$(function(){
 
    $(document).bind("contextmenu",function(e){

        return false;

    });
 
});

//-------------------------------------------------------------------------

$(document).ready(function(){

         oTable = $('#jsontable').dataTable(); 
		 $("#MHeader").load('../view/View-HeaderModel.php');
		 $("#FormPie").load('../view/View-pie.php');


		modulo();

	    FormView();

	    FormFiltro();

	    BusquedaGrilla( oTable);
 
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {

	 var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_rol.php',
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
//-------------------------------------------------------------------------
function CerrarPeriodo( ) {

	var anio = $("#anio").val("");

	var parametros = {
					'accion' : 'cierre',  
					'anio'   : anio 
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-nom_rol.php',
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
    	$("#id_periodo").val("");
    	$("#anio").val(" ");
	    $("#mes").val(" ");
		$("#estado").val(" "); 
		$("#id_rol").val("");
 		$("#novedad").val("");
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
	$("#id_rol").val(id);
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

        dd='0'+ dd

    } 

    if(mm < 10){

        mm='0'+ mm

    } 

  

    

    var today = yyyy + '-' + mm + '-' + dd;

    

    document.getElementById('fechatarea').value = today ;

    

    document.getElementById('fechafinal').value = today ;

 

            

} 
//------------------------------------------------------------------------- 
function BusquedaGrilla(oTable){        	 

     	var fanio = $("#fanio").val();
     	var fecha = new Date();
     	var ano = fecha.getFullYear();
 
     	if(fanio==null){
     		fanio = ano;
     	}
     	
        var parametros = {
				'fanio' : fanio  
        };


		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_nom_rol.php',
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

 					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 

					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 

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
	 $("#ViewForm").load('../controller/Controller-nom_rol.php');
}
//----------------------
function FormFiltro()
{
	 $("#ViewFiltro").load('../controller/Controller-nom_rol_dato_filtro.php');
}
