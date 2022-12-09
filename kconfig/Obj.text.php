<?php
/**
 Constructor de la clase  del formulario de ingreso de datos
 @return

 */ 
class objects_text  {
   
    private static $_instance;
 
/**
     Constructor de la clase  del formulario de ingreso de datos
     @return
     
*/ 
function editor_area($titulo_aa,$variable,$rows,$cols,$maxlength,$datos,$required,$readonly,$salto)
{
    
    $titulo_aa   =  ($titulo_aa);
    $placeholder = '';
    
    if ($required=='required')   $required ='required="required" ';   else   $required ='';
            
    if ($readonly=='readonly')  $readonly = 'readonly="readonly" ';   else   $readonly = '';
                    
  
   $cadena = $salto;
   $array  = explode("-", $cadena);
   $div1   = $array[0];
   $div2   = $array[1];
   $div3   = $array[2];
                    
   if ($div1 == 'div'){
       $titulo1 = '';
       $td      = '';
       $td1     = '';
   }
   else	 {
                        
                        if (empty($titulo_aa)){
                            $titulo1    = '';
                            $td         = '';
                            $td1        = '';
                        }
                        else{
                            $titulo1    ='<td align="right">'.$titulo_aa.'</td>';
                            $td         = '<td align="left">';
                            $td1        = '</td>';
                        }
     }
     
     echo $titulo1;
                    
     if ($div1 == 'div'){
         echo '<label style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo_aa.'</label>';
         echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
     }
                    
      echo $td.'<textarea name="'.$variable.'" 
                          class="textarea"  
                          style="width: 100%; height: 150px;" 
                          maxlength="'.$maxlength.'" '.$readonly.$required.' 
                          id="'.$variable.'" 
                          placeholder="'.$placeholder.'">'.
					      str_replace('"', '&quot;', ( (trim($datos[$variable])))).'
               </textarea>'.$td1;
		 
 					
			  if ($div1 == 'div'){  echo '</div>'; }
 					
			  if ($salto == '/'){  echo '</tr><tr>'; }
			  
	return true;
}
/**
  CASILLERO DE TEXTO text
 @return
 
 */ 
function text($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
  
    $v1     = '' ;
    $v2     = '' ;
    $v4     = '' ;

    $cadena    = $salto_linea;
    $array     = explode("-", $cadena);
    $div1      = $array[0];
    $div2      = $array[1];
    $div3      = $array[2];

    $esboton   = strpos(trim($titulo),'class');
    $esboton1  = strpos(trim($titulo),'onClick');
    $esboton2  = strpos(trim($titulo),'onclick');
    $esboton3  = strpos(trim($titulo),'<b>');
    $esboton4  = strpos(trim($titulo),'</b>');
    $valida_b  = $esboton +  $esboton1 +$esboton2 +$esboton3 +$esboton4;
 
 
    if ($required=='required'){
        $required        = ' required="required" '; 
        if ( $valida_b > 0 ) {
            $placeholder     = ' es requerido ';
        }    
        else     {
            $placeholder     =  $titulo.' es requerido ';
        }
    }else{
         if (  $valida_b > 0 ) {
            $placeholder     = ' es opcional ';
        }    
        else     {
            $placeholder     =  $titulo.' es opcional ';
        }
    }   

            if ($readonly=='readonly')  {
                    $readonly = ' readonly="readonly"  '; 
            }
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v4 = ' style="text-align:right" ';
            }
            if ($type=='entero'){
                $v1 = ' step="1" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
                $type= 'number';
            }
            
            if ($type  == 'texto'){ 
                    $type = 'text';
                    $v1 = ' size ="'.$size.'"' ;
                    $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'time'){ 
                $type = 'time';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }

