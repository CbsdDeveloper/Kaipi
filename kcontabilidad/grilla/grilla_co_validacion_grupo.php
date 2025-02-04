<?php      
session_start( );   
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
class grilla_co_validacion_grupo{
 
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
      function grilla_co_validacion_grupo( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($ftipo,$ffecha1,$ffecha2){
 
          
          if ( $ftipo == 'G'){
              
            $this->_enlace_gasto( );

            $this->_enlace_gasto_valida( );

              $output = $this->Gasto($ffecha1,$ffecha2);
              
          }
          
          
          if ( $ftipo == 'I'){

            $this->_enlace_ingreso( );
              
              $output = $this->Ingreso($ffecha1,$ffecha2);
              
          }
          
          echo json_encode($output);
      	
 }    
//---------------------------------------
      	function _enlace_gasto( ){
      	    
      	  
              $sql1 = "UPDATE co_asientod
                          SET item      =".$this->bd->sqlvalue_inyeccion('-', true).",
                               partida      =".$this->bd->sqlvalue_inyeccion('-', true)."
                        WHERE  anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true)."  and 
                               cuenta  like ".$this->bd->sqlvalue_inyeccion('112.%', true) ;
    
           $this->bd->ejecutar($sql1);


           $sql = "select item,id_asiento,id_asientod, length(item_valida) ,item_presupuesto
                    from view_diario_presupuesto
                   where tipo_presupuesto = 'G'and cuenta like '213%' and coalesce(length(trim(item_valida)),0)  < 3 ";

                   $resultado  = $this->bd->ejecutar($sql);
    
                   while ($fetch=$this->bd->obtener_fila($resultado)){      
 
                         $item_presupuesto = trim($fetch['item_presupuesto']);
                         $id_asientod      = $fetch['id_asientod'];

                            $sql1 = "UPDATE co_asientod
                                        SET item =".$this->bd->sqlvalue_inyeccion($item_presupuesto, true)."
                                      WHERE  id_asientod = ".$this->bd->sqlvalue_inyeccion( $id_asientod ,true) ;

                          $this->bd->ejecutar($sql1);

                   }
          

      	}
//-----------
function _enlace_gasto_valida( ){
      	    
      	  
    $sql1 = "update presupuesto.pre_tramite
                set fdevenga = null
                where estado = '5' and 
                      fdevenga is not null and  
                      anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true) ;

   $this->bd->ejecutar($sql1);


