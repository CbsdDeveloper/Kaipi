<?php
    
 /* Clase encargada de gestionar las conexiones a la base de datos */
class objects_list  {
   // private $array;
private static $_instance;
// lista manual
function KP_lista($titulo,$MATRIZ,$variable,$datos,$required,$disabled){	
 
  
    
$titulo = utf8_encode(utf8_decode($titulo)); 

  if ($required=='required')
	$required =' required '; 
  else	
    $required =''; 
  
  if ($disabled =='disabled')
	$readonly = ' disabled="disabled" '; 
  else	
	$readonly =' '; 
  if (empty($titulo)){
	 $titulo1 = '';
	 $td = '';
	 $td1 = '';
   }else{
	$titulo1 ='<td align="right">'.$titulo.'</td>';
	$td = '<td align="left">';
	$td1 = '</td>';
  }
  echo $titulo1;
  echo $td ;			
  echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control required">';
  foreach($MATRIZ as $key => $value){
		$val     = utf8_encode($key);
		$caption = utf8_encode($value);	
  	$valor = trim($datos[$variable]);
	if ( $valor == $val) {
	  $selstr = " selected"; 
	}else{
	  $selstr = "";
	}
	$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
	echo $cadena1;
  }
  echo '</select>';    
  echo $td1; 
}  
// lista con eventos
function listaodbe($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled,$evento,$salto)
{
    
    $titulo = utf8_encode(utf8_decode($titulo));
    
    if ($required=='required')
        $required =' required ';
        else
            $required ='';
            
            if ($disabled =='disabled')
                $readonly = ' disabled="disabled" ';
                else
                    $readonly =' ';
                    
                    // div-3-3  div para objetos
                    $cadena = $salto;
                    $array = explode("-", $cadena);
                    
                    $div1 = $array[0];
                    $div2 = $array[1];
                    $div3 = $array[2];
                    
                    if ($div1 == 'div'){
                        $titulo1 = '';
                        $td = '';
                        $td1 = '';
                    }
                    else	 {
                        if (empty($titulo)){
                            $titulo1 = '';
                            $td = '';
                            $td1 = '';
                        }
                        else{
                            $titulo1 ='<td align="right">'.$titulo.'</td>';
                            $td = '<td align="left">';
                            $td1 = '</td>';
                        }
                    }
                    echo $titulo1;
                    echo $td ;
                    
                    
                    if ($div1 == 'div'){
                        //    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
                        //    echo '<label id="'.'l'.$variable.'"  style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                        echo '<div id="'.'d'.$variable.'" style="padding-top: 12px;"  class="col-md-'.$div3.'">';
                    }
                    
                    echo '<select name="'.$variable.'" '.$required.' '.$evento.' '.$readonly .' id="'.$variable.'" class="form-control required">';
                    $objeto_texto = '';
                    if ($tipo ==  'mysql'){
                        while ($lp_row = mysql_fetch_assoc($resultado))
                        {
                            $val     =ltrim(rtrim($lp_row["codigo"])) ;
                            $caption = $lp_row["nombre"];
                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
                            $objeto_texto = $objeto_texto.$cadena1;
                        }
                    }
                    ///////////////////////////////////
                    if ($tipo ==  'postgress'){
                        while($lp_row=pg_fetch_assoc($resultado))
                        {
                            $val     =ltrim(rtrim($lp_row["codigo"])) ;
                            $caption = $lp_row["nombre"];
                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
                            $objeto_texto = $objeto_texto.$cadena1;
                        }
                    }
                    ///////////////////////////////////
                    if ($tipo 
                        ==  'oracle'){
                        while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
                        {
                            $val     =ltrim(rtrim($lp_row["codigo"])) ;
                            $caption = $lp_row['NOMBRE'];
                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
                            $objeto_texto = $objeto_texto.$cadena1;
                        }
                        oci_free_statement($resultado);
                    }
                    echo  $objeto_texto ;
                    echo '</select>';
                    
                    
                    if ($div1 == 'div'){
                        echo '</div>';
                    }
                    
                    echo $td1;
                    if ($salto == '/'){
                        echo '</tr><tr>';
                    }
}	
function KP_listae($titulo,$MATRIZ,$variable,$datos,$required,$eventos,$disabled){	


$titulo = utf8_encode(utf8_decode($titulo)); 

  if ($required=='required')
	$required =' required '; 
  else	
    $required =''; 
  
  if ($disabled =='disabled')
	$readonly = ' disabled="disabled" '; 
  else	
	$readonly =' '; 
  if (empty($titulo)){
	 $titulo1 = '';
	 $td = '';
	 $td1 = '';
   }else{
	$titulo1 ='<td align="right">'.$titulo.'</td>';
	$td = '<td align="left">';
	$td1 = '</td>';
  }
  echo $titulo1;
  echo $td ;			
  echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control required" '.$eventos.'>';
  foreach($MATRIZ as $key => $value){
		$val     = utf8_encode($key);
		$caption = utf8_encode($value);	 
  	$valor = trim($datos[$variable]);
	if ( $valor == $val) {
	  $selstr = " selected"; 
	}else{
	  $selstr = "";
	}
	$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
	echo $cadena1;
  }
  echo '</select>';    
  echo $td1; 
}  
/*
// lista de valores parametros
*/
function lista($titulo,$MATRIZ,$variable,$datos,$required,$disabled,$salto){	
  

   $cadena = $salto;

   $readonly =' ';  
   
   $array = explode("-", $cadena);
   $div1  = $array[0];   
   $div2  = $array[1];
   $div3  = $array[2];

   if ($required=='required')
   {	 
	   $required =' required '; 
   }   

   if ($disabled =='disabled')
    { 
		$readonly = ' disabled="disabled" '; 
   }

   
   if ($disabled =='readonly')
    { 
		$readonly = ' readonly '; 
    }


   if ($div1 == 'div'){
	 	$titulo1 	= '';
		$td 		= '';
		$td1 		= '';
  }		
  else	 {
	   if (empty($titulo)){
				$titulo1 = '';
				$td 	 = '';
				$td1 	 = '';
	   }else{
				$titulo1 ='<td align="right">'.$titulo.'</td>';
				$td = '<td align="left">';
				$td1 = '</td>';
	   }
    } 
   
   echo $titulo1.$td ;		
   
    if ($div1 == 'div'){
 				echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
				echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
    }
  
    echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control">';

	 	  foreach($MATRIZ as $key => $value){
		
 				$val     =  trim ($key);
				$caption =  trim($value);
  		
  				$valor = trim($datos[$variable]);
				if ( $valor == $val) {
						$selstr = " selected"; 
				}else{
						$selstr = "";
				}
				$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
				echo $cadena1;
			}	


		echo '</select>';    
		
		echo $td1; 
		
		if ($div1 == 'div'){
		echo '</div>';
		}		 
			
		if($salto =='/'){
			echo '</tr><tr>';
		}
	
		if($salto =='-'){
			echo '</tr>';
		} 
    
}  
// lista con eventos
function listae($titulo,$MATRIZ,$variable,$datos,$required,$disabled,$evento,$salto){	

 
    if ($required=='required')
    {
        $required =' required ';
    }
    
    if ($disabled =='disabled')
    {
        $readonly = ' disabled="disabled" ';
    }
    
    
    if ($disabled =='readonly')
    {
        $readonly = ' readonly ';
    }
 
  	$cadena		= $salto;
  	$array		= explode("-", $cadena);
	$div1 		= $array[0];
	$div2 		= $array[1];
	$div3 		= $array[2];
  	
	 if ($div1 == 'div'){
				$titulo1 	= '';
				$td 		= '';
				$td1 		= '';
    }		
    else	 {	
			  if (empty($titulo)){
					$titulo1 	= '';
					$td 		= '';
					$td1 		= '';
			   }else{
				    $titulo1 	= '<td align="right">'.$titulo.'</td>';
				    $td 		= '<td align="left">';
				    $td1 		= '</td>';
			   }
     }	
   
   echo $titulo1;
   echo $td ;			

     if ($div1 == 'div'){
			echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
			echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
  	  }
     
   	 echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" '.$evento.' class="form-control">';
   
	foreach($MATRIZ as $key => $value){
		$val     = $key;
		$caption = $value;	 
		$valor = trim($datos[$variable]);
		if ( $valor == $val) {
				$selstr = " selected"; 
		}else{
				$selstr = "";
		}
		$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
		echo $cadena1;
		}

	echo '</select>';    
	echo $td1; 
	
	if ($div1 == 'div'){
			echo '</div>';
	}		 
		
	if (trim($salto) == '/'){
			echo '</tr><tr>';
	}
	if (trim($salto) == '-'){
			echo '</tr>';
	}  
  
 }  
 // lista con eventos
function listae_ajax($MATRIZ,$variable,$datos,$required,$disabled,$evento){	
  if ($required=='required')
	$required =' required '; 
  else	
	$required =''; 
  if ($disabled =='disabled')
	$readonly = ' disabled="disabled" '; 
  else	
	$readonly =' '; 
	
 		
   $cadena_ajax = '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" '.$evento.' class="form-control required">';
   
   $cadena2 = '';
   
   foreach($MATRIZ as $key => $value){
	 $val     = $key;
	 $caption = $value;	 
  	 $valor = trim($datos[$variable]);
	 if ( $valor == $val) {
	   $selstr = " selected"; 
	 }else{
	   $selstr = "";
	 }
	 $cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
	 $cadena2 = $cadena1.$cadena2;
	}
	
	$cadena_ajax = $cadena_ajax.$cadena2.'</select>';
	 
	 return $cadena_ajax;
  
 }  
 // lista con eventos
function listae_web($titulo,$MATRIZ,$variable,$datos,$required,$disabled,$evento,$salto){	

$titulo = utf8_encode(utf8_decode($titulo)); 

  if ($required=='required')
	$required =' required '; 
  else	
	$required =''; 
  if ($disabled =='disabled')
	$readonly = ' disabled="disabled" '; 
  else	
	$readonly =' '; 
  if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
   }else{
	 $titulo1 ='<td align="right">'.$titulo.'</td>';
	 $td = '<td align="left">';
	 $td1 = '</td>';
   }
   echo $titulo1;
   echo $td ;			
   echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" '.$evento.' class="form-control required">';
   
