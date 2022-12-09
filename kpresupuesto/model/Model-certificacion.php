<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $perfil;
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'presupuesto.pre_tramite';
                
                $this->secuencia 	     = 'presupuesto.pre_tramite_id_tramite_seq';
                
                $this->perfil =  $this->bd->__user( $this->sesion );
                
                
                if ($this->perfil['supervisor']  == 'S'){
                    $estado_var ='S';
                }else{
                    $estado_var ='N';
                }
                
                $this->anio       =  $_SESSION['anio'];
                
                $this->ATabla = array(
                    array( campo => 'id_tramite',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc, key => 'N'),
                    array( campo => 'anio',tipo => 'NUMBER',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'mes',tipo => 'NUMBER',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'detalle',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'observacion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'sesion_asigna',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                    array( campo => 'comprobante',tipo => 'VARCHAR2',id => '10',add => 'N', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '11',add => 'S', edit => $estado_var, valor => '-', key => 'N'),
                    array( campo => 'tipo',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'planificado',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_asiento_ref',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'marca',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'solicita',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N') ,
                    array( campo => 'tipocp',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N') 
                 );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo,$visor){
            //inicializamos la clase para conectarnos a la bd
      
        
          echo '<script type="text/javascript">accion('."'". $id."'". ','. "'".$accion."',". $visor.')</script>';
             
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
         array( campo => 'id_tramite',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'sesion_asigna',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'creacion',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'comprobante',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'planificado',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'solicita',valor => '-',filtro => 'N', visor => 'S') ,
         array( campo => 'tipocp',valor => '-',filtro => 'N', visor => 'S') 
            );
     
       
        $dato =  $this->bd->JqueryArrayVisorDato('presupuesto.view_pre_tramite ',$qquery);           
        
        echo '<script>
                  $("#fecha").val('."'".trim($dato["fecha"])."'".') ;
                  $("#detalle").val('."'".trim($dato["detalle"])."'".') ;
                  $("#comprobante").val('."'".trim($dato["comprobante"])."'".') ;
                  $("#estado").val('."'".trim($dato["estado"])."'".') ;
                  $("#documento").val('."'".trim($dato["documento"])."'".') ;
                  $("#id_departamento").val('."'".trim($dato["id_departamento"])."'".') ;
                  $("#planificado").val('."'".trim($dato["planificado"])."'".') ;
                  $("#solicita").val('."'".trim($dato["solicita"])."'".') ;
                  $("#tipocp").val('."'".trim($dato["tipocp"])."'".') ;
              </script>';
        
 
            $result =  $this->div_resultado($accion,$id,0,1);
     
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
     	
     	
           $fecha    = $_POST["fecha"];
           
           $bandera  = 0;
           
           $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ESTADO NO VALIDO... REVISE PORFAVOR ?</b>';
           
           $trozos = explode("-", $fecha,3);
           $anio1  = $trozos[0];
           $mes1   =  (int) $trozos[1];
            
           $estado = $_POST["estado"];
           
           
           $this->ATabla[3][valor] =   $this->anio ;
           
           
           $this->ATabla[4][valor] =  $mes1;
           $this->ATabla[6][valor] = 'Inicio de proceso de adquisicion';
           $this->ATabla[15][valor] =  '0';
          
           
           if ( $estado == '2'){
               $bandera = 1;
           }
           if ( $estado == '1'){
               $bandera = 1;
           }
         
           if ( $anio1   <>  $this->anio ) {
               $bandera = -1;
               $result   = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>PERIODO NO VALIDO... REVISE PORFAVOR PERIODO ?'.$this->anio .'</b>';
           }
           
           if ( $bandera == '1'){
               $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
               $result = $this->div_resultado('editar',$id,1,0).'['. $id.']';
           }
           
   
            echo $result;
          
     }	
      //---------------------------------------------------
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){
           
           
           $x = $this->bd->query_array('presupuesto.pre_tramite',
                                                'fcertifica, fcompromiso, fdevenga,estado', 
                                                'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true)
                                               );
           $bandera = 0;
           
           $fecha  = $_POST["fecha"];
           $estado = $_POST["estado"];
           
           if ( $estado == '4'){
               
               if(empty($x["fcertifica"])) {
                   $bandera = 1;
                   $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>TIENE QUE EMITIR CERTIFICACION?</b>';
               }else{
                   $bandera = 0;
               }
                   
           }
           
           $trozos = explode("-", $fecha,3);
           $anio1  = $trozos[0];
           $mes1   =  (int) $trozos[1];
           
           
           $this->ATabla[3][valor] =  $anio1;
           $this->ATabla[4][valor] =  $mes1;
           $this->ATabla[6][valor] = 'Inicio de proceso de adquisicion';
           $this->ATabla[15][valor] =  '0';
           
            
           if ( $bandera == 0 ){
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
               $result = $this->div_resultado('editar',$id,1,0).'['. $id.'] '.$bandera;
           }
               
          
 
          
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
       echo $result;
      
   }
   //---------
   function liquidacion_certificacion( $id ){
 
 
       
       $y = $this->bd->query_array('presupuesto.pre_tramite',
           'estado',
           'id_tramite='.$this->bd->sqlvalue_inyeccion($id,true) 
           );
       
       
       $comment        = trim($_GET['comment']);
       $id_tramite_det = $_GET['id_tramite_det'];
       $monto1         = $_GET['monto1'];
       $monto2         = $_GET['monto2'];
       
       $len = strlen($comment);
       
       $result = ' Verifique la informacion...(' .$len.')   ' ;
       
       if ( $len > 15 ){
        
           
           
           if ( trim($y['estado']) == '6'  ){
               
               $sql1 = 'UPDATE  presupuesto.pre_tramite_det
                  SET certificado_h = '.$this->bd->sqlvalue_inyeccion( $monto1, true).' ,
                      certificado = '.$this->bd->sqlvalue_inyeccion( $monto2, true).' ,
                      compromiso = '.$this->bd->sqlvalue_inyeccion( $monto2, true).' ,
                      novedad = '.$this->bd->sqlvalue_inyeccion( $comment, true).' 
                  WHERE id_tramite_det = '.$this->bd->sqlvalue_inyeccion( $id_tramite_det, true)  ;
            
                
               
               $this->bd->ejecutar($sql1);
               
               $result ='Registro actualizado... actualizar saldos...';
           }
           
       }
       
       
       
       
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
            
            $accion    = trim($_GET['accion']);
            
            $id        = $_GET['id_tramite'];
            
           
            
            if ($accion == 'liquida'){
                     
                $gestion->liquidacion_certificacion( $id  ); 
                    
            }else{
                $gestion->consultaId($accion,$id);
            }
            
            
            
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_tramite"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  