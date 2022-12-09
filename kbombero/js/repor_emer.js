var oTable;
var formulario = 'repor_emer';


 
//-------------------------------------------------------------------------
$(document).ready(function(){
    
    oTable 	= $('#jsontable').dataTable( {      
        searching: true,
        paging: true, 
        info: true,         
        lengthChange:true ,
        aoColumnDefs: [
		      { "sClass": "highlight", "aTargets": [ 4 ] },
		      { "sClass": "ye", "aTargets": [ 1 ] },
		      { "sClass": "de", "aTargets": [ 3 ] },
		      { "sClass": "di", "aTargets": [ 5 ] },
		    ] 
   } );
    
          
        modulo();
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
 	    FormView();
  	 		    
		
	     $("#saveAsExcel").click(function(){
	         var workbook = XLSX.utils.book_new();
	         
	         //var worksheet_data  =  [['hello','world']];
	         //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
	       
	         var worksheet_data  = document.getElementById("jsontable");
	         var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
	         
	         workbook.SheetNames.push("Test");
	         workbook.Sheets["Test"] = worksheet;
	       
	          exportExcelFile(workbook);
	       
	      
	     });

	     $("#saveAsExcelResumen").click(function(){
	    	 
	    	   enlace = '../model/_exporta_excel_general.php' ;
	    	 										   
	    	   var win = window.open(enlace, '_blank');
	    	   
	    	   win.focus();
	       
	      
	     });


		 $("#load").click(function(){
 			BusquedaGrilla(oTable)
 	   
	    });


	     $("#saveAsReporte").click(function(){
 	    	 
	    	 var bparro	= $("#bparro").val();
	         var btipo	= $("#btipo").val(); 
	        var bcate	= $("#bcate").val();
	    	  
	    	 
	    	 var ancho = 1250; 
	   	     var alto = 400; 
	   	     var posicion_x ; 
	   	     var posicion_y ; 
	   	     var enlace; 
	    	 var cadena 	= 'cat=' + bcate ;
	    	 enlace 		= '../model/_exporta_impresion.php?' + cadena;
 	         posicion_x		= (screen.width/2)-(ancho/2); 
 	   	     posicion_y		= (screen.height/2)-(alto/2); 
	 
 	   	     
 	   	    	 if ( bcate == '-'){
 	   	    	 alert('Seleccione la categoria de emergencia');
 	   	    	 }else{
 	 		   		 window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 	   	    	 }
 	   	   

 	      
	     });
 
		
});  

function exportExcelFile(workbook) {
    return XLSX.writeFile(workbook, "bookName.xlsx");
}

//----------------------------------------
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

function imprimir(){

  	
    cod    =$("#cod").val();
    accion='impre';

  	$.ajax({
       type: 'POST',
       url: "../view/gestion.php",
       data: {
       cod:cod,
       accion:accion},
       success:function(response) {}
       
    })
  }

// ir a la opcion de editar
function goToURL(id, proceso) {

	 
 

	var enlace = '../../kcrm/reportes/documento_matriz_dato?caso=' + id + '&process=' + proceso + '&doc=1';

 
	window.open(enlace,'#','width=750,height=480,left=30,top=20');

}
//----------------------
//-------------------------------------------------------------------------
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
	  
 
 
	var bparro	= $("#bparro").val();
	var btipo	= $("#btipo").val(); 
 
	var ffecha1	= $("#ffecha1").val(); 
	var ffecha2	= $("#ffecha2").val();
 
    var parametros = {
				'bparro' : bparro,  
				'btipo' : btipo ,
 				'ffecha1':ffecha1,
				'ffecha2': ffecha2
				};
 	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_repor_emer.php',
			dataType: 'json',
			cache: false,
			success: function(s){
		    console.log(s); 
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
  					'<button title="Ver informe" class="btn btn-xs" onClick="goToURL('+ s[i][9] + ','+ s[i][10]+')"><i class="glyphicon glyphicon-search"></i></button>&nbsp;' 
				]);										
			} // End For
		  } 						
		 } 
	 	});

}   
  



//-----------------
 function FormView()
 {
    
 	 
	 $("#ViewFiltro").load('../controller/Controller-' + formulario + '_filtro.php');
	 
 	 $("#ViewForma").load('../controller/Controller-' + formulario+ '.php');
	 
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

	 var url = '../../upload/uploadDoc';
	 
 
	    
	  var idprov = $('#idprov').val();

	  var ancho = 650; 
	  var alto = 320; 

	  
	  var posicion_x ; 
	  var posicion_y ; 

	  var enlace; 
	 
	  posicion_x=(screen.width/2)-(ancho/2); 

	  posicion_y=(screen.height/2)-(alto/2); 
	 
	  enlace = url+'?id='+idprov  ;
	 
	  if ( idprov) {
		  	window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

		}
	  
	} 
 //-------------------------------------------------
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
 
		 
	}
 //---------------------------
 //---------------------------------
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
	 
			 
		}