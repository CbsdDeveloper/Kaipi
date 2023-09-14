<?php
/* Clase encargada de gestionar las conexiones a la base de datos */
class objects_table  {

// private $array;

private static $_instance;

   private $columna;
   private $ncolumna;
   private $var1;
   private $var2;
   private $var3;
   private $var4;
   private $var5;
   
 
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
function _esdecimal($valor)  {
    
   
    $num = explode('.',$valor);
    
    $conta =  count($num);
    
    if ( $conta > 2 ){
        $nbandera = 0;
    }
    else{
        if ($num['1'] == 0){
            
            if(is_numeric($valor)){
                
                $nbandera = 1;
            }else{
                
                $nbandera = 0;
                
            }
            
         }
         
        else{
            
            $nbandera = 1;
        }
    }
   return $nbandera;
    
}
//--------------------------------
function table_basic_js($resultado,$tipo,$editar,$del,$evento,$cabecera,$font='11px',$id='tablaBasica',$filas='N',$ancho='0' )  {
    
    
    $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

    $array = explode(",", $cabecera);
    
    $numero_campos = count($array);
    
    $numero = 0;
    
    echo '<table class="table table-striped table-bordered table-hover datatable" id="'.$id.'"  style="font-size:'.$font.'" width="100%">
    <thead>
    <tr>';
  
 
    for($i=0; $i<$numero_campos; $i++)
    {
        if ( $i == 0 ) {
            if ( $ancho == '0' ) {
                echo '<th '. $estilo .'>'.$array[$i].'</th>';
            }else {
                echo '<th '. $estilo .' width='.$ancho.'>'.$array[$i].'</th>';
            }    
        }else     {
              echo '<th '. $estilo .'>'.$array[$i].'</th>';
        }
    }

    $bandera = 0;
    if ($editar == 'editar'){
        $bandera = 1;
    }
    if ($del == 'del'){
        $bandera = 1;
    }
    
    if ($editar == 'seleccion'){
        $bandera = 1;
    }

    if ($editar == 'aprobar'){
        $bandera = 1;
    }
    
    if ($bandera == 1){
        echo '<th> Acciones</th>';
     }
    echo '</tr>
            </thead><tbody>';
   
    //--------------------- agrega datos -----------------------------
    
    if ($tipo == 'mysql'){
        
    }
    
    if ($tipo == 'postgress'){
        
        $numero = $this->p_grid($resultado,$numero_campos,$bandera,$editar,$del,$evento,$filas );
    }
    
    if ($tipo == 'oracle'){
        
    } 
    
    echo '</tbody></table>';
 
    return $numero;
}	
//----
function table_basic_datos($resultado,$tipo,$editar,$del,$evento,$cabecera,$font='11px',$id='tablaBasica' )  {
    
    
    $array = explode(",", $cabecera);
    
    $numero_campos = count($array);
    
    $numero = 0;
    
    echo '<table class="table table-striped table-bordered table-hover datatable" id="'.$id.'"  style="font-size:'.$font.'" width="100%">
    <thead>
    <tr>';
    
    
    for($i=0; $i<$numero_campos; $i++)
    {
        
        echo '<th  bgcolor="#ebedff">'.$array[$i].'</th>';
        
        
    }
    $bandera = 0;
    if ($editar == 'editar'){
        $bandera = 1;
    }
    if ($del == 'del'){
        $bandera = 1;
    }
    
    if ($editar == 'seleccion'){
        $bandera = 1;
    }
    
    if ($bandera == 1){
        echo '<th> Acciones</th>';
    }
    echo '</tr>
            </thead><tbody>';
    
    //--------------------- agrega datos -----------------------------
    
    if ($tipo == 'mysql'){
        
    }
    
    if ($tipo == 'postgress'){
        
        $numero = $this->p_grid_datos($resultado,$numero_campos,$bandera,$editar,$del,$evento);
    }
    
    if ($tipo == 'oracle'){
        
    }
    
    echo '</tbody></table>';
    
    return $numero;
}	
//-------------
function table_basic_seleccion($resultado,$tipo,$editar,$del,$evento,$cabecera )  {
    
    /*
    entrada:
            resultado =  resulta do del sql
            tipo      =  tipo de conexion
            editar    =  evento editar / seleccionar
            del       =  evento eliminar / del
            evento    =  nombre funcion javascript separada - index de la variable clave
            cabecera  = columnas
    */
    
    $array = explode(",", $cabecera);
    
    $numero_campos = count($array);
    
    $numero = 0;
    
    $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


    echo '<table class="table table-striped table-bordered table-hover datatable" id="tablaBasica"  style="font-size: 11px" width="100%">
    <thead>
    <tr>';
    
    for($i=0; $i<$numero_campos; $i++)
    {
        
        echo '<th '. $estilo.'>'.$array[$i].'</th>';
        
        
    }
    $bandera = 0;
    if ($editar == 'editar'){
        $bandera = 1;
    }
    if ($del == 'del'){
        $bandera = 1;
    }
    
    if ($editar == 'seleccion'){
        $bandera = 1;
    }
    
    if ($bandera == 1){
        echo '<th> Acciones</th>';
    }
    echo '</tr>
            </thead><tbody>';
    
    //--------------------- agrega datos -----------------------------
    
    if ($tipo == 'mysql'){
        
    }
    
    if ($tipo == 'postgress'){
        
        $numero = $this->p_gridfila($resultado,$numero_campos,$bandera,$editar,$del,$evento);
    }
    
    if ($tipo == 'oracle'){
        
    }
    
    echo '</tbody></table>';
    
    return $numero;
}	
function table_cabecera($cabecera )  {
    
    
    $array = explode(",", $cabecera);
    
    $numero_campos = count($array);
    
    $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

    
    echo '<table class="table table-striped table-bordered table-hover datatable"  style="font-size: 11px" width="100%">
    <thead>
    <tr>';
    
    for($i=0; $i<$numero_campos; $i++)
    {
        
        echo '<th '. $estilo.' >'.$array[$i].'</th>';
        
        
    } 
    echo '</tr> </thead>';
   
    
 
    
}
//------------------------------
function KP_sumatoria($ncolumna,$va1="",$va2="",$va3="",$va4="",$va5="")  {
    $this->ncolumna 	=$ncolumna;
    
    $this->var1       =$va1;
    $this->var2   	  =$va2;
    $this->var3       =$va3;
    $this->var4       =$va4;
    
    $this->var5       =$va5;
    
  //  echo $this->var1.'<br>';
}	
//--------- postgress ------------------------
function p_grid( $resultado,$numero_campos,$bandera,$editar,$del,$evento,$filas='N' )  {
    
    $aevento = explode("-", $evento);
    
    $enlace    = $aevento[0];
    $pk_indice = $aevento[1];
    
    $numero = 0;
    

    
    $nsuma1 = 0;
    $nsuma2 = 0;
    $nsuma3 = 0;
    $nsuma4 = 0;
    $nsuma5 = 0;
    
  
    $esfila = 0;
    
    while($row=pg_fetch_row($resultado)) {
        
        echo "<tr>";
         
        for($i=0; $i< $numero_campos  ; $i++)
                {
                    $var = $this->_esdecimal( $row[$i] );
                    
                    if(  $var == 1) {
                        $valor  = number_format($row[$i],2,".",",");

                        echo '<td  align="right">'.$valor.'</td>';

                    }else {

                        echo '<td>'.trim($row[$i]).'</td>';

                    }
                    
                    
                    
                }
                
              
                $n1 = $row[$this->var1];
             
 
                $n2 = $row[$this->var2];
                $n3 = $row[$this->var3];
                $n4 = $row[$this->var4];
                $n5 = $row[$this->var5];
                
                $nsuma1 = $nsuma1 + $n1;
                $nsuma2 = $nsuma2 + $n2;
                $nsuma3 = $nsuma3 + $n3;
                $nsuma4 = $nsuma4 + $n4;
                $nsuma5 = $nsuma5 + $n5;
                 //----- acciones 
                if ($bandera == 1){
                    echo '<td>'.$this->_eventos($row[$pk_indice],$editar,$del,$enlace,$filas, $esfila ).'</td>';
                }
                
                echo "</tr>";
                
                $esfila ++;
                $numero ++;
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
        if (!empty($this->var4)) {
            echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        }	
        
        if (!empty($this->var5)) {
            echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        }	
        
    //    echo "</tbody></table>";
    
        pg_free_result ($resultado) ;
        
        return $numero;
}
//--------------
function p_grid_datos( $resultado,$numero_campos,$bandera,$editar,$del,$evento )  {
    
    $aevento = explode("-", $evento);
    
    $enlace    = $aevento[0];
    $pk_indice = $aevento[1];
    
    $numero = 0;
    
    
    
    $nsuma1 = 0;
    $nsuma2 = 0;
    $nsuma3 = 0;
    $nsuma4 = 0;
    $nsuma5 = 0;
    
    
    while($row=pg_fetch_row($resultado)) {
        
        echo "<tr>";
        
        for($i=0; $i< $numero_campos  ; $i++)
        {
             
      
                echo '<td>'.$row[$i].'</td>';
  
            
            
        }
        
 
        //----- acciones
        if ($bandera == 1){
            echo '<td>'.$this->_eventos($row[$pk_indice],$editar,$del,$enlace ).'</td>';
        }
        
        echo "</tr>";
        
        $numero ++;
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
    if (!empty($this->var4)) {
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
    }
    
    if (!empty($this->var5)) {
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
    }
    
    echo "</tbody></table>";
    
    pg_free_result ($resultado) ;
    
    return $numero;
}
//--------- postgress ------------------------
function p_gridfila( $resultado,$numero_campos,$bandera,$editar,$del,$evento )  {
    
    $aevento = explode("-", $evento);
    
    $enlace    = $aevento[0];
    $pk_indice = $aevento[1];
    
    $numero = 0;
    
    while($row=pg_fetch_row($resultado)) {
        
        echo "<tr>";
        
        for($i=0; $i< $numero_campos  ; $i++)
        {
            
            $var = $this->_esdecimal( $row[$i] );
            
            if(  $var == 1) {
                
                echo '<td  align="right">'.$row[$i].'</td>';
                
            }else {
                
                echo '<td>'.$row[$i].'</td>';
                
            }
            
            
        }
        //----- acciones
        if ($bandera == 1){
            echo '<td>'.$this->_eventos_fila($row[$pk_indice],$editar,$del,$enlace,$numero ).'</td>';
        }
        
        echo "</tr>";
        
        $numero ++;
    }
    
    echo "</tbody></table>";
    
    pg_free_result ($resultado) ;
    
    return $numero;
}
//--------- postgress ------------------------
function p_gridPdf( $resultado,$numero_campos,$bandera )  {
    
 
    
    
    while($row=pg_fetch_row($resultado)) {
        
        echo "<tr>";
        
        for($i=0; $i< $numero_campos  ; $i++)
        {
            
            $var = $this->_esdecimal( $row[$i] );
            
            if(  $var == 1) {
                
                echo '<td  align="right">'.$row[$i].'</td>';
                
            }else {
                
                echo '<td>'.$row[$i].'</td>';
                
            }
            
            
        }
      
        
        echo "</tr>";
        
    }
    
    // echo "</table>";
    
    pg_free_result ($resultado) ;
}
//------------------------------
//--------- postgress ------------------------
function _eventos( $pk_indice,$editar,$del,$evento,$filas='N' , $esfila=0)  {
    
    $ceditar = '';
    $cdel = '';
    
    if ($editar == 'editar'){
        $ceditar =  '<button class="btn btn-xs btn-warning" onClick="'.$evento.'('."'".$editar."'".','."'".trim($pk_indice)."'".')"> '.
        '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';

        if (trim($filas) == 'S'){
            $ceditar =  '<button class="btn btn-xs btn-warning" onClick="'.$evento.'('."'".$editar."'".','."'".trim($pk_indice)."',".$esfila.')"> '.
            '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
        }
    }
    
    if ($del == 'del'){
        $cdel =  '<button class="btn btn-xs btn-danger" onClick="'.$evento.'('."'".$del."'".','."'".trim($pk_indice)."'".')"> '.
            '<i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
    }
    
    if ($del == 'anular'){
        $cdel =  '<button class="btn btn-xs btn-danger" title="Anular transacción"  onClick="'.$evento.'('."'".$del."'".','."'".trim($pk_indice)."'".')"> '.
            '<i class="glyphicon glyphicon-trash"></i></button>&nbsp;';
    }

    if ($editar == 'seleccion'){
     
        $ceditar =  '<button class="btn btn-xs btn-warning" title="Seleccionar datos" onClick="'.$evento.'('."'".$editar."'".','."'".trim($pk_indice)."'".')"> '.
        '<i class="glyphicon glyphicon-play"></i></button>&nbsp;';

     //   $evento = 'onClick="'.$evento.'('."'".$editar."'".','.trim($pk_indice).')"';
     //   $cdel =  "<a href='#' ".$evento." class='ls' ><i class='glyphicon glyphicon-play'></i></a>";
  
    }

    if ($editar == 'aprobar'){
     

        $ceditar =  '<button class="btn btn-xs btn-success" title="Aprobar transacción" onClick="'.$evento.'('."'".$editar."'".','."'".trim($pk_indice)."'".')"> '.
        '<i class="glyphicon glyphicon-ok"></i></button>&nbsp;';

        // $evento = 'onClick="'.$evento.'('."'".$editar."'".','.trim($pk_indice).')"';
        // $cdel =  "<a href='#' ".$evento." class='ls' title='Seleccionar datos'><i class='glyphicon glyphicon-play'></i></a>";
  
    }
 
    $cevento = $ceditar.$cdel;
    
    return $cevento;
   
}
//-------------
function _eventos_fila( $pk_indice,$editar,$del,$evento,$fila )  {
    
    $ceditar = '';
    $cdel = '';
    
    if ($editar == 'editar'){
        $ceditar =  '<button class="btn btn-xs btn-info" onClick="'.$evento.'('."'".$editar."'".','.trim($pk_indice).')"> '.
            '<i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
    }
    
    if ($del == 'del'){
        $cdel =  '<button class="btn btn-xs btn-danger" onClick="'.$evento.'('."'".$del."'".','.trim($pk_indice).')"> '.
            '<i class="glyphicon glyphicon-remove"></i></button>&nbsp;';
    }
    
    if ($editar == 'seleccion'){
        
        $evento = 'onClick="'.$evento.'('."'".$editar."'".','."'".trim($pk_indice)."'".','.$fila.')"';
        $cdel =  "<a href='#' ".$evento." class='btn btn-xs btn-warning' title='Seleccionar datos'><i class='glyphicon glyphicon-play'></i></a>";
        
        
    }
    
    $cevento = $ceditar.$cdel;
    
    return $cevento;
    
}
//----------------------------------------------------------------------------- 
function table_pdf_js($resultado,$tipo,$cabecera )  {
    
    
    $array = explode(",", $cabecera);
    
    $numero_campos = count($array);
    
    
    echo '<table  width="100%">
     <tr>';
    
    for($i=0; $i<$numero_campos; $i++)
    {
        
        echo '<td>'.$array[$i].'</td>';
        
        
    }
    $bandera = 0;
   
    echo '</tr> ';
    
    //--------------------- agrega datos -----------------------------
    
    if ($tipo == 'mysql'){
        
    }
    
    if ($tipo == 'postgress'){
        
        $this->p_gridPdf($resultado,$numero_campos,$bandera);
    }
    
    if ($tipo == 'oracle'){
        
    }
    
    echo '</table>';
    
}	
}		
 	
?>