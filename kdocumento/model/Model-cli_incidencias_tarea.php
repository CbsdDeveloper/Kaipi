<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';    
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
    require '../../kconfig/Db.emailMarket.php'; 
    
    class proceso{
 
    
      private $obj;
      private $bd;
      private $mail;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $ATablaVar;
      private $ATablaReq;
      private $usuario;
      
      
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      
      function proceso( ){
           
                //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->bd	   =	new Db ;
                
                $this->mail    =	new EmailEnvio;
                
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                
                $this->hoy 	     =   date("Y-m-d");  
                
                
                $this->usuario 	 =  trim($_SESSION['usuario']);
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
           
                
                // guarda informacion del tramite proceso
                //--------------------------------------------------------------
                $this->tabla 	  	  = 'flow.wk_proceso_caso';
                
                $this->secuencia 	     = '-';
                
                $timestamp = date('H:i:s'); 
                
                $this->ATabla = array(
                    array( campo => 'caso',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'fvencimiento',tipo => 'DATE',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'responsable',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idtareactual',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'autorizado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '9',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '10',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => $this->sesion 	, key => 'N'),
                    array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'hora_fin',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => $timestamp, key => 'N'),
                    array( campo => 'modificado',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'hmodificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => $timestamp, key => 'N'),
                    array( campo => 'umodificado',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $this->sesion, key => 'N')
                );
                
                
                $this->ATablaVar = array(
                    array( campo => 'idcaso_var',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'variable',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'valor',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
                    array( campo => 'orden',tipo => 'NUMBER',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N')
                );
                
                // requisitos
                
                $this->ATablaReq = array(
                    array( campo => 'idcasoreq',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'idproceso_requi',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'cumple',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'N', key => 'N'),
                    array( campo => 'archivo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => 'N', key => 'N')
                );
            
                
                
                
      }
      
      //-----------------------------------------------------------------------------------------------------------
      // RESULTADO EN PANTALLA DE LAS SENTENCIAS CRUD
      //-----------------------------------------------------------------------------------------------------------
     
      function div_resultado($accion,$id,$tipo){
          

      
          //    $result = $this->div_resultado('editar',$idcaso,1);
          //    function accion(id,modo,bandera)
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA ['.$id.']</b>';
                     
                     echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',0)</script>';
                     
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                     echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',0)</script>';
                  
             }
            
             if ($tipo == 2){
                 
                 $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA ['.$id.']</b>';
                  
                 echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',1)</script>';
             }
             
             
            return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      // LIMPIAR PANTALLA 
      //-----------------------------------------------------------------------------------------------------------
      
      function div_limpiar( ){
            //inicializamos la clase para conectarnos a la bd
       
             $resultado = '';
             echo '<script type="text/javascript">';
              
             echo  'LimpiarPantalla();';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
    	      
     //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
          
     	
 	$qquery = array( 
 			array( campo => 'idcaso',   valor => $id,  filtro => 'S',   visor => 'S'),
 			array( campo => 'caso',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'sesion_siguiente',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'autorizado',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S') 
  	);
 	
      	    $_SESSION['idcaso'] = $id;
 	
      	    $datos = $this->bd->JqueryArrayVisorDato('flow.wk_proceso_caso',$qquery );   
            
      	    $razon =  $this->bd->__ciu($datos['idprov']);
             
        
       
            echo '<script>$("#razon").val('."'".$razon."'".');';
            
            echo '$("#sesion_siguiente").val('."'".trim($datos['sesion_siguiente'])."'".');';
            
            echo '$("#estado").val('."'".trim($datos['estado'])."'".');';
            
            echo '$("#autorizado").val('."'".trim($datos['autorizado'])."'".');';
            
            echo '$("#idprov").val('."'".trim($datos['idprov'])."'".');';
              
            $string =   trim($datos['caso']);
            
       
           $string =   str_replace('"','',$string);

           $string =   str_replace("<br>",'\n',$string);
           $string =   str_replace("&nbsp;",' ',$string);
           $string = str_replace(array("\r\n", "\r"), "\n", $string);
           $string =   trim($string);
           $string =   strip_tags($string);
           
           $str = trim($datos['caso']);

           $str =   str_replace('"','',$str);

           $buscar     = array(chr(13).chr(10), "\r\n", "\n", "\r");
           $reemplazar = array("", "", "", "");
           $str        = str_ireplace($buscar,$reemplazar,$str);
            
          
          
           echo 'document.getElementById("caso").value='.'"'.$string.'"';
             
           echo '$("#novedad").val('."'".'En proceso de revision...	'."'".');';
 
            echo '</script>';
            
            
            $accion = 'editar';
             
            $this->pone_variables( $id  );
            
               
            $result =  $this->div_resultado($accion,$id,2);
     
        echo  $result;
      }	
  
      /*

      */
      function pone_variables( $idcaso  ){
          
          
          
          $sql = 'SELECT  variable, valor,   orden
                  FROM flow.wk_proceso_caso_var
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and
                        valor is not NULL order by orden'    ;
          
          
          
          $resultado  = $this->bd->ejecutar($sql);
          
          while ($x=$this->bd->obtener_fila($resultado)){
              
              $cobjetos = 'col_'.trim( $x['orden'] );
              
              $valor = trim($x['valor']);
              
               
              if ( !empty($valor)) {
                   
                  echo '<script>$("#'.$cobjetos.'").val("'.trim($valor).'" );</script>';
                  
              }
               
          }
          
          
          
      }	
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
                 if ($action == 'edit'){
                     
                     $this->edicion($id );
                     
                 }  
     }  
    //-----------------------------------
   
   function _actualiza_tareas( $idcaso, $idproceso, $idtarea,$novedad,$sesion_siguiente,$siguiente,$ambito='-' ){
       
       
       $tiempo  = date("H:i:s");
       $cumple  = 'N';
       $id_departamento = $this->_departamento_codigo(trim($sesion_siguiente));
       
       
       $ATablaTarea = array(
           array( campo => 'idcasotarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
           array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idproceso, key => 'N'),
           array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
           array( campo => 'idtarea',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '2', key => 'N'),
           array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$idcaso, key => 'N'),
           array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
           array( campo => 'cumple',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $cumple, key => 'N'),
           array( campo => 'finaliza',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'N', key => 'N'),
           array( campo => 'fecha_recepcion',tipo => 'DATE',id => '8',add =>'S', edit => 'S', valor => $this->hoy, key => 'N'),
           array( campo => 'fecha_envio',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N') ,
           array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => trim($sesion_siguiente), key => 'N'),
           array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>trim($sesion_siguiente), key => 'N'),
           array( campo => 'unidad',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor =>$id_departamento, key => 'N'),
           array( campo => 'hora_in',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
           array( campo => 'hora_fin',tipo => 'VARCHAR2',id => '14',add =>'S', edit => 'S', valor => $tiempo, key => 'N'),
           array( campo => 'ambito',tipo => 'VARCHAR2',id => '15',add =>'S', edit => 'S', valor =>$ambito, key => 'N'),
       );
       
       
       $caso_tarea = $this->bd->_InsertSQL('flow.wk_proceso_casotarea',$ATablaTarea,'flow.wk_proceso_casotarea_idcasotarea_seq');
       

       return $caso_tarea;
   }	
  
 
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){
           
            $proceso_tarea    =  $_POST['tarea_actual'];
            $doc_user         =  $_POST['doc_user'];
            $novedad          =  trim($_POST['novedad']);
            
            $sesion_siguiente   =  trim($_POST['sesion_siguiente']);
            
              
            if ( $sesion_siguiente == '-'){
                $reasignado = 'S';
            }else{
                $reasignado = 'N';
            }
               
            
            $fecha     = $this->bd->hoy();
            
            $sql = "UPDATE flow.wk_proceso_casotarea
        			        SET cumple =".$this->bd->sqlvalue_inyeccion('S', true).",
                                idtarea=".$this->bd->sqlvalue_inyeccion($proceso_tarea, true).",
                                reasignado=".$this->bd->sqlvalue_inyeccion($reasignado, true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
                                fecha_recepcion=".$fecha."
         				 WHERE idcasotarea =".$this->bd->sqlvalue_inyeccion($doc_user, true) ;
           
             
            $this->bd->ejecutar($sql);
            
            //------------------------
            $sql = "UPDATE flow.wk_proceso_caso 
                       SET idtareactual =".$this->bd->sqlvalue_inyeccion($proceso_tarea, true)." 
                    WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true) ;
              
            $this->bd->ejecutar($sql);
            
            $result = $this->div_resultado('editar',$id,1);
            
            echo $result;
            
        
    }
    
    //--------------------------------------------------------------------------------
    //--- APROBACION DE TRAMITES de registros
    //--- $id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente
    //--------------------------------------------------------------------------------
    
    function Aprobado( $id,$idproceso,$tarea_actual ,$novedad,$sesion_siguiente,$doc_user ,$sesion_reasigna){
        
      $bandera1  = 1;
      $bandera2  = 1;
      $lon       = strlen(trim($novedad));
      $lon2      = strlen(trim($sesion_siguiente));   

      $lon1      = strlen(trim($sesion_reasigna));   

 
      $fecha     = $this->bd->hoy();

      
     // $lon1      = $Reasigna['nn']; // REASIGNAR USUARIO INTERNO
      $result    = ' nada q ver '; 

      if ( $lon  < 15 ){
          $bandera1 = 0;
      }
          
      if ( $lon1 > 0 ){    // REASIGNAR USUARIO INTERNO
          $bandera2 = 3;
      }
      
      if ( $lon2 > 4 ){   // USUARIO EXTERNO PARA ENVIAR A OTRA UNIDAD
          $bandera2 = 4;
      }
       

     if (   $bandera1  == 1 ){

            $sql = "UPDATE flow.wk_proceso_casotarea
                    SET cumple =".$this->bd->sqlvalue_inyeccion('S', true).",
                        finaliza=".$this->bd->sqlvalue_inyeccion('S', true).",
                        fecha_envio=".$fecha."
                WHERE idcasotarea =".$this->bd->sqlvalue_inyeccion($doc_user, true) ;

                 $this->bd->ejecutar($sql);

                // REASIGNAR USUARIO INTERNO
                 if (   $bandera2  == 3 ){    
                       
                    $this->pone_tareas( $id, $idproceso ,$sesion_reasigna );

                   // $this->_actualiza_tareas( $id, $idproceso, $tarea_actual,$novedad,$sesion_reasigna,'','R' );

                   $sql = "UPDATE flow.wk_doc_user
                   SET bandera =".$this->bd->sqlvalue_inyeccion(1, true)."
                       WHERE bandera = 0 and idcaso =".$this->bd->sqlvalue_inyeccion($id, true) ;

                   $this->bd->ejecutar($sql);

                    $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> ';
                }

                // USUARIO EXTERNO PARA ENVIAR A OTRA UNIDAD
                 if (   $bandera2  == 4 ){
                    
                    $this->_actualiza_tareas( $id, $idproceso, $tarea_actual,$novedad,$sesion_siguiente,'','S' );

                    $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> ' ;
                }
    }

 
 
        echo $result;
    }

 //--------------------------------------------------------------------------------
    //--- APROBACION DE TRAMITES de registros
    //--- $id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente
    //--------------------------------------------------------------------------------
    
    function Leido( $id,$idproceso,$tarea_actual ,$novedad,$sesion_siguiente,$doc_user ,$sesion_reasigna){
        
        $bandera1  = 1;
        $lon       = strlen(trim($novedad));
        $fecha     = $this->bd->hoy();
  
        
        $result    = ' AGREGE COMENTARIO DEL DOCUMENTO ENVIADO '; 
  
        if ( $lon  < 25 ){
            $bandera1 = 0;
        }
            
       
         
  
       if (   $bandera1  == 1 ){
  
              $sql = "UPDATE flow.wk_proceso_casotarea
                      SET cumple =".$this->bd->sqlvalue_inyeccion('S', true).",
                          finaliza=".$this->bd->sqlvalue_inyeccion('S', true).",
                          novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
                          leido=".$this->bd->sqlvalue_inyeccion(1, true).",
                          fecha_envio=".$fecha."
                  WHERE idcasotarea =".$this->bd->sqlvalue_inyeccion($doc_user, true) ;
  
                   $this->bd->ejecutar($sql);
  
                  
                   $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> ' ;    
      }
  
   
   
          echo $result;
      }

    //--------------------------------------------------------------------------------
    function pone_tareas( $idcaso, $idproceso,$sesion_reasigna  ){
        
        
        
        $Tramite = $this->bd->query_array('flow.wk_proceso_caso',
                                         'idtareactual, sesion_actual, autorizado, caso,
                                          sesion_siguiente,caso,estado,hora_in',
                                         'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)
            );
        
        $tiempo  = date("H:i:s");
        
             
            //--------------- primera tarea solicitada
            $novedad = 'Requerimiento '.trim($Tramite['caso'])  ;
            $cumple  = 'S';
            $sesion_actual    =   trim($this->sesion ) ;
            $sesion_siguiente =   trim($this->sesion ) ;
            $id_departamento  =   $Tramite['id_departamento']  ;
            $tipo = 'N'  ;
              
            
            //-----------------------------------------
            $sql = "SELECT    id_user_doc, idcaso, fecha, tipo, sesion_actual, hora_in, sesion,
                                     funcionario, cedula,
                                     id_departamento, idusuario
                            FROM  flow.view_proceso_doc_user
                            where tipo = 'N' and inicio = 'N' and bandera = 0 and  
                                  idcaso = ".$this->bd->sqlvalue_inyeccion($idcaso ,true)    ;
            
 

            $resultado  = $this->bd->ejecutar($sql);
            
            $i = 1;
            
            while ($x=$this->bd->obtener_fila($resultado)){
                
                // $cobjetos = 'col_'.
                $novedad = trim($Tramite['caso'])  ;
                $cumple  = 'N';
                $sesion_actual    =   $x['sesion_actual']  ;
                $sesion_siguiente =   $x['sesion_actual']  ;
                $id_departamento  =   $x['id_departamento']  ;
                $tipo             =   'R'  ;
                
                
                $ATablaTarea = array(
                    array( campo => 'idcasotarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idproceso, key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'idtarea',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '2', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$idcaso, key => 'N'),
                    array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
                    array( campo => 'cumple',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $cumple, key => 'N'),
                    array( campo => 'finaliza',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'N', key => 'N'),
                    array( campo => 'fecha_recepcion',tipo => 'DATE',id => '8',add =>'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'fecha_envio',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N') ,
                    array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $sesion_actual, key => 'N'),
                    array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$sesion_siguiente, key => 'N'),
                    array( campo => 'unidad',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor =>$id_departamento, key => 'N'),
                    array( campo => 'hora_in',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'hora_fin',tipo => 'VARCHAR2',id => '14',add =>'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'ambito',tipo => 'VARCHAR2',id => '15',add =>'S', edit => 'S', valor => $tipo, key => 'N'),
                );
                
                
                
            $this->bd->_InsertSQL('flow.wk_proceso_casotarea',$ATablaTarea,'flow.wk_proceso_casotarea_idcasotarea_seq');
                
                //  $dato = $this->notificacion_email($id,$Tramite['email_siguiente'],$Tramite['nombre_siguiente'],'N');
                
                $i =  $i + 1;
                
            }

            $caso_tarea = 1;
         
        
        return $caso_tarea;
    }	
    //--------------------------------------------------------------------------------
    //--- APROBACION DE TRAMITES de registros
    //--- $id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente
    //--------------------------------------------------------------------------------
    
    function Anulado( $id,$idproceso,$tarea_actual ,$novedad,$sesion_siguiente ){
        
        $bandera = 1;
        
         
        $lon = strlen(trim($novedad));
        
        //----------------------------------------------------------
        if ( $lon > 15 ){
            $bandera == 0;
        }
        
       
         
        if ( $bandera == 1 ){
            
                 $estado = 6;
                 
                 $caso = 'TRAMITE ANULADO...'. $this->sesion. ' fecha: '.$this->hoy.' ';
                 
                $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion($estado, true).",
                                caso = ".$this->bd->sqlvalue_inyeccion($caso, true)." || caso 
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                
                 $this->bd->ejecutar($sql);
                 
                 $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE ANULADO</b> ';
            }else {
                
                $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>REGISTRE NOVEDAD PARA SU ESTADO</b>';
                
            }
       
        
        
        echo $result;
    }
    //--------------------------------------------------------------------------------
    function _vencimiento($id  ){
        
        $sql = "select sum(tiempo) as tiempo_total,tipotiempo, ( sum(tiempo) / 8) en_dias
              from flow.wk_procesoflujo
             where idproceso = ". $this->bd->sqlvalue_inyeccion($id,true)." and idtarea  <> 0  group by idproceso, tipotiempo";
        
 
        
        $stmt_nivel1=  $this->bd->ejecutar($sql);
        
        $totalhora = 0;
        
        while ($x= $this->bd->obtener_fila($stmt_nivel1)){
            
            $totalhora = $totalhora + $x['en_dias'];
            
        }
        
        $date =  date("Y-m-d");  
       
        $endias = "+ ".$totalhora." days";
        
        $mod_date = strtotime($date.$endias);
          
        return date("Y-m-d",$mod_date);
    }
    //---------------------
    function _departamento_codigo( $sesion  ){
        
        
 
        $Aunidad = $this->bd->query_array('par_usuario',
                                          'id_departamento', 
                                'email='.$this->bd->sqlvalue_inyeccion(trim($sesion),true)
            );
        
        
        return $Aunidad['id_departamento'];
    }
    //------------------
    function _unidad( $idproceso, $idtarea ){
        
        $Aunidad = $this->bd->query_array(
            'flow.wk_proceso_formulario_user',
            'unidad',
            'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true)." and 
             idtarea =". $this->bd->sqlvalue_inyeccion($idtarea,true)." and
             perfil = 'operador'"
            );
        
        
        return $Aunidad['unidad'];
    }
    
    //---------------------
    function _responsable_proceso($idproceso ){
         
        
        $Aunidad = $this->bd->query_array('flow.wk_proceso',
            'responsable',
            'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true)
            );
     
        
        return $Aunidad['responsable'];
    }
    //-----------------------------
    function propiedades_proceso($idproceso ){
        
        
        $Aunidad = $this->bd->query_array('flow.wk_proceso',
            'responsable,ambito,id_departamento,solicitud',
            'idproceso='.$this->bd->sqlvalue_inyeccion($idproceso,true)
            );
        
        
        return $Aunidad;
    }
    //-----------------------------
    function valida_idprov($idprov,$tipo ){
        
        if ( $tipo == 'N'){
            
            $x = $this->bd->query_array('par_ciu',
                'count(*) as nn ',
                'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true). ' and 
                 modulo ='.$this->bd->sqlvalue_inyeccion($tipo,true)
                );
            
        }else {
            
            $x = $this->bd->query_array('par_ciu',
                'count(*) as nn ',
                'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true). ' and 
                modulo <>'.$this->bd->sqlvalue_inyeccion($tipo,true)
                );
            
        }
      
  
         
        return $x['nn'];
        
    }
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
    function eliminar($id ,$novedad){
  
         $Aunidad = $this->bd->query_array('par_usuario',
             'responsable',
             'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
             );
         
         $Tramite = $this->bd->query_array('flow.wk_proceso_caso',
             'idtareactual, sesion_actual, autorizado, caso,
                                          sesion_siguiente,caso,estado,hora_in',
             'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
             );
         
         $responsable =  $Aunidad['responsable'];
         
         
         $fecha     = $this->bd->hoy();
         
         if ( $responsable == 'S' ){
             
             $estado = 6;
             
             $caso = 'TRAMITE ANULADO...'. $this->sesion. ' fecha: '.$this->hoy.' ';
     
             $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion($estado, true).",
                                caso = ".$this->bd->sqlvalue_inyeccion($caso, true)." || caso,
                                sesiona =".$this->bd->sqlvalue_inyeccion($this->sesion, true).",
                                fecha_a =".$fecha."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true).' and 
                                sesion_actual='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
             
             $this->bd->ejecutar($sql);
             
             //-------------- INSERTA FINAL
             $tiempo  = date("H:i:s");
             $novedad = 'Anulado '.trim($novedad)  ;
             $cumple  = 'S';
             $sesion_actual    =   trim($this->sesion ) ;
             $sesion_siguiente =   trim($this->sesion ) ;
             $id_departamento  =   $Tramite['id_departamento']  ;
             $tipo = 'N'  ;
             
             $idproceso = 21;
             
             $ATablaTarea = array(
                 array( campo => 'idcasotarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
                 array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idproceso, key => 'N'),
                 array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                 array( campo => 'idtarea',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '1', key => 'N'),
                 array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$id, key => 'N'),
                 array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
                 array( campo => 'cumple',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $cumple, key => 'N'),
                 array( campo => 'finaliza',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'S', key => 'N'),
                 array( campo => 'fecha_recepcion',tipo => 'DATE',id => '8',add =>'S', edit => 'S', valor => $this->hoy, key => 'N'),
                 array( campo => 'fecha_envio',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N') ,
                 array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $sesion_actual, key => 'N'),
                 array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$sesion_siguiente, key => 'N'),
                 array( campo => 'unidad',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor =>$id_departamento, key => 'N'),
                 array( campo => 'hora_in',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                 array( campo => 'hora_fin',tipo => 'VARCHAR2',id => '14',add =>'S', edit => 'S', valor => $tiempo, key => 'N'),
                 array( campo => 'ambito',tipo => 'VARCHAR2',id => '15',add =>'S', edit => 'S', valor => $tipo, key => 'N'),
             );
             
             
             $this->bd->_InsertSQL('flow.wk_proceso_casotarea',$ATablaTarea,'flow.wk_proceso_casotarea_idcasotarea_seq');
             
             $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE ANULADO</b> ';
             
         }else {
             
             $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LOS PERMISOS DE USUARIO...</b>';
             
         }
         
  
       echo $result;
      
   }
 //-----------------------------
   function Terminar($id,$novedad ){
       
       $Aunidad = $this->bd->query_array('par_usuario',
           'responsable',
           'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
           );
       
       $Tramite = $this->bd->query_array('flow.wk_proceso_caso',
           'idtareactual, sesion_actual, autorizado, caso,
                                          sesion_siguiente,caso,estado,hora_in',
           'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
           );
       
       
       $responsable =  $Aunidad['responsable'];
       
       
       $fecha     = $this->bd->hoy();
       
       if ( $responsable == 'S' ){
           
           $estado = 4;
           
           $caso = 'TRAMITE TERMINADO...'. $this->sesion. ' fecha: '.$this->hoy.' ';
           
           
           $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion($estado, true).",
                                caso = ".$this->bd->sqlvalue_inyeccion($caso, true)." || caso,
                                fecha_fina =".$fecha."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
           
           $this->bd->ejecutar($sql);
           
           //-------------- INSERTA FINAL 
           $tiempo  = date("H:i:s");
           $novedad = 'Finalizado '.trim($novedad)  ;
           $cumple  = 'S';
           $sesion_actual    =   trim($this->sesion ) ;
           $sesion_siguiente =   trim($this->sesion ) ;
           $id_departamento  =   $Tramite['id_departamento']  ;
           $tipo = 'N'  ;
           
           $idproceso = 21;
           
           $ATablaTarea = array(
               array( campo => 'idcasotarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
               array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idproceso, key => 'N'),
               array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
               array( campo => 'idtarea',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '1', key => 'N'),
               array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$id, key => 'N'),
               array( campo => 'novedad',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
               array( campo => 'cumple',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $cumple, key => 'N'),
               array( campo => 'finaliza',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'S', key => 'N'),
               array( campo => 'fecha_recepcion',tipo => 'DATE',id => '8',add =>'S', edit => 'S', valor => $this->hoy, key => 'N'),
               array( campo => 'fecha_envio',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy, key => 'N') ,
               array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $sesion_actual, key => 'N'),
               array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor =>$sesion_siguiente, key => 'N'),
               array( campo => 'unidad',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor =>$id_departamento, key => 'N'),
               array( campo => 'hora_in',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
               array( campo => 'hora_fin',tipo => 'VARCHAR2',id => '14',add =>'S', edit => 'S', valor => $tiempo, key => 'N'),
               array( campo => 'ambito',tipo => 'VARCHAR2',id => '15',add =>'S', edit => 'S', valor => $tipo, key => 'N'),
           );
           
           
           $this->bd->_InsertSQL('flow.wk_proceso_casotarea',$ATablaTarea,'flow.wk_proceso_casotarea_idcasotarea_seq');
           
           ///--------------------
           $sql = " UPDATE flow.wk_proceso_casotarea
        			        SET finaliza =".$this->bd->sqlvalue_inyeccion('S', true).",
                                   cumple=".$this->bd->sqlvalue_inyeccion('S', true)."
          				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true).' and 
                               sesion_actual='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
           
           $this->bd->ejecutar($sql);
           
           ///----------------------
           $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE TERMINADO</b> ';
           
       }else {
           
           $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>VERIFIQUE LOS PERMISOS DE USUARIO...</b>';
           
       }
       
       
       echo $result;
       
   }
   //-----------------------
   function notificacion_email($idcaso ,$nombre_notifica, $encuesta){
       
       
       $this->mail->_DBconexion(  $this->obj, $this->bd );
       
       $this->mail->_smtp_factura_electronica( );
       
       
       $url = $this->bd->query_array(
           'flow.view_proceso_caso',
           ' nombre_solicita, movil_solicita, email_solicita, direccion_solicita,proceso,caso,fecha, 
            fvencimiento, estado,dias_trascurrido,unidad,ambito',
           'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)
           );
       
       $asunto = 'Notificacion Tramite '.$idcaso.'-'.$url['nombre_solicita'];
       
       if ( trim($url['estado']) == '5'){
           $idplantilla = -6 ;
       }else{
           $idplantilla = -5 ;
       }
       
       
       $Contenido = $this->bd->query_array(
           'ven_plantilla',
           'contenido,   variable',
           'id_plantilla='.$this->bd->sqlvalue_inyeccion($idplantilla,true)
           );
       
       
       
       $boton = '<a class="m_-7419620230746147874btn-primary"'.
           'style="margin: 0; padding: 0; '."
                                    font-family: 'Avenir LT W01_35 Light','Helvetica Neue','Helvetica',Helvetica,Arial,sans-serif;
                                    font-size: 100%; line-height: 2; color: #ffffff; text-decoration: none; background-color: #348eda;
                                    border: solid #348eda; border-width: 10px 40px; font-weight: bold; margin-right: 10px; text-align: center;".
                                    ' display: inline-block; border-radius: 25px;" '.'
                                    href="https://www.g-kaipi.cloud/encuesta/UserEncuesta/Resolver.php?id_encuesta=1" target="_blank"
                                    data-saferedirecturl="#pdf">Presiona Aqui </a>';
       
       
       $texto_encuesta = '<span style="font-weight:500px">Es importante conocer tu sentir...
                              te invitamos a calificar nuestro servicio '.$boton.'</span>';
       
       
       
       
       $content =  str_replace ( '#NOMBRE' , trim($nombre_notifica) ,  $Contenido['contenido']);
       
       $content =  str_replace ( '#CASO' , $idcaso,  $content);
       
       $content =  str_replace ( '#FECHA' , trim($url['fecha']) ,  $content);
       
       $content =  str_replace ( '#PROCESO' , trim($url['proceso']) ,  $content);
       
       $content =  str_replace ( '#AMBITO' , trim($url['ambito']) ,  $content);
       
       $content =  str_replace ( '#DETALLE' ,trim($url['caso']) ,  $content);
       
       $content =  str_replace ( '#USUARIO' ,trim($url['nombre_solicita']) ,  $content);
       
       $content =  str_replace ( '#DIAS' ,trim($url['dias_trascurrido']) ,  $content);
       
       
       if (trim($encuesta) == 'S'){
           $content =  str_replace ( '#ENCUESTA' ,trim($texto_encuesta) ,  $content);
       }
       
       $this->mail->_DeCRM(  $this->sesion, $_SESSION['razon']);
       
       //$this->mail->_ParaCRM(trim($email_notifica),trim($nombre_notifica));
       
       $this->mail->_CopiaCRM( $this->sesion,$_SESSION['razon'] );
       
       
       $this->mail->_AsuntoCRM($asunto,$content );
       
       
       $response = $this->mail->_EnviarElectronica();
       
       
       return $response;
       
       
   }
   
   //-----------------------------------
   function _agregar_historico( $idtarea, $idcaso ,$sesion ,$novedad,$reasignado){
       
       $timestamp = date('H:i:s');
       
      $ATabla = array(
           array( campo => 'idtareaa',tipo => 'NUMBER',id => '0',add => 'N', edit => 'S', valor => '-', key => 'S'),
          array( campo => 'sesion',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
          array( campo => 'idtarea',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => $idtarea, key => 'N'),
           array( campo => 'idcaso',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor =>$idcaso, key => 'N'),
          array( campo => 'novedad',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $novedad, key => 'N'),
           array( campo => 'cumple',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => 'N', key => 'N'),
          array( campo => 'fecha_recepcion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>$this->hoy , key => 'N'),
          array( campo => 'hora_in',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $timestamp, key => 'N'),
          array( campo => 'reasignado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => $reasignado, key => 'N'),
       );
           
      
      
      $this->bd->_InsertSQL('flow.wk_proceso_tareaa',$ATabla,'flow.wk_proceso_tarea_idtareaa_seq');
           
     
   }	
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    //------ poner informacion en los campos del sistema
    
     if (isset($_GET['accion']))	{
            
            $accion           =   $_GET['accion'];
            $id               =   $_GET['id'];
            $novedad          =   trim($_GET['novedad']);
            
            if ($accion == 'aprobado'){
                
                $idproceso        =   $_GET['idproceso'];
                $tarea_actual     =   $_GET['tarea_actual'];
              
                $sesion_siguiente =   trim($_GET['sesion_siguiente']);
                $siguiente        =   trim($_GET['siguiente']);
                $sesion_reasigna  =   trim($_GET['sesion_reasigna']);
                
                $gestion->Aprobado($id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente,$siguiente,$sesion_reasigna);
         
            }elseif  ($accion == 'leido'){
                
                $idproceso        =   $_GET['idproceso'];
                $tarea_actual     =   $_GET['tarea_actual'];
              
                $sesion_siguiente =   trim($_GET['sesion_siguiente']);
                $siguiente        =   trim($_GET['siguiente']);
                $sesion_reasigna  =   trim($_GET['sesion_reasigna']);

                $novedad =   trim($_GET['novedad']);
                
                
                $gestion->Leido($id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente,$siguiente,$sesion_reasigna);

             }elseif  ($accion == 'anulado'){
                
                $gestion->Anulado($id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente);
                
            }elseif  ($accion == 'del'){

                $gestion->eliminar( $id,$novedad );

            }elseif  ($accion == 'terminar'){

                  $gestion->Terminar( $id,$novedad );

             }
            elseif  ($accion == 'variable'){
 
             $gestion->pone_variables( $id );

           }
            else {
                $gestion->consultaId($accion,$id);
                
            }
     }
    
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["idcaso"];
        
          
            
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  