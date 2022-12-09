var oTable;

var formulario = 'ven_potencia';

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
                    
              	  $("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
              	  
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
	
	$("#idprov").val("-");
	$("#razon").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#correo").val("");
	
	$("#movil").val("593");
	$("#contacto").val("");
	$("#estado").val("");
 	$("#canton").val("");

 	$("#web").val("www.");
	$("#proceso").val("");
	$("#medio").val("");
 	$("#id_campana").val("");
 	
 	
    }
function abrirGoogle()
{
   

	 	var idprov = $("#idprov").val();
	 	 
	 	window.open('https://www.google.com.ec/search?q='+idprov,'_blank');
     

}  
 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#idvencliente").val(id);
 
	   BusquedaGrilla(oTable);

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
 function BuscaCanton(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCanton.php",
		 type: "GET",
        success: function(response)
        {
            $('#vcanton').html(response);
        }
	 });
      
 } 
 ///--
 function BuscaCantond(cprov)
 {
    
	 var parametros = {
			 'cprov'  : cprov  
   };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_buscaCantonUser.php",
		 type: "GET",
        success: function(response)
        {
            $('#canton').html(response);
        }
	 });
      
 }  
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

   	var vid_campana = $("#vid_campana").val();
 	var vsector     = $("#vsector").val();
 	var vestado     = $("#vestado").val();
 	var vmedio      = $("#vmedio").val();
 
 	
 	 
    var parametros = {
 				'vid_campana' : vid_campana,
				'vsector': vsector,
				'vestado': vestado,
				'vmedio' : vmedio
    };
 
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_'+formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			if(s){
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
						s[i][4],
   					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
				]);										
			} // End For
			} 						
			} 
	 	});
 
 
		
  }   
//--------------
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
 //---------------------------
 function open_gmail() {
	 
	 var enlace ='../view/gnail';
	 
	 var ancho = '550';
	 var alto  = '450';
	 
     var posicion_x; 
     var posicion_y; 
     
     posicion_x=(screen.width/2)-(ancho/2); 
     posicion_y=(screen.height/2)-(alto/2); 
      
     
     window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}

//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-' + formulario);
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-'+formulario+'_filtro.php');
	 

 }

    
  