<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class Model_viatico{
 
 
 
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
      function Model_viatico( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'adm.viatico';
                
                $this->secuencia 	     = 'adm.viatico_id_viatico_seq';
                
                 
                $this->ATabla = array(
                    array( campo => 'id_viatico',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'documento',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'idprov',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'ciudad_comision',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_salida',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_salida',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_llegada',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_llegada',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'servidores',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'motivo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipo_tras1',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nombre_tras1',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'ruta1',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_sa1',tipo => 'DATE',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_sa1',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_sa11',tipo => 'DATE',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_sa11',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipo_tras2',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nombre_tras2',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'ruta2',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_sa2',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_sa2',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_sa22',tipo => 'DATE',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'hora_sa22',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'informe',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => 'AGREGAR', key => 'N'),
                    array( campo => 'fcreacion',tipo => 'DATE',id => '27',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
                    array( campo => 'modificacion',tipo => 'VARCHAR2',id => '28',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
                    array( campo => 'fmodificacion',tipo => 'DATE',id => '29',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'N', valor => 'solicitado', key => 'N'),
                    array( campo => 'productos',tipo => 'VARCHAR2',id => '31',add => 'S', edit => 'S', valor => 'AGREGAR', key => 'N'),
                    array( campo => 'tipo_cuenta',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nro_cuenta',tipo => 'VARCHAR2',id => '33',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'banco',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'id_tarea',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'revisado',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'autorizado',tipo => 'VARCHAR2',id => '37',add => 'S', edit => 'S', valor => '-', key => 'N'),
                );
                
       
                
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion('."'". $id."'". ','. "'".$accion."'" .')</script>';
             
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
                 array( campo => 'id_viatico',   valor => $id,  filtro => 'S',   visor => 'S'),
                 array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'ciudad_comision',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_salida',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_salida',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_llegada',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_llegada',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'servidores',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'motivo',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'tipo_tras1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'nombre_tras1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'ruta1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_sa1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_sa1',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_sa11',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_sa11',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'tipo_tras2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'nombre_tras2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'ruta2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_sa2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_sa2',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'fecha_sa22',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'hora_sa22',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'revisado',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'autorizado',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'informe',valor => '-',filtro => 'N', visor => 'S'),
                array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
                 array( campo => 'productos',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'tipo_cuenta',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'nro_cuenta',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'banco',valor => '-',filtro => 'N', visor => 'S'),
         array( campo => 'id_tarea',valor => '-',filtro => 'N', visor => 'S')
                    );
 
       
     
     
            $datos = $this->bd->JqueryArrayVisor('adm.viatico',$qquery );       
            
             
            $datoss = $this->bd->query_array('planificacion.view_tarea_poa',
                      'codificado ,certificacion, disponible', 
                      'idtarea='.$this->bd->sqlvalue_inyeccion($datos['id_tarea'],true)
                );
            
             
            echo "<script>$('#codificado').val(".$datoss['codificado'].");</script>";
            echo "<script>$('#certificacion').val(".$datoss['certificacion'].");</script>";
            echo "<script>$('#disponible').val(".$datoss['disponible'].");</script>";
            
 
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
     	
     	
    
          
         $id =  $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
         
            //------------ seleccion de periodo
          
        	$result = $this->div_resultado('editar',$id,1).'['. $id.']';
   
            echo $result;
          
     }	
      //---------------------------------------------------
     
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $estado = trim($_POST["estado"]);
           
           if ( $estado == 'solicitado'){
               $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           }
           
             $result = $this->div_resultado('editar',$id,1).'['. $id.']';
                
     
 
           echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
         $sql = "update adm.viatico
                            set estado = 'anulado'
                            where id_viatico =".$this->bd->sqlvalue_inyeccion($id,true)  ;
         
         $this->bd->ejecutar($sql);
         
         $result = '<b>EL TRAMITE FUE ANULADO CON EXITO... A LA UNIDAD DE RESPONSABLE...</b>';
         
         echo $result;
      
   }
   
   function aprobado($id ){
       
        
       $sql = "update adm.viatico
                            set estado = 'enviado'
                            where id_viatico =".$this->bd->sqlvalue_inyeccion($id,true)  ;
       
       $this->bd->ejecutar($sql);
       
       $result = '<b>EL TRAMITE FUE ENVIADO CON EXITO... A LA UNIDAD DE RESPONSABLE...</b>';
       
       echo $result;
       
   }
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new Model_viatico;
    
 
    //------ poner informacion en los campos del sistema
     if (isset($_GET['accion']))	{
            
            $accion    = trim($_GET['accion']);
            
            $id        = $_GET['id'];
            
            if ( $accion == 'autorizado' ){
                $gestion->aprobado($id);
            }
            elseif ( $accion == 'del' ){
                $gestion->eliminar($id);
            }
            else{
                $gestion->consultaId($accion,$id);
            }
           
            
            
            
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["id_viatico"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  