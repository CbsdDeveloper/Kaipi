<?php
 
class objects_grid  {
 

private static $_instance;

   private $columna;
   private $ncolumna;
   private $var1;
   private $var2;
   private $var3;
   private $var4;
   private $var5;
   private $var6;
   private $var7;
   private $anchot;
   
function clave_inyeccion() {

 return 'cmkDAK4qoP5BGg1wAjfeM0pA2'; // Modificamos las variables pasadas por URL
}	

function kaipi_url_pop($vinculo,$variable,$largo,$ancho){				

  $cadena = 'javascript:abrirf('."'".$vinculo."'".",'".$variable."'".','.$largo.','.$ancho.')';

  return $cadena;
}	


/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function num_campos($resultado,$tipo)  {
    
  switch ($tipo){
    
	case 'mysql':    
                    $numero_campos = mysql_num_fields($resultado) - 1;
					break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				     $numero_campos = oci_num_fields($resultado) - 1;
				     break;	
	break;
  }
  
  return $numero_campos;

}
/*-------------------------------------------------------------------------------------------*/		
function cabecera($resultado,$tipo, $numero_campos)  {
    
   // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
    // class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
 
echo '<table class="table table-striped table-bordered table-hover table-checkable  datatable" width="100%"><thead> <tr>';
 
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
    	switch ($tipo){
    		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
    						 break;
                             
    		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
    						 break;
                             
    		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
    						 break;						 
    		break;
    	}		 
	    
		echo "<th>".ucfirst($cabecera).'</th>';

	    $k++;  
  }
}

/*-------------------------------------------------------------------------------------------*/		
function cabecera_row($resultado,$tipo, $numero_campos)  {
 
 
 for ($i = 0; $i<= $numero_campos; $i++){
    	switch ($tipo){
    		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
    						 break;
                             
    		case 'postgress':$cabecera = pg_field_name($resultado,$i) ;	
    						 break;
                             
    		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
    						 break;						 
    		break;
    	}		 
	    $row[$i] = $cabecera;
 
  }
  return $row;
}
/*-------------------------------------------------------------------------------------------*/		
function cabeceraTool($resultado,$tipo, $numero_campos)  {
    
   // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
    // class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
  
echo '<table class="table table-hover table-striped table-highlight-head table-tabletools datatable" width="100%"><thead> <tr>';
 
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
    	switch ($tipo){
    		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
    						 break;
                             
    		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
    						 break;
                             
    		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
    						 break;						 
    		break;
    	}		 
	    echo "<th><small>".$cabecera.'</small></th>';
	    $k++;  
  }
}
//-------------------
function cabeceraToolreporte($resultado,$tipo, $numero_campos,$porcentaje)  {
    
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
    // class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
 
    echo '<table  class="display table table-condensed table-hover datatable" cellspacing="0" width="'.$porcentaje.'"><thead> <tr>';
 
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
    	switch ($tipo){
    		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
    						 break;
                             
    		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
    						 break;
                             
    		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
    						 break;						 
    		break;
    	}		 
    	
    	
    	echo "<th><small>".strtoupper($cabecera).'</small></th>';
	    
	    $k++;  
  }
}
//-------------------
function cabeceraToolancho($resultado,$tipo, $numero_campos,$porcentaje)  {
    
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    // table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
    // class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
    
    echo '<table cellspacing="2px" cellpadding="2px"  width="'.$porcentaje.'"><thead> <tr>';
    
    $k = 0;
    for ($i = 0; $i<= $numero_campos; $i++){
        switch ($tipo){
            case 'mysql':    $cabecera = mysql_field_name($resultado,$i);
            break;
            
            case 'postgress':$cabecera = pg_field_name($resultado,$k) ;
            break;
            
            case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;
            break;
            break;
        }
        
        
        echo "<th align='right'><small>".strtoupper(trim($cabecera)).'</small></th>';
        
        $k++;
    }
}
/*---------------------------------------------------------------------------------oracle_ToolWeb----------*/		
function oracle_gridTab3($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    // actiones de la grilla   
    if ($action == 'S'){
        echo '<th> Acciones </th>';
    }
 
    echo '</tr></thead><tbody>';
 

    $i = 1;

    while($row=oci_fetch_assoc($resultado)) {
    
    echo '<tr>';
	
    foreach ($row as $item){
	   
    	  if(is_numeric($item)){
        		if ($i == 1)  {
        		  echo "<td align='right'>".$item."</td>";
         		}else{
        		  echo "<td align='right'>".number_format($item,2)."</td>";
        	    }
    	   }else{
    		      echo "<td>".$item."</td>";
    	   }
     	   $i++;
           
	  }
      if ($action == 'S'){
        
		echo '<td width="10%">';
		
		if (!empty($visor)) {
		     
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).'#tab3';
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		}
		echo '</td>';			 
	 }
 	echo '</tr>';		
	$i = 1;
	}
	
    echo '</tbody></table>';
  
    oci_free_statement ($resultado) ; 
}
/*-------------------------------------------------------------------------------------------*/		
function oracle_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    // actiones de la grilla   
    if ($action == 'S'){
        echo '<th> Acciones </th>';
    }
?>
    </tr></thead>
     <tbody>
<?php     

    $i = 1;

    while($row=oci_fetch_assoc($resultado)) {
    
    echo '<tr>';
	
    foreach ($row as $item){
	   
    	  if(is_numeric($item)){
        		if ($i == 1)  {
        		  echo "<td align='right'>".$item."</td>";
         		}else{
        		  echo "<td align='right'>".number_format($item,2)."</td>";
        	    }
    	   }else{
    		      echo "<td>".$item."</td>";
    	   }
     	   $i++;
           
	  }
      if ($action == 'S'){
        
		echo '<td width="10%">';
		
		if (!empty($visor)) {
		     
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		}
		echo '</td>';			 
	 }
 	echo '</tr>';		
	$i = 1;
	}
	
    echo '</tbody></table>';
  
    oci_free_statement ($resultado) ; 
}
/*-------------------------------------------------------------------------------------------*/		
function postgress_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    // actiones de la grilla   
    if ($action == 'S'){
        echo '<th> Acciones </th>';
    }
?>
    </tr></thead>
     <tbody>
<?php     
    $i = 1;
	
    while($row=pg_fetch_assoc($resultado)) {
	 echo '<tr>';
	 foreach ($row as $item){
	  if(is_numeric($item)){
    		if ($i == 1)  {
    		 echo "<td align='right'>".$item.'</td>';
     		}else{
    		 echo "<td align='right'>".number_format($item,2).'</td>';
    		}
    	   }else{
    		echo '<td>'.$item.'</td>';
    	   }
     	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
		}
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo '</tr>';		
	$i = 1;
	}
	echo '</tbody></table>';
    pg_free_result ($resultado) ;
}
function postgress_grid_reporte($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    // actiones de la grilla
?>
    </tr></thead>
     <tbody>
<?php     
    $i = 0;
	
    while($row=pg_fetch_assoc($resultado)) {
	 echo '<tr>';
	 foreach ($row as $item){
	     
	  if(is_numeric($item)){
     	
	      echo "<td align='right'>".number_format($item,2).'</td>';
 
	   }else{
    	
	       echo '<td>'.$item.'</td>';
       }
     	   $i++;
     	   
	  }

 	echo '</tr>';		
	$i = 0;
	}
	echo '</tbody></table>';
    pg_free_result ($resultado) ;
}
/*-------------------------------------------------------------------------------------------*/		
function postgress_gridPop($resultado,$tipo,$llave_primaria,$archivo_ref,$variables_adicional,$action,$visor,$editar,$del,$largo,$ancho,$tab)  {

    
  while($row=pg_fetch_assoc($resultado)) {

	echo "<tr>";
    
	$i= 1;
	
    foreach ($row as $item){
	
        if ($i == 1 ){
    		  echo "<td align='center'>".$item;
     	 }else{
    	
        	 if(is_numeric($item)){
    			     echo "<td align='right'>".number_format($item,2); 
    			  }else{
    				 echo "<td>".($item) ;
    		      }
    	 }
    	
         echo "</td>";
    	 
         $i++; 
         
	}
	$i= 1;
        if ($action == 'S'){

                   echo '<td>';

   		           if (!empty($visor)) {

        			     $ajax =$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho);
			             echo '<a href="'.$ajax.'" class=" btn btn-xs btn-info"  role="button" title="Search"><i class="icon-search"></i></a>';
			      }
                  
			      if (!empty($editar)){
			          if (empty($variables_adicional)){
			              $variables_adicional1 ='';
			          }
			          else
			          {
			              $referencial  = explode('&',$variables_adicional);
			              $referencial1 = $referencial[0];
			              $referencial2 = $referencial[1];
						  $referencial3 = $referencial[2];
			              
			              if (empty($referencial2)){
			                  $variable_url = $variables_adicional.'&action=del&tid='.$row[$llave_primaria].$tab;
			                  $ajax = "open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			              }
			              else
			              {
			                  $var1 = explode('=',$referencial1);
			                  $var_url1 = $var1[0] ;
			                  $var_url2 = trim($var1[1]) ;
			                  // var2RA
			                  $var2 = explode('=',$referencial2);
			                  $var_url3 = $var2[0] ;
			                  $var_url4 = trim($var2[1]) ;
							  // var3RA
							  $var3 = explode('=',$referencial3);
			                  $var_url5 = $var3[0] ;
			                  $var_url6 = trim($var3[1]) ;

			                  $variables_adicional1 ='&'.$var_url1.'='.trim($row[$var_url2]).'&'.$var_url3.'='.$var_url4.'&'.$var_url5.'='.trim($row[$var_url6]);
							  
			                  $ajax = $this->kaipi_url_pop($archivo_ref,'&action=editar&id='.$row[$llave_primaria].$variables_adicional1,$largo,$ancho);
			              }
			          }
			          echo '<a href="'.$ajax.'" class=" btn btn-xs btn-warning" role="button" title="editar registro"><i class="icon-edit"></i></a> ';
			      }
                  
		          if (!empty($del)){ 			  
 			            if (empty($variables_adicional)){ 
			                     $variables_adicional1 ='';
                        }
                        else
                        { 
                			  $referencial  = explode('&',$variables_adicional);
                			  $referencial1 = $referencial[0]; 
                			  $referencial2 = $referencial[1]; 
			  
                              if (empty($referencial2)){
				                    $variable_url = $variables_adicional.'&action=del&tid='.$row[$llave_primaria].$tab;
  				                    $ajax = "open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			                  } 
                              else
                              {
				   	                $var1 = explode('=',$referencial1);
					                $var_url1 = $var1[0] ;
					                $var_url2 = trim($var1[1]) ;
					                // var2RA
              					    $var2 = explode('=',$referencial2);
                					$var_url3 = $var2[0] ;
                					$var_url4 = trim($var2[1]) ;		
                					$variables_adicional1 ='&'.$var_url1.'='.trim($row[$var_url2]).'&'.$var_url3.'='.$var_url4;
                					$ajax = $this->kaipi_url_pop($archivo_ref,'&action=del&id='.$row[$llave_primaria].$variables_adicional1,$largo,$ancho);
			                 }
			           }
			           echo '<a href="'.$ajax.'" class=" btn btn-xs btn-danger" role="button" title="Eliminar registro"><i class="icon-trash"></i></a> ';
		      }
		      echo '</td>';			 
         }
         echo "</tr>";		
		}
		echo "</tbody></table>";
        
 		pg_free_result ($resultado) ;
	 }
 
/*-------------------------------------------------------------------------------------------*/		
function mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    // actiones de la grilla   
    if ($action == 'S'){
        echo '<th> Acciones </th>';
    }
?>
    </tr></thead>
     <tbody>
<?php     
	$i = 1;
    
	while($row=mysql_fetch_assoc($resultado)) {
	 echo '<tr>';
	 foreach ($row as $item){
    	  if(is_numeric($item)){
    		if ($i == 1)  {
    		   echo "<td align='right'>".$item.'</td>';
     		}else{
    	   	   echo "<td align='right'>".number_format($item,2).'</td>';
    		}
    	   }else{
    		  echo '<td>'.$item.'</td>';
    	   }
     	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
         
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
        
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo '</tr>';		
	$i = 1;
	}
	echo '</tbody></table>';
    
 	mysql_free_result($resultado) ;
}
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID3($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    $numero_campos = $this->num_campos($resultado,$tipo) ;
    
    $this->cabecera($resultado,$tipo,$numero_campos);
   
      switch ($tipo){
        
    	case 'mysql':    
                        $this->mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'postgress':  
    					$this->postgress_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'oracle':  
                        $this->oracle_gridTab3($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    				    break;	
    	break;
      }
}  
 
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
     $numero_campos = $this->num_campos($resultado,$tipo) ;
    
     $this->cabecera($resultado,$tipo,$numero_campos);
   
      switch ($tipo){
        
    	case 'mysql':    
                        $this->mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'postgress':  
    					$this->postgress_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'oracle':  
                        $this->oracle_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    				    break;	
    	break;
      }
}    
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRIDF($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$var1,$var2)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 //table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
 
 //  class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
 
  echo '<table class="table table-striped table-bordered table-hover table-checkable  datatable" width="100%">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
			// '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
		 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		//$var1,$var2
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).'&'.$var1.'='.$var2.$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
			// '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }
 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_SIMPLE($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 //table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
 
 //  class="table table-hover table-striped table-highlight-head table-tabletools datatable" 
 
  echo '<table class="table table-striped table-bordered table-hover table-checkable" width="100%">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}		

	$nombre_datos = ucwords($cabecera);

	$cabecera = str_replace('_',' ',$nombre_datos);

	$estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
 
	echo "<th ".$estilo." >".$cabecera.'</th>';

	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
		 foreach ($row as $item){
			//  if(is_numeric($item)){
			//	    echo "<td align='right'>".number_format($item,2)."</td>";
			//   }else{
					echo "<td>".$item."</td>";
		//	   }
			   $i++;
		  }
	  $i = 1;
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
			// '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo "</tr>";		
	
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }
  /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/		
 function KP_GRID_TOOL_WEB($resultado,$tipo)  {
    
    $numero_campos = $this->num_campos($resultado,$tipo);
    
    $this->cabeceraTool($resultado,$tipo,$numero_campos);
 
     switch ($tipo){
        
    	case 'mysql':    
                        $this->mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'postgress':  
    					$this->postgress_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    					break;
    	case 'oracle':  
                        $this->oracle_ToolWeb($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
    				    break;	
    	break;
      }
		
 }
 function KP_GRID_TOOL_REPORTE($resultado,$tipo,$porcentaje)  {
     
     $numero_campos = $this->num_campos($resultado,$tipo);
     
     $this->cabeceraToolreporte($resultado,$tipo,$numero_campos,$porcentaje);
     
     // $this->mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
     
     switch ($tipo){
         
         //     case 'mysql':
         //      break;
         case 'postgress':
             $this->postgress_grid_reporte($resultado,$tipo,'','','N','','','','');
             break;
         case 'oracle':
             $this->oracle_ToolWeb($resultado,$tipo,'','','N','','','','');
             break;
             break;
     }
     
 }
 function KP_GRID_TOOL_ANCHO($resultado,$tipo,$porcentaje)  {
     
     $numero_campos = $this->num_campos($resultado,$tipo);
     
     $this->cabeceraToolancho($resultado,$tipo,$numero_campos,$porcentaje);
     
     // $this->mysql_grid($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab);
     
     switch ($tipo){
         
         //     case 'mysql':
         //      break;
         case 'postgress':
             $this->postgress_grid_reporte($resultado,$tipo,'','','N','','','','');
             break;
         case 'oracle':
             $this->oracle_ToolWeb($resultado,$tipo,'','','N','','','','');
             break;
             break;
     }
     
 }
  /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/		
 function KP_GRID_TOOL_WEB_AJAX($resultado,$tipo)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				     $numero_campos = oci_num_fields($resultado) - 1;
				      break;	
	break;
}
 
 //data-horizontal-width="150%"
echo '<table class="table table-striped table-bordered table-hover table-checkable table-tabletools table-colvis datatable" width="100%">
 <thead> <tr>';
 $k = 1;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$k) ;	
						 break;						 
		break;
	}		 
	echo "<th><small>".$cabecera.'</small></th>';
	$k++;  
  }
