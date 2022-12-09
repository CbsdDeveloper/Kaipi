var formulario = 'ac_bienes_componente';


//-------------------------------------------------------------------------
$(document).ready(function(){
    
   
   
		
});  
 
 
 
//-----------------------------------------------------------------
function changeAction(tipo,action,mensaje){
			
			if (tipo =="confirmar"){			 
			
			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {
			  if (e) {
				 
                 	
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
 
//----------------------------
function Mensaje(accion) {
	
	var resultado;
	
	if ( accion == 'editar')
        resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
	if ( accion == 'del')    
        resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
   
	return resultado;

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
					
				$("#id_bien").val (respuesta.id_bien);
 			 
				$("#fecha").val (respuesta.fecha);
				$("#forma_ingreso").val (respuesta.forma_ingreso);
				$("#identificador").val (respuesta.identificador);
				$("#descripcion").val (respuesta.descripcion);
		 
				$("#origen_ingreso").val (respuesta.origen_ingreso);
				$("#tipo_documento").val (respuesta.tipo_documento);
				$("#clase_documento").val (respuesta.clase_documento);
				$("#tipo_comprobante").val (respuesta.tipo_comprobante);
				$("#fecha_comprobante").val (respuesta.fecha_comprobante);
				
				$("#codigo_actual").val (respuesta.codigo_actual);
				$("#estado").val (respuesta.estado);
				$("#costo_adquisicion").val (respuesta.costo_adquisicion);
				$("#depreciacion").val (respuesta.depreciacion);
				$("#serie").val (respuesta.serie);
			
				$("#id_marca").val (respuesta.id_marca);
				
				$("#clasificador").val (respuesta.clasificador);
				$("#cuenta").val (respuesta.cuenta);
				
				$("#clase_esigef").val (respuesta.clase_esigef);
				$("#marca").val (respuesta.marca);
				
			 
				$("#valor_residual").val (respuesta.valor_residual);
				$("#anio_depre").val (respuesta.anio_depre);
				$("#vida_util").val (respuesta.vida_util);
				$("#color").val (respuesta.color);
				$("#dimension").val (respuesta.dimension);
			
				$("#uso").val (respuesta.uso);
				$("#fecha_adquisicion").val (respuesta.fecha_adquisicion);
				$("#clase").val (respuesta.clase);
			 
				$("#material").val (respuesta.material);
				$("#razon").val (respuesta.razon);
				$("#idprov").val (respuesta.idprov);
				$("#id_departamento").val (respuesta.id_departamento);
			 
				$("#tiene_acta").val (respuesta.tiene_acta);
				$("#tipo_ubicacion").val (respuesta.tipo_ubicacion);
				
				$("#detalle").val (respuesta.detalle);
				
				$("#idsede").val (respuesta.idsede);
				
				$("#detalle_ubica").val (respuesta.detalle_ubica);
				
				$("#cuenta_parametro").val (respuesta.cuenta_parametro);
 			
				$("#action").val(accion); 
			 	$("#result").html(resultado);
			 
			 	
			 	
			 	selecciona_cuenta(respuesta.cuenta);
			 	
			 	var id_modelo = respuesta.id_modelo;
			 		
			 	ListaModeloAsignado(respuesta.id_marca,id_modelo) ;
  			 	  
			 	verdocumento_bien(respuesta.id_bien);
			 
			 	
			});
 
		
	 
	
 	$('#mytabs a[href="#tab2"]').tab('show');
	  
}
  
//-------------------------------------------------------------------------
// ir a la opcion de editar
function LimpiarPantalla() {
   
	 
	$("#id_bien_componente").val("");
 	$("#id_marca_componente").val("");
	$("#detalle_componente").val("");
	$("#costo_componente").val("");
	$("#relacionado").val("");
 	$("#estado").val("");
	 
}
//-------------
function ListaModelo(idmarca) {
	   
 var parametros = {
			 'idmarca'  : idmarca  
  };
	 
	 $.ajax({
		 data:  parametros,
		 url: "../model/Model_ac_auto_lista_modelo.php",
		 type: "GET",
       success: function(response)
       {
           $('#id_modelo').html(response);
       }
	 });
	 
	 VerVariables();
	 
}
//----------------------------------------
function ListaModeloAsignado(idmarca,id_modelo) {
	   
	 var parametros = {
				 'idmarca'  : idmarca,
				 'id_modelo' :id_modelo
	  };
		 
		 $.ajax({
			 data:  parametros,
			 url: "../model/Model_ac_auto_lista_modelo.php",
			 type: "GET",
	       success: function(response)
	       {
	           $('#id_modelo').html(response);
	       }
		 });
		 
		 VerVariables();
		 
	}
//------------------------
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
//-----------------
 function printDiv(divID) {
	 
	 var objeto=document.getElementById(divID);  //obtenemos el objeto a imprimir
	 
	  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
	  
	  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
	  ventana.document.close();  //cerramos el documento
	  ventana.print();  //imprimimos la ventana
	  ventana.close();  //cerramos la ventana
        
}
