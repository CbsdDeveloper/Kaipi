var oTable ;
var oTablei ;


//-------------------------------------------------------------------------
$(document).ready(function(){
     
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		$("#FormPie").load('../view/View-Pie.php');
		
		modulo();
 		
		FormView();
     
		oTable    = $('#jsontable').dataTable(); 
		
		oTablei    = $('#jsontablei').dataTable(); 
		
	
		$('#load').on('click',function(){
			 
			FormArbolCuentas('tipo');
	       
		 });
 
	    BusquedaGrilla(oTable);

	    BusquedaGrillai(oTablei);

		
		 
		 
});  

//--------------------------------------
function BusquedaGrilla(oTable){        	 


	 
 
		$.ajax({
 		    url: '../grilla/grilla_matrizo.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
				  oTable.fnAddData([
                    s[i][0],
                    s[i][1],
                     '<button title="Copiar objetivos homologados" class="btn btn-xs" data-dismiss="modal" onClick="javascript:goToURL('+"'" +s[i][1] + "'"+')"><i class="glyphicon glyphicon-paste"></i></button>' 
                ]);									
			  } // End For
			}				
	  },

			error: function(e){

			   console.log(e.responseText);	

			}

			});

	 

}   
//---------------------------------------------------------------
//--------------------------------------
function BusquedaGrillai(oTablei){        	 


	 
 
		$.ajax({
 		    url: '../grilla/grilla_matrizi.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			//console.log(s); 
			oTablei.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
				  oTablei.fnAddData([
                    s[i][0],
                    s[i][1],
                     '<button title="Copiar Indicadores recomendados" class="btn btn-xs" data-dismiss="modal" onClick="javascript:goToURLi('+ "'" +s[i][0] + "',"+"'" +s[i][1] + "'"+')"><i class="glyphicon glyphicon-paste"></i></button>' 
                ]);									
			  } // End For
			}				
	  },

			error: function(e){

			   console.log(e.responseText);	

			}

			});

	 

}   
//---------------------------------------------------------------
function ListaDes( ) {
 	 
		
	    $("#idestrategia").select2({dropdownCssClass : 'bigdrop'});
}

//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	//	$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
				 
					$("#result").html('<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>NUEVO REGISTRO TRANSACCION ?</b>');
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
    
 
            
} 
 
  //------------------------------------------------------------------------- 
 function FormArbolCuentas(tipo)
 {
 
     var codigo        =  $("#Q_IDUNIDADPADRE").val();
     var anio      =  $("#Q_IDPERIODO").val();
     
     if (tipo == '-'){
    	 codigo = '-';
     }
 
	 $("#ViewFormArbol").load('../controller/Controller-unidadtecho_arbol.php?codigo='+codigo+'&anio='+anio);
	 
 
 
 }
 
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function DetalleOpcion() {
 
    var id =   $('#id_par_modulo').val();
 
     var parametros = {
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_opcion_det.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#opcionModulo").html('Procesando');
  					},
					success:  function (data) {
							 $("#opcionModulo").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }

//--------------------------------------------------------------------	verifica_oo
function verifica_oo( ) {

}
function verifica_ii() {

}
//---------------
function goToURL(cdato) {
 	
	  $('#objetivo').val(cdato);

 

}	
function goToURLi(cdato,dato1) {
 	
	  $('#indicador').val(cdato);

      $('#detalle').val(dato1);

}	
//-----------------	
function goToURLDato(vid) {
	
	 
	     var id  	  =  vid;
	     var periodo  =  $('#Q_IDPERIODO').val();
	     
	    $('#Q_IDUNIDAD').val(vid);

		$('#depa').val(vid);
	     
	     var parametros = {
 	                   'id' 	:id ,
 	                   'periodo':periodo
		  };
	 
	 	   $.ajax({
						data:  parametros,
				    	url:   '../model/Model-DatoUnidadOO.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
								$("#ViewVisorArbol").html('Procesando');
	 					},
						success:  function (data) {
								 $("#ViewVisorArbol").html(data);   
							     
	 					} 
				}); 
	 	   
 		busquedaArticulado();
 }	  
  
function goToURLArbol(vid) {

 
    var action =  "visor" 
    var id  =  vid  ;
   
    var parametros = {
					'action' : action ,
                    'id' :id 
	  };

	   $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							 $("#result").html(data);   
						     
					} 
			}); 
 
}

//-------------
function goToIndicador(vid) {

	 
    var action =  "visor"; 
    var id  =  vid  ;
   
    var parametros = {
					'actionindicador' : action ,
                    'id' :id 
	  };

	   $.ajax({
					data:  parametros,
			    	url:   '../model/Model-OO-indicador.php',
					type:  'POST' ,
					cache: false,
					beforeSend: function () { 
							$("#resultadoIndicador").html('Procesando');
					},
					success:  function (data) {
							 $("#resultadoIndicador").html(data);   
						     
					} 
			}); 
 
}