    $longitud = count($MATRIZ);
	 
	  for($i=0; $i<$longitud; $i++)
		{
		
		 $val     = $MATRIZ[$i][0];
		 $caption = $MATRIZ[$i][1];
		 $valor = trim($datos[$variable]);
	
		   if ( $valor == $val) {
			 $selstr = " selected"; 
		   }else{
			  $selstr = "";
		   }
	 $cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
	 echo $cadena1;
	
	  }	
		 
	echo '</select>';    
	echo $td1; 
	
   if (trim($salto) == '/'){
   echo '</tr><tr>';
  }
  if (trim($salto) == '-'){
   	echo '</tr>';
  }  
  
 }  
//-----lista con base de datos
function KP_listadb($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled){	

$titulo = utf8_encode(utf8_decode($titulo)); 

 if ($required=='required')
  $required =' required '; 
 else	
  $required =''; 
 if ($disabled =='disabled')
  $readonly = ' disabled="disabled" '; 
 else	
  $readonly =' '; 
 if (empty($titulo)){
  $titulo1 = '';
  $td = '';
  $td1 = '';
  }else{
	$titulo1 ='<td align="right">'.$titulo.'</td>';
	$td = '<td align="left">';
	$td1 = '</td>';
  }
  echo $titulo1;
  echo $td ;		
  echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control required">';
  $objeto_texto = '';
  if ($tipo ==  'mysql'){
	while ($lp_row = mysql_fetch_assoc($resultado)){
		$val     = $lp_row["codigo"];
		$caption = $lp_row["nombre"];
		if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
			$cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
			$objeto_texto = $objeto_texto.$cadena1;
		} 	  
	 }
   if ($tipo ==  'postgress'){
	while($lp_row=pg_fetch_assoc($resultado)){
		$val     = $lp_row["codigo"];
		$caption = $lp_row["nombre"];
		if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
			$cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
			$objeto_texto = $objeto_texto.$cadena1;
		} 	  
	}
	if ($tipo ==  'oracle'){
	 while($lp_row=oci_fetch_array($resultado, OCI_BOTH)){
		$val     = $lp_row['CODIGO'];
		$caption = $lp_row['NOMBRE'];
		if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		 $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		 $objeto_texto = $objeto_texto.$cadena1;
		 } 	  
		 oci_free_statement($resultado);
	  }
	  echo  $objeto_texto ;	  
	  echo '</select>';    
	  echo $td1; 
}		
//-----lista con base de datos
function listadb($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled,$salto){	

    
    
    if ($disabled=='readonly')  {
        $disabled = ' readonly="readonly"  ';
    }
    
    if ($disabled=='disabled')  {
        $disabled = ' disabled="disabled" '; 
    }
 			 	
				 
					
		
    		   // div-3-3  div para objetos
      $cadena = $salto;
      $array = explode("-", $cadena);
      
      $div1 = $array[0];
      $div2 = $array[1];
      $div3 = $array[2];
  	
  if ($div1 == 'div'){
	 	$titulo1 = '';
		$td = '';
		$td1 = '';
  }		
 else	 {			
		    if (empty($titulo)){
					$titulo1 = '';
				    $td = '';
				    $td1 = '';
				 }
				 else{
				   $titulo1 ='<td align="right">'.$titulo.'</td>';
				   $td = '<td align="left">';
				   $td1 = '</td>';
				 }
	 }
	 
	      if ($div1 == 'div'){
             	
	          if ( $div2  <> '0' ) {
	              
	              echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
	              
	          }
             	
             	
             echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
           }
	  		
				echo $titulo1;
				echo $td ;		
				echo '<select name="'.$variable.'" '.$required.$disabled .' id="'.$variable.'" class="form-control">';
				
				$objeto_texto = '';
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val          = trim($lp_row["codigo"]);
								  $caption      = trim($lp_row["nombre"]);
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					while($lp_row=pg_fetch_assoc($resultado))
					{
						$val          = trim($lp_row["codigo"]);
						$caption  = trim($lp_row["nombre"]);
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				 oci_free_statement($resultado);
				}
				echo  $objeto_texto ;	  
				echo '</select>';    
				
	if ($div1 == 'div'){
     echo '</div>';
    }	
	
				echo $td1; 
				if ($salto == '/'){
					echo '</tr>';
				}
		}	
	//-----------------------------	
		function listadbe($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled,$evento,$salto){
		    
 		    
		    if ($required=='required')
		        $required =' required ';
		        else
		            $required ='';
		            
		            if ($disabled =='disabled')
		                $readonly = ' disabled="disabled" ';
		                else
		                    $readonly =' ';
		                    
		                    
		                    // div-3-3  div para objetos
		                    $cadena = $salto;
		                    $array = explode("-", $cadena);
		                    
		                    $div1 = $array[0];
		                    $div2 = $array[1];
		                    $div3 = $array[2];
		                    
		                    if ($div1 == 'div'){
		                        $titulo1 = '';
		                        $td = '';
		                        $td1 = '';
		                    }
		                    else	 {
		                        if (empty($titulo)){
		                            $titulo1 = '';
		                            $td = '';
		                            $td1 = '';
		                        }
		                        else{
		                            $titulo1 ='<td align="right">'.$titulo.'</td>';
		                            $td = '<td align="left">';
		                            $td1 = '</td>';
		                        }
		                    }
		                    
		                    if ($div1 == 'div'){
		                        
		                        if ( $div2  <> '0' ) {
		                            
		                            echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
		                            
		                        }
		                        
		                        
		                        echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
		                    }
		                    
		                    echo $titulo1;
		                    echo $td ;
		                    echo '<select name="'.$variable.'" '.$evento.$required.$readonly .' id="'.$variable.'" class="form-control">';
		                    
		                    $objeto_texto = '';
		                    if ($tipo ==  'mysql'){
		                        while ($lp_row = mysql_fetch_assoc($resultado))
		                        {
		                            $val          = trim($lp_row["codigo"]);
		                            $caption      = trim($lp_row["nombre"]);
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                    }
		                    ///////////////////////////////////
		                    if ($tipo ==  'postgress'){
		                        while($lp_row=pg_fetch_assoc($resultado))
		                        {
		                            $val          = trim($lp_row["codigo"]);
		                            $caption  = trim($lp_row["nombre"]);
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                    }
		                    ///////////////////////////////////
		                    if ($tipo ==  'oracle'){
		                        while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
		                        {
		                            $val     = $lp_row['CODIGO'];
		                            $caption = $lp_row['NOMBRE'];
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                        oci_free_statement($resultado);
		                    }
		                    echo  $objeto_texto ;
		                    echo '</select>';
		                    
		                    if ($div1 == 'div'){
		                        echo '</div>';
		                    }
		                    
		                    echo $td1;
		                    if ($salto == '/'){
		                        echo '</tr>';
		                    }
		}
//------------------
function listadbe_unidad($bd,$titulo,$variable,$datos,$required,$disabled,$evento,$salto){
		
	
	$sql = "select id_departamento as codigo,nombre,orden  
			from nom_departamento 
			where estado = 'S'
			ORDER BY ORDEN "   ;

	$resultado = $bd->ejecutar($sql);
  		    
	if ($required=='required') 	$required =' required '; else $required ='';
			
    if ($disabled =='disabled') $readonly = ' disabled="disabled" '; else  $readonly =' ';
					
    $cadena = $salto;
	$array = explode("-", $cadena);
	$div1 = $array[0];
	$div2 = $array[1];
	$div3 = $array[2];
					
	 if ($div1 == 'div'){
						$titulo1 = ''; 	$td = ''; 	$td1 = '';
	 }
	else	 {
						if (empty($titulo)){
							$titulo1 = ''; $td 	 = ''; 	$td1	 = '';
						}
						else{
							$titulo1 ='<td align="right">'.$titulo.'</td>';
							$td      = '<td align="left">';
							$td1     = '</td>';
						}
	 }
	 if ($div1 == 'div'){
 						if ( $div2  <> '0' ) {
							echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
						}
 						echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
	}
	echo $titulo1;
	echo $td ;


	echo '<select name="'.$variable.'" '.$evento.$required.$readonly .' id="'.$variable.'" class="form-control">';
		  $objeto_texto = '';
		  echo '<option value="0"> -  Seleccionar Unidad  - </option>';

		  echo '<option style="font-weight:bold;color: #070BD7" value="-1">  DIRECTORES DE LA INSTITUCION </option>';
		  echo '<option style="font-weight:bold;color: #070BD7" value="-2">  FUNCIONARIOS DE LA UNIDAD </option>';
		
		  while($lp_row=pg_fetch_assoc($resultado)) {

			$val          = trim($lp_row["codigo"]);
			$caption      = trim($lp_row["nombre"]);

			$orden        = trim($lp_row["orden"]);
			$long         = strlen($orden);

			if ( $long  > 1 ){
				$caption    = '&nbsp;&nbsp;&nbsp;'.$caption   ;
			} 
			if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}

				$cadena1 = ' <option style="font-weight:bold"  value="'.$val.'"'.$selstr.'>'.$caption.'</option>';

				$objeto_texto = $objeto_texto.$cadena1;

			}
				 
	 echo  $objeto_texto ;
	 echo '</select>';
	 if ($div1 == 'div'){
						echo '</div>';
	 }
	 echo $td1;
		 if ($salto == '/'){
			 echo '</tr>';
	      }
}		
/*
*/
function listadbe_uni_usuario($bd,$titulo,$variable,$datos,$required,$disabled,$evento,$salto,$orden="-"){
		

	$sesion 	= trim($_SESSION['email']);
	$nivel      = strlen(trim($orden));
	 
 


	$sql_supe  = ' ';

	if ( $nivel == 1 ){

		$sql = "SELECT   email ,completo ,cargo, responsable  ,orden
				FROM  view_nomina_user
			where estado='S' and 
						cargo is not null and
						email  <> ".$bd->sqlvalue_inyeccion( $sesion ,true)." and 
						orden like ".$bd->sqlvalue_inyeccion( trim($orden).'%' ,true)."
						order by orden asc, responsable desc, completo asc " ;
	}
else{

		//CC
		$orden = substr($orden,0,$nivel -1);

		$sql = "SELECT   email ,completo ,cargo, responsable  ,orden
			  FROM  view_nomina_user
			where estado='S' and 
 						email  <> ".$bd->sqlvalue_inyeccion( $sesion ,true)." and 
						cargo is not null and
						orden like ".$bd->sqlvalue_inyeccion( $orden.'%' ,true)." 	
						order by orden asc, responsable desc, completo asc " ;

	}	
 

 


			
 
	$resultado = $bd->ejecutar($sql);
  		    
	if ($required=='required') 	$required =' required '; else $required ='';
			
    if ($disabled =='disabled') $readonly = ' disabled="disabled" '; else  $readonly =' ';
					
    $cadena = $salto;
	$array = explode("-", $cadena);
	$div1 = $array[0];
	$div2 = $array[1];
	$div3 = $array[2];
					
	 if ($div1 == 'div'){
						$titulo1 = ''; 	$td = ''; 	$td1 = '';
	 }
	else	 {
						if (empty($titulo)){
							$titulo1 = ''; $td 	 = ''; 	$td1	 = '';
						}
						else{
							$titulo1 ='<td align="right">'.$titulo.'</td>';
							$td      = '<td align="left">';
							$td1     = '</td>';
						}
	 }
	 if ($div1 == 'div'){
 						if ( $div2  <> '0' ) {
							echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
						}
 						echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
	}
	echo $titulo1;
	echo $td ;

	echo '<select name="'.$variable.'" '.$evento.$required.$readonly .' id="'.$variable.'" class="form-control">';
		  $objeto_texto = '';
		  echo '<option value="-"> -  Seleccionar Funcionario de la Unidad  - </option>';
		
		  while($lp_row=pg_fetch_assoc($resultado)) {

			$val          = trim($lp_row["email"]);
			$caption      = trim($lp_row["completo"]).' ('.trim($lp_row["cargo"]).')' ;

			$orden        = trim($lp_row["orden"]);
			$long         = strlen($orden);

			 

			if ( $long  > 1 ){
				$caption    = '&nbsp;&nbsp;&nbsp;'.$caption   ;
			} 
			if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}

				$cadena1 = ' <option style="font-weight:bold" value="'.$val.'"'.$selstr.'>'.$caption.'</option>';

				$objeto_texto = $objeto_texto.$cadena1;

			}
				 
	 echo  $objeto_texto ;
	 echo '</select>';
	 if ($div1 == 'div'){
						echo '</div>';
	 }
	 echo $td1;
		 if ($salto == '/'){
			 echo '</tr>';
	      }
}	

/*
*/
function listadbe_uni_responsables_para($bd,$titulo,$variable,$datos,$required,$disabled,$evento,$salto,$orden="-"){
		
	$sesion 		 =  trim($_SESSION['email']);
 	$datos_uni       =  $bd->__user($sesion);
	$orden   		 =  trim($datos_uni['orden']);

	$sql = "SELECT   email ,completo ,cargo, responsable  ,orden
			  FROM  view_nomina_user
			where estado='S' and 
						email  <> ".$bd->sqlvalue_inyeccion( $sesion ,true)." and 
						cargo is not null and
						responsable = ".$bd->sqlvalue_inyeccion( 'S' ,true)." union 
				   SELECT   email ,completo ,cargo, responsable  ,orden
			         FROM  view_nomina_user
			         where estado='S' and 
						email  <> ".$bd->sqlvalue_inyeccion( $sesion ,true)." and 
						cargo is not null and
						responsable = ".$bd->sqlvalue_inyeccion( 'N' ,true)." and 
						orden like ".$bd->sqlvalue_inyeccion( 	$orden .'%'  ,true)."
						order by  responsable desc,orden asc, completo asc " ;
 
	$resultado = $bd->ejecutar($sql);
  		    
	if ($required=='required') 	$required =' required '; else $required ='';
			
    if ($disabled =='disabled') $readonly = ' disabled="disabled" '; else  $readonly =' ';
					
    $cadena = $salto;
	$array = explode("-", $cadena);
	$div1 = $array[0];
	$div2 = $array[1];
	$div3 = $array[2];
					
	 if ($div1 == 'div'){
						$titulo1 = ''; 	$td = ''; 	$td1 = '';
	 }
	else	 {
						if (empty($titulo)){
							$titulo1 = ''; $td 	 = ''; 	$td1	 = '';
						}
						else{
							$titulo1 ='<td align="right">'.$titulo.'</td>';
							$td      = '<td align="left">';
							$td1     = '</td>';
						}
	 }
	 if ($div1 == 'div'){
 						if ( $div2  <> '0' ) {
							echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
						}
 						echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
	}
	echo $titulo1;
	echo $td ;
	echo '<select name="'.$variable.'" '.$evento.$required.$readonly .' id="'.$variable.'" class="form-control">';
		  $objeto_texto = '';
		  echo '<option value="-"> -  Seleccionar Funcionario de la Unidad  - </option>';
		
		  while($lp_row=pg_fetch_assoc($resultado)) {

			$val          = trim($lp_row["email"]);
			$caption      = trim($lp_row["completo"]).' ('.trim($lp_row["cargo"]).')';

			$orden        = trim($lp_row["orden"]);
			$long         = strlen($orden);

			 

			if ( $long  > 1 ){
				$caption    = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$caption   ;
			} 
			if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}

				$cadena1 = ' <option style="font-weight:bold" value="'.$val.'"'.$selstr.'>'.$caption.'</option>';

				$objeto_texto = $objeto_texto.$cadena1;

			}
				 
	 echo  $objeto_texto ;
	 echo '</select>';
	 if ($div1 == 'div'){
						echo '</div>';
	 }
	 echo $td1;
		 if ($salto == '/'){
			 echo '</tr>';
	      }
}	
/*
*/
function listadbe_uni_responsables($bd,$titulo,$variable,$datos,$required,$disabled,$evento,$salto,$orden="-"){
		
	$sesion = trim($_SESSION['email']);

	$sql = "SELECT   email ,completo ,cargo, responsable  ,orden
			  FROM  view_nomina_user
			where estado='S' and 
						email  <> ".$bd->sqlvalue_inyeccion( $sesion ,true)." and 
						cargo is not null and
						responsable = ".$bd->sqlvalue_inyeccion( 'S' ,true)."
						order by orden asc, responsable desc, completo asc " ;
 
	$resultado = $bd->ejecutar($sql);
  		    
	if ($required=='required') 	$required =' required '; else $required ='';
			
    if ($disabled =='disabled') $readonly = ' disabled="disabled" '; else  $readonly =' ';
					
    $cadena = $salto;
	$array = explode("-", $cadena);
	$div1 = $array[0];
	$div2 = $array[1];
	$div3 = $array[2];
					
	 if ($div1 == 'div'){
						$titulo1 = ''; 	$td = ''; 	$td1 = '';
	 }
	else	 {
						if (empty($titulo)){
							$titulo1 = ''; $td 	 = ''; 	$td1	 = '';
						}
						else{
							$titulo1 ='<td align="right">'.$titulo.'</td>';
							$td      = '<td align="left">';
							$td1     = '</td>';
						}
	 }
	 if ($div1 == 'div'){
 						if ( $div2  <> '0' ) {
							echo '<label style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
						}
 						echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
	}
	echo $titulo1;
	echo $td ;
	echo '<select name="'.$variable.'" '.$evento.$required.$readonly .' id="'.$variable.'" class="form-control">';
		  $objeto_texto = '';
		  echo '<option value="-"> -  Seleccionar Funcionario de la Unidad  - </option>';
		
		  while($lp_row=pg_fetch_assoc($resultado)) {

			$val          = trim($lp_row["email"]);
			$caption      = trim($lp_row["completo"]).' ('.trim($lp_row["cargo"]).')';

			$orden        = trim($lp_row["orden"]);
			$long         = strlen($orden);

			 

			if ( $long  > 1 ){
				$caption    = '&nbsp;&nbsp;&nbsp;'.$caption   ;
			} 
			if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}

				$cadena1 = ' <option style="font-weight:bold" value="'.$val.'"'.$selstr.'>'.$caption.'</option>';

				$objeto_texto = $objeto_texto.$cadena1;

			}
				 
	 echo  $objeto_texto ;
	 echo '</select>';
	 if ($div1 == 'div'){
						echo '</div>';
	 }
	 echo $td1;
		 if ($salto == '/'){
			 echo '</tr>';
	      }
}	
//------------------------------------------
	
	 
		/*   CASILLERO DE TEXTO
		 $MATRIZ = array(
		 0    => 'Select a State',
		 1    => 'AL - Alabama'
		 );
		 );*/
