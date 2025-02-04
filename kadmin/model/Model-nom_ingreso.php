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
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->tabla 	  	  = 'par_ciu';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
                    array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
                    array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor =>  $this->hoy ,   filtro => 'N',   key => 'N'),
                    array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'N',   edit => 'S',   valor => $this->hoy ,   filtro => 'N',   key => 'N'),
                    array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $this->sesion,   filtro => 'N',   key => 'N'),
                    array( campo => 'serie',   tipo => 'VARCHAR2',   id => '19',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '20',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '21',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'apellido',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'registro',   tipo => 'VARCHAR2',   id => '24',  add => 'S',   edit => 'N',   valor => $this->ruc ,   filtro => 'N',   key => 'N'),
                    array( campo => 'grafico',   tipo => 'VARCHAR2',   id => '25',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'id_banco',   tipo => 'NUMBER',   id => '26',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipo_cta',   tipo => 'VARCHAR2',   id => '27',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cta_banco',   tipo => 'VARCHAR2',   id => '28',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'vivienda',   tipo => 'NUMBER',   id => '29',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'salud',   tipo => 'NUMBER',   id => '30',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'educacion',   tipo => 'NUMBER',   id => '31',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'alimentacion',   tipo => 'NUMBER',   id => '32',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'vestimenta',   tipo => 'NUMBER',   id => '33',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'sifondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
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
         array( campo => 'idprov',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'razon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'direccion',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'telefono',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'correo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'movil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'idciudad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'apellido',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_departamento',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'id_cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'responsable',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'regimen',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'fecha',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'contrato',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'sueldo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargo',   valor => '-',  filtro => 'N',   visor => 'S'),
          array( campo => 'fechan',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nacionalidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'etnia',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'ecivil',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'vivecon',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tsangre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'unidad',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cargas',   valor => '-',  filtro => 'N',   visor => 'S')
                    );
 
          
            $this->bd->JqueryArrayVisor('view_nomina_rol',$qquery );           
 
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
     	
     	
         $nombre   =  $_POST["nombre"];
         $apellido =  $_POST["apellido"];
         
         $id =  trim($_POST["idprov"]);
         
         
           $this->ATabla[1][valor] =  trim($apellido).' '. trim($nombre);
          
        	$this->bd->_InsertSQL($this->tabla,$this->ATabla,'-');
        	
            $this->k_situacion_actual($id );
       
            //------------ seleccion de periodo
          
        	$result = $this->div_resultado('editar',$id,1).'['. $id.']';
   
            echo $result;
          
     }	
      //---------------------------------------------------
     function k_situacion_actual($id ){
          
         
         $sql_movimiento = "SELECT count(*) as movimiento FROM nom_personal  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
         
         $resultado_mov         = $this->bd->ejecutar($sql_movimiento);
         
         $datos_movimiento      = $this->bd->obtener_array( $resultado_mov);
         
         $fecha			        = $this->bd->fecha($_POST["fecha"]);
         
      
         
         if  ($datos_movimiento["movimiento"] == 0){
             
             $sql = "INSERT INTO nom_personal( idprov, id_departamento, id_cargo, responsable, regimen, fecha, contrato, sueldo)
    				VALUES (".
    				$this->bd->sqlvalue_inyeccion( $_POST["idprov"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",".
    				$fecha.",".
    				$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",".
    				$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true).")";
				
    				$this->bd->ejecutar($sql);
         }
         else {
             
             $sql = "UPDATE nom_personal
    			   SET  id_departamento  =".$this->bd->sqlvalue_inyeccion( $_POST["id_departamento"], true).",
    			   		id_cargo         =".$this->bd->sqlvalue_inyeccion( $_POST["id_cargo"], true).",
    					responsable      =".$this->bd->sqlvalue_inyeccion( $_POST["responsable"], true).",
    					regimen          =".$this->bd->sqlvalue_inyeccion( $_POST["regimen"], true).",
    					fecha            =".$fecha.",
    					contrato         =".$this->bd->sqlvalue_inyeccion( $_POST["contrato"], true).",
    					sueldo           =".$this->bd->sqlvalue_inyeccion( $_POST["sueldo"], true)."
     			 WHERE idprov            =".$this->bd->sqlvalue_inyeccion($id, true);
             
             $this->bd->ejecutar($sql);
         }
         
         return  $datos_movimiento["movimiento"];
     }
     ///--------------------------------------------------------
    function k_nom_adicional($id ){
        
         
        $sql_movimiento1 = "SELECT count(*) as movimiento FROM nom_adicional  where idprov =".$this->bd->sqlvalue_inyeccion($id ,true);
         
        $resultado_mov1     = $this->bd->ejecutar($sql_movimiento1);
         
        $datos_movimiento1  = $this->bd->obtener_array( $resultado_mov1);
         
        $fecha			    = $this->bd->fecha(@$_POST["fechan"]);
         
         if  ($datos_movimiento1["movimiento"] == 0){
             
             $sql = "INSERT INTO nom_adicional( idprov,  nacionalidad, etnia, ecivil, vivecon,fechan, tsangre, cargas)
				VALUES (".
				$this->bd->sqlvalue_inyeccion(@$_POST["idprov"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",".
				$fecha.",".
				$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",".
				$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true).")";
				
				
				$this->bd->ejecutar($sql);
         }
         else {
             
             $sql = "UPDATE nom_adicional
			   SET  nacionalidad=".$this->bd->sqlvalue_inyeccion(@$_POST["nacionalidad"], true).",
			   		etnia       =".$this->bd->sqlvalue_inyeccion(@$_POST["etnia"], true).",
					ecivil      =".$this->bd->sqlvalue_inyeccion(@$_POST["ecivil"], true).",
					vivecon     =".$this->bd->sqlvalue_inyeccion(@$_POST["vivecon"], true).",
					fechan      =".$fecha.",
					tsangre     =".$this->bd->sqlvalue_inyeccion(@$_POST["tsangre"], true).",
					cargas      =".$this->bd->sqlvalue_inyeccion(@$_POST["cargas"], true)."
 			 WHERE idprov       =".$this->bd->sqlvalue_inyeccion($id, true);
             
             $this->bd->ejecutar($sql);
             
         }
         
     }
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $nombre   =  $_POST["nombre"];
           
           $apellido =  $_POST["apellido"];
           
           $this->ATabla[1][valor] =  trim($apellido).' '. trim($nombre);
 
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
           $this->k_situacion_actual($id );
           
      
       	
           $result = $this->div_resultado('editar',$id,1).'['. $id.']';
            
     
 
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
        
            $action 	    = $_POST["action"];
        
            $id 			= $_POST["idprov"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  