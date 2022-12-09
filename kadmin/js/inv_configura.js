 var oTable;
  
 


//-------------------------------------------------------------------------
$(document).ready(function(){
    
	
	 oTable 	= $('#jsontable').dataTable( {      
         searching: true,
         paging: true, 
         info: true,         
         lengthChange:true ,
         aoColumnDefs: [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "de", "aTargets": [ 3 ] }
		    ] 
      } );
	 
	
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		modulo();
 		
	    FormView();
	    
		$("#FormPie").load('../view/View-pie.php');
   		
		  
		BusquedaGrilla( oTable,'basico');
 		
 	   $('#load').on('click',function(){
 	 		 
 		   			BusquedaGrilla(oTable,'-');
          
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
					
					$("#result").html('<img src="../../kimages/z_add.png" align="absmiddle"/><b> AGREGAR NUEVO REGISTRO</b>');
					 
					 
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
					url:   '../model/Model-inv_configura.php',
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
  
	﻿$("#tipo").val("");
	$("#carpeta").val("");
	$("#modulo").val("");
	$("#carpetasub").val("");
	$("#formato").val("");
	
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
  function BusquedaGrilla(oTable,otipo){        	 

	var param;

	if ( otipo == '-'){   

		param = 	$("#param").val();         

	} 	else {  

		param = otipo;
 
    } 


	var parametros = {
		'param' : param  
};


 	 
		$.ajax({
			data:  parametros,
 		    url: '../grilla/grilla_inv_configura.php',
			dataType: 'json',
			success: function(s){
		//	console.log(s); 
			oTable.fnClearTable();
			for(var i = 0; i < s.length; i++) {
			    	oTable.fnAddData([
							s[i][0],
							'<b>' + s[i][1] + '</b>',
							'<b>' + s[i][2] + '</b>',
							'<b>' + s[i][3] + '</b>',
                            s[i][4],
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
  function GuardaDatosGuia()
  {
	  
	  var parametros = {
				'accion' : 'copiar'  
      };
  
	  $.ajax({
				data:  parametros,
				url:   '../model/Model-inv_configura.php',
				type:  'GET' ,
				beforeSend: function () { 
						$("#result").html('Procesando');
				},
				success:  function (data) {
						 $("#result").html(data);  // $("#cuenta").html(response);
					     
						 alert(data);
				} 
		}); 
	  
  }
// -----------------------
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
 
//-----------------------------------------
 function accion(id,modo)
 {
   
 			$("#action").val(modo);
 			
 			$("#tipo").val(id);          

			var param = 	$("#param").val();         

 			BusquedaGrilla(param );

 }
//-----------------
 function FormView()
 {
    

	 $("#ViewForm").load('../controller/Controller-inv_configura.php');
      

 }
    
  