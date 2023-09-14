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
      private $anio;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
                
                $this->anio       =  $_SESSION['anio'];
                
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id_tramite,$festado){
      
      	
      $output = array();
       
       
      $cadena0 =  '  id_tramite = '.$this->bd->sqlvalue_inyeccion(($id_tramite),true).'  and ';
 
 
      $yy = $this->bd->query_array('view_rol_tramite','max(id_rol) as id_rol',
          'id_tramite='.$this->bd->sqlvalue_inyeccion($id_tramite,true));
      
 
      $id_rol =$yy['id_rol'];
      
 
      $xx = $this->bd->query_array('nom_rol_pago','tipo', 
          'id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true));
      
 
      if ( $xx['tipo'] == '0' ){
          $cadena1 = '  tipoformula = '.$this->bd->sqlvalue_inyeccion(('RS'),true) ;
      }
         
      if ( $xx['tipo'] == '1' ){
          $cadena1 = '  tipoformula = '.$this->bd->sqlvalue_inyeccion(('DC'),true) ;
      }
      
      if ( $xx['tipo'] == '2' ){
          $cadena1 = '  tipoformula = '.$this->bd->sqlvalue_inyeccion(('DT'),true) ;
      }
      
	  if ( $xx['tipo'] == '3' ){
          $cadena1 = '  tipoformula in '."('CC','RS','AA')" ;
      }

     
 
    if ( $xx['tipo'] == '4' ){
        $cadena1 = '  tipoformula in '."( 'RS','AA')" ;
      }
      

   

      $where = $cadena0.$cadena1;
      
      $sql = 'SELECT  programa,nombre,clasificador, ingreso
               FROM view_rol_tramite
              where '. $where.' order by  clasificador';
     
     
    
      
      $resultado  = $this->bd->ejecutar($sql);
      
      $output = array();
      
      while ($fetch=$this->bd->obtener_fila($resultado)){
          
          
          $x = $this->bd->query_array('presupuesto.pre_catalogo',
                                      'detalle', 
                                        'codigo='.$this->bd->sqlvalue_inyeccion(trim($fetch['programa']),true). ' and 
                                        tipo='.$this->bd->sqlvalue_inyeccion('catalogo',true). ' and 
                                        categoria='.$this->bd->sqlvalue_inyeccion('programa',true)
              );
          
          
          
          $output[] = array (
              trim($fetch['programa']),
              trim($x['detalle']),
              trim($fetch['nombre']),
              trim($fetch['clasificador']),
              $fetch['ingreso'] 
          );
          
      }
      
      
       
      echo json_encode($output);
      
 }
      	
//------------------ 
 
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
 
          
            //------ consulta grilla de informacion
            if (isset($_GET['id_tramite']))	{
            
                $id_tramite = $_GET['id_tramite'];
                $festado    = $_GET['festado'];
              	 
                $gestion->BusquedaGrilla($id_tramite,$festado);
            	 
            }
  
  
   
 ?>
 
  