"use strict"; 

var oTable;
//-------------------------------------------------------------------------
$(document).ready(function(){
    
	$("#MHeader").load('../view/View-HeaderModel.php');
	
	modulo();
 
	
	FormView();
    
	$("#FormPie").load('../view/View-pie.php');
 
    oTable = $('#jsontable').dataTable(); 
        
    Busqueda();
       
 
	         
});  
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					 
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
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToURL(accion,id) {
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-categoria.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
                             DetalleAsiento();    
  					} 
			}); 

}
//-----------------     
function go_modal(id) {
 
	
     var parametros = {
					'action_variable' : 'visor' ,
                    'idcategoriavar' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-categoria_variable.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#GuardaVariable").html('Procesando');
  					},
					success:  function (data) {
							 $("#GuardaVariable").html(data);  // $("#cuenta").html(response);
						     
                            
  					} 
			}); 

}
//-----------------------------------------
function accion(id,modo)
{
  
			$("#action").val(modo);
			
			$("#idcategoria").val(id);          

		//	BusquedaGrilla(oTable );
			
			DetalleAsiento();

}
///----------------------------------
function accion_variable(id,modo)
{
  
			$("#action_variable").val(modo);
			
			$("#idcategoriavar").val(id);          

			DetalleAsiento() ; 

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
  
 
	$("#idcategoria").val(0);
	$("#nombre").val("");
	$("#referencia").val("");
	$("#tipo_categoria").val("");
	
	
       			   
    }
   
 //-----------------------------
function LimpiarVariable ( ) {
	
	
	 $("#nombre_variable").val('');
 	 $("#imprime").val('');      
 	 
 	 $("#tipo").val('');
 	 $("#lista").val('-');    
	   
	 $("#action_variable").val('add');   
	 $("#idcategoriavar").val('');   
	 
	 $("#tipo_dato").val('-');   
	 
	 
	 
	 $("#GuardaVariable").html('');      
      
       
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
  function Busqueda(){        
  
	  
	  var ftipo = $("#ftipo").val();

	 
      var parametros = {
 				'ftipo' : ftipo   
      };

       $.ajax({
			    url: '../grilla/grilla_categoria.php',
				data:  parametros,
				dataType: 'json',
				success: function(s){
		
						oTable.fnClearTable();
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
								s[i][3],
                                	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
				     }
	 	});
     
 }   
 ///////////////////////////////////
function modulo()
{
 

	 var modulo1 =  'kadmin';
		 
	 var parametros = {
	 
			    'ViewModulo' : modulo1 
     };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php?',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewModulo").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewModulo").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}
//--------------------------
function checkTextarea(idText) {
	
	 var comentarios = document.getElementById(idText).value; 
 	 
	  if (!comentarios) {
		  alert("Error: Ingrese informacion");
	    return false;
	  }
	  
	  return true;
	 
}
//-----------------------

function GuardarVariable()
{
 
	 
	
	//if( !checkTextarea('nombre_variable')) {
		
			   var variable 	=  $("#nombre_variable").val();
			   var idcategoria	=  $("#idcategoria").val();      
			   var imprime		=  $("#imprime").val();    
			   var action_variable		=  $("#action_variable").val();      
			   var idcategoriavar		=  $("#idcategoriavar").val();      
 
			   var tipo  = $("#tipo").val();
			   var lista = $("#lista").val();    
			   var tipo_dato = $("#tipo_dato").val();    
			   
 
			   
			   var parametros = {
					 
							    'variable' : variable ,
							    'idcategoria' : idcategoria ,
							    'imprime' : imprime ,
							    'tipo': tipo,
							    'lista' : lista,
							    'idcategoriavar' : idcategoriavar,
							    'action_variable' : action_variable,
							    'tipo_dato' : tipo_dato
				     };
			 
 							
								$.ajax({
										data:  parametros,
										 url:   '../model/Model-categoria_variable.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#GuardaVariable").html(data);   
											     
											} 
								});
			 
					 
//	}
	
	


}
//--- EliminarVariable
function EliminarVariable()
{
  		   var action_variable		=  'del';      
			   var idcategoriavar		=  $("#idcategoriavar").val();      
 
		 
			   var parametros = {
							    'idcategoriavar' : idcategoriavar,
							    'action_variable' : action_variable
				     };
			 
 							
								$.ajax({
										data:  parametros,
										 url:   '../model/Model-categoria_variable.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#GuardaVariable").html(data);   
											     
											} 
								});
 
}
//-----------------
function FormView()
{
  	 
	 $("#ViewForm").load('../controller/Controller-categoria.php');
	 
     $("#VisorVariable").load('../controller/Controller-categoria_variable.php');
 
     $("#ViewFiltro").load('../controller/Controller-categoria_filtro.php');
     
     

}
///--------------------------------------------------
function DetalleAsiento()
{


    var idcategoria = $('#idcategoria').val(); 

    var parametros = {

			    'idcategoria' : idcategoria 
      };

	  

	$.ajax({

			data:  parametros,

			 url:   '../model/ajax_categoria_var.php',

			type:  'GET' ,

			cache: false,

			beforeSend: function () { 

						$("#DivAsientosTareas").html('Procesando');

				},

			success:  function (data) {

					 $("#DivAsientosTareas").html(data);   

				  

				} 

	});



	

}


  
