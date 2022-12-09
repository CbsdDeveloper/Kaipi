function activaTab(){

 

        $('#mytabs a[href="#tab2"]').tab('show');

  

     

};





function openNav() {

    document.getElementById("mySidenav").style.width = "250px";

  //  document.getElementById("main").style.marginLeft = "250px";

  

}



function closeNav() {

    document.getElementById("mySidenav").style.width = "0";

    document.getElementById("main").style.marginLeft= "0";

    

 

}





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

    

    document.getElementById('f1').value = today ;

    

    document.getElementById('f2').value = today ;

    

    

}

//--------------------------------------------------------------------	   

function open_pop(url,ovar,ancho,alto) {

          var posicion_x; 

          var posicion_y; 

          var enlace; 

          posicion_x=(screen.width/2)-(ancho/2); 

          posicion_y=(screen.height/2)-(alto/2); 

          enlace = url +'?'+ovar;

          

          window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

}



function changeActionE(tipo,action,mensaje){

			if (tipo =="confirmar"){			 

			  alertify.confirm("<p>"+mensaje+"<br><br></p>", function (e) {

			  if (e) {

				document.location.href = action; 

			  }

			 }); 

			}

			if (tipo =="alerta"){			 

			  alertify.alert("<b>"+mensaje+"<br><br></p>", function () {

			  });

			 }		  

			return false	  

		   }

/*-----------------------------------------------------------------

      FUNCIONES DE APOYO PERFIL DE USUARIOS  

 -------------------------------------------------------------------*/

function realizaProceso(codigo_cuenta)

	{



	var parametros = {

					'codigo_cuenta' :  codigo_cuenta 

			};

			

			$.ajax({

					data:  parametros,

					url:   '../model/ajax_CodigoCuenta.php',

					type:  'GET' ,

 					beforeSend: function () {

 							$("#cuenta").val('Procesando');

 					},

					success:  function (response) {

							 $("#cuenta").val(response);   

						 

  					} 

			});

	}

  /*-----------------------------------------------------------------

      FUNCIONES DE APOYO PERFIL DE USUARIOS  

 -------------------------------------------------------------------*/

	  function inserta_producto(articulo)

		{

  		  

           var id_asiento  =   $("#id_asiento").val();

         

         

           $( "guardaicon" ).click();

          

          

          	var parametros = {

					"articulo" : articulo ,

                    "id" : id_asiento

			};

 		 

        	$.ajax({

					data:  parametros,

					url:   'controller/ajax_detalle_asiento.php?articulo=' + articulo + '&id='+id_asiento,

					type:  'GET' ,

 					success: function(data) {

					 

		   	         $("#resultadod").html(data); 

					

                     $("#div_mistareas").load("controller/ajax_det_asiento.php?id="+id_asiento);

                    

                     

                     document.getElementById('txtcodigo').value ='';

                    

				    },

				  error: function() {

					alert( "Ha ocurrido un error" );

				  }

			}); 

            

	 	  

		}  

       

 //--------------------------------------------------------------------	

function abrirf(url,ovar,ancho,alto) {

      var posicion_x; 

      var posicion_y; 

      var enlace; 

 

      posicion_x=(screen.width/2)-(ancho/2); 

      posicion_y=(screen.height/2)-(alto/2); 

	  

      enlace = url +'?'+ovar;

      window.open(enlace, '#','width='+ancho+',height='+alto+',scrollbars=no,left='+posicion_x+',top='+posicion_y+'');

 

 }    

  //--------------------------------------------------------------------

function abrir(url,variables){

     

    

     var a;

     var ab;

     

     ab = '?';

     

     if(variables==''){

        ab = '';

     }

     

     location.href= url + ab + variables; 

      

     

}  

//--------------------------------------------------------------------

function _url(url){

     

 

     location.href= url  ; 

      

     

} 

  //--------------------------------------------------------------------

function abrirAsientos(url,variables){

     

    

     var a ;

     var ab ;

     

    

     

     a = $("#idprov").val();

     

     

     ab = '?idReferencia=' +  a;

      

      

     location.href= url + ab ; 

      

        /*

        	request(url,function(r){

        	 location.href= url + ab +variables; 

        	},{})

            */

}   

 /*-----------------------------------------------------------------

      FUNCIONES DE APOYO PERFIL DE USUARIOS  

 -------------------------------------------------------------------*/

//--------------------------------------------------------------------	

function imprimir_excel(){        

	window.open('reportes/ficheroExcel');

    window.close();

}

//--------------------------------------------------------------------

    function open_enlace(url,variables){

      var a;

      var ab;

      ab = '?';

      if(variables==''){

    	 ab = '';

      }

      location.href= url + ab +variables ;

     }	 

//--------------------------------------------------------------------	  

function anexosT(url){

         

          var idanexos = document.getElementById('id_compras').value  ;

          var posicion_x; 

          var posicion_y; 

          var enlace; 

          

          var ancho = 1024;

          var alto = 560;

          posicion_x=(screen.width/2)-(ancho/2); 

          posicion_y=(screen.height/2)-(alto/2); 

        

           

        //  enlace = url +'?'+ovar;

          enlace = '../ktributacion/comprasc_cxp?action=editar&tid='+idanexos+'#tab2';

          

          window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');

          

   

          

	}	

 

