var oTable;

var formulario = 'ac_bienes';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});
//---------------------
function BuscaPrograma( codigo) {
 	
	 
	 var parametros = {
				 'codigo' : codigo,
				 'tipo'   : 0
	  };
		 
		
	   $.ajax({
			 data:  parametros,
			 url: "../model/ajax_bienes_sede_uni.php",
			 type: "GET",
	       success: function(response)
	       {

	    		   $('#Vid_departamento').html(response);
	    	  
	    		   BuscaCuenta( codigo) ;
	       }
		 });

	   
	   $(".dataTables_filter input[type='search']").val(''); 
		 
	}
//-----------
function BuscaCuenta( codigo) {
 	
	 
	 var parametros = {
				 'codigo' : codigo,
				 'tipo'   : 1
	  };
		 
		
	   $.ajax({
			 data:  parametros,
			 url: "../model/ajax_bienes_sede_uni.php",
			 type: "GET",
	       success: function(response)
	       {

	    		   $('#vcuenta').html(response);
	    	  
	       }
		 });

	   $(".dataTables_filter input[type='search']").val(''); 
		 
	}
//----------------------------------
function open_spop_modelo(url,ovar,ancho,alto) {
    var posicion_x; 
    var posicion_y; 
    var enlace; 
	 
    
    var id_marca = $("#id_marca").val();
 
    
    
	 //if (obj){
   	//		   obj.click();   
    //}
   			
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    enlace = url +'?id='+id_marca;
    window.open(enlace,
   		 	 '#',
   		 	 'width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+',toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');

  
}	
//----
  
//--
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
$(document).ready(function(){
    
   
        oTable 	= $('#jsontable').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 1 ] },
  		      { "sClass": "ye", "aTargets": [ 2 ] },
  		      { "sClass": "de", "aTargets": [ 3 ] },
  		      { "sClass": "di", "aTargets": [ 6 ] },
  		    ] 
       } );
        
        
       
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});
	    
	     $("#saveAsExcel").click(function(){
 
	    	   enlace = '../model/_exporta_excel.php' ;
	    	 										   
	    	   var win = window.open(enlace, '_blank');
	    	   
	    	   win.focus();
	       
	      
	     });
	     
	     $("#saveAsExcelResumen").click(function(){
	    	 
	    	   enlace = '../model/_exporta_excel_general.php' ;
	    	 										   
	    	   var win = window.open(enlace, '_blank');
	    	   
	    	   win.focus();
	       
	      
	     });
	     
	     
	     $("#saveAsReporte").click(function(){
 	    	 
	    	 var vtipo_bien			= $("#vtipo_bien").val();
	    	 var vcuenta			= $("#vcuenta").val(); 
	    	 var vuso				= $("#vuso").val();
	    	 var Vid_departamento	= $("#Vid_departamento").val();
	    	 
	    	 
	    	 
	    	 var ancho = 1250; 
	   	     var alto = 400; 
	   	     var posicion_x ; 
	   	     var posicion_y ; 
	   	     var enlace; 
	    	 var cadena 	= 'tip=' + vtipo_bien + '&cue=' + vcuenta + '&uso=' + vuso + '&idd=' +Vid_departamento;
	    	 enlace 		= '../model/_exporta_impresion.php?' + cadena;
 	         posicion_x		= (screen.width/2)-(ancho/2); 
 	   	     posicion_y		= (screen.height/2)-(alto/2); 
	 
 	   	     
 	   	    	 if ( vcuenta == '-'){
 	   	    	 alert('Seleccione grupo contable de bienes');
 	   	    	 }else{
 	 		   		 window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 	   	    	 }
 	   	   

 	      
	     });
	     
	     
	     $("#saveAsReporteUnidad").click(function(){
 	    	 
 
 	    	 var Vid_departamento	= $("#Vid_departamento").val();
 	    	 var vtipo_bien			= $("#vtipo_bien").val();
	    	 
	    	 
	    	 var ancho = 1250; 
	   	     var alto = 400; 
	   	     var posicion_x ; 
	   	     var posicion_y ; 
	   	     var enlace; 
	    	 var cadena 	= 'tip=' + vtipo_bien + '&cue=99&idd=' +Vid_departamento;
	    	 enlace 		= '../model/_exporta_impresion.php?' + cadena;
 	         posicion_x		= (screen.width/2)-(ancho/2); 
 	   	     posicion_y		= (screen.height/2)-(alto/2); 
	 
 	 
 	   	    	 if ( Vid_departamento == '0'){
 	   	    		 alert('Seleccione Unidad de bienes');
 	   	    	 }else{
 	 		   		 window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 	   	   
 	   	    	 }
 	      
	     });
	     
	     
	     
	     
	     
	      // loadprintEx
	     
	     
	     $("#ViewGrupo").load('../model/Model-ViewGrupo.php');
	     
	     $("#ViewSede").load('../model/Model-ViewSede.php');
	     
	     $("#ViewSedePeriodo").load('../model/Model-ViewPeriodo.php');
	     
	     
	     var j = jQuery.noConflict();
	     
	     j("#loadprint").click(function(){
				var mode = 'iframe'; //popup
				var close = mode == "popup";
				var options = { mode : mode, popClose : close};

			  j("#impresion_resumen").printArea( options );

		});
 

		$("#loadprintdatos").click(function(){
 
			enlace = '../reportes/ResumenBienes.php' ;
													 
			var ancho = 600; 
			var alto = 610; 
	  
			
			var posicion_x ; 
			var posicion_y ; 
	  
			var enlace; 
		   
			posicion_x=(screen.width/2)-(ancho/2); 
	  
			posicion_y=(screen.height/2)-(alto/2); 
		   
 		   
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 			 
		
	   
	  });

		
		
	     
	     
	     
	     
});  

function copiarAlPortapapeles(id_elemento) {
	  var aux = document.createElement("input");
	  aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
	  document.body.appendChild(aux);
	  aux.select();
	  document.execCommand("copy");
	  document.body.removeChild(aux);
	  alert("Contenido Copiado... vaya excel!!!");
	}

//-----------------------------------------
function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}
  
//------------------------------------------
function modulo()
{
 

	 var modulo1 =  'kactivos';
		 
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
	  
 
 
	var vtipo_bien			= $("#vtipo_bien").val();
	var vcuenta				= $("#vcuenta").val(); 
	var Vid_departamento	= $("#Vid_departamento").val();
	var vuso				= $("#vuso").val();
	var vtiene_acta			= $("#vtiene_acta").val();
	var vidsede				= $("#vidsede").val();
	
	var vactivo				= $("#vactivo").val();
	
	var vcodigo				= $("#vcodigo").val();
	
	
	   
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vcuenta' : vcuenta ,
				'Vid_departamento' : Vid_departamento ,
				'vuso' : vuso ,
				'vtiene_acta' : vtiene_acta ,
				'vidsede': vidsede,
				'vactivo' :vactivo,
				'vcodigo' :vcodigo
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
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
						s[i][5],
						s[i][6]
 				]);										
			} // End For
		  } 						
		 } 
	 	});
		
		$("#vactivo").val('');
		
		$("#vcodigo").val('');
		 

}   
  



//-----------------
 function FormView()
 {
    
	 $("#ViewForm").load('../controller/Controller-ac_bienes_reportes.php' );
	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');
	 
 }
//--------------- 
  
 //------------
 function selecciona_cuenta(cuenta)
 {
    
	 document.getElementById("cuenta_tmp").value = cuenta ;
	 
 
	 
 }
 
 
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
  
    