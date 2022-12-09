<?php 
session_start();   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class Model_tarea_seg01 {
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function Model_tarea_seg01 ( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =  date('Y-m-d');
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'planificacion.sitarea_seg';
                
                 $this->secuencia 	     = 'planificacion.sitarea_seg_idtarea_seg_seq';
                
 

                $this->ATabla = array(
                    array( campo => 'idtarea_seg',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'idtarea',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idpac',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '0', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_tramite',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '0', key => 'N'),
                    array( campo => 'seg_fecha',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'seg_secuencia',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '000000', key => 'N'),
                    array( campo => 'seg_proceso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'seg_estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'seg_tarea_seg',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'sesionm',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'modificacion',tipo => 'DATE',id => '13',add => 'S', edit => 'S', valor =>  $this->hoy, key => 'N'),
                    array( campo => 'seg_solicitado',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
                    array( campo => 'cur_cer',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
                    array( campo => 'cur_dev',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '0', key => 'N'),
                );
 
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
         
       	   
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b>';
                      if ($accion == 'del')    
                          $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b>';
                          
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
                 
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
                    array( campo => 'id_bom_bita',   valor =>$id,  filtro => 'S',   visor => 'S'),
                     array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'denominacion',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'actividad',valor => '-',filtro => 'N', visor => 'S')
                     );
 
 
          
            $this->bd->JqueryArrayVisor('bomberos.bombero_bitacora',$qquery );           
 
            $result =  $this->div_resultado($accion,$id,0);
     
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
     	 
         $tarea             = $_POST["idtarea1"];
         
          
         $seg_comentario    = trim($_POST["seg_tarea_seg1"]);
         
         $modulo            = trim($_POST["seg_proceso1"]);
        
         $datos = $this->bd->__user_tthh($this->sesion);

         $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>MONTO NO VALIDO...</b>';

       

         $this->ATabla[1][valor] =    $_POST["idtarea1"];
         $this->ATabla[5][valor] =    $_POST["seg_fecha1"];
         $this->ATabla[7][valor] =    $_POST["seg_proceso1"];
         $this->ATabla[8][valor] =    $_POST["seg_estado1"];
         $this->ATabla[9][valor] =    $_POST["seg_tarea_seg1"];
                   
         $this->ATabla[3][valor] =  $datos['id_departamento'];

                        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia  );
                    
                        $result = $this->div_resultado('editar',$id,1);
                        
                        $this->ejecuta_proceso_tarea($id, $tarea,$modulo ,$seg_comentario);
                        
                        $this->actualiza_tareas($tarea );
    
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){


            $datos = $this->bd->__user_tthh($this->sesion);

            $this->ATabla[3][valor] =  $datos['id_departamento'];

 
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
       	
            $result = $this->div_resultado('editar',$id,1);
            
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
         
         $this->bd->JqueryDeleteSQL($this->tabla,'id_bom_bita='.$this->bd->sqlvalue_inyeccion($id, true));	
         
     	$result ='<b>DATO ELIMINADO CORRECTAMENTE....</b>';
  
       echo $result;
      
   }
   
   //-----------------
   //----------------------
   function actualiza_tareas($idtarea ){
       
       
       //---------- AVANCE DE TAREA
       $datos_avance = $this->bd->query_array('planificacion.sitarea_seg',
           'sum(avance) as avance,count(*) as subtareas',
           'idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true). " and seg_estado = 'ejecucion' "
           );
       
       $avance_geneeral = $datos_avance['avance'] / $datos_avance['subtareas'] ;
       
       $sql = "UPDATE planificacion.sitarea
               SET     avance=".$this->bd->sqlvalue_inyeccion( $avance_geneeral, true)."
               WHERE idtarea=".$this->bd->sqlvalue_inyeccion($idtarea, true);
       
       $this->bd->ejecutar($sql);
       
       
       //--------------------- avance actividad
       $datos_actividad = $this->bd->query_array('planificacion.sitarea',
           'idactividad',
           'idtarea='.$this->bd->sqlvalue_inyeccion($idtarea,true)
           );
       
       $idactividad =  $datos_actividad['idactividad'];
       
       
       $datos_ejecuta = $this->bd->query_array('planificacion.sitarea',
           'sum(coalesce(avance,0)) as avance, count(*) tareas',
           'idactividad='.$this->bd->sqlvalue_inyeccion($idactividad,true)
           );
       
       $avance_actividad = $datos_ejecuta['avance'] / $datos_ejecuta['tareas'];
       
       
       
       $sql = "UPDATE planificacion.siactividad
  SET     avance=".$this->bd->sqlvalue_inyeccion( $avance_actividad, true)."
  WHERE idactividad=".$this->bd->sqlvalue_inyeccion($idactividad, true);
       
       $this->bd->ejecutar($sql);
       
       
   }
   //--------------------------------------------------------------------
   //-------------------
   function ejecuta_proceso_tarea($idtarea_seg,$idtarea,$modulo ,$seg_comentario){
       
       $datos = $this->bd->query_array('planificacion.sitarea_seg',
           'seg_solicitado, seg_estado,seg_secuencia,seg_tarea_seg,seg_proceso,seg_estado_proceso',
           'idtarea_seg='.$this->bd->sqlvalue_inyeccion($idtarea_seg,true));
       
       
       $datos_modulo = $this->bd->query_array('planificacion.proceso',
           'proceso,valor,secuencia',
           'tipo='.$this->bd->sqlvalue_inyeccion($modulo,true). " and secuencia = '01'"
           );
       
       $seg_estado_proceso = $datos_modulo['proceso'];
       $avance             = $datos_modulo['valor'];
       $monto_solicita     = $datos['seg_solicitado'] ;
       
       
       $input = str_pad($idtarea_seg, 6, "0", STR_PAD_LEFT);
       $anio = date('Y');
       
       $documento = $input.'-'.$anio;
       
       $sqlE = "UPDATE planificacion.sitarea_seg
                        SET     seg_estado=".$this->bd->sqlvalue_inyeccion('ejecucion', true)." ,
                                comentario=".$this->bd->sqlvalue_inyeccion($seg_comentario, true)." ,
                                 seg_secuencia=".$this->bd->sqlvalue_inyeccion($documento, true)." ,
                                seg_estado_proceso=".$this->bd->sqlvalue_inyeccion($seg_estado_proceso, true)." ,
                                sesion_ultima=".$this->bd->sqlvalue_inyeccion( $this->sesion, true)." ,
                                avance=".$this->bd->sqlvalue_inyeccion($avance, true)." ,
                                fecha_ultima=".$this->bd->sqlvalue_inyeccion($this->hoy , true)."
                        WHERE idtarea_seg=".$this->bd->sqlvalue_inyeccion($idtarea_seg, true);
       
       $this->bd->ejecutar($sqlE);
       
       
       $this->Generar_proceso( $idtarea,$idtarea_seg,$modulo,$seg_comentario);
       
       // actualiza saldos a la tarea
       if (  $monto_solicita > 0 )  {
           
           $datos_saldo = $this->bd->query_array('planificacion.sitarea_seg',
               'sum(coalesce(seg_solicitado,0)) as pedido',
               'idtarea='. $this->bd->sqlvalue_inyeccion($idtarea,true). " and seg_estado = 'ejecucion' "
               );
           
           $certificacion = $datos_saldo['pedido'];
           
           $sql = "UPDATE planificacion.sitarea
                                      SET     certificacion=". $this->bd->sqlvalue_inyeccion( $certificacion, true)." ,
                                              disponible=codificado-". $this->bd->sqlvalue_inyeccion($certificacion, true) ."
                                      WHERE idtarea=". $this->bd->sqlvalue_inyeccion($idtarea, true);
           
           $this->bd->ejecutar($sql);
           
       }
       
   }
   
   /*
    genera el recorriddo del proceso...
    */
   function Generar_proceso( $idtarea,$seg_tarease1,$modulo,$comentario){
       
       $sql = "select  *
            from planificacion.proceso
            where tipo = ".$this->bd->sqlvalue_inyeccion($modulo, true). " and estado = 'S'
            order by secuencia";
       
       $stmt1  = $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
       
       
       $tabla = 'planificacion.sitarea_seg_com';
       $secuencia = 'planificacion.sitarea_seg_com_idtarea_segcom_seq';
       
       
       $sesion 	 =  trim($_SESSION['email']);
       $hoy 	     =  date('Y-m-d');
       
       
       $i = 1 ;
       
       while ($fila=$this->bd->obtener_fila($stmt1)){
           
           if ( $i == 1){
               $cumplio= 'S';
               $sesion 	 =  trim($_SESSION['email']);
               $hoy 	     =  date('Y-m-d');
               $tarea_com = $comentario;
           }else    {
               if ( $i == 2){
                   $cumplio= 'N';
               }else{
                   $cumplio= '-';
               }
               $sesion 	 =  '@';
               $hoy 	     =  date('Y-m-d');
               $tarea_com   = 'Pendiente' ;
           }
           
           $proceso_tarea  = trim($fila['proceso']);
           $iddepartamento = trim($fila['id_departamento']);
           $secuencia      = trim($fila['secuencia']);
           
           $ATabla = array(
               array( campo => 'idtarea_segcom',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
               array( campo => 'idtarea_seg',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $seg_tarease1, key => 'N'),
               array( campo => 'tarea_com',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => $tarea_com, key => 'N'),
               array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>  $sesion, key => 'N'),
               array( campo => 'creacion',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor =>$hoy, key => 'N'),
               array( campo => 'cumplio',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $cumplio, key => 'N'),
               array( campo => 'idtarea',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => $idtarea, key => 'N'),
               array( campo => 'proceso_tarea',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $proceso_tarea, key => 'N'),
               array( campo => 'iddepartamento',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor =>  $iddepartamento, key => 'N') ,
               array( campo => 'secuencia',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor =>  $secuencia, key => 'N')
           );
           
           
           $this->bd->_InsertSQL($tabla,$ATabla, $secuencia  );
           
           $i++;
           
       }
       
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new Model_tarea_seg01;
    
 
    //------ poner informacion en los campos del sistema

     if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);
     }  
      

      //------ grud de datos insercion

     if (isset($_POST["action_03"]))	{
        
            $action = $_POST["action_03"];
        
            $id     = $_POST["idtarea_seg1"];
        
           $gestion->xcrud(trim($action),$id );
           
    }         
?>