function aprobacionc(url){

         

         var obj = document.getElementById("guardai");

         

         document.getElementById('action').value = 'aprobacion';

 

         var accion = document.getElementById('action').value;

          

         alert('VA A REALIZAR LA APROBACION DE LA TRANSACCION!!! ' + accion);

            

         if (obj){

                   obj.click();   

         }

			

	}     

 //--------------------------------		

function anular_pago(url){

         

            document.getElementById('action').value = 'anular';

 

           	alert('VA A REALIZAR LA ANULACION DE LA TRANSACCION!!!');

            

            var obj = document.getElementById("guardaicon");

			if (obj){

			   obj.click();   

			}

	}		

	

function eliminar_pago(url){

         

            document.getElementById('action').value = 'del';

 

           	alert('VA A REALIZAR LA ELIMINAR DE LA TRANSACCION!!!');

            

            var obj = document.getElementById("guardaicon");

			if (obj){

			   obj.click();   

			}

	}

//--------------------------------------------------------------------	

function open_spop(url,ovar,ancho,alto) {

         var posicion_x; 

         var posicion_y; 

         var enlace; 

	 	 
         posicion_x=(screen.width/2)-(ancho/2); 

         posicion_y=(screen.height/2)-(alto/2); 

         enlace = url +'?'+ovar;

         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

 

 }

//--------------------------------------------------------------------	

function open_spop_doc(url,ovar,ancho,alto) {

         var posicion_x; 

         var posicion_y; 

         var enlace; 

		 

         var fecha = document.getElementById('fecha1').value;

         

         var transaccion = document.getElementById('transaccion').value;

         

        

        			

         posicion_x=(screen.width/2)-(ancho/2); 

         posicion_y=(screen.height/2)-(alto/2); 

         

         enlace = url +'?tipo='+ transaccion + '&dat='+ fecha;

         

         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

 

 }	



//--------------------------------------------------------------------	

function open_spop_parametro(url,ovar,ancho,alto,codigo_var) {

         var posicion_x; 

         var posicion_y; 

         var enlace; 

       

         var obj = document.getElementById('guardai');

         

 	  /*   if (obj){

        			   obj.click();   

        }

      */  

         var referencia = document.getElementById(codigo_var).value;

        			

         posicion_x=(screen.width/2)-(ancho/2); 

         posicion_y=(screen.height/2)-(alto/2); 

         

 

         

         if (codigo_var.length > 3)

         {

           enlace = url +'?'+ovar+'&opc='+referencia;

         }

         else

         {

             enlace = url +'?'+ovar;

         }

         

         window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

 

 }

// valida saldo liquidacion de facturaas

	 function valida_saldo(obj,valor,total){

			 

			 var nombre = obj.id  

 			 

				if (valor > total){

						alert('valor excede al total');

						document.getElementById(nombre).value = 0;

						return 0;

				}

				return true;

		}

  // seleccion de pagos		

function seleccion(cambio,codigo)

	{

  	  var tipo =  cambio.is(':checked');

      var parametros = {

					'tipo' : tipo,

					'codigo' : codigo

 	  };

 	  $.ajax({

					data:  parametros,

					url:   'controller/ajax_cpago.php?tipo=' + tipo + '&codigo=' + codigo ,

					type:  'GET' ,

 					beforeSend: function () { 

 							$("#che").val('Procesando');

  					},

					success:  function (response) {

							 $("#che").val(response);  // $("#cuenta").html(response);

 							  

  					} 

			}); 

	}

	/////////////

		function _monto_basecxc(){

    		  //// base imponible  ,baseImpGrav,

    		  var base0 =  parseFloat(document.getElementById('baseimponible').value)

			  var base1 =  parseFloat(document.getElementById('baseimpgrav').value) 

			  var base2 =  parseFloat(document.getElementById('montoiva').value) 

              

   			  var base3 =  parseFloat(document.getElementById('basenograiva').value) 

			  

			  var base4 =  parseFloat(document.getElementById('valorretrenta').value) 

			  var base5 =  parseFloat(document.getElementById('valorretiva').value) 

 

			  var baser  =  ( base4 + base5 )   ;

 

         	  var base  =  (base1 +  base2 + base0 + base3 )   ;

			  

			   var basec  =  (base - baser )   ;

              

 			  document.getElementById('totalf').value = base;

			  

			  var decimales = 2

			  

			  var flotante = parseFloat(basec);

			  

			  var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);

 			 

			   document.getElementById('totalc').value = resultado;

 		}   

 /////////////

		  

 //---- agrega retencion

function genera_asientocxc()

	{

  	 

      var id_asiento  = document.getElementById("id_asiento").value;  

     

      var enlace = 'controller/ajax_asientocxc.php?id='+id_asiento;

	  

	  window.open(enlace,'#','width=10,height=10,left=150,top=120');

 	 

	}			

 

