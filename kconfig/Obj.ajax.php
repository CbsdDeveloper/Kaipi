<?php
   /* Clase encargada de gestionar las conexiones a la base de datos */
class objects_ajax  {
   // private $tipo;
  // private $stmt;
  // private $array;
    private static $_instance;
	
function _ajax() {
    
echo "<script type='text/javascript'>
 function http(){
         if(typeof window.XMLHttpRequest!='undefined'){
		   return new XMLHttpRequest();    
		 }else{
		 try{
		  return new ActiveXObject('Microsoft.XMLHTTP');
		}catch(e){
		  alert('Su navegador no soporta AJAX');
		  return false;
		 }    
	  }    
  }
 function request(url,callback,params){
  var H=new http();
  if(!H)return;
	  H.open('post',url+'?'+Math.random(),true);
	  H.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	  H.onreadystatechange=function(){
	  if(H.readyState==4){
		callback(H.responseText);
		H.onreadystatechange=function(){}
		H.abort();
		H=null;
		}
	}
	var p='';
	for(var i in params){
	  p+='&'+i+'='+escape(params[i]);    
	}
	 H.send(p);
  }
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
</script>  

<script type='text/javascript'>
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
</script> 

<script type='text/javascript'>
 function open_enlace(url,variables){
  var a;
  var ab;
  ab = '?';
  if(variables==''){
	 ab = '';
  }
  location.href= url + ab +variables ;
 }
</script> 

<script type='text/javascript'>
 function open_pop(url,ovar,ancho,alto) {
  var posicion_x; 
  var posicion_y; 
  var enlace; 
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  enlace = url +'?'+ovar;
  
  window.open(enlace, '#','width='+ancho+',height='+alto+',toolbar=0,scrollbars=no,resizable=no,left='+posicion_x+',top='+posicion_y+'');
}
</script> 

<script type='text/javascript'>
 function abrirf(url,ovar,ancho,alto) {
  var posicion_x; 
  var posicion_y; 
  var enlace; 
  posicion_x=(screen.width/2)-(ancho/2); 
  posicion_y=(screen.height/2)-(alto/2); 
  enlace = url +'?'+ovar;
  window.open(enlace, '#','width='+ancho+',height='+alto+',scrollbars=no,left='+posicion_x+',top='+posicion_y+'');
}
</script> 
 <script type='text/javascript'>
function open_spop(url,ovar,ancho,alto) {
 var posicion_x; 
 var posicion_y; 
 var enlace; 
 var obj = document.getElementById('guardai');
 if (obj){
			   obj.click();   
 }
			
 posicion_x=(screen.width/2)-(ancho/2); 
 posicion_y=(screen.height/2)-(alto/2); 
 enlace = url +'?'+ovar;
 window.open(enlace,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');
  }
 </script>  
<script type='text/javascript'>
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
</script>  
<script type='text/javascript'>
// devuelve el valor
 function filtro(campo,valor_filtro) {
   document.getElementById(campo).value = valor_filtro;
}
</script> 

<script type='text/javascript'>
							function imprimir(muestra)
							{
								var ficha=document.getElementById(muestra);
								var ventimp=window.open(' ','popimpr');
								ventimp.document.write(ficha.innerHTML);
								ventimp.document.close();
								ventimp.print();
								ventimp.close();
								}
</script>

<script language='javascript'>
							 function imprimir_excel(){        
									window.open('reportes/ficheroExcel');
									window.close();
								}
</script> 

<script language='javascript'>
							 function imprimir_reporte(){        
  									window.open('ficheroreporte');
									window.close();
								}
</script>

<script language='javascript'>
function imprimir_comprobante(url){        
  		//							window.open(url);
		//							window.close();

var posicion_x; 
var posicion_y; 
ancho = 900;
alto = 520;

posicion_x=(screen.width/2)-(ancho/2); 
posicion_y=(screen.height/2)-(alto/2); 

 window.open(url,'#','width='+ancho+',height='+alto+',left='+posicion_x+',top='+posicion_y+'');

 
}
 </script>";
				 
				  return true;
}
// proteccion
// Evitamos la inyeccion SQL
function _inyeccion() {
// Modificamos las variables pasadas por URL
 foreach( $_GET as $variable => $valor ){
  $_GET [ $variable ] = str_replace ( '"' , '"' , $_GET [ $variable ]);
 }
 // Modificamos las variables de formularios
 foreach( $_POST as $variable => $valor ){
   $_POST [ $variable ] = str_replace ( '"' , '"' , $_POST [ $variable ]);
  }		
 } 
}

?>