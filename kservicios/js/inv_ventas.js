var oTable;

var formulario = 'inv_ventas';

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
 	     
	    FormFiltro();
   		
	    $('#load').on('click',function(){
	 		   
	            BusquedaGrilla(oTable);
	  			
		});
	 
	    
	    //-------------------------------------------
	   
	  $('#ExcelButton').on('click',function(){
	 		   
	          	 var id_reforma = $('#parte_caja').val(); 	
			     var fecha_caja = $('#fecha_caja').val(); 	
 				 var enlace = '../reportes/Resumen_detalle_caja?id=' + id_reforma + '&f1=' + fecha_caja;
     
				 window.open(enlace,'#','width=750,height=480,left=30,top=20');
	  			
		});
	     
	    
 
      
	    var j = jQuery.noConflict();
 
		j("#printButton").click(function(){

				 var id_reforma = $('#parte_caja').val(); 	
			     var fecha_caja = $('#fecha_caja').val(); 	
 				 var enlace = '../reportes/Resumen_conta_caja?id=' + id_reforma + '&f1=' + fecha_caja;
     
				 window.open(enlace,'#','width=750,height=480,left=30,top=20');


			});
		  
		fecha_hoy();
 
   
});  


//------------------------------------------------------------------------- 
function TipoComprobante(odata){   
	
	var opcion_seleccionada = $("#tipofacturaf option:selected").text();
 	
  	$("#ViewComprobante").html('<H5><b>COMPROBANTE: ' + opcion_seleccionada + '</b></H5>');
  	
}
 

//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
				 
					 
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
//--------
function AgregarEspecie(   ) {
	
	
		/* cuenta_uno partida_uno cuenta_dos monto
	 
	 parte_caja fecha_caja*/

 
	 
 	   
	   	 var especie_valor     =  $("#especie_valor").val();
	  	 var monto             =  $("#monto_especie").val();
	  	 
	  	 var fecha_caja         =  $("#fecha_caja").val();
	  	 var parte_caja         =  $("#parte_caja").val();
	  	
	 
	    var parametros = {
 	 				'especie_valor' : especie_valor,  
 					'monto':monto,
					'fecha_caja':fecha_caja,
					'parte_caja':parte_caja
 	    };
		    
	    if ( monto > 0 ){
	    	if (fecha_caja){
					$.ajax({
						    url:  '../model/Model_contabiliza_manual_especie.php' ,
				 			data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#ContabilizadoVentas").html('Procesando');
								},
							success:  function (data) {
									 $("#MensajeParametro").html(data);  // $("#cuenta").html(response);
								     
									  	$("#especie_valor").val('');
 									  	$("#monto_especie").val('0.00');
									  	 
									 goToURL( 1);
								} 
					});
	    	  }
	    }

  }
// ir a la opcion de editar
function goToURL( id ) {
 
	 
	 
   	
  	var tipo_tran      = $("tipo_tran").val();
  	var parte_caja     = $("#parte_caja").val();
  	var fecha_caja     = $("#fecha_caja").val();
  	
   	
   	
   	

    if ( id == 1){
       
    	var parametros = {
				'tipo_tran' : tipo_tran,
  				'fecha_caja' : fecha_caja,  
  				'parte_caja': parte_caja
        };
	    
		$.ajax({
		    url:  '../model/Model-ManualIngresos.php' ,
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewForm").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewForm").html(data);  // $("#cuenta").html(response);
					} 
		});
    }

    if ( id == 5){
		 
    	Contabilizar(parte_caja,fecha_caja);
    	
    }
}
///----------------------------
function goToURLDel( parte,id ) {
 
	 
alertify.confirm("<p>Desea anular y revertir el asiento generado de ingresos..."+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	 
                var parametros = {
				'id' : id,
  				'parte' : parte
        };
	    
		$.ajax({
		    url:  '../model/ajax_ren_enlace_servicios.php' ,
 			data:  parametros,
			type:  'GET' ,
 			success:  function (data) {
					 alert('Dato actualizado... revise y actualice pantalla...'+ data);
					} 
			});
				 
					 
			  }
			 }); 
	  
}
//---------
function goToURver( tipo , id) {
	 
	 
    var parametros = {
  				'tipo' : tipo,  
  				'id':id
     };
	    
		$.ajax({
			    url:  '../model/ajax_manual_del.php' ,
	 			data:  parametros,
				type:  'GET' ,
					beforeSend: function () { 
							$("#ContabilizadoVentas").html('Procesando');
					},
				success:  function (data) {
						 $("#ContabilizadoVentas").html(data);  // $("#cuenta").html(response);
						 goToURL( 1);
					} 
		});
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
      
    
    
    
    $("#fecha_caja").val(today);
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 
 
	  
   	var fecha1     = $("#fecha1").val();
  	var fecha2     = $("#fecha2").val();
   	
    
    var parametros = {
  				'fecha1' : fecha1,
				'fecha2' : fecha2
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		 	console.log(s); 
			oTable.fnClearTable();
			if(s ){ 
					for(var i = 0; i < s.length; i++) {
						 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
								s[i][3],
  								'<p align="right">' +  formatNumber.new(s[i][4], "") + '</p>' ,
								'<p align="right">' +  formatNumber.new(s[i][5], "") + '</p>' ,
								'<button class="btn btn-xs" onClick="javascript:goToURL_dato('+"'" + s[i][0] +"'," +"'"  + s[i][1] +"'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' +
								'<button class="btn btn-xs" onClick="goToURLDel('+ "'"+ s[i][0]+"',"+s[i][3] +')"><i class="glyphicon glyphicon-remove"></i></button>' 

  						]);										
					} // End For
			} 					
			} 
	 	});
 		
  }   
