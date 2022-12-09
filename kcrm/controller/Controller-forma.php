<?php 
     session_start( );   
   
  
    class tareaProceso{
 
  
      private $obj;
      private $bd;
      private $set;
                
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function tareaProceso( $obj, $set, $bd){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	$obj;
                
                $this->set     = 	$set;
                   
                $this->bd	   =	$bd ;
        
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
        
      }
 //---------------------------------------------------------------------  
      function Formulario( $idproceso,$idtarea){
          
          
          $datos = array();
            
          
          $this->set->div_label(12,' Datos Solicita');
          
          
          $this->obj->text->textautocomplete('<b>SOLICITA</b>',"texto",'razon',40,45,$datos,'','','div-2-4');
          
          
          $this->obj->text->textautocomplete('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'',' ','div-2-4') ;
          
         
          
          $this->set->div_label(12,' Datos Complementarios');
          
          
          $sqlDepa = "SELECT acceso,variable,tipo,enlace,tabla,lista,orden
					    FROM flow.view_proceso_form
						WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($idtarea,true). "  and
						      idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true). "
					  ORDER BY  orden";
          
          $stmt_depa		=		$this->bd->ejecutar($sqlDepa);
          $tipo_c 			=		 $this->bd->retorna_tipo();
          
          $i = 1;
          
          while ($x=$this->bd->obtener_fila($stmt_depa)){
              
              $variable       = utf8_decode(trim($x['variable']));
              $tipo			  = trim($x['tipo']);
              
            //  $idproceso_var  =  $x['idproceso_var'];
            
              $tabla  		  =  $x['tabla'];
              $objeto		  =  'col_'.$x['orden'];
              $lista	  	  =  $x['lista'];
              
              $acceso			    =  $x['acceso'];
              //----------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'listaDB'){
                  $resultado = $this->combolista($tabla);
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'disabled';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->list->listadb($resultado,$tipo_c,$variable,$objeto,$datos,$required,$disabled,'div-2-4');
                  }
                  
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'caracter'){
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'readonly';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->text->text($variable,"texto",$objeto,170,170,$datos,$required ,$disabled,'div-2-4') ;
                  }
                  
              }
              //------------------------------------------------------------------------------------------------------------------------
              
              if ($tipo == 'editor'){
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'readonly';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                       $this->obj->text->editor($variable,$objeto,3,250,300,$datos,$required,'','div-2-4') ;
                  }
                  
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'lista'){
                  $MATRIZ = $this->lista($lista);
                  
                  $evento = '';
                  
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'disabled';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required, $disabled,$evento,'div-2-4');
                  }
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'email'){
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'readonly';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->text->text($variable,"email",$objeto,170,170,$datos, $required, $disabled ,'div-2-4') ;
                  }
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'numerico'){
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'readonly';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->text->text($variable,"number",$objeto,70,70,$datos,'required','','div-2-4') ;
                  }
              }
              if ($tipo == 'date'){
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'readonly';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  $div = 'div-2-4';
                  
                  if ($visualiza == 1){
                      
                      //$this->obj->text->text($variable,"date",$objeto,70,70,$datos,'required','','div-2-4') ;
                      
                      $this->obj->text->text_dia($variable,"5",$objeto,70,70,$datos,'required','',$div) ;
                      
                  }
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'condicion'){
                  $MATRIZ = array(
                      'SI'    => 'SI',
                      'NO'    => 'NO'
                  );
                  $visualiza = 1;
                  if($acceso== 1) {
                      $required = '';
                      $disabled = 'disabled';
                  } else if($acceso== 2) {
                      $required = 'required';
                      $disabled = '';
                  } else {
                      $visualiza =0;
                  }
                  
                  if ($visualiza == 1){
                      $this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required ,$disabled  , $evento,'div-2-4');
                  }
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'vinculo'){
  
                  
                  if ( !empty($acceso))  {
                       
                      $evento = ' onClick="enlance_externo('."'".$lista."'".')"';
                     
                      $enlace = '<a href="#" '.$evento.'>'.$variable.'</a>';
                      
                      echo '<div  style="padding-top: 5px;text-align: right;" class="col-md-2"> '.
                           '<img src="../../kimages/wurl.png" /> ' .
                           '</div>';
                      
                      echo '<div style="padding-top: 5px;" class="col-md-4">'.$enlace.'</div>';
                  }
                
                  
                  
              }
              
              $i++;
          }
          $valida = $i-1;
          
          if($valida%2<>0)
          {
              echo '<div   class="col-md-6"></div>';
          }
     		     
          
          return $i - 1;
   }
 //----------------------------------------------
   function Formulario_solicita(  ){
       
 
       $datos   = array();
       
       $x       = $this->bd->query_array('par_usuario','completo,cedula,email,movil', 'email='.$this->bd->sqlvalue_inyeccion(  $this->sesion ,true));
       
       $len     = strlen(trim($x['cedula']));

       $div     = 'div-2-10';
       
       if ( $len > 9){
           $datos['idprov']     = trim($x['cedula']);
           $datos['razon']      = trim($x['completo']);
           $datos['correo']     = trim($x['email']);
           $datos['telefono']   = trim($x['movil']);
       }
     
        
      $solicita = '<a href="#" onclick="LimpiarCliente()" title="Limpiar Informacion"><b>Solicita</b><img src="../../kimages/cdel.png" align="absmiddle"></a>';

      $email    = '<a href="#" onclick="ActualizaCliente()" title="Actualizar Cliente">Email <img src="../../kimages/okk.png" align="absmiddle"></a>';
       
       
       $this->obj->text->textautocomplete14($solicita,"texto",'razon',40,45,$datos,'','',$div);
       
       $this->obj->text->textautocomplete14('Identificacion','texto','idprov',13,13,$datos ,'',' ',$div) ;
       
       $this->obj->text->text($email,"email",'correo',20,20,$datos,'required','',$div) ;
       
       $this->obj->text->text('Telefono','texto','telefono',10,10, $datos ,'required','',$div) ;
       
       
   }
   ///-------------Formulario_solicita_tramite
   function Formulario_solicita_tramite( $idcaso  ){
       
       
       $qquery = array(
           array( campo => 'idcaso',   valor => $idcaso,  filtro => 'S',   visor => 'S'),
           array( campo => 'caso',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'sesion_siguiente',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'autorizado',   valor => '-',  filtro => 'N',   visor => 'S') ,
           array( campo => 'secuencia',   valor => '-',  filtro => 'N',   visor => 'S') ,
           array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S')
       );
       
       $datos               = $this->bd->JqueryArrayVisorDato('flow.wk_proceso_caso',$qquery );   
       $_SESSION['idcaso']  = $idcaso;
       
        
   
        
       $x = $this->bd->query_array('par_ciu','razon,idprov,direccion, telefono ,correo', 
           'idprov='.$this->bd->sqlvalue_inyeccion(  trim($datos['idprov']) ,true));
       
       
       $len = strlen(trim($x['idprov']));
       
       if ( $len > 9){
           $datos['razon'] = trim($x['razon']);
           $datos['correo'] = trim($x['correo']);
           $datos['telefono'] = trim($x['telefono']);
       }
       
       
       $this->obj->text->text_blue('',"texto",'secuencia',40,45,$datos,'','readonly','div-2-10') ;
       
       $div = 'div-2-4';
       
       $solicita= '<b>Solicita</b>';
       
       $this->obj->text->textautocomplete14($solicita,"texto",'razon',40,45,$datos,'','readonly',$div);
       
       
       $div = 'div-2-4';
       $this->obj->text->textautocomplete14('<b>Identificacion</b>','texto','idprov',13,13,$datos ,'','readonly',$div) ;
       
       
       $email = 'Email';
       
       $this->obj->text->text($email,"email",'correo',20,20,$datos,'required','readonly',$div) ;
       
       $this->obj->text->text('Telefono','texto','telefono',10,10, $datos ,'required','readonly',$div) ;
       
       
   }
   //------------
   function Formulario6( $idcaso,$idproceso,$idtarea){
       
 
       $sql_det1 = 'SELECT etiqueta
                    FROM flow.view_proceso_form
                    WHERE idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea,true). "  and
                            idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true). 
                    ' GROUP BY etiqueta ORDER BY etiqueta ASC' ;


        $stmt1 = $this->bd->ejecutar($sql_det1);


        $i = 0;
        
        while ($xx=$this->bd->obtener_fila($stmt1)){


                $etiqueta  = trim($xx['etiqueta']) ;

                $this->set->div_label(12, '<b>'. $etiqueta.'</b>');

                $contador =  $this->crea_formulario( $etiqueta,  $idcaso,$idproceso,$idtarea);

                $i = $i + $contador ;


        }

   }
 //-------------------------------------
   //------------
   function Formulario6_id( $idcaso,$idproceso,$idtarea){
       
       
       $sql_det1 = 'SELECT etiqueta
                    FROM flow.view_proceso_form
                    WHERE idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea,true). "  and
                            idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true).
                            ' GROUP BY etiqueta ORDER BY etiqueta ASC' ;
       
       
       $stmt1 = $this->bd->ejecutar($sql_det1);
       
       
       $i = 0;
       
       while ($xx=$this->bd->obtener_fila($stmt1)){
           
           
           $etiqueta  = trim($xx['etiqueta']) ;
           
           $this->set->div_label(12, '<b>'. $etiqueta.'</b>');
           
           $contador =  $this->crea_formulario( $etiqueta,  $idcaso,$idproceso,$idtarea);
           
           $i = $i + $contador ;
           
           
       }
       
   }
 //----------------------------------------------
 function crea_formulario(  $etiqueta,  $idcaso,$idproceso,$idtarea  ){
       

       $datos = array();
     
 
       $sqlDepa = "SELECT acceso,variable,tipo,enlace,tabla,lista,orden,enlace_url,columna
					    FROM flow.view_proceso_form
						WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($idtarea,true). "  and
						      idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true). " and
                              etiqueta = ".$this->bd->sqlvalue_inyeccion($etiqueta,true). "  
					  ORDER BY  orden";
       
       $stmt_depa		=	 	 $this->bd->ejecutar($sqlDepa);
       $tipo_c 			=		 $this->bd->retorna_tipo();
       
       $i = 1;
       
       while ($x=$this->bd->obtener_fila($stmt_depa)){

       
            if (   trim($x['columna']) == '1'  ){
                    $div = 'div-2-10';
                    $div1 = 'col-md-6';
                    $columna = 1;
            }else {
                    $div = 'div-2-4';
                    $div1 = 'col-md-3';
                    $columna = 2;
            }

           $variable       =  trim($x['variable']);
           $tipo_dato	   =  trim($x['tipo']);
           $tabla  		   =  $x['tabla'];
           $objeto		   =  'col_'.$x['orden'];
           $lista	  	   =  trim($x['lista']);
           $url            =  trim($x['enlace_url']);
           $acceso		   =  trim($x['acceso']);

           $fecha          = date('Y-m-d') ;

           // lista de base

           if ($tipo_dato == 'listaDB'){

               $resultado = $this->combolista($tabla);

               $visualiza = 1;

               $this->_listaDB($resultado,$acceso,$tipo_c,$variable,$objeto, $visualiza,$div);
         
            }
          
           // caracter
           if ($tipo_dato == 'caracter'){

               $visualiza = 1;
 
               $this->_caracter( $variable , $visualiza,$acceso,"texto",$objeto,$div,'-');
 
           }

              // hora
              if ($tipo_dato == 'time'){

                $visualiza = 1;
  
                $this->_caracter( $variable , $visualiza,$acceso,"time",$objeto,$div,'06:00');
  
            }

           
           //------------------------------------------------------------------------------------------------------------------------
           
           if ($tipo_dato == 'editor'){

               $visualiza = 1;
               
               $this->_editor($variable,$visualiza,$acceso,"editor",$objeto,$div,'-');
                

             
           }
           //------------------------------------------------------------------------------------------------------------------------
           if ($tipo_dato == 'lista'){

               $MATRIZ = $this->lista($lista);
               $evento = '';
               
               $visualiza = 1;
               if($acceso== '1') {
                   $required = '';
                   $disabled = 'disabled';
               } else if($acceso== '2') {
                   $required = 'required';
                   $disabled = '';
               } else {
                   $visualiza =0;
               }
               
               if ($visualiza == 1){
                   $this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required, $disabled,$evento,$div);
               }
           }

           //  check 

           if ($tipo_dato == 'check'){

            
            $visualiza = 1;

            if($acceso== '1') {
                $required = '';
                $disabled = 'disabled';
            } else if($acceso== '2') {
                $required = 'required';
                $disabled = '';
            } else {
                $visualiza =0;
            }
            
            if ($visualiza == 1){
                
                if ( $columna == 1){

                    echo '<div style="padding-top: 12px;text-align: right;" class="col-md-2">'. $variable.'</div>
                    <div  style="padding-top:12px;" class="col-md-10"><input type="checkbox"  value="1" id="'.$objeto.'" name="'.$objeto.'" '. $disabled.'   > </div>';

                }else    {
  
                    echo '<div style="padding-top: 12px;text-align: right;" class="col-md-2">'. $variable.'</div>
                    <div  style="padding-top:12px;padding-right: 25px" class="col-md-4"><input type="checkbox" value="1" id="'.$objeto.'" name="'.$objeto.'" '. $disabled.'   > </div>';

                }               
            }

        }

         
           //------------------------------------------------------------------------------------------------------------------------
           if ($tipo_dato == 'email'){
               
              $visualiza = 1;

               $this->_caracter( $variable , $visualiza,$acceso,"email",$objeto,$div,'@');
           }

           //------------------------------------------------------------------------------------------------------------------------
           if ($tipo_dato == 'numerico'){

               $visualiza = 1;

               $this->_caracter( $variable , $visualiza,$acceso,"number",$objeto,$div,'0');
         
 
           }


           if ($tipo_dato == 'date'){

               $visualiza = 1;

               $fecha = date('Y-m-d');

               $this->_caracter( $variable , $visualiza,$acceso,"date",$objeto,$div,$fecha );
                    
              
           }
           //------------------------------------------------------------------------------------------------------------------------
           if ($tipo_dato == 'condicion'){
               $MATRIZ = array(
                   'SI'    => 'SI',
                   'NO'    => 'NO'
               );
               $visualiza = 1;
               
               if($acceso== '1') {
                   $required = '';
                   $disabled = 'disabled';
               } else if($acceso== '2') {
                   $required = 'required';
                   $disabled = '';
               } else {
                   $visualiza =0;
               }
               
               if ($visualiza == 1){
                   $this->obj->list->listae( $variable,$MATRIZ, $objeto, $datos,$required ,$disabled  , $evento,$div);
               }
           }
           //------------------------------------------------------------------------------------------------------------------------
           if ($tipo_dato == 'vinculo'){
               
                
               if($acceso== '1') {
                    $disabled = 'disabled';
                    $accion = "'visor'";
               } else  {
                    $disabled = '';
                    $accion = "'update'";
               }
                
               if ( !empty($acceso))  {
                   
                   $evento = ' onClick="enlance_externo('."'".trim( $url )."',".$accion.')"';
           
                   
                   $enlace = '<a href="#"  '.$evento.' class="btn btn-success btn-sm btn-block" '.$disabled.'>'.$variable.'</a>';
                   
                
                    echo '<div style="padding-top: 25px;" align="center" class="'.$div1.'">'.$enlace.'</div>';
               }
               
               
               
           }
           
           $i++;
       }
    
    /*   $valida = $i-1;
       
       if($valida%2<>0)
       {
           echo '<div   class="col-md-6"></div>';
       }
     */
       
      return $i - 1;

 
}   
/*
objeto combo
*/
function _listaDB( $resultado,$acceso,$tipo_c,$variable,$objeto, $visualiza,$div  ){
       
    $datos = array();

    if($acceso== '1') {
        $required = '';
        $disabled = 'disabled';
    } else if($acceso== '2') {
        $required = 'required';
        $disabled = '';
    } else {
        $visualiza =0;
    }
    
    if ($visualiza == 1){
        $this->obj->list->listadb($resultado,$tipo_c,$variable,$objeto,$datos,$required,$disabled,$div);
    }
 
    
}
/*
dibuja casilleros input
*/

