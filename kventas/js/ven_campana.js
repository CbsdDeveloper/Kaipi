var oTable;

var formulario = 'ven_campana';


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
	    
	    Campana_seg();
	    
	    
	    $('#load').on('click',function(){
	 		 
	           BusquedaGrilla(oTable);
	           
	           Campana_seg();
	           
	 		});
	         
 	    
 	    
	  
	 
 	   $.ajax({
 	 		 url: "../model/Model_lista_Zona.php",
 			 type: "GET",
 	       success: function(response)
 	       {
 	           $('#qzona').html(response);
 	       }
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
						     
							 SegContactos();
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
	
	
	$("#id_campana").val("");
	$("#fecha").val(fecha_hoy());
	$("#fecha_cierre").val(fecha_hoy());
	
	$("#medio").val("");
	$("#publica").val("");
	$("#titulo").val("");
	$("#idresponsable").val("");
	$("#idvengrupo").val("");

	
    }
   
 
 //---------------------------
function accion(id,modo,estado)
{
 
	 
	$("#action").val(modo);
	
	$("#id_campana").val(id);
 
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
 
    return today;
            
} 
///----------------
 function ListaGrupo(idvengrupo){        
	 	  
   var parametros = {
                    'idvengrupo' : idvengrupo 
 	  };
   
   
	 $.ajax({
			data:  parametros,
 		 url: "../model/Model_lista_User.php",
		 type: "GET",
       success: function(response)
       {
           $('#idresponsable').html(response);
       }
	 });
	 
 }
 //------------------------- ContactosCampana
 function SegContactos(){        
	  
	 
	var id =  $("#id_campana").val();
	 
	 
	 var parametros = {
              'id' : id 
      };
	 
    $.ajax({
				data:  parametros,
				url:   '../model/Model_lista_CampanaSeg.php',
				type:  'GET' ,
				cache: false,
 				success:  function (data) {
						 $("#ContactosCampana").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 

		 
	 }
 //------------------------- ContactosCampana
 function Campana_seg(){        
	  
  	 
	 
	 var parametros = {
              'id' : 1 
      };
	 
    $.ajax({
				data:  parametros,
				url:   '../model/Model_lista_CampanaTot.php',
				type:  'GET' ,
				cache: false,
 				success:  function (data) {
						 $("#TotalCampana").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 

		 
	 }
 //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	   
	  var qmedio = $("#qmedio").val();
      var qzona  = $("#qzona").val();
      var qpublica = $("#qpublica").val();
	
	   var parametros = {
				'qmedio' : qmedio , 
                'qzona' : qzona  ,
                'qpublica' : qpublica  
      };
	  
 
	  
		$.ajax({
			data:  parametros,  
 		    url: '../grilla/grilla_'+ formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		// 	console.log(s); 
			oTable.fnClearTable();
			if(s){
				for(var i = 0; i < s.length; i++) {
					 oTable.fnAddData([
							s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
							s[i][4],
							s[i][5],
						 	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
							'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-' + formulario);
      

 }
 
//----------------------
 function FormFiltro()
 {
  
//	 $("#ViewFiltro").load('../controller/Controller-ven_potencia_filtro.php');
	 

 }

    
  