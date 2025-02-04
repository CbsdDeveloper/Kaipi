var oTableGrid;  
var oTable ;
var oTablePeriodo ;
var anio_periodo ;

"use strict"; 


//-------------------------------------------------------------------------
$(document).ready(function(){
    
        /*oTable 	   		= $('#jsontable').dataTable(); 
        oTableGrid 		= $('#ViewCuentas').dataTable();  
        */
        oTablePeriodo	= $('#jsontable_ingreso').dataTable();  
        

		$("#MHeader").load('../view/View-HeaderModel.php');
		$("#FormPie").load('../view/View-pie.php');

		modulo();
		
 	    FormFiltro();
 		
		ListaAnio();
		
		
		BusquedaGrillaPeriodo(oTablePeriodo);

	    $('#load').on('click',function(){
 	    	Ingresos() ;
 		});

	
	    $('#loadg').on('click',function(){
 	    	Gastos() ;
 
		});

		$('#loadSri').on('click',function(){
       //    openFile('../../upload/uploadxml?file=1',650,300)
		});
 

	   $('#loadAuxView').on('click',function(){
            BusquedaGrilla( );

		});

	
	   $('#loadpartidas').on('click',function(){
           GuardaPartida( );
		});

	    $('#loadxls').on('click',function(){
	  	  	var ffecha1 = $("#ffecha1").val();
	  	  	var ffecha2 = $("#ffecha2").val();
	  	  	var festado = $("#festado").val();
	  	  	var cadena = 'festado='+festado+'&ffecha1='+ffecha1+'&ffecha2='+ffecha2;
	  	  	var page = "../reportes/excel.php?"+cadena;  
	  	  	window.location = page;  
	    });
	    
 
	      estadoPresupuesto( );
	    
		
		 
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
				  if (e) {
					  	LimpiarDatos();
	                    LimpiarPantalla();
	                	$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
				  }
			 }); 
			}
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false;	  
}
//-------------------------------------------------------------------------
function BusquedaGrillaPeriodo(oTablePeriodo){        	 


	$.ajax({
	    url: '../grilla/grilla_periodo.php',
		dataType: 'json',
		cache: false,
		success: function(s){
		//console.log(s); 
		oTablePeriodo.fnClearTable();
		if(s){
			for(var i = 0; i < s.length; i++) {
				oTablePeriodo.fnAddData([
                     s[i][0],
                     s[i][1],
                     s[i][2],
                     s[i][3],
					 s[i][4],
					 '<button class="btn btn-xs" onClick="javascript:goToURLPeriodo('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> ' +
                     '<button class="btn btn-xs" onClick="javascript:goToURLPeriodo('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>'  ]);									
 			} // End For
 		   }				
	    	},
			error: function(e){
			   console.log(e.responseText);	
			}

		});

}   
//-------------------------------------------------------------------------
function goToURL(accion,id) {

	 $("#txtcuenta").val('');
	 $("#cuenta").val('');

	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-co_xpagar.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},

					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						 	 var idprov =  $("#idprov").val();
					 		 ListaAux(idprov);

  					} 
			}); 
}
///---------------ViewFiltroAux

