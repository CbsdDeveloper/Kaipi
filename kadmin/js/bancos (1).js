$(function(){
      
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
 
});



var oTableGrid;  
var oTable ;

//-------------------------------------------------------------------------
$(document).ready(function(){
    
        oTable = $('#jsontable').dataTable( {
	        "paging":   false,
	        "ordering": false,
	        "info":     false
	    } );
       
  
       
		$("#MHeader").load('../view/View-HeaderModel.php');
	
		$("#FormPie").load('../view/View-pie.php');
		
		modulo();
 		
	    FormView();
	    
	    FormFiltro();
   		    
	  
 		
	   $('#load').on('click',function(){
 		   
            BusquedaGrilla(oTable);
  			
		});
 
	   
	   $("#btnExport").click(function(e) {
	        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#imprime').html()));
	        e.preventDefault();
	    });
	   
 
	   
	   $('#cmd').click(function () {
		   	
		   pruebaDivAPdf();
		
	   });
	   
	   
	   $("#bimpresion").click(function(e) {
		   
		   
          var nombreDiv = 'imprime';
		   
		   var    contenido= document.getElementById(nombreDiv).innerHTML;
		    
		    var contenidoOriginal= document.body.innerHTML;
		    
		  
		    document.body.innerHTML = contenido;

		    window.print();

		    document.body.innerHTML = contenidoOriginal;
	 

	   });
 
 //-----------------------------------------------------------------

});  
//-----------------------------------------------------------------
 
function pruebaDivAPdf() {
	
	   var posicion_x; 
       var posicion_y; 
       var enlace; 
       var ancho = 770;
        var alto    = 470;
	    			
       posicion_x=(screen.width/2)-(ancho/2); 
       
       posicion_y=(screen.height/2)-(alto/2); 
 	  
       var ffecha1    = $("#ffecha1").val();
       
	  var ffecha2    = $("#ffecha2").val();
	  
	  var idbancos = $("#idbancos").val();
	   
       enlace =  '../reportes/librobancos.php?ffecha1='+ffecha1+'&ffecha2=' + ffecha2 + '&idbancos=' + idbancos;
       
       window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
    
}

function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
			  		$('#mytabs a[href="#tab2"]').tab('show');
                	
                    LimpiarPantalla();
                    
                    accion(0,'');
                    
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
 
   
//-------------------------------------------------------------------------
//ir a la opcion de editar
function validaPantalla() {

	var valida = 1;
 
 
	 	
	 return valida;

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
 
//----------- bancos
 function saldo_banco(ffecha1,ffecha2,idbancos) {

 
	 
	var parametros = {
					'ffecha1' : ffecha1 ,
                    'ffecha2' : ffecha2 ,
                    'idbancos' : idbancos
 	  };
	
	  $.ajax({
					data:  parametros,
					url:   '../grilla/grilla_saldo-banco.php',
					type:  'GET' ,
					cache: false,
					beforeSend: function () { 
 							$("#cbanco").html('Procesando');
  					},
					success:  function (data) {
							 $("#cbanco").html(data);   
							 
						 
  					} 
			}); 
	  
	 
     }
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        	 

	 //  var oTable = $('#jsontable').dataTable();  //Initialize the datatable
		var user = $(this).attr('id');
    
	  var ffecha1    = $("#ffecha1").val();
	  var ffecha2    = $("#ffecha2").val();
	  var idbancos = $("#idbancos").val();
	       
	   	
      var parametros = {
				'ffecha1' : ffecha1  ,
				'ffecha2' : ffecha2  ,
				'idbancos' : idbancos  
      };

		if(user != '') 
		{ 
		$.ajax({
		 	data:  parametros,
		    url: '../grilla/grilla_bancos.php',
			dataType: 'json',
			cache: false,
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
                      '<p align="right">' +  formatNumber.new(s[i][6], "") + '</p>' ,
                      '<p align="right">' +  formatNumber.new(s[i][7], "") + '</p>' ,
                      '<p align="right">' +  formatNumber.new(s[i][8], "") + '</p>' ,
                  ]);									
			} // End For
							
										
			},
			error: function(e){
			   console.log(e.responseText);	
			}
			});
		}
		
		
		saldo_banco(ffecha1,ffecha2,idbancos) ;
		
 

  }   
//--------------
  
//------------------------------------------------------------------------- 
 function modulo()
 {
 	 var modulo =  'kcontabilidad';
 	 var parametros = {
			    'ViewModulo' : modulo 
    };
 	$.ajax({
			data:  parametros,
			 url:   '../model/Model-moduloOpcion.php',
			type:  'GET' ,
			cache: false,
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
    

	 $("#ViewForm").load('../controller/Controller-co_asientos.php');
      

 }
 
 
 
//----------------------
 function FormFiltro()
 {
  
	 $("#ViewFiltro").load('../controller/Controller-bancos_filtro.php');
	 
 }
   