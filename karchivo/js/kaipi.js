function activaTab(){
 
	 
	 
	 $('#mytabs a[href="#tab2"]').tab('show');
  
     
};


function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
  //  document.getElementById("main").style.marginLeft = "250px";
  
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
  //  document.getElementById("main").style.marginLeft= "0";
    
 
}
 function activaTabP(tab1){
 
 		 
		
        $('#mytabs a[href="#'+tab1+'"]').tab('show');
  
     
}; 

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
function Hoy()
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

function popup2(url,ancho,alto) {
var posicion_x; 
var posicion_y; 
posicion_x=(screen.width/2)-(ancho/2); 
posicion_y=(screen.height/2)-(alto/2); 
window.open(url, "#", "width="+ancho+",height="+alto+",menubar=0,toolbar=0,directories=0,scrollbars=no,resizable=no,left="+posicion_x+",top="+posicion_y+"");
}

function changeAction_url(action)
  {
           document.location.href = action; 
		   return true;
  }
 
 function retorna_valor2(symbol) {
 
   var valor = document.getElementById(symbol).value;
 
    //window.opener.form1.formulario.url.value = valor;
 	  window.opener.document.getElementById('url').value = valor;
	  window.top.close(); 	 
	  window.close();
}

  function url_editor() { 
	var URL_ubicacion;
    // URL_ubicacion = 'http://localhost/_Web/enriqueztorres/js/ckfinder' ;
     //   URL_ubicacion = 'http://www.enriqueztorres.com/keditor/ckfinder' ;
    //var URL_ubicacion = 'http://186.66.135.44/joyeria/keditor/ckfinder' ;
    //var URL_ubicacion = 'http://localhost/kaipi/keditor/ckfinder' ;
 
   // URL_ubicacion = 'http://www.mendozacontadores.com.ec/keditor/ckfinder/' ;
	//  http://186.66.135.43/kaipi-p/kimages/ http://fasca.org.ec/kimages/
	
	URL_ubicacion = 'http://181.39.51.179/kaipi-p/keditor/ckfinder' ;
  
 
  	return URL_ubicacion;
 	
}  
 //--------------------------------------------------------------------
function abrir(url,variables){
        	var a;
        	var ab;
        	ab = '?';
        	if(variables==''){
        	 ab = '';
        	}
        	request(url,function(r){
        	 location.href= url + ab +variables; 
        	},{})
}
//--------------------------------------------------------------------	   
      function abrir_menu(url,variables){
          var a;
          var ab;
          ab = '?';
          if(variables==''){
        	ab = '';
          }
          request(url,function(r){
          window.open(url + ab +variables,'iframe');
          },{})
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
function open_pop(url,ovar,ancho,alto) {
          var posicion_x; 
          var posicion_y; 
          var enlace; 
          posicion_x=(screen.width/2)-(ancho/2); 
          posicion_y=(screen.height/2)-(alto/2); 
          enlace = url +'?'+ovar;
          
          window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
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
function open_spop(url,ovar,ancho,alto) {
         var posicion_x; 
         var posicion_y; 
         var enlace; 
		 
         var obj = document.getElementById('guardai');
         
		 //if (obj){
        	//		   obj.click();   
         //}
        			
         posicion_x=(screen.width/2)-(ancho/2); 
         posicion_y=(screen.height/2)-(alto/2); 
         enlace = url +'?'+ovar;
         window.open(enlace,
        		 	 '#',
        		 	 'width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+',toolbar=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');
 
       
 }	
 //--------------------------------------------------------------------
 function openpop(url,ovar,ancho,alto,objcodigo) {
   var posicion_x; 
   var posicion_y; 
   var dato_id; 
         
   dato_id = document.getElementById(objcodigo).value;
        	
   if (dato_id > 0){
             posicion_x=(screen.width/2)-(ancho/2); 
        	 posicion_y=(screen.height/2)-(alto/2); 
        	 enlace = url +'?'+ovar;
        	  if (document.getElementById('guardai').click()){
        	  }
        
        	 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
        
   }
   else {
     if (document.getElementById('guardai').click()){
     }
   } 
 }
//--------------------------------------------------------------------	
 function filtro(campo,valor_filtro) {
           document.getElementById(campo).value = valor_filtro;
 }
//--------------------------------------------------------------------	
function imprimir(muestra)
    	{
    	  var ficha=document.getElementById(muestra);
    	  var ventimp=window.open(' ','popimpr');
    	      ventimp.document.write(ficha.innerHTML);
    		  ventimp.document.close();
    		  ventimp.print();
    		  ventimp.close();
    	}	
//--------------------------------------------------------------------	
function imprimir_excel(){        
	window.open('reportes/ficheroExcel');
    window.close();
}	
//--------------------------------------------------------------------	
function imprimir_reporte(){        
  window.open('ficheroreporte');
  window.close();
}	
//-------------------------------------------------------------------- 
 function imprimir_comprobante(url){        
    var posicion_x; 
    var posicion_y; 
    ancho = 900;
    alto = 520;
    
    posicion_x=(screen.width/2)-(ancho/2); 
    posicion_y=(screen.height/2)-(alto/2); 
    
     window.open(url,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
    
 }
//--------------------------------------------------------------------
function open_opcion(url,variables,nombre){
  			var a;
			var ab;
  		 //	document.getElementById('lbltipAddedComment').innerHTML = nombre;
			
	 		var miFrame=document.getElementById('miFrame');
 			ab = '?';
			if(variables==''){
				ab = '';
			}
 			enlace = 	url + ab +variables;
 			miFrame.src=enlace;
}
//------------------------------------------------------
  function open_forma() {
    		  var cata_url  = document.getElementById("cata").value;
    		  location.href= cata_url ;
 } 
//--------------------------------------------------------------------	
function confirmacion(){ 
	if (confirm("¿Estas seguro de enviar este formulario?")){ 
   			    $("#formulario").submit();														 
    }	
}	

//--------------------------------------------------------------------