//------------------------------------------------------------------------
//------------------------------------------------------------------------
function Detallepartidas(partida,tipo,i) {
	
 
	if ( tipo == 'I')       {
		var total =   $('#jtabla_ingresoi tr').eq(i).find('td').eq(2).text();
		var detalle =   $('#jtabla_ingresoi tr').eq(i).find('td').eq(1).text();
	}else{
		var total =   $('#jtabla_gasto tr').eq(i).find('td').eq(2).text();
		var detalle =   $('#jtabla_gasto tr').eq(i).find('td').eq(1).text();
	}
 
	  
	
	
	 $("#ddetalle").val(detalle);
	   
	 $("#monto_inicial_dato").val(total);
	 $("#fpartida").val(partida);
	 $("#ftipo").val(tipo);
	 
	 $("#guardarAux").html('');   
	
}
//-------------------------------------
function GuardarAuxiliar( ) {

	
	var monto_inicial_dato =  $("#monto_inicial_dato").val();
	var fpartida =  $("#fpartida").val();
	var ftipo =  $("#ftipo").val();
	 
	 var detalle = $("#ddetalle").val();

	 var orientador = $("#orientador").val();

	 
	

	var parametros = {
					'accion' : 'add' ,
                    'monto_inicial_dato' : monto_inicial_dato, 
                    'fpartida' : fpartida,
                    'ftipo' : ftipo,
                    'detalle': detalle,
					'orientador':orientador
	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model_emite_inicial.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#guardarAux").html('Procesando');
 					},
 					success:  function (data) {
							 $("#guardarAux").html(data);   
							 
						 	 if (ftipo == 'I'){
						 		 Ingresos();
						 	 }else {
						 		 Gastos();
						 	 }

 					} 
			}); 
 
} 
//-------------------------------------
function EliminarAuxiliar( ) {

	
	var monto_inicial_dato =  $("#monto_inicial_dato").val();
	var fpartida =  $("#fpartida").val();
	var ftipo =  $("#ftipo").val();
	 

	var parametros = {
					'accion' : 'del' ,
                    'fpartida' : fpartida,
                    'ftipo' : ftipo
	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model_emite_inicial.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#guardarAux").html('Procesando');
 					},
 					success:  function (data) {
							 $("#guardarAux").html(data);   
							 
						 	 if (ftipo == 'I'){
						 		 Ingresos();
						 	 }else {
						 		 Gastos();
						 	 }

 					} 
			}); 
 
}
//-----------------------------------------
function goToURLPeriodo(accion,id) {

 

	var parametros = {
					'accion' : accion ,
                    'id' : id 
	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model_periodo.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
							$("#guardarDocumento").html('Procesando');
 					},
 					success:  function (data) {
							 $("#guardarDocumento").html(data);   
						 	 

 					} 
			}); 
	  
	  		$('#myModalPeriodo').modal('show');
	  
}
//-------------------------------------------------------------------------
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

    return today;

} 
//-------------------------------------------------------------------------
 function Anio()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy =   $('#anio_crea').val();  
 
    
    return yyyy;
    

} 
 
 function ListaAnio()
 {

     var today = new Date();
     var dd = today.getDate();
     var mm = today.getMonth()+1;  
    
 	 var anio  =   today.getFullYear();
     
 	 var aanio;
 	 
   	$.ajax({
   	    type: 'get',
    	 url:   '../model/ajax_periodo.php',
    	 dataType: 'json',
    	 success: function(data){
    		 
      		 	aanio = JSON.parse(data.anio);
      		 	
      		    $('#anio_crea').append($('<option>', {  value: aanio, text: aanio  }));
      		
      		    var suma =  aanio  ;
       	    
	      	     var a = suma + 1;
	      	     var b = suma - 1;
	      	     var c = suma - 2;
	      	     var d = suma - 3;
	      	     
	      	     
	      	      $('#anio_crea').append($('<option>', {  value: a, text: a  }));
	      	      $('#anio_crea').append($('<option>', {  value: b, text: b  }));
	      	      $('#anio_crea').append($('<option>', {  value: c, text: c  }));
	      	      $('#anio_crea').append($('<option>', {  value: d, text: d  }));
	      	      
	      	      $('#fanio').val(aanio);
	      	      
	      	      document.getElementById("fanio").value = aanio;
	      	      
	      	     Total_Presupuesto( aanio );
          }
  
	});
 

 }  
//------------------------------------------------------------------------- 
 function Total_Presupuesto( fanio )

 {
 	  var parametros = {
 			    'fanio' : fanio  
  			  
 	  };

 	  $.ajax({

 			data:  parametros,
 			url:   '../model/ajax_saldo_presupuesto.php',
 			type:  'GET' ,
 			cache: false,
 			success:  function (data) {
  					 $("#presupuesto_total").html(data);   
   				} 

 	  });
  
 } 