//----------------		
		function listadb_place($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled,$salto){
		    
 		    
		    if ($required=='required')
		        $required =' required ';
		        else
		            $required ='';
		            
		            if ($disabled =='disabled')
		                $readonly = ' disabled="disabled" ';
		                else
		                    $readonly =' ';
		                    
		                    
		                    // div-3-3  div para objetos
		                    $cadena = $salto;
		                    $array = explode("-", $cadena);
		                    
		                    $div1 = $array[0];
		                    $div2 = $array[1];
		                    $div3 = $array[2];
		                    
		                    if ($div1 == 'div'){
		                        $titulo1 = '';
		                        $td = '';
		                        $td1 = '';
		                    }
		                    else	 {
		                        if (empty($titulo)){
		                            $titulo1 = '';
		                            $td = '';
		                            $td1 = '';
		                        }
		                        else{
		                            $titulo1 ='<td align="right">'.$titulo.'</td>';
		                            $td = '<td align="left">';
		                            $td1 = '</td>';
		                        }
		                    }
		                    
		                    if ($div1 == 'div'){
 		                     
		                        echo '<div style="padding-top: 2px;"  class="col-md-'.$div3.'">';
		                    }
		                    
		                    echo $titulo1;
		                    echo $td ;
		                    echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control">';
		                    
		                    $objeto_texto = '';
		                    if ($tipo ==  'mysql'){
		                        while ($lp_row = mysql_fetch_assoc($resultado))
		                        {
		                            $val          = trim($lp_row["codigo"]);
		                            $caption  = trim($lp_row["nombre"]);
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                    }
		                    ///////////////////////////////////
		                    if ($tipo ==  'postgress'){
		                        while($lp_row=pg_fetch_assoc($resultado))
		                        {
		                            $val          = trim($lp_row["codigo"]);
		                            $caption  = trim($lp_row["nombre"]);
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                    }
		                    ///////////////////////////////////
		                    if ($tipo ==  'oracle'){
		                        while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
		                        {
		                            $val     = $lp_row['CODIGO'];
		                            $caption = $lp_row['NOMBRE'];
		                            if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
		                            $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
		                            $objeto_texto = $objeto_texto.$cadena1;
		                        }
		                        oci_free_statement($resultado);
		                    }
		                    echo  $objeto_texto ;
		                    echo '</select>';
		                    
		                    if ($div1 == 'div'){
		                        echo '</div>';
		                    }
		                    
		                    echo $td1;
		                    if ($salto == '/'){
		                        echo '</tr>';
		                    }
		}	
//-----lista con base de datos listadb_ajax
function listadb_ajax($resultado,$tipo,$variable,$datos,$required,$disabled){	
			 	
				if ($required=='required')
					$required =' required '; 
				else	
					$required =''; 

				if ($disabled =='disabled')
					$readonly = ' disabled="disabled" '; 
				else	
					$readonly =' '; 
					
					
 			    $objeto_texto = '';
				$listadb_ajax ='<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control required">';
				 $objeto_texto = '';
				 
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					$objeto_texto = '';
					while($lp_row=pg_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $cadena1.$objeto_texto;
					} 	  
				    $listadb_ajax = $listadb_ajax.$objeto_texto.'</select>';  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $cadena1.$objeto_texto;
					} 	  
					 $listadb_ajax = $listadb_ajax.$objeto_texto.'</select>';  
				 oci_free_statement($resultado);
				}
				 
				return $listadb_ajax;
		}	
