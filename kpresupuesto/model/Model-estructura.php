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
      private $perfil;
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
                
                $this->tabla 	  	  = 'presupuesto.pre_estructura';
                
           
                
               $this->ATabla = array(
                    array( campo => 'idpre_estructura',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'anio',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'catalogo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'tipo',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'orden',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
                   array( campo => 'esigef',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
                   array( campo => 'campo',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'etiqueta',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'lista',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'elemento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'N', valor => '-', key => 'N'),
                   array( campo => 'estado',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
                 );
                
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion,$id, $tipo){
            //inicializamos la clase para conectarnos a la bd
      
        
          if ($tipo == 1){
          
              $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';
          
          }else{
                  if ($accion == 'editar')
                      $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ? ( '.$id.' )</b>';
                  if ($accion == 'del')    
                      $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ?( '.$id.' )</b>';
          }
                      
           $datos = array(
                          'resultado' => $resultado,
                          'id' => $id,
                          'accion' => $accion  
           );
              
              
           return $datos;   
 
      }
 

    	      
 //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
 //--------------------------------------------------------------------------------
 function consultaId($accion,$id ){
          
 	
  	
     $qquery = array( 
             array( campo => 'idpre_estructura',  valor =>$id,    filtro => 'S', visor => 'S'),
             array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'catalogo',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'orden',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'esigef',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'campo',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'etiqueta',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'lista',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'elemento',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S')
            );
     
       
           $datos =   $this->bd->JqueryArrayVisorDato('presupuesto.pre_estructura',$qquery );   
           
           header('Content-Type: application/json');
             
           echo json_encode($datos, JSON_FORCE_OBJECT);
 
              
              
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
     	  
          
            $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,$this->secuencia );
        	
           
            $datos = $this->div_resultado('editar',$id, 1) ;
            
            echo json_encode($datos, JSON_FORCE_OBJECT);
   
          
          
     }	
      //---------------------------------------------------
    
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion( $id  ){

           $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
           
           $datos = $this->div_resultado('editar',$id, 1) ;
  
           echo json_encode($datos, JSON_FORCE_OBJECT);
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
        
            $id 			= $_POST["idpre_estructura"];
        
            $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  