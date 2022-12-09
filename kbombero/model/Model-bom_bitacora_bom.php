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
      private $POST;
      private $ATabla;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
  
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);

                $this->hoy 	     =  date('Y-m-d');
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'bomberos.bitacora_bom';
                
                 $this->secuencia 	     = 'bomberos.bitacora_bom_id_bita_bom_seq';
                
                $this->ATabla = array(
                    array( campo => 'id_bita_bom',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'usuario',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'peloton',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'novedad',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fecha_creacion',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => $this->hoy , key => 'N'),
                    array( campo => 'fecha_modificacion',tipo => 'DATE',id => '6',add => 'S', edit => 'S', valor =>$this->hoy , key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $this->sesion , key => 'N'),
                    array( campo => 'estado',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => 'digitado', key => 'N'),
                    array( campo => 'id_departamento',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N')
                );
                
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
      	   
       	   
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
                    array( campo => 'id_bita_bom',   valor =>$id,  filtro => 'S',   visor => 'S'),
                     array( campo => 'usuario',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'peloton',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha_creacion',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'fecha_modificacion',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'id_departamento',valor => '-',filtro => 'N', visor => 'S'),
                    array( campo => 'grafico',valor => '-',filtro => 'N', visor => 'S')
                    );
 
          
            $datos = $this->bd->JqueryArrayVisor('bomberos.bitacora_bom',$qquery );           
 
            $urlimagen = '../../kimages/'.trim($datos['grafico']);
            
            echo '<script type="text/javascript">';
            echo "window.document.getElementById('url').src="."'".$urlimagen."'";
            echo '</script>';
            
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
     	
          
          
             
           // $this->ATabla[1][valor] =  $tipo ;
         
         
        	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
     	    
            //------------ seleccion de periodo
          
        	$result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           
           $result ='No se puede editar el registro';
 
           $estado = trim($_POST["estado"]);
           
           if ( $estado == 'digitado'){
           
            $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
       	
            $result = $this->div_resultado('editar',$id,1);
            
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
   
   function aprobar_tramite($id ){
       
       
      
           $sql = "update ".$this->tabla ." set 
                  estado = ".$this->bd->sqlvalue_inyeccion('autorizado', true).' 
                   WHERE sesion = '.$this->bd->sqlvalue_inyeccion( $this->sesion, true).' and  
                         id_bita_bom='.$this->bd->sqlvalue_inyeccion( $id, true);
           
        
           $this->bd->ejecutar($sql); // EJECUTA SENTENCIA SQL  RETORNA RESULTADO
           
           $result = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
       
       
       
      
       
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
            
            $id        = $_GET['id'];
            
            if ( $accion == 'aprobar'){
                $gestion->aprobar_tramite($id);
            }else{
                $gestion->consultaId($accion,$id);
            }
            
           
            
            
            
            
     }  
  
      //------ grud de datos insercion

     if (isset($_POST["action"]))	{
        
            $action = $_POST["action"];
        
            $id     = $_POST["id_bita_bom"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
 ?>