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
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'inv_importaciones_fac_item';
                 
                $this->secuencia 	     = 'inv_importaciones_fac_item_id_importacionfacitem_seq';
         
            
                $this->ATabla = array(
                	array( campo => 'id_importacionfacitem',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                     array( campo => 'id_importacionfac',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'id_importacion',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                    array( campo => 'idproducto',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'partida',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'cantidad',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'costo',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'peso_item',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'advalorem',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'infa',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'iva',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'salvaguardia',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'aranceles',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                 );
        
               
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
          
          $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
         
          
      	   echo '<script type="text/javascript">accion_item('. $id. ','. "'".$accion."'" .')</script>';
             
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
 			array( campo => 'id_importacionfacitem',   valor => $id,  filtro => 'S',   visor => 'S'),
  	    array( campo => 'idproducto',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'partida',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'peso_item',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'advalorem',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'infa',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'iva',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'salvaguardia',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'aranceles',valor => '-',filtro => 'N', visor => 'S')
   	);
 
          
 	$this->bd->JqueryArrayVisorTab('inv_importaciones_fac_item',$qquery ,'tab3');           
 
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
         
  
         
            $id_importacionfac = trim($_POST["id_importacionfac_key"]);
            
            $id_importacion = trim($_POST["id_importacion_item"]);
         
            $this->ATabla[1][valor] = $id_importacionfac ;
            $this->ATabla[2][valor] = $id_importacion ;
         
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
             'id_importacionfac, id_importacion',
             'id_importacionfacitem='.$this->bd->sqlvalue_inyeccion($id,true)
             );
         
       
         $y= $this->bd->query_array('inv_importaciones_fac',
             'id_movimiento',
             'id_importacionfac='.$this->bd->sqlvalue_inyeccion($x['id_importacionfac'],true)
             );
         
        
         
         if ( $y['nn'] > 0 ){
             
             $result ='No se puede eliminar el registro '. $y['nn'];
             
         }else{
             
             
             $sql = 'delete from inv_importaciones_fac_item where id_importacionfacitem='.$this->bd->sqlvalue_inyeccion($id, true);
             
             $this->bd->ejecutar($sql);
             
             echo '<script type="text/javascript">accion_item('. $id. ','. "'".'eliminado'."',''" .')</script>';
             
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
     if (isset($_POST["action_items"]))	{
        
            $action 	= $_POST["action_items"];
        
            $id 		= $_POST["id_importacionfacitem"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  