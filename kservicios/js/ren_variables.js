var oTable;
var oTable_matriz;
var oTable_matriz1;

$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
 		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
   
		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 6 ] },
			      { "sClass": "de", "aTargets": [ 2 ] },
			      { "sClass": "di", "aTargets": [ 7 ] }
			    ] 
	      } );  
		 
		oTable_matriz   = $('#jsontable_matriz').dataTable(); 
	    
		oTable_matriz1  = $('#jsontable_matriz1').dataTable(); 
 		
		 BusquedaGrilla(oTable,'0');
	 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable,'1');
           
 		});
	
	         
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
					url:   '../model/Model-ren_rubro.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
							 PoneCuenta( id );
							 
							 PoneMatriz( id );
  					} 
			}); 

    }
//----  
function goToURLCat(accion,id) {
	 
    $("#action_cata").val(accion);
    
    var parametros = {
			'accion' : accion ,
            'id' : id 
};
    
	$.ajax({
	    type:  'GET' ,
		data:  parametros,
		url:   '../model/Model-ren_variable_cat.php',
		dataType: "json",
			success:  function (response) {

				
				 $("#idcatalogo1").val( response.idcatalogo1 );  
				 $("#idcatalogo2").val( response.idcatalogo2 ); 
				 $("#idcatalogo3").val( response.idcatalogo3 ); 
				 $("#id_matriz_cat").val( response.id_matriz_cat ); 
				 $("#valor").val( response.valor ); 
				 $("#action_cata").val('guardar'); 
				 
				    
				 
		} 
});
	 
	  $("#myModalcatalogo").modal('show');
	
	
   }
//-----------------------
function goToURLCat1(accion,id) {
	 
    $("#action_cata1").val(accion);
    
    var parametros = {
			'accion' : accion ,
            'id' : id 
};
    
	$.ajax({
	    type:  'GET' ,
		data:  parametros,
		url:   '../model/Model-ren_variable_cat1.php',
		dataType: "json",
			success:  function (response) {

				
				 $("#valor1").val( response.valor1 );  
				 $("#valor2").val( response.valor2 ); 
				 $("#basico").val( response.basico ); 
				 $("#excendente").val( response.excendente ); 
				 
				 
				 $("#id_matriz_cat1").val( response.id_matriz_cat ); 
				 $("#valor0").val( response.valor ); 
				 $("#action_cata1").val('guardar'); 
				 
				    
				 
		} 
});
	 
	  $("#myModalcatalogo1").modal('show');
	
	
   }
//--------------------------------------------------
function go_matriz( id) {
	 
    $("#action_cab").val('editar');
	   
    var parametros = {
			'accion' : 'editar' ,
            'id' : id 
};
     
	$.ajax({
	    type:  'POST' ,
		data:  parametros,
		url:   '../model/Model-ren_variable_cab_cat.php',
		dataType: "json",
			success:  function (response) {

				
				 $("#id_matriz_var").val( response.id_matriz_var );  
				 $("#catalogo").val( response.catalogo ); 
 				 $("#action_cab").val('guardar'); 
				 
 				 $("#Guarda_datos_matriz").html(' '); 
 				    
				 
		} 
});
	 
 	
	
   }
