var oTable;
var oTable_doc;

var formulario = 'ac_bienes_custodio';


$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


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
        
        
    oTable_doc 	= $('#jsontable_main').dataTable( {      
            searching: true,
            paging: true, 
            info: true,         
            lengthChange:true ,
            aoColumnDefs: [
   		      { "sClass": "highlight", "aTargets": [ 0 ] },
  		      { "sClass": "ye", "aTargets": [ 4 ] },
  		      { "sClass": "de", "aTargets": [ 5 ] }
  		    ] 
       } );
       
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable_doc);
          
		});

 
 
	    
	     $("#saveAsExcel").click(function(){
	         var workbook = XLSX.utils.book_new();
	         
 	       
	         var worksheet_data  = document.getElementById("jsontable");
	         var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
	         
	         workbook.SheetNames.push("Test");
	         workbook.Sheets["Test"] = worksheet;
	       
	          exportExcelFile(workbook);
	       
	      
	     });
 
		
});  
//---------------------------------------------------------------
function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}
 
//----------------------------------------
function verdocumento_bien(id)
{
 
 		 
	 var parametros = {
			    'id' : id,
			    'accion' : 'visor'
   };
	  
	  
	$.ajax({
			data:  parametros,
			 url:   '../model/Model-ac_bienes_doc_view',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFormfile").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFormfile").html(data);  
				     
				} 
	});
     

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
   
//----------------
function goToURLvisor(idprov,id) {
	 
	 
 
    var vcustodio			= '-'; 
	var vcodigo				= idprov;
	
    var parametros = {
				'vcustodio' : vcustodio ,
				'vcodigo' : vcodigo
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ac_bienes_custo_seg.php'  ,
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
                        s[i][6],
                        s[i][7],
                        s[i][8],
                        s[i][9] 
 				]);										
			} // End For
		  } 						
		 } 
	 	});

     
         var fila = id + 1;

         var x=document.getElementById("jsontable_main");
          
         var mensaje  = x.rows[fila].cells[1].innerHTML + ' <br> ' +  x.rows[fila].cells[0].innerHTML + ' ' +  x.rows[fila].cells[2].innerHTML + ' <br> Nro Bienes ' +  x.rows[fila].cells[4].innerHTML + ' <br> Monto Bienes ' +  x.rows[fila].cells[5].innerHTML;

         $('#idprov').val(x.rows[fila].cells[0].innerHTML);
 
         $('#ViewForm').html(mensaje);
         

     

    $('#mytabs a[href="#tab2"]').tab('show');

	 
	 
	 
 }
//---------------------------------------------------------------------
  
  
//------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable_doc){       
	  
	
	var vcustodio			= $("#vcustodio").val(); 
	var vcodigo				= $("#vcodigo").val();
	
    var parametros = {
				'vcustodio' : vcustodio ,
				'vcodigo' : vcodigo
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_' + formulario,
			dataType: 'json',
			cache: false,
			success: function(s){
		    //console.log(s); 
			oTable_doc.fnClearTable();
			if(s)  {
			for(var i = 0; i < s.length; i++) {
                oTable_doc.fnAddData([
						s[i][0],
						s[i][1],
						'<b>' + s[i][2] + '</b>',
						s[i][3],
						s[i][4],
						s[i][5],
                        '<button class="btn btn-xs btn-warning" title="Visualizar detalle del Bien" onClick="goToURLvisor('+ "'"+ s[i][0] +"',"+i+')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;'   

 				]);										
			} // End For
		  } 						
		 } 
	 	});

		
		
		$("#vcustodio").val(''); 
 		$("#vcodigo").val('');
		
}   
  
//-----------------------
 
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
//-----------------
 function FormView()
 {
    
 	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro');

     $("#ViewForm").load('../controller/Controller-' + formulario );
	 
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
 function impresion_custodio( ) {

	 var url = '../reportes/Activos_Custodios';
	 
 
	    
	  var id = $('#idprov').val();

	  var ancho = 650; 
	  var alto = 460; 

	  
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

	function impresion_acta( ) {

		var url = '../reportes/acta_custodio_total';
		
	
		   
		 var id = $('#idprov').val();
   
		 var ancho = 650; 
		 var alto = 460; 
   
		 
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
	

//------------	
function Exportar_datos( ) {

	var url = '../model/_exporta_bien_funcionario';
	

	   
	 var id = $('#idprov').val();

	 var ancho = 650; 
	 var alto = 460; 

	 
	 var posicion_x ; 
	 var posicion_y ; 

	 var enlace; 
	
	 posicion_x=(screen.width/2)-(ancho/2); 

	 posicion_y=(screen.height/2)-(alto/2); 
	
	 enlace = url+'?id='+id  ;
	
	 if ( id) {
 			
	   window.location.href = enlace;

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
  