 $sql = "select id_tramite,fcompromiso,fdevenga 
 from presupuesto.pre_tramite
 where estado = '6' and
       fdevenga < fcompromiso and   
       anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true) ;

         $resultado  = $this->bd->ejecutar($sql);

         while ($fetch=$this->bd->obtener_fila($resultado)){      

            $id_tramite      = $fetch['id_tramite'];

            $x_asiento = $this->bd->query_array('co_asiento',   // TABLA
            'id_asiento,fecha',                        // CAMPOS
            'id_tramite='.$this->bd->sqlvalue_inyeccion( $id_tramite,true)  ." and estado= 'aprobado'"
            );

             
                 $fecha            = trim($x_asiento['fecha']);
 
                  $sql1 = "UPDATE presupuesto.pre_tramite
                              SET fdevenga =".$this->bd->sqlvalue_inyeccion(  $fecha , true)."
                            WHERE  id_tramite = ".$this->bd->sqlvalue_inyeccion( $id_tramite ,true) ;

                $this->bd->ejecutar($sql1);

         }


}          
//----------
function _enlace_ingreso( ){
      	    
      	  
    $sql1 = "select partida
        from view_diario_presupuesto 
        where tipo_presupuesto = 'I' and 
              anio=".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
              coalesce(length(grupo),0)  < 3
        group by partida";


 
         $resultado  = $this->bd->ejecutar($sql1);

         while ($fetch=$this->bd->obtener_fila($resultado)){      

               $item_presupuesto = substr(trim($fetch['partida']),0,6);

               $partida = trim($fetch['partida']);

 
                  $sql1 = "UPDATE co_asientod
                              SET item =".$this->bd->sqlvalue_inyeccion($item_presupuesto, true)."
                            WHERE  partida = ".$this->bd->sqlvalue_inyeccion(  $partida ,true) ;

                $this->bd->ejecutar($sql1);

         }


}          
//---------------------------------------
public function Gasto( $ffecha1,$ffecha2){
      	    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
                                $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
    
                                
    
    $sql = "select tipo_presupuesto, grupo,sum(debe) as debe, sum(haber) as haber
            FROM view_diario_presupuesto
            where partida_enlace = 'gasto' and 
                  debe  <> 0  and  principal = 'S' and 
                  anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
                   ".$fecha." 
            group by  tipo_presupuesto,grupo";
 
 
    
    $output = array();
    
    
    $resultado  = $this->bd->ejecutar($sql);
    
    
    $ok = '<img src="../../kimages/m_verde.png" />';
    $no = '<img src="../../kimages/m_rojo.png"  />';
    
    
    
    while ($fetch=$this->bd->obtener_fila($resultado)){
        
        $grupo_contable = '213.'.trim($fetch['grupo']);
        
        $suma_conta = $this->Gasto_contabilidad( $ffecha1,$ffecha2,trim($fetch['grupo']));
        
        $suma_presu = $this->Gasto_presupuesto( $ffecha1,$ffecha2,trim($fetch['grupo']));
        
        
        $diferencia2 = $fetch['debe'] -  $suma_conta['haber'] ;
        
        $diferencia1 = $suma_conta['debe'] - $suma_presu['debe'] ;
        
        if ( $diferencia2 <> 0 ){
            $valida = $no;
        }else{
            $valida = $ok;
        }
            
        
        if ( $diferencia1 <> 0 ){
            $valida1 = $no;
        }else{
            $valida1 = $ok;
        }
        
        
        
        $saldo = $suma_conta['haber'] - $suma_conta['debe'];
        
        $output[] = array (
            'GASTO',
            $fetch['grupo'],
            $this->bd->_fnumber($fetch['debe']),
            $valida,
            $grupo_contable,
            $this->bd->_fnumber($suma_conta['debe']),
            $this->bd->_fnumber($suma_conta['haber']),
            $this->bd->_fnumber($saldo),
            $valida1,
            $this->bd->_fnumber($suma_presu['debe']),
            $this->bd->_fnumber($diferencia1),
            $this->bd->_fnumber($diferencia2)
        );
        
    }
    
    
    pg_free_result($resultado);
    
    return $output;
   
}
///--------------------------
public function Gasto_contabilidad( $ffecha1,$ffecha2,$grupo){
    
    
       $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
                                   $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $cuenta_grupo = '213.'.$grupo ;
 
        
        if ( $grupo == '97' ){
            
            $sql = "SELECT   subgrupo,  sum(debe) as debe, sum(haber) as haber
                FROM view_diario_conta
                where subgrupo  in  ('213.97','213.98') and 
                      anio  =".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
                      ".$fecha."  
                 group by subgrupo";
            
        }else{
            
            
            $sql = "SELECT  subgrupo,  sum(debe) as debe, sum(haber) as haber
                FROM view_diario_conta
                where subgrupo  = ".$this->bd->sqlvalue_inyeccion($cuenta_grupo,true)."
                      and ".$fecha." and
                      anio  =".$this->bd->sqlvalue_inyeccion($this->anio  ,true)."
                group by subgrupo";
            
            
        }
        
      
        
    
         
   
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
public function Ingreso_contabilidad( $ffecha1,$ffecha2,$grupo){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
                                $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $cuenta_grupo = '113.'.$grupo;
        
        if ( $grupo == '38' ){
            
            $sql = "SELECT  subgrupo,  sum(debe) as debe, sum(haber) as haber
                FROM view_diario_conta
                where trim(subgrupo)  in  ('113.97','113.98')
                      and ".$fecha." and
                      anio  =".$this->bd->sqlvalue_inyeccion($this->anio  ,true)."
                group by subgrupo";
            
          
            
        }else{
            
 
        $sql = "SELECT  subgrupo,  sum(debe) as debe, sum(haber) as haber
                FROM view_diario_conta
                where trim(subgrupo)  = ".$this->bd->sqlvalue_inyeccion(trim($cuenta_grupo),true)."
                      and ".$fecha." and
                      anio  =".$this->bd->sqlvalue_inyeccion($this->anio  ,true)."
                group by subgrupo";
        
 
        }
        
        
       
        
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
public function Gasto_presupuesto( $ffecha1,$ffecha2,$grupo){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
         
        $sql = "SELECT grupo_presupuesto, sum(debe) as debe, sum(haber) as haber
                FROM  view_diario_presupuesto
                where grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($grupo,true)." and 
                        debe   <> 0  and principal = 'N' and 
                      anio  = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
                     ".$fecha."
                group by grupo_presupuesto  order by grupo_presupuesto ";
        
 
 
         
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
//------------------------------------
public function Ingreso_presupuesto( $ffecha1,$ffecha2,$grupo){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
        
        
        $sql = "SELECT grupo_presupuesto, sum(debe) as debe, sum(haber) as haber
                FROM view_diario_presupuesto
                where grupo_presupuesto = ".$this->bd->sqlvalue_inyeccion($grupo,true)." and
                      partida_enlace = '-'  and 
                      anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
                      haber    <>  0   and ".$fecha."
                group by grupo_presupuesto
                order by grupo_presupuesto";
    
 
              
        
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
public function Ingreso( $ffecha1,$ffecha2){
    
    
    $fecha = '( fecha BETWEEN '.$this->bd->sqlvalue_inyeccion($ffecha1,true)." and ".
        $this->bd->sqlvalue_inyeccion($ffecha2,true)." )   ";
      
        
        $sql = "select grupo,
                       sum(debe) as debe, sum(haber) as haber
            FROM  view_diario_presupuesto
            where haber   <> 0 and
                  anio = ".$this->bd->sqlvalue_inyeccion($this->anio  ,true)." and 
                  partida_enlace = 'ingreso' and ".$fecha."
            group by  grupo";
        
         
        $output = array();
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        $ok = '<img src="../../kimages/m_verde.png" />';
        $no = '<img src="../../kimages/m_rojo.png"  />';
        
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            
            if ( trim($fetch['grupo']) == '38' ){
                
                $grupo_contable = '113.98';
                
            }else {
                
                $grupo_contable = '113.'.trim($fetch['grupo']);
                
            }
            
           
            
            
            
            $suma_conta = $this->Ingreso_contabilidad( $ffecha1,$ffecha2,trim($fetch['grupo']));
            
            $suma_presu = $this->Ingreso_presupuesto( $ffecha1,$ffecha2,trim($fetch['grupo']));
            
            
            $diferencia2 = $fetch['haber'] -  $suma_conta['debe'] ;
            
            $diferencia1 = $suma_conta['haber'] - $suma_presu['haber'] ;
            
            if ( $diferencia2 <> 0 ){
                $valida = $no;
            }else{
                $valida = $ok;
            }
            
            
            if ( $diferencia1 <> 0 ){
                $valida1 = $no;
            }else{
                $valida1 = $ok;
            }
            
            $saldo = $suma_conta['debe'] - $suma_conta['haber'];
            
            $output[] = array (
                'INGRESO',
                $fetch['grupo'],
                $this->bd->_fnumber($fetch['haber']),
                $valida,
                $grupo_contable,
                $this->bd->_fnumber($suma_conta['debe']),
                $this->bd->_fnumber($suma_conta['haber']),
                $this->bd->_fnumber($saldo),
                $valida1,
                $this->bd->_fnumber($suma_presu['haber']),
                $this->bd->_fnumber($diferencia1),
                $this->bd->_fnumber($diferencia2)
            );
            
        }
        
        
        pg_free_result($resultado);
        
        return $output;
        
  }
}    
///------------------------------------------------------------------------
 
 
            $gestion   = 	new grilla_co_validacion_grupo;
          
            if (isset($_GET['ftipo']))	{
                $ftipo   = $_GET['ftipo'];
            	$ffecha1 = $_GET['ffecha1'];
            	$ffecha2 = $_GET['ffecha2'];
            	
            	$gestion->BusquedaGrilla($ftipo,$ffecha1,$ffecha2);
            	 
            }
  
  
   
 ?>
 
  