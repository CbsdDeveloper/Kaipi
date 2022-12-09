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
    
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'wk_config';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'tipo',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'carpeta',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'carpetasub',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'formato',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'registro',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'N',   valor => trim($this->ruc),   filtro => 'N',   key => 'N')
                );
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
      	   
      	   $resultado = '<img src="../../kimages/kfav.png" align="absmiddle" />&nbsp;<b>ACTUALIZANDO INFORMACION</b><br>';
      	         	   
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
 	    array( campo => 'tipo',   valor => $id,  filtro => 'S',   visor => 'S'),
 	    array( campo => 'carpeta',   valor => '-',  filtro => 'N',   visor => 'S'),
 	    array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S'),
 	    array( campo => 'carpetasub',   valor => '-',  filtro => 'N',   visor => 'S'),
 	    array( campo => 'formato',   valor => '-',  filtro => 'N',   visor => 'S'),
 	    array( campo => 'registro',   valor => trim($this->ruc),  filtro => 'S',   visor => 'S')
  	);
 
          
             $this->bd->JqueryArrayVisor('wk_config',$qquery );           
 
            $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
      function Copiar( ){
          
          $sql =  "SELECT a.tipo, a.carpeta, a.modulo, a.carpetasub, a.formato, a.opcion
                    FROM wk_config a
                    join  web_registro b on  a.registro = b.ruc_registro and b. tipo = 'principal'";
          
          $stmt12 = $this->bd->ejecutar($sql);
          
          $result = 'PARAMETROS GENERADOS CORRECTAMENTE';
          
          
          while ($x=$this->bd->obtener_fila($stmt12)){
              
              $y = $this->bd->query_array('wk_config',
                                          'count(*) as nn', 
                                          'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true).' and 
                                           tipo='.$this->bd->sqlvalue_inyeccion($x['tipo'],true)
                                         );
              
              if ( $y['nn'] >  0 ) {
                  
                  $result = 'Codigo ya generado';
                  
              }else {
   
                       $sql_inserta = "INSERT INTO wk_config(
        					           tipo,  carpeta,  modulo, carpetasub, formato, opcion,registro) VALUES ( ".
        					           $this->bd->sqlvalue_inyeccion($x['tipo'], true).",".
        					           $this->bd->sqlvalue_inyeccion($x['carpeta'], true).",".
        					           $this->bd->sqlvalue_inyeccion($x['modulo'], true).",".
        					           $this->bd->sqlvalue_inyeccion($x['carpetasub'], true).",".
        					           $this->bd->sqlvalue_inyeccion($x['formato'], true).",".
        					           $this->bd->sqlvalue_inyeccion($x['opcion'], true).",".
        					           $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
        					                   			                      
        			$this->bd->ejecutar($sql_inserta);
              
              }
 
              
          }
          
          echo $result ;
         
          
      }
     
      
///-----------------      
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
     	
         
            $id =  $this->id_secuencia();
         
            $this->ATabla[0][valor] =  $id;
         
     	
            $this->bd->_InsertSQL($this->tabla,$this->ATabla,$id);
     	    
            //------------ seleccion de periodo
          
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
      
     	$result ='No se puede eliminar el registro';
  
       echo $result;
      
   }
   
   //----------------------
   function id_secuencia(  ){
       
       $AResultado = $this->bd->query_array(
           'wk_config',
           'max(tipo) as secuencia', 
           '1='.$this->bd->sqlvalue_inyeccion('1',true)
           );
       
       return $AResultado['secuencia'] +1;
       
       ;
       
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
            
            if ($accion == 'copiar'){
                
                $gestion->Copiar( );
                
            }else{
                
                $gestion->consultaId($accion,$id);
                
            }
            
            

     }  
  
      //------ grud de datos insercion
      
     
     if (isset($_POST["action"]))	{
        
            $action 	= $_POST["action"];
        
            $id 			= $_POST["tipo"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  