            if (($type) == 'tel'){ 
                    $v1 = ' size ="'.$size.'"' ;
                    $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            
            if (($type) == 'url'){ 
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
        
            if (($type) == 'email'){ 
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
        
            if (($type) == 'date'){ 
            $v1 = ' size ="'.$size.'" ' ;
            $v2 = ' maxlength  ="'.$maxlength.'" ' ;
     }		
 
    
 
     if ($div1 == 'div'){
    	 	$titulo1  = '';
    		$td       = '';
    		$td1      = '';
      }		
     else	 {
     	 if (empty($titulo)){
    		$titulo1  = '';
    		$td       = '';
    		$td1      = '';
    	 }
     	 else{
    		$titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
    		$td = '<td align="left" valign="middle">';
    		$td1 = '</td>';
    	 }
       }
     
      echo $titulo1;
   
      if ($div1 == 'div'){
              if (!empty($titulo))    {
                  if ($div2   <> '0'){
                      echo '<label id="'.'l'.$variable.'"  style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                   }else  {
                    $placeholder     =  $titulo;
                   }
              }
              echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
      }
  
     echo $td.'<input type="'.$type.'" 
                   name="'.$variable.'" 
                   id="'.$variable.'"'.$required.' 
                   autocomplete="offS" 
                   class="form-control" 
                   placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.' value="'. 
                   str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
		
  
      if ($div1 == 'div'){ echo '</div>';  }		 
     		  
      if($salto_linea=='/'){ echo '</tr><tr>';  }
       
      if($salto_linea=='-'){ echo '</tr>'; } 
  
  
  return true;
}	
/**
 CASILLERO DE TEXTO text
 @return
 
 */ 
function text_decimal($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
    $titulo =  (($titulo));
    $v4     ='';
    $v1     = '' ;
    $v2     = '' ;
    
    if ($required=='required'){
        
        $required        = ' required="required" ';
        $placeholder     = 'requerido';
        
    }else	{
        
        $required        ='';
        $placeholder     = '';
        
    }
    
    
    if ($readonly=='readonly')  $readonly = ' readonly="readonly"  '; else	 $readonly ='';
    
 
        $v1 = ' step="0.000001" ';
        $v2 = '';
        $v4 = ' style="text-align:right" ';
 
      
    $cadena = $salto_linea;
    $array = explode("-", $cadena);
    
    $div1 = $array[0];
    $div2 = $array[1];
    $div3 = $array[2];
    
    if ($div1 == 'div'){
        $titulo1  = '';
        $td       = '';
        $td1      = '';
    }
    else	 {
        
        if (empty($titulo)){
            $titulo1  = '';
            $td       = '';
            $td1      = '';
        }
        
        else{
            $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
            $td = '<td align="left" valign="middle">';
            $td1 = '</td>';
        }
        
    }
    
    echo $titulo1;
     
    if ($div1 == 'div'){
        
        if (!empty($titulo))    {
            if ($div2   <> '0'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                
            }
        }
        
        echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
    }
    
    
    echo $td.'<input type="'.$type.'"
                   name="'.$variable.'"
                   id="'.$variable.'"'.$required.'
                   autocomplete="offS"
                   class="form-control"
                   placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.' value="'.
                   str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
                   
                   
                   if ($div1 == 'div'){ echo '</div>';  }
                   
                   if($salto_linea=='/'){ echo '</tr><tr>';  }
                   
                   if($salto_linea=='-'){ echo '</tr>'; }
                   
                   
                   return true;
}	
//------------------------------------------
function text_date($titulo,$hoy,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
    //('Fecha',$this->hoy,"date",'fecha',15,15,$datos,'required','','div-2-4');
    
    $titulo =  (($titulo));
    
    $placeholder = '';
    if ($required=='required'){
        $required =' required="required" ';
        $placeholder = 'requerido';
    }else	{
        $required ='';
        $placeholder = '';
    }
    if ($readonly=='readonly')
        $readonly = ' readonly="readonly"  ';
        else
            $readonly ='';
            // -------------------------
            $v4 ='';
            $v1 = '' ;
            $v2 = '' ;
            
            $type = 'date';
                 $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
             
            
            // div-3-3  div para objetos
            $cadena = $salto_linea;
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
                    $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
                    $td = '<td align="left" valign="middle">';
                    $td1 = '</td>';
                }
            }
            echo $titulo1;
            
           
            
            
            
            if ($div1 == 'div'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
           // $hoy 	     =  date("Y-m-d");    	 
            
            echo $td.'<input type="'.$type.'" 
                    name="'.$variable.'" 
                    id="'.$variable.'"'.$required.' 
                    autocomplete="off" 
                    class="form-control" 
                    min='.$hoy.'
                    placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
            ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            if ($div1 == 'div'){
                echo '</div>';
            }
            
            
            
            if($salto_linea=='/'){
                echo '</tr><tr>';
            }
            
            if($salto_linea=='-'){
                echo '</tr>';
            }
            
            
            
            return true;
}	
//-----------------------------
function text_dia($titulo,$dias,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea,$evento="-"){
    
    
    $fecha_actual = date("Y-m-d");
    
    if ( $dias == '0'){
        $hoy = $fecha_actual;
    }else{
        $dia_valida = '- '.$dias.' days';
        $hoy = date("Y-m-d",strtotime($fecha_actual.$dia_valida));
    }
    
        
    
    //('Fecha',$this->hoy,"date",'fecha',15,15,$datos,'required','','div-2-4');
    
    $titulo =  $titulo ;
    
    $placeholder = '';
    if ($required=='required'){
        $required =' required="required" ';
        $placeholder = 'requerido';
    }else	{
        $required ='';
        $placeholder = '';
    }
    if ($readonly=='readonly')
        $readonly = ' readonly="readonly"  ';
        else
            $readonly ='';
            // -------------------------
            $v4 ='';
            $v1 = '' ;
            $v2 = '' ;
            
            $type = 'date';
            $v1 = ' size ="'.$size.'" ' ;
            $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            
            
            // div-3-3  div para objetos
            $cadena = $salto_linea;
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
                    $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
                    $td = '<td align="left" valign="middle">';
                    $td1 = '</td>';
                }
            }
            echo $titulo1;
            
            
            
            
            
