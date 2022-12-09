var oTable;
var modulo_sistema     =  'kpersonal';
 
 

//-------------------------------------------------------------------------
$(document).ready(function(){
	
		modulo();
	
 

       oTable 	= $('#jsontable').dataTable( {      
           searching: true,
           paging: true, 
           info: true,         
           lengthChange:true ,
           aoColumnDefs: [
  		      { "sClass": "highlight", "aTargets": [ 0 ] },
 		      { "sClass": "ye", "aTargets": [ 1 ] },
 		      { "sClass": "de", "aTargets": [ 4 ] } 
 		    ] 
      } );
       
      
 
		$.ajax({
 			 url: "../model/ajax_unidad_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qunidad').html(response);
	       }
		 });
	    
	    $.ajax({
			 url: "../model/ajax_regimen_lista.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#qregimen').html(response);
	       }
		 });
	    

 	   $('#load').on('click',function(){
 		   			BusquedaGrilla(oTable);
		});

     
		$('#loadDoc').on('click',function(){
 
            openFile('../../upload/uploadDoc',650,370);
 
		});
 
		$('#excelload').on('click',function(){
 
			exportar_excel('../../reportes/excel_personal');

 		});
 
         $("#ViewForm").load('../controller/Controller-nom_cvacaciones.php');
	 
		
 
		$("#FormPie").load('../view/View-pie.php');
		$("#MHeader").load('../view/View-HeaderModel.php');

});  
 
//---------------
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
//-------------------------
function imprimir_informe(url) {
    
	var idprov = $('#idprov').val();
	   
	var ancho = 800;
	var alto  = 650;
	var posicion_x; 
	var posicion_y; 
	var enlace; 
   
	posicion_x=(screen.width/2)-(ancho/2); 

	posicion_y=(screen.height/2)-(alto/2); 
   
	enlace = url+'id='+idprov  ;
   
	if ( idprov) {
			window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

	  }
}
//---------------
function exportar_excel(url)

{
	 window.open(url,'_blank');

}
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {
 				 
 					$("#action").val("add");
 
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
 
		            LimpiarPantalla();
 
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
function goToURL(accion,id,ajuste) {

	var parametros = {
 					'accion' : accion ,
                     'id' : id 
  	  };
 
	 $("#idprov_funcionario").val(id);
			

    if (accion == 'editar'){

		$("#ajuste").val(ajuste);
         $('#myModalCarga').modal('show');

         
       } 


        /*
				  $.ajax({
								data:  parametros,
								url:   '../model/Model-nom_ingreso.php',
								type:  'GET' ,
			 					beforeSend: function () { 
			 							$("#result").html('Procesando');
			  					},
								success:  function (data) {
									if ( accion == 'del'){
										      alert(data);
									} else	{
											  $("#result").html(data);  // $("#cuenta").html(response);
										      Ver_doc_prov(id) ;
									}
										
									
			  					} 
			
						}); 

                        */

 }
 
//---------------------------
function fecha_hoy()
{

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();

    if(dd < 10){
        dd='0'+ dd;
    } 

    if(mm < 10){
        mm='0'+ mm;
    } 

  
    var today = yyyy + '-' + mm + '-' + dd;
   
 return today;
 
} 
//------------------------------------------------------------------------- 
 function BusquedaGrilla(oTable){        	 

  		var user     = $(this).attr('id');
     	var qestado  = $("#qestado").val();
     	var qunidad  = $("#qunidad").val();

         var text     = $("#qregimen").val();
        var  qregimen = text.trim();

     
       var parametros = {
				'qestado' : qestado  ,
				'qunidad' : qunidad,
				'qregimen' : qregimen

      };

 
		if(user != '')  { 

		$.ajax({
 		 	data:  parametros,
		    url: '../grilla/grilla_nom_cvacacion.php',
			dataType: 'json',
			success: function(s){
			oTable.fnClearTable();
			if (s){ 
					for(var i = 0; i < s.length; i++) {
						oTable.fnAddData([
 							s[i][0],
 							s[i][1],
 							s[i][2],
  	                        s[i][3],
                            s[i][4],
                            s[i][5],
                            s[i][6],
                            s[i][7],
                           	'<button class="btn btn-xs btn-warning" title="EDITAR REGISTRO SELECCIONADO"   onClick="goToURL('+"'editar'"+','+"'"+ s[i][8]+"',"+s[i][9] +')"><i class="glyphicon glyphicon-edit"></i></button> ' + 
 							'<button class="btn btn-xs btn-info" title="HISTORIAL DE PERMISOS DE VACACIONES"  onClick="goToURL('+"'visor'"+','+ "'"+ s[i][8]+"'," +s[i][9]+')"><i class="glyphicon glyphicon-file"></i></button>' 
 						]);										
 					}  
 			    }						
 			},
 			error: function(e){
 			   console.log(e.responseText);	
 			}
 			});
 		}

  }   
//-----------------
 
 function modulo()
{
 	  
	 var parametros = {

			    'ViewModulo' : modulo_sistema

    };

 
	$.ajax({
			data:  parametros,
			url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ViewModulo").html(data);  
				} 
	});
 
}
   
//----------------
function Ver_doc_prov(idprov) {

	 
     var parametros = {
 					'idprov' : idprov  
  	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-nom_rol_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfile").html(data);  // $("#cuenta").html(response);
 
  					} 

			}); 
 
	  //-----------------------ListaFormContrato
	  var parametrosd = {
					'idprov' : idprov  
	  };
	    
	  $.ajax({
			data:  parametrosd,
			url:   '../model/Model-nom_rol_ac.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ListaFormContrato").html(data);  // $("#cuenta").html(response);

			} 

	}); 
	  
}
 