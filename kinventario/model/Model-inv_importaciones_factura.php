<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
      //creamos la variable donde se instanciar la clase "mysql"
 
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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'inv_importaciones_fac';
                 
                $this->secuencia 	     = 'inv_importaciones_fac_id_importacionfac_seq';
         
                $this->ATabla = array(
                	array( campo => 'id_importacionfac',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'id_importacion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'fechafactura',tipo => 'DATE',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor =>$this->ruc , key => 'N'),
                    array( campo => 'factura',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nombre_factura',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'naturaleza',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'iconterm',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'valor',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N') 
                 );
        
               
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
          
          $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
         
          
      	   echo '<script type="text/javascript">accion_factura('. $id. ','. "'".$accion."'" .')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ?</b><br>';
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?</b><br>';
                     
             }
             
             if ($tipo == 1){
                   
                 $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b><br>';
                  
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
 			array( campo => 'id_importacionfac',   valor => $id,  filtro => 'S',   visor => 'S'),
  	    array( campo => 'fechafactura',valor => '-',filtro => 'N', visor => 'S'),
  	    array( campo => 'factura',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nombre_factura',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'naturaleza',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'iconterm',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'valor',valor => '-',filtro => 'N', visor => 'S'),
   	);
 
          
 	$this->bd->JqueryArrayVisorTab('inv_importaciones_fac',$qquery ,'tab3');           
 
        //--------------------------
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
         
         
           $id_importacion = trim($_POST["id_importacion_key"]);
         
            $this->ATabla[1][valor] = $id_importacion ;
         
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
  
          
        	$result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
 
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                 
 
       
        $result = $this->div_resultado('editar',$id,1);
            
     
    echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
 
     
     $x= $this->bd->query_array('inv_importaciones_fac_item',
                                'count(*) as nn', 
                                'id_importacionfac='.$this->bd->sqlvalue_inyeccion($id,true)
         );
         
     if ( $x['nn'] > 0 ){
         
         $result ='No se puede eliminar el registro '. $x['nn'];
          
     }else{
         
 
         $sql = 'delete from inv_importaciones_fac where id_importacionfac='.$this->bd->sqlvalue_inyeccion($id, true);
         
         $this->bd->ejecutar($sql);
         
         echo '<script type="text/javascript">accion_factura('. $id. ','. "'".'eliminado'."'" .')</script>';
         
         $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b> REGISTRO TRANSACCION ELIMINADO</b>';
         
         
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
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
            
            $gestion->consultaId($accion,$id);
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action_factura"]))	{
        
            $action 	= $_POST["action_factura"];
        
            $id 		= $_POST["id_importacionfac"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  