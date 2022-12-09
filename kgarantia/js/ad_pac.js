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
     
   
		 oTable 	= $('#jsontable').dataTable( {      
	         searching: true,
	         paging: true, 
	         info: true,         
	         lengthChange:true ,
	         aoColumnDefs: [
			      { "sClass": "highlight", "aTargets": [ 4 ] },
			      { "sClass": "ye", "aTargets": [ 1 ] },
			      { "sClass": "de", "aTargets": [ 5 ] }
			    ] 
	      } );
 	    
	     $('#load').on('click',function(){
 	 		 
           BusquedaGrilla(oTable);
           
 		});
         
	     
	     $('#loadDoc').on('click',function(){
	    	 
	            openFile('../view/ga_nueva_poliza',1080,530)
 
		 });
 	     
	     $('#loadContrato').on('click',function(){
	    	 
	            openFile('../../upload/uploadGar',650,320)

	  			

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
					url:   '../model/Model-ga_contrato.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
							 Ver_doc_(id);
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
function accion(id, action)
{
 
	$('#action').val(action);
	
	$('#idcontrato').val(id); 
	  
 
}
//---------------------------
function goToURLDocdelG(idcodigo,idcaso) {

 alert ('Opcion No disponible');
 
  }
//------------------goToURLDocdel
function goToURLDocdel(idcodigo,idcaso) {

	 
    var parametros = {
 					'idcodigo' : idcodigo  ,
					'idcaso'   : idcaso  ,
					'accion' : 'del'
 	  };

	  $.ajax({
 					data:  parametros,
 					url:   '../model/Model-garantia_doc.php',
 					type:  'GET' ,
 					success:  function (data) {
 							 $("#ViewFormfileDoc").html(data);  // $("#cuenta").html(response);
  
 					} 

			}); 
 
  }
//--------
function PoneDoc(file)
{
 
 
 
  
 var parent = $('#DocVisor').parent(); 
 $('#DocVisor').remove(); 
 
 var newElement = "<embed src='new src'" +' width="100%"  height="450px" id="DocVisor" name ="DocVisor" >'; 
 parent.append(newElement); 
	 
  $('#DocVisor').attr('src',file); 
 
	
  	
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

	  //-----------------------ListaFormContrato
  var parametrosd = {
					'id' : id  
	  };
	    
	  $.ajax({
			data:  parametrosd,
			url:   '../model/Model-garantia_doc.php',
			type:  'GET' ,
			success:  function (data) {
					 $("#ViewFormfileDoc").html(data);   

			} 

	}); 
	 
}

// ir a la opcion de editar
function LimpiarPantalla() {
  
	
	var fecha = fecha_hoy();
 
	$("#idcontrato").val("");
	$("#idprov").val("");
	$("#nro_contrato").val("");
	$("#forma_contratacion").val("");
	$("#tipo_contratacion").val("");
	$("#detalle_contrato").val("");
	$("#monto_contrato").val("0.00");
 
	
	$("#fecha").val(fecha);
	$("#fecha_inicio").val(fecha);
	$("#fecha_fin").val(fecha);
	
	$("#razon").val("");
	
	
	$("#iddepartamento").val("");
	$("#dias_vigencia").val("30");
	$("#sesion_responsable").val("");
	$("#estado").val("");
       			   

$("#novedad").val("");
$("#fecha_acta").val("");
$("#monto_anticipo").val("");
$("#canticipo").val("");

 
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
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
             
           	var tipo1 = $("#tipo1").val();
            var tiddepartamento1 = $("#tiddepartamento1").val();
             var estado1 = $("#estado1").val();
 
         
            var parametros = {
					'tipo1' : tipo1 , 
                    'tiddepartamento1' : tiddepartamento1  ,
                    'estado1' : estado1
 	       };
      
	 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_ga_registro.php',
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
       	                        s[i][6],
       	                        s[i][7],
                               	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
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
   
	 
	 $("#ViewForm").load('../controller/Controller-ga_contrato.php');
     

}
//----------------------
function FormFiltro()
{
	
 
	 $("#ViewFiltro").load('../controller/Controller-ga_registros_filtro.php');
	 
	 
	 

}
 
//------------------
function openFile(url,ancho,alto) {
    
	  var posicion_x; 
  var posicion_y; 
  var enlace; 
  
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  
 
  var idcontrato = $("#idcontrato").val();
  enlace		 = url +'?id='+ idcontrato ;

  if (idcontrato >0 ){
	  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

  }

}
  