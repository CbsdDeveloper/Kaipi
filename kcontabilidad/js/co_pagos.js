$(function(){
      
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
 
});
var oTableGrid;  
var oTable ;
//-------------------------------------------------------------------------$(document).ready(function(){
    
        oTable = $('#jsontable').dataTable(); 
       
       oTableGrid = $('#ViewCuentas').dataTable();  
       
       
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
 
 		
	   $('#load').on('click',function(){
 		   
            BusquedaGrilla(oTable);
  			
		});
 
 
 //-----------------------------------------------------------------

});  
//-----------------------------------------------------------------
 
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
                    accion(0,'');
                    
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
					'accion' : accion ,                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-co_pagos.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  
						     
  					} 
			}); 
     }
//-------------------------------------------------------------------------
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
//ir a la opcion de editar
function validaPantalla() {

	var valida = 1;
	 
	if ( ! $("#tipo").val()  ) { valida = 0 ; }  
	
	if ( ! $("#retencion").val()  ) { valida = 0 ; }  
	  
	if ( ! $("#cheque").val()  ) { valida = 0 ; }   
 
 
	 return valida;

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
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

 
		var user = $(this).attr('id');
    
	  var ffecha1 = $("#ffecha1").val();
	  var ffecha2 = $("#ffecha2").val();
	  var festado = $("#festado").val();
	  var fidbancos = $("#idbancos").val();
 
 
      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'festado' : festado  ,
				'idbancos' : fidbancos  
      };

 
		
		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_pagos.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			
			if (s){
			
					for(var i = 0; i < s.length; i++) {
						  oTable.fnAddData([
		                      s[i][0],
		                      s[i][1],
		                      s[i][2],
		                      s[i][3],
		                      s[i][4],		                      s[i][5],		                      		                      s[i][6],
		                      '<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][7] +')"><i class="	glyphicon glyphicon-ok"></i></button> '  
		                  ]);									
					} // End For
									
			}
			
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
  }   
 
 
//------------------------------------------------------------------------- 
 function modulo()
 {
 	 var modulo1 =  'kcontabilidad';
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
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-co_pagos.php');
      

 }
 //--------------------------------
 function GuardarCosto( )
 {
 	 
	 
	var	idasientodetCosto     =  $("#idasientodetCosto").val( );
	
	 
	var codigo1      =	$("#codigo1").val( );
	var codigo2      =	$("#codigo2").val( );
	var codigo3      =	$("#codigo3").val( );
	var codigo4      =	$("#codigo4").val( );
 	 	 
 		 
 			 	 var parametros = {
						    'idasientodetCosto' : idasientodetCosto ,
						    'codigo1' : codigo1 ,
						    'codigo2' : codigo2 ,
						    'codigo3' : codigo3 ,
						    'codigo4' : codigo4 
 			    };
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosCosto.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarCosto").html('Procesando');
							},
						success:  function (data) {
								 $("#guardarCosto").html(data);   
							     
							} 
				});
 	  
 
 }
//------------------------------------------------------------------------- 

 //----------------------
 function ViewDetAuxiliar(codigoAux)
 {
 	 
 
 	 var parametros = {
			    'codigoAux' : codigoAux 
    };
 	 
 	$.ajax({
			data:  parametros,
			 url:   '../controller/Controller-co_asientos_aux.php',
			type:  'GET' ,
			cache: false,
			beforeSend: function () { 
						$("#ViewFiltroAux").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltroAux").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
 
 } 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-co_pagos_filtro.php');
	 
 }
 //------------------------------------------------------------------------- 
 function GuardarAuxiliar()
 {
 	 
    var valida = validaPantalla();
	 
	var	id_asiento     =  $("#id_asiento").val( );
	var codigodet      =	$("#codigodet").val( );
	var idprov         =	$("#idprov").val( );
 	 
	 if (valida ==0 ){
		 
 			 	 var parametros = {
						    'id_asiento' : id_asiento ,
						    'codigodet' : codigodet ,
						    'idprov' : idprov 
 			    };
			 	 
			 	$.ajax({
						data:  parametros,
						url:   '../model/Model-co_asientosaux.php',
						type:  'GET' ,
						cache: false,
						beforeSend: function () { 
									$("#guardarAux").html('Procesando');
							},
						success:  function (data) {
								 $("#guardarAux").html(data);   
							     
							} 
				});
 	 }else{
		 alert('Ingrese la informacion del beneficiario');
	 }

 }
//----------------------
 function accion(id,modo,comprobante)
 {
  
	  if (modo == 'procesado'){
			$("#action").val('aprobado');
			$("#comprobante").val(comprobante);       
			$("#pago").val('S');     
	 }else{
			$("#action").val(modo);
			         
 	 }
	 
	  if (comprobante){
		//  alert('Transacción procesada con exito' + comprobante);
	  }
	
 		 
	 BusquedaGrilla(oTable);

 }
//------------------------------------------------------------------------- 
function aprobacion( ){
     	$("#action").val( 'aprobacion');
    var pagado = $("#pago").val();     
    if (pagado == 'N'){
			var	id_asiento    =   $("#id_asiento").val( ); 
			var mensaje = 'Desea generar el comprobante del asiento:  ' + id_asiento;			alert(mensaje);			
			 
    }
    
     
	}
 
 