//------------------------------------------------------------
function GuardarCabMatriz()
{
 
	   var id_rubro	     =  $("#id_rubro").val();      
       var id_matriz_var =  $("#id_matriz_var").val();    
       var accion 		 =  $("#action_cab").val();    
       var catalogo	     =  $("#catalogo").val();      
       var tipo_cat      =  $("#tipo_cat").val();     
       
       if ( catalogo ){
    	   
    	   if ( id_rubro > 0 ){
 
			   var parametros = {
					 
							    'catalogo' : catalogo ,
							    'accion' : accion,
							    'id_rubro' :id_rubro,
							    'id_matriz_var' : id_matriz_var,
							    'tipo_cat' : tipo_cat
 
				     };
 								$.ajax({
										data:  parametros,
										url:   '../model/Model-ren_variable_cab_cat.php',
										 type:  'POST'  ,
										 success:  function (data) {
												 $("#Guarda_datos_matriz").html(data);   
											     
											} 
								});
 								
 								PoneMatriz( id_rubro );	
    	   }					
       }
}
//--------------------------
function GuardarMatriz()
{
 
	   var id_rubro	    =  $("#id_rubro").val();      
       var id_matriz_var =  $("#id_matriz_var").val();   
       var id_matriz_cat =  $("#id_matriz_cat").val();   
       
       var idcatalogo1 =  $("#idcatalogo1").val();   
       var idcatalogo2 =  $("#idcatalogo2").val();   
       var idcatalogo3 =  $("#idcatalogo3").val();   
       
       var valor =  $("#valor").val();   
       
       var action_cata =  $("#action_cata").val();   
   	   
       if ( id_rubro ) {
    	   
    	   if ( id_matriz_var)  {
    		   
    		   if ( valor > 0 ) {
    		   
			   var parametros = {
					 
							    'idcatalogo1' : idcatalogo1 ,
							    'idcatalogo2' : idcatalogo2 ,
							    'idcatalogo3' : idcatalogo3 ,
							    'id_matriz_cat': id_matriz_cat,
							    'accion'       : action_cata,
							    'id_rubro'     :id_rubro,
							    'id_matriz_var' : id_matriz_var,
							    'valor' : valor
 
				     };
  							
								$.ajax({
										data:  parametros,
										url:   '../model/Model-ren_variable_cat.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#guardarCat").html(data);   
											     
												 VerMatriz(id_rubro,id_matriz_var);
											} 
								});
    	   }						
       }		
     }	 	   
 
}
///--------------------------------------
function GuardarMatriz1()
{
 
	   var id_rubro	    =  $("#id_rubro").val();      
       var id_matriz_var =  $("#id_matriz_var").val();   
       var id_matriz_cat =  $("#id_matriz_cat1").val();   
       
       var valor0 =  $("#valor0").val();   
       var valor1 =  $("#valor1").val();   
       var valor2 =  $("#valor2").val();   
       var basico =  $("#basico").val();   
       var excendente =  $("#excendente").val();   
        
        
       var action_cata =  $("#action_cata1").val();   
   	   
       if ( id_rubro ) {
    	   
    	   if ( id_matriz_var)  {
    		   
    		   if ( valor0 > 0 ) {
    		   
			   var parametros = {
					 
							    'valor1' : valor1 ,
							    'valor2' : valor2 ,
							    'basico' : basico ,
							    'excendente' : excendente,
							    'id_matriz_cat': id_matriz_cat,
							    'accion'       : action_cata,
							    'id_rubro'     :id_rubro,
							    'id_matriz_var' : id_matriz_var,
							    'valor' : valor0
 
				     };
  							
								$.ajax({
										data:  parametros,
										url:   '../model/Model-ren_variable_cat1.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#guardarCat1").html(data);   
											     
												  VerMatriz1(id_rubro,id_matriz_var);
											} 
								});
    	   }						
       }		
     }	 	   
 
}