//----------------		
//-----lista con base de datos
function listadb_ajaxe($resultado,$tipo,$variable,$datos,$required,$disabled,$evento){	

 			 	
				if ($required=='required')
					$required =' required '; 
				else	
					$required =''; 

				if ($disabled =='disabled')
					$readonly = ' disabled="disabled" '; 
				else	
					$readonly =' '; 
					
					
 			    $objeto_texto = '';
				$listadb_ajax ='<select name="'.$variable.'" '.$required.$readonly.' '.$evento.' id="'.$variable.'" class="form-control required">';
				 $objeto_texto = '';
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					$objeto_texto = '';
					while($lp_row=pg_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $cadena1.$objeto_texto;
					} 	  
				    $listadb_ajax = $listadb_ajax.$objeto_texto.'</select>';  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $cadena1.$objeto_texto;
					} 	  
					 $listadb_ajax = $listadb_ajax.$objeto_texto.'</select>';  
				 oci_free_statement($resultado);
				}
				 
				return $listadb_ajax;
		}			
//-----------------------------------------		
	
				////////////////////////
	/*   CASILLERO DE TEXTO
			$MATRIZ = array(
					0    => 'Select a State',
 					1    => 'AL - Alabama'
				);
		);
		---------------------------------------------------------------------*/
	    function KP_listadbweb($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled)
		{	
			 $titulo = utf8_encode(utf8_decode($titulo)); 
				
				if ($required=='required')
					$required =' required '; 
				else	
					$required =''; 

				if ($disabled =='disabled')
					$readonly = ' disabled="disabled" '; 
				else	
					$readonly =' '; 
					
					
		    if (empty($titulo)){
					$titulo1 = '';
				    $td = '';
				    $td1 = '';
				 }
				 else{
				   $titulo1 ='<td align="right">'.$titulo.'</td>';
				   $td = '<td align="left">';
				   $td1 = '</td>';
				 }
			
				echo $titulo1;
				echo $td ;		
				echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="casillero_texto">';
				$objeto_texto = '';
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					while($lp_row=pg_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				 oci_free_statement($resultado);
				}
				echo  $objeto_texto ;	  
				echo '</select>';    
				echo $td1; 
		}	
