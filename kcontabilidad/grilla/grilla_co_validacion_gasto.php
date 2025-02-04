<?php 
     session_start( );   
   require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
   require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class grilla_co_validacion_gasto{
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function grilla_co_validacion_gasto( ){
      
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($fitem,$tipo,$ffecha1,$ffecha2,$tipo_cta){
      
          
          if ( $tipo == 'GASTO'){
              
              $output = $this->Gasto($fitem,$ffecha1,$ffecha2,$tipo_cta);
              
          }
          
          
          if ( $tipo == 'INGRESO'){
              
              $output = $this->Ingreso($fitem,$ffecha1,$ffecha2,$tipo_cta);
              
          }
          
          echo json_encode($output);
      	
      	
      	}
//---------------------------------------
public function Gasto( $fitem,$ffecha1,$ffecha2,$tipo_cta){
      	    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
                                $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
    

    if ( $tipo_cta == '2'){
        
                                    $sql = "select item_presupuesto,cuenta_superior as cuenta,  sum(debe) as devengado
                                    FROM view_diario_presupuesto
                                   WHERE grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($fitem,true)." and
                                        principal = 'S' and   debe <> 0  and 
                                        partida_enlace = 'gasto' and ".$fecha." 
                                  group by  item_presupuesto,cuenta_superior";

                                
                        
       }else{
                        
                            $sql = "select item_presupuesto,cuenta,sum(debe) as devengado
                            FROM public.view_diario_presupuesto
                            where grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($fitem,true)." and 
                                principal = 'S' and   debe <> 0  and 
                                partida_enlace = 'gasto' and ".$fecha." 
                            group by  item_presupuesto,cuenta";

                        
        }
    
     
 
    $output = array();
     
    $resultado  = $this->bd->ejecutar($sql);
    
     
    while ($fetch=$this->bd->obtener_fila($resultado)){
          
        $output[] = array (
            trim($fetch['item_presupuesto']),
            trim($fetch['cuenta']),
            trim($fetch['devengado']),
        );
        
    }
    
    
    pg_free_result($resultado);
    
    return $output;
   
}
//-------------------
public function Ingreso_contabilidad( $ffecha1,$ffecha2,$grupo){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $cuenta_grupo = '113.'.$grupo.'%' ;
        
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
///--------------------------
//------------------------------------
public function Ingreso_presupuesto( $ffecha1,$ffecha2,$grupo){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $sql = "SELECT grupo_presupuesto, sum(debe) as debe, sum(haber) as haber
                FROM public.view_diario_presupuesto
                where grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($grupo,true)." and
                      tipo_presupuesto = 'I' and 
                      haber   <> 0 and partida_enlace = '-' and ".$fecha."
                group by grupo_presupuesto
                order by grupo_presupuesto ";
    
           $totales = array();
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $debe  = 0;
        $haber = 0;
        
        while ($xy=$this->bd->obtener_fila($resultado)){
            $debe  = $debe  +  $xy['debe'];
            $haber = $haber +  $xy['haber'];
            
        }
        $totales['debe'] =  $debe;
        $totales['haber'] = $haber;
        
        return $totales;
}
//----------------------------
public function Ingreso($fitem, $ffecha1,$ffecha2,$tipo_cta){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
      

        if ( $tipo_cta == '2'){
        
            $sql = "select item_presupuesto as item,cuenta_superior as cuenta,  sum(haber) as devengado
            FROM view_diario_presupuesto
           WHERE tipo_presupuesto = 'I' and
                 grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($fitem,true)." and
                 haber   <> 0 and
                 partida_enlace = 'ingreso' and ".$fecha."
          group by  item_presupuesto,cuenta_superior";

        }else{

            $sql = "select item_presupuesto as item,cuenta,  sum(haber) as devengado
            FROM view_diario_presupuesto
           WHERE tipo_presupuesto = 'I' and
                 grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($fitem,true)." and
                 haber   <> 0 and
                 partida_enlace = 'ingreso' and ".$fecha."
          group by  item_presupuesto,cuenta";

        }
      
        
 
        
        $output = array();
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
           
        while ($fetch=$this->bd->obtener_fila($resultado)){
             
 
            $output[] = array (
                 trim($fetch['item']),
                 trim($fetch['cuenta']),
                 trim($fetch['devengado']) 
            );
            
        }
        
        
        pg_free_result($resultado);
        
        return $output;
        
}
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new grilla_co_validacion_gasto;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['fitem']))	{
            
                $fitem    = $_GET['fitem'];
                $tipo     = $_GET['tipo'];
            	$ffecha1  = $_GET['ffecha1'];
            	$ffecha2  = $_GET['ffecha2'];
                $tipo_cta = $_GET['tipo_cta'];
             	 
            	$gestion->BusquedaGrilla($fitem,$tipo,$ffecha1,$ffecha2,$tipo_cta);
            	 
            }
 
  
   
 ?>
 
  