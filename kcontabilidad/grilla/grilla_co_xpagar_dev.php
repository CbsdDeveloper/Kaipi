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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id_tramite,$festado){
      
      	
      $output = array();
       
      $cadena0 =  '  a.id_tramite = '.$this->bd->sqlvalue_inyeccion(($id_tramite),true).'  and ';
      
      $cadena1 = '  a.estado ='.$this->bd->sqlvalue_inyeccion('6',true)."  and b.univel='S' and  b.debito = a.clasificador ";
      
      
      $where = $cadena0.$cadena1;
      
      $sql = 'SELECT a.partida, a.clasificador, b.cuenta,b.detalle,a.compromiso,a.iva,a.id_tramite_det
               FROM presupuesto.view_dettramites a,  co_plan_ctas b 
              where '. $where.' order by a.clasificador';
      
      
      $resultado  = $this->bd->ejecutar($sql);
      
      $output = array();
      
      while ($fetch=$this->bd->obtener_fila($resultado)){
          
          $output[] = array (
              trim($fetch['partida']),
              trim($fetch['clasificador']),
              trim($fetch['cuenta']),
              trim($fetch['detalle']),
              $fetch['compromiso'],
              $fetch['iva']
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
 
  