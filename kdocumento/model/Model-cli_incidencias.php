<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
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
                
                $tiempo = date("H:i:s");
                
                $this->tabla 	  	  = 'flow.wk_proceso_caso';
                
                $this->secuencia 	     = 'flow.wk_proceso_caso_idcaso_seq';
                
                $this->ATabla = array(
                    array( campo => 'caso',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'fvencimiento',tipo => 'DATE',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
                    array( campo => 'responsable',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idtareactual',tipo => 'NUMBER',id => '6',add => 'S', edit => 'N', valor => '1', key => 'N'),
                    array( campo => 'autorizado',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'N', key => 'N'),
                    array( campo => 'idproceso',tipo => 'NUMBER',id => '8',add => 'S', edit => 'N', valor => '21', key => 'N'),
                    array( campo => 'idcaso',tipo => 'NUMBER',id => '9',add => 'N', edit => 'N', valor => '-', key => 'S'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion_actual',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'N', valor => $this->sesion 	, key => 'N'),
                    array( campo => 'sesion_siguiente',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_in',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'modulo',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'D', key => 'N'),
                    array( campo => 'modificado',tipo => 'DATE',id => '16',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'hmodificado',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => $tiempo, key => 'N'),
                    array( campo => 'umodificado',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => $this->sesion, key => 'N')
                 );
            
                
                
                 
               
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase 'editar',$idcaso,1
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
       
          
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA </b> -'.$id;
                     
                  echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',0)</script>';
                     
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO </b> -'.$id;

                     echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',2)</script>';
                  
             }
            
             if ($tipo == 2){
                 
                 $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA </b> -'.$id;
                  
                 echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .',1)</script>';
             }
             
             
            return $resultado;   
 
      }
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
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
          
            
            //--------------------------
            if ( $datos['sesion_siguiente'] == '-'){
                
                if (trim($datos['estado']) == '3'){
                    
                   
                 
                }
            }

        

 
            $str = trim($datos['caso']);
            $str =   str_replace('"','',$str);
             
            $buscar     = array(chr(13).chr(10), "\r\n", "\n", "\r");
            $reemplazar = array("", "", "", "");
            $str        = str_ireplace($buscar,$reemplazar,$str);
 
             
            echo '<script>$("#razon").val('."'".$razon."'".');';
                     echo '$("#sesion_siguiente").val('."'".trim($datos['sesion_siguiente'])."'".');';
                    echo '$("#estado").val('."'".trim($datos['estado'])."'".');';
                    echo '$("#vestado").val('."'".trim($datos['estado'])."'".');';
                    echo '$("#autorizado").val('."'".trim($datos['autorizado'])."'".');';
                    echo '$("#idprov").val('."'".trim($datos['idprov'])."'".');';
                    echo 'valida_botones();';

                    echo 'limpiar_mensaje('.'"'.  $str.'"'.')';
                   

             echo '</script>';
 
           
             
            $result =  $this->div_resultado($accion,$id,2);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
     function xcrud($action,$id){
          
 
                 // ------------------  agregar
                 if ($action == 'add'){
                    
                     $this->agregar( );
                 
                 }  
                 // ------------------  editar
                 if ($action == 'editar'){
        
                     $this->edicion($id );
     
                 }  
                 // ------------------  eliminar
                  if ($action == 'del'){
        
                     $this->eliminar($id );
     
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
         $id_proceso           =   $_POST['proceso_codigo'];
         $sesion_siguiente     =   $_POST['sesion_siguiente'];
         $caso                 =   substr(trim($_POST['caso']),0,300);
         
         $bandera = 0;

         if ( strlen($sesion_siguiente) >  0 ) {
             $bandera = 1;
         }else {
             $bandera = 0;
             $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>SELECCIONE RESPONSABLE TAREA SIGUIENTE'.$sesion_siguiente.'</b>';
         }
         
 
         if ( strlen($caso) >  10 ) {
             $bandera = 1;
         }else {
             $bandera = 0;
             $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>INGRESE EL DETALLE DEL DOCUMENTO A REALIZAR</b>';
         }
         
           
         $this->ATabla[0][valor]  =  $caso ;

         $this->ATabla[2][valor]  =  $this->vencimiento($id_proceso);
         $this->ATabla[5][valor]  =  $this->responsable_proceso($id_proceso);
         $this->ATabla[8][valor]  =  $id_proceso;
         $this->ATabla[10][valor] =  $this->departamento_codigo();
      
    
         if ( $bandera == 1 ) {
         
                 $idcaso = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia  );
                   
                 $result = $this->div_resultado('editar',$idcaso,1) ;
                 
                 $_SESSION['idcaso'] = $idcaso;


                 $sql = " UPDATE flow.wk_doc_user
                                            SET idcaso=".$this->bd->sqlvalue_inyeccion($idcaso, true)."
                                        WHERE idcaso =".$this->bd->sqlvalue_inyeccion(-1, true).' and 
                                              sesion='.$this->bd->sqlvalue_inyeccion( $this->sesion , true);

                $this->bd->ejecutar($sql);             

               
         }
         
         
         echo $result;
          
     }	
   	
   //---------------
     
  //-----------------------------------
   function pone_tareas( $idcaso, $idproceso  ){
       
        
       $Tramite = $this->bd->query_array('flow.wk_proceso_caso', '*',   'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)   );
       
       $tiempo  = date("H:i:s");
        
       if ( $Tramite['estado'] == 1 ) {
                   
         //--------------- primera tarea solicitada
           $novedad              = 'Requerimiento '.trim($Tramite['caso'])  ;
           $cumple               = 'S';
           $sesion_actual        =   trim($this->sesion ) ;
           $sesion_siguiente     =   trim($this->sesion ) ;
           $id_departamento      =   $Tramite['id_departamento']  ;
           $tipo = 'N'  ;
           
           
           $ATablaTarea = array(
               array( campo => 'idcasotarea',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
               array( campo => 'idproceso',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idproceso, key => 'N'),
               array( campo => 'sesion',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->sesion, key => 'N'),
               array( campo => 'idtarea',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '1', key => 'N'),
               array( campo => 'idcaso',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor =>$idcaso, key => 'N'),
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
           
           /*
           INGRESO DE  USUARIOS PARA ENVIAR LOS CORREOS  
           */
           
           $sql = 'SELECT   id_user_doc, idcaso, fecha, tipo, sesion_actual, hora_in, sesion,  funcionario, cedula,  id_departamento, idusuario
                   FROM     flow.view_proceso_doc_user
                   WHERE    idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true)    ;
                  
            $resultado  = $this->bd->ejecutar($sql);
                   
            $i = 1;
                   
            while ($x=$this->bd->obtener_fila($resultado)){
                       
 
                       $novedad          =   trim($Tramite['caso'])  ;
                       $cumple           =   'N';
                       $sesion_actual    =   $x['sesion_actual']  ;
                       $sesion_siguiente =   $x['sesion_actual']  ;
                       $id_departamento  =   $x['id_departamento']  ;
                       $funcionario      =   $x['funcionario']  ;
                       $tipo             =   $x['tipo']  ;
    
       
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
                       
                       $this->notificacion_email($idcaso,$sesion_actual, $funcionario ,'N');
                       
                       $i =  $i + 1;
                       
                   }
               $caso_tarea = 1;    
       }else {
           $caso_tarea = 0;    
       }
       
       return $caso_tarea;
   }	
   //-------------------
   function pone_requisitos( $idcaso  ){
       
       
       
       $Afolder = $this->bd->query_array('wk_config','carpeta', 'tipo='.$this->bd->sqlvalue_inyeccion(61,true));
    
       $folder = $Afolder['carpeta'];
       
       
       
       $sql = 'SELECT  idcasoreq, idproceso, sesion, idproceso_requi, idcaso, cumple, archivo
                  FROM flow.wk_proceso_casoreq
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and
                        cumple is not NULL'    ;
       
  
       $resultado  = $this->bd->ejecutar($sql);
       
       echo '<script>';
       
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $cobjetos1 = 'cumple_'.trim( $x['idproceso_requi'] );
           
           $cobjetos2 = 'fileArchivo_'.trim( $x['idproceso_requi'] );
           
           $cobjetos3 = 'arc_'.trim( $x['idproceso_requi'] );
            
           $vinculo = 'vinculo_'.trim( $x['idproceso_requi'] );
           
           $cumple  = trim($x['cumple'] );
           $archivo = trim($x['archivo'] );
           
            
           if ($cumple == 'S'){
                echo '$("#'.$cobjetos1.'")'.".prop('checked', true);";
              
           }else{
               echo '$("#'.$cobjetos1.'")'.".prop('checked', false);";
           }
            
       
           
           if ( !empty($archivo)) {
                echo '$("#'.$cobjetos2.'").val("'.$archivo.'");';
                echo '$("#'.$cobjetos3.'").val("'.$archivo.'");';
                
                echo '$("#'.$vinculo.'").attr("href", '.'"'.$folder.$archivo.'"'.');';
 
                
           }
        }
        echo '</script>';
   }
   //---------------
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){
 
            $id_proceso           =  @$_POST['proceso_codigo'];
            $estado               =  @$_POST['estado'];
            
           
            $result='';
            
            if ($estado == '1'){
                    
                    $this->ATabla[2][valor]  =  $this->vencimiento($id_proceso);
                    $this->ATabla[5][valor]  =  $this->responsable_proceso($id_proceso);
                    $this->ATabla[8][valor]  =  $id_proceso;
                    $this->ATabla[10][valor] =  $this->departamento_codigo();
             
                    
                    $_SESSION['idcaso'] = $id;
                   
                     $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                   
                     $sql = " UPDATE flow.wk_doc_user
                     SET idcaso=".$this->bd->sqlvalue_inyeccion($id, true)."
                        WHERE idcaso =".$this->bd->sqlvalue_inyeccion(-1, true).' and 
                            sesion='.$this->bd->sqlvalue_inyeccion( $this->sesion , true);

                   $this->bd->ejecutar($sql);             

  
        	
                     $result = $this->div_resultado('editar',$id,1);
             
            }else {
                
                if ($estado == '2'){
                    
                    $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>ESTADO NO VALIDO PARA EDICION</b>';
                    
                } 
                
               
          
               
            }
 
           echo $result;
    }
    //--------------------------------------------------------------------------------
    //--- APRUEBA Y ENVIA LAS NOTITICACIONES
    //--------------------------------------------------------------------------------
    function Aprobado( $id,$idproceso  ){
  
     
    $para_user = $this->bd->query_array('flow.wk_doc_user', 'count(*) as nn',    'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)  );
   
    if ($id  > 0 )       {  

        if ( $para_user['nn'] > 0 ){
            
                        $dato = $this->pone_tareas( $id, $idproceso  ) ; 
            
                        if ( $dato == 1){
                            
                            $sql = " UPDATE flow.wk_proceso_caso
                                            SET estado =".$this->bd->sqlvalue_inyeccion(3, true).",
                                                sesion_actual=".$this->bd->sqlvalue_inyeccion(trim($this->sesion ), true).",
                                                sesion_siguiente=".$this->bd->sqlvalue_inyeccion('-', true).",
                                                idtareactual=".$this->bd->sqlvalue_inyeccion(2, true)."
                                        WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                            
                            
                            $this->bd->ejecutar($sql);
                            
                            $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> '.$id;
                        
                        }
        
            }else{
            
                $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>NO EXISTE DESTINATARIO ['.$id.']... ADVERTENCIA</b> ';
                
            }
    }else{
            
            $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>GUARDE LA TRASACCION PARA CONTINUAR... ADVERTENCIA</b> ';
            
    }            
  
 
     
        echo $result;
    }
    //--------------------------------------
    function terminado( $id,$idproceso  ){
        
        $fecha      = $this->bd->hoy();
        $timestamp  = date('H:i:s');
        
        
        
        $Tramite = $this->bd->query_array('flow.view_proceso_caso',
            'idtareactual, sesion_actual, autorizado,    sesion_siguiente,estado,
                        caso,sesion_actual, email_actual, nombre_actual, sesion_siguiente, email_siguiente, nombre_siguiente,encuesta',
            'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
        if ( trim( $Tramite['estado']) == '3')     {
            
            $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion( 4, true).",
                                autorizado=".$this->bd->sqlvalue_inyeccion('S', true).",
                                fecha_fina=".$fecha."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
            
            
            $this->bd->ejecutar($sql);
            
            //-------------------------------------
            
            //------------------------------------------------
            // ACTUALIZA TAREA FINALIZAR
            $cumple     = 'S';
            
            
            $novedad    = 'Tarea Finalizada el dia '.$this->hoy .' a las '.$timestamp;
            $idtarea    = $Tramite['idtareactual'];
            
            $sqltarea = "UPDATE flow.wk_proceso_casotarea
        			        SET cumple =".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                finaliza=".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
                                fecha_envio=".$fecha.",
                                hora_fin=".$this->bd->sqlvalue_inyeccion($timestamp, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true). ' and
                               idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and
                               idtarea='.$this->bd->sqlvalue_inyeccion($idtarea, true);
            
            
            
            $this->bd->ejecutar($sqltarea);
            
            //------------------------------------------------------------
            
            $dato = $this->notificacion_email($id,$Tramite['sesion_actual'],$Tramite['nombre_actual'],trim($Tramite['encuesta']));
            
            
            $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> '.$dato;
            
        }else {
            
            $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>PROCESO EN EJECUCION... REVISE LA INFORMACION EN SU BANDEJA</b>';
            
        }
        
        
        
        echo $result;
    }
    //-----------------------------------
    function finalizado( $id,$idproceso  ){
        
        $fecha      = $this->bd->hoy();
        $timestamp  = date('H:i:s');
        
 
 
                $Tramite = $this->bd->query_array('flow.view_proceso_caso',
                    'idtareactual, sesion_actual, autorizado,    sesion_siguiente,estado,
                        caso,sesion_actual, email_actual, nombre_actual, sesion_siguiente, email_siguiente, nombre_siguiente,encuesta',
                    'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
                    );
                
       if ($Tramite['estado'] == '4')     {
                
                $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion(5, true).",
                                autorizado=".$this->bd->sqlvalue_inyeccion('S', true).",
                                fecha_fina=".$fecha." 
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                
                
                $this->bd->ejecutar($sql);
                
                //-------------------------------------
  
                //------------------------------------------------
                // ACTUALIZA TAREA FINALIZAR
                $cumple     = 'S';
              
             
                $novedad    = 'Tarea Finalizada el dia '.$this->hoy .' a las '.$timestamp;
                $idtarea    = $Tramite['idtareactual'];
                
                $sqltarea = "UPDATE flow.wk_proceso_casotarea
        			        SET cumple =".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                finaliza=".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
                                fecha_envio=".$fecha.",
                                hora_fin=".$this->bd->sqlvalue_inyeccion($timestamp, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true). ' and
                               idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and
                               idtarea='.$this->bd->sqlvalue_inyeccion($idtarea, true);
                
             
                
                $this->bd->ejecutar($sqltarea);
                
                //------------------------------------------------------------
                
                $dato = $this->notificacion_email($id,$Tramite['sesion_actual'],$Tramite['nombre_actual'],trim($Tramite['encuesta']));
                
                
                $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> '.$dato;
                
            }else {
                
                $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>PROCESO EN EJECUCION... REVISE LA INFORMACION EN SU BANDEJA</b>';
                
            }
       
        
        
        echo $result;
    }
    //--------------------------------------------------------------------------------
    function vencimiento($id  ){
        
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
    function departamento_codigo( ){
        
        
 
        $Aunidad = $this->bd->query_array('par_usuario',
                                          'id_departamento', 
                                          'email='.$this->bd->sqlvalue_inyeccion(trim($this->sesion),true)
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
    function responsable_proceso($idproceso ){
         
        
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
     
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
         
         $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion(6, true).",
                                autorizado=".$this->bd->sqlvalue_inyeccion('S', true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
         
         
         $this->bd->ejecutar($sql);
         
      
     	$result ='Tramite Anulado satisfactoriamente...';
  
        echo $result;
      
   }
   //-----------------------
   function notificacion_email($idcaso,$email_notifica,$nombre_notifica, $encuesta){
       
             
               $this->mail->_DBconexion(  $this->obj, $this->bd );
               
               $this->mail->_smtp_tramites( );
       
            
               $url = $this->bd->query_array(
                   'flow.view_proceso_caso',
                   ' nombre_solicita, movil_solicita, email_solicita, direccion_solicita,
                     proceso,caso,fecha, fvencimiento, estado,dias_trascurrido,unidad,ambito',
                   'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)
                   );
       
                $asunto = 'Notificacion Nro.Proceso '.$idcaso.'-'.$url['nombre_solicita'];
           
                   if ( trim($url['estado']) == '5'){
                       $idplantilla = -6 ;
                   }else{
                       $idplantilla = -5 ;
                   }
                    
          
                $Contenido = $this->bd->query_array( 'ven_plantilla',   'contenido,   variable', 'id_plantilla='.$this->bd->sqlvalue_inyeccion($idplantilla,true) );
             
            
               $content =  str_replace ( '#NOMBRE' , trim($nombre_notifica) ,  $Contenido['contenido']);
               
               $content =  str_replace ( '#CASO' , $idcaso,  $content);
               
               $content =  str_replace ( '#FECHA' , trim($url['fecha']) ,  $content);
               
               $content =  str_replace ( '#PROCESO' , trim($url['proceso']) ,  $content);
               
               $content =  str_replace ( '#AMBITO' , trim($url['ambito']) ,  $content);
               
               $content =  str_replace ( '#DETALLE' ,trim($url['caso']) ,  $content);
               
               $content =  str_replace ( '#USUARIO' ,trim($url['nombre_solicita']) ,  $content);
               
               $content =  str_replace ( '#DIAS' ,trim($url['dias_trascurrido']) ,  $content);
           
 
               $this->mail->_DeCRM(  $this->sesion, $_SESSION['razon']);
               
               $this->mail->_ParaCRM(trim($email_notifica),trim($nombre_notifica));
                
               $this->mail->_AsuntoCRM($asunto,$content );
               
               $response = 'Enviado';
               
               //$response = $this->mail->_EnviarElectronica();
           
           
           
           return $response;
       
       
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

            $accion    = $_GET['accion'];

            $id        = $_GET['id'];
            
            
            if ($accion == 'aprobado'){
                
                $idproceso = $_GET['idproceso'];
                $gestion->Aprobado($id,$idproceso);
                
            }elseif ($accion == 'finaliza'){
                
                $idproceso = $_GET['idproceso'];
                $gestion->finalizado($id,$idproceso);
                
             }elseif ($accion == 'del'){
                 
                 $gestion->eliminar($id);
                 
             }elseif ($accion == 'terminado'){
                 
                 $gestion->terminado($id,$idproceso);
                 
             }else {
                 
                 $gestion->consultaId($accion,$id);
                 
             }
              
        }  
      
     
     
     
     $action 	    = $_POST["action"];

 
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["idcaso"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>