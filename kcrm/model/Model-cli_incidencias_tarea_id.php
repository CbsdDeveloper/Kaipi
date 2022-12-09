<?php 
     session_start( );   
  
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
                    array( campo => 'caso',tipo => 'VARCHAR2',id => '0',add => 'S', edit => 'N', valor => '-', key => 'N'),
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
             array( campo => 'secuencia',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'idprov',   valor => '-',  filtro => 'N',   visor => 'S') 
  	);
 	
      	    $_SESSION['idcaso'] = $id;
 	
      	    $datos = $this->bd->JqueryArrayVisorDato('flow.wk_proceso_caso',$qquery );   
            
      	    $razon =  $this->bd->__ciu($datos['idprov']);
             
        
       
            echo '<script>$("#razon").val('."'".$razon."'".');';
            
            echo '$("#sesion_siguiente").val('."'".trim($datos['sesion_siguiente'])."'".');';
            
            echo '$("#estado").val('."'".trim($datos['estado'])."'".');';

            echo '$("#secuencia").val('."'".trim($datos['secuencia'])."'".');';
            
            echo '$("#autorizado").val('."'".trim($datos['autorizado'])."'".');';
            
            echo '$("#idprov").val('."'".trim($datos['idprov'])."'".');';
              
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
          
          
           echo 'document.getElementById("caso").value='.'"'.$string.'"';
             
           echo  ' Ver_doc_prov('.$id.');';
           
            echo '</script>';
            
            
            $accion = 'editar';
             
            $this->pone_variables( $id  );
            
            $this->pone_requisitos( $id  );
              
            $result =  $this->div_resultado($accion,$id,2);
     
        echo  $result;
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
 
   //---------------
   //-------- EDITA VALORES DE LAS VARIABLES
     
   function edicion_variables( $id_proceso, $idcaso ,$proceso_tarea  ){
       
    $sql = "SELECT  variable,orden,tipo,idproceso_var
    FROM flow.wk_proceso_variables
    where  tipo  	<> 'vinculo' and  
           idproceso = ".$this->bd->sqlvalue_inyeccion($id_proceso ,true).' order by orden'    ;


    $resultado  = $this->bd->ejecutar($sql);
    
    while ($x=$this->bd->obtener_fila($resultado)){
        
         $xx = $this->bd->query_array('flow.view_proceso_caso_var',   // TABLA
         'idcaso_var',                        // CAMPOS
         'idcaso='.$this->bd->sqlvalue_inyeccion( $idcaso,true) .' and 
          variable='.$this->bd->sqlvalue_inyeccion(  trim($x['variable']),true) .' and 
          idproceso='.$this->bd->sqlvalue_inyeccion(  $id_proceso ,true)  
         );

      
         

         $yy = $this->bd->query_array('flow.wk_proceso_formulario',   // TABLA
         'acceso',                        // CAMPOS
         'idtarea='.$this->bd->sqlvalue_inyeccion( $proceso_tarea,true) .' and 
           idproceso_var='.$this->bd->sqlvalue_inyeccion( $x['idproceso_var'] ,true)   
         );

        $idcaso_var      =  $xx['idcaso_var'];
        $tipo_variable   =  trim($x['tipo'] );
        $cobjetos        =  'col_'.trim($x['orden']) ;
        $valor           =  $_POST[$cobjetos];

        if (empty( $valor )){
         if (  $tipo_variable=='numerico'){
                 $valor  ='0';
         }elseif( $tipo_variable=='date'){
                 $valor  = date('Y-m-d');
         }elseif( $tipo_variable=='time'){
                 $valor  = date('Y-m-d');
         }else{
                 $valor  = 'N';
         } 
      } 


        if (  $tipo_variable == 'check'){
       
             if (isset( $_POST[$cobjetos])){
                     $valor  ='S';
             } else {
                     $valor  ='N';
             } 
       } 
   

        $this->ATablaVar[1][valor]  =  $id_proceso;
        $this->ATablaVar[2][valor]  =  $idcaso;
        
        $this->ATablaVar[4][valor]  = trim($x['variable'] );
        $this->ATablaVar[5][valor] =  trim($valor);
        $this->ATablaVar[7][valor] =  $x['orden'] ;

         
        
        if ( trim($yy['acceso']) == '2') {

           $this->bd->_UpdateSQL('flow.wk_proceso_caso_var',$this->ATablaVar,$idcaso_var ); 

        }  
      
    }
   }	
 
   //-------------------
   //---------------
   function edicion_requisitos( $id_proceso, $idcaso  ){
       
       
       $sql = 'SELECT  idcasoreq, idproceso, sesion, idproceso_requi, idcaso, cumple, archivo
                  FROM flow.wk_proceso_casoreq
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true)." and
                        coalesce(cumple,'N')    <> 'S' "     ;
       
        
       $resultado  = $this->bd->ejecutar($sql);
       
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $cobjetos1 = 'cumple_'.$x['idproceso_requi'] ;
           $cobjetos2 = 'ver_'.$x['idproceso_requi'] ;
           $cobjetos3 = 'arc_'.$x['idproceso_requi'] ;
           
           
           $idcasoreq = $x['idcasoreq'] ;
           
           
           $valor11 = @$_POST[$cobjetos1];
           $valor2 = @$_POST[$cobjetos2];
           $valor3 = @$_POST[$cobjetos3];
           
           $this->ATablaReq[1][valor]  =  $id_proceso;
           $this->ATablaReq[3][valor]  =  $x['idproceso_requi'];
           $this->ATablaReq[4][valor]  =  $idcaso;
           
           if (isset($valor11)){
               $valor1 = 'S';
           }else{
               $valor1 = 'N';
           }
           
           $this->ATablaReq[1][valor]  =  $id_proceso;
           $this->ATablaReq[3][valor]  =  $x['idproceso_requi'];
           $this->ATablaReq[4][valor]  =  $idcaso;
           $this->ATablaReq[5][valor]  =  $valor1;
           
           if ($valor2 == 'S'){
               $this->ATablaReq[6][valor]  =  $valor3;
           }else{
               $this->ATablaReq[6][valor]  =  '-';
           }
           
           $this->bd->_UpdateSQL('flow.wk_proceso_casoreq',$this->ATablaReq,$idcasoreq); 
           
           
           
 
           
       }
       
       return $sql;
   }
   
   //---------------------------
   
   function _cumple_requisitos(   $idcaso,$tarea_actual  ){
       
       
       $sql = 'SELECT  *
                  FROM flow.view_proceso_caso_requisito
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and
                        idtarea = '.$this->bd->sqlvalue_inyeccion($tarea_actual ,true)    ;
       
       $resultado  = $this->bd->ejecutar($sql);
       
       
       
       $cumple = 'N';
       
       $bandera = 'S';
       
       
       
       
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $archivo = strlen(trim($x['archivo']));
           
           $perfil = trim($x['requisito_perfil']);
           
           if ( $perfil == 'operador' ){
               
               if ( trim($x['obligatorio']) == 'S' ){
                   
                   if ( trim($x['cumple']) == 'S' ){
                       if ( $archivo > 2  ){
                           $cumple = 'S';
                       }else {
                           $cumple = 'N';
                           $bandera = 'X';
                       }
                   }else{
                       $cumple = 'N';
                       $bandera = 'X';
                   }
               }else{
                   if ( trim($x['cumple']) == 'S' ){
                       $cumple = 'S';
                   }else{
                       $cumple = 'N';
                       $bandera = 'X';
                   }
               }
               
           }
           
           
       }
       
       if( $bandera == 'X'){
           $cumple = 'N';
       }
       
       
 
       
       return  $cumple ;
   }
  
   //------------------
   
   function pone_variables( $idcaso  ){
       
 
       
       $sql = 'SELECT  variable, valor,   orden
                  FROM flow.wk_proceso_caso_var
                  where idcaso = '.$this->bd->sqlvalue_inyeccion($idcaso ,true).' and 
                        valor is not NULL order by orden'    ;
       
      
       
       $resultado  = $this->bd->ejecutar($sql);
       
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $cobjetos = 'col_'.trim( $x['orden'] );
           
           $valor = trim($x['valor'] );
           
           if ( $valor == '0'){
               $valor = '0.00';
           }
           
           if ( !empty($valor)) {
               
               echo '<script> $("#'.$cobjetos.'").val("'.$valor.'" ); </script> ';
           }
           
 
       }
   }	
  //-----------------------------------
   
   function _actualiza_tareas( $idcaso, $idproceso, $idtarea,$novedad,$sesion_siguiente,$siguiente ){
       
       $Tramite = $this->bd->query_array('flow.wk_proceso_caso',
                                         'idtareactual, sesion_actual, autorizado,    
                                          sesion_siguiente,caso,estado', 
                                         'idcaso='.$this->bd->sqlvalue_inyeccion($idcaso,true)
                                        );
      
       $timestamp = date('H:i:s');
       
       $fecha =$this->bd->hoy();
 
       
       //--- verifica que no este anulado el tramite...
   
       if ( $Tramite['estado'] <> '6' ) {
           
           $sql = 'SELECT     idtarea,   condicion, siguiente,  notificacion, tipotiempo, tiempo, anterior
                            FROM  flow.wk_procesoflujo
                            where idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso ,true).'  and 
                                  idtarea ='.$this->bd->sqlvalue_inyeccion($idtarea ,true).' 
                            order by idtarea'    ;
           
            
            $resultado  = $this->bd->ejecutar($sql);
            
            while ($x=$this->bd->obtener_fila($resultado)){
               
 
               $cumple    = 'S';
               $condicion = $x['condicion'] ;   
                
               //------------------------------------------------
               // ACTUALIZA TAREA FINALIZAR
               
               $sql = "UPDATE flow.wk_proceso_casotarea
        			        SET cumple =".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                finaliza=".$this->bd->sqlvalue_inyeccion($cumple, true).",
                                novedad=".$this->bd->sqlvalue_inyeccion($novedad, true).",
                                fecha_envio=".$fecha.",
                                sesion_siguiente=".$this->bd->sqlvalue_inyeccion($sesion_siguiente, true).",
                                hora_fin=".$this->bd->sqlvalue_inyeccion($timestamp, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true). ' and 
                               idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and 
                               idtarea='.$this->bd->sqlvalue_inyeccion($idtarea, true);
               
     
               
               $this->bd->ejecutar($sql);
               
               //--------------------------------------------------------------------------------------
               //-------- ACTUALIZA ENVIO DE TAREA  
               
               if ( $siguiente > 0 ) {
                   
                  
                   
                   $sql1 = "UPDATE flow.wk_proceso_casotarea
        			        SET fecha_recepcion=".$fecha.",
                                sesion_actual=".$this->bd->sqlvalue_inyeccion($sesion_siguiente, true).",
                                hora_in=".$this->bd->sqlvalue_inyeccion($timestamp, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true). ' and
                               idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and
                               idtarea='.$this->bd->sqlvalue_inyeccion($siguiente , true);
                   
                   $this->bd->ejecutar($sql1);
                   
                   $caso_tarea = $siguiente;    
                   
                   //--------------------------------------------------------------------------------------
                   //---- verifica si es una tarea condicionada
                   
                   if ( $condicion == 'S'){
                   
                       $sql1 = "UPDATE flow.wk_proceso_casotarea
            			        SET fecha_recepcion=".$fecha.",
                                    fecha_envio=".$fecha.",
                                    hora_in=".$this->bd->sqlvalue_inyeccion($timestamp, true).",
                                    hora_fin=".$this->bd->sqlvalue_inyeccion($timestamp, true).",
                                    novedad=".$this->bd->sqlvalue_inyeccion('Condicion generada por el usuario', true).",
                                    finaliza=".$this->bd->sqlvalue_inyeccion('S', true)."
             				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true). ' and
                                   idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and 
                                   cumple = '.$this->bd->sqlvalue_inyeccion('N', true). '  and 
                                   idtarea < '.$this->bd->sqlvalue_inyeccion($siguiente, true). '  and 
                                   novedad='.$this->bd->sqlvalue_inyeccion('PENDIENTE DE GESTION' , true);
                       
                       $this->bd->ejecutar($sql1);
                   
                   }
               }else {
                   
                   
              
                       $sql1 = "UPDATE flow.wk_proceso_casotarea
                			        SET fecha_recepcion=".$fecha.",
                                        sesion_actual=".$this->bd->sqlvalue_inyeccion($sesion_siguiente, true).",
                                        hora_in=".$this->bd->sqlvalue_inyeccion($timestamp, true)."
                 				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true). ' and
                                       idproceso = '.$this->bd->sqlvalue_inyeccion($idproceso, true). '  and
                                       idtarea='.$this->bd->sqlvalue_inyeccion($x['siguiente'] , true);
                       
                       $caso_tarea = $x['siguiente'] ;    
                       
                       $this->bd->ejecutar($sql1);
                       
                       
               
               }
               
               
           }
           
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
   function agregar_requisitos( $id_proceso, $idcaso  ){
       
      
       
       $sql = 'SELECT  idproceso_requi, requisito, tipo, obligatorio, estado, prioridad
                  FROM flow.wk_proceso_requisitos
                  where idproceso = '.$this->bd->sqlvalue_inyeccion($id_proceso ,true).' order by idproceso_requi'    ;
       
       $resultado  = $this->bd->ejecutar($sql);
       
       while ($x=$this->bd->obtener_fila($resultado)){
           
           $cobjetos1 = 'cumple_'.$x['idproceso_requi'] ;
           $cobjetos2 = 'ver_'.$x['idproceso_requi'] ;
           $cobjetos3 = 'arc_'.$x['idproceso_requi'] ;
           
           $valor1 = @$_POST[$cobjetos1];
           $valor2 = @$_POST[$cobjetos2];
           $valor3 = @$_POST[$cobjetos3];
     
           $this->ATablaReq[1][valor]  =  $id_proceso;
           $this->ATablaReq[3][valor]  =  $x['idproceso_requi'];
           $this->ATablaReq[4][valor]  =  $idcaso;
           $this->ATablaReq[5][valor]  =  $valor1;
            
           if ($valor2 == 'S'){
               $this->ATablaReq[6][valor]  =  $valor3;
           }else{
               $this->ATablaReq[6][valor]  =  '-';
           }
        
      
           $this->bd->_InsertSQL('flow.wk_proceso_casoreq',$this->ATablaReq,'flow.wk_proceso_casoreq_idcasoreq_seq');
           
       }
   }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){
 
            $id_proceso     =  $_POST['codigoproceso'];
            
            $estado         =  $_POST['estado'];
            
            
            $sesion_siguiente = trim($_POST['sesion_siguiente']);
            
            $proceso_tarea  =  $_POST['tarea_actual'];
            
            $timestamp  = date('H:i:s');
            
            $fecha_hoy = date('Y-m-d');

            
             
            if ( $id_proceso > 0 ){
            
                    if ($estado  <>  '5'){
                            
                      
                            $this->ATabla[5][valor]  =  $this->_responsable_proceso($id_proceso);
                            $this->ATabla[8][valor]  =  $id_proceso;
                            $this->ATabla[10][valor] =  $this->_departamento_codigo();
                        
                            
                            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                       	
                          
                            $this->edicion_variables( $id_proceso, $id ,$proceso_tarea  );
                              
                         
                             
                	

                            $sql = " UPDATE flow.wk_proceso_caso
                            SET estado =".$this->bd->sqlvalue_inyeccion(2, true).",
                                sesion_actual=".$this->bd->sqlvalue_inyeccion($this->sesion , true).",
                                sesion_siguiente=".$this->bd->sqlvalue_inyeccion($sesion_siguiente, true).",
                                idtareactual=".$this->bd->sqlvalue_inyeccion(2, true).",
                                modificado=".$this->bd->sqlvalue_inyeccion($fecha_hoy, true).",
                                hmodificado=".$this->bd->sqlvalue_inyeccion( $timestamp , true).",
                                umodificado=".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
                        WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                
  
                         $this->bd->ejecutar($sql);


                            $result = $this->div_resultado('editar',$id,1);
                     
                    }else {
                        
                        $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>ESTADO DEL TRAMITE INVALIDO PARA GESTIONAR</b>';
                  
                    }
            }
            else {
                $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>ESTADO DEL TRAMITE INVALIDO PARA GESTIONAR</b>';
                
            }
           echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- APROBACION DE TRAMITES de registros
    //--- $id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente
    //--------------------------------------------------------------------------------
    
    function Aprobado( $id,$idproceso,$tarea_actual ,$novedad,$sesion_siguiente,$siguiente ){
        
      $bandera = 1;
 
      $cumple =   $this->_cumple_requisitos(   $id  ,$tarea_actual);
 
      $lon = strlen(trim($novedad));
      
      $lon1 = strlen(trim($sesion_siguiente));
      
      //----------------------------------------------------------
      if ( $lon > 15 ){
          $bandera == 0;
      }
      if ( $cumple == 'S'){
          $bandera == 0;
      }
      if ( $sesion_siguiente  > 0 ){
          $bandera == 0;
      }
      
      if ( $lon1 < 5 ){
          $bandera == 0;
      }
      
      if ( $idproceso <= 0 ){
          $bandera == 0;
      }
      //----------------------------------------------------------

      $fecha      = $this->bd->hoy();
      $timestamp  = date('H:i:s');
      $fecha_hoy = date('Y-m-d');

      
      if ( $bandera == 1 ){
          
         $valida_siguiente =  $this->_actualiza_tareas( $id, $idproceso ,$tarea_actual,$novedad,$sesion_siguiente,$siguiente ) ; 
  
       if ( $valida_siguiente >= 1) {
      
                  $Tramite = $this->bd->query_array('flow.view_proceso_caso',
                      'idtareactual, sesion_actual, autorizado, estado,   
                       sesion_siguiente,caso,sesion_actual, email_actual, nombre_actual, 
                       sesion_siguiente, email_siguiente, nombre_siguiente',
                      'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
                      );
                  
                  $estado = $Tramite['estado'];
                  
                  if ( $Tramite['estado'] == '2'){
                      $estado= '3';
                  }
      
                  if ($siguiente == -99){
                      $estado = 4;
                  }else{
                      $estado = 3;
                  }
                  
                  $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion($estado, true).",
                                sesion_actual=".$this->bd->sqlvalue_inyeccion($sesion_siguiente, true).",
                                sesion_siguiente=".$this->bd->sqlvalue_inyeccion('-', true).",
                                idtareactual=".$this->bd->sqlvalue_inyeccion($valida_siguiente, true).",
                                modificado=".$this->bd->sqlvalue_inyeccion($fecha_hoy, true).",
                                hmodificado=".$this->bd->sqlvalue_inyeccion( $timestamp , true).",
                                umodificado=".$this->bd->sqlvalue_inyeccion($this->sesion, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                  
                  
                  $this->bd->ejecutar($sql);
      
                  $dato= '';
                  
                  $dato = $this->notificacion_email($id,$Tramite['email_siguiente'],$Tramite['nombre_siguiente'],'N');
  
                  
                  $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> '.$dato;
         }else {
             
             $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>PROCESO EN EJECUCION... REVISE LA INFORMACION EN SU BANDEJA</b>';
             
         }
      }else {
          
          $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>NO PUEDE CONTINUAR CON EL PROCESO NO CUMPLE LOS REQUISITOS- NO ASIGNO RESPONSABLE</b>';
       
      }

        
        echo $result;
    }
    //--------------------------------------------------------------------------------
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
    function _departamento_codigo( ){
        
        
 
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
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
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
                
                $idproceso        =   $_GET['idproceso'];
                
                $tarea_actual     =   $_GET['tarea_actual'];
                
                $novedad          =   $_GET['novedad'];
                
                $sesion_siguiente =   trim($_GET['sesion_siguiente']);
                
                $siguiente        =   trim($_GET['siguiente']);
                
        
                 $gestion->Aprobado($id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente,$siguiente);
         
     
            }elseif  ($accion == 'anulado'){
                
                $gestion->Anulado($id,$idproceso,$tarea_actual,$novedad,$sesion_siguiente);
                
            }else {
                
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
 
  