// actiones de la grilla  
 
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	   
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	   
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
break;
case 'oracle':   {
 
 while($row=oci_fetch_assoc($resultado)) {
	echo "<tr>";
	foreach ($row as $item){
				echo "<td><small>".trim($item)."</small></td>";
	}
    echo "</tr>";		
 }
 echo "</tbody></table>";
 oci_free_statement ($resultado) ;  }
 break;  
 
 break;
}	
			
 }
 
 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_TOOL($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
?>
 <table class="table table-striped table-bordered table-hover table-checkable table-tabletools table-colvis datatable" width="100%">
 <thead> <tr>
<?php 
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
?> 
 </tr>
  </thead> 
  <tbody> 
<?php 
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;

	while($row=oci_fetch_assoc($resultado)) {

	 echo "<tr>";

	 foreach ($row as $item){
	  if(is_numeric($item)){
     		if ($i == 1)  {
        		 echo "<td align='right'>".$item."</td>";
         		}else{
        		 echo "<td align='right'>".number_format($item,2)."</td>";
        		}

	   }else{
               echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	   if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
	 	 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo '</tr>';		
	$i = 1;
	}
 ?>  
 </tbody>
  </table> 
 <?php
 oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }
  /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_NOTOOL($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$p1)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 //table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
 
 //  class="table table-hover table-striped table-highlight-head table-tabletools datatable" 
 
echo '<table class="table table-striped table-hover table-checkable" width="'.$p1.'">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	   if ($action == 'S'){
		echo '<td width="12%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }
 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_WEB($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$MAX)  {
 
    $numero_campos = $this->num_campos($resultado,$tipo);
 
?>
 <table class="table table-striped table-bordered table-hover table-highlight-head table-checkable datatable" border="0" width="<?php echo $MAX ?>">
    <thead> 
        <tr>
            <?php 
             $k = 0;
             for ($i = 0; $i<= $numero_campos; $i++){
            	switch ($tipo){
            		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
            						 break;
            		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
            						 break;
            		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
            						 break;						 
            		break;
            	}		 
            	echo "<th>".$cabecera.'</th>';
            	$k++;  
              }
              
              // actiones de la grilla  
                if ($action == 'S'){
                    echo '<th> Acciones </th>';
                }
            ?>    
         </tr>
    </thead>
 <tbody>
<?php  
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
  
  break;
  
  case 'oracle':  
  {
	$i = 1;
	   while($row=oci_fetch_assoc($resultado)) {
	       echo '<tr>';
        	 foreach ($row as $item){
            	  if(is_numeric($item)){
                		if ($i == 1)  {
                		 echo "<td align='right'>".$item."</td>";
                 		}else{
                		 echo "<td align='right'>".number_format($item,2)."</td>";
                		}
            	   }else{
        		        echo "<td>".$item."</td>";
            	   }
             	   $i++;
        	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
 ?>   
   </tbody>
 </table>
<?php
     oci_free_statement ($resultado) ;  }
     break;  
 break;
  }	
			
 }
  /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_WEB_P($resultado,$tipo,$llave_primaria,$indicador,$action,$visor,$editar,$del,$MAX)  {
 
    $numero_campos = $this->num_campos($resultado,$tipo);
 
?>
 <table class="table table-striped table-bordered table-hover table-highlight-head table-checkable datatable" border="0" width="<?php echo $MAX ?>">
    <thead> 
        <tr>
            <?php 
             $k = 0;
             for ($i = 0; $i<= $numero_campos; $i++){
            	switch ($tipo){
            		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
            						 break;
            		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
            						 break;
            		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
            						 break;						 
            		break;
            	}		 
            	echo "<th>".$cabecera.'</th>';
            	$k++;  
              }
              
              // actiones de la grilla  
                if ($action == 'S'){
                    echo '<th> Acciones </th>';
                }
            ?>    
         </tr>
    </thead>
 <tbody>
<?php  
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
  
  break;
  
  case 'oracle':  
  {
	$i = 1;
	   while($row=oci_fetch_assoc($resultado)) {
	       echo '<tr>';
             $columna = 1;
        	 foreach ($row as $item){
        	   if  ($columna == $indicador){
                   $porcentaje = $item.'%';
                   if ($item > 95){
                    $imagen = '<img src="../kimages/verde.png" title="'.$porcentaje.'" />';
                   } 
                   if (($item > 75) && ($item < 95) ) {
                     $imagen = '<img src="../kimages/amarillo.png" title="'.$porcentaje.'" />';
                   }
                    if (($item > 0) && ($item < 75) ) {
                     $imagen = '<img src="../kimages/advertencia.png" title="'.$porcentaje.'" />';
                   }
        	       
                   
                    echo "<td align='center'>".$imagen."</td>";
        	   }
               else{
            	  if(is_numeric($item)){
                		if ($i == 1)  {
                		 echo "<td align='right'>".$item."</td>";
                 		}else{
                		 echo "<td align='right'>".number_format($item,2)."</td>";
                		}
            	   }else{
        		        echo "<td>".$item."</td>";
            	   }
              }     
           	   $i++;
               $columna ++;   
        	  }
	 
 	echo "</tr>";		
	$i = 1;
	}
 ?>   
   </tbody>
 </table>
<?php
     oci_free_statement ($resultado) ;  }
     break;  
 break;
  }	
			
 }
 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_WEBQ($resultado,$tipo,$llave_primaria,$ref,$action,$visor,$editar,$del,$MAX)  {
 
    $numero_campos = $this->num_campos($resultado,$tipo);
 
?>
 <table class="table table-striped table-bordered table-hover table-highlight-head table-checkable datatable" border="0" width="<?php echo $MAX ?>">
    <thead> 
        <tr>
            <?php 
             $k = 0;
             for ($i = 0; $i<= $numero_campos; $i++){
            	switch ($tipo){
            		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
            						 break;
            		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
            						 break;
            		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
            						 break;						 
            		break;
            	}		 
            	echo "<th>".$cabecera.'</th>';
            	$k++;  
              }
              
              // actiones de la grilla  
                if ($action == 'S'){
                    echo '<th> Acciones </th>';
                }
            ?>    
         </tr>
    </thead>
 <tbody>
<?php  
 // para tiopo de conecion se crea la estructura
 $i = 1;
	   while($row=oci_fetch_assoc($resultado)) {
	       echo '<tr>';
        	 foreach ($row as $item){
            	  if(is_numeric($item)){
                		if ($i == 1)  {
                		 echo "<td align='right'>".$item."</td>";
                 		}else{
                		 echo "<td align='right'>".number_format($item,2)."</td>";
                		}
            	   }else{
        		        echo "<td>".$item."</td>";
            	   }
             	   $i++;
        	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="70">';
		if (!empty($visor)) {
		
		 	$ajax = ' onClick="'."javascript:abrirCod('".$row[$llave_primaria]."')".'"';
           
            echo ' <a data-toggle="modal" href="'.$ref.'" class="btn btn-success" '.$ajax.'><i class="icon-zoom-in icon-white"></i></a>';
		 
         }
		 
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
 ?>   
   </tbody>
 </table>
<?php
     oci_free_statement ($resultado) ;  
  } 
/*  consulta con parametro de edicion principal-----------------------------*/					
function KP_GRID_casillero($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
	case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 echo '<table class="table table-striped table-bordered table-hover table-checkable datatable" border="0" width="100%"><thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':{ 
						 $cabecera = pg_field_name($resultado,$k) ;	
						 if ( $cabecera == 'Seleccion')
						 	 $cabecera_check = $i;
						 break;
	    }
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>";
		 echo $item; 
		}else{
		 echo "<td align='right'>";
		 echo number_format($item,2); 
		}
	   }else{
		echo "<td>";
		echo ($item) ;
	   }
	   echo "</td>";
	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
		}
		if (!empty($editar)) {	
		  $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
			$variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
		 }
 									   echo "</tr>";		
									   $i = 1;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  $i = 0;
										  foreach ($row as $item){
 												if ( $cabecera_check == $i) {
													 $codigo = trim($row[$llave_primaria]);
												//	 $evento = "javascript:seleccion($('#chk".$codigo.":checked').val(),".$codigo.")";
													 $evento = "javascript:seleccion($(this),".$codigo.")";
													
 													 echo "<td>";
												 	 echo '<div id="che"><input name="chk'.$codigo.'" type="checkbox" onChange="'.$evento.'" id="chk'.$codigo.'">' ;
													 echo "</div></td>";
												 }else{	
													 echo "<td>";
												 	 echo ($item) ;
													 echo "</td>";
												} 
											$i++;		 
										  }
									   									    /// actions 
									 if ($action == 'S'){
										echo '<td width="90">';
											if (!empty($visor)) {
													 $variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												    echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											}
											if (!empty($editar)) {	
													 $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
											}
											if (!empty($del)){ 			  
													 $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
											}
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   }
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		}		
/*  consulta con parametro de edicion principal-----------------------------*/					
function KP_GRID_check($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
	case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 echo '<table class="table table-striped table-bordered table-hover table-checkable datatable" border="0" width="100%"><thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':{ 
						 $cabecera = pg_field_name($resultado,$k) ;	
						 if ( $cabecera == 'Seleccion')
						 	 $cabecera_check = $i;
						 break;
	    }
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>";
		 echo $item; 
		}else{
		 echo "<td align='right'>";
		 echo number_format($item,2); 
		}
	   }else{
		echo "<td>";
		echo ($item) ;
	   }
	   echo "</td>";
	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="90">';
		if (!empty($visor)) {
													 $variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												    echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											}
		if (!empty($editar)) {	
													 $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
											}
											if (!empty($del)){ 			  
													 $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
											}
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   $i = 1;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  $i = 0;
										  foreach ($row as $item){
 												if ( $cabecera_check == $i) {
													 $codigo = trim($row[$llave_primaria]);
													 echo "<td>";
												 	 echo '<input name="chk'.$codigo.'" type="checkbox" id="chk'.$codigo.'">' ;
													 echo "</td>";
												 }else{	
													 echo "<td>";
												 	 echo ($item) ;
													 echo "</td>";
												} 
											$i++;		 
										  }
									   									    /// actions 
									 if ($action == 'S'){
										echo '<td width="90">';
											if (!empty($visor)) {
													 $variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												    echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											}
											if (!empty($editar)) {	
													 $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
											}
											if (!empty($del)){ 			  
													 $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
											}
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   }
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		}
	/*  consulta con parametro de edicion principal 
------------------------------------------------------*/					
function KP_GRID_POP($resultado,$tipo,$llave_primaria,$archivo_ref,$variables_adicional,$action,$visor,$editar,$del,$largo,$ancho,$tab)  {
 
        $numero_campos = $this->num_campos($resultado,$tipo) ;
        
        $this->cabecera($resultado,$tipo, $numero_campos);
        
     
 
         if ($tipo == 'postgress'){
         
            $this->postgress_gridPop($resultado,$tipo,$llave_primaria,$archivo_ref,$variables_adicional,$action,$visor,$editar,$del,$largo,$ancho,$tab);
         }
         
        
  
 
}	
//-----------------------------------------------------------------------------------------------
/*  consulta con parametro de edicion principal 
$resultado,$tipo, $sql_nivel2,$enlace,$accion,'shijo','#tab2'
		------------------------------------------------------*/					
		function KP_arbol2($resultado,$tipo,$sql_nivel2,$enlace,$accion,$clave,$tab)  {
	    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
						 $i = 1;
						 while($row=mysql_fetch_assoc($resultado)) {
							if ($i == 1)  {
								echo '<li class="open-default">';
							}
							else{
								echo '<li>';
							}
								echo '<a href="javascript:void(0);"><i></i>';
								echo $row["nombre"];
								echo '<span class="arrow"></span></a>';
					   // aqui 2 nivel
					    $sql_nivel2_completo = $sql_nivel2.$row["hijo"];
					   	$resultado_dos_nivel = mysql_query($sql_nivel2_completo);
						echo '<ul class="sub-menu">';
					    while($row_dos_nivel=mysql_fetch_assoc($resultado_dos_nivel)) {
							
							//$accion,'shijo','#tab2'
							//$accion = 'action=del_opcion&tid='.$datos['idusuario'].'&opcion=';
							$variables  = $accion.$row_dos_nivel[$clave].$tab;
							$javascript = "javascript:abrir('".$enlace."','".$variables."');";
							echo '<li><a href="'.$javascript.'"><i></i>';
							echo $row_dos_nivel["snombre"];
							echo '</a></li>';
						}
						echo '</ul>';
						mysql_free_result($resultado_dos_nivel) ;
						echo '</li>';
						$i++;
						 }
 						mysql_free_result($resultado) ;
					 }
  break;
  case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	if ($i == 1)  {
		echo '<li class="open-default">';}
	 else{
		 echo '<li>'; 
	 }
	 echo '<a href="javascript:void(0);"><i></i>';
	 echo $row["nombre"];
	 echo '<span class="arrow"></span></a>';
					   // aqui 2 nivel
					    $sql_nivel2_completo = $sql_nivel2.$row["hijo"];
					   	$resultado_dos_nivel = pg_query($sql_nivel2_completo);
						echo '<ul class="sub-menu">';
					    while($row_dos_nivel=pg_fetch_assoc($resultado_dos_nivel)) {
							
							//$accion,'shijo','#tab2'
							//$accion = 'action=del_opcion&tid='.$datos['idusuario'].'&opcion=';
							$variables  = $accion.$row_dos_nivel[$clave].$tab;
							$javascript = "javascript:abrir('".$enlace."','".$variables."');";
							echo '<li><a href="'.$javascript.'"><i></i>';
							echo $row_dos_nivel["snombre"];
							echo '</a></li>';
						}
						echo '</ul>';
						pg_free_result($resultado_dos_nivel) ;
						echo '</li>';
						$i++;
						 }
 						pg_free_result($resultado) ;
					 }
					 break;
									   
 				}
		}
