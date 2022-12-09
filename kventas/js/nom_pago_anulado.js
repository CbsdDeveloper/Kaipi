 var oTable;
   
 
//-------------------------------------------------------------------------
$(document).ready(function(){
     
		
 	  
	    $("#ViewForm").load('../controller/Controller-pago_anulado.php');
	    
  
	         
});  

function actualiza_cliente() {
	 
	
	var cuenta =	$("#cuenta").val( );
	
	 var parametros = {
			    'cuenta' : cuenta  ,
                'action' : 'visor_grid'
  };

 

$.ajax({
             data:  parametros,
              url:   '../model/Model-pago_anulado.php',
             type:  'POST' ,
             cache: false,
             success:  function (data) {

                      opener.$("#ViewFormfile").html(data);  

                 
                 } 
     });
    

     window.close();

   }
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  	     LimpiarPantalla();
                    
						$("#action").val("add");
					
					    $("#result").html("<b>AGREGAR INFORMACION DEL COMPROBANTE DE PAGO</b>");
			 		 
				 
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
  
	
	var fecha = fecha_hoy();    
	
	$("#fecha").val(fecha);
	
	$("#cuenta").val("");
	$("#detalle").val("");
	$("#autorizacion").val("");
	$("#id_anulados").val("");
	 
 
	$("#action").val("add");
 
       			   
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
 
   
			var user = $(this).attr('id');
            
           var  estado 		  = $("#estado1").val();
            var naturaleza    = $("#naturaleza1").val();
           
 
         
            var parametros = {
					'estado' : estado , 
                    'naturaleza' : naturaleza  
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_cli_clientes.php',
				dataType: 'json',
				success: function(s){
				console.log(s); 
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
 }   
 
 
 
//-----------------
function accion(id, action,estado)
{
 
	$('#action').val(action);
 
	  
   

}
  
  