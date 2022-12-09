<?php 
     session_start( );   
   
  
    class tareaProceso{
 
      //creamos la variable donde se instanciar? la clase "mysql"
 
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
                
                $this->sesion 	 =  $_SESSION['email'];
                
        
      }
 //---------------------------------------------------------------------  
      function Formulario( $idproceso,$idtarea){
      
          
          $sqlDepa = "SELECT acceso,variable,tipo,enlace,tabla,lista,orden
									      FROM view_proceso_form
										WHERE idtarea =   ".$this->bd->sqlvalue_inyeccion($idtarea,true). "  and
													   idproceso =  ".$this->bd->sqlvalue_inyeccion($idproceso,true). "
									  ORDER BY  orden";
          
          $stmt_depa		=		$this->bd->ejecutar($sqlDepa);
          $tipo_c 			=		 $this->bd->retorna_tipo();
          
          $i = 1;
          
          while ($x=$this->bd->obtener_fila($stmt_depa)){
              
              $variable       = utf8_decode(trim($x['variable']));
              $tipo			= trim($x['tipo']);
              $idproceso_var  =  $x['idproceso_var'];
              $tabla  				=  $x['tabla'];
              $objeto				=  'col_'.$x['orden'];
              $lista	  				=  $x['lista'];
              
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
                      $this->obj->text->text($variable,"texto",$objeto,70,70,$datos,$required ,$disabled,'div-2-4') ;
                  }
                  
              }
              //------------------------------------------------------------------------------------------------------------------------
              if ($tipo == 'lista'){
                  $MATRIZ = $this->lista($lista);
                  
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
                      $this->obj->text->text($variable,"email",$objeto,70,70,$datos, $required, $disabled ,'div-2-4') ;
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
                  
                  if ($visualiza == 1){
                      $this->obj->text->text($variable,"date",$objeto,70,70,$datos,'required','','div-2-4') ;
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
                  $div2 = 'div-2-4';
                  $enlace = '<a href="'.$lista.'" target="_blank">'.$variable.'</a>';
                  
                  echo '<div  style="padding-top: 5px;text-align: right;" class="col-md-2">'.' <img src="../../kimages/wurl.png" />' .'</div>';
                  
                  echo '<div style="padding-top: 5px;" class="col-md-4">'.$enlace.'</div>';
                  
              }
              $i++;
          }
          $valida = $i-1;
          
          if($valida%2<>0)
          {
              echo '<div   class="col-md-6"></div>';
          }
     		       
   }
 
   //----------------------------------------------
  //----------------------------------------------
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
       
       $this->set->div_label(12,'<h5> Requisitos <h5>');
       
       $tipo 		= $this->bd->retorna_tipo();
       
       $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    requisito  ,
                    requisito_perfil ,
                    tipo ,
                    obligatorio ,
                    sesion,idtarearequi,prioridad
      FROM view_unidadprocesorequi
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
       
       
       
       ///--- desplaza la informacion de la gestion
       $resultado  = $this->bd->ejecutar($sql);
       
       $cabecera =  "Requisito,Tipo,Prioridad,Adjunto,Cargar,Archivo,Cumple";
       
       
       $this->obj->table->table_cabecera( $cabecera);
       
     
       //align="right"
           
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $adjunto_valida = $x['obligatorio'];
           $Perfil = trim($x['requisito_perfil']);
           
           $adjunto = 'Perfil de observador';
           $upload ='';
           $fileArchivo = '';
           
           
           if ($adjunto_valida == 'S') {
               
               if ($Perfil == 'operador')  {
                   
                   $adjunto ='<input type="file"
                             id = "file" name="file" class="filestyle"
                            data-icon="true" accept="*/*"
                            data-inputsize="medium">
                      <input name="ADJUNTO" type="hidden" id="ADJUNTO" value="-">';
                   
                   $upload = '<button type="button" class="btn btn-default" id="CargaFileActividad"> <span class="glyphicon glyphicon-paperclip"></span></button> ';
                   
               }
               
            
               
               $fileArchivo = '  <input name="fileArchivo" type="text" size="45" readonly="readonly" id="fileArchivo" placeholder="Archivo">';
               
               
           }else{
               
               $adjunto = 'No requiere adjunto archivo';
               $upload ='';
               $fileArchivo = '';
           }
         
               
         
           
           
           echo "<tr>";
          
           echo '<td with="25%">'.$x['requisito'].'</td>';
           echo '<td with="10%">'.$x['tipo'].'</td>';
           echo '<td with="10%">'.$x['prioridad'].'</td>';
           echo '<td with="20%">'.$adjunto.'</td>';
           echo '<td with="10%">'.$upload.'</td>';
           echo '<td with="15%">'.$fileArchivo.'</td>';
           echo '<td with="10%">'.
               '<select name="cumple" required="required" id="cumple">
                       <option value="S">Si</option>
                       <option value="N">No</option>
                     </select>'.'</td>';
           echo "</tr>";
           
       }
       
       echo "</tbody></table>";
         
    } 
///------------------------------------------------------------------------
//----------------------------------------------
    function documentos_tarea($idproceso,$idtarea ){
        
        $this->set->div_label(12,'<h5> Documentos <h5>');
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $sql = 'SELECT  idproceso ,
                    idtarea  ,
                    documento  ,
                    perfil_documento ,
                    tipo ,
                    estado ,
                    sesion,idtareadoc
      FROM view_unidadProcesodocu
      where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).' and
            idtarea = '.$this->bd->sqlvalue_inyeccion($idtarea ,true)      ;
        
        
        
        ///--- desplaza la informacion de la gestion
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Documento,Tipo,Perfil,Editor";
        
        
        $this->obj->table->table_cabecera( $cabecera);
        
        
        //align="right"
        
        while ($x=$this->bd->obtener_fila($resultado)){
            
             $Perfil = trim($x['perfil_documento']);
            
         /*
            
            
            if ($adjunto_valida == 'S') {
                
                if ($Perfil == 'operador')  {
                    
                    $adjunto ='<input type="file"
                             id = "file" name="file" class="filestyle"
                             data-inputsize="medium">
                      <input name="ADJUNTO" type="hidden" id="ADJUNTO" value="-">';
                    
                    $upload = '<button type="button" class="btn btn-default" id="CargaFileActividad"> <span class="glyphicon glyphicon-paperclip"></span></button> ';
                    
                }
                
                
                
                $fileArchivo = '  <input name="fileArchivo" type="text" size="45" readonly="readonly" id="fileArchivo" placeholder="Archivo">';
                
                
            }else{
                
                $adjunto = 'No requiere adjunto archivo';
                $upload ='';
                $fileArchivo = '';
            }
            
            */
             
             $adjunto = '<button type="button" data-toggle="modal" data-target="#VentanaEditor" class="btn btn-default" id="CargaEditor"> <span class="glyphicon glyphicon-paperclip"></span></button> ';
            
             
            
            echo "<tr>";
            
            echo '<td with="40%">'.$x['documento'].'</td>';
            echo '<td with="20%">'.$x['tipo'].'</td>';
            echo '<td with="20%">'.$x['perfil_documento'].'</td>';
            echo '<td with="20%">'.$adjunto.'</td>';
          
            
        }
        
        echo "</tbody></table>";
        
    } 
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  

 
  
 
 ?>