/*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_web_noticia($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
			break;
		  }
			//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
			
			echo '<table border="0" width="100%">';
			
			echo '<tbody>';
			
			    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
									  $i = 1;
									   while($row=mysql_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
											   if(is_numeric($item)){
												   if ($i == 1)  {
										  			echo "<td align='center' class='noticia_orden'>";
													echo $item; 
												   }
									  			}else{
													 echo "<td class='noticia_texto'>";
											         $variable_url = 'tid='.$this->clave_inyeccion().$row[$llave_primaria];
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												 	 echo '<a href="'.$ajax.'" class="noticia_texto">'.$item.'</a> ';
 													 
												}
										    echo "</td>";
											$i++;
										  }
									    /// actions 
										if ($action == 'S'){
										echo '<td>';
											if (!empty($visor)) 
												echo '<a class="btn btn-success" href="'.$archivo_ref.'?action=visor&id='.$row[$llave_primaria].$tab.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											if (!empty($editar)) 	
												echo '<a class="btn btn-info" href="'.$archivo_ref.'?action=editar&id='.$row[$llave_primaria].$tab.'"> <i class="icon-edit icon-white"></i></a> ';
											if (!empty($del)) 			  
												echo '<a class="btn btn-danger" href="'.$archivo_ref.'?action=del&id='.$row[$llave_primaria].$tab.'"> <i class="icon-trash icon-white"></i></a> ';
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   $i = 1;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
 													 echo "<td>";
												 	 echo ($item) ;
													 echo "</td>";
										  }
									   									    /// actions 
									 if ($action == 'S'){
										echo '<td>';
											if (!empty($visor)) 
												echo '<a class="btn btn-success" href="'.$archivo_ref.'?action=visor&id='.$row[$llave_primaria].$tab.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											if (!empty($editar)) 	
												echo '<a class="btn btn-info" href="'.$archivo_ref.'?action=editar&id='.$row[$llave_primaria].$tab.'"> <i class="icon-edit icon-white"></i></a> ';
											if (!empty($del)) 			  
												echo '<a class="btn btn-danger" href="'.$archivo_ref.'?action=del&id='.$row[$llave_primaria].$tab.'"> <i class="icon-trash icon-white"></i></a> ';
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   }
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		}					
 /*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_CTA($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
			break;
		  }

		  $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
		  
		    echo '<table class="table table-striped table-bordered table-hover table-checkable" border="0" width="100%">';

			echo '<thead> <tr>';

			$k = 0;

			for ($i = 0; $i<= $numero_campos; $i++){
				
				 switch ($tipo){
					 case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
									  break;
					 case 'postgress':  
									   $cabecera = pg_field_name($resultado,$k) ;	
									   break;
					break;
				  }		 
			       echo "<th ".$estilo." >".$cabecera.'</th>';

				 $k++;  

			}

 		    /// actiones de la grilla  

			if ($action == 'S'){
				echo '<th> Acciones';
				echo '</th>';			 
			}
			    echo '</tr></thead>';
			    echo '<tbody>';
			
			    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
									  $i = 1;
									   while($row=mysql_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
											   if(is_numeric($item)){
												   if ($i == 1)  {
										  			echo "<td align='right'>";
													echo $item; 
												   }
												    else{
														echo "<td align='right'>";
														echo number_format($item,2); 
													}
									  			}else{
													 echo "<td>";
												 	 echo ($item) ;
												}
										    echo "</td>";
											$i++;
										  }
									    /// actions 
										if ($action == 'S'){
										echo '<td>';
											if (!empty($visor)) {
													 $variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												    echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											}
											if (!empty($editar)) {	
													 $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
											}
											if (!empty($del)){ 			  
													 $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
											}
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   $i = 1;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
 													 echo "<td>";
												 	 if ($row['Nivel'] == 1)
													 	echo '<b>'.trim($item).'</b>' ;
													 else
														 echo (trim($item)) ;
													
													 echo "</td>";
										  }
									   									    /// actions 
									 if ($action == 'S'){
										echo '<td>';
											if (!empty($visor)) {
													 $variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
												    echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											}
											if (!empty($editar)) {	
													 $variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
											}
											if (!empty($del)){ 			  
													 $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
												 	 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
													 echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
											}
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   }
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		}   
/*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_POP_asientos($resultado,$tipo,
																 $llave_primaria,
																 $archivo_ref,
																 $enlaceModal,
																 $variables_adicional,
							  									$action,
							  									$visor,
							  									$editar,
							  									$del,
							  									$largo,$ancho,$tab)  {
		 
							  									    
			 $modal = explode('-',$enlaceModal);
			 
			 
			 $enlaceModalAux    = $modal[0];
			 $enlaceModalCostos = $modal[1];
		 
			 $numero_campos = pg_num_fields($resultado) - 1;
	 		 
  			echo '<table class="table table-hover datatable" width="100%" id="tableAsiento" >
						<thead>
							<tr>';
 						  $k = 0;
						  $ndebe = 0;
						  $nhaber = 0;
						  $sdebe = 0;
						  $shaber = 0;			
  						  // actiones de la grilla  
					      if ($action == 'S'){
							   echo '<th> Acciones </th>';
				 	      }
   				          //-------------------------------------------------------------
				          for ($i = 0; $i<= $numero_campos-1; $i++){
 									$cabecera = pg_field_name($resultado,$k) ;	
									if ($cabecera=='Debe'){
									 $ndebe = $i ;
									}
									if ($cabecera=='Haber'){
									  $nhaber = $i ; 
									}
					           
									echo "<th>".$cabecera.'</th>';
					                $k++;  
				            }
				            
   				         echo '</tr>
                                </thead>
                                   <tbody>';
              
                   				$numero_ver = $numero_campos-1;	   
                	            $i = 0;
	            
 	 		   while($row=pg_fetch_assoc($resultado)) {
	  		       echo "<tr>";
  	                      if ($action == 'S'){
	  						   echo '<td>';
     						   if (!empty($visor)) {
    							echo '<a class="btn btn-xs" href="'.$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho).'"> 
    									  <i class="icon-zoom-in icon-white"></i></a> ';
    							}
         					    if (!empty($editar)) 	{
        									  if (empty($variables_adicional)){
        												$variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
        									  }
        									  else{ 
        										$variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
        										$ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
        							  		    echo '<a class="btn btn-xs" title="Editar registro" href="'. $ajax.'"><i class="icon-edit icon-white"></i></a> ';
        									  }
        						}
        				 		if (!empty($del)){ 		
        						 			 $variable_url = 'action=del&tid='.$row[$llave_primaria].'&'.$variables_adicional.$tab;
        		 							 $largo = 30;
        									 $ancho = 30;
        									 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
        		 							 echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
        				 		}
				 		         // auxiliar del asiento // data-toggle="modal" data-target="#myModal"   $enlaceModal
 					           if ($row['aux'] == 'S') {
 					  					echo '<a class="btn btn-xs"   
													   href="#" data-toggle="modal" 
													   data-target="#'.$enlaceModalAux.'"  
													   onClick="ViewDetAuxiliar('.$row[$llave_primaria]. ')">
														<i class="icon-user icon-white"></i>
                                              </a>';
							    }else{
					  					echo '<a class="btn btn-xs" title="No aplica auxiliar" href="#"> 
                                                 <i class="icon-eye-close icon-white"></i>
                                             </a>';
							   }
							   if (!empty($enlaceModalCostos)) {
							   echo '<a class="btn btn-xs"
													   href="#" data-toggle="modal"
													   data-target="#'.$enlaceModalCostos.'"
													   onClick="ViewDetCostos('.$row[$llave_primaria]. ')">
														<i class="icon-asterisk icon-white"></i>
                                              </a>';
							   }
					           echo '</td>';	
		
		                       foreach ($row as $item){
		                                if ($i <= $numero_ver){
 			                                    if ($i == 0 ){
 			                                          echo "<td>".$item;
 			                                    }else{
				                                     if(is_numeric($item)){
                                				           $id_dato = $row[$llave_primaria];
                                				           $odebe  = 'name="debe_'.$id_dato.'" id="debe_'.$id_dato.'"';
                                				           $ohaber = 'name="haber_'.$id_dato.'"id="haber_'.$id_dato.'"';
				
				                                            if ($ndebe == $i) {
                                             					echo '<td style="padding: 1px">
                                                                      <input '.$odebe.' type="number" style="text-align:right;"  required
                                                                                        class="form-control" step="0.01"   max="999999999"  
                                            											onChange="javascript:montoDetalle('."'D'".',this.value'.','.$row[$llave_primaria].');"  value="'.$row['Debe'].'">';
                                            					$sdebe = $sdebe + $row['Debe'];
				                                            }else{
                                            					  if ($nhaber == $i) {
                                             					    echo '<td style="padding: 1px">
                                                                           <input '.$ohaber.' type="number"  required   style="text-align:right;" 
                                                                                              class="form-control" step="0.01"   max="999999999" 
                                            									              onChange="javascript:montoDetalle('."'H'".',this.value'.','.$row[$llave_primaria].');"  value="'.$row['Haber'].'">';	
                                            					  $shaber = $shaber + $row['Haber'];																
                                            					}
                                            					else{
                                            					           echo "<td>".number_format($item,2); 	
                                            					}
				                                           }
 				                                 }else{
				                                          echo "<td>".$item ;
				                                 }
		                               }
		                               $i++; 	
		                          }
		                      }
		              }
 		              echo "</tr>";	
		              $i = 0;	
	           }
		echo "<tr>";
		echo "<td></td><td></td><td></td><td></td>";
		echo "<td>";
		echo '<input name="total_debe" type="number" class="form-control" id="total_debe" style="text-align:right" max="999999999" min="0" step="0.01"  value="'.$sdebe.'" readonly="readonly" >';
		echo "</td>";
		echo "<td>";
		echo '<input name="total_haber" type="number" class="form-control" id="total_haber" style="text-align:right" max="999999999" min="0"  step="0.01" value="'.$shaber.'" readonly="readonly" > ';
		echo "</td>";
		echo "</tr>";	
		echo "</tbody></table>";
 		pg_free_result ($resultado) ;
 
 }
//--------------------
 function KP_GRID_POP_asientos_te($resultado,$tipo,
 $llave_primaria,
 $archivo_ref,
 $enlaceModal,
 $variables_adicional,
 $action,
 $visor,
 $editar,
 $del,
 $largo,$ancho,$tab)  {
     
     
     $modal = explode('-',$enlaceModal);
     
     
     $enlaceModalAux    = $modal[0];
     $enlaceModalCostos = $modal[1];
     
     $numero_campos = pg_num_fields($resultado) - 1;
     
     echo '<table class="table table-hover datatable" width="100%" id="tableAsiento" >
						<thead>
							<tr>';
     $k = 0;
     $ndebe = 0;
     $nhaber = 0;
     $sdebe = 0;
     $shaber = 0;
     // actiones de la grilla
     if ($action == 'S'){
         echo '<th> Acciones </th>';
     }
     //-------------------------------------------------------------
     for ($i = 0; $i<= $numero_campos-1; $i++){
         $cabecera = pg_field_name($resultado,$k) ;
         if ($cabecera=='Ingreso'){
             $ndebe = $i ;
         }
         if ($cabecera=='Egreso'){
             $nhaber = $i ;
         }
         
         echo "<th>".$cabecera.'</th>';
         $k++;
     }
     
     echo '</tr>
                                </thead>
                                   <tbody>';
     
     $numero_ver = $numero_campos-1;
     $i = 0;
     
     while($row=pg_fetch_assoc($resultado)) {
         echo "<tr>";
         if ($action == 'S'){
             echo '<td>';
             if (!empty($visor)) {
                 echo '<a class="btn btn-xs" href="'.$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho).'">
    									  <i class="icon-zoom-in icon-white"></i></a> ';
             }
             if (!empty($editar)) 	{
                 if (empty($variables_adicional)){
                     $variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
                 }
                 else{
                     $variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
                     $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
                     echo '<a class="btn btn-xs" title="Editar registro" href="'. $ajax.'"><i class="icon-edit icon-white"></i></a> ';
                 }
             }
             if (!empty($del)){
                 $variable_url = 'action=del&tid='.$row[$llave_primaria].'&'.$variables_adicional.$tab;
                 $largo = 30;
                 $ancho = 30;
                 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
                 echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
             }
             // auxiliar del asiento // data-toggle="modal" data-target="#myModal"   $enlaceModal
             if ($row['aux'] == 'S') {
                 echo '<a class="btn btn-xs"
													   href="#" data-toggle="modal"
													   data-target="#'.$enlaceModalAux.'"
													   onClick="ViewDetAuxiliar('.$row[$llave_primaria]. ')">
														<i class="icon-user icon-white"></i>
                                              </a>';
             }else{
                 echo '<a class="btn btn-xs" title="No aplica auxiliar" href="#">
                                                 <i class="icon-eye-close icon-white"></i>
                                             </a>';
             }
             if (!empty($enlaceModalCostos)) {
                 echo '<a class="btn btn-xs"
													   href="#" data-toggle="modal"
													   data-target="#'.$enlaceModalCostos.'"
													   onClick="ViewDetCostos('.$row[$llave_primaria]. ')">
														<i class="icon-asterisk icon-white"></i>
                                              </a>';
             }
             echo '</td>';
             
             foreach ($row as $item){
                 if ($i <= $numero_ver){
                     if ($i == 0 ){
                         echo "<td>".$item;
                     }else{
                         if(is_numeric($item)){
                             $id_dato = $row[$llave_primaria];
                             $odebe  = 'name="debe_'.$id_dato.'" id="debe_'.$id_dato.'"';
                             $ohaber = 'name="haber_'.$id_dato.'"id="haber_'.$id_dato.'"';
                             
                             if ($ndebe == $i) {
                                 echo '<td style="padding: 1px">
                                                                      <input '.$odebe.' type="number" style="text-align:right;"  required
                                                                                        class="form-control" step="0.01"   max="999999999"
                                            											onChange="javascript:montoDetalle('."'D'".',this.value'.','.$row[$llave_primaria].');"  value="'.$row['Ingreso'].'">';
                                 $sdebe = $sdebe + $row['Ingreso'];
                             }else{
                                 if ($nhaber == $i) {
                                     echo '<td style="padding: 1px">
                                                                           <input '.$ohaber.' type="number"  required   style="text-align:right;"
                                                                                              class="form-control" step="0.01"   max="999999999"
                                            									              onChange="javascript:montoDetalle('."'H'".',this.value'.','.$row[$llave_primaria].');"  value="'.$row['Egreso'].'">';
                                     $shaber = $shaber + $row['Egreso'];
                                 }
                                 else{
                                     echo "<td>".number_format($item,2);
                                 }
                             }
                         }else{
                             echo "<td>".$item ;
                         }
                     }
                     $i++;
                 }
             }
         }
         echo "</tr>";
         $i = 0;
     }
     echo "<tr>";
     echo "<td></td><td></td><td></td><td></td>";
     echo "<td>";
     echo '<input name="total_debe" type="number" class="form-control" id="total_debe" style="text-align:right" max="999999999" min="0" step="0.01"  value="'.$sdebe.'" readonly="readonly" >';
     echo "</td>";
     echo "<td>";
     echo '<input name="total_haber" type="number" class="form-control" id="total_haber" style="text-align:right" max="999999999" min="0"  step="0.01" value="'.$shaber.'" readonly="readonly" > ';
     echo "</td>";
     echo "</tr>";
     echo "</tbody></table>";
     pg_free_result ($resultado) ;
     
 }
 
 /*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
function KP_GRID_POP_pago_detalle($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							   $ancho,$tab)  {
		 
 switch ($tipo){
	 
  case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
				   break;
  case 'postgress':  
				   $numero_campos = pg_num_fields($resultado) - 1;
				   break;
}
		 
  echo '<table class="table table-striped table-bordered table-hover table-checkable datatable" width="'.$ancho.'" border="0">';
 
  echo '<thead> <tr>';
  $k = 0;
  $ndebe = 0;
  $nhaber = 0;
  $sdebe = 0;
  $shaber = 0;			
  /// actiones de la grilla  
 
  for ($i = 0; $i<= $numero_campos ; $i++){
	  
	switch ($tipo){
	  
	  case 'mysql': $cabecera = mysql_field_name($resultado,$i);	
					break;
	  
	  case 'postgress':  {
					$cabecera = pg_field_name($resultado,$k) ;	
					if ($cabecera=='Liquidar')
					 $liquidar = $i ;
					if ($cabecera=='Haber')
					  $nhaber = $i ; 
					}
					break;
	  }		 
	  
	  echo "<th align='center'>".$cabecera.'</th>';
	  
	  $k++;  
  }
 
  echo '</tr></thead><tbody>';
  //// para tiopo de conecion se crea la estructura
  switch ($tipo){
	  
	case 'postgress': {
 	 
	 $i = 0;
	 
	 while($row=pg_fetch_assoc($resultado)) {
	
	   echo "<tr>";
 		
		foreach ($row as $item){
		
		  if ($liquidar == $i) {
			  echo "<td width='150'>";
		
			  $id_dato = $row[$llave_primaria];
		
			  $liquido  = 'name="liquido_'.$id_dato.'" id="liquido_'.$id_dato.'"';
		
			  $valor = $row["Saldo"];
			  
			  if ($row['Liquidar'] == 0)
			    $valor_liquidar = $valor;
			  else
			  	$valor_liquidar = $row['Liquidar'];
			    
			     echo '<input '.$liquido.' type="number" style="text-align:right; 
						 	  border:rgba(193,193,193,1.00)" 
							  step="0.01" min="0" max="999999999"  
							  onChange="javascript:valida_saldo(this,this.value,'.$valor.');" value="'.$valor_liquidar.'">';
				
				$sdebe = $sdebe + $row['Liquidar'];
			   echo "</td>"	;
		  }else	 {
   				echo "<td>".$item."</td>";
		  }	
		  $i++; 	
 		}
		echo "</tr>";	
		 $i = 0;	
	  }
	  echo "</tbody></table>";
 	  pg_free_result ($resultado) ;
	}
	break;
break;
}	
 }			

 	
/*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_web_faq($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
			break;
		  }
			//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
			
			echo '<table border="0" width="100%">';
			echo '<tbody>';
			    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
									  $i = 1;
									  $j = 1;
									   while($row=mysql_fetch_assoc($resultado)) {
									 	
										  foreach ($row as $item){
 											  echo "<tr>";
												 if ($i == 1)  {
										  			echo "<td align='left' class='pregunta'>";
													echo  $j.'. '.$item.' <img src="../kimages/Like.png" align="absmiddle"/>'; 
									  			}else{
													 echo "<td>";
												 	 echo  html_entity_decode(htmlspecialchars( $item));
  													 
												}
										    echo "</td>";
											echo "</tr>";		
											$i++;
										  }
									    /// actions 

									   $i = 1;
									   $j++;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
 													 echo "<td>";
												 	 echo ($item) ;
													 echo "</td>";
										  }
									   									    /// actions 
									 if ($action == 'S'){
										echo '<td>';
											if (!empty($visor)) 
												echo '<a class="btn btn-success" href="'.$archivo_ref.'?action=visor&id='.$row[$llave_primaria].$tab.'"> <i class="icon-zoom-in icon-white"></i></a> ';
											if (!empty($editar)) 	
												echo '<a class="btn btn-info" href="'.$archivo_ref.'?action=editar&id='.$row[$llave_primaria].$tab.'"> <i class="icon-edit icon-white"></i></a> ';
											if (!empty($del)) 			  
												echo '<a class="btn btn-danger" href="'.$archivo_ref.'?action=del&id='.$row[$llave_primaria].$tab.'"> <i class="icon-trash icon-white"></i></a> ';
										echo '</td>';			 
									   }
 									   echo "</tr>";		
									   }
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		}	
//////////////////////////////////////////
		function KP_GRID_kardex($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
		    
		    switch ($tipo){
		        
		        case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
		        break;
		        case 'postgress':
		            $numero_campos = pg_num_fields($resultado) - 1;
		            break;
		            break;
		    }
		    
		    
		    echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%"> <thead> <tr>';
		    
		    $k              = 0;
		    $valida_asiento = 0;
		    
		    for ($i = 0; $i<= $numero_campos; $i++){
		        
		        switch ($tipo){
		            case 'mysql':     $cabecera = mysql_field_name($resultado,$i);
		            break;
		            case 'postgress':
		                $cabecera = pg_field_name($resultado,$k) ;
		                break;
		                break;
		        }
		        
		        if (trim($cabecera) == 'Asiento'){  $valida_asiento = 1; 	}
		        
		        echo '<th bgcolor="#91b7f5">'.strtoupper ($cabecera).'</th>';
		        
		        $k++;
		    }
		    
		    /// actiones de la grilla
		    
		    if ($action == 'S'){  echo '<th> Acciones </th>'; }
		    
		    echo '</tr></thead><tbody>';
		    
		    
		    switch ($tipo){
		        
		        case 'mysql':    {  }   break;
		        
		        case 'postgress':{
		            
		            $nsuma1 = 0;
		            $nsuma2 = 0;
		            $nsuma3 = 0;
		            
		            while($row=pg_fetch_assoc($resultado)) {
		                
		                echo "<tr>";
		                $i    = 1;
		                
		                foreach ($row as $item){
		                    $n1 = $row[$this->var1];
		                    $n2 = $row[$this->var2];
		                    $n3 = $row[$this->var3];
		                    
		                    if(is_numeric($item)){
		                        if ($i == 1)  {
		                            echo "<td>".$item;
		                        }else{
		                            echo "<td align='right'>".number_format($item,4);
		                        }
		                    }else{
		                        echo "<td>".$item;
		                    }
		                    $i++;
		                }
		                //----------------------------------------------
		                if ($action == 'S'){
		                    echo '<td width="90">';
		                    
		                    if (!empty($editar)) {
		                        
		                        $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
		                        $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		                        echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
		                        
		                    }
		                    
		                    if (!empty($visor)) {
		                        //	 $variable_url = 'action=visor&tid='.$row[$llave_primaria].$tab; #
		                        $ajax = "javascript:abrirReporte(".$row[$llave_primaria].")";
		                        
		                        if ($visor == 'elimina'){
		                            $c = '<i class="icon-trash icon-white">';
		                        }else {
		                            $c = '<i class="icon-zoom-in icon-white">';
		                        }
		                        
		                        echo '<a class="btn btn-xs" href="#" onClick="'.$ajax.'">'. $c.'</i></a> ';
		                    }
		                    
		                    if ( $valida_asiento == 1){
		                        
		                        $ajax = "javascript:abrirAux(".$row[$llave_primaria].")";
		                        $c = '<i class="icon-ambulance icon-white">';
		                        echo '<a class="btn btn-xs" href="#" onClick="'.$ajax.'">'. $c.'</i></a> ';
		                    }
		                    
		                    echo '</td>';
		                }
		                
		                $nsuma1 = $nsuma1 + $n1;
		                $nsuma2 = $nsuma2 + $n2;
		                $nsuma3 = $nsuma3 + $n3;
		                echo "</tr>";
		                
		            }
		            /// total
		            $columna = $this->ncolumna;
		            echo "<tr>";
		            for ($i = 1; $i<= $columna - 1  ; $i++){
		                echo "<td></td>";
		            }
		            if (!empty($this->var1)) {
		                echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		            }
		            if (!empty($this->var2)) {
		                echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		            }
		            if (!empty($this->var3)) {
		                echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
		            }
		            echo "</tr>";
		            echo "</tbody></table>";
		            pg_free_result ($resultado) ;
		        }
		        break;
		        break;
		    }
		}
/*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_CTAA($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$font='')  {
		    
		    switch ($tipo){
		        
		        case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
		        break;
		        case 'postgress':
		            $numero_campos = pg_num_fields($resultado) - 1;
		            break;
		            break;
		    }
		    
			$estilo = 'style ="background-color: #4993eb;color:#ffffff;" ';
		    
			$font_estilo = '';

			if (!empty($font)){
				$font_estilo = ' style="font-size:'.$font.'px" ';
			}
		    echo '<table id="caso_1" class="table table-bordered table-hover table-tabletools" border="0" width="100%" '.$font_estilo .'> <thead> <tr>';
		    
		    $k              = 0;

		    $valida_asiento = 0;
		    
		    for ($i = 0; $i<= $numero_campos; $i++){
		        
		        switch ($tipo){

		            case 'mysql':     $cabecera = mysql_field_name($resultado,$i);
		            break;

		            case 'postgress':
		                $cabecera = pg_field_name($resultado,$k) ;
		                break;
		                break;
		        }
		        
		        if (trim($cabecera) == 'Asiento'){  $valida_asiento = 1; 	}

				$cabecera = str_replace('_',' ',$cabecera);
		        
		        echo '<th '.$estilo .'>'.ucfirst($cabecera).'</th>';
		        
		        $k++;
		    }
		    
		    /// actiones de la grilla
		    
		    if ($action == 'S'){  echo '<th> Acciones </th>'; }
		    
		 	   echo '</tr></thead><tbody>';
		    
		    
		    	switch ($tipo){
		        
		       		 case 'mysql':    {  }   break;
		        
		        	 case 'postgress':{
		            
							$nsuma1 = 0;
							$nsuma2 = 0;
							$nsuma3 = 0;
		            
							while($row=pg_fetch_assoc($resultado)) {
									
									echo "<tr>";
									$i    = 1;
									
									foreach ($row as $item){
										$n1 = $row[$this->var1];
										$n2 = $row[$this->var2];
										$n3 = $row[$this->var3];
										
										if(is_numeric($item)){
											if ($i == 1)  {
												echo "<td>".$item;
											}else{
												echo "<td align='right'>".number_format($item,2);
											}
										}else{
											echo "<td>".$item;
										}
										$i++;
									}
									//----------------------------------------------
									if ($action == 'S'){
										echo '<td width="90">';
										
										if (!empty($editar)) {
											
											$variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
											$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
											echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
											
										}
										
										if (!empty($visor)) {
											//	 $variable_url = 'action=visor&tid='.$row[$llave_primaria].$tab; #
											$ajax = "javascript:abrirReporte("."'".trim($row[$llave_primaria])."'".")";
											
											if ($visor == 'elimina'){
												$c = '<i class="icon-trash icon-white">';
											}else {
												$c = '<i class="icon-zoom-in icon-white">';
											}
											
											echo '<a class="btn btn-xs" href="#" onClick="'.$ajax.'">'. $c.'</i></a> ';
										}
										
										if ( $valida_asiento == 1){
											
											$ajax = "javascript:abrirAux(".$row[$llave_primaria].")";
											$c = '<i class="icon-ambulance icon-white">';
											echo '<a class="btn btn-xs" href="#" onClick="'.$ajax.'">'. $c.'</i></a> ';
										}
										
										echo '</td>';
									}
									
									$nsuma1 = $nsuma1 + $n1;
									$nsuma2 = $nsuma2 + $n2;
									$nsuma3 = $nsuma3 + $n3;
									echo "</tr>";
									
								}

						/// total
						$columna = $this->ncolumna;
						echo "<tr>";
						for ($i = 1; $i<= $columna - 1  ; $i++){
							echo "<td></td>";
						}
						if (!empty($this->var1)) {
							echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
						}
						if (!empty($this->var2)) {
							echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
						}
						if (!empty($this->var3)) {
							echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
						}
						echo "</tr>";
						echo "</tbody></table>";
						pg_free_result ($resultado) ;
					}
					break;
		        break;
		    }
		}
//----------------
function KP_GRID_COSTO($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
    
    switch ($tipo){
        case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
        break;
        case 'postgress':
            $numero_campos = pg_num_fields($resultado) - 1;
            break;
            break;
    }
    
    //table table-striped table-bordered table-hover table-checkable table-tabletools datatable
    
    //'<table class="table table-striped table-bordered table-hover table-checkable datatable" border="0" width="100%">';
    
    
    echo '<table class="table table-bordered table-hover table-tabletools" id="tableCosto" border="0" width="100%">
        <thead> <tr>';
    
    $k       = 0;
    $idmarca = 0;
    for ($i = 0; $i<= $numero_campos; $i++){
        switch ($tipo){
            case 'mysql':     $cabecera = mysql_field_name($resultado,$i);
            break;
            case 'postgress':
                $cabecera = pg_field_name($resultado,$k) ;
                break;
                break;
        }
        echo "<th>".$cabecera.'</th>';
        
        if ($cabecera == 'marca'){
            $idmarca   =  $i;
        }
        
        $k++;
    }
    $idmarca = $idmarca +  1;
    
    /// actiones de la grilla
    if ($action == 'S'){
        echo '<th> Acciones </th>';
    }
    
    echo '</tr></thead>';
    echo '<tbody>';
    //// para tiopo de conecion se crea la estructura
    switch ($tipo){
        case 'mysql':    {
            $i = 1;
            while($row=mysql_fetch_assoc($resultado)) {
                echo "<tr>";
                foreach ($row as $item){
                    if(is_numeric($item)){
                        if ($i == 1)  {
                            echo "<td align='right'>".$item;
                        }
                        else{
                            echo "<td align='right'>".number_format($item,2);
                        }
                    }else{
                        echo "<td>".$item;
                    }
                    echo "</td>";
                    $i++;
                }
                /// actions
                if ($action == 'S'){
                    echo '<td width="90">';
                    if (!empty($visor)) {
                        //	 $variable_url = 'action=visor&tid='.$row[$llave_primaria].$tab; #
                        $ajax = "javascript:abrirReporte(".$row[$llave_primaria].")";
                        echo '<a class="btn btn-success" href="#" onClick="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';
                    }
                    if (!empty($editar)) {
                        $variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
                        $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
                        echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
                    }
                    if (!empty($del)){
                        $variable_url = 'action=del&tid='.$row[$llave_primaria].$tab;
                        $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
                        echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
                    }
                    echo '</td>';
                }
                echo "</tr>";
                $i = 1;
            }
            echo "</tbody></table>";
            mysql_free_result($resultado) ;
            
        }
        break;
        //---------------------------------------------------------
        case 'postgress':{
            $nsuma1 = 0;
            $nsuma2 = 0;
            $nsuma3 = 0;
            while($row=pg_fetch_assoc($resultado)) {
                
                echo "<tr>";
                $i = 1;
                foreach ($row as $item){
                    $n1 = $row[$this->var1];
                    $n2 = $row[$this->var2];
                    $n3 = $row[$this->var3];
                     
                    
                    if(is_numeric($item)){
                        if ($i == 1)  {
                            echo "<td>".$item;
                        }else{
                            echo "<td align='right'>".number_format($item,2);
                        }
                    }else{
                      
                        if ( $idmarca == $i){
                            
                            $d = '<input type="checkbox" id="myCheck' .$row[$llave_primaria].'"   onclick="myFunction('. $row[$llave_primaria] .',this)" '   . '>'   ;
			    
                           echo "<td>".$d;
                           
                        }else  {
                            echo "<td>".$item;
                        }
                        
                        
                        
                    }
                    $i++;
                }
                
                
                if ($action == 'S'){
                    echo '<td width="90">';
                    if (!empty($editar)) {
                        $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
                        $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
                        echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
                    }
                    if (!empty($visor)) {
                        //	 $variable_url = 'action=visor&tid='.$row[$llave_primaria].$tab; #
                        $ajax = "javascript:abrirReporte(".$row[$llave_primaria].")";
                        echo '<a class="btn btn-xs" href="#" onClick="'.$ajax.'"> <i class="icon-print icon-white"></i></a> ';
                    }
                    echo '</td>';
                }
                
                
                $nsuma1 = $nsuma1 + $n1;
                $nsuma2 = $nsuma2 + $n2;
                $nsuma3 = $nsuma3 + $n3;
                echo "</tr>";
                
            }
            /// total
            $columna = $this->ncolumna;
            echo "<tr>";
            for ($i = 1; $i<= $columna - 1  ; $i++){
                echo "<td></td>";
            }
            if (!empty($this->var1)) {
                echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
            }
            if (!empty($this->var2)) {
                echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
            }
            if (!empty($this->var3)) {
                echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
            }
            echo "</tr>";
            echo "</tbody></table>";
            pg_free_result ($resultado) ;
        }
        break;
        break;
    }
}
//--------------------
function KP_GRID_NEW($resultado,$tipo,$action,$editar,$del,$llave_primaria)  {
    
    switch ($tipo){
        
        case 'mysql':    $numero_campos = mysql_num_fields($resultado)   ;
                         break;
        
        case 'postgress':  $numero_campos = pg_num_fields($resultado) ;
                           break;
    }
     
    echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
          <thead> 
            <tr>';
    
    $k = 0;
    
    for ($i = 0; $i<= $numero_campos -  2; $i++){
        
        switch ($tipo){
            
            case 'mysql': $cabecera = mysql_field_name($resultado,$i);
                          break;
            
            case 'postgress':
                          $cabecera = pg_field_name($resultado,$k) ;
                          break;
        }
     
        echo "<th>".$cabecera.'</th>';
        
        $k++;
    }
    
    /// actiones de la grilla
    if ($action == 'S'){
        
        echo '<th>  &nbsp;  </th>';
   
    }
    
    echo '</tr>
            </thead>
              <tbody>';
     
   
    switch ($tipo){
        
        case 'postgress':{
            $nsuma1 = 0;
            $nsuma2 = 0;
            $nsuma3 = 0;
            
            while($row=pg_fetch_assoc($resultado)) {
                
                echo "<tr>";
                $i = 1;
               
                for ($k = 0; $k<= $numero_campos  - 2 ; $k++){
                    $n1 = $row[$this->var1];
                    $n2 = $row[$this->var2];
                    $n3 = $row[$this->var3];
                    
                    $campo = pg_field_name($resultado,$k) ;
                 
                    $item = $row[$campo];
                    
                    if(is_numeric($item)){
                        if ($i == 1)  {
                            echo "<td>".$item. "</td>";
                        }else{
                            echo "<td align='right'>".number_format($item,2). "</td>";
                        }
                    }else{
                        echo "<td>".$item. "</td>";
                    }
                    $i++;
                 
                }
                 
                if ($action == 'S'){
                    echo '<td width="10%">';
                      
                    if (!empty($editar)) {
                        $evento ="abrir_grid('edit',".$row[$llave_primaria].")";
                        echo '<a class="btn btn-xs" href="#" onClick="'.$evento.'"> <i class="icon-edit icon-white"></i></a> ';
                    }
                    if (!empty($del)) {
                        $evento ="abrir_grid('del',".$row[$llave_primaria].")";
                        echo '<a class="btn btn-xs" href="#" onClick="'.$evento.'"> <i class="icon-remove icon-white"></i></a> ';
                    }
                    echo '</td>';
                    
                    
                }
                
                $nsuma1 = $nsuma1 + $n1;
                $nsuma2 = $nsuma2 + $n2;
                $nsuma3 = $nsuma3 + $n3;
                echo "</tr>";
                
            }
            /// total
            $columna = $this->ncolumna;
            echo "<tr>";
            for ($i = 1; $i<= $columna - 1  ; $i++){
                echo "<td></td>";
            }
            if (!empty($this->var1)) {
                echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
            }
            if (!empty($this->var2)) {
                echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
            }
            if (!empty($this->var3)) {
                echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
            }
            echo "</tr>";
            echo "</tbody></table>";
            pg_free_result ($resultado) ;
        }
        break;
     }
}


/*  consulta con parametro de edicion principal 
		------------------------------------------------------*/					
		function KP_GRID_REPORTE($resultado,$tipo,$espacio,$v1,$v2,$v3,$v4)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
		  	case 'oracle':  
				    		 $numero_campos = oci_num_fields($resultado) - 1;
				      break;						   
			break;
		  }
			//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 			$tbHtml .= '<p>&nbsp;</p><table class="borde">';
 			$tbHtml .= '<tr>';
			$k = 0;
			for ($i = 0; $i<= $numero_campos; $i++){
				
				 switch ($tipo){
					 case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
									  break;
					 case 'postgress':  
									   $cabecera = pg_field_name($resultado,$k) ;	
									   break;
					 case 'oracle':   $cabecera = oci_field_name($resultado,$k) ;
									   
					break;
				  }		 
			     $tbHtml .= "<td class='cabecerai' align='center'>".$cabecera.'</td>';
				 $k++;  
			}
 
			    $tbHtml .='</tr>';
			    $tbHtml .='<tbody>';
			
			    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
									  $i = 1;
									   while($row=mysql_fetch_assoc($resultado)) {
									 	  echo ' <tr class="filai">';
										  foreach ($row as $item){
											   if(is_numeric($item)){
												   if ($i == 1)  {
										  			$tbHtml .= "<td align='right'>";
													$tbHtml .= $item; 
												   }
												    else{
														$tbHtml .= "<td align='right'>";
														$tbHtml .= number_format($item,2); 
													}
									  			}else{
													 $tbHtml .= "<td>";
												 	 $tbHtml .= ($item) ;
												}
										    $tbHtml .= "</td>";
											$i++;
										  }
									    /// actions 
  									   $tbHtml .= "</tr>";		
									   $i = 1;
									   }
									   $tbHtml .= "</tbody></table></div>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									  {
									  $counter = 1;		
									  //$v1,$v2,$v3,$v4
									  $t1 = 0;
									  $t2 = 0;
									  $t3 = 0;
									  $t4 = 0;
									    
									   while($row=pg_fetch_assoc($resultado)) {
									 	  
 										  if ($counter % 2 ) {
											  $clase = 'class="filap"';
 										  } else {
											  $clase = 'class="filai"';
  										  }
										$tbHtml .= "<tr>";
 										  foreach ($row as $item){
 											   if(is_numeric($item)){
 												 	if (is_integer($item)){
														$tbHtml .= '<td '.$clase.' align="center">';
														$tbHtml .= ($item) ;
													}	 
													else{
													  if (is_float($item)){
														$tbHtml .= '<td '.$clase.'  align="right">';
														$tbHtml .= ($item) ;
													  }else{
														$tbHtml .= '<td '.$clase.' align="center">';
														$tbHtml .= ($item) ;
													  }	  	
													}	
											   } else	{
 														$tbHtml .= '<td '.$clase.' align="justify">';
														$tbHtml .= ($item) ;
												}														
 													 $tbHtml .= "</td>";
 										  }
										  $counter ++;
 									   if ($v1 <> '')
									   		$t1 = $t1 + $row[$v1];
									   if ($v2 <> '')
									  	    $t2 = $t2 + $row[$v2];
									   if ($v3 <> '')
									        $t3 = $t3 + $row[$v3];
									   if ($v4 <> '')
									        $t4 = $t4 + $row[$v4];
										   	 
 									   $tbHtml .= "</tr>";		
									   }
									   if ($espacio > 1){
										for ( $i = 1 ; $i <= $espacio ; $i ++) {
											$columnas .= '<td></td>';
										}
										
 									   	$tbHtml .= "<tr>".$columnas;
										////////////////////////
										 $clase = 'class="cabecerai"';
										$columnas_total = '';
										if ($v1 <> '')
									   		$columnas_total .= '<td '.$clase.' align="center">'.$t1.'</td>';
									   if ($v2 <> '')
									  	   $columnas_total .= '<td '.$clase.' align="center">'.$t2.'</td>';
									   if ($v3 <> '')
									       $columnas_total .= '<td'.$clase.' align="center">'.$t3.'</td>';
									   if ($v4 <> '')
									       $columnas_total .= '<td '.$clase.' align="center">'.$t4.'</td>';
									   
									    $tbHtml .= $columnas_total."</tr>";	
									    }
									   $tbHtml .= "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			return $tbHtml;
		}	
		
