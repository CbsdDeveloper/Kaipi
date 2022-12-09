var oTable ;
 
//-------------------------------------------------------------------------

$(document).ready(function(){

        oTable = $('#jsontable').dataTable(); 
        
      	$("#MHeader").load('../view/View-HeaderModel.php');

		$("#FormPie").load('../view/View-pie.php');

		
		// OPCIONES DEL SISTEMA
		modulo();

		// FORMULARIOS
	    FormView();
 

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

// ir a la opcion de editar
function goToURL(accion,id) {

 
	
   var resultado = Mensaje( accion ) ;
	
	
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	$.ajax({
		  url:   '../model/Model-catalogo.php',
		  type:  'GET' ,
		  data:  parametros,
		  dataType: 'json',  
	}).done(function(respuesta){
 			
		 		$("#idpre_catologo").val(respuesta.idpre_catologo );
				$("#codigo").val(respuesta.codigo);
				
				$("#detalle").val(respuesta.detalle);
				$("#tipo").val(respuesta.tipo);
				$("#nivel").val(respuesta.nivel);
				$("#transaccion").val(respuesta.transaccion);
				$("#estado").val(respuesta.estado);
				$("#categoria").val(respuesta.categoria);
				$("#subcategoria").val(respuesta.subcategoria);
				$("#pac").val(respuesta.pac);
				$("#modulo").val(respuesta.modulo);
 			 						
				$("#action").val(accion); 
				$("#result").html(resultado);
 	 
	 
	});
 
	  
	  	$('#mytabs a[href="#tab2"]').tab('show');
	  	
 }
//-----------------------------------------------------------------
function Mensaje(accion) {
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {

 
	    var fecha = fecha_hoy();
 

		$("#action").val("add");

		
		$("#idpre_catologo").val("");
		$("#codigo").val("");
		$("#detalle").val("");
		$("#tipo").val("");
		$("#nivel").val("");
		$("#transaccion").val("");
		$("#estado").val("");
		$("#categoria").val("");
		$("#subcategoria").val("");
		$("#pac").val("");
		$("#modulo").val("");

 }
//----------------------------------
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

 

     return  today;      

} 
//------------------------------------------------------------------------- 
function BusquedaGrilla(oTable){        	 

	  var festado         = $("#festado").val();
	  var ftipo           = $("#ftipo").val();
	  var fcategoria      = $("#fcategoria").val();
	  var fsubcategoria   = $("#fsubcategoria").val();
  
	  var fgrupo   = $("#fgrupo").val();
	  
	  

      var parametros = {
				'festado' : festado  ,
				'ftipo' : ftipo  ,
				'fcategoria' : fcategoria  ,
				'fsubcategoria' : fsubcategoria   ,
				'fgrupo': fgrupo
      };


 		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_catalogo.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
				if(s){
					for(var i = 0; i < s.length; i++) {
						oTable.fnAddData([
	                      s[i][0],
	                      s[i][1],
	                      s[i][2],
	                      s[i][3],
						  s[i][4],
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
//------------------------------------------------------------------------- 
 
//------------------------------------------------------------------------- 
function modulo()
{

 	 var modulo1 =  'kpresupuesto';
 	 var parametros = {

			    'ViewModulo' : modulo1 

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
//----------------------------------------------------------------------------------
function FormView()
{

	 $("#ViewForm").load('../controller/Controller-catalogo.php');


	 $("#ViewFiltro").load('../controller/Controller-catalogo_filtro.php');

}
//----------------------------------------------------------------------------------
function accion(id,modo,estado)
  {
 
 

		   $("#action").val('aprobado');
		   
		   $("#idpre_catologo").val(modo);
 		   

            BusquedaGrilla(oTable);
 

}
//------ 
function listaClasificador(grupo)
{
	
 
 
		var parametros = {
							'grupo' : grupo  
						};
		
				$.ajax({
					data: parametros,
					url: "../model/ajax_lista_catalogo_item.php",
					type: "GET",
					success: function(response)
					{
							$('#fgrupo').html(response);
					}
				});
		
 
	
	
}