function VerMatriz(id_rubro,id)
{
		var parametros = {
				'id_rubro' : id_rubro,  
				'id':id,
		};
		
		$.ajax({
		data:  parametros,
		url: '../grilla/grilla_ren_matriz_rubro.php',
		dataType: 'json',
		success: function(s){
				//console.log(s); 
			oTable_matriz.fnClearTable();
				if(s ){ 
					for(var i = 0; i < s.length; i++) {
						oTable_matriz.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
		                 s[i][3],
		                 s[i][4],
		              	'<button class="btn btn-xs" onClick="javascript:goToURLCat('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
					]);										
				} // End For
		  }						
		},
		error: function(e){
		   console.log(e.responseText);	
		}
		});
}
//----------------
function VerMatriz1(id_rubro,id)
{
		var parametros = {
				'id_rubro' : id_rubro,  
				'id':id,
		};
		
		$.ajax({
		data:  parametros,
		url: '../grilla/grilla_ren_matriz_rubro1.php',
		dataType: 'json',
		success: function(s){
				//console.log(s); 
			oTable_matriz1.fnClearTable();
				if(s ){ 
					for(var i = 0; i < s.length; i++) {
						oTable_matriz1.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
		                 s[i][3],
		                 s[i][4],
		                 s[i][5],
		              	'<button class="btn btn-xs" onClick="javascript:goToURLCat1('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
					]);										
				} // End For
		  }						
		},
		error: function(e){
		   console.log(e.responseText);	
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
  
 
               
	$("#id_rubro").val("");
	$("#estado").val("");
	$("#detalle").val("");
	$("#resolucion").val("");
   
	$("#modulo").val("");
                  
        			   
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
    
 
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable,tipo){        
 
            
	  var vmodulo = $("#vmodulo_q").val();
      
	   if ( tipo == '0'){
		   vmodulo = '-'; 
	   } 		   
		   
   
     var parametros = {
              'vmodulo' : vmodulo  
     };
 
			$.ajax({
				data:  parametros,  
 			    url: '../grilla/grilla_ren_variables.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								'<b>' + s[i][2] + '</b>',
       	                        s[i][3],
       	                        s[i][4],
       	                        s[i][5],
       	                        s[i][6],
       	                        s[i][7],
                               	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
		 
 }   
//-----------------
  function go_visor(id){        
	  
      
 	  	
 		var id_rubro	=  $("#id_rubro").val();      
 		
 		 $("#id_matriz_var").val( id );  
 		
 		 
 	    var parametros1 = {
 	   		'id' : id  
 	   		}; 

 	   		$.ajax({
 	   			data: parametros1,
 	   			url: "../model/ajax_ren_nombre_matriz.php",
 	   			type: "GET",
 	   		    dataType: "json",
 	   			success: function(response)
 	   			{
 	   			
 	   			 $("#nombre_matriz").html( response.a );  
				 
				 var  valida = response.b ;  
				 
				 if ( valida == 'S'){
 					 document.getElementById("boton_s1").disabled = false;
					 document.getElementById("boton_s2").disabled = true;
					 VerMatriz(id_rubro,id);
				 }else{
 					 document.getElementById("boton_s1").disabled = true;
					 document.getElementById("boton_s2").disabled = false;
					 VerMatriz1(id_rubro,id);
 				 }
				 
				
 	   				 
 	   			}
 	   		});
 		 
 		
 		 
	 
}   
//----------
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
        var id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

function modulo()
{
 

 var modulo1 =  'kservicios';
		 
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
//-----------------
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_variables.php');
     
     $("#VisorVariable").load('../controller/Controller-ren_variable_lista.php');
     
     $("#ViewCatalogo").load('../controller/Controller-ren_variable_cat.php');
 
     $("#ViewCabMatriz").load('../controller/Controller-ren_variable_cab.php');
     
     $("#ViewCatalogo1").load('../controller/Controller-ren_variable_cat1.php');
     
     
     
}
//----------------------
function FormFiltro()
{
	
 
	 
	 
	 
	 

}
//---
function accion_variable(id,modo)
{
  
	 		var id_rubro	=  $("#id_rubro").val();      
	 
			$("#action_variable").val(modo);
			
			$("#id_rubro_var").val(id);          

			PoneCuenta( id_rubro )

}


//------------------------
function PoneCuenta( id ) {
	 
 	
    var parametros = {
		'id' : id  
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_ren_variable.php",
			type: "GET",
			success: function(response)
			{
				$('#ViewFormDetalle').html(response);
			}
		});
 
		
}
//-------------.php
function PoneMatriz( id ) {
	 
 	
    var parametros = {
		'id' : id  
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_ren_ru_variable.php",
			type: "GET",
			success: function(response)
			{
				$('#ViewFormMatriz').html(response);
			}
		});
 
		
}
//--------------()
function LimpiarCatMatriz ( ) {
	
	
	 $("#action_cata").val('add');   
	 
 
     $("#id_matriz_cat").val('');   
     
     $("#idcatalogo1").val('');   
     $("#idcatalogo2").val('');   
     $("#idcatalogo3").val('');   
     $("#valor").val('');   
     $("#guardarCat").html('');   
     
     
 
}



function LimpiarCabMatriz ( ) {
	
 
	  
 
	$("#action_cab").val('add');   
	$("#id_matriz_var").val('');   
	$("#catalogo").val('');   
	$("#tipo_cat").val('');   

	
}

//----------------------------------
function LimpiarCatMatriz1 ( ) {
	
	 
	 $("#id_matriz_cat1").val('');
	 $("#action_cata1").val('add');   
	 
	   
	  var today = new Date();
	    var dd = today.getDate();
	    var mm = today.getMonth()+1; //January is 0!

	    var yyyy = today.getFullYear();
	 
       
	  
     $("#valor0").val(yyyy);   
     $("#valor1").val('0.00');   
     $("#valor2").val('0.00');   
     $("#basico").val('0.00');   
     $("#excendente").val('0.00');   
     $("#guardarCat1").html('0.00');   
 
	 
}

//-----------------------------
function LimpiarVariable ( ) {
	
	
	 $("#nombre_variable").val('');
 	 $("#imprime").val('');      
 	 
 	 $("#tipo").val('');
 	 $("#lista").val('-');    
	 $("#id_rubro_var").val('');   
	 $("#tipo_dato").val('-');   
 	 $("#GuardaVariable").html('');      
	 $("#action_variable").val('add');   
	 $("#relacion").val('-');    
	 $("#variable").val('-');   

	 $("#etiqueta").val('Formulario');   
	 $("#columna").val('1');   
	 

	  


}

function GuardarVariable()
{
 
	 
	
	//if( !checkTextarea('nombre_variable')) {
		
			   var variable 	=  $("#nombre_variable").val();
			   var id_rubro	    =  $("#id_rubro").val();      
			   var imprime		=  $("#imprime").val();    
			   var action_variable		=  $("#action_variable").val();      
			   var id_rubro_var		=  $("#id_rubro_var").val();      
 
			   var tipo  = $("#tipo").val();
			   var lista = $("#lista").val();    
			   var tipo_dato = $("#id_catalogo").val();    
			   var relacion = $("#relacion").val();    
			   var publica = $("#publica").val();


			   var etiqueta = $("#etiqueta").val();    
			   var columna = $("#columna").val();
			   var requerido = $("#requerido").val();
			   
			   
 
	
			  if ( variable) {
			   
			   var parametros = {
					 
							    'variable' : variable ,
							    'id_rubro' : id_rubro ,
							    'imprime' : imprime ,
							    'tipo': tipo,
							    'lista' : lista,
							    'id_rubro_var' : id_rubro_var,
							    'action_variable' : action_variable,
							    'id_catalogo' : tipo_dato,
							    'relacion' : relacion,
							    'publica' :publica		,
								'etiqueta':etiqueta,
								'columna':columna,
								'requerido' : requerido
				     };
			 
 							
								$.ajax({
										data:  parametros,
										 url:   '../model/Model-ren_ru_variable.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#GuardaVariable").html(data);   
											     
											} 
								});
			 
					 
 	}
 

}
//---------------------
function go_modal(id) {
	 
	
    var parametros = {
					'action_variable' : 'visor' ,
                    'id_rubro_var' : id 
	  };
	  $.ajax({
					data:  parametros,
					 url:   '../model/Model-ren_ru_variable.php',
					type:  'GET' ,
					beforeSend: function () { 
							$("#GuardaVariable").html('Procesando');
 					},
					success:  function (data) {
							 $("#GuardaVariable").html(data);  // $("#cuenta").html(response);
						     
                           
 					} 
			}); 

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
										 url:   '../model/Model-ren_ru_variable.php',
										 type:  'GET'  ,
										 success:  function (data) {
												 $("#GuardaVariable").html(data);   
											     
											} 
								});
 
}
//---

//------------------
function openFile(url,ancho,alto) {
    
	  var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  
  enlace = url  ;

  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
  