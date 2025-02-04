<?php 
     session_start( );   
  
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
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
             
               
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
       
          
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA ['.$id.']</b>';
                     
                      
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                   
             }
            
             if ($tipo == 2){
                 
                 $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b> TRANSACCION  SELECCIONADA ['.$id.']</b>';
                  
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
 			array( campo => 'nombre_solicita',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
 	        array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'proceso',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'tarea',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'idtareactual',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'sesion_actual',   valor => '-',  filtro => 'N',   visor => 'S') ,
 	        array( campo => 'unidad_actual',   valor => '-',  filtro => 'N',   visor => 'S') 
  	);
 
 
 	         $_SESSION['idcaso'] = $id;
   	
 	         $datos = $this->bd->JqueryArrayVisorDato('flow.view_proceso_caso',$qquery );   
 	         
          
 	         echo '<script>';
 	         
 	         
 	         echo '$("#idcaso").val('.$id.');';
 	         
 	         echo '$("#unidad").val('."'".trim($datos['unidad'])."'".');';
 	         
 	         echo '$("#proceso").val('."'".trim($datos['proceso'])."'".');';
  	         
 	         echo '$("#estado").val('."'".trim($datos['estado'])."'".');';
  	         
 	         echo '$("#idtareactual").val('."'".trim($datos['idtareactual'])."'".');';
 	         
 	         echo '$("#unidad_actual").val('."'".trim($datos['unidad_actual'])."'".');';
 	         
 	         echo '$("#fecha").val('."'".trim($datos['fecha'])."'".');';
 	         
 	         
  
 	         $string =   trim($datos['caso']);
 	         
 
 	         $string =   str_replace("<br>",'\n',$string);
 	         $string =   str_replace("&nbsp;",' ',$string);
 	         $string = str_replace(array("\r\n", "\r"), "\n", $string);
 	         $string =   trim($string);
 	         $string =   strip_tags($string);
 	         
 	         
 	         $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
 	         $reemplazar=array("", "", "", "");
 	         $string=str_ireplace($buscar,$reemplazar,$string);
 	         
 	         
 	          echo 'document.getElementById("tarea").value='.'"'.$string.'"';
 	         
 	         
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
    
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){
 
            $idcaso               =  @$_POST['idcaso'];
            $estado               =  @$_POST['estado'];
            
            $idtareactual           =  @$_POST['idtareactual'];
            $sesion_actual          =  @$_POST['sesion_actual'];
            $unidad_actual          =  @$_POST['unidad_actual'];
            $result                 =  'NO ACTUALIZA';
             
            $result = $sesion_actual;
            
            $result = '<img src="../../kimages/nogusta.png" align="absmiddle"/>&nbsp;<b>ESTADO NO VALIDO PARA EDICION</b>';
            
            if ($estado <> '5'){
                if ($sesion_actual <> '-'){
                   
                    $sql = " UPDATE flow.wk_proceso_caso
        			        SET sesion_actual=".$this->bd->sqlvalue_inyeccion(trim($sesion_actual), true).",
                                estado = ".$this->bd->sqlvalue_inyeccion(trim($estado), true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true) ;
                    
                    $this->bd->ejecutar($sql);
                    
                    $sql = " UPDATE flow.wk_proceso_casotarea
        			        SET sesion_actual=".$this->bd->sqlvalue_inyeccion(trim($sesion_actual), true).",
                                unidad=".$this->bd->sqlvalue_inyeccion($unidad_actual, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($idcaso, true)." and
                               idtarea=".$this->bd->sqlvalue_inyeccion($idtareactual, true) ;
                    
                    $this->bd->ejecutar($sql);

                    $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                    
                }
            }
             
 
      
         echo $result;
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function aprobado( $id,$idproceso  ){
        
 
 
                  $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion(5, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                  
                  
                  $this->bd->ejecutar($sql);
    
                  
                  $result = '<img src="../../kimages/kfav.png" align="absmiddle"/>&nbsp;<b>PROCESO CON EXITO ['.$id.']... TRAMITE EN SEGUIMIENTO</b> ';
  
        
                 echo $result;
    }
    //-----------------------------------
    function finalizado( $id,$idproceso  ){
        
        
 
 
                $Tramite = $this->bd->query_array('flow.view_proceso_caso',
                    'idtareactual, sesion_actual, autorizado,    sesion_siguiente,estado,
                        caso,sesion_actual, email_actual, nombre_actual, sesion_siguiente, email_siguiente, nombre_siguiente,encuesta',
                    'idcaso='.$this->bd->sqlvalue_inyeccion($id,true)
                    );
                
       if ($Tramite['estado'] == '4')     {
                
                $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion(5, true).",
                                autorizado=".$this->bd->sqlvalue_inyeccion('S', true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
                
                
                $this->bd->ejecutar($sql);
                
                //-------------------------------------
  
                //------------------------------------------------
                // ACTUALIZA TAREA FINALIZAR
                $cumple     = 'S';
                $timestamp  = date('H:i:s');
                $fecha      = $this->bd->hoy();
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
        
        $sql = " UPDATE flow.wk_proceso_caso
        			        SET estado =".$this->bd->sqlvalue_inyeccion(6, true).",
                                autorizado=".$this->bd->sqlvalue_inyeccion('S', true).",
                                sesiona=".$this->bd->sqlvalue_inyeccion($this->sesion, true).",
                                fecha_a=".$this->bd->sqlvalue_inyeccion($this->hoy, true)."
         				 WHERE idcaso =".$this->bd->sqlvalue_inyeccion($id, true);
        
 
        
        $this->bd->ejecutar($sql);
        
        
        $result ='Tramite Anulado satisfactoriamente...';
        
        echo $result;
        
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
                
            }elseif ($accion == 'finaliza') {
        
                $idproceso = $_GET['idproceso'];
                
                $gestion->finalizado($id,$idproceso);
                
            }elseif ($accion == 'del') {
           
                $gestion->eliminar($id);
                
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
 
  