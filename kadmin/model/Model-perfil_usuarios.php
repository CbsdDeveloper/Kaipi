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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
            	$this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_resultado($accion){
            //inicializamos la clase para conectarnos a la bd
                 
          
            echo '<script>location.reload();</script>';
            
            $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b>'; 
 
             
            return $resultado;   
 
      }
  
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion(   ){
       
            $anterior             = @$_POST["anterior"];	
            $clave_anterior 	  = $this->obj->var->_codifica(trim($anterior));
              
            $password = @$_POST["clave"];	
            $clave    = $this->obj->var->_codifica(trim($password));	
             
            
            $url = @$_POST["url"];
            
            $bandera1 = 0;
            $bandera2 = 0;
            
            
            if (!empty($anterior)){
                $bandera1 = 1;   
            }
            if (!empty($password)){
                $bandera2 = 1;
            }
  
            $valida = $bandera1 + $bandera2;
            
            if ( $valida == 2 ){
                
                $clave_valida =   $this->valida_clave( $clave_anterior ) ;
              
              if ($clave_valida == 1){
                 
                          if (strlen($password) >= 6) {
                              $UpdateQuery = array(
                                  array( campo => 'email',   valor => $this->sesion ,  filtro => 'S'),
                                  array( campo => 'clave',       valor => $clave,  filtro => 'N'),
                                  array( campo => 'url',       valor => $url,  filtro => 'N') ,
                                  array( campo => 'tipourl',       valor => 2,  filtro => 'N') 
                               );
                              
                              
                              $this->bd->JqueryUpdateSQL('par_usuario',$UpdateQuery);
                              
                              $result = $this->div_resultado('editar');
                              
                          }else{
                              $result = '<b>LA CLAVE DE ACCESO DEBE TENER AL MENOS 6 CARACTERES</b>';
                          }
                  }else{
                      
                  $result = '<b>LA CLAVE DE ACCESO NO CORRESPONDE A LA REGISTRADA EN EL SISTEMA</b>';
                  
                   }
                
            }else{
                if (strlen($url) >= 6) {
                        $UpdateQuery = array(
                            array( campo => 'email',   valor => $this->sesion ,  filtro => 'S'),
                            array( campo => 'url',       valor =>$url,  filtro => 'N') ,
                            array( campo => 'tipourl',       valor => 2,  filtro => 'N') 
                         );
                        
                        
                        $this->bd->JqueryUpdateSQL('par_usuario',$UpdateQuery);
                        
                        $result = $this->div_resultado('editar');
                   }
            }
 
           echo $result;
    }
//------------------------------------------------------------------
    function valida_clave( $anterior  ){
        
        $AResultado = $this->bd->query_array('par_usuario',
                                             'clave', 
                                             'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
            );
        
        if (trim($anterior) == trim($AResultado["clave"])){
            return 1;
        }else {
            return 0;
        }
        
        
        
    }
 //-------
   
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
            
             
            $gestion->consultaId($accion);
     }  
  
      //------ grud de datos insercion
     if (isset($_POST["action"]))	{
        
            $action = @$_POST["action"];
          
            $gestion->edicion(  );
           
    }      
  
     
   
 ?>
 
  