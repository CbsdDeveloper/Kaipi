var oTable;

var formulario = 'ac_bienes_soft';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});
//----------------------------------
 
  
//-------------------------------------------------------------------------
$(document).ready(function(){
    
   
        oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "de", "aTargets": [ 3 ] }
   		    ] 
       } );
        
        
       
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	    
 	   BusquedaGrilla(oTable);
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});
	    
	     $("#saveAsExcel").click(function(){
	    	 
 

	    	   enlace = '../model/_exporta_excel.php' ;
	    	 										   
	    	   var win = window.open(enlace, '_blank');
	    	   
	    	   win.focus();
	       
	      
	     });
 
		
});  
//-----------------------------------------
function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}
//----------------------------------------

function GuardarSoftware()
{
	  
 
 
	var  tipo     		= $("#tipo").val();
	var  categoria      = $("#categoria").val();
	var  detalle        = $("#detalle_soft").val();
	var  licencia       = $("#licencia").val();
	var  id_software    = $("#id_software").val();
 	
	
      
    
    var parametros = {
            'tipo' : tipo ,
            'categoria' : categoria,
            'detalle' : detalle,
            'licencia' :licencia,
            'id_software' : id_software
    };
    
	  
	$.ajax({
 			 url:   '../model/Model-ac_bienes_soft_cat.php',
			type:  'POST' ,
			data:  parametros,
			cache: false,
			beforeSend: function () { 
						$("#ViewGuarda").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewGuarda").html(data);   
				     
					 BusquedaGrilla(oTable)
				} 
	});

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
//------------------------------------------
function modulo()
{
 

	 var modulo1 =  'kcms';
		 
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
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
                    LimpiarPantalla();
                    
					$("#action").val("add");
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
					verdocumento_bien(0);
				 	
				 	verComponente_bien(0);
				 	
			  }
			 }); 
			}
			
			
			if (tipo =="alerta"){			 
			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {
			  });
			 }		  
			return false	  
		   }
 
//----------------------------
 	 
//--------------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

}

//--------------

function modalVentana(url){        
	
    
    var posicion_x; 
    var posicion_y; 
    
    var enlace = url  
    
    var ancho = 1000;
    
    var alto = 450;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }
//----------------------------------------------------------
function _asigna(variable,valor) {
	
	
	var objeto = '#'+variable;
	
	var variable_asiga = valor;
	
	if (valor){
 	
			if(variable_asiga.length > 0) {
				
				$(objeto).val(variable_asiga.trim() );
				
			}else{
				
				$(objeto).val('');
			}
	}		
	else{
		
		$(objeto).val('');
		
	}
   
	
}
//--------------
function goToURLTeam(accion,id) {
	
	$('#myModalDocVisor').modal('show');
 	
}
//--------------
function goToURLLista(accion,id) {
	
 	$('#mytabs a[href="#tab2"]').tab('show');
 	
}
// ir a la opcion de editar
function goToURL(accion,id) {

    var resultado = Mensaje( accion ) ;
	   
	var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	
 	
	$.ajax({
		  url:   '../model/Model-'+ formulario,
		  type:  'GET' ,
		  data:  parametros,
		  dataType: 'json',  
			}).done(function(respuesta){
					
			 
				_asigna('id_bien',respuesta.id_bien);
				
				_asigna('fecha',respuesta.fecha);
				_asigna('forma_ingreso',respuesta.forma_ingreso);
				_asigna('identificador',respuesta.identificador);
				_asigna('descripcion',respuesta.descripcion);
				
				_asigna('clase_esigef',respuesta.clase_esigef);
				
			 
				 
			});
 
	$('#myModal').modal('show');
	 
 
	

	  
}
//----------------------
 
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
 

	$("#id_software").val("0");
	$("#tipo").val("");
	$("#categoria").val("");
	$("#detalle_soft").val("");
 	$("#licencia").val("");
	
	 
	 
}
//-------------
 
//-------------
function siguiente( menu1 ) {


	 $('#mytabs_1 a[href="#'+ menu1+'"]').tab('show');
	 
	 
	 

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
//------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){       
	  
 
 
 	  
		$.ajax({
  		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable.fnClearTable();
			if(s)  {
			for(var i = 0; i < s.length; i++) {
				 oTable.fnAddData([
						s[i][0],
						s[i][1],
						s[i][2],
						s[i][3],
						s[i][4],
   					'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;'  +
   					'<button class="btn btn-xs" onClick="javascript:goToURLTeam('+"'visor'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-user"></i></button>&nbsp;'  +
   					'<button class="btn btn-xs" onClick="javascript:goToURLLista('+"'visor'"+','+ s[i][5] +')"><i class="glyphicon glyphicon-search"></i></button>' 
				]);										
			} // End For
		  } 						
		 } 
	 	});
		
 
		 

}   
  



//-----------------
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-' + formulario);
	 
	 $("#ViewCatalogo").load('../controller/Controller-' + formulario + '_cat');
 
 }
//--------------- 
 
//-----------------
 function printDiv(divID) {
	 
	 var objeto=document.getElementById(divID);  //obtenemos el objeto a imprimir
	 
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
        
}
//----------------------------
 function openFile( ) {

	 var url = '../../upload/uploadAc';
	 
 
	    
	  var id = $('#id_bien').val();

	  var ancho = 650; 
	  var alto = 360; 

	  
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
 