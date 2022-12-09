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
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->tabla 	  	  = 'par_catalogo';
                
                $this->secuencia 	     = '-';
                
                $this->ATabla = array(
                    array( campo => 'idcatalogo',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                    array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'codigo',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'publica',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'secuencia',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'valor1',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'valor2',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'valor3',   tipo => 'NUMBER',   id => '8',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'valor4',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
                    array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N'),
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
                    array( campo => 'idcatalogo',   valor =>$id,  filtro => 'S',   visor => 'S'),
                        array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'nombre',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'publica',   valor => '-',  filtro => 'N',   visor => 'S'),
                        array( campo => 'secuencia',   valor => '-',  filtro => 'N',   visor => 'S') ,
                        array( campo => 'modulo',   valor => '-',  filtro => 'N',   visor => 'S') ,
                        array( campo => 'valor1',   valor => '-',  filtro => 'N',   visor => 'S') ,
                        array( campo => 'valor2',   valor => '-',  filtro => 'N',   visor => 'S') ,
                        array( campo => 'valor3',   valor => '-',  filtro => 'N',   visor => 'S') ,
                        array( campo => 'valor4',   valor => '-',  filtro => 'N',   visor => 'S') 
                    );
 
          
            $this->bd->JqueryArrayVisor('par_catalogo',$qquery );           
 
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
     	
          
         
            $tipo =  trim($_POST["tipo"]);
            
            if  ( $tipo == '-'){
                $tipo =  trim($_POST["nombre"]);
            }
         
            $this->ATabla[1][valor] =  $tipo ;
         
         
        	$id = $this->bd->_InsertSQL($this->tabla,$this->ATabla,'-');
     	    
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
        
            $action = @$_POST["action"];
        
            $id =     @$_POST["idcatalogo"];
        
           $gestion->xcrud(trim($action),$id );
           
    }      
  
     
   
 ?>
 
  