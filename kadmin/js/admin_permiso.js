var oTable ;

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
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "ye", "aTargets": [ 1 ] },
		      { "sClass": "de", "aTargets": [ 6 ] }
		    ] 
    } );
	    
	    
	    BusquedaGrilla( oTable);
 		
 	   $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
 
		});
      
	         
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
					url:   '../model/Model-admin_permiso.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 
	  
	  asignav(  id, 'visor' );

	  AsignaModulo('0','0');
	  
	   $("#id_par_modulo").val('0');
	  
	  
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

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable

 
     	var GrillaCodigo = $("#qestado").val();
    
          
      var parametros = {
				'GrillaCodigo' : GrillaCodigo  
      };

 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_admin_usuarios.php',
			dataType: 'json',
			success: function(s){
			//console.log(s); 
			oTable.fnClearTable();
			
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
			    		  s[i][0],
							s[i][1],
							s[i][2],
							s[i][3],
	                        s[i][4],
                          s[i][5],
                          s[i][6],
                        	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button> '  
						]);										
					} // End For
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
 
		
  }   
//--------------
  //------------------------------------------------------------------------- 
 
 
 function modulo()
 {
 
	 var modulo =  'kadmin';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-admin_permiso.php');
      

 }
   //---
 function AsignaModulo(val,val2){   //esperando la carga... 
	 
	  var idUsuario =    $("#idusuario").val();
     
    
     var parametros = {
					'mod' : val ,
                    'user' : idUsuario 
	  };
     
     $.when(
			  $.ajax({
							data:  parametros,
							url:   '../model/Model-admin_permiso_mod.php',
							type:  'GET' ,
							beforeSend: function () { 
									$("#modulo").html('Procesando');
		 					},
							success:  function (data) {
									 $("#modulo").html(data);  // $("#cuenta").html(response);
								     
		 					} 
					}),
			
					$.ajax({
						data:  parametros,
						url:   '../model/Model-admin_permiso_usu.php',
						type:  'GET' ,
	 					beforeSend: function () { 
	 							$("#asignado").html('Procesando');
	  					},
						success:  function (data) {
								 $("#asignado").html(data);  // $("#cuenta").html(response);
							     
	  					} 
				})
					
					
	 	).done(function() {
			 
			});	
} 
 /*-----------------------------------------------------------------
 FUNCIONES DE APOYO AJAX  PERFIL DE USUARIOS AÑADIR
-------------------------------------------------------------------*/	 
function filtro_addperfil(val,val2,val3){



action ='add';
var parametros = {
				 "action" : action,
				 "modcod" : val,
				 "user": val2,
				 "mod": val3,
				 
		 };

 
	 $.ajax({
			 type : 'get',
			 data:  parametros,
			 url : '../model/ajax_admin_usuarios.php' ,
			 success:  function (response) {
						 $("#asignado").html(response);
				 }

		}); 
} 
//----------------
/*-----------------------------------------------------------------
FUNCIONES DE APOYO PERFIL DE USUARIOS  
-------------------------------------------------------------------*/
function filtro_perfil(val,val2,val3){

//   $('#asignado').html('');
//   $('#asignado').remove(); 

action ='del';

var parametros = {
				 "action" : action,
				 "modcod" : val,
				 "user": val2,
				 "mod": val3
		 };
 	
 

	 $.ajax({
			 type : 'get',
			 data:  parametros,
			 url : '../model/ajax_admin_usuarios.php',
			 success:  function (response) {
						 $("#asignado").html(response);
				 }

		});

}

//-----------------------------
function asignaa( val, action ){

var idusuario  = $('#idusuario').val();
 

var parametros = {
				 "action" 		: action,
				 "idusuario" 	: idusuario,
				 "tipo"			 	: val
		 };
	
	 $.ajax({
			 type : 'POST',
			 data:  parametros,
			 url : '../model/ajax_rol_user_ac.php',
			 success:  function (response) {
						 $("#tableroasignado").html(response);
				 }

		});

}
//--------------------------------
//-----------------------------
function asignav( idusuario, action ){

 
 

var parametros = {
				 "action" 		: action,
				 "idusuario" 	: idusuario,
 		 };
	
	 $.ajax({
			 type : 'POST',
			 data:  parametros,
			 url : '../model/ajax_rol_user_ac.php',
			 success:  function (response) {
						 $("#tableroasignado").html(response);
				 }

		});

}

/*-----------------------------------------------------------------
FUNCIONES DE APOYO AJAX  ASIGNACION DE OPCIONES
-------------------------------------------------------------------*/ 
function recargarS2(val,val2){   //esperando la carga... 

var idUsuario =    $("#idusuario").val();

 
var parametros = {
				'mod' : val ,
                'user' : idUsuario 
 };
$.ajax({
				data:  parametros,
				url:   ' ../model/ajax_admin_modulo.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#modulo").html('Procesando');
				},
				success:  function (data) {
						 $("#modulo").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 

//-----------------------------------------------------------------------         
var parametros1 = {
		'mod' : val ,
       'user' : idUsuario 
};
$.ajax({
				data:  parametros1,
				url:   '../model/ajax_admin_usuarios.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#asignado").html('Procesando');
				},
				success:  function (data) {
						 $("#asignado").html(data);  // $("#cuenta").html(response);
					     
				} 
		}); 
              


}
  