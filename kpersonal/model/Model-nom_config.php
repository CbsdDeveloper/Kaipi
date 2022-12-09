<?php
session_start();   
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
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =     date("Y-m-d");    
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'nom_config';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'id_config',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'estado',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'estructura',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'formula',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cuentai',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'cuentae',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'monto',   tipo => 'NUMBER',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'variable',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'tipoformula',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N')
                );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
       
        
      	   echo '<script type="text/javascript">accion('. $id. ','. "'".$accion."'" .')</script>';
             
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                     $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>'; 
                  if ($accion == 'del')    
                     $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b>'; 
                     
             }
             
             if ($tipo == 1){
                   
                     $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b>'; 
                  
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
         array( campo => 'id_config',   valor => $id,  filtro => 'S',   visor => 'S'),
         array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'estructura',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'formula',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cuentai',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'cuentae',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'monto',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'variable',   valor => '-',  filtro => 'N',   visor => 'S'),
         array( campo => 'tipoformula',   valor => '-',  filtro => 'N',   visor => 'S'),
  
           );
 
          
            $this->bd->JqueryArrayVisor('nom_config',$qquery );           
 
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
     	
            $nombre 	    = $_POST["nombre"];
         
            $variable = str_replace(' ','_',trim($nombre));
 
            $this->ATabla[9][valor] = '$'.$variable;
            
 
        	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,'-');
        	
         	$result = $this->div_resultado('editar',$id,1).'['. $id.']';
   
            echo $result;
          
     }	
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
           
           $nombre 	    = $_POST["nombre"];
           
           $variable = str_replace(' ','_',trim($nombre));
           
           $this->ATabla[9][valor] = '$'.$variable;
           
           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
         	
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
        
            $id 			= $_POST["id_config"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>