function ir(){ 

  window.parent.scrollTo (0,0);

}	

/////////////////////---

function busca_cheque(tipo)

	{

 	  var fidbancos = $("#idbancos").val();
 	 	 

	 var parametros = {
 					'tipo'     : tipo,
 					'fidbancos': fidbancos
  	};

			

			$.ajax({

					data:  parametros,

					url:   '../model/Model-co_pagos_tipo.php',

					type:  'GET' ,

 					beforeSend: function () { 

 							$("#cheque").val('Procesando');

  					},

					success:  function (response) {

							 $("#cheque").val(response);  // $("#cuenta").html(response);

 							  

  					} 

			});

			

		 

	}

//---- agrega retencion

//*****---------------------------------------------------

function _agrega_retencion()

	{

  			// var obj = document.getElementById('guardai');

			// if (obj){

			//	obj.click();   

			// }

 	  var id_asiento  = document.getElementById('id_asiento').value;

      var baseimpair = document.getElementById("baseimpair").value; 

	  var codretair  = document.getElementById("codretair").value;

	  var id_compras = document.getElementById("id_compras").value;

	  var secuencial = document.getElementById("secuencial").value;

 			  

	 alert('Agrega retencion:' + codretair);

	 

	  var enlace = 'controller/ajax_retencion.php?codretair=' + codretair + '&baseimpair=' + baseimpair +

			 								   '&id_compras=' + id_compras + '&secuencial=' + secuencial+ '&id_asiento=' + id_asiento;

											   

     	  window.open(enlace,'#','width=10,height=10,left=30,top=20');

 	 

	}	

//---- agrega retencion

function _genera_asiento()

	{

  	 

    var id_asiento  = document.getElementById('id_asiento').value;

	  

	var enlace = 'controller/ajax_asientocxp.php?tid='+id_asiento;

											   

    window.open(enlace,'#','width=10,height=10,left=30,top=20');

 	 

	}	



//---- agrega retencion

function impresion(enlace,codigo_x1)

	{

  	 

	 var id_asiento  = document.getElementById(codigo_x1).value;  
      

	  enlace = enlace +id_asiento;

											   

     	  window.open(enlace,'#','width=750,height=480,left=30,top=20');

 	 

	}	

//---- agrega retencion

function vinculo(enlace,codigo_x1)

	{

  	 

    

     

 	 var id_asiento  = document.getElementById(codigo_x1).value;  

     

	  enlace = enlace +  id_asiento;

											   

      window.open(enlace,'#','width=750,height=450,left=80,top=20');

 	 

	}

function saldos()

	{

		

        

            alert('Verificando');

            

			$.ajax({

					

					url:   'co_saldos.php',

					type:  'GET' ,

 					beforeSend: function () {

 							$("#SALDOSF").val('Procesando, espere por favor...');

 					},

					success:  function (response) {

							 $("#SALDOSF").html(response);  // $("#cuenta").html(response);

							  

  					}  

			});

	}   

 /*-----------------------------------------------------------------

      FUNCIONES DE APOYO PERFIL DE USUARIOS  

 -------------------------------------------------------------------*/



		

// impresion de tab2		area

function imprSelec(muestra,TITULO,f1,f2)

    {

		

      var fecha1  = document.getElementById(f1).value;  

	  var fecha2  = document.getElementById(f2).value;  



	  var TituloFecha = '<h4>' + 'Periodo ' + fecha1 + ' al ' + fecha2  + '</h4>';

	    		

			

	  var printContents = document.getElementById(muestra).innerHTML;

	  

      var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva

	  

	  var estilo = '<style type="text/css">body,td,th {font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;font-size: 11px;}table {border-collapse:collapse}td {border:1px solid black}th {border:1px solid black}</style>';

	   

	  

	  ventana.document.body.innerHTML = estilo + '<h4>' +TITULO + '</h4>' + TituloFecha + printContents;

	

	  ventana.print();  //imprimimos la ventana

	  

	  ventana.close();  //cerramos la ventana

	 

	  

	}                                 

// impresion de tab2		area

function tableToExcel(muestra,TITULO,f1,f2)

    {

	

	 

	

 	    var dt = new Date();

        var day = dt.getDate();

        var month = dt.getMonth() + 1;

        var year = dt.getFullYear();

        var hour = dt.getHours();

        var mins = dt.getMinutes();

        var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;

        //creating a temporary HTML link element (they support setting file names)

        var a = document.createElement('a');

        //getting data from our div that contains the HTML table

		

  		

        var data_type = 'data:application/vnd.ms-excel; charset=utf-8';

        

  		var table_div = document.getElementById(muestra);

        

		var table_html = table_div.outerHTML.replace(/ /g, '%20');

		

	 

        a.href = data_type + ', ' +  table_html;



        //setting the file name

        a.download = 'Datos_' + postfix + '.xls';

        //triggering the function

        a.click();

        //just in case, prevent default behaviour

        e.preventDefault();

	   	  

	  

	  

	} 	