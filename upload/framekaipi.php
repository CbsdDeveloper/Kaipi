<?php 
 
  if (isset($_POST['tipo'])){ // eventos de gestiÃ³n
  	 $textocadenaobj = $_POST['textoedicion'];
         
	 if ($_POST['tipo'] == 'CA'){
		tipoA($_POST['textoedicion']);
	  }	
	 if ($_POST['tipo'] == 'EE'){
		tipoEE($_POST['textoedicion']);
	 }
     if ($_POST['tipo'] == 'AA'){
		tipoAA($_POST['textoedicion']);
	 }
 	 if ($_POST['tipo'] == 'LI'){
		tipol($_POST['textoedicion']);
	 }     
        
 }
//------------------------------------------------------------------ 
function tipoA($textocadena){
        
    
    $textocadena = trim($textocadena);
	
	$columnasO = explode("FROM", $textocadena); 
	
	$NuevaCadena =  ($columnasO[0]);
 
	$columnas1 = explode("SELECT",  ($NuevaCadena) ); 
	
	$CadenaCampos =  ($columnas1[1]);
	
	
	$columnas1 = explode("," ,  ($CadenaCampos) ); 
	
	$nroColumnas = count($columnas1);
     
	echo "qquery = array( " ;
	 for ($row = 0; $row <= $nroColumnas; $row++)
    {
     
	 	  $cadenaJava = $cadenaJava. "array( campo => '".trim($columnas1[$row])."',".'&nbsp;&nbsp;'." valor => '".
		  				'-'."',".'&nbsp;&nbsp;'."filtro => 'N', ".'&nbsp;&nbsp;'."visor => 'S'),"."<br>";
 
    }
 
       
	$result = $cadenaJava.' ); '; 
       
    echo $result; 
  
  }	
  //------------------------------------------------------------------ 
function tipoEE($textocadena){
    
     
    $textocadena = trim($textocadena);
	
	$columnasO = explode("FROM", $textocadena); 
	
	$NuevaCadena =  ($columnasO[0]);
 
	$columnas1 = explode("SELECT",  ($NuevaCadena) ); 
	
	$CadenaCampos =  ($columnas1[1]);
	
	
	$columnas1 = explode("," ,  ($CadenaCampos) ); 
	
	$nroColumnas = count($columnas1);
     
	//$_POST["cheque"]
	 
	echo "UpdateQuery = array( " ;
	 for ($row = 0; $row <= $nroColumnas; $row++)
    {
     
	      $variable = '$_POST["'.trim($columnas1[$row]).'"]';
		 
	 	  $cadenaJava = $cadenaJava. "array( campo => '".trim($columnas1[$row])."',".'&nbsp;&nbsp;'." valor => ".
		  				 $variable.",".'&nbsp;&nbsp;'."filtro => 'N'),"."<br>";
 
    }
	
	 
	$result = $cadenaJava.' ); '; 
 
      
    echo $result; 
         
                 
  }	
  
  //------------------------------------------------------------------ 
function tipol($textocadena){
        
    
    $textocadena = trim($textocadena);
	
	$columnasO = explode("FROM", $textocadena); 
	
	$NuevaCadena =  ($columnasO[0]);
 
	$columnas1 = explode("SELECT",  ($NuevaCadena) ); 
	
	$CadenaCampos =  ($columnas1[1]);
	
	
	$columnas1 = explode("," ,  ($CadenaCampos) ); 
	
	$nroColumnas = count($columnas1);
     
 
	 for ($row = 0; $row <= $nroColumnas; $row++)
    {
     
    //    $("#id_periodo").val("0");
     
	 	  $cadenaJava = $cadenaJava. '$("#'.trim($columnas1[$row]).'").val("");'."<br>"; 
 
    }
 
       
	$result = $cadenaJava; 
       
    echo $result; 
  
  }	
  
    //------------------------------------------------------------------ 
function tipoAA($textocadena){
    
     
    $textocadena = trim($textocadena);
	
	$columnasO = explode("FROM", $textocadena); 
	
	$NuevaCadena =  ($columnasO[0]);
 
	$columnas1 = explode("SELECT",  ($NuevaCadena) ); 
	
	$CadenaCampos =  ($columnas1[1]);
	
	
	$columnas1 = explode("," ,  ($CadenaCampos) ); 
	
	$nroColumnas = count($columnas1);
     
	//$_POST["cheque"]
	 
	echo "InsertQuery = array( " ;
	 for ($row = 0; $row <= $nroColumnas; $row++)
    {
     
	      $variable = '@$_POST["'.trim($columnas1[$row]).'"]';
		 
	 	  $cadenaJava = $cadenaJava. "array( campo => '".trim($columnas1[$row])."',".'&nbsp;&nbsp;'." valor => ".
		  				 $variable."),"."<br>";
 
    }
	
	 
	$result = $cadenaJava.' ); '; 
 
      
    echo $result; 
         
                 
  }	S
 ?> 