function _caracter( $variable, $visualiza,$acceso,$tipo_objeto,$objeto,$div,$valor ){

    $datos = array();
 
    $datos[$objeto] = $valor;

    if($acceso== '1') {
        $required = '';
        $disabled = 'readonly';
    } else if($acceso== '2') {
        $required = 'required';
        $disabled = '';
    } else {
        $visualiza =0;
    }
    
    if ( $tipo_objeto == 'date'){
        if ($visualiza == 1){
            $this->obj->text->text_dia($variable,"30",$objeto,70,70,$datos, $required,$disabled    ,$div) ;
        }
    }
    else {
        if ($visualiza == 1){
            $this->obj->text->text($variable,$tipo_objeto,$objeto,170,170,$datos,$required ,$disabled,$div) ;
        }
    }


  

}  
/*
editor de texto
*/
 
function _editor( $variable,$visualiza,$acceso,$texto,$objeto,$div,$valor) {

     $datos = array();

   //  $visualiza,$acceso,$texto,$objeto,$div,$valor

  // <textarea disabled="disabled"></textarea>



        if($acceso== '1') {
             $required = '';
             $disabled = 'readonly';

        } else if($acceso== '2') {
            $required = 'required';
            $disabled = '';
        } else {
            $visualiza =0;
        }

        if ($visualiza == 1){

            
            $this->obj->text->editor($variable,$objeto,4,450,450,$datos, $required,  $disabled  ,$div) ;

       

        }

}  
 //----------------------------------------------
   function combolista($tabla){
       
       $sqlb = " SELECT    nombre  AS CODIGO, nombre
									  FROM ".$tabla." order by 1";
       
       
       
       $resultado = $this->bd->ejecutar($sqlb);
       
       return $resultado;
       
   }
   //----------------------------------------------
   function lista($lista){
       
       $pieces = explode(",", $lista);
       
       $a = array();
       $b = array();
       
       
       foreach($pieces as $elemento)
       {
           
           $a[] = $elemento;
           $b[] = $elemento;
           
       }
       
       $MATRIZ = array_combine ($a ,  $b);
       
       return $MATRIZ;
       
   }  
  //----------------------------------------------
    function requisitos_tarea($idproceso,$idtarea ){
       
       $this->set->div_label(6,'<h5> Requisitos <h5>');
       
        
 
       $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    requisito  ,
                    requisito_perfil ,
                    tipo ,
                    obligatorio ,
                    sesion,idtarearequi,prioridad,idproceso_requi
      FROM flow.view_unidadprocesorequi
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       $cabecera =  "Requisito,Tipo,Adjunto,Archivo,Cumple";
       
        
       
       $resultado  = $this->bd->ejecutar($sql);
       
       
       $this->obj->table->table_cabecera( $cabecera);
 
       
        while ($x=$this->bd->obtener_fila($resultado)){
           
           $adjunto_valida  = $x['obligatorio'];
           $Perfil          = trim($x['requisito_perfil']);
           $idcodigo        = $x['idproceso_requi'];
           
               
           $adjunto     = 'Perfil de observador';
       
           $fileArchivo = '';
            
           $objeto = 'fileArchivo_'.$idcodigo;
           
           $vinculo = 'vinculo_'.$idcodigo;
           
           $filead      =   ' <a target="_blank" class="btn btn-default btn-sm" download  id="'.$vinculo.'"> <span class="glyphicon glyphicon-download-alt"></span></a> ';
           
           if ($adjunto_valida == 'S') {
               
               if ($Perfil == 'operador')  {
              
                   $adjunto = '<a href="requisitoload.php?id='.$idcodigo.'" 
                                  rel="pop-up" class="btn btn-default btn-sm">
	                              <span class="glyphicon glyphicon-floppy-open"></span></a> ';
                   
               }
                  
                   
               $fileArchivo = '  <input name="'.$objeto.'" type="text" class="form-control" size="25" readonly="readonly" id="'.$objeto.'" placeholder="Archivo">';
               
                 
                 
           }else{
               
               $adjunto = ' ';
            
               $fileArchivo = '';
               
               $filead ='';
           }
         
              
           $objeto = 'cumple_'.$idcodigo;
           
           $objeto1 = 'ver_'.$idcodigo;
           
           $objeto2 = 'arc_'.$idcodigo;
           
           echo "<tr>";
          
           echo '<td with="25%">'.$x['requisito'].'</td>';
           echo '<td with="10%">'.$x['tipo'].'</td>';
           echo '<td with="25%">'.$adjunto.$filead.'</td>';
           echo '<td with="20%">'.$fileArchivo.' </td>';
           echo '<td with="20%">';
           
           if ($Perfil == 'operador')  {
               echo '<input type="checkbox" name="'.$objeto.'"  id="'.$objeto.'">' ;
           }
          else  {
               echo '-' ;
           }
           
            
           echo '</td> 
                    <input name="'.$objeto1.'" type="hidden" id="'.$objeto1.'" value="'.$adjunto_valida.'">
                    <input name="'.$objeto2.'" type="hidden" id="'.$objeto2.'" value="-">';
           echo "</tr>";
           
       }
       
       echo "</tbody></table>";
       
 
         
    } 