//consulta con parametro de edicion principal 

function KP_GRID_CTA_query($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$decimal=2,$font='10px')  {

 
      //  $cantidad = pg_num_rows ($resultado)  ;
    
	
        $numero_campos = pg_num_fields($resultado) - 1;
   
         $nsuma1 = 0;
         $nsuma2 = 0;
         $nsuma3 = 0;
         $nsuma4 = 0;
		 $nsuma5 = 0;
 
         echo '<table id ="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size:'.$font.';table-layout: auto"><thead> <tr>';
         $k = 0;
 
         for ($i = 0; $i<= $numero_campos; $i++){

              $cabecera = pg_field_name($resultado,$k) ;	

			  $cabecera1 = str_replace("_"," ",$cabecera);


        	 echo "<th>".ucwords($cabecera1) .'</th>';

             $k++;  
         }
 
         echo '</tr></thead><tbody>';
  
 		 $n1 = 0;
 		 $n2 = 0;
 		 $n3 = 0;
 		 $n4 = 0;
		  $n5 = 0;
         
    	 while($row=pg_fetch_assoc($resultado)) {
    	     
     	   echo "<tr>";
     	   $i = 1;
           
    	   foreach ($row as $item){
             		 $n1 = $row[$this->var1];
             		 $n2 = $row[$this->var2];
             		 $n3 = $row[$this->var3];
            		 $n4 = $row[$this->var4];
					 $n5 = $row[$this->var5];
            				 
             		 if(is_numeric($item)){
                		  if ($i == 1)  {
                 		         	echo "<td align='right'>".$item; 
                            }else{
                         	        echo "<td align='right'>".number_format($item,$decimal); 
                            }
            		 }else{
                                    echo "<td>".$item ;
                     }
            	    echo "</td>";
            		$i++;										  
    	  }
     	  echo "</tr>";
    	      $nsuma1 = $nsuma1 + $n1;
     		  $nsuma2 = $nsuma2 + $n2;
      		  $nsuma3 = $nsuma3 + $n3;
    		  $nsuma4 = $nsuma4 + $n4;
			  $nsuma5 = $nsuma5 + $n5;
    	 }
 	     $columna = $this->ncolumna;
         echo "<tr>";
     		for ($i = 1; $i<= $columna - 1  ; $i++){
    			echo "<td></td>";
    		}	
    		if (!empty($this->var1)) {
       		  echo '<td align="right"><b>'.number_format($nsuma1,$decimal).'</b></td>';
    		}
    		if (!empty($this->var2)) {
       		  echo '<td align="right"><b>'.number_format($nsuma2,$decimal).'</b></td>';
    		}	 
    		if (!empty($this->var3)) {
       		  echo '<td align="right"><b>'.number_format($nsuma3,$decimal).'</b></td>';
    		}
    		if (!empty($this->var4)) {
       		  echo '<td align="right"><b>'.number_format($nsuma4,$decimal).'</b></td>';
    		}
			if (!empty($this->var5)) {
				echo '<td align="right"><b>'.number_format($nsuma5,$decimal).'</b></td>';
		   }
 	    echo "</tr></tbody></table>";
 	
 	    unset($row); //eliminamos la fila para evitar sobrecargar la memoria
 	    
        pg_free_result ($resultado) ;
    
   return $nsuma1 + $nsuma2 + $nsuma3 + $nsuma4+ $nsuma5;
    
 }

 /*
 visor de grilla visualizacion con datos 
 */

