var oTable;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
   
		oTable = $('#jsontable').dataTable(); 
	    
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});


		 $("#ExcelButton").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#ViewForm_resumen').html()));
	        e.preventDefault();
	    });
	     
	    
    var j = jQuery.noConflict();
		j("#printButton").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};
			    j("#ViewForm_resumen").printArea( options );
		});


		 var anio = fecha_hoy();
         
		 $('#anioc').val(anio);
		 
	         
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
					url:   '../model/Model-ren_especie.php',
					type:  'GET' ,
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
  
 
               
                    $("#idproducto").val("");
                    $("#tipo").val("");
                    
                    $("#idbodega").val("");
                    $("#idcategoria").val("");
                    $("#idmarca").val("");
                    $("#unidad").val("");
                    $("#producto").val("");
                    $("#referencia").val("");
                    $("#estado").val("");
                    $("#facturacion").val("");
                    $("#costo").val("");
                    $("#tributo").val("");
                    $("#cuenta_ing").val("");
                    $("#cuenta_inv").val("");
                    
                    $("#partida").val("");
                    
                    
                    $("#partidaa").val("");
                    $("#cuenta_ajeno").val("");
                    $("#coactiva").val("");
                    $("#fondoa").val("");
                    $("#cuenta_aa").val("");
                    $("#cuenta_ce").val("");
                    $("#tipo_formula").val("");
                    $("#formula").val("");
                  
  			   
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
    
	return yyyy;
 
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
           	var GrillaCodigo = $("#tipo1").val();
            var idcategoria1 = $("#idcategoria1").val();
           
         
         
            if (!(idcategoria1))  { idcategoria1 = 0;}
         
         
            var parametros = {
					'GrillaCodigo' : GrillaCodigo , 
                    'idcategoria1' : idcategoria1  
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ren_especie.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
       	                        s[i][4],
       	                        s[i][5],
                               	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
 
 function imagenfoto(urlimagen)
{
 
  
   var path_imagen = '../../kimages/' + urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToPrecio() {
 
     var id =   $('#idproducto').val();
 
     var parametros = {
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ajax_precio.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#precio_grilla").html('Procesando');
  					},
					success:  function (data) {
							 $("#precio_grilla").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ren_especie');
     

}
//----------------------
function FormFiltro()
{
	
 
	 $("#ViewFiltro").load('../controller/Controller-ren_especie_filtro.php');
	 
	 
	 

}
//----------------------
function PonePartida( id ) {
	 
    var parametros = {
		'id' : id ,
		'tipo': 'partida'
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_cuenta_partida.php",
			type: "GET",
			success: function(response)
			{
				$('#cuenta_aa').html(response);
			}
		});
 
		 
}


function PoneCuenta( id ) {
	 
	var partida = $('#partidaa').val();
	
    var parametros = {
		'id' : id ,
		'tipo': 'cuenta',
		'partida': partida	
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_cuenta_partida.php",
			type: "GET",
			success: function(response)
			{
				$('#cuenta_ce').html(response);
			}
		});
 
		
}

function BusquedaVisor( id ) {
	 
	var anioc   = $('#anioc').val();
	var mesc = $('#mesc').val();

    var parametros = {
		'id' : id  ,
		'mesc': mesc,
		'anioc':anioc
		}; 

		$.ajax({
			data: parametros,
			url: "../model/Model-ven_reportes_especie.php",
			type: "GET",
			success: function(response)
			{
				$('#ViewForm_resumen').html(response);
			}
		});
 
		
}
 
//------------------------
/*
function PoneCuenta( id ) {
	 
	var partida = $('#partida').val();
	
    var parametros = {
		'id' : id ,
		'tipo': 'cuenta',
		'partida': partida	
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_cuenta_partida.php",
			type: "GET",
			success: function(response)
			{
				$('#cuenta_inv').html(response);
			}
		});
 
		
}*/
//---
function PoneCuentaa( id ) {
	 
	var partida = $('#partidaa').val();
	
    var parametros = {
		'id' : id ,
		'tipo': 'cuenta',
		'partida': partida	
		}; 

		$.ajax({
			data: parametros,
			url: "../model/ajax_cuenta_partida.php",
			type: "GET",
			success: function(response)
			{
				$('#cuenta_ce').html(response);
			}
		});
 
		
}

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
  
/*
*/