//--------------

function goToURL_dato( parte_caja ,fecha_caja) {
 
	 
	 
   	
  	var tipo_tran      = $("tipo_tran").val();
 

	var tipo_tran      = $("tipo_tran").val();
  
    $("#parte_caja").val(parte_caja);
  	$("#fecha_caja").val(fecha_caja);
       
    	var parametros = {
				'tipo_tran' : tipo_tran,
  				'fecha_caja' : fecha_caja,  
  				'parte_caja': parte_caja
        };
	    
		$.ajax({
		    url:  '../model/Model-ManualIngresos.php' ,
 			data:  parametros,
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewForm").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewForm").html(data);  // $("#cuenta").html(response);
					} 
		});
 

	$('#mytabs a[href="#tab2"]').tab('show');

     
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
 function modulo()
 {
 	 var modulo1 =  'kservicios';
 	 
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
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 
	 
	 $("#ViewFormControl").load('../controller/Controller-inv_ventas_dato.php');
	 
	 $("#ViewFormEspecie").load('../controller/Controller-inv_ventas_especie.php');
	 


 }
//------------------------------------------------
//----------------------
 function Contabilizar(parte_caja,fecha_caja)
 {
  
 	   
	    var parametros = {
 	 				'parte_caja' : parte_caja,  
					'fecha_caja' : fecha_caja 
 	    };
		    

	 	alertify.confirm("Desea generar el asiento contable de este parte de caja?", function (e) {
			  if (e) {
				 
			  		$.ajax({
				    url:  '../model/Model-ContaVentasManual.php' ,
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#ContabilizadoVentas").html('Procesando');
						},
					success:  function (data) {
							 $("#ContabilizadoVentas").html(data);  // $("#cuenta").html(response);
						     
						} 
			});
		  }
	}); 
	 
} 
//-----------------;
 function busca_cuenta(cuenta,tipo) {
	   
	 var parametros = {
				 'cuenta'  : cuenta ,
				 'tipo': tipo
	  };
		 
	 if ( tipo == '1'){
		 $.ajax({
			 data:  parametros,
			 url: "../model/ajax_cuenta_lista_grupo.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#partida_uno').html(response);
	       }
		 });
	 }
	 
	 if ( tipo == '2'){
		 $.ajax({
			 data:  parametros,
			 url: "../model/ajax_cuenta_lista_grupo.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#cuenta_dos').html(response);
	       }
		 });
	 }
	 	 
	 
		 
 }
 //----------
 function Agregar_datos()
 {
  
	/* cuenta_uno partida_uno cuenta_dos monto
	 
	 parte_caja fecha_caja*/
	 
 	  	var cuenta_uno     =  $("#cuenta_uno").val();
	  	var partida_uno     = $("#partida_uno").val();
	  	var cuenta_dos     =  $("#cuenta_dos").val();
	  	 var monto         =  $("#monto").val();
	  	 
	  	 var fecha_caja         =  $("#fecha_caja").val();
	  	 var parte_caja         =  $("#parte_caja").val();
	  	
	 
	    var parametros = {
 	 				'cuenta_uno' : cuenta_uno,  
					'partida_uno' : partida_uno,  
					'cuenta_dos': cuenta_dos,
					'monto':monto,
					'fecha_caja':fecha_caja,
					'parte_caja':parte_caja
 	    };
		    
	    if ( monto > 0 ){
	    	if (fecha_caja){
					$.ajax({
						    url:  '../model/Model_contabiliza_manual.php' ,
				 			data:  parametros,
							type:  'GET' ,
								beforeSend: function () { 
										$("#ContabilizadoVentas").html('Procesando');
								},
							success:  function (data) {
									 $("#ContabilizadoVentas").html(data);  // $("#cuenta").html(response);
								     
									  	$("#cuenta_uno").val('');
									  	$("#partida_uno").val('');
									  	$("#cuenta_dos").val('');
									  	$("#monto").val('0.00');
									  	 
									 goToURL( 1);
								} 
					});
	    	  }
	    }

 } 
 //--------------
 function AgregarTramite()
 {
  
	 var fecha_caja         =  $("#fecha_caja").val();
	  	 var parte_caja         =  $("#parte_caja").val();
	  	var id_tramite     = $("#id_tramite").val();
 	 
	    var parametros = {
 	 				'fecha_caja' : fecha_caja,  
					'parte_caja' : parte_caja,  
					'id_tramite': id_tramite
 	    };
		    
			$.ajax({
				    url:  '../model/Model-ContaVentasTramite.php' ,
		 			data:  parametros,
					type:  'GET' ,
						beforeSend: function () { 
								$("#MensajeParametro1").html('Procesando');
						},
					success:  function (data) {
							 $("#MensajeParametro1").html(data);  // $("#cuenta").html(response);
						     goToURL( 1 );
						} 
			});
	 

 } 
