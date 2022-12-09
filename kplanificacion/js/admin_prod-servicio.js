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
     
       oTable = $('#jsontable').dataTable(); 
	    
	    BusquedaGrilla( oTable);
 	    
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
function goToURL(accion,id) {
 
 
	
     var parametros = {
					'accion' : accion ,
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-admin_prod-servicio.php',
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
  
 
               
                    $("#idproducto").val("");
                    $("#tipo").val("");
                    
                    $("#idbodega").val("");
                    $("#idcategoria").val("");
                    $("#idmarca").val("");
                    $("#unidad").val("");
                    $("#producto").val("");
                    $("#referencia").val("");
                    $("#estado").val("");
                    $("#facturacion").val("");
                    $("#costo").val("");
                    $("#tributo").val("");
                    $("#cuenta_ing").val("");
                    $("#cuenta_inv").val("");
                  
                    $("#url").val("");
       			   
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
    
    document.getElementById('fechatarea').value = today ;
    
    document.getElementById('fechafinal').value = today ;
    
    $("#tarea").val("");
	
    $("#tareaproducto").val("");
            
} 
 
  //------------------------------------------------------------------------- 
  function BusquedaGrilla(oTable){        
 
   
			var user = $(this).attr('id');
            
           	var GrillaCodigo = $("#tipo1").val();
            var idcategoria1 = $("#idcategoria1").val();
            var idbodega1    = $("#idbodega1").val();
            var facturacion1 = $("#facturacion1").val();
          
         
            if (!(GrillaCodigo))  { GrillaCodigo = 'S';}
            if (!(idcategoria1))  { idcategoria1 = 0;}
            if (!(idbodega1))  { idbodega1 = 0;}
            if (!(facturacion1))  { facturacion1 = 'S';}
            
         
            var parametros = {
					'GrillaCodigo' : GrillaCodigo , 
                    'idcategoria1' : idcategoria1 , 
                    'idbodega1' : idbodega1 , 
                    'facturacion1' : facturacion1 
 	       };
      
			if(user != '') 
			{ 
			$.ajax({
			 	data:  parametros,  
			    url: '../grilla/grilla_admin_prod-servicio.php',
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
                              	'<button class="btn btn-xs" onClick="javascript:goToURL('+"'editar'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;' + 
								'<button class="btn btn-xs" onClick="javascript:goToURL('+"'del'"+','+ s[i][0] +')"><i class="glyphicon glyphicon-remove"></i></button>' 
							]);										
						} // End For
											
				},
				error: function(e){
				   console.log(e.responseText);	
				}
				});
			}
 }   
 
 function imagenfoto(urlimagen)
{
 
  
   var path_imagen = '../../kimages/' + urlimagen ;
 
    imagenid = document.getElementById("ImagenUsuario");
    
    imagenid.src = path_imagen;
     

}
//-------------------------------------------------------------------------
// ir a la opcion de editar
function goToPrecio() {
 
     id =   $('#idproducto').val();
 
     var parametros = {
                    'id' : id 
 	  };
	  $.ajax({
					data:  parametros,
					url:   '../model/Model-ajax_precio.php',
					type:  'GET' ,
 					beforeSend: function () { 
 							$("#precio_grilla").html('Procesando');
  					},
					success:  function (data) {
							 $("#precio_grilla").html(data);  // $("#cuenta").html(response);
						     
  					} 
			}); 

    }
  //--------------------------------------------------------------------	
function open_precio(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
 
         id =   $('#idproducto').val();
  
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         
         posicion_y=(screen.height/2)-(alto/2); 
         
         enlace = url + '?id='+ id;
         
         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
 
 }	  

function modulo()
{
 

	 var modulo =  'kadmin';
		 
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
//-----------------
function FormView()
{
   
	 
	 $("#ViewForm").load('../controller/Controller-admin_prod-servicio.php');
     

}
//----------------------
function FormFiltro()
{
 
	$.ajax({
 			 url:   '../controller/Controller-admin_prod-servicio_filtro.php',
			type:  'GET' ,
				beforeSend: function () { 
						$("#ViewFiltro").html('Procesando');
				},
			success:  function (data) {
					 $("#ViewFiltro").html(data);  // $("#cuenta").html(response);
				     
				} 
	});
     

}

  