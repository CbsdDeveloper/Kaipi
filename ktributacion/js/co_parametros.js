$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
       var oTable = $('#jsontable').dataTable(); 
	
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
				 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
                	
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
					url:   '../model/Model-co_parametros.php',
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
//------------------------------
function accion(id,modo)
{
 
  
			$("#action").val(modo);
			
			$("#secuencia").val(id);          

		 
}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
       			   
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
    
    document.getElementById('fechatarea').value = today ;
    
    document.getElementById('fechafinal').value = today ;
    
    $("#tarea").val("");
	
    $("#tareaproducto").val("");
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
	  
	  
		var user = $(this).attr('id');
		
     	var GrillaCodigo = $("#tipobusqueda").val();
     	
     	var var_activo = $("#var_activo").val();
     	
          
     	 
     	
      var parametros = {
				'GrillaCodigo' : GrillaCodigo ,
				'var_activo': var_activo
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_co_parametros.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		 	//console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
					s[i][0],
					s[i][1],
					'<input type="checkbox" id="myCheck'+ s[i][0] +'"   onclick="myFunction('+ s[i][0] +',this)" '+ s[i][2]  + '>',
					s[i][3],
					s[i][4],
					s[i][5],
					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
				]);										
			} // End For
							
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 
 function modulo()
 {
 	 var modulo =  'ktributacion';
 	 
 	 
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
 //--------------
 
 function myFunction(codigo,objeto)
 {
  
	   var accion = 'check';
	   var estado = '';
	   
	    if (objeto.checked == true){
	    	estado = 'S'
	        
	    } else {
	    	estado = 'N'
	    }
	    
	    var parametros = {
				'accion' : accion ,
                'id' : codigo ,
                'estado':estado
	  };
	    
      $.ajax({
				data:  parametros,
				url:   '../model/Model-co_parametros.php',
				type:  'GET' ,
				cache: false,
				beforeSend: function () { 
							$("#mensajeEstado").html('Procesando');
					},
				success:  function (data) {
						 $("#mensajeEstado").html(data);   
					     
					} 
		}); 
  

 }
 
 
 
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-co_parametros.php');
      

 }
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-co_parametros_filtro.php');
	 

 }

    
  