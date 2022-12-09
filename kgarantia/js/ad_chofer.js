var oTable;
   
$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

//-------------------------------------------------------------------------
$(document).ready(function(){
    
 
	
		$("#MHeader").load('../view/View-HeaderModel_ad.php');
		
		modulo();
			
		FormFiltro();
		
		FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
     
   
		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 4 ] },
			      { "sClass": "ye", "aTargets": [ 0 ] },
			      { "sClass": "de", "aTargets": [ 5 ] }
			    ] 
	      } );
 	    
		 BusquedaGrilla(oTable);
		 
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     
	  
	     
	     
	 	$('#loadDoc').on('click',function(){
	 		 
            openFile('../../upload/uploadChofer',1024,350)

  			

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
								url:   '../model/Model-ad_chofer_visor.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
										 $("#result").html(data);  // $("#cuenta").html(response);
											verdocumento_bien(id);
			  					} 
						}); 
	 
  }
 //----
function goToURL_asignar(idprov_cho,razon_cho) {
  	
   
 $('#idprov_cho').val(idprov_cho);
 $('#razon_cho').val(razon_cho);
		
 			$("#myModalCarga").modal('show'); 
	
   }

//---
function AsignarVehiculo() {
  	
   
 var idprov_cho = $('#idprov_cho').val();
 var id_unidad  = $('#id_unidad').val();
		
		 var parametros = {
					'accion' : 'asignar' ,
                    'idprov_cho' : idprov_cho ,
					'id_unidad' : id_unidad
 	  };

 
				  $.ajax({
								data:  parametros,
								url:   '../model/_lista_carro_asigna.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result_carga").html('Procesando');
			  					},
								success:  function (data) {
										 $("#result_carga").html(data);  // $("#cuenta").html(response);
											 
			  					} 
						}); 
 	 BusquedaGrilla(oTable);

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
//-----------
function url_ficha(url){        
	
	var variable    = $('#id_bien').val();
   
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url + '?codigo='+variable  ;
    
    var ancho = 1000;
    
    var alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    
    posicion_y=(screen.height/2)-(alto/2); 
    
    window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//-------------------------------------------------------------------------
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#id_bien').val(id); 
	  
 
}
//---------------------------
function goToURLDocdelG(idcodigo,idcaso) {

 alert ('Opcion No disponible');
 
  }
//------------------goToURLDocdel
function goToURLDocdel(idcodigo,idprov) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'prov'   : idprov  
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-ad_chofer_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
  
 
//----------------------
function Ver_doc_(id) {

	 
    var parametros = {
					'id' : id  
 	  };

	  $.ajax({
					data:  parametros,
					url:   '../model/Model-garantia_visor.php',
					type:  'GET' ,
					success:  function (data) {
							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

 					} 

			}); 

 
	 
}

// ir a la opcion de editar
function LimpiarPantalla() {
  
	
	var fecha = fecha_hoy();
 
 

 
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
    
 
    return today;
            
} 
//----------------------------
 function openFile(url,ancho,alto) {
	    
	  var idprov = $('#idprov').val();
		 
	  var posicion_x; 

	  var posicion_y; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idprov  ;
	 
	  if ( idprov) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
}

  ///***********
 function openFileComponente( ) {

	 var url = '../view/ac_bienes_componente.php';
	 
 
	    
	  var id = $('#id_bien').val();

	  var ancho = 920; 
	  var alto = 420; 

	  
	  var posicion_x ; 
	  var posicion_y ; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+id  ;
	 
	  if ( id) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
		var qestado = $("#qestado").val();
      
     
 
            var parametros = {
					'accion' : 'visor',
					'qestado':qestado
 	       };
      
         
            
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ad_chofer.php',
				dataType: 'json',
				success: function(s){
						//console.log(s); 
						oTable.fnClearTable();
						if(s ){ 
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								'<b>'+ s[i][1] + '</b>',
								s[i][2],
       	                        s[i][3],
       	                        '<b>'+s[i][4] + '</b>',
       	                        s[i][5],
                                 	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ "'" + s[i][0] + "'" +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;&nbsp;&nbsp;' +
'<button class="btn btn-xs" title="Asignar conductor al vehiculo/maquinaria" onClick="javascript:goToURL_asignar('+ "'" +  s[i][0]+ "'," + "'" +  s[i][1]+ "'" +')"><i class="glyphicon glyphicon-user"></i></button>' 
							]);										
						} // End For
				  }						
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
   
 
 function imagenfoto(urlimagen)
{
 
  
   var path_imagen = '../../kimages/' + urlimagen ;
 
    var imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
 
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
 

 var modulo1 =  'kgarantia';
		 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ad_chofer.php');

	 $("#asigna_vehiculo").load('../controller/Controller-ad_asigna_carro.php');
 




}
//----------------------
function FormFiltro()
{
 
}
//-------
//----------------------------------------
function verdocumento_bien(idprov)
{
 
 		 
	var parametros = {
				'idprov' : idprov  
};

$.ajax({
				data:  parametros,
				url:   '../model/Model-ad_chofer_doc.php',
				type:  'GET' ,
				success:  function (data) {
						 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);

				} 

	}); 
     

}
//---------
function PoneDoc(file)
{
  	 
	 var parent = $('#DocVisor').parent(); 
	 $('#DocVisor').remove(); 
	 
	 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
	 parent.append(newElement); 
	 
	 
	  
 	 var url = '../../archivos/doc/' + file;
	 
 	 var myStr = file;
 	   
     var strArray = myStr.split(".");
      
     if ( strArray[1] == 'pdf' ){
    	 
     	 
    	    $('#DocVisor').attr('src',url); 
    	    
    	 
  
     }else{
    	 
    	 $('#DocVisor').attr('src',url); 
     	 
  
     }
 
  	
}
 
//---------------------------------------------------------------------
function verComponente_bien(id)
{
 
 		 
  var parametros = {
			    'id' : id,
			    'accion' : 'visor'
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ac_bienes_componente.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormComponentes").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormComponentes").html(data);  
				     
				} 
	});
     

}
 
  