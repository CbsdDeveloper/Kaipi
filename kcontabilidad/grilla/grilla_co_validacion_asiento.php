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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($cuenta,$ffecha1,$ffecha2){
      
 
              
          $output = $this->Gasto($cuenta,$ffecha1,$ffecha2);
              
 
          
          echo json_encode($output);
      	
      	
      	}
//---------------------------------------
public function Gasto( $fitem,$ffecha1,$ffecha2){
      	    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
 
                                
    
    $sql = "select  id_asiento,cuenta,detalle,debe,haber,partida,item
            FROM view_diario_conta
            where cuenta like ".$this->bd->sqlvalue_inyeccion(trim($fitem) .'%',true)." and  ".$fecha." 
            order by  id_asiento";
 
 
    $output = array();
     
    $resultado1  = $this->bd->ejecutar($sql);
    
     
    while ($fetch=$this->bd->obtener_fila($resultado1)){
        
         
        $output[] = array (
            $fetch['id_asiento'],
            trim($fetch['cuenta']),
             trim($fetch['partida']),
            trim($fetch['item']),
            $fetch['debe'],
            $fetch['haber']
         );
        
    }
 
    
    return $output;
   
}
///--------------------------
public function Gasto_contabilidad( $ffecha1,$ffecha2,$grupo){
    
    
       $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $cuenta_grupo = '213.'.$grupo.'%' ;
        
        $sql = "SELECT credito,    sum(debe) as debe, sum(haber) as haber
                FROM public.view_diario_presupuesto
                where cuenta like ".$this->bd->sqlvalue_inyeccion($cuenta_grupo,true)." 
                      and ".$fecha."
                group by credito 
                order by credito ";
           
        $totales = array();
         
        $resultado  = $this->bd->ejecutar($sql);
        
        $debe  = 0;
        $haber = 0;
        
         while ($xx=$this->bd->obtener_fila($resultado)){
              $debe  = $debe  +  $xx['debe'];
              $haber = $haber +  $xx['haber'];
  
        }
        
        $totales['debe'] =  $debe;
        $totales['haber'] = $haber;
        
        return $totales;
}
//-------------------
   
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
            if (isset($_GET['cuenta']))	{
            
                $cuenta  = $_GET['cuenta'];
            	$ffecha1 = $_GET['ffecha1'];
            	$ffecha2 = $_GET['ffecha2'];
             	 
            	$gestion->BusquedaGrilla(trim($cuenta) ,$ffecha1,$ffecha2);
            	 
            }
 
  
   
 ?>
 
  