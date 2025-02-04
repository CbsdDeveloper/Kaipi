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
                $this->bd	   =		new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['login'];
                
                $this->hoy 	     =  date("Y-m-d");
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
                $this->tabla 	  	  = 'nom_departamento';
                
                $this->secuencia 	     = '-';
                
                $this-> ATabla = array(
                		array( campo => 'id_departamento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
                		array( campo => 'id_departamentos',   tipo => 'VARCHAR2',   id => '1',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                 		array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   visor => 'N',   valor => $this->hoy ,   filtro => 'N',   key => 'N'),
                		array( campo => 'ambito',   tipo => 'VARCHAR2',   id => '3',  add => 'N',   edit => 'N',   visor => 'S',   valor =>  $this->sesion,   filtro => 'N',   key => 'N'),
                		array( campo => 'programa',   tipo => 'VARCHAR2',   id => '4',  add => 'N',   edit => 'N',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                		array( campo => 'techo',   tipo => 'NUMBER',   id => '5',  add => 'N',   edit => 'S',   visor => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                );
                
           
                
}
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
             echo '<script type="text/javascript">';
             echo 'accion("'.$id.'","'.$accion.'")';
             echo '</script>';
            
             if ($tipo == 0){
                
                  if ($accion == 'editar')
                     $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b><br>'; 
                  if ($accion == 'del')    
                     $resultado = '<img src="../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b><br>'; 
                     
             }
             
             if ($tipo == 1){
                   
                     $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b><br>'; 
                  
             }
             
             
            return $resultado;   
 
      }
       
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 
     
 	$qquery = array( 
 	        array( campo => 'id_departamento',   valor => $id,  filtro => 'S',   visor => 'S'),
 			array( campo => 'id_departamentos',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
  			array( campo => 'techo',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'superior',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'ambito',   valor => '-',  filtro => 'N',   visor => 'S'),
 			array( campo => 'programa',   valor => '-',  filtro => 'N',   visor => 'S') 
 	);
 	
 		  $this->bd->JqueryArrayVisorTab('view_unidad_planificacion',$qquery,'-' );           
  
          $result =  $this->div_resultado($accion,$id,0);
     
        echo  $result;
      }	
  
      //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
 
      function xcrud($action,$id,$idQuery){
          
 
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
                 // ------------------  visor
                 if ($action == 'visor'){
                 	
                 	$this->consultaId('editar',$idQuery);
                 	
                 }  
 
     }  
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
     	
     	$result ='-';
   
         echo $result;
          
     }	
   
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion($id  ){
       	
       		
      	 	$id = $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id); 

      	 	$result = $this->div_resultado('editar',$id,1) ;
            
            echo $result;
    }
  
      //--------------------------------------------------------------------------------
      //--- eliminar de registros
      //--------------------------------------------------------------------------------              
     function eliminar($id ){
      
     
       $result = 'No se puede eliminar';
  
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
    
 
 
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action = $_POST["action"];
        
            $id 	= $_POST["id_departamento"];
            
            $idQuery     = $_POST['id'];
        
            $gestion->xcrud(trim($action),$id,$idQuery);
           
    }      
  
     
   
 ?>
 
  