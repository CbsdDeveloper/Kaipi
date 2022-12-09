var oTable;
var oTableCliente;
var formulario = 'ven_asignar';


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
 
	    
	    $.ajax({
	 		 url: "../model/Model_lista_Asigna.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#ViewFormGrupo').html(response);
	       }
		 });
 
	    
	    
	    $.ajax({
	 		 url: "../model/Model_lista_CampanaQuery.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#ViewFormCampana').html(response);
	       }
		 });
 
	    
	    
 
	 	   
	 	   $('#loadCliente').on('click',function(){
	 		   
	 		  GenerarContactos();
	  			
			});
 
 	    //-----------------------------------------------------------------
  
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
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
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
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
// visorr 
function ListaContactos() {

	 $.ajax({
 		 url: "../model/Model_lista_Asigna.php",
		 type: "GET",
       success: function(response)
       {
           $('#ViewFormGrupo').html(response);
       }
	 });

    }
//---------------
//----
function GenerarContactos(  ) {
	
     var idsuario_recibe = $("#idusuario_para").val();
	 
     var actual = $("#nro_actual").val();
     
     var nuevo = $("#numero").val();
	 
     var porcentaje =    parseFloat(nuevo) /  parseFloat(actual);  
     
     var p1 = porcentaje * 100;
     
     if ( idsuario_recibe > 0 ){
    	 
    	 if( parseInt(nuevo) > parseInt(actual)){
    		 alert('Numero mayor para realizar la asignacion');
    	 }
    	 else {
    		 if( nuevo == 0){
    			 alert('Ingrese numero de contactos para asignar');
    		 }else{
    			 if (parseInt(p1) > 60){
    				 alert('No puede generar mas del 60% de contactos');
    			 }else{
    				 //------------------
    				 CreaContactos(idsuario_recibe,actual,nuevo);
    				 //-------------------------
    				 $("#numero").val('');
    				 $("#idusuario_para").val('');
    			 
    				 ListaContactos() ;
    			 }
    		 }
    	 }
    	 
     }
     else {
    	 alert('Seleccione usuario para generar la informacion');
     }
	 
	 
	
}
//----
function CreaContactos(idsuario_recibe,actual,nuevo)  {

	var idusuario_actual = $("#idusuario_temp").val();
	 
	 
	var parametros = {
                     'idusuario_actual' : idusuario_actual, 
                     'idsuario_recibe' :idsuario_recibe,
                     'actual' : actual,
                     'nuevo': nuevo
 	  };
	
	 $.ajax({
		 type : 'GET',
		 data:  parametros,
		 url:   '../model/Model_lista_asigna_user.php',
		 success:  function (response) {
					 $("#Asignarcta").html(response);
			 }

	});
	 
 
    }
//-----------------------------
function CargaCampana( id) {

	var parametros = {
                     'id' : id 
 	  };
	
	 $.ajax({
		 type : 'GET',
		 data:  parametros,
		 url:   '../model/Model_lista_Campana.php',
		 success:  function (response) {
					 $("#ViewFormCampana").html(response);
			 }

	});
	 
 
    }
//--------------
function CampanaLista( id) {

	$("#id_campana_temp").val( id );
	
    $('#mytabs a[href="#tab2"]').tab('show');
    
  
    }
 //-------------------------------------------------------------------------
//ir a la opcion de editar
function goToURLClientes(accion,id) {

	var parametros = {
					'accion' : accion ,
                 'id' : id 
	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-'+ formulario,
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
	
	$("#idprov").val("");
	$("#razon").val(" ");
	$("#direccion").val(" ");
	$("#telefono").val("");
		$("#correo").val(" "); 
		$("#movil").val(" "); 
		$("#tipo").val(" ");   
	  
    	$("#idciudad").val("");
		$("#contacto").val("");
		$("#ctelefono").val("");
		$("#cmovil").val("");
	  
		$("#ccorreo").val("");
		$("#estado").val("");
		$("#tpidprov").val("");
		$("#naturaleza").val("");
    }
   
 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#idvencliente").val(id);
 
	$('#myModal').modal('hide')

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
///----------------
 function AsignaLista(idprov,usuario,nro_actual)
 {
	 
 
	 
	 $("#usuario").val(usuario);
	 
	 $("#nro_actual").val(nro_actual);
	 
	 $("#idusuario_temp").val(idprov);
	 
	 $("#numero").val(0);
	 
	 var parametros = {
              'id' : idprov 
     } ;
	 
	 if ( nro_actual > 0 ) {
		 
		 $.ajax({
			 data:  parametros,
	 		 url: "../model/Model_lista_GrupoUser.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#idusuario_para').html(response);
	       }
		 });
	 } 
	 
	 $("#Asignarcta").html('');
 } 
 ///--
  
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

   	var vestado = $("#qestado").val();
   	
      var parametros = {
 				'vestado': vestado
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ven_clientesSesion.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTable.fnClearTable();
					if (s){
								for(var i = 0; i < s.length; i++) {
									 oTable.fnAddData([
											s[i][0],
											s[i][1],
											s[i][2],
											s[i][3],
											s[i][4]
										 
									]);										
								} // End For
					} 				
			} 
	 	});
 
  }   
//--------------
  //------------------------------------------------------------------------- 
  function BusquedaGrillaCliente(oTableCliente){        	 

   	var vprovincia = $("#vprovincia").val();
   	
 	var vcanton = $("#vcanton").val();
 
    
    var parametros = {
 				'vprovincia' : vprovincia,
				'vcanton': vcanton
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ven_inicioCliente.php',
			dataType: 'json',
			cache: false,
			success: function(s){
			console.log(s); 
			oTableCliente.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
				oTableCliente.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
					'<button class="btn btn-xs" onClick="javascript:goToURLClientes('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
				]);										
			} // End For
	 							
			} 
	 	});
 
  }     
  //------------------------------------------------------------------------- 
 
 
 
 function modulo()
 {
 	 var modulo =  'kventas';
 	 
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
 function FormFiltro()
 {
  
	 $("#ViewForAsigna").load('../controller/Controller-' + formulario+'_asigna');
	 

 }
//-----------------
 function abrirGoogle()
 {
    

	 	var idprov = $("#idprov").val();
	 	 
	 	window.open('https://www.google.com.ec/search?q='+idprov,'_blank');
      

 }
    
  