//-------------------------------------------------------------------------
//ir a la opcion de editar
function FiltroArticula() {

 
	  $.ajax({
 					url:   '../model/Model-admin_opcion.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#result").html('Procesando');
					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
					} 
			}); 

	 
 }


//-------------
function PoneCodigo(codigo)
{
 
 
 var parametros = {
			    'codigo' : codigo 
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-CodiUnidad.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#IDUNIDAD").val('Procesando');
				},
			success:  function (data) {
					 $("#IDUNIDAD").val(data);  // $("#cuenta").html(response);
				     
				} 
	});
     
 
}

//-------------
function PoneObjetivoI()
{
 
var id_dato      = $('#depa').val();
	
 $("#idobjetivo_indicador").select2({dropdownCssClass : 'bigdrop1'});
    
  var idperiodo =   $('#Q_IDPERIODO').val();
  
  
  
  var parametros = {
			    'codigo'    : id_dato ,
			    'idperiodo' : idperiodo
   };
	  
 
  $.ajax({
		  data: parametros,
		  url:   '../model/Model-UnidadObjIndicador.php',
		  type: "GET",
		  success: function(response)
		  {
			  $('#idobjetivo_indicador').html(response);
		  }
	  });
	  
 
 
}

 

//-----------------
function FormView()
{
   
	 
 	 $("#ViewForm").load('../controller/Controller-objetivoo.php');
     
 	   
	 $("#ViewFiltro").load('../controller/Controller-unidadobj.php');
	 
	 
	// $("#FiltroUnidad").load('../controller/Controller-unidadArticulaFiltro.php');
	 
	
	 $("#ViewFormIndicador").load('../controller/Controller-objetivo_indicador.php');
	 
	 
	 
 	 $("#result").html('Desea agregar informacion');
 	
 	 
}
 
function accion(id,modo)
{
 
  	 $("#action").val(modo);
 	 
	 $("#idobjetivo").val(id);
 

	  var vid = $('#depa').val();

	 goToURLDato(vid);
	 
}

function accionIndicador(id,modo)
{
 
  	 $("#actionindicador").val(modo);
  
	 
	 $("#idobjetivoindicador").val(id);
 
	 
}


 //-------------------
function LimpiarPantalla( )
{
	 
 	 $("#action").val('add');

 	$("#idobjetivo").val("");

 
	var id_dato      = $('#depa').val();
 
 	$("#id_departamento").val(id_dato);
   



 	$("#idestrategia").val("");
 	$("#objetivo").val("");
 	$("#estado").val("");

 	$("#anio").val("");
 	$("#aporte").val("");
 	$("#ambito").val("");
 
 	
 	$("#result").html("Crear un nuevo objetivo");
 	
 
 
}
//-------------------
function LimpiarPantallaIndicador() 
{
	 
	var qanio        =   $('#Q_IDPERIODO').val();
	
	var id_dato      = $('#depa').val();

	$("#IDUNIDAD_INDICADOR").val(id_dato);
	
    $("#anio_indicador").val(qanio);
	
 	
	$("#id_departamento_indicador").val(id_dato);
	
	$("#actionindicador").val("add");
	 
	var parametros = {
				    'codigo'    : id_dato ,
				    'idperiodo' : idperiodo
	};
		  

		$("#idobjetivoindicador").val("");
		$("#idobjetivo_indicador").val("");
 		$("#indicador").val("");
		$("#detalle").val("");
		$("#tipoformula").val("");
		
	 	$("#idperiodo_indicador").val("");
	 	$("#anio").val(qanio);

		$("#estado1").val("");
		$("#periodo").val("");
 		$("#variable1").val("");
		$("#variable2").val("");
		$("#formula").val("");
		$("#meta").val("");
		$("#medio").val("");
		
		
    alert('Crear nuevo registro');

	$("#idobjetivo_indicador").select2({dropdownCssClass : 'bigdrop1'});
	  
	$.ajax({
			  data: parametros,
			  url:   '../model/Model-UnidadObjIndicador.php',
			  type: "GET",
			  success: function(response)
			  {
				  $('#idobjetivo_indicador').html(response);
			  }
		  });
		  
 
 
		$("#actionindicador").val("add");
	 
}
//---------------------
function modulo ( )
 {
	
	var modulo_sistema =  'kplanificacion';
	 
	 var parametros = {
			    'ViewModulo' : modulo_sistema 
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

//---------------------
function busquedaArticulado ( )
{
	
 
 	
	//Q_IDUNIDAD UnidadArticula
	
      var Q_IDUNIDAD =  $("#depa").val();
      
      var Q_IDPERIODO =  $("#Q_IDPERIODO").val();
       
	 var parametros = {
			    'Q_IDUNIDAD'  : Q_IDUNIDAD ,
			    'Q_IDPERIODO' : Q_IDPERIODO 
     };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-OOtree.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#UnidadArticula").html('Procesando');
				},
			success:  function (data) {
					 $("#UnidadArticula").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
	
	PoneObjetivoI(Q_IDUNIDAD);
	
 
}
 