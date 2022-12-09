var oTable;

var formulario = 'ac_bienes_codi';


 
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
  	 		   
 	   
	     $('#load').on('click',function(){
	 		 
	    	 BusquedaGrilla(oTable);
          
		});
	    
		$('#load1').on('click',function(){
	 		 
			BusquedaGrilla1(oTable);
		 
	   });
		
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
    nom    =$("#nom").val();

    var cadena 	= 'cod=' + cod +'&nom=' + nom;
    var ancho = 1000; 
	var alto = 400; 
	var posicion_x ; 
	var posicion_y ; 
	var enlace; 
	

    enlace= "../view/imprimir.php?"+cadena;
    
    window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
 	   	    	 

  }

// ir a la opcion de editar
function goToURL(accion,id,nom) {

	$("#nom").val(nom);



	 var parametros = {
			    'id' : id
      };
	 
  
	    if ( accion == 'barra') {
	    
	    	
	 	    $.ajax({
	 			data:  parametros,
	 			 url:   '../code/code.php',
	 			type:  'GET' ,
	 			success:  function (data) {
	 					 $("#ViewBarras").html('<img src="../code/'+data + '">');
	 					  $("#cod").val(data);

 	 				} 
	 	    });
	 	    
	 	    
	 		$('#myModalbarra').modal('show');
	    	
	    }
 
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
	  
 
 
	var vtipo_bien			= $("#vtipo_bien").val();
	var vcuenta				= $("#vcuenta").val(); 
	var Vid_departamento	= $("#Vid_departamento").val();
	var vuso				= $("#vuso").val();
	var vtiene_acta			= '-';
	var vidsede				= $("#vidsede").val();
	
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vcuenta' : vcuenta ,
				'Vid_departamento' : Vid_departamento ,
				'vuso' : vuso ,
				'vtiene_acta' : vtiene_acta ,
				'vidsede': vidsede
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ac_bienes_im.php',
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
						s[i][7],
						s[i][4],
						s[i][5],
						s[i][6],
  					'<button title="Genere codigo de Barra" class="btn btn-xs" onClick="javascript:goToURL('+"'barra'"+','+"'"+ s[i][4]  + "'"+','+"'"+ s[i][3]  + "'"+')"><i class="glyphicon glyphicon-barcode"></i></button>&nbsp;' 
				]);										
			} // End For
		  } 						
		 } 
	 	});

}   
  

function BusquedaGrilla1(oTable){       
	  
 
 
	var vtipo_bien			= $("#vtipo_bien").val();
	var vidsede				= $("#vidsede").val();
	
    var parametros = {
				'vtipo_bien' : vtipo_bien,  
				'vidsede': vidsede
				};
  
	  
 	  
		$.ajax({
		 	data:  parametros,
 		    url: '../grilla/grilla_ac_bienes_im1.php',
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
						s[i][7],
						s[i][4],
						s[i][5],
						s[i][6],
  					'<button title="Genere codigo de Barra" class="btn btn-xs" onClick="javascript:goToURL('+"'barra'"+','+"'"+ s[i][4]  + "'"+','+"'"+ s[i][3]  + "'"+')"><i class="glyphicon glyphicon-barcode"></i></button>&nbsp;' 
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