function KP_GRID_CTA_visor($resultado,$tipo,$decimal=2,$font="10px")  {

 
   
  
	  $numero_campos = pg_num_fields($resultado) - 1;
 
	   $nsuma1 = 0;
	   $nsuma2 = 0;
	   $nsuma3 = 0;
	   $nsuma4 = 0;

	   echo '<table id ="tabla1" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size:'.$font.';table-layout: auto"><thead> <tr>';
	   $k = 0;

	   for ($i = 0; $i<= $numero_campos; $i++){

			$cabecera = pg_field_name($resultado,$k) ;	

			$cabecera1 = str_replace("_"," ",$cabecera);


			$ancho = '';

			if ( !empty($this->anchot[$i])){
				$ancho = ' width="'.$this->anchot[$i].'%" ';
			}	


		   echo '<th '.$ancho .' >'.ucwords($cabecera1) .'</th>';

		   $k++;  
	   }

	   echo '</tr></thead><tbody>';

		$n1 = 0;
		$n2 = 0;
		$n3 = 0;
		$n4 = 0;
		$n5 = 0;
		$n6 = 0;
		$n7 = 0;
	   
	   while($row=pg_fetch_assoc($resultado)) {
		   
		  echo "<tr>";
		  $i = 1;
		 
		 foreach ($row as $item){
					$n1 = $row[$this->var1];
					$n2 = $row[$this->var2];
				 	$n3 = $row[$this->var3];
			  	    $n4 = $row[$this->var4];
					$n5 = $row[$this->var5];
					$n6 = $row[$this->var6];
					$n7 = $row[$this->var7];  
						   
					if(is_numeric($item)){

						if ($i == 1)  {
									echo "<td align='right'>".$item; 
						  }else{
								   echo "<td align='right'>".number_format($item,$decimal); 
						  }
				   }else{
								  echo "<td>".$item ;
				   }
				  echo "</td>";

				  $i++;										  
		}
		 echo "</tr>";

			$nsuma1 = $nsuma1 + $n1;
		    $nsuma2 = $nsuma2 + $n2;
			$nsuma3 = $nsuma3 + $n3;
			$nsuma4 = $nsuma4 + $n4;
			$nsuma5 = $nsuma5 + $n5;
			$nsuma6 = $nsuma6 + $n6;
			$nsuma7 = $nsuma7 + $n7;
	   }
		
	   $columna = $this->ncolumna;

	   echo "<tr>";
		   for ($i = 1; $i<= $columna - 1  ; $i++){
			  echo "<td></td>";
		  }	

		  if (!empty($this->var1)) {
			   echo '<td align="right"><b>'.number_format($nsuma1,$decimal).'</b></td>';
		  }

		  if (!empty($this->var2)) {
			   echo '<td align="right"><b>'.number_format($nsuma2,$decimal).'</b></td>';
		  }	 
		  if (!empty($this->var3)) {
			   echo '<td align="right"><b>'.number_format($nsuma3,$decimal).'</b></td>';
		  }
		  if (!empty($this->var4)) {
			   echo '<td align="right"><b>'.number_format($nsuma4,$decimal).'</b></td>';
		  }

		  if (!empty($this->var5)) {
			echo '<td align="right"><b>'.number_format($nsuma5,$decimal).'</b></td>';
	      }	 
	     if (!empty($this->var6)) {
			echo '<td align="right"><b>'.number_format($nsuma6,$decimal).'</b></td>';
	     }
	     if (!empty($this->var7)) {
			echo '<td align="right"><b>'.number_format($nsuma7,$decimal).'</b></td>';
	    }



	   echo "</tr></tbody></table>";
   
	   unset($row); //eliminamos la fila para evitar sobrecargar la memoria
	   
	  pg_free_result ($resultado) ;

   
 return $nsuma1 + $nsuma2 + $nsuma3 + $nsuma4  + $nsuma5 + $nsuma6 + $nsuma7;
  
} 

// grid de balance de datos				
function KP_GRID_CTA_balance($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
			break;
		  }
			//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
			
			echo '<table class="table table-striped table-bordered table-hover table-tabletools" border="0" width="100%">';
			echo '<thead> <tr>';
			$k = 0;
			for ($i = 0; $i<= $numero_campos; $i++){
				
				 switch ($tipo){
					 case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
									  break;
					 case 'postgress':  
									   $cabecera = pg_field_name($resultado,$k) ;	
									   break;
					break;
				  }		
				  if ($i > 0 ) {
			       echo "<th>".$cabecera.'</th>';
				   if ($cabecera=='Debe')
						$ndebe = $i ;
					if ($cabecera=='Haber')
						$nhaber = $i ; 
 					if ($cabecera=='Saldo')
						$nsaldo = $i ; 
 				   }
				 $k++;  
			}
 		    /// actiones de la grilla  
			 
			    echo '</tr></thead>';
			    echo '<tbody>';
			
			    //// para tiopo de conecion se crea la estructura
				 switch ($tipo){
					 case 'mysql':    {
									  $i = 1;
									   while($row=mysql_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  foreach ($row as $item){
											 if ($i > 1)  {
												 echo "<td>";
												 	 echo ($item) ;
											   }
										  }	   		  
 										    echo "</td>";
											$i++;
 									    /// actions 
  									   echo "</tr>";		
									   $i = 1;
									   }
									   echo "</tbody></table>";
 									   mysql_free_result($resultado) ;
						 
					 }
									  break;
					 case 'postgress':  
									   {
									  
									   while($row=pg_fetch_assoc($resultado)) {
									 	  echo "<tr>";
										  $i = 1;
										  foreach ($row as $item){
 											 if ($i > 1)  {
												 if ($ndebe == $i) {
															  $sdebe  = $sdebe + $row['Debe'];
												  }
												  if ($nhaber == $i) {
															   $shaber = $shaber + $row['Haber'];
												   }
												   if ($nsaldo == $i) {
															   $ssaldo = $ssaldo + $row['Saldo'];
													}
												 
												 if(is_numeric($item)){
													 if ($i == 2)  {
														 echo "<td>";
														 echo ($item) ;
													 }	 
													 else{	 
														 echo "<td align='right'>";
														 if ($item == 0){
														 	echo '' ;
														  }
														  else	
														  {
														 	echo ($item) ;
 															
 														  }
													 }	 
												 }else	
												 {
 													 echo "<td>";
												 	 echo ($item) ;
												 } 
  												}
										    echo "</td>";
											$i++;										  }
									   	 	
									   }
									  echo "<tr>";
									   echo "<td></td><td></td>";
									   echo '<td align="right" >';
									   echo '<B>'.number_format($sdebe, 2, ".", ",").'</B>' ;
									   echo "</td>";
									   echo '<td align="right">';
									   echo '<B>'.number_format($shaber, 2, ".", ",").'</B>' ; ;
 									   echo "</td>";
									   echo '<td align="right">';
									   echo '<B>'.number_format($ssaldo, 2, ".", ",").'</B>' ; ;
 									   echo "</td>";
									   echo "</tr>";	
									 
									   echo "</tbody></table>";
 									   pg_free_result ($resultado) ;
						 
					 }
									   break;
					break;
				  }	
			
		} 

		function KP_GRID_EXCEL_doc($resultado,$tipo)  {
		 
			switch ($tipo){
			   case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
								break;
			   case 'postgress':  
								 $numero_campos = pg_num_fields($resultado) - 1;
								 break;
			   case 'oracle':  
								$numero_campos = oci_num_fields($resultado) - 1;
						break;	
  
			  break;
			}
			  //table table-striped table-bordered table-hover table-checkable table-tabletools datatable
			  
			  $tbHtml .= '<table style="border-collapse: collapse; border: 1px solid #AAAAAA;" border="0" width="100%" cellspacing="0" cellpadding="0">';

			  $tbHtml .= '<thead> <tr>';
			  $k = 0;
			  for ($i = 0; $i<= $numero_campos; $i++){
				  
				   switch ($tipo){
					   case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
										break;
					   case 'postgress':  
										 $cabecera = pg_field_name($resultado,$k) ;	
										 break;
					  case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;
						   break;						   
					  break;
					}		 
				   $tbHtml .= '<th style="border-collapse: collapse; border: 1px solid #AAAAAA; font-size: 11px; padding: 2px;">'.ucfirst($cabecera).'</th>';
				   
				   $k++;  
			  }
   
				  $tbHtml .='</tr></thead>';
				  $tbHtml .='<tbody>';
			  
				  //// para tiopo de conecion se crea la estructura
				   switch ($tipo){
					   case 'mysql':    {
										$i = 1;
										 while($row=mysql_fetch_assoc($resultado)) {
											 echo "<tr>";
											foreach ($row as $item){
												 if(is_numeric($item)){
													 if ($i == 1)  {
														$tbHtml .= "<td align='right'>";
													  $tbHtml .= $item; 
													 }
													  else{
														  $tbHtml .= "<td align='right'>";
														  $tbHtml .= number_format($item,2); 
													  }
													}else{
													   $tbHtml .= "<td>";
														$tbHtml .= ($item) ;
												  }
											  $tbHtml .= "</td>";
											  $i++;
											}
										  /// actions 
										   $tbHtml .= "</tr>";		
										 $i = 1;
										 }
										 $tbHtml .= "</tbody></table>";
										  mysql_free_result($resultado) ;
						   
					   }
										break;
					   case 'postgress':  
										 {
										 while($row=pg_fetch_assoc($resultado)) {
											 $tbHtml .= "<tr>";
											foreach ($row as $item){
														$tbHtml .= '<td style="border-collapse: collapse; border: 1px solid #AAAAAA; font-size: 11px; padding: 2px;" >';
														$tbHtml .= ($item) ;
													    $tbHtml .= "</td>";
											}
																				 /// actions 
										
										  $tbHtml .= "</tr>";		
										 }
										 $tbHtml .= "</tbody></table>";
										  pg_free_result ($resultado) ;
						   
					   }
										 break;
					   case 'oracle':  
										 {
										 while($row=oci_fetch_assoc($resultado)) {
											 $tbHtml .= "<tr>";
											foreach ($row as $item){
														$tbHtml .= "<td>".$item."</td>";
											 }
																				 /// actions 
										
										  $tbHtml .= "</tr>";		
										 }
										 $tbHtml .= "</tbody></table>";
										   oci_free_statement ($resultado) ;
						   
					   }
										 break;
					  break;
					}	
			  return $tbHtml;
		  }	


/*  consulta con parametro de edicion principal  KP_GRID_EXCEL
		------------------------------------------------------*/					
		function KP_GRID_EXCEL($resultado,$tipo)  {
		 
 			
			  $numero_campos = pg_num_fields($resultado) - 1;
							 
			//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
			
			$tbHtml .= '<table border="1" width="100%" style="font-size: 14px;border-collapse: collapse" bordercolor="#111111">';
			
			$tbHtml .= '<thead> <tr>';
			
			$k = 0;
			
			for ($i = 0; $i<= $numero_campos; $i++){
			    
				    $cabecera      = pg_field_name($resultado,$k) ;	
					
				    $cadena_cabera = strtoupper($cabecera);
				    
				    $cabecera      = str_replace("_"," ",$cadena_cabera);
				    
				    $tbHtml .= "<th>".strtoupper($cabecera).'</th>';
 			        
				    $k++;  
			}
 
			    $tbHtml .='</tr></thead>';
			    
			    $tbHtml .='<tbody>';
			 
			   while($row=pg_fetch_assoc($resultado)) {
			       
									 	  $tbHtml .= "<tr>";
									 	  
										  foreach ($row as $item){
 													 $tbHtml .= "<td>";
												 	 $tbHtml .= ($item) ;
													 $tbHtml .= "</td>";
										  }
									   									    /// actions 
									        $tbHtml .= "</tr>";		
 									 }
	           
 									 $tbHtml .= "</tbody></table></html>";
	           
 			   pg_free_result ($resultado) ;
						 
					 
			return $tbHtml;
		}	
/*-------------------------------------------------------------------------------------------*/			

function KP_GRID_PLANTILLA($resultado,$tipo)  {
		 
	switch ($tipo){
	   case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
						break;
	   case 'postgress':  
						 $numero_campos = pg_num_fields($resultado) - 1;
						 break;
	   case 'oracle':  
						$numero_campos = oci_num_fields($resultado) - 1;
				break;	

	  break;
	}
	  //table table-striped table-bordered table-hover table-checkable table-tabletools datatable
	  
	  $tbHtml .= '<table style="border-collapse: collapse; border: 1px solid #AAAAAA;" border="0" width="100%" cellspacing="0" cellpadding="0">';
	  $tbHtml .= '<thead> <tr>';
	  $k = 0;
	  for ($i = 0; $i<= $numero_campos; $i++){
		  
		   switch ($tipo){
			   case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
								break;
			   case 'postgress':  
								 $cabecera = pg_field_name($resultado,$k) ;	
								 break;
			  case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;
				   break;						   
			  break;
			}		 
		   $tbHtml .= '<th align="center" style="border-collapse: collapse; border: 1px solid #AAAAAA;padding: 3px">'.$cabecera.'</th>';
		   $k++;  
	  }

		  $tbHtml .='</tr></thead>';
		  $tbHtml .='<tbody>';
	  
		  //// para tiopo de conecion se crea la estructura
		   switch ($tipo){
			   case 'mysql':    {
								$i = 1;
								 while($row=mysql_fetch_assoc($resultado)) {
									 echo "<tr>";
									foreach ($row as $item){
										 if(is_numeric($item)){
											 if ($i == 1)  {
												$tbHtml .= "<td align='right'>";
											  $tbHtml .= $item; 
											 }
											  else{
												  $tbHtml .= "<td align='right'>";
												  $tbHtml .= number_format($item,2); 
											  }
											}else{
											   $tbHtml .= "<td>";
												$tbHtml .= ($item) ;
										  }
									  $tbHtml .= "</td>";
									  $i++;
									}
								  /// actions 
								   $tbHtml .= "</tr>";		
								 $i = 1;
								 }
								 $tbHtml .= "</tbody></table></html>";
								  mysql_free_result($resultado) ;
				   
			   }
								break;
			   case 'postgress':  
								 {
								 while($row=pg_fetch_assoc($resultado)) {
									 $tbHtml .= "<tr>";
									foreach ($row as $item){
												$tbHtml .= '<td style="border-collapse: collapse; border: 1px solid #AAAAAA;padding: 3px">';
												$tbHtml .= ($item) ;
											   $tbHtml .= "</td>";
									}
																		 /// actions 
								
								  $tbHtml .= "</tr>";		
								 }
								 $tbHtml .= "</tbody></table></html>";
								  pg_free_result ($resultado) ;
				   
			   }
								 break;
			   case 'oracle':  
								 {
								 while($row=oci_fetch_assoc($resultado)) {
									 $tbHtml .= "<tr>";
									foreach ($row as $item){
												$tbHtml .= "<td>".$item."</td>";
									 }
																		 /// actions 
								
								  $tbHtml .= "</tr>";		
								 }
								 $tbHtml .= "</tbody></table>";
								   oci_free_statement ($resultado) ;
				   
			   }
								 break;
			  break;
			}	
	  return $tbHtml;
  }
/*
*/	
function KP_sumatoria($ncolumna,$va1="",$va2="",$va3="",$va4="",$va5="",$va6="",$va7="")  {

      $this->ncolumna 	=$ncolumna;
      $this->var1    	=$va1;
      $this->var2   	=$va2;
      $this->var3       =$va3;
	  $this->var4       =$va4;
	  $this->var5   	=$va5;
      $this->var6       =$va6;
	  $this->var7       =$va7;

}
/*
*/
function KP_with($anchot="")  {

 	$this->anchot    	= explode(",",$anchot);
 
}
 