///------------------------------------------------------------------------
//----------------------------------------------
    function documentos_tarea($idproceso,$idtarea ){
        
        $this->set->div_label(6,'<h5> Documentos <h5>');
        
  
            $sql = 'SELECT  idproceso ,
                        idtarea  ,
                        documento  ,
                        perfil_documento ,
                        tipo ,
                        estado ,
                        sesion,idtareadoc,idproceso_docu,
                        editor_doc,id_docmodelo
        FROM flow.view_unidadProcesodocu
        where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
                idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Documento,Tipo,Perfil,Editor";

        // cabecera de la tabla
        
        $this->obj->table->table_cabecera( $cabecera);
 
        
        while ($x=$this->bd->obtener_fila($resultado)){
            
             $Perfil = trim($x['perfil_documento']);
              
             $codigo       = $x['idproceso_docu'];
             $editor_doc   = trim($x['editor_doc']);
             $id_docmodelo = $x['id_docmodelo'];
             
          
               
                
                if ($Perfil == 'operador')  {
                    
                            if (  $editor_doc == 'S')  {
                                    $evento = ' onClick="formato_doc('.$idproceso.",'".trim($x['tipo'])."',".$codigo.','.$idtarea.');" ';
                                    
                                    $evento1 = ' onClick="formato_doc_visor('.$idproceso.",'".trim($x['tipo'])."',".$codigo.','.$idtarea.');" ';
                                    
                                    $adjunto = '<button type="button" '.$evento.'  class="btn btn-default" id="CargaEditor_'.$codigo.'">
                                                    <span class="glyphicon glyphicon-edit"></span> </button>
                                                <button type="button" '.$evento1.'  class="btn btn-default" id="CargaEditorP_'.$codigo.'">
                                                    <span class="glyphicon glyphicon-download-alt"></span> </button> ';
                            }else  {

                                
                                $evento = ' onClick="reporte_doc_visor('.$idproceso.",'".trim($x['tipo'])."',".$codigo.','.$id_docmodelo.');" ';
                       
                       
                                $adjunto = '<button type="button"  '.$evento.' class="btn btn-default" id="CargaREditor_'.$codigo.'">
                                             <span class="glyphicon glyphicon-print"></span>  </button> ';


                            }

                   }else{
                       
                       $evento = ' onClick="formato_doc_visor('.$idproceso.",'".trim($x['tipo'])."',".$codigo.','.$idtarea.');" ';
                       
                       
                       $adjunto = '<button type="button" data-toggle="modal" '.$evento.' class="btn btn-default" id="CargaEditor_'.$codigo.'">
                                    <span class="glyphicon glyphicon-download-alt"></span>  </button> ';
                  }
            
 
                
            echo "<tr>";
            
            echo '<td with="40%">'.$x['documento'].'</td>';
            echo '<td with="20%">'.$x['tipo'].'</td>';
            echo '<td with="20%">'.$x['perfil_documento'].'</td>';
            echo '<td with="20%">'.$adjunto.'</td><input name="iddoc_'.$codigo.'" type="hidden" id="iddoc_'.$codigo.'">';
          
            
        }
        
        echo "</tbody></table>";
        
     
        
    } 
 //------------------------------
    function detalle_tarea($idproceso,$idtarea ){
        
        $datos = array();
        

        $this->obj->text->text_blue('',"texto",'secuencia',40,45,$datos,'','readonly','div-0-12') ;
           
        $this->obj->text->editor('','caso',4,45,300,$datos,'required','','div-0-12') ;
        
        $this->obj->text->text('',"number",'idcaso',40,45,$datos,'','readonly','div-0-12') ;
 
        
    }
    
    //-------------------------------
    //------------------------------
    function detalle_tarea_casos($idcaso,$idproceso,$idtarea ){
        
        $datos = array();
        
        $datos['idcaso'] = $idcaso;

        $this->obj->text->text('',"number",'idcaso',40,45,$datos,'','readonly','div-0-12') ;
 
         
        
    }
    //-------------------------------------------------------------------------

    //-----------------------------------------------------------------------
    function siguiente_tarea($idproceso,$idtarea ){
        
        $datos      = array();

        $tipo 		= $this->bd->retorna_tipo();
        
        $unidad_actual                 = $this->bd->query_array('par_usuario',
                                         '*',  
                                         "email = ".$this->bd->sqlvalue_inyeccion( $this->sesion  ,true) );
   
        $id_departamento_unidad        = $unidad_actual['id_departamento'] ;


        //---------------------------------------------------------------------------
        $tarea_siguiente               = $this->bd->query_array('flow.wk_procesoflujo', 
                                         '*', 
                                         'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and 
                                          idtarea='.$this->bd->sqlvalue_inyeccion($idtarea +  1,true)   );
       //----------------------------------------------------------------------------
       
       $ATarea_flujo = $this->bd->query_array('flow.wk_proceso_formulario_user',
            '*',
            'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
             idtarea='.$this->bd->sqlvalue_inyeccion($idtarea +  1,true) .' and
             perfil='.$this->bd->sqlvalue_inyeccion('operador',true)
            );
        $unidad  = $ATarea_flujo['unidad'] ;

        //----------------------------------------------------------------------------
      
        //-------------------------------//-------------------------------//-------------------------------
        //-------------------------------//--------$tarea_siguiente['condicion'] 
        echo '<div id="mensaje_siguiente">
                 <span style="font-size: 14px;color: #AA0508">
                 <img src="../../kimages/mano.png"  align="absmiddle"/> SIGUIENTE TAREA<br>
                <strong>'.strtoupper($tarea_siguiente['tarea']).'</strong><br> <br> '.'</span></div>' ;
        
        
        if ( $unidad == 0){

            $sql = "SELECT   email as codigo,completo as nombre
                               FROM  par_usuario
                   where  tarea = 'S' and 
                          id_departamento =".$this->bd->sqlvalue_inyeccion( $id_departamento_unidad ,true) .' 
                          order by completo'  ;
            
        }elseif ( $unidad == 1){
      
            $sql = "SELECT   email as codigo,completo as nombre
                        FROM  par_usuario
                       where responsable =".$this->bd->sqlvalue_inyeccion( 'S' ,true)   ;
             
        }else {
            
            $sql = "SELECT   email as codigo,completo as nombre
                        FROM  par_usuario
                       where id_departamento =".$this->bd->sqlvalue_inyeccion( $unidad ,true)   ;
            
        }
        
        $resultado                   = $this->bd->ejecutar($sql);
        $evento                      = '';
        $datos['sesion_siguiente']   = trim($this->sesion);

        $this->obj->list->listadbe($resultado,$tipo,'Asignar a','sesion_siguiente',$datos,'required','',$evento,'div-0-12');
        
         
        
    } 
 //-------------------------------------------------------------------------------
    function condicion_tarea($idproceso,$idtarea,$siguiente,$anterior,$idcaso){
 
        
        $datos      = array();
        $tipo 		= $this->bd->retorna_tipo();
        
        $sqlb = "SELECT    idtarea  AS codigo, '[ 1. SI ] TAREA: ' || tarea  AS NOMBRE
									  FROM flow.wk_procesoflujo
									  WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($siguiente ,true)."  AND
                                            idproceso = ".$idproceso.' union ';
        
        $sqlb1 = " SELECT    idtarea  AS codigo, '[ 2. NO ] TAREA: ' || tarea  AS NOMBRE
									  FROM flow.wk_procesoflujo
									  WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($anterior ,true)."  AND
                                            idproceso = ".$idproceso.' order by 2 ';
        
        
        $resultado = $this->bd->ejecutar($sqlb.$sqlb1);
        
        $imagen = '<img src="../../kimages/tab_condicion.png" align="absmiddle" />';
        
        $evento = 'Onchange="PoneUsuarioCondicion(this.value,'.$idproceso.','.$idcaso.')"';
        
        $this->obj->list->listadbe($resultado,$tipo,'<b>CONDICION </b>'.$imagen,'siguiente',$datos,'required','',$evento,'div-2-10');
        
    }
    //--------------------------------------------------   
    //--------------------------------------------------
    function  _caso( $idcaso){
        
        
        $qquery = array(
            array( campo => 'idcaso',   valor => $idcaso,  filtro => 'S',   visor => 'S'),
            array( campo => 'caso',   valor => '-',  filtro => 'N',   visor => 'S'),
           array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S')
        );
        
         
        $datos = $this->bd->JqueryArrayVisorDato('flow.wk_proceso_caso',$qquery );   
        
        $string =   trim($datos['caso']);
        
        /*
         $string =   htmlspecialchars($string);
         $string =   html_entity_decode($string);*/
        
        $string =   str_replace("<br>",'\n',$string);
        $string =   str_replace("&nbsp;",' ',$string);
        $string = str_replace(array("\r\n", "\r"), "\n", $string);
        $string =   trim($string);
        $string =   strip_tags($string);
        
        
        $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
        $reemplazar=array("", "", "", "");
        $string=str_ireplace($buscar,$reemplazar,$string);
        
        return $string;
    }
    
    function siguiente_tarea_caso($idproceso,$idtarea ,$idcaso){
        
        $datos        = array();
     
        $tipo 		  = $this->bd->retorna_tipo();
        //--------------------------------------------------------------------------------------------------
        $unidad_actual                 = $this->bd->query_array('flow.view_proceso_caso','*',  "idcaso = ".$this->bd->sqlvalue_inyeccion( $idcaso  ,true) );
        $sesion                        = trim($unidad_actual['sesion']) ;
        //---------------------------------------------------------------------------
        $tarea_siguiente               = $this->bd->query_array('flow.wk_procesoflujo', '*', 'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and idtarea='.$this->bd->sqlvalue_inyeccion($idtarea +  1,true)   );
        //----------------------------------------------------------------------------
        
        $ATarea_flujo = $this->bd->query_array('flow.wk_proceso_formulario_user',
            '*',
            'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
             idtarea='.$this->bd->sqlvalue_inyeccion($idtarea +  1,true) .' and
             perfil='.$this->bd->sqlvalue_inyeccion('operador',true) 
            );
        $unidad  = $ATarea_flujo['unidad'] ;
        
        //--------------------------------------------------------------------------------------------------
        $tarea_actual = $this->bd->query_array('flow.wk_procesoflujo',
                                                '*',
                                                'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true).' and
                                                idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true)  
            );
        
        $condicion     = $tarea_actual['condicion'] ;
        $siguiente     = $tarea_actual['siguiente'] ;
        $anterior      = $tarea_actual['anterior'] ;
        
        echo '<div class="col-md-12"><h4><strong>'.$tarea_actual['tarea'].'</strong><br> '.'</h4> </div>' ;
        
        $datos['caso'] = $this->_caso( $idcaso);

        $datos['novedad'] = 'No existe novedad';
  
        
        
        $this->obj->text->editor('Detalle','caso',4,45,350,$datos,'','readonly','div-2-10') ;
        

        $this->obj->text->editor_yellow('Responder','novedad',3,45,350,$datos,'required','','div-2-10') ;

         
        $sql = "SELECT '-' as codigo, ' - 0. No existe Usuario - ' as nombre  ";
        
        if ( $condicion == 'N'){
            
            $this->obj->text->texto_oculto("siguiente",$datos);
              
            echo '<div class="col-md-12"  style="padding-bottom: 5px;padding-top: 5px" align="center">
                  <div class="alert alert-success">
                    <div class="row" style="padding: 5px">
                      <h4>
                       Siguiente tarea: <br> <strong>'.$tarea_siguiente['tarea'].'</strong><br> <br> '.
                       'Tarea es condicionada? [ '.$tarea_siguiente['condicion'] .' ]<br>
                        </h4>
                  </div>
                 </div>
               </div>' ;
            
            
            
            if ( $unidad == '0')    {
                $sql = "SELECT   email as codigo,completo as nombre
                               FROM  par_usuario
                   where  estado= 'S' and email =".$this->bd->sqlvalue_inyeccion( $sesion ,true) .' order by 2'  ;
                
            }elseif ( $unidad == '1') {
                
                $sql = "SELECT   email as codigo,completo as nombre
                        FROM  par_usuario
                       where responsable =".$this->bd->sqlvalue_inyeccion( 'S' ,true)  .' order by 2'  ;
                
            }else {
                
                $sql = "SELECT   email as codigo,completo as nombre
                        FROM  par_usuario
                       where  estado= 'S' and id_departamento =".$this->bd->sqlvalue_inyeccion( $unidad ,true)  .' order by 2'  ;
                
                if ( empty($unidad)){
                    $sql = "SELECT '-' as codigo, ' - 0. No existe Usuario - ' as nombre  ";
                }
            }
            
        }else{
            
            $this->condicion_tarea($idproceso,$idtarea,$siguiente,$anterior,$idcaso );
            
            $sql = "SELECT '-' as codigo, ' - 0.Seleccione usuario responsable - ' as nombre  ";
            
        }
        
        $resultado = $this->bd->ejecutar($sql);
        $evento='';
        $this->obj->list->listadbe($resultado,$tipo,'Asignar a','sesion_siguiente',$datos,'required','',$evento,'div-2-10');
          
        
    } 
    
    
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
 
 
 ?>