//------------------------------------------------------------------------- 
  function Ingresos()
  {
  

	  var fanio   = $('#fanio').val(); 
	  var vfuente = $('#vfuente').val(); 
	  var vgrupo = $('#vgrupo').val(); 
	 
	  if ( 	$("#bi").val() == '0' ) {
		    $("#bi").val('1');
	  }
	  
	  var parametros = {

 			    'fanio' : fanio ,
 			    'vfuente' : vfuente , 
 			    'tipo' : 'I',
 			    'vgrupo' : vgrupo
     };

	  

  	$.ajax({
  			data:  parametros,
  			url:   '../model/Model_inicial_ingreso.php',
  			type:  'GET' ,
 			cache: false,
 			beforeSend: function () { 
 						$("#ViewFormIngresos").html('Procesando');
 				},
 			success:  function (data) {
 					 $("#ViewFormIngresos").html(data);   
 				} 

 	});

  
  	

  }
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
//------------------------------------------------
function estadoPresupuesto()
{

    var data;
 	
 	
 	$.ajax({
 			 url:   '../model/ajax_periodo_presupuesto.php',
			type:  'GET' ,
			dataType: "json",
            processData: true,
 			success:  function (response) {
 			      data = $.trim(response); //prevenir caracteres extra del server
 				  $("#estado_presupuesto").val(data);  
 				  
 				 if ( data == 'ejecucion'){
 			 		 $('#vinicial').attr("disabled", true); 
 			  	 }
 			 	 if ( data == 'cerrado'){
 					 $('#vinicial').attr("disabled", true); 
 				 }
 			 	 if ( data == 'proforma'){
 					 $('#vinicial').attr("disabled", false); 
 				 }
 			 	
 		 } 

	});
 	
  
  	
 	
 	

 }
//------------------GuardaPartida
 function GuardaPartida()

 {

	 var anio = $("#anio_crea").val();
	 var tipo = $("#tipo_crea").val();
	 
	 var grupoi = 	 	 $("#grupoi").val();
	 var itemi = 	 	 $("#itemi").val();
	 var subitemi = 	 $("#subitemi").val();
	 var detallei = 	 $("#detallei").val();
	 var fuentei = 	 	 $("#fuentei").val();
		 
		 
	 var actividadg = 	 $("#actividadg").val();
	 var grupog = 	 	 $("#grupog").val();
	 var itemg = 	 	 $("#itemg").val();
	 var detalleg = 	 $("#detalleg").val();
	 var fuenteg = 	 	 $("#fuenteg").val();
	 
	 var subitemg = 	 	 $("#subitemg").val();
	 var proyectog = 	 	 $("#proyectog").val();
	 var competenciag = 	 $("#competenciag").val();
	 var orientadorg = 	 	 $("#orientadorg").val();
	 var funciong = 	 	 $("#funciong").val();
	 var partidag = 	 	 $("#partidag").val();

	 
	 var vinicial   = 	 $("#vinicial").val();
 	 
	 if (tipo == 'I') {
		 
		 var parametros = {

				    'anio' : anio ,
				    'tipo' : tipo,
				    'grupo' : grupoi ,
				    'item' : itemi,
				    'subitem' : subitemi ,
				    'detalle' : detallei,
				    'fuente' : fuentei,
				    'vinicial' : vinicial

	    };
		// $("#clasig").val(itemg);
		// itemi
	 }else {
		 
		 $("#clasig").val(itemg);
		 
		 Ponepartida( );
		 
 
		 
		 var parametros = {

				    'anio' : anio ,
				    'tipo' : tipo,
				    'grupo' : grupog ,
				    'item' : itemg,
				    'actividad' : actividadg ,
				    'detalle' : detalleg,
				    'fuente' : fuenteg,
				    'vinicial' : vinicial,
				    'subitemg' : subitemg,
				    'proyectog' : proyectog,
				    'competenciag' : competenciag,
				    'orientadorg' : orientadorg,
				    'funciong' : funciong,
				    'partidag' : partidag

	    };
		 
	 }
		 
	 if ( tipo == '-') {
		 alert('Seleccione el tipo de presupuesto');
	 }else {
		 
	 		  alertify.confirm("Agregar partida", function (e) {
		
				  if (e) {
					  $.ajax({
							data:  parametros,
							 url:   '../model/Model-crea_partida.php',
							type:  'GET' ,
							cache: false,
							beforeSend: function () { 
										$("#ResultadoPartida").html('Procesando');
							},
							success:  function (data) {
									 $("#ResultadoPartida").html(data);   
											  
		 						} 
 				 	});
 				  }
 				 }); 
	 }
	 
 
 }