/*
*/							  
function KP_GRID_POP_cos($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab)  {
		 
 switch ($tipo){
  case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
				   break;
 case 'postgress':  
				   $numero_campos = pg_num_fields($resultado) - 1;
				   break;
}
  echo '  <table id="jsontable" class="display table-condensed" cellspacing="0" width="100%">';
  echo '<thead> <tr>';
  $k = 0;
  
  $nsuma1 = 0;
  $nsuma2 = 0;
  $nsuma3 = 0;
   /// actiones de la grilla  
  if ($action == 'S'){
   echo '<th> Acciones </th>';
  }
  for ($i = 0; $i<= $numero_campos  ; $i++){
   switch ($tipo){
	case 'mysql': $cabecera = mysql_field_name($resultado,$i);	
					break;
	case 'postgress':  {
					$cabecera = pg_field_name($resultado,$k) ;	
					if ($cabecera=='Monto')
					  $nmonto = $i ;
 					if ($cabecera=='total')
					  $ntotal = $i ; 
 					}
					break;
	}		 
	echo "<th>".$cabecera.'</th>';
	  $k++;  
  }
  echo '</tr></thead><tbody>';
  //// para tiopo de conecion se crea la estructura
  switch ($tipo){
	case 'postgress': {
	 $numero_ver = $numero_campos  ;	   
	 $i = 0;
	 $stotal = 0;
	 $n1= 0;
	 $n2= 0;
	 $n3= 0;
	 while($row=pg_fetch_assoc($resultado)) {
	  echo "<tr>";
		/// actions 
		//kaipi_enlace_pop('admin_opcion_detalle?action=add&ref='.$datos['id_par_modulo'],800,450)
 		if ($action == 'S'){
		echo '<td>';
		if (!empty($visor)) {
			if (empty($variables_adicional))
			$variable_url = $this->kaipi_url_pop($archivo_ref,'&action=visor&id='.trim($row[$llave_primaria]),$largo,$ancho);
		  else	 
			$variable_url = $this->kaipi_url_pop($archivo_ref,$variables_adicional.'&action=visor&id='.trim($row[$llave_primaria]),$largo,$ancho);
 			
			echo '<a class="btn btn-xs" href="'.$variable_url.'"> 
				  <i class="icon-zoom-in icon-white"></i></a> ';
		}
 	    if (!empty($editar)) 	{
		  if (empty($variables_adicional))
			$variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
		  else	 
			$variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
													 
 		    $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
  		    echo '<a class="btn btn-xs" title="Editar registro" href="'. $ajax.'"><i class="icon-edit icon-white"></i></a> ';
		}
		
		if (!empty($del)){ 		
 			 $variable_url = 'action=del&tid='.$row[$llave_primaria].'&'.$variables_adicional.$tab;
 			 $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			 echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
 		}
  		echo '</td>';	
 		foreach ($row as $item){
		if ($i <= $numero_ver){
 			if ($i == 0 ){
			  echo "<td>";
			  echo ($item) ;
			}else{
			 if(is_numeric($item)){
			    $id_dato = $row[$llave_primaria];
				$omonto  = 'name="monto_'.$id_dato.'" id="monto_'.$id_dato.'"';
 				$v1 = '#monto_'.$id_dato;
   				$cantidad = $row['Monto'];
				//-- suma de grilla
				 
				 $n1 = $row[$this->var1];
 				 $n2 = $row[$this->var2];
 				 $n3 = $row[$this->var3];
				//-- fin 
				if ($nmonto == $i) {
					 echo "<td width='150'>";
 					 $evento = 'onChange="javascript:calculo('.$valor.');"';
					 
 					 echo '<input '.$omonto.' type="number" 
                        style="text-align:right; border:rgba(193,193,193,1.00)" step="0.01" min="0" max="999999999" value="'.$cantidad.'">';
  				 }else{
 					echo '<td align="right">';
					echo number_format($item,2); 	
				  }
  			  }else{
				  echo "<td>";
				  echo ($item) ;
				}
		   }
		   $i++; 	
		  }
 		 }
 		}
 		 echo "</tr>";	
	
		  $nsuma1 = $nsuma1 + $n1;
 		  $nsuma2 = $nsuma2 + $n2;
  		  $nsuma3 = $nsuma3 + $n3;
		 $i = 0;	
	   }
 		$columna = $this->ncolumna;
		echo "<tr>";
		for ($i = 1; $i<= $columna - 1  ; $i++){
			echo "<td></td>";
		}	
		if (!empty($this->var1)) {
   		  echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		}
		if (!empty($this->var2)) {
   		  echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		}	 
		if (!empty($this->var3)) {
   		  echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
		}		 
  		 
		 
 		echo "</tr>";	 
		echo "</tbody></table>";
 		pg_free_result ($resultado) ;
	}
	break;
break;
}	
}	
//-------------------------------------------------------------------------------------------------
function KP_GRID_POP_NOM($resultado,$tipo,$llave_primaria,$variables_adicional,
                                $action,$visor,$editar,$del,$bd="-")  {
    
    $numero_campos = pg_num_fields($resultado) - 1;
     
 
    echo '<table id="jsontable" class="table table-striped table-bordered table-hover datatable" cellspacing="0" width="100%"><thead> <tr>';
    
        $k = 0;
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        
    //    $ntotal = 0;
      
        for ($i = 0; $i<= $numero_campos  ; $i++){
            
               $cabecera = pg_field_name($resultado,$k) ;
      
                if ($cabecera=='Monto')
                    $nmonto = $i ;
                
                if ($cabecera=='total')
                    $ntotal = $i ;
                     
                    echo "<th>".strtoupper($cabecera).'</th>';
                
                $k++;
        }
        
 

        $masuno = 0;
        
        if ($action == 'S'){
            echo "<th> Acciones </th>";
            $masuno = 1;
        }
    
        echo '</tr>
               </thead><tbody>';
        
                $numero_ver = $numero_campos  ;
                $i = 0;
                $n1= 0;
                $n2= 0;
                $n3= 0;
                
                while($row=pg_fetch_assoc($resultado)) {
                  
                    echo "<tr>";

					$estilo ='';
 
									if ( $bd =='-'){
										$estilo ='';
									}else{
										$variables  = 'id_rol='.$id_rol;
										
										$sql 		= "select sum(ingreso)-sum(descuento) as saldo
										from  view_rol_impresion
										where ".$variables_adicional ." and 
											  idprov= ".$bd->sqlvalue_inyeccion( trim( $row['identificacion'])  ,true) ;

										$Array = $bd->query_array_sql($sql);

										if ( $Array['saldo']  < 0 ){
											$estilo = 'style="color: #B60003;font-weight:650" ';
										}
 									}
                    
                     foreach ($row as $item){
                         
                        if ($i <= $numero_ver){
                            
                             if ($i == 0 ){
                                 echo "<td>";
                                 echo trim($item) ;
                             }else{
                                
                                if(is_numeric($item)){
                                    
                                    $id_dato = $row[$llave_primaria];
                                    
                                    $omonto  = 'name="monto_'.$id_dato.'" id="monto_'.$id_dato.'"';
                                    
                                    $cantidad = $row['Monto'];

									

                                    $n1 = $row[$this->var1];
                                    $n2 = $row[$this->var2];
                                    $n3 = $row[$this->var3];
                                      
                                    //-- fin
                                    if ($nmonto == $i) {
                                        
                                        echo "<td ".$estilo.">";
												$evento = ' onChange="go_actualiza_dato('.$id_dato.',this.value);" ';
												echo '<input '.$omonto.$evento.' type="number"  
																		style="text-align:right; 
																		border:rgba(193,193,193,1.00)" 
																		step="0.01" 
																		min="0" 
																		max="999999999" 
																		value="'.$cantidad.'">';
                                  
                                    }else{
                                         echo '<td align="right" '.$estilo.' >';
                                         echo number_format($item,2);
                                    }
                                 }else{
                                    
									  echo "<td ".$estilo.">";
                                      echo trim($item) ;
                                    
                                }
                            }
                            $i++;
                        }
                    }
                   //--------------------------------------------------------
                    if ($action == 'S'){
                        
                        echo '<td>';
                      
                        if (!empty($visor)) {
                            
                            $id = "'". trim($row['identificacion']). "'";
                            
                            $evento = ' onClick="go_actualiza('."'visor',".$id.')" ';
                            
                            echo '<a class="btn btn-xs" href="#" '.$evento.' ><i class="icon-zoom-in icon-white"></i></a> ';
                                      
                        }
                    
                        if (!empty($editar)) 	{
                            
                            $id = "'". trim($row['identificacion']). "'";
                        
                            if ($editar == 'pdf'){
                                $id = "'". trim($row['identificacion']). "'";
                                $evento = ' onClick="go_actualiza('."'pdf',".$id.')" ';
                                echo '<a class="btn btn-xs" title="Visor PDF" href="#" '.$evento.'><i class="icon-download icon-white"></i></a> ';
                            }
                            else{
                                $id = $row[$llave_primaria];
                                $evento = ' onClick="go_actualiza('."'editar',".$id.')" ';
                                echo '<a class="btn btn-xs" title="Editar registro" href="#" '.$evento.'><i class="icon-edit icon-white"></i></a> ';
                                
                            }
                         
                        }
 
                        if (!empty($del)){
                            
                            if ($del == 'del'){
                                $id = trim($row[$llave_primaria]);
                                $evento = ' onClick="go_actualiza('."'del',".$id.')" ';
                            } else    
                            {
                                $id = "'". trim($row['identificacion']). "'";
                                $evento = ' onClick="go_actualiza('."'eliminar',".$id.')" ';
                            } 
                             
                            echo '<a class="btn btn-xs" title="Eliminar registro" href="#" '.$evento.'><i class="icon-trash icon-white"></i></a> ';
                            
                        } 
                        
                        echo '</td>';
                    }
               
                echo "</tr>";
                
                $nsuma1 = $nsuma1 + $n1;
                $nsuma2 = $nsuma2 + $n2;
                $nsuma3 = $nsuma3 + $n3;
                $i = 0;
            }
            
            
            $columna = $this->ncolumna  ;
            
            echo "<tr>";
            
            for ($i = 1; $i<= $columna - 2   ; $i++){
                echo "<td></td>";
            }
            
            
            if (!empty($this->var1)) {
                echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
            }
            if (!empty($this->var2)) {
                echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
            }
            if (!empty($this->var3)) {
                echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
            }
            
            if ( $masuno== 1) {
                echo "<td></td>";
            }
 
            echo "</tr> </tbody>  </table>";
            
            pg_free_result ($resultado) ;
   
    
}	
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID visor  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/		
function KP_GRID_visor($resultado,$tipo,$porcentaje)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
	case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
	case 'oracle':  
							   $numero_campos = oci_num_fields($resultado) - 1;
							   break;
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 echo '<table class="table table-striped table-bordered table-hover" border="0" width="'.$porcentaje.'"><thead> <tr>';
$k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}	
	
	$cabecera_ancho = explode("_", $cabecera);
	$cabecera_head  = $cabecera_ancho[0]; // porción1
	$cabecera_long = $cabecera_ancho[1]; // porción1
	
 	if ($cabecera_long > 0 ) {
		echo "<th width='".$cabecera_long."%'>".$cabecera_head.'</th>';
	}
	else
	{ 
		echo "<th>".$cabecera.'</th>';
 	}
	$k++;  
  
  }
 
 echo '</tr></thead>'.'<tbody>';
// para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>";
		 echo $item; 
		}else{
		  $n1 = $row[$this->var1];
 		  $n2 = $row[$this->var2];
 		  $n3 = $row[$this->var3];
 		 echo "<td align='right'>";
		 echo number_format($item,2); 
		}
	   }else{
		echo "<td>";
		echo ($item) ;
	   }
	   echo "</td>";
	   $i++;
	  }
 	  echo "</tr>";		
	  $i = 1;
	 }
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
	}
	break;
	 case 'postgress':  
	 {
 	    $nsuma1 = 0;
  		$nsuma2 = 0;
  		$nsuma3 = 0;
 		while($row=pg_fetch_assoc($resultado)) {
		 echo "<tr>";
		 foreach ($row as $item){
			 if(is_numeric($item)){
 			    echo "<td align='right'>";
				 $n1 = $row[$this->var1];
 		  		 $n2 = $row[$this->var2];
 		  		 $n3 = $row[$this->var3];
		  
				echo number_format($item,2); 
			  }else{
			 	 echo "<td>";
				 echo ($item) ;
			   }	  
			
			echo "</td>";
		 }
		  $nsuma1 = $nsuma1 + $n1;
 		  $nsuma2 = $nsuma2 + $n2;
  		  $nsuma3 = $nsuma3 + $n3;
		 echo "</tr>";		
	  }
 	  $columna = $this->ncolumna;
	  echo "<tr>";
		for ($i = 1; $i<= $columna - 1  ; $i++){
			echo "<td></td>";
		}	
		if (!empty($this->var1)) {
   		  echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		}
		if (!empty($this->var2)) {
   		  echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		}	 
		if (!empty($this->var3)) {
   		  echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
		}
	   echo "</tr>";			
	  echo "</tbody></table>";
 	  pg_free_result ($resultado) ;
	  }
	  break;
 	 case 'oracle':  
	 {
 	    $nsuma1 = 0;
  		$nsuma2 = 0;
  		$nsuma3 = 0;
 		while($row=oci_fetch_assoc($resultado)) {
		 echo "<tr>";
		 foreach ($row as $item){
			 if(is_numeric($item)){
 			    echo "<td align='right'>";
				 $n1 = $row[$this->var1];
 		  		 $n2 = $row[$this->var2];
 		  		 $n3 = $row[$this->var3];
		  
				echo number_format($item,2); 
			  }else{
			 	 echo "<td>";
				 echo ($item) ;
			   }	  
			
			echo "</td>";
		 }
		  $nsuma1 = $nsuma1 + $n1;
 		  $nsuma2 = $nsuma2 + $n2;
  		  $nsuma3 = $nsuma3 + $n3;
		 echo "</tr>";		
	  }
 	  $columna = $this->ncolumna;
	  echo "<tr>";
		for ($i = 1; $i<= $columna - 1  ; $i++){
			echo "<td></td>";
		}	
		if (!empty($this->var1)) {
   		  echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		}
		if (!empty($this->var2)) {
   		  echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		}	 
		if (!empty($this->var3)) {
   		  echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
		}
	   echo "</tr>";			
	  echo "</tbody></table>";
 	     oci_free_statement ($resultado) ;
	  }
	  break;
     break;
	}	
  }
/*  consulta con parametro de edicion principal-----------------------------*/					
function KP_GRID_banco($resultado,$tipo,$porcentaje,$saldo,$fecha)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
	case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 echo '<table id="tabla1" class="table table-striped table-bordered table-hover" border="0" width="'.$porcentaje.'"><thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$i) ;	
						 break;
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	if ($cabecera == 'Saldo'){
		$k = $i;
	 } 	
	 
  }
 
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 0;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 0)  {
		 echo "<td align='right'>";
		 echo $item; 
		}else{
  		 echo "<td align='right'>";
		 echo number_format($item,2); 
		}
	   }else{
		echo "<td>";
		echo ($item) ;
	   }
	   echo "</td>";
	   $i++;
	  }
 	  echo "</tr>";		
	  $i = 1;
	 }
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
	}
	break;
	 case 'postgress':  
	 {
	
	    $nsuma1 = 0;
  		$nsuma2 = 0;
  		$nsuma3 = 0;
	 
	 	if ($saldo > 0){
			$ingreso = $saldo;
			$egreso = 0;
			$queda = $saldo;
		}else{
			$ingreso = 0;
			$egreso = $saldo * -1;
			$queda = $saldo;			
	    }
	  	echo "<tr>";
		echo "<td>".$fecha."</td>";
		echo "<td>&nbsp;&nbsp;</td>";
        echo "<td>&nbsp;&nbsp;</td>";
		echo "<td>Saldo inicial del periodo</td>";
		echo "<td>Movimiento saldo anterior</td>";
		echo "<td>-</td>";
		echo "<td align='right'>".$ingreso."</td>";
		echo "<td align='right'>".$egreso."</td>";
		echo "<td align='right'>".$queda."</td>";
		echo "</tr>";
	    $i = 0;
		$saldo_parcial = $queda;
		while($row=pg_fetch_assoc($resultado)) {
		 echo "<tr>";
		 foreach ($row as $item){
			if ($i == $k){
				$saldo_parcial = $saldo_parcial + ($row["Ingreso"] - $row["Egreso"]);
				$n1 = $row["Ingreso"];
				$n2 = $row["Egreso"];
				echo "<td align='right'>";
 				echo number_format($saldo_parcial,2);
			}else{
			 if(is_numeric($item)){
				echo "<td align='right'>";
 				echo number_format($item,2); 
			  }else{
			 	 echo "<td>";
				 echo ($item) ;
			   }	  
			 }
			echo "</td>";
		  $i++;
		 }
		 $i = 0;
		  $nsuma1 = $nsuma1 + $n1;
 		  $nsuma2 = $nsuma2 + $n2;
  		  $nsuma3 = $nsuma3 + $n3;
		 echo "</tr>";		
	  }
	  
	  $columna = 6;
	  $nsuma1 = $nsuma1 + $ingreso;
 	  $nsuma2 = $nsuma2 + $egreso;
      echo "<tr>";
		for ($i = 1; $i<= $columna  ; $i++){
			echo "<td></td>";
		}	
 		echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		echo '<td align="right"><b>'.''.'</b></td>';
		echo "</tr>";			
	  echo "</tbody></table>";
 	  pg_free_result ($resultado) ;
	  }
	  break;
     break;
	}	
  }		
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_CTA_SE($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
switch ($tipo){
	case 'mysql': $numero_campos = mysql_num_fields($resultado) - 1;
				  break;
	case 'postgress':  
				  $numero_campos = pg_num_fields($resultado) - 1;
				  break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;			
	break;
 }
//---------------------------------------------------------------------------------------------
echo ' <table id="jsontable" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  ><thead> <tr>';
$k = 0;
for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':     
			$cabecera = mysql_field_name($resultado,$i);	
			break;
		case 'postgress':  
			$cabecera = pg_field_name($resultado,$k) ;	
			break;
		case 'oracle':  
			$cabecera = oci_field_name($resultado,$i + 1) ;	
			break;
	break;
}		 
echo "<th>".$cabecera.'</th>';
$k++;  
}
//---------------accion que ejecuta de la grilla  -----------------------------------------------------
if ($action == 'S'){
  echo '<th> Acciones </th>';
}
echo '</tr></thead><tbody>';
//---------------detalle de la grilla  -----------------------------------------------------
 switch ($tipo){
//---------------MSQL ----------------------------------------------------- 
 case 'mysql': {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	   if(is_numeric($item)){
			if ($i == 1)  {
			  echo "<td align='right'>".$item."</td>";
			}else{
			  echo "<td align='right'>".number_format($item,2)."</td>";
			}
		}else{
			echo "<td>".$item."</td>";
		}
		$i++;
	 }
//---------------acciones de detalle de la grilla  -----------------------------------------------------
	if ($action == 'S'){
	     echo '<td width="20%">';
		 if (!empty($editar)) {	
		  $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
		  $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		  echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a>'.'</td>';	
		 }
 	}
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
  }
  break;
//---------------POSTGRESS  -----------------------------------------------------  
case 'postgress':{
 $nsuma1 = 0;
 $nsuma2 = 0;
 $nsuma3 = 0;
 while($row=pg_fetch_assoc($resultado)) {
	echo "<tr>";
	$i = 1;
    foreach ($row as $item){
   	if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td>".$item;
		}else{
		 echo "<td align='right'>".number_format($item,2); 
		}
	 }else{
		echo "<td>".$item;
	}
	  $i++;
	}
	if ($action == 'S'){
	     echo '<td width="20%">';
		 if (!empty($editar)) {	
		  $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
		  $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		  echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a>'.'</td>';
		 }
 	}
  	echo "</tr>";	
  }
  echo "</tbody></table>";
  pg_free_result ($resultado) ;
  }
  break;
//---------------ORACLE  -----------------------------------------------------  
case 'oracle':{
    
 $nsuma1 = 0;
 $nsuma2 = 0;
 $nsuma3 = 0;
 $nsuma4 = 0; 
 
 while($row=oci_fetch_assoc($resultado)) {
	echo "<tr>";
	$i = 1;
    foreach ($row as $item){
   	if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td>".$item;
		}else{
		 echo "<td align='right'>".number_format($item,2); 
		}
	  	$n1 = $row[$this->var1];
 		$n2 = $row[$this->var2];
 		$n3 = $row[$this->var3];	
		$n4 = $row[$this->var4];
	 }else{
		echo "<td>".$item;
	}
	  $i++;
	}
	if ($action == 'S'){
	     echo '<td width="20%">';
		 if (!empty($editar)) {	
		  $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
		  $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		  echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a>'.'</td>';
		 }
 	}
	 $nsuma1 = $nsuma1 + $n1;
 	 $nsuma2 = $nsuma2 + $n2;
     $nsuma3 = $nsuma3 + $n3;
     $nsuma4 = $nsuma4 + $n4; 
 
  	echo "</tr>";	
  }
      $columna = $this->ncolumna;
	  echo "<tr>";
		for ($i = 1; $i<= $columna - 1  ; $i++){
			echo "<td> </td>";
		}	
		if (!empty($this->var1)) {
   		  echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
		}
		if (!empty($this->var2)) {
   		  echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
		}	 
		if (!empty($this->var3)) {
   		  echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
		}
		if (!empty($this->var4)) {
   		  echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
		  echo '<td align="right"></td>';
		}		
	   echo "</tr>";	
  echo "</tbody></table>";
  oci_free_statement ($resultado) ;
  }
  break;  
break;
}	
}  	
//--------------------------------------------------------------
//------------
/*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_campos($resultado,$tipo)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
  }
   $cabecera_cadena = '';
   $cabecera_cadena[0] = ' ';
   $k = 1;
	 for ($i = 0; $i<= $numero_campos; $i++){
		switch ($tipo){
			case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
							 break;
			case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
							 break;
			case 'oracle':   $cabecera 	   = oci_field_name($resultado,$k) ;	
							 $column_type  = oci_field_type($resultado, $k);
							 break;						 
			break;
		}		 
		 
		 $cabecera_cadena[$k] = $cabecera.'.('.$column_type.')';
		$k++;  
	  }
 	return $cabecera_cadena;
 }

// final de la clase
////------------------		------------------------------------------------------*/					
 function KP_cabecera($resultado,$tipo)  {
		 
		  switch ($tipo){
			 case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
			 case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
		     case 'oracle':  
				    		 $numero_campos = oci_num_fields($resultado) - 1;
				      break;	

			break;
		  }
	 
			$k = 1;
			for ($i = 0; $i<= $numero_campos ; $i++){
				
				 switch ($tipo){
					 case 'mysql':     $cabecera = mysql_field_name($resultado,$i);	
									  break;
					 case 'postgress':  
									   $cabecera = pg_field_name($resultado,$k) ;	
									   break;
					case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						   
					break;
				  }		 
				  
			    $cabecera_cadena[$k] = $cabecera;
				 $k++;  
			}
 		return $cabecera_cadena;
		 
		}	

