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
	 		   
	            BusquedaGrilla(oTable,1);

				diario_contabilizacion();
	  			
		});
	 

		$('#loadp').on('click',function(){
	 		   
			BusquedaGrilla(oTable,2);

			diario_contabilizacion();
			  
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



function impresion(id_asiento)

	{

  	 
  	 var enlace= '../../kcontabilidad/reportes/ficherocomprobante?a=';
  	 
	  enlace = enlace +id_asiento;

											   
   window.open(enlace,'#','width=750,height=480,left=30,top=20');

 	 

	}	

 
function diario_contabilizacion()
{
 

 
	  
	$.ajax({
 			 url:   '../model/ajax_diario_registro.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewForm").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewForm").html(data);   
				     
				} 
	});

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
 
	 
	 
 
   	var fecha_caja     = $("#fecha_caja").val();
 

    if ( id == 1){
       
    	var parametros = {
   				'fecha_caja' : fecha_caja,  
         };
	    
		$.ajax({
		    url:  '../model/Model-ManualIngresos01.php' ,
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

    if ( id == 5){
		 
    	Contabilizar(fecha_caja);
    	
    }
}
//--
// ir a la opcion de editar
function goToURLEspecie( id ) {
 
	 
	var url =  '../model/Model-ManualIngresos02.php' ;

	if ( id == 11)  {
		url =  '../model/Model-Contabilizar_especie.php' ;
	}
 
	var fecha_caja     = $("#fecha_cajae").val();
 
	 var parametros = {
				'id' : id,
				'fecha_caja' : fecha_caja
	  };
	 
	 $.ajax({
		  url:  url ,
		  data:  parametros,
		  type:  'GET' ,
			 beforeSend: function () { 
					 $("#ViewForme").html('Procesando');
			 },
		 success:  function (data) {
				  $("#ViewForme").html(data);  // $("#cuenta").html(response);
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
      
    
	$("#fecha_cajae").val(today);
    $("#fecha_caja").val(today);
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable,tipo){        	 
 
	  
   	var fecha1     = $("#fecha1").val();
  	var fecha2     = $("#fecha2").val();
   	
    
    var parametros = {
  				'fecha1' : fecha1,
				'fecha2' : fecha2,
				'tipo' : tipo
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
   								'<span align="right">' +  formatNumber.new(s[i][3], "") + '</span>' ,
								'<span align="right">' +  formatNumber.new(s[i][4], "") + '</span>' ,
								'<span align="right">' +  formatNumber.new(s[i][5], "") + '</span>' ,
								'<span align="right">' +  formatNumber.new(s[i][6], "") + '</span>' ,
								'<span align="right">' +  formatNumber.new(s[i][7], "") + '</span>' ,
								s[i][8],
								s[i][9],
								s[i][10] 
   						]);										
					} // End For
			} 					
			} 
	 	});
 		
  }   
//--------------
 
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
	 
	 
 	 
	 $("#ViewFormEspecie").load('../controller/Controller-inv_ventas_especie.php');
	 


 }
//------------------------------------------------
//----------------------
 function Contabilizar( fecha_caja)
 {

	

	var tipo_asi = $("#tipo_asi").val();
  
			var parametros = {
				'fecha'  : fecha_caja ,
				'cajero' : 'emision' ,
				'parte'  : '001',
				'tipo_asi': tipo_asi
		};



		alertify.confirm("Desea realizar la contabilización del dia: " + fecha_caja, function (e) {
		if (e) {


				$.ajax({
					data:  parametros,
					url:   '../model/Model-Contabilizar_proceso01.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#data").html('Procesando');
					},
					success:  function (data) {
							$("#data").html(data);   
							
					} 
			}); 

			diario_contabilizacion();
		
			goToURL( 1 );
		}
		}); 
			
} 
 