//----------------- 
 function PoneItem(grupo)
 {
 
  	   
 	    var parametros = {
 	            'grupo'       : grupo ,
 	           'tipo'       : 'I'
 	    };
 	    
  	    $.ajax({
 			data: parametros,
 			url: "../model/Model_busca_item.php",
 			type: "GET",
 			success: function(response)
 			{
 					$('#itemi').html(response);
 			}
 		});


 }
//----------------- 
 function PoneItemg(grupo)
 {
 
  	   
 	    var parametros = {
 	            'grupo'       : grupo ,
 	           'tipo'       : 'G'
 	    };
 	    
 	     
 	    $.ajax({
 			data: parametros,
 			url: "../model/Model_busca_item.php",
 			type: "GET",
 			success: function(response)
 			{
 					$('#itemg').html(response);
 			}
 		});


 }
 //-----------------------------------------
 function PoneSubItemi(item)
 {
 
  	   
 	    var parametros = {
 	            'item'       : item ,
 	            'tipo'       : 'I'
 	    };
 	    
 	       
 	   $.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/Model_busca_subitem.php',
			dataType: "json",
			success:  function (response) {

					
					 $("#subitemi").val( response.a );  
					 
					 $("#detallei").val( response.b );  
					  
			} 
	});

 }
 //------------------------
 function PoneSubItemg(item)
 {
  	   
 	    var parametros = {
 	            'item'       : item ,
 	            'tipo'       : 'G'
 	    };
 	    
 	       
 	   $.ajax({
		    type:  'GET' ,
			data:  parametros,
			url:   '../model/Model_busca_subitem.php',
			dataType: "json",
			success:  function (response) {

				 $("#subitemg").val( response.a );  
				 
				 $("#detalleg").val( response.b );  
  				 
					  
			} 
	});

 	   
  
	  
 }
 
//---------------------- 

 function FormFiltro()

 {

	 $("#ViewFiltro").load('../controller/Controller-inicial_filtro.php');

	 
	 $("#ViewFiltrog").load('../controller/Controller-inicialg_filtro.php');
	 
	 
	 $("#ViewFormPartida").load('../controller/Controller-crea_partida.php');
	 
	 $("#ViewPeriodo").load('../controller/Controller-periodo.php');
	 
	 
	 $("#ViewFiltroAux").load('../controller/Controller-inicial_monto.php');
	 
 
}
///-----------------------  
 function LimpiaPeriodos()
 {
	 $("#idperiodo").val("");
	 $("#anio").val("");
 	 $("#sesionm").val("");
	 $("#modificacion").val("");
	 $("#estado").val("");
 	 $("#detalle").val("");
 	 $("#action2").val("add");
 	
 }
 //----------------
 function accion_periodo(id, accion)
 {
	 $("#idperiodo").val(id);
 
 	 $("#action2").val(accion);
 	
  	 BusquedaGrillaPeriodo(oTablePeriodo);
  	 
  	//$('#mytabs a[href="#tab4"]').tab('show');
  	
 }
 function LimpiaDatos(tipo)
 {

	     $("#grupoi").val('');
		 $("#itemi").val('');
		 $("#subitemi").val('');
		 $("#detallei").val('');
		 $("#fuentei").val('');
		 
		 
		 $("#actividadg").val('');
		 $("#grupog").val('');
		 $("#itemg").val('');
		 $("#detalleg").val('');
		 $("#fuenteg").val('');
		 
		 $("#vinicial").val('');
  
		 
	 	if ( tipo == 'I') {
	 		
	 		 $('#grupoi').attr("disabled", false);
			 $('#itemi').attr("disabled", false);
			 $('#detallei').attr("disabled", false);
			 $('#subitemi').attr("disabled", false);
			 $('#fuentei').attr("disabled", false);
		 
			 $('#actividadg').attr("disabled", true); 
			 $('#grupog').attr("disabled", true); 
			 $('#detalleg').attr("disabled", true);  
			 $('#itemg').attr("disabled", true); 
			 $('#fuenteg').attr("disabled", true);  
			 
 			 $('#funciong').attr("disabled", true);
			 $('#subitemg').attr("disabled", true);
			 $('#competenciag').attr("disabled", true);
			 $('#orientadorg').attr("disabled", true);
			 
	 	}else{
	 		
	 		 $('#grupoi').attr("disabled", true);
			 $('#itemi').attr("disabled", true);
			 $('#detallei').attr("disabled", true);
			 $('#subitemi').attr("disabled", true);
			 $('#fuentei').attr("disabled", true);
			 
			 
			 $('#actividadg').attr("disabled", false); 
			 $('#grupog').attr("disabled", false); 
			 $('#detalleg').attr("disabled", false); 
			 
			 $('#itemg').attr("disabled", false); 
			 $('#fuenteg').attr("disabled", false);  
			 
			 $('#funciong').attr("disabled", false);
			 $('#subitemg').attr("disabled", false);
			 $('#competenciag').attr("disabled", false);
			 $('#orientadorg').attr("disabled", false);
			 
			 
			 
	 		    
			  $('#partidag').val('') ; 
			  $('#subitemg').val('') ; 
			  
	 	}
	 
	 
 } 