/*  consulta con parametro de edicion principal 
------------------------------------------------------*/					
function KP_datos($resultado,$tipo)  {
	switch ($tipo){
	 	  case 'mysql':         
						   return mysql_fetch_row($resultado);
						   break; 
 		 case 'postgress':  
						   return pg_fetch_row($resultado);
 						   break;
	     case 'oracle':     
 						   return oci_fetch_row($resultado);
						   break;
			 
		}
  }
  
  	/*  consulta con parametro de edicion principal 
------------------------------------------------------*/					
function KP_GRID_POPP($resultado,$tipo,$llave_primaria,$archivo_ref,$variables_adicional,$action,$visor,$editar,$del,$largo,$ancho,$tab,$ancho1)  {

 switch ($tipo){
	case 'mysql':             $numero_campos = mysql_num_fields($resultado) - 1;
							  break;
	case 'postgress':  
							   $numero_campos = pg_num_fields($resultado) - 1;
							   break;
	case 'oracle':  
							   $numero_campos = oci_num_fields($resultado) - 1;
							   break;
	break;
}
echo '<table class="table table-striped table-hover table-checkable datatable" width="'.$ancho1.'">';
echo '<thead> <tr>';
$k = 0;
for ($i = 0; $i<= $numero_campos; $i++){
 switch ($tipo){
	case 'mysql': 
				  $cabecera = mysql_field_name($resultado,$i);	
				  break;
	case 'postgress':  
				  $cabecera = pg_field_name($resultado,$k) ;	
				  break;
	case 'oracle':  
				  case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
				  break;
	break;
 }		 
 echo "<th>".$cabecera.'</th>';
 $k++;  
}
 /// actiones de la grilla  
if ($action == 'S'){
 echo '<th> Acciones';
 echo '</th>';			 
}
 echo '</tr></thead>';
 echo '<tbody>';
//// para tiopo de conecion se crea la estructura
switch ($tipo){
	case 'mysql':    {
	 $i= 1;
	 while($row=mysql_fetch_assoc($resultado)) {
		echo "<tr>";
		foreach ($row as $item){
		 if ($i == 1 ){
		  echo "<td>".$item;
 		  }else{
			if(is_numeric($item)){
			  echo "<td align='right'>".number_format($item,2);
 			  }else{
				echo "<td>".$item;
			  }
		   }
		   echo "</td>";
		   $i++; 
		  }
		  $i= 1;
		// actions 
		 if ($action == 'S'){
		 echo '<td>';
		 if (!empty($visor)) {
			echo '<a class="btn btn-success" href="'.
					$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho).'"> 
					<i class="icon-zoom-in icon-white"></i></a> ';
		  }
		  if (!empty($editar)) 	{
			if (empty($variables_adicional))
			  $variable_url = 'action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
			else	 
			  $variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
															 
			$ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		   }
		   if (!empty($del)){ 			  
			echo '<a class="btn btn-danger" href="'.
				 $this->kaipi_url_pop($archivo_ref,'&action=del&tid='.$this->clave_inyeccion().$row[$llave_primaria],$largo,$ancho).'"> 
				 <i class="icon-trash icon-white"></i></a> ';
			}
			echo '</td>';			 
			}
			 echo "</tr>";		
		 }
		 echo "</tbody></table>";
		 mysql_free_result($resultado) ;
 }
 break;
 case 'postgress': {
	while($row=pg_fetch_assoc($resultado)) {
	echo "<tr>";
	$i= 1;
	foreach ($row as $item){
	if ($i == 1 ){
		  echo "<td align='center'>".($item);
 	 }else{
		 if(is_numeric($item)){
			  echo "<td align='right'>".number_format($item,2); 
			  }else{
				echo "<td>".($item) ;
		      }
	 }
	 echo "</td>";
	 $i++; 
	}
	$i= 1;
	/// actions 
		//kaipi_enlace_pop('admin_opcion_detalle?action=add&ref='.$datos['id_par_modulo'],800,450)
 		//$cadena_enlace = kaipi_enlace_pop('."'".$archivo_ref.'&action=';editar,del
		if ($action == 'S'){
		 echo '<td>';
		 if (!empty($visor)) {
			 
			$ajax =$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho);
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			 
		   
		  }
		  if (!empty($editar)) 	{
			if (empty($variables_adicional))
			 $variable_url = 'action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
			else	 
			 $variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
													 
 			 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
		  											 
 			 echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			 
		  }
		  if (!empty($del)){ 			  
 		
			if (empty($variables_adicional)){ 
			  $variables_adicional1 ='';

			  
			 }else{ 
			 /// manda una variable y una fija
			  $referencial  = explode('&',$variables_adicional);
			  $referencial1 = $referencial[0]; 
			  $referencial2 = $referencial[1]; 
			 
			 
			  if (empty($referencial2)){
				 $variable_url = $variables_adicional.'&action=del&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
  				 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			  } else{
				   // var 1
					  $var1 = explode('=',$referencial1);
					  $var_url1 = $var1[0] ;
					  $var_url2 = trim($var1[1]) ;
					  // var2RA
					  $var2 = explode('=',$referencial2);
					  $var_url3 = $var2[0] ;
					  $var_url4 = trim($var2[1]) ;		
					  $variables_adicional1 ='&'.$var_url1.'='.trim($row[$var_url2]).'&'.$var_url3.'='.$var_url4;
					  $ajax = $this->kaipi_url_pop($archivo_ref,'&action=del&id='.$row[$llave_primaria].$variables_adicional1,$largo,$ancho);
			  }
			 }
			 		 
			  
			 echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar registro"><i class="icon-trash"></i></a> ';
			 
			 
           }
		   echo '</td>';			 
		  }
 		  echo "</tr>";		
		}
		echo "</tbody></table>";
 		pg_free_result ($resultado) ;
	 }
	  break;
   case 'oracle': {
    
	while($row=oci_fetch_assoc($resultado)) {
	echo "<tr>";
	$i= 1;
        	foreach ($row as $item){
            	if ($i == 1 ){
            		  echo "<td align='center'>".($item);
             	 }else{
            		 if(is_numeric($item)){
            			   echo "<td align='right'>".number_format($item,2); 
            			  }else{
            					     //--------------------------------------------------------------------------------------
                             	 $codigo = trim($row[$llave_primaria]);
                                 $campo = oci_field_name($resultado,$i ).'_'.$codigo;
                                 $ncampo = oci_field_name($resultado,$i );
                               
                                 if ($item =='S'){
                                          $evento = "javascript:seleccion($(this),".$codigo.",'".$ncampo."')";
                                         echo "<td>" ;
                                    	 echo '<input name="chk_'.$campo .'" type="checkbox" onChange="'.$evento.'" checked id="chk'.$codigo.'">' ;
                                 }else{
                                    if ($item == 'N'){
                                         $evento = "javascript:seleccion($(this),".$codigo.",'".$ncampo."')";
                                         echo "<td>" ;
                                         echo '<input name="chk_'.$campo .'" type="checkbox" onChange="'.$evento.'" id="chk'.$codigo.'">' ;
                                    }else
                                    {
                                        echo "<td>".($item) ;
                                    }
                                 }
						}
            	 }
        	 echo "</td>";
        	 $i++; 
        	}
	$i= 1;
	/// actions 
		//kaipi_enlace_pop('admin_opcion_detalle?action=add&ref='.$datos['id_par_modulo'],800,450)
 		//$cadena_enlace = kaipi_enlace_pop('."'".$archivo_ref.'&action=';editar,del
		if ($action == 'S'){
		 echo '<td>';
		 if (!empty($visor)) {
			 
			$ajax =$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho);
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			 
		   
		  }
		  if (!empty($editar)) 	{
			if (empty($variables_adicional))
			 $variable_url = 'action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
			else	 
			 $variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
													 
 			 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
		  											 
 			 echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			 
		  }
		  if (!empty($del)){ 			  
 		
			if (empty($variables_adicional)){ 
			  $variables_adicional1 ='';

			  
			 }else{ 
			 /// manda una variable y una fija
			  $referencial  = explode('&',$variables_adicional);
			  $referencial1 = $referencial[0]; 
			  $referencial2 = $referencial[1]; 
			 
			 
			  if (empty($referencial2)){
				 $variable_url = $variables_adicional.'&action=del&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
  				 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			  } else{
				   // var 1
					  $var1 = explode('=',$referencial1);
					  $var_url1 = $var1[0] ;
					  $var_url2 = trim($var1[1]) ;
					  // var2RA
					  $var2 = explode('=',$referencial2);
					  $var_url3 = $var2[0] ;
					  $var_url4 = trim($var2[1]) ;		
					  $variables_adicional1 ='&'.$var_url1.'='.trim($row[$var_url2]).'&'.$var_url3.'='.$var_url4;
					  $ajax = $this->kaipi_url_pop($archivo_ref,'&action=del&id='.$row[$llave_primaria].$variables_adicional1,$largo,$ancho);
			  }
			 }
			 		 
			  
			 echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar registro"><i class="icon-trash"></i></a> ';
			 
			 
           }
		   echo '</td>';			 
		  }
 		  echo "</tr>";		
		}
		echo "</tbody></table>";
 		oci_free_statement($resultado) ;
	 }
	  break;   
 break;
 }	
}	
//----------------------------------------------------------------------------------------------------------------------
 
 //consulta con parametro de edicion principal 
	 				
//----------------------------------------------------------------------------------------------------------------------	
function KP_GRID_POP_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab)  {

    
    
    if ($tipo == 'mysql'){
        $numero_campos = mysql_num_fields($resultado) ;
    }
    
    if ($tipo == 'postgress'){
        
		$this->post_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							      $action,$visor,$editar,$del,$largo,$ancho,$tab,1) ;
    }

    if ($tipo == 'oracle'){
      $this->oracle_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							      $action,$visor,$editar,$del,$largo,$ancho,$tab,1) ;
    }
 
 
}

function post_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab,$estilo)  {
 
 
  $numero_campos = pg_num_fields($resultado) - 1;
 
  echo '<table class="table table-striped  table-hover" width="100%" border="0">';
  
  echo '<thead> <tr>';
  $k = 0;
  $ndebe = 0;
  $nhaber = 0;
  $sdebe = 0;
  $shaber = 0;	
  $ntotal = 0;		
  /// actiones de la grilla  
  if ($action == 'S'){
   echo '<th> Acciones </th>';
  }
  
  for ($i = 0; $i<= $numero_campos - 1  ; $i++){
	 
 
					$cabecera = pg_field_name($resultado,$k) ;	
					if ($cabecera=='cantidad')
					  $ndebe = $i ;
					if ($cabecera=='costo')
					  $nhaber = $i ; 
					if ($cabecera=='total')
					  $ntotal = $i ; 
					 
					if ($cabecera=='saldo')
						  $nsaldo = $i ; 
				 
	
	  echo "<th>".$cabecera.'</th>';
	  
	  $k++;  
	  				 
	  }		 
	
 
  echo '</tr></thead><tbody>';
  //// para tiopo de conecion se crea la estructura
  
	 $numero_ver = $numero_campos - 1  ;	   
	 $i = 0;
	 while($row=pg_fetch_assoc($resultado)) {
	  echo "<tr>";
		/// actions 
		//kaipi_enlace_pop('admin_opcion_detalle?action=add&ref='.$datos['id_par_modulo'],800,450)
 		if ($action == 'S'){
		echo '<td>';
		if (!empty($visor)) {
			echo '<a class="btn btn-xs" href="'.
				   $this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho).'"> 
				  <i class="icon-zoom-in icon-white"></i></a> ';
		}
      
	    if (!empty($editar)) 	{
		  if (empty($variables_adicional))
			$variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
		  else	 
			$variable_url = $variables_adicional.'&action=editar&tid='.
							$this->clave_inyeccion().$row[$llave_primaria].$tab;
													 
 		    $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
  		    echo '<a class="btn btn-xs" title="Editar registro" 
					 href="'. $ajax.'"><i class="icon-edit icon-white"></i></a> ';
		}
		
		if (!empty($del)){ 		
 			 $variable_url = 'action=del&tid='.$row[$llave_primaria].'&'.$variables_adicional.$tab;
 			// $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			 $largo = 30;
			 $ancho = 30;
			 $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			 
			 echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
 		}
 		echo '</td>';	
		
		foreach ($row as $item){
		  if ($i <= $numero_ver){
 			if ($i == 0 ){
			  echo "<td>";
			  echo ($item) ;
			}else{
				if(is_numeric($item)){
				 $id_dato = $row[$llave_primaria];
				 $odebe  = 'name="cantidad_'.$id_dato.'" id="cantidad_'.$id_dato.'"';
				 $ohaber = 'name="costo_'.$id_dato.'" id="costo_'.$id_dato.'"';
				 $ototal = 'name="total_'.$id_dato.'" id="total_'.$id_dato.'"';
				 $osaldo = 'name="saldo_'.$id_dato.'" id="saldo_'.$id_dato.'"';
				 
				 $v1 = '#cantidad_'.$id_dato;
				 $v2 = '#costo_'.$id_dato;
				 $v3 = "'".'total_'.$id_dato."'";
				 $v4 = "'".'saldo_'.$id_dato."'";
				 
				 $valor = "$('".$v1."').val(),"."$('".$v2."').val(),".$v3.",". $v4;
				 
				 if ($ndebe == $i) {
					echo "<td width='150'>";
 					$cantidad = $row['cantidad'];
 					
					echo '<input '.$odebe.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)" 
						 required step="0.01" min="0" max="999999999"  
						 onChange="javascript:calculo('.$valor.');" value="'.$cantidad.'">';
 				  }else{
					if ($nhaber == $i) {
					  echo "<td width='150'>";
					  if ($row['costo'] == 0)
					  		$valor_costo = $row['lifo'];
					  else
					  		$valor_costo = $row['costo'];
							
					  echo '<input '.$ohaber.' type="number" 
					  		style="text-align:right; border:rgba(193,193,193,1.00)" required  
									step="0.01" min="0" max="999999999" 
									onChange="javascript:calculo('.$valor.');" value="'.$valor_costo.'">';	
 					}
					else{
						if ($ntotal == $i) {
					 	 echo "<td width='150'>";
					 	 echo '<input '.$ototal.' type="number" style="text-align:right; 
						 	  border:rgba(193,193,193,1.00)" required  step="0.01" min="0" max="999999999" 
									  value="'.$row['total'].'">';	
					 	 $stotal = $stotal + $row['total'];																
						}else{
						 	if ($nsaldo == $i) {
 					 	      echo "<td width='120'>";
					 	 	  echo '<input '.$osaldo.' type="number" style="text-align:right; 		
							  		border:rgba(193,193,193,1.00)" readonly  step="0.01" min="0" max="999999999" 
									value="'.$row['saldo'].'">';	
 						}else{
						 	echo "<td>";
					 		echo number_format($item,2); 	
					    }
					 }
					}
				  }
 				}else{
				  echo "<td>";
				  echo ($item) ;
				}
		   }
		   $i++; 	
		  }
		 }
		}
 		 echo "</tr>";	
		 $i = 0;	
	   }
	 	echo "<tr>";
		echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
		echo "<td>";
		echo '<input name="total_costo" type="number" class="form-control" 
			 	id="total_costo" style="text-align:right" max="999999999" min="0"  
			 	step="0.01" value="'.$stotal.'" readonly="readonly" > ';
		echo "</td>";
		echo "</tr>";	 
		echo "</tbody></table>";
		
 		pg_free_result ($resultado) ;
	 
 }


//----------------------------------------------------------------------------------------------------------------------
 
 //consulta con parametro de edicion principal 
	 				
//----------------------------------------------------------------------------------------------------------------------	
function KP_GRID_POP_inv_ingreso($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab,$ancho1)  {

    
    
    if ($tipo == 'mysql'){
        $numero_campos = mysql_num_fields($resultado) ;
    }
    
    if ($tipo == 'postgress'){
        $numero_campos = pg_num_fields($resultado) ;
    }

    if ($tipo == 'oracle'){
      $this->oracle_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							      $action,$visor,$editar,$del,$largo,$ancho,$tab,$ancho1) ;
    }
 
 
}
//----------------------------------------------------------------------------------------------------------------------
 
 //consulta con parametro de edicion principal 
	 				