            if ($div1 == 'div'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
            // $hoy 	     =  date("Y-m-d");
            
            echo $td.'<input type="'.$type.'"
                    name="'.$variable.'" .'.$evento.'
                    id="'.$variable.'"'.$required.'
                    autocomplete="off"
                    class="form-control"
                    style="background-color:#f9ffa4"
                    min='.$hoy.'
                    placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
                    ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            if ($div1 == 'div'){
                echo '</div>';
            }
            
            
            
            if($salto_linea=='/'){
                echo '</tr><tr>';
            }
            
            if($salto_linea=='-'){
                echo '</tr>';
            }
            
            
            
            return true;
}	
//-----------------------
function text_filtro($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
    $titulo = utf8_encode(($titulo));
    
    $placeholder = $titulo;
    
    
    if ($required=='required'){
        
        $required =' required="required" ';
     
    }else	{
        
        $required ='';
        
     }
     
    if ($readonly=='readonly')
        $readonly = ' readonly="readonly"  ';
        else
            $readonly ='';
            // -------------------------
            $v4 ='';
            $v1 = '' ;
            $v2 = '' ;
            
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            if (($type) == 'texto'){
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            
            if (($type) == 'tel'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            
            if (($type) == 'url'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'email'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'date'){
                $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            }
            
            $titulo ='';
            
            // div-3-3  div para objetos
            $cadena = $salto_linea;
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
                    $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
                    $td = '<td align="left" valign="middle">';
                    $td1 = '</td>';
                }
            }
            echo $titulo1;
            
            
            /*if ($type == 'password'){
                $valor = base64_decode(trim($datos[$variable]));
            }
            else{
                $valor = trim($datos[$variable]);
            }*/
            
             
            if ($div1 == 'div'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 12px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
            
            echo $td.'<input type="'.$type.'" 
                      name="'.$variable.'" 
                      id="'.$variable.'"'.$required.' 
                      autocomplete="off" 
                      class="form-control" 
                      placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.' value="'. 
                      str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            
            if ($div1 == 'div'){  echo '</div>';   }
             
            if($salto_linea=='/'){  echo '</tr><tr>'; }
            
            if($salto_linea=='-'){  echo '</tr>';  }
             
            
            return true;
}	


function text_yellow($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
    $v1 = '' ;
    $v2 = '' ;
    $v4 = '' ;
 

    $cadena     = $salto_linea;
    $array      = explode("-", $cadena);
    $div1       = $array[0];
    $div2       = $array[1];
    $div3       = $array[2];

    $esboton   = strpos(trim($titulo),'class');
    $esboton1  = strpos(trim($titulo),'onClick');
    $esboton2  = strpos(trim($titulo),'onclick');
    $esboton3  = strpos(trim($titulo),'<b>');
    $esboton4  = strpos(trim($titulo),'</b>');
    $valida_b  = $esboton +  $esboton1 +$esboton2 +$esboton3 +$esboton4;
 
 
    if ($required=='required'){
        $required        = ' required="required" '; 
        if ( $valida_b > 0 ) {
            $placeholder     = ' es requerido ';
        }    
        else     {
            $placeholder     =  $titulo.' es requerido ';
        }
    }else{
         if (  $valida_b > 0 ) {
            $placeholder     = ' es opcional ';
        }    
        else     {
            $placeholder     =  $titulo.' es opcional ';
        }
    }       

    if ($readonly=='readonly'){
        $readonly = ' readonly="readonly"  ';
    }    
       
            
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            
            if ($type=='entero'){
                $v1 = ' step="1" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
                $type= 'number';
            }
            
           
            if ($type=='float'){
                $v1 = ' step="0.0001" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            if (($type) == 'texto'){
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'tel'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'url'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'email'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'date'){
                $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            }
            if (($type) == 'time'){
                $v1 = '  min="00:00" ' ;
                $v2 = ' max="23:00" ' ;
            }
            
            
            if ($div1 == 'div'){
                $titulo1        = '';
                $td             = '';
                $td1            = '';
            }
            else	 {
                if (empty($titulo)){
                    $titulo1    = '';
                    $td         = '';
                    $td1        = '';
                }
                else{
                    $titulo1    = '<td align="right" valign="middle">'.$titulo.'</td>';
                    $td         = '<td align="left" valign="middle">';
                    $td1        = '</td>';
                }
            }
            echo $titulo1;
            
            if ($div1 == 'div'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 15px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
            echo $td.'<input type="'.
                    $type.'" name="'.
                    $variable.'" id="'.
                    $variable. '"'.
                    $required.' autocomplete="off" 
                    class="form-control"  
                    style="background-color:#FFFE97"
                    placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
                   ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
           
            if ($div1 == 'div'){     echo '</div>';  }
             
            if($salto_linea=='/'){   echo '</tr><tr>';  }
            
            if($salto_linea=='-'){   echo '</tr>';   }
             
            return true;
}	
//-----------------------------------------------------------------------------------------------------
function text_blue($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea,$titulo_place=''){
    
    $v1     = '' ;
    $v2     = '' ;
    $v4     = '' ;
    $cadena = $salto_linea;
    $array = explode("-", $cadena);
       
       $div1 = $array[0];
       $div2 = $array[1];
       $div3 = $array[2];

       $esboton   = strpos(trim($titulo),'class');
       $esboton1  = strpos(trim($titulo),'onClick');
       $esboton2  = strpos(trim($titulo),'onclick');
       $esboton3  = strpos(trim($titulo),'<b>');
       $esboton4  = strpos(trim($titulo),'</b>');
       $valida_b  = $esboton +  $esboton1 +$esboton2 +$esboton3 +$esboton4;
    
    
       if ($required=='required'){
           $required        = ' required="required" '; 
           if ( $valida_b > 0 ) {
               $placeholder     = ' es requerido ';
           }    
           else     {
               $placeholder     =  $titulo.' es requerido ';
           }
       }else{
            if (  $valida_b > 0 ) {
               $placeholder     = ' es opcional ';
           }    
           else     {
               $placeholder     =  $titulo.' es opcional ';
           }
       }    


    if ( !empty($titulo_place)) {
        $placeholder = $titulo_place;
    }  
    if ($readonly=='readonly'){
        $readonly = ' readonly="readonly"  ';
    }  
                    if ($type=='number'){
                        $v1 = ' step="0.01" ';
                        $v2 = '';
                        $v4 = ' style="text-align:right" ';
                    }
                    if ($type=='entero'){
                        $v1 = ' step="1" ';
                        $v2 = '';
                        $v4 = ' style="text-align:right" ';
                        $type= 'number';
                    }
                    if (($type) == 'texto'){
                        $type = 'text';
                        $v1 = ' size ="'.$size.'"' ;
                        $v2 = ' maxlength  ="'.$maxlength.'"' ;
                    }
                    if (($type) == 'tel'){
                        $v1 = ' size ="'.$size.'"' ;
                        $v2 = ' maxlength  ="'.$maxlength.'"' ;
                    }
                    if (($type) == 'url'){
                        $v1 = ' size ="'.$size.'"' ;
                        $v2 = ' maxlength  ="'.$maxlength.'"' ;
                    }
                    if (($type) == 'email'){
                        $v1 = ' size ="'.$size.'"' ;
                        $v2 = ' maxlength  ="'.$maxlength.'"' ;
                    }
                    if (($type) == 'date'){
                        $v1 = ' size ="'.$size.'" ' ;
                        $v2 = ' maxlength  ="'.$maxlength.'" ' ;
                    }
                    if (($type) == 'time'){ 
                        $type = 'time';
                        $v1 = ' size ="'.$size.'"' ;
                        $v2 = ' maxlength  ="'.$maxlength.'"' ;
                    }
                    if ($div1 == 'div'){
                        $titulo1    = '';
                        $td         = '';
                        $td1        = '';
                    }
                    else	 {
                        if (empty($titulo)){
                            $titulo1    = '';
                            $td         = '';
                            $td1        = '';
                        }
                        else{
                            $titulo1    = '<td align="right" valign="middle">'.$titulo.'</td>';
                            $td         = '<td align="left" valign="middle">';
                            $td1        = '</td>';
                        }
                    }

             
               
            if ($div1 == 'div'){
                $titulo1 =  $titulo;
                if ( $div2 == '0'){
                     $titulo1 = '';
                 }  
                
                 echo '<label id="'.'l'.$variable.'"  style="padding-top: 15px;text-align: right;" class="col-md-'.$div2.'">'.$titulo1.'</label>';
                 echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
             }
            
             if ( $div2 == '0'){
                $placeholder = $titulo;
             }    
            
            echo $td.'<input type="'.
                        $type.'" name="'.
                        $variable.'" id="'.
                        $variable.'"'.
                        $required.' autocomplete="off"
                        class="form-control"
                        style="background-color:#c6dcff"
                        placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
                        ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            
            if ($div1 == 'div'){     echo '</div>';  }
            
            if($salto_linea=='/'){   echo '</tr><tr>';  }
            
            if($salto_linea=='-'){   echo '</tr>';   }
            
            
            
            return true;
}	
/*
Casillero para filtro de datos
*/
function text_yellow_filtro($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea,$placeholder){
    
     
     $v1 = '' ;
     $v2 = '' ;
     $v4 = '' ;

     $cadena    = $salto_linea;
     $array     = explode("-", $cadena);
     $div1      = $array[0];
     $div2      = $array[1];
     $div3      = $array[2];

     if ($required=='required'){
        $required        = ' required="required" '; 
        $esboton = strpos($titulo,'class');
        if ( $esboton > 0 ) {
            $placeholder     = ' es requerido ';
        }    
        else     {
            $placeholder     =  $titulo.' es requerido ';
        }
    }
    if ($readonly=='readonly'){
        $readonly = ' readonly="readonly"  ';
    }
    
            
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            if ($type=='entero'){
                $v1 = ' step="1" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
                $type= 'number';
            }
            
            if (($type) == 'texto'){
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'tel'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'url'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'email'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'date'){
                $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            }
            if ($div1 == 'div'){
                $titulo1 = '';
                $td = '';
                $td1 = '';
            }
            
            echo $titulo1;
            
 
            
            if ($div1 == 'div'){
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 15px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
             
            echo $td.'<input type="'.
                             $type.'"  name="'.
                             $variable.'" id="'.
                             $variable.'"'.
                             $required.' autocomplete="off"
                             class="form-control"
                             placeholder="'.$placeholder.'" 
                             title="'.$placeholder.'"'.
                             $v1.$v2.$v4.$readonly.
                             ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            if ($div1 == 'div'){
                echo '</div>';
            }
          
            
            return true;
}	

//  CASILLERO DE TEXTO text_place
function text_place($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
     
    $placeholder = $titulo;
    
    $placeholder = $titulo;
    $v1 = '' ;
    $v2 = '' ;
    $v4          = '';
    $cadena       = $salto_linea;
    $array        = explode("-", $cadena);
    $div1         = $array[0];
    $div3         = $array[2];
    
    
    $esboton   = strpos(trim($titulo),'class');
    $esboton1  = strpos(trim($titulo),'onClick');
    $esboton2  = strpos(trim($titulo),'onclick');
    $esboton3  = strpos(trim($titulo),'<b>');
    $esboton4  = strpos(trim($titulo),'</b>');
    $valida_b  = $esboton +  $esboton1 +$esboton2 +$esboton3 +$esboton4;
    
    
    if ($required=='required'){
        $required        = ' required="required" ';
        if ( $valida_b > 0 ) {
            $placeholder     = ' es requerido ';
        }
        else     {
            $placeholder     =  $titulo.' es requerido ';
        }
    }else{
        if (  $valida_b > 0 ) {
            $placeholder     = ' es opcional ';
        }
        else     {
            $placeholder     =  $titulo.' es opcional ';
        }
    }   
    
    
    if ($readonly=='readonly'){
        $readonly = ' readonly="readonly"  ';
    }  
           
            
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            if (($type) == 'texto'){
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            
            if (($type) == 'tel'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            
            if (($type) == 'url'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'email'){
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if (($type) == 'date'){
                $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            }
            
            
            // div-3-3  div para objetos
            $cadena = $salto_linea;
            $array = explode("-", $cadena);
            
            $div1 = $array[0];
            // $div2 = $array[1];
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
                    $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
                    $td = '<td align="left" valign="middle">';
                    $td1 = '</td>';
                }
            }
            echo $titulo1;
            
            /*
            if ($type == 'password'){
                $valor = base64_decode(trim($datos[$variable]));
            }
            else{
                $valor = trim($datos[$variable]);
            }
            */
               
            if ($div1 == 'div'){
          
                echo '<div id="'.'d'.$variable.'" style="padding-top: 2px;"  class="col-md-'.$div3.'">';
            }
            
            // class="form-control"  <input type="text" required="required" placeholder="sdsdsadasd" size="12" maxlength="12" readonly="readonly">
            
            echo $td.'<input class="form-control" type="'.$type.'" 
                             name="'.$variable.'" 
                             id="'.$variable.'"'.$required.'  
                             placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
                            ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
            
            if ($div1 == 'div'){
                echo '</div>';
            }
            
            
            
            if($salto_linea=='/'){
                echo '</tr><tr>';
            }
            
            if($salto_linea=='-'){
                echo '</tr>';
            }
            
            
            
            return true;
}	
//----------------------------------
function textautocomplete($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
	
	$titulo         = utf8_encode(($titulo));
	$placeholder    = 'Ingrese informacion required ';
    $required       = '';
    $readonly       = '';
 	$v4             = '';
	$v1             = '' ;
	$v2             = '' ;
    $cadena         = $salto_linea;
    $array          = explode("-", $cadena);
    $div2           = $array[1];
    $div3           = $array[2];
	
	if ($required=='required'){
		$required =' required="required" ';
	} 
	
	if ($readonly=='readonly'){
	    $readonly = ' readonly="readonly"  ';
	}else{
		 		if (($type) == 'texto'){
				$type = 'text';
				$v1 = ' size ="'.$size.'"' ;
				$v2 = ' maxlength  ="'.$maxlength.'"' ;
			}
	}
		  
	if ($div2 > 0 ){
 				echo '<label id="'.'l'.$variable.'"  style="padding-top: 10px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
	}else{
        $placeholder = $titulo;
    }    
 			
	echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
			
	echo  '<input type="'.$type.'" 
                       name="'.$variable.'" 
                       id="'.$variable.'"'.$required.' 
                       class="typeahead form-control" 
                       autocomplete="nope"
                       style="background-color:#FFFE97"  
                       placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
			           ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>';
 			
		 
	echo '</div>';
	 
		 return true;
}	
//----------------------------------
function textautocomplete14($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
    
    $titulo = utf8_encode(($titulo));
    
    $placeholder = '';
    
    if ($required=='required'){
        
        $required =' required="required" ';
        $placeholder = 'requerido';
        
    }else	{
        
        $required ='';
        $placeholder = '';
        
    }
    
    if ($readonly=='readonly'){
        
        $readonly = ' readonly="readonly"  ';
        
    }else{
        $readonly ='';
        // -------------------------
        $v4 ='';
        $v1 = '' ;
        $v2 = '' ;
        
        if (($type) == 'texto'){
            $type = 'text';
            $v1 = ' size ="'.$size.'"' ;
            $v2 = ' maxlength  ="'.$maxlength.'"' ;
            
        }
    }
    
    
    // div-3-3  div para objetos
    
    $cadena = $salto_linea;
    
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
            $titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
            $td = '<td align="left" valign="middle">';
            $td1 = '</td>';
        }
    }
    
    echo $titulo1;
    
    
    
    if ($div1 == 'div'){
        
        echo '<label id="'.'l'.$variable.'"  style="padding-top: 10px;text-align: right;font-size: 14px" class="col-md-'.$div2.'">'.$titulo.'</label>';
        echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
    }
    
    
    echo $td.'<input type="'.$type.'"
                       name="'.$variable.'"
                       id="'.$variable.'"'.$required.'
                       class="typeahead form-control"
                       autocomplete="nope"
                       style="background-color:#FFFE97;font-size: 14px"
                       placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
                       ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
    
    
    if ($div1 == 'div'){
        echo '</div>';
    }
    
    
    
    if($salto_linea=='/'){
        echo '</tr><tr>';
    }
    
    if($salto_linea=='-'){
        echo '</tr>';
    }
    
    
    return true;
}	
//  CASILLERO DE TEXTO echo '<input style="font-weight: bold;" class="form-control input-lg" type="text" placeholder=".input-lg" value = "09303">';
 function textSMALL($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
	 
  $titulo = utf8_encode(($titulo));  
  	 
  $placeholder = '';			
  if ($required=='required'){
   $required =' required="required" '; 
   $placeholder = 'requerido';
  }else	{
   $required =''; 
   $placeholder = '';
 }
 if ($readonly=='readonly')
  $readonly = ' readonly="readonly"  '; 
 else	
  $readonly =''; 
 // -------------------------			
 $v4 ='';
 $v1 = '' ;
 $v2 = '' ;
   
 if ($type=='number'){
  $v1 = ' step="0.01" ';
  $v2 = '';
  $v4 = ' style="text-align:right" ';
 }
 if (($type) == 'texto'){ 
    $type = 'text';
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
 if (($type) == 'tel'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
  if (($type) == 'url'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
  if (($type) == 'email'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 if (($type) == 'date'){ 
   $v1 = ' size ="'.$size.'" ' ;
   $v2 = ' maxlength  ="'.$maxlength.'" ' ;
 }		
 		
 if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
 }
 else{
	$titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
	$td = '<td align="left" valign="middle">';
	$td1 = '</td>';
 }
 echo $titulo1;

  	/*			
	if ($type == 'password'){
					$valor = base64_decode(trim($datos[$variable]));
	}
	else{
					$valor = trim($datos[$variable]);
	}
			
				*/

 echo $td.'<input type="'.$type.'" style="font-weight: bold;"  name="'.$variable.'" id="'.$variable.
 		  '"'.$required.' class="form-control input-lg" placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
		  ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
		  
  if($salto_linea=='/'){
    echo '</tr><tr>';
  }
   
  if($salto_linea=='-'){
   	echo '</tr>';
  } 
 
  return true;
}
		/*   CASILLERO DE TEXTO
		---------------------------------------------------------------------*/
function texte($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$evento,$salto)
{
 		
 
 
    $placeholder = $titulo;
    $v4          = '';
    $cadena       = $salto;
    $array        = explode("-", $cadena);
    $div1         = $array[0];
    $div2         = $array[1];
    $div3         = $array[2];
     		
    
    $esboton   = strpos(trim($titulo),'class');
    $esboton1  = strpos(trim($titulo),'onClick');
    $esboton2  = strpos(trim($titulo),'onclick');
    $esboton3  = strpos(trim($titulo),'<b>');
    $esboton4  = strpos(trim($titulo),'</b>');
    $valida_b  = $esboton +  $esboton1 +$esboton2 +$esboton3 +$esboton4;
 
 
    if ($required=='required'){
        $required        = ' required="required" '; 
        if ( $valida_b > 0 ) {
            $placeholder     = ' es requerido ';
        }    
        else     {
            $placeholder     =  $titulo.' es requerido ';
        }
    }else{
         if (  $valida_b > 0 ) {
            $placeholder     = ' es opcional ';
        }    
        else     {
            $placeholder     =  $titulo.' es opcional ';
        }
    }     

            if ($readonly=='readonly'){
            $readonly = ' readonly="readonly"  '; 
            }   
             if ($type=='number'){
            $v1 = ' step="0.01" ';
            $v2 = '';
            $v4 = ' style="text-align:right" ';
            }
            if (($type) == 'texto'){ 
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if ($type=='entero'){
                $v1 = ' step="1" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
                $type= 'number';
            }
            if ($type=='date'){ 
            $v1 = ' size ="'.$size.'" ' ;
            $v2 = ' maxlength  ="'.$maxlength.'" ' ;
            }				
            if ($div1 == 'div'){
                    $titulo1    = '';
                    $td         = '';
                    $td1        = '';
            }		
            else	 { 
            
                if (empty($titulo)){
                                    $titulo1    = '';
                                    $td         = '';
                                    $td1        = '';
                }
                else{
                                $titulo1    = '<td align="right">'.$titulo.'</td>';
                                $td         = '<td align="left">';
                                $td1        = '</td>';
                }
            }
				
            if ($div1 == 'div'){
                if ( $div2 > 0 ){
                        echo '<label id="'.'l'.$variable.'"  style="padding-top: 5px;text-align: right;"  class="col-md-'.$div2.'">'.$titulo.'</label>';
                }	
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }		
		
            echo $titulo1;
            echo $td.'<input type="'.
                 $type.'" autocomplete="off" name="'.
                 $variable.'" id="'.
                 $variable.'"'.
                 $required.' class="form-control" placeholder="'.
                 $placeholder.'"'.$v1.$v2.$v4.$evento.' '.
                 $readonly.' value="'. str_replace('"', '&quot;',    (trim($datos[$variable]))).'"'.' />'.$td1;
                            
            if ($div1 == 'div'){
                echo '</div>';
            }		 
    		 				 
     
return true;
}	
//--------------
function texte_focus($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$evento,$salto)
{
    
    $placeholder = '';
    $titulo = utf8_encode(($titulo));
    
    if ($required=='required'){
        $required =' required="required" ';
        $placeholder = 'requerido';
    }else	{
        $required ='';
        $placeholder = '';
    }
    
    if ($readonly=='readonly')
        $readonly = ' readonly="readonly"  ';
        else
            $readonly ='';
            
            $v4 ='';
            if ($type=='number'){
                $v1 = ' step="0.01" ';
                $v2 = '';
                $v4 = ' style="text-align:right" ';
            }
            if (($type) == 'texto'){
                $type = 'text';
                $v1 = ' size ="'.$size.'"' ;
                $v2 = ' maxlength  ="'.$maxlength.'"' ;
            }
            if ($type=='date'){
                $v1 = ' size ="'.$size.'" ' ;
                $v2 = ' maxlength  ="'.$maxlength.'" ' ;
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
                //    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
                echo '<label id="'.'l'.$variable.'"  style="padding-top: 5px;text-align: right;"  class="col-md-'.$div2.'">'.$titulo.'</label>';
                echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
            }
            
            
            echo $titulo1;
            
            echo $td.'<input type="'.$type.'" autocomplete="off"  name="'.$variable.'" id="'.$variable.'"'.$required.
                    ' class="form-control" placeholder="'.
                     $placeholder.'"'.$v1.$v2.$v4.$evento.' autofocus '.
                     $readonly.' value="'. str_replace('"', '&quot;',    (trim($datos[$variable]))).'"'.' />'.$td1;
            
            if ($div1 == 'div'){
                echo '</div>';
            }
            
            
            if($salto=='/'){
                echo '</tr><tr>';
            }
            if($salto=='-'){
                echo '</tr>';
            }
            return true;
}	


//---------------------------------------------------------------------*/
function  textMask($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$placeholder,$data_mask,$salto)
{

//$titulo = utf8_encode(($titulo));  
 			
				if ($required=='required')
					$required ='required="required" '; 
				else	
					$required =''; 

				if ($readonly=='readonly')
					$readonly = 'readonly="readonly" '; 
				else	
					$readonly =''; 
			
				if ($type=='number'){
					$v1 = 'min';
					$v2 = 'max';
				}
				else{
					$v1 = 'size';
					$v2 = 'maxlength';
				}
				
				if (empty($data_mask))
					$data_mask1 = '';
				else
					$data_mask1 = ' pattern="'.$data_mask.'" ';
				

				if (($type) == 'texto'){ 
					$type = 'text';
					$v1 = ' size ="'.$size.'"' ;
					$v2 = ' maxlength  ="'.$maxlength.'"' ;
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
				echo $titulo1;
  				
				if ($type == 'password'){
					$valor = base64_decode(trim($datos[$variable]));
				}
				else{
					$valor = trim($datos[$variable]);
				}
			
			  if ($div1 == 'div'){
				//    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
					echo '<label id="'.'l'.$variable.'"  style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo.'</label>';
					echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
  				}
  	 
				echo	 $td.'<input type="'.$type.'" 
						   name="'.$variable.'" 
						   id="'.$variable.'"'. 
						   $required.'
						   class="form-control" autocomplete="off"
						   placeholder="'.$placeholder.'" 
						   '.$v1.'="'.$size.'" 
						   '.$v2.'="'.$maxlength.'"'.  
						   $required.'
						   value="'. str_replace('"', '&quot;',    $valor).'"'.$data_mask1.' />'.$td1;
			  
			     if ($div1 == 'div'){
					 echo '</div>';
				 }		 
												   
						   
				if ($salto == '/'){
   						echo '</tr><tr>';
 				}
 					return true;
				}	
//////////////////////////////////
 	/*   CASILLERO DE TEXTO
		---------------------------------------------------------------------*/
function textM($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$data_mask,$salto)
{

$titulo = utf8_encode(($titulo));  
 			
				if ($required=='required')
					$required ='required="required" '; 
				else	
					$required =''; 

				if ($readonly=='readonly')
					$readonly = 'readonly="readonly" '; 
				else	
					$readonly =''; 
			
				if ($type=='number'){
					$v1 = 'min';
					$v2 = 'max';
				}
				else{
					$v1 = 'size';
					$v2 = 'maxlength';
				}
				if (($type) == 'texto'){ 
					$type = 'text';
					$v1 = ' size ="'.$size.'"' ;
					$v2 = ' maxlength  ="'.$maxlength.'"' ;
				 }
								
				
				if (empty($data_mask))
					$data_mask1 = '';
				else
					$data_mask1 = ' pattern="'.$data_mask.'" ';
				
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
  				
				if ($type == 'password'){
					$valor = base64_decode(trim($datos[$variable]));
				}
				else{
					$valor = trim($datos[$variable]);
				}
				
				$placeholder = 'Ingreso de datos';
				
				echo	 $td.'<input type="'.$type.'" 
						   name="'.$variable.'" 
						   id="'.$variable.'"'. 
						   $required.'
						   class="form-control" 
						   placeholder="'.$placeholder.'" 
						   '.$v1.'="'.$size.'" 
						   '.$v2.'="'.$maxlength.'"'.  
						   $required.'
						   value="'. str_replace('"', '&quot;',    $valor).'"'.$data_mask1.' />'.$td1;
				 
				if ($salto == '/'){
					echo '</tr><tr>';
				} 
 					return true;
				}	
	 
 
//---------------
 function editor_yellow($titulo_aa,$variable,$rows,$cols,$maxlength,$datos,$required,$readonly,$salto)
		{
		    
		    $titulo_aa =  ($titulo_aa);
		    
		    $placeholder ='';
		    
		    if ($required=='required')
		        $required ='required="required" ';
		        else
		            $required ='';
		            
		            if ($readonly=='readonly')
		                $readonly = 'readonly="readonly" ';
		                else
		                    $readonly ='';
		                    
		                    
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
		                        
		                        if (empty($titulo_aa)){
		                            $titulo1 = '';
		                            $td = '';
		                            $td1 = '';
		                        }
		                        else{
		                            $titulo1 ='<td align="right">'.$titulo_aa.'</td>';
		                            $td = '<td align="left">';
		                            $td1 = '</td>';
		                        }
		                    }
		                    echo $titulo1;
		                    
		                    if ($div1 == 'div'){
		                        //    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
		                        echo '<label style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo_aa.'</label>';
		                        echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
		                    }
		                    
		                    echo $td.'<textarea name="'.$variable.'"
			  		class="auto form-control" style="background-color:#FFFE97"
			  		cols="'.$cols.'"
					rows="'.$rows.'"
					maxlength="'.$maxlength.'" '.$readonly.$required.' id="'.$variable.'" placeholder="'.$placeholder.'">'.
					str_replace('"', '&quot;', ( (trim($datos[$variable])))).'</textarea>'.$td1;
					
					
					if ($div1 == 'div'){
					    echo '</div>';
					}
					
					
					if ($salto == '/'){
					    echo '</tr><tr>';
					}
					return true;
		}		
		
	/*   CASILLERO DE editor de texto   
		---------------------------------------------------------------------*/
 function editor($titulo_aa,$variable,$rows,$cols,$maxlength,$datos,$required,$readonly,$salto)
		{
            
		    $titulo_aa =  ($titulo_aa); 

  			$placeholder ='';

            //disabled="disabled"
			
				if ($required=='required'){
					$required ='required="required" '; 
				}	else	{
					$required =''; 
                }

				if ($readonly=='readonly'){
					$readonly = 'disabled="disabled" '; 
                }
				else	{
					$readonly =''; 
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
		
				if (empty($titulo_aa)){
					$titulo1 = '';
				    $td = '';
				    $td1 = '';
				 }
				 else{
				   $titulo1 ='<td align="right">'.$titulo_aa.'</td>';
				   $td = '<td align="left">';
				   $td1 = '</td>';
				 }
			}
				 echo $titulo1;

		 if ($div1 == 'div'){
		//    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
			echo '<label style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo_aa.'</label>';
			echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
		  }
							
			  echo $td.'<textarea name="'.$variable.'" 
			  		class="auto form-control"
			  		cols="'.$cols.'" 
					rows="'.$rows.'" 
					maxlength="'.$maxlength.'" '.$readonly.$required.' id="'.$variable.'" placeholder="'.$placeholder.'">'.
					str_replace('"', '&quot;', ( (trim($datos[$variable])))).'</textarea>'.$td1;
			
			
			  if ($div1 == 'div'){
				 echo '</div>';
			 }		 
				
				
			if ($salto == '/'){
					echo '</tr><tr>';
				} 		
  					return true;
		}		
//------------
		function editor_wysiwyg($titulo_aa,$variable,$rows,$cols,$maxlength,$datos,$required,$readonly,$salto)
		{
		    
		    
		    
		    $titulo_aa =  ($titulo_aa);
		    
		    $placeholder ='';
		    
		    if ($required=='required')
		        $required ='required="required" ';
		        else
		            $required ='';
		            
		            if ($readonly=='readonly')
		                $readonly = 'readonly="readonly" ';
		                else
		                    $readonly ='';
		                    
		                    
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
		                        
		                        if (empty($titulo_aa)){
		                            $titulo1 = '';
		                            $td = '';
		                            $td1 = '';
		                        }
		                        else{
		                            $titulo1 ='<td align="right">'.$titulo_aa.'</td>';
		                            $td = '<td align="left">';
		                            $td1 = '</td>';
		                        }
		                    }
		                    echo $titulo1;
		                    
		                    if ($div1 == 'div'){
		                        //    echo '<div style="padding-top: 7px;"  class="col-md-'.$div2.'">'.$titulo.'</div>';
		                        echo '<label style="padding-top: 5px;text-align: right;" class="col-md-'.$div2.'">'.$titulo_aa.'</label>';
		                        echo '<div style="padding-top: 5px;"  class="col-md-'.$div3.'">';
		                    }
		                    
		                    echo $td.'<textarea name="'.$variable.'"
			  		class="form-control wysiwyg"
			  		cols="'.$cols.'"
					rows="'.$rows.'"
					maxlength="'.$maxlength.'" '.$readonly.$required.' id="'.$variable.'" placeholder="'.$placeholder.'">'.
					str_replace('"', '&quot;', ( (trim($datos[$variable])))).'</textarea>'.$td1;
					
					
					if ($div1 == 'div'){
					    echo '</div>';
					}
					
					
					if ($salto == '/'){
					    echo '</tr><tr>';
					}
					return true;
		}		
// texto oculto
function codigo_oculto($variable)
{
  echo ' <input name="'.$variable.'" type="hidden" id="'.$variable.'"> ';	
  return true;
}	
// texto oculto
function texto_oculto($variable,$datos)
{
 echo '<input name="'.$variable.'" type="hidden" id="'.$variable.'" value="'.trim($datos[$variable]).'">';
}
// texto oculto
function texto_filtro($variable,$valor)
{
 echo '<input name="'.$variable.'" type="hidden" id="'.$variable.'" value="'.trim($valor).'">';
}
 
//  CASILLERhO DE TEXTO
 function check($titulo,$variable,$datos,$salto_linea){
    
 $titulo = utf8_encode(($titulo));  
 
 if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
 }
 else{
	$titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
	$td = '<td align="left" valign="middle">';
	$td1 = '</td>';
 }
 echo $titulo1;
 
 echo $td.'<input name="'.$variable.'" type="checkbox" id="'.$variable.'" >'.$td1;

 
		  
  if($salto_linea=='/'){
    echo '</tr><tr>';
  }
   
  if($salto_linea=='-'){
   	echo '</tr>';
  } 
 
  return true;
}	
//  CASILLERO DE TEXTO_web

 function text_web($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
	 
  $titulo = utf8_encode(($titulo)); 
	 
  $placeholder = '';			
  if ($required=='required'){
   $required =' required="required" '; 
   $placeholder = 'requerido';
  }else	{
   $required =''; 
   $placeholder = '';
 }
 if ($readonly=='readonly')
  $readonly = ' readonly="readonly"  '; 
 else	
  $readonly =''; 
 // -------------------------			
 $v4 ='';
 $v1 = '' ;
 $v2 = '' ;
   
 if ($type=='number'){
  $v1 = ' step="0.01" ';
  $v2 = '';
  $v4 = ' style="text-align:right" ';
 }
 if (($type) == 'texto'){ 
    $type = 'text';
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
 if (($type) == 'tel'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
  if (($type) == 'url'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
  if (($type) == 'email'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 if (($type) == 'date'){ 
   $v1 = ' size ="'.$size.'" ' ;
   $v2 = ' maxlength  ="'.$maxlength.'" ' ;
 }		
 		
 if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
 }
 else{
	$titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
	$td = '<td align="left" valign="middle">';
	$td1 = '</td>';
 }
 echo $titulo1;

 /*
	if ($type == 'password'){
					$valor = base64_decode(trim($datos[$variable]));
	}
	else{
					$valor = trim($datos[$variable]);
	}
		*/		

 echo $td.'<input type="'.$type.'" name="'.$variable.'" id="'.$variable.
 		  '"'.$required.' class="css-input"  placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
		  ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
		  
  if($salto_linea=='/'){
    echo '</tr><tr>';
  }
   
  if($salto_linea=='-'){
   	echo '</tr>';
  } 
 
  return true;
}	
 //  CASILLERO DE TEXTO
 function textWEB($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$salto_linea){
  
 // $titulo = utf8_encode(($titulo)); 
	 
  $placeholder = '';			
  if ($required=='required'){
   $required =' required="required" '; 
   $placeholder = 'requerido';
  }else	{
   $required =''; 
   $placeholder = '';
 }
 if ($readonly=='readonly')
  $readonly = ' readonly="readonly"  '; 
 else	
  $readonly =''; 
 // -------------------------			
 $v4 ='';
 $v1 = '' ;
 $v2 = '' ;
   
 if ($type=='number'){
  $v1 = ' step="0.01" ';
  $v2 = '';
  $v4 = ' style="text-align:right" ';
 }
 if (($type) == 'texto'){ 
    $type = 'text';
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
 if (($type) == 'tel'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 
  if (($type) == 'url'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
  if (($type) == 'email'){ 
	$v1 = ' size ="'.$size.'"' ;
	$v2 = ' maxlength  ="'.$maxlength.'"' ;
 }
 if (($type) == 'date'){ 
   $v1 = ' size ="'.$size.'" ' ;
   $v2 = ' maxlength  ="'.$maxlength.'" ' ;
 }		
 		
 if (empty($titulo)){
	$titulo1 = '';
	$td = '';
	$td1 = '';
 }
 else{
	$titulo1 ='<td align="right" valign="middle">'.$titulo.'</td>';
	$td = '<td align="left" valign="middle">';
	$td1 = '</td>';
 }
 echo $titulo1;

 
  $placeholder = utf8_encode('Ingrese la informaci�n aqu�'); 
 	
  /*
	if ($type == 'password'){
					$valor = base64_decode(trim($datos[$variable]));
	}
	else{
					$valor = trim($datos[$variable]);
	}
		*/		

 echo $td.'<input type="'.$type.'" name="'.$variable.'" id="'.$variable.
 		  '"'.$required.' class="form-control" placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$readonly.
		  ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/>'.$td1;
		  
  if($salto_linea=='/'){
    echo '</tr><tr>';
  }
   
  if($salto_linea=='-'){
   	echo '</tr>';
  } 
 
  return true;
}	

//  CASILLERO DE TEXTO
 function ColEtiqueta($etiqueta,$valor,$div2,$negrita){
    
    if ($negrita == 'B'){
        $s1= '<b>';
        $s2= '</b>';
    }else{
        $s1= '';
        $s2= '';        
    }
   //div-2-2
   $div = explode("-", $div2);
   
   if ($div['1'] == '0'){
       echo '<label class="col-md-'.$div['2'].' control-label">'.$s1.$etiqueta.$s2.'</label>';

   }else
   {
       echo '<label class="col-md-'.$div['1'].' control-label">'.$etiqueta.'</label><label class="col-md-'.$div['2'].' control-label">'.$s1.$valor.$s2.'</label>';
    
   }
 
   
 }
//---------------------------------------------
 function textLong($titulo,$type,$variable,$size,$maxlength,$datos,$required,$readonly,$evento,$salto)
 {
     
     $placeholder = $titulo;
     
     $titulo = utf8_encode(($titulo));
     
     if ($required=='required'){
         $required =' required="required" ';
      }else	{
         $required ='';
      }
     
     if ($readonly=='readonly')
         $readonly = ' readonly="readonly"  ';
         else
             $readonly ='';
             
             $v4 ='';
             if ($type=='number'){
                 $v1 = ' step="0.01" ';
                 $v2 = '';
                 $v4 = ' style="text-align:right" ';
             }
             if (($type) == 'texto'){
                 $type = 'text';
                 $v1 = ' size ="'.$size.'"' ;
                 $v2 = ' maxlength  ="'.$maxlength.'"' ;
             }
             if ($type=='date'){
                 $v1 = ' size ="'.$size.'" ' ;
                 $v2 = ' maxlength  ="'.$maxlength.'" ' ;
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
                 if ( $div2 > 0 ){
                  echo '<label id="'.'l'.$variable.'"  style="padding-top: 20px;text-align: right;"  class="col-md-'.$div2.'">'.$titulo.'</label>';
                 }
                  echo '<div id="'.'d'.$variable.'" style="padding-top: 5px;"  class="col-md-'.$div3.'">';
             }
             
             
             echo $titulo1;
             $placeholder= '';
             
             echo $td.'<input type="'.$type.'" name="'.$variable.'" id="'.$variable.'"'.$required.' 
             class="form-control input-lg"   style="background-color:#ff0945;color:#ffffff"
             placeholder="'.$placeholder.'"'.$v1.$v2.$v4.$evento.' '.$readonly.' 
             value="'. str_replace('"', '&quot;',    (trim($datos[$variable]))).'"'.' />'.$td1;
             
             if ($div1 == 'div'){
                 echo '</div>';
             }
             
           
             return true;
 }	
 //----------------------------------------------------
 //  CASILLERO DE TEXTO
 function input_filtro( $type,$variable,$datos,$placeholder){
     
     // $titulo = utf8_encode(($titulo));
     
            $placeholder = utf8_encode($placeholder);
            
            $required    = '';
            
             
             echo  '<input type="'.$type.'" 
                           name="'.$variable.'"    style="background-color:#FFFE97"
                           id="'.$variable.'"'.$required.' 
                           class="form-control" 
                           placeholder="'.$placeholder.'"'. 
             ' value="'. str_replace('"', '&quot;',(trim($datos[$variable]))).'"'.'/><br>    ' ;
             
             
             return true;
 }
}
?>