//------------------------
//-------------------
 function Ponepartida(   ){
	 

	  var longitud   = $('#estructura_gasto').val(); 
	 
	  var res = longitud.split("-");
	  
	  var cadena = '';
 
	  
      for(i=0;i<res.length ;i++)
      {
          
    	  cadena = cadena + $('#'+res[i]).val(); 
    	  
    	  
      }

      $('#partidag').val(cadena); 
       
 }
 
 
function Gastos( )
{
	  var fanio   = $('#fanio').val(); 
	  var vfuente = $('#vfuentegg').val(); 
	  
	  var vgrupo = $('#vgrupog').val(); 
	  var vactividad = $('#vactividad').val(); 
	  
	  var clasig = $('#clasig').val(); 
	  
	  var vprograma = $('#vprograma').val(); 
	  
	  
	  if ( 	$("#bg").val() == '0' ) {
		  $("#bg").val('1');
	  }
	  
 
	  
	  var parametros = {
			    'fanio' : fanio ,
			    'vfuente' : vfuente , 
			    'tipo' : 'G',
			    'vgrupo': vgrupo,
			    'vactividad' : vactividad,
			    'item': clasig,
			    'vprograma': vprograma
     };

	 $.ajax({
			data:  parametros,
			url:   '../model/Model_inicial_ingreso.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFormGastos").html('Procesando');
			},
			success:  function (data) {
					 $("#ViewFormGastos").html(data);   
			} 
	 	});

}
//------------------------------------
function openFile(url,ancho,alto) {

  var posicion_x; 
  var posicion_y; 
  var enlace; 


  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
 

  enlace = url  ;
 
  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

}

function filterTable() {
	// Obtener el valor de búsqueda
	const input = document.getElementById("searchInput");
	const filter = input.value.toUpperCase();
	const table = document.getElementById("jtabla_gasto");
	const tr = table.getElementsByTagName("tr");

	// Iterar sobre las filas de la tabla y ocultar las que no coincidan
	for (let i = 1; i < tr.length; i++) { // Empezar en 1 para saltar el encabezado
		const td = tr[i].getElementsByTagName("td");
		console.log(td)
		let match = false;

		// Verificar cada celda de la fila
		for (let j = 0; j < td.length; j++) {
			if (td[j] && td[j].innerText.toUpperCase().indexOf(filter) > -1) {
				match = true;
				break;
			}
		}

		// Mostrar u ocultar la fila
		tr[i].style.display = match ? "" : "none";
	}
}