/*********************************/
		
/*	---------------------------------------------------------------------*/
	    function KP_listadbe($resultado,$tipo,$titulo,$variable,$datos,$required,$disabled,$evento)
		{	
			$titulo = utf8_encode(utf8_decode($titulo)); 
				
				if ($required=='required')
					$required =' required '; 
				else	
					$required =''; 

				if ($disabled =='disabled')
					$readonly = ' disabled="disabled" '; 
				else	
					$readonly =' '; 
					
					
		    if (empty($titulo)){
					$titulo1 = '';
				    $td = '';
				    $td1 = '';
				 }
				 else{
				   $titulo1 ='<td align="right">'.$titulo.'</td>';
				   $td = '<td align="left">';
				   $td1 = '</td>';
				 }
			
            
            
				echo $titulo1;
				echo $td ;		
				echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control required" '.$evento.'>';
				$objeto_texto = '';
				if ($tipo ==  'mysql'){
					while ($lp_row = mysql_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'postgress'){
					while($lp_row=pg_fetch_assoc($resultado))
					{
								  $val     = $lp_row["codigo"];
								  $caption = $lp_row["nombre"];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				}
				///////////////////////////////////
				if ($tipo ==  'oracle'){
					while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
					{
								  $val     = $lp_row['CODIGO'];
								  $caption = $lp_row['NOMBRE'];
								  if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
									  $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
									  $objeto_texto = $objeto_texto.$cadena1;
					} 	  
				 oci_free_statement($resultado);
				}
				echo  $objeto_texto ;	  
				echo '</select>';    
				echo $td1; 
		}
		
		
  // lista de valores parametros
function listaweb($titulo,$MATRIZ,$variable,$datos,$required,$disabled,$salto){	

$titulo = utf8_encode(utf8_decode($titulo)); 

   if ($required=='required')
	$required =' required '; 
   else	
	$required =''; 
   if ($disabled =='disabled')
	$readonly = ' disabled="disabled" '; 
   else	
	$readonly =' '; 
   if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
   }else{
	$titulo1 ='<td align="right">'.$titulo.'</td>';
	$td = '<td align="left">';
	$td1 = '</td>';
   }
   echo $titulo1;
   echo $td ;			
   echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="css-input" >';
  	foreach($MATRIZ as $key => $value){
		$val     = $key;
		$caption = $value;	 
  		$valor = trim($datos[$variable]);
		if ( $valor == $val) {
		 $selstr = " selected"; 
		}else{
		 $selstr = "";
		}
		$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
		echo $cadena1;
	}
	echo '</select>';    
	echo $td1; 
	
  if($salto =='/'){
    echo '</tr><tr>';
  }
   
  if($salto =='-'){
   	echo '</tr>';
  } 
    
}       
//---------------------------------------------------------------------
function lista_filtro($MATRIZ,$variable,$datos,$evento){
    
   
                    
    echo '<select name="'.$variable.'" '.' id="'.$variable.'" '.$evento.' class="form-control">';
                    
                    foreach($MATRIZ as $key => $value){
                        $val     = $key;
                        $caption = $value;
                        $valor = trim($datos[$variable]);
                        if ( $valor == $val) {
                            $selstr = " selected";
                        }else{
                            $selstr = "";
                        }
                        $cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
                        echo $cadena1;
                    }
                    echo '</select><br> ';
                    
                     
   }  
//-------------------------------------------------------------
   function listadb_filtro($resultado,$tipo,$variable,$datos){
       
      
                       echo '<select name="'.$variable.'" '.$required.$readonly .' id="'.$variable.'" class="form-control">';
                       
                       $objeto_texto = '';
                      
                       ///////////////////////////////////
                       if ($tipo ==  'postgress'){
                           while($lp_row=pg_fetch_assoc($resultado))
                           {
                               $val          = trim($lp_row["codigo"]);
                               $caption  = trim($lp_row["nombre"]);
                               if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
                               $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
                               $objeto_texto = $objeto_texto.$cadena1;
                           }
                       }
                       ///////////////////////////////////
                       if ($tipo ==  'oracle'){
                           while($lp_row=oci_fetch_array($resultado, OCI_BOTH))
                           {
                               $val     = $lp_row['CODIGO'];
                               $caption = $lp_row['NOMBRE'];
                               if ($datos[$variable] == $val) {$selstr = " selected"; } else {$selstr = "";}
                               $cadena1 = ' <option value="'.$val.'"'.$selstr.'>'.$caption.'</option>';
                               $objeto_texto = $objeto_texto.$cadena1;
                           }
                           oci_free_statement($resultado);
                       }
                       echo  $objeto_texto ;
                       echo '</select><br> ';
                       
                    
   }	
 //-------------------------------------------------------  
   
}


?>