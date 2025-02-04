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
      function div_resultado($accion,$id,$tipo){
            //inicializamos la clase para conectarnos a la bd
           
         
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
 
     
      //--------------------------------------------------------------------------------
      //--- edicion de registros
      //--------------------------------------------------------------------------------              
       function edicion(   ){
 
         
           
           $sql = "SELECT tipo, carpeta, modulo, carpetasub
                    FROM  wk_config
                     where opcion = 'firmas'  ";
           
           
           $stmt = $this->bd->ejecutar($sql);
           
           while ($x=$this->bd->obtener_fila($stmt)){
               
               $tipo    =    $x['tipo'] ;
               
               $cuenta1 = @$_POST['c1-'.$tipo];
               $cuenta2 = @$_POST['c2-'.$tipo];
               $cuenta3 = @$_POST['c3-'.$tipo];
               
               $UpdateQuery = array(
                   array( campo => 'tipo',   valor => $tipo ,  filtro => 'S'),
                   array( campo => 'carpeta',   valor => trim($cuenta1),  filtro => 'N'),
                   array( campo => 'modulo',      valor => trim($cuenta2),  filtro => 'N'),
                   array( campo => 'carpetasub',       valor => trim($cuenta3),  filtro => 'N')  ,
               );
               
 
               
               $this->bd->JqueryUpdateSQL('wk_config',$UpdateQuery);
 
              
               
           }
           
 
 
             
          $result = $this->div_resultado('editar',$id,1);
            
     
 
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
        
         
           $gestion->edicion( );
           
    }      
  
     
   
 ?>
 
  