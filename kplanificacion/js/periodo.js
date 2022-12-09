$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});

var oTable;

//-------------------------------------------------------------------------
$(document).ready(function(){
 
	
	$("#MHeader").load('../view/View-HeaderModel.php');
	
	modulo();
 
	FormView();
    
	$("#FormPie").load('../view/View-Pie.php');
    
   
	 oTable 	= $('#jsontable').dataTable( {      
         searching: true,
         paging: true, 
         info: true,         
         lengthChange:true ,
         aoColumnDefs: [
		      { "sClass": "highlight", "aTargets": [ 0 ] },
		      { "sClass": "de", "aTargets": [ 1 ] }
		    ] 
      } );

	 BusquedaGrilla(oTable);
 
     $('#load').on('click',function(){
 
     	 BusquedaGrilla(oTable);
       
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
function goToURL(action,id) {
 
 
	 var visor= 'S';
	
	 
	 
     var parametros = {
					'action' : action ,
                    'id' : id ,
                    'visor': visor
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-periodo.php',
					type:  'POST' ,
 					beforeSend: function () { 
 							$("#result").html('Procesando');
  					},
					success:  function (data) {
							 $("#result").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
//-----------------------------------------
function accion(id,modo)
{
  
			$("#action").val(modo);
			
	        $("#idperiodo").val(id);          

			BusquedaGrilla(oTable );

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
  function BusquedaGrilla(oTable){        
 
 
     var today = new Date();
     var yyyy = today.getFullYear();
 	 var ANIO1 	= yyyy;
            
       
            var parametros = {
					'ANIO1' : ANIO1  
					 
  	       };
      
			 
 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_periodo.php',
				dataType: 'json',
				success: function(s){
				console.log(s); 
						oTable.fnClearTable();
							for(var i = 0; i < s.length; i++) {
							 oTable.fnAddData([
								s[i][0],
								s[i][1],
								s[i][2],
       	                        s[i][3],
                                s[i][4],
                                s[i][5],
                               	'<button class="btn btn-xs btn-warning" onClick="goToURL('+"'editar'"+','+ "'" + s[i][6] +"'"  +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs btn-danger" onClick="goToURL('+"'del'"+','+  "'" +  s[i][6]  +"'" +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
											
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
 
			
 }   
 ///////////////////////////////////
 
function modulo()
{
 

	 var modulo =  'kplanificacion';
		 
	 var parametros = {
			    'ViewModulo' : modulo 
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
//----------------

function validaAnio(fechavar)
{
 
   
	var fecha = fechavar; // aca tenes que remplazar por tus datos
 	 
 
	
	var array_fechasol = fecha.split("/")  //esta linea esta bien y te genera el arreglo
	var ano = parseInt(array_fechasol[0]); // porque repites el nombre dos veces con una basta
	 
	 
 
     $('#ANIO').val(ano);

}
//-----------------
function FormView()
{
   
	 $("#ViewFiltro").load('../controller/Controller-periodo_filtro.php');
	 
	 $("#ViewForm").load('../controller/Controller-periodo.php');
     
	
	 

}   