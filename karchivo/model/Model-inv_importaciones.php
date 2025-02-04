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
                
                $this->tabla 	  	  = 'inv_importaciones';
 
                
                $this->secuencia 	     = 'inv_importaciones_id_importacion_seq';
         
                $this->ATabla = array(
                	array( campo => 'id_importacion',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'registro',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => $this->ruc  , key => 'N'),
                    array( campo => 'dai',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'distrito',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'regimen',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipodespacho',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tipopago',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nrodespacho',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fechaaceptacion',tipo => 'DATE',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'codigodeclarante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'identificaciondeclarante',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nombredeclarante',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'direcciondeclarante',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'paisprocede',tipo => 'VARCHAR2',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'codigoendoso',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'doctrasporte',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'nrocarga',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'sesion',tipo => 'VARCHAR2',id => '18',add => 'S', edit => 'S', valor =>  $this->sesion , key => 'N'),
                    array( campo => 'creacion',tipo => 'DATE',id => '19',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
                    array( campo => 'cierre',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'fob',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'flete',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'seguro',tipo => 'NUMBER',id => '23',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'aduana',tipo => 'NUMBER',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'items',tipo => 'NUMBER',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'peso',tipo => 'NUMBER',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'unidadfisica',tipo => 'NUMBER',id => '27',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'tributo',tipo => 'NUMBER',id => '28',add => 'S', edit => 'S', valor => '-', key => 'N'),
                    array( campo => 'unidadcomercial',tipo => 'NUMBER',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
                 );
        
               
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
          
          $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
         
          
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
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
 			array( campo => 'id_importacion',   valor => $id,  filtro => 'S',   visor => 'S'),
  	    array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
  	    array( campo => 'dai',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'distrito',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'regimen',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tipodespacho',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tipopago',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nrodespacho',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fechaaceptacion',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'codigodeclarante',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'identificaciondeclarante',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nombredeclarante',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'direcciondeclarante',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'paisprocede',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'codigoendoso',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'doctrasporte',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'nrocarga',valor => '-',filtro => 'N', visor => 'S'),
  	    array( campo => 'cierre',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'fob',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'flete',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'seguro',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'aduana',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'items',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'peso',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'unidadfisica',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'tributo',valor => '-',filtro => 'N', visor => 'S'),
 	    array( campo => 'unidadcomercial',valor => '-',filtro => 'N', visor => 'S')
   	);
 
          
        $this->bd->JqueryArrayVisor('inv_importaciones',$qquery );           
 
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
         
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia);
  
          
        	$result = $this->div_resultado('editar',$id,1);
   
            echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
 
       $estado = trim($_POST["cierre"]);
           
 
       $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
                 
 
 
       
        $result = $this->div_resultado('editar',$id,1);
            
     
    echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     	$result ='No se puede eliminar el registro';
  
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
     if (isset($_POST["action"]))	{
        
            $action 	= $_POST["action"];
        
            $id 		= $_POST["id_importacion"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  