

$(document).ready(function(){

  	$("#NavMod").load('../view/View-HeaderMain.php');
	
 	$("#FormPie").load('../view/View-pie.php');

    $("#viewform").load('../controller/Controller_micombustible.php');
 
	Busqueda(); 
	 
	 
 
 
 
});
//--------------
function Busqueda(  ){
	
 	 						 
    									$.ajax({
    										    type:  'GET' ,
     											url:   '../model/Model_reportes_presupuesto.php',
     											success:  function (response) {
     													 $("#viewformResultado").html( response );  
     													 
    											} 
    									});
	 
 
} 
  