//----------------------------------------------------------------------------------------------------------------------	
function KP_GRID_POP_fac($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab)  {

    
    
    if ($tipo == 'mysql'){
        $numero_campos = mysql_num_fields($resultado) ;
    }
    
    if ($tipo == 'postgress'){
        $numero_campos = pg_num_fields($resultado) ;
    }

    if ($tipo == 'oracle'){
      $this->oracle_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							      $action,$visor,$editar,$del,$largo,$ancho,$tab,2) ;
    }
 
 
}
//
// funcion para oracle inventarios de movimientos
//
function oracle_inv($resultado,$tipo,$llave_primaria,$archivo_ref,$enlacea,$variables_adicional,
							  $action,$visor,$editar,$del,$largo,$ancho,$tab,$estilo)  {
		
    // numero de campos
  $numero_campos = oci_num_fields($resultado)  ;
  
 
  if ($estilo == 1) {
        echo '<table class="table table-striped  table-hover" width="100%" border="0">';
  }
  else{ 
      if ($estilo == 2) {
         echo '<table width="100%" cellpadding="1" cellspacing="3" border="0">';
      }
      else{
         echo '<table class="table table-striped table-bordered" data-horizontal-width="150%">';
      }   
  } 
  
  //class="table table-striped table-bordered table-hover table-checkable" 
  echo '<thead> <tr>';
  $ndebe = 0;
  $nhaber = 0;
  $sdebe = 0;
  $shaber = 0;	
  $ntotal = 0;		
  $nprecio = 0;	
  /// actiones de la grilla  
  if ($action == 'S'){
   echo '<th align="center" valign="middle" > Acciones </th>';
  }
  // para cabecera --------------------------------------------------------------
  $k = 2;
  for ($i = 1; $i<= $numero_campos ; $i++){
    
    $cabecera = oci_field_name($resultado,$i) ;	
	
    if ($cabecera =='cantidad')
		$ndebe = $k ;
	if ($cabecera =='costo')
		$nhaber = $k ; 
	if ($cabecera =='total') 
		$ntotal = $k ; 
 	if ($cabecera =='saldo')
        $nsaldo = $k ; 
  	if ($cabecera =='IVA')
        $nIVA = $k ; 
  	if ($cabecera =='Descuento')
        $nDescuento = $k ;  
    if ($cabecera =='Lote')
        $nlote = $k ;         
    if ($cabecera =='Caducidad')
        $ncaducidad = $k ;  
  	if ($cabecera =='Tributo')
        $ntributo = $k ;  
  if ($cabecera =='Precio')
        $nprecio = $k ;    
                      	 
    echo '<th align="center" valign="middle">'.$cabecera.'</th>';
    $k++;
  }
  
  echo '</tr></thead><tbody>';      	
  				     
 // para cabecera --------------------------------------------------------------
 
    $i = 2;
	 while($row=oci_fetch_assoc($resultado)) {
	   
	    echo "<tr>"; 	/// actions 
	 	if ($action == 'S'){
		    echo '<td align="center" valign="middle">';
    		if (!empty($visor)) {
    			echo '<a class="btn btn-xs" href="'.$this->kaipi_url_pop($archivo_ref,'&action=visor&id='.$row[$llave_primaria],$largo,$ancho).'"> 
    				  <i class="icon-zoom-in icon-white"></i></a> ';
    		} 
            if (!empty($editar)){
		        if (empty($variables_adicional))
		  	        $variable_url = 'action=editar&tid='.$row[$llave_primaria].$tab;
		        else	 
			        $variable_url = $variables_adicional.'&action=editar&tid='.$this->clave_inyeccion().$row[$llave_primaria].$tab;
													 
 		        $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
  		        echo '<a class="btn btn-xs" title="Editar registro" href="'. $ajax.'"><i class="icon-edit icon-white"></i></a> ';
		    }
		    if (!empty($del)){ 		
		        $variable_url = 'action=del&tid='.$row[$llave_primaria].'&'.$variables_adicional.$tab; // $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			    $largo = 30;
			    $ancho = 30;
			    $ajax = "javascript:open_pop('".$archivo_ref."','".$variable_url."',$largo,$ancho)";
			    echo '<a class="btn btn-xs" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
 		    }
 		    echo '</td>';	
         }   
         
         
        //------------------------------------------------------------------------------------------------------------------------------------
	    foreach ($row as $item){
	       
				 $id_dato = $row[$llave_primaria];
                 
				 $odebe  = 'name="cantidad_'.$id_dato.'" id="cantidad_'.$id_dato.'"';
				 $ohaber = 'name="costo_'.$id_dato.'" id="costo_'.$id_dato.'"';
				 $ototal = 'name="total_'.$id_dato.'" id="total_'.$id_dato.'"';
				 $osaldo = 'name="saldo_'.$id_dato.'" id="saldo_'.$id_dato.'"';
				 $oprecio = 'name="precio_'.$id_dato.'" id="precio_'.$id_dato.'"';
				 
				 
				 $oIVA = 'name="IVA_'.$id_dato.'" id="IVA_'.$id_dato.'"';
			
            	 $oDescuento = 'name="descuento_'.$id_dato.'" id="descuento_'.$id_dato.'"';
			
            
                 $olote      = 'name="lote_'.$id_dato.'" id="lote_'.$id_dato.'"';
				 $ocaducidad = 'name="caducidad_'.$id_dato.'" id="caducidad_'.$id_dato.'"';
                 
                 $otributo = 'name="tributo_'.$id_dato.'" id="tributo_'.$id_dato.'"';
                 
                 
            	 $v1 = '#cantidad_'.$id_dato;
				 
				 if ($row['Precio'] > 0){
				    
					$v2 = '#precio_'.$id_dato;
				
                 }else	{ 
				
                     $v2 = '#costo_'.$id_dato;
				 }
				
				 
				 
				 $v3 = "'".'total_'.$id_dato."'";
				 $v4 = "'".'saldo_'.$id_dato."'";
   	             
                 $v5 = '#tributo_'.$id_dato;
                
              	 $v6 = "'".'IVA_'.$id_dato."'";

                 $v7 = "'".'descuento_'.$id_dato."'";
                 
                  
                 $valor = "$('".$v1."').val(),"."$('".$v2."').val(),".$v3.",". $v4.","."$('".$v5 ."').val(),".$v6;
                 
                 $valor1 = "$('".$v1."').val(),"."$('".$v2."').val(),".$v3.",". $v4.","."$('".$v5 ."').val(),".$v6.",".$v7;
                  
                    
 			     if ($i == 2 ){
 			        
			         echo "<td>".$item;
                 
                 }else{
                    
				    if(is_numeric($item)){
    				      echo "<td width='110'>";  
    				      if ($ndebe == $i  ) {
    				    	 $cantidad = number_format($row['cantidad'],2);
     				         echo '<input '.$odebe.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)" 
    						 required step="0.01" min="0" max="999999999" onChange="javascript:calculo('.$valor.');" value="'.$cantidad.'">';
     				      }
                          elseif ($nhaber == $i   ) {
                             if ($row['costo'] == 0)
    					  		$valor_costo = $row['lifo'];
    					     else
    					  		$valor_costo = $row['costo'];
                             //------------------------------------------------------------------------------
                             echo '<input '.$ohaber.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)" required  
    									step="0.0001" min="0" max="999999999" onChange="javascript:calculo('.$valor.');" value="'.number_format($valor_costo,4).'">';	
                              
                          }
                       	  elseif ($nsaldo == $i  ) {
     					 	  echo '<input '.$osaldo.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)" readonly 
                                step="0.01" min="0" max="999999999"  value="'.number_format($row['saldo'],2).'">';
                             
                          }
                          elseif ($nprecio == $i  ) {
     					 	  echo '<input '.$oprecio.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)"   
                                step="0.01" min="0" max="999999999"  value="'.number_format($row['Precio'],2).'">';
                             
                          } 
                          elseif ($nIVA == $i  ) {
     					 	  echo '<input '.$oIVA.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)"  
                                step="0.0001" min="0" max="999999999" onBlur="javascript:total_ingresos();"  value="'.number_format($row['IVA'],4).'">';
                             
                          }
                          elseif ($nDescuento == $i  ) {
     					 	  echo '<input '.$oDescuento.' type="number" style="text-align:right; border:rgba(193,193,193,1.00)"  
                                step="0.01" min="0" max="999999999" onChange="javascript:calculod('.$valor1.');" value="'.number_format($row['Descuento'],4).'">';
                             
                          }
                          
                          elseif ($ntotal == $i) {  
                            
    				        echo '<input '.$ototal.' type="number" style="text-align:right;border:rgba(193,193,193,1.00)" required  
                                  step="0.01" min="0" max="999999999" value="'.number_format($row['total'],2).'">';	
    					 	      $stotal = $stotal + $row['total']; 
                         }
                          else {
    					      echo "<td>".number_format($item,2); 
                         }  
  
 				}else{
 				          if ($nlote == $i) {  
                            echo '<td><input '.$olote.' class="form-control" type="text" size="15" maxlength="10"  value="'.$row['Lote'].'">';	
    					  }
                          elseif ($ncaducidad == $i) {  
                           //  $ocaducidad = 'name="caducidad_'.$id_dato.'" id="caducidad_'.$id_dato.'"';
                            $date =   date('Y-m-d', strtotime($row['Caducidad']));  
    				        echo '<td><input '.$ocaducidad.' class="form-control" type="date" value="'.$date.'">';	
    					  }
                         elseif ($ntributo == $i) {  
                           //  $ocaducidad = 'name="caducidad_'.$id_dato.'" id="caducidad_'.$id_dato.'"';
    				       $MATRIZ = array(
                        	'N'    => 'N',
                        	'I'    => 'S'
                           );
   
                          echo '<td><select  '.$otributo.' class="form-control ">';
                          	foreach($MATRIZ as $key => $value){
                        		$val     = $key;
                        		$caption = $value;	 
                          		$valor = trim($row['Tributo']);
                        		if ( $valor == $val) {
                        		 $selstr = " selected"; 
                        		}else{
                        		 $selstr = "";
                        		}
                        		$cadena1 = '<option value="'.$val.'"'.$selstr.'>'.trim($caption).'</option>';
                        		echo $cadena1;
                        	}
                        	echo '</select>';    
                             
    					  }
                         
    			          else {
    					      echo "<td>".$item;
                         }  
				  
			    }
                echo "</td>";
		   }
		   $i++; 	
		  }
		  echo "</tr>";	
		 $i = 2;	
	   }
	   
       echo "<tr>";
       
       for ($i = 1; $i<= $numero_campos ; $i++){
         echo '<td></td>';
       }
 		echo '<td>
                <input name="total1_costo" type="number" style="text-align:right;border:rgba(193,193,193,1.00)" id="total1_costo" 
                style="text-align:right" max="999999999" min="0"  step="0.01" value="'.$stotal.'" readonly="readonly" > ';
		echo "</td></tr>";
           
		echo "</tbody></table>";
 		oci_free_statement ($resultado) ; 
 }
//FIN DE IVENTARIO ORACLE
 /*-------------------------------------------------------------------------------------------*/		
function oracle_ToolWeb($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
 
?>
    </tr></thead>
     <tbody>
<?php  
    while($row=oci_fetch_assoc($resultado)) {
	echo "<tr>";
	foreach ($row as $item){
	   if (is_numeric($item)){
	        $n=$item; 
            $r=($n-intval($n))*100; 
            if ($r == 0){
	          echo "<td align='left'><small>".trim($item)."</small></td>"; 
	        }
            else{
               echo "<td align='right'><small>".number_format($item,2,',', '.')."</small></td>";
            }
	       
	   }else
       {
              $trozos = explode("-", trim($item),3); 
			  $anio1 = strlen($trozos[2]);	
			  $mes1 =  strlen($trozos[1]); 
			  $dia1 =  $trozos[0]; 
              $lon = strlen(trim($item)); 
              // 30-NOV-12  $date =   date('Y-m-d', strtotime( $datos['FECINGRESO'])); 
              if (($lon == 9) && ($mes1 == 3)){
                $date =   date('d-m-Y', strtotime($item)); 
                echo "<td align='left'><small>".trim($date)."</small></td>";
              }else
              {
                 echo "<td align='left'><small>".trim($item)."</small></td>";
              }
       }
				
	}
    echo "</tr>";		
 }
 ?>
</tbody></table>
<?php  
 oci_free_statement ($resultado) ;
}
 
  /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_MSJ($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$porcentaje)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 //table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
 
 //  class="table table-hover table-striped table-highlight-head table-tabletools datatable"   width="'.$ancho1.'">';
 
 echo '<table class="table table-hover table-striped table-highlight-head datatable" width="100%" border="0">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}	
	
	$cabecera_ancho = explode("_", $cabecera);
	$cabecera_head  = $cabecera_ancho[0]; // porción1
	$cabecera_long = $cabecera_ancho[1]; // porción1
	
 	if ($cabecera_long > 0 ) {
		echo "<th width='".$cabecera_long."%'>".$cabecera_head.'</th>';
	}
	else
	{ 
		echo "<th>".$cabecera.'</th>';
 	}
	$k++;  
  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th></th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="20%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
	       		if ($i == 1)  {
        		 echo "<td align='right' width='10%'>".$item."</td>";
         		}else{
        		 echo "<td align='right'  width='10%'>".number_format($item,2)."</td>";
        		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="10%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
        		if ($i == 1)  {
        		 echo "<td align='right' width='15%'><small>".$item."</small></td>";
         		}else{
        		 echo "<td align='right'><small>".number_format($item,2)."</small></td>";
        		}
	   }else{
	           	echo "<td><SMALL>".$item."</SMALL></td>";
	   }
 	   $i++;
	  }
	  // actions 
	   if ($action == 'S'){
		echo '<td width="15%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }


 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR data-horizontal-width="150%"  -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_ROW($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab,$porcentaje)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}

 
 echo '<table class="table table-hover table-striped table-highlight-head datatable" width="100%" border="0">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}	
	
	$cabecera_ancho = explode("_", $cabecera);
	$cabecera_head  = $cabecera_ancho[0]; // porción1
	$cabecera_long = $cabecera_ancho[1]; // porción1
	
 	if ($cabecera_long > 0 ) {
		echo "<th width='".$cabecera_long."%'>".$cabecera_head.'</th>';
	}
	else
	{ 
		echo "<th>".$cabecera.'</th>';
 	}
	$k++;  
  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th></th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="20%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
	       		if ($i == 1)  {
        		 echo "<td align='right' width='10%'>".$item."</td>";
         		}else{
        		 echo "<td align='right'  width='10%'>".number_format($item,2)."</td>";
        		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="10%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
        		if ($i == 1)  {
        		 echo "<td align='right' width='15%'><small>".$item."</small></td>";
         		}else{
        		 echo "<td align='right'><small>".number_format($item,2)."</small></td>";
        		}
	   }else{
	           	echo "<td><SMALL>".$item."</SMALL></td>";
	   }
 	   $i++;
	  }
	  // actions 
	   if ($action == 'S'){
		echo '<td width="15%">';
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
				
			//'<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		    echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		  // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }
 
 /*-------------------------------------------------------------------------------------------*/					
/*-------------------GRID STANDAR PARA EDICION, VISOR Y ELIMINAR -----------------------------*/			
/*-------------------------------------------------------------------------------------------*/					
function KP_GRID_AJAX_SIMPLE($resultado,$tipo,$llave_primaria,$archivo_ref,$action,$visor,$editar,$del,$tab)  {
  switch ($tipo){
	case 'mysql':    $numero_campos = mysql_num_fields($resultado) - 1;
					 break;
	case 'postgress':  
					 $numero_campos = pg_num_fields($resultado) - 1;
					 break;
	case 'oracle':  
				  $numero_campos = oci_num_fields($resultado) - 1;
				  break;	
	break;
}
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
//table table-striped table-bordered table-hover table-checkable table-tabletools datatable
 //table table-striped table-bordered table-checkable table-highlight-head table-no-inner-border table-hover
 
 //  class="table table-hover table-striped table-highlight-head table-tabletools datatable" KP_GRID_CTAA table-colvis
 
  echo '<table class="table table-striped table-bordered table-hover table-checkable  datatable" width="100%">
 <thead> <tr>';
 $k = 0;
 for ($i = 0; $i<= $numero_campos; $i++){
	switch ($tipo){
		case 'mysql':    $cabecera = mysql_field_name($resultado,$i);	
						 break;
		case 'postgress':$cabecera = pg_field_name($resultado,$k) ;	
						 break;
		case 'oracle':   $cabecera = oci_field_name($resultado,$i + 1) ;	
						 break;						 
		break;
	}		 
	echo "<th>".$cabecera.'</th>';
	$k++;  
  }
// actiones de la grilla  
if ($action == 'S'){
  echo '<th> Acciones </th>';
 }
 echo '</tr></thead>';
 echo '<tbody>';
 // para tiopo de conecion se crea la estructura
 switch ($tipo){
  case 'mysql':    {
	$i = 1;
	while($row=mysql_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
		}
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   echo '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
 	mysql_free_result($resultado) ;
 }
 break;
 case 'postgress':  
	{
	$i = 1;
	while($row=pg_fetch_assoc($resultado)) {
	 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url1 = 'visor';
            $variable_url2 = trim($row[$llave_primaria]);
            
			$ajax = "javascript:abrir_accion('".$archivo_ref."','".$variable_url1."','".$variable_url2."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
			// '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
	pg_free_result ($resultado) ;
  }
   break;
  case 'oracle':  
	{
	$i = 1;
	while($row=oci_fetch_assoc($resultado)) {
		 echo "<tr>";
	 foreach ($row as $item){
	  if(is_numeric($item)){
		if ($i == 1)  {
		 echo "<td align='right'>".$item."</td>";
 		}else{
		 echo "<td align='right'>".number_format($item,2)."</td>";
		}
	   }else{
		echo "<td>".$item."</td>";
	   }
 	   $i++;
	  }
	  // actions 
	  if ($action == 'S'){
		echo '<td width="12%">';
		
		if (!empty($visor)) {
			$variable_url = 'action=visor&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Search"><i class="icon-search"></i></a>';
			
			// '<a class="btn btn-success" href="'.$ajax.'"> <i class="icon-zoom-in icon-white"></i></a> ';	
		 }
		
		if (!empty($editar)) {	
			$variable_url = 'action=editar&tid='.trim($row[$llave_primaria]).$tab;
			$ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
			//'<a class="btn btn-info" href="'. $ajax.'"> <i class="icon-edit icon-white"></i></a> ';
			echo '<a href="'. $ajax.'" class="btn btn-xs bs-tooltip" title="Editar"><i class="icon-pencil"></i></a> ';
			
		}
		
		if (!empty($del)){ 			  
		   $variable_url = 'action=del&tid='.trim($row[$llave_primaria]).$tab;
		   $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
		   
		   echo '<a href="'.$ajax.'" class="btn btn-xs bs-tooltip" title="Eliminar"><i class="icon-trash"></i></a> ';
		   
		   // '<a class="btn btn-danger" href="'.$ajax.'"> <i class="icon-trash icon-white"></i></a> ';
		}
		
		echo '</td>';			 
	 }
 	echo "</tr>";		
	$i = 1;
	}
	echo "</tbody></table>";
  oci_free_statement ($resultado) ;  }
   break;  
 break;
  }	
			
 }  
 ////---------------------------- $resultado,$tipo,'id', $enlaceModal,$evento
 function KP_grilla_detalle_modal($resultado,$tipo,
 $llave_primaria, $enlaceModal,$evento,$id)  {
     
 
     
     $numero_campos = pg_num_fields($resultado) - 1;
     
     echo '<table class="table table-hover datatable" width="100%" id="'.$id.'"> <thead><tr>';
     $k = 0;
     
     // actiones de la grilla
 
     //-------------------------------------------------------------
     for ($i = 0; $i<= $numero_campos; $i++){
         
         $cabecera = pg_field_name($resultado,$k) ;
         
         echo '<th bgcolor="#c6dcff">'.$cabecera.'</th>';
         
         $k++;
     }
     echo '<th bgcolor="#c6dcff"> Accion </th>';
     echo '</tr></thead><tbody>';
   
     $a_evento = explode("-",$evento);
     
     $evento  = trim($a_evento[0]);
     $evento1 = trim($a_evento[1]);
     
      
     $i = 0;
     
     while($row=pg_fetch_assoc($resultado)) {
        
         echo "<tr>";
         
         foreach ($row as $item){
                // $id_dato = $row[$llave_primaria];
                      if ($i == 0 ){
                          echo "<td>".$item."</td>";
                     }else{
                         if(is_numeric($item)){
                             echo "<td>".number_format($item,2)."</td>";
                          }else{
                              echo "<td>".$item ."</td>";
                         }
                     }
                     $i++;
              }
               
    
              $lon = strlen($evento1);
              
              $idcodigo = trim($row[$llave_primaria]) ;
             
              
              if ($lon > 3){
                  
                  $cadena_evento = '<a class="btn btn-xs"
							href="#"   title="VISUALIZAR  INFORMACION "   
                            onClick="'.$evento1.'('.$idcodigo. ')">
							<i class="icon-eye-open icon-white"></i>
                      </a>';
                  
              }
              echo '<td>
                     <a class="btn btn-xs"
							href="#" data-toggle="modal" 
                        	title="EDITAR REGISTRO" 
							data-target="#'.$enlaceModal.'"
							onClick="'.$evento.'('.$idcodigo. ')">
							<i class="icon-edit icon-white"></i>
                      </a>'.$cadena_evento.' 
                    </td>';
              echo "</tr>";
         }
       
         $i = 0;
 
         echo "</tbody></table>";
         
        pg_free_result ($resultado) ;
     
 }
 
}		
 	
?>