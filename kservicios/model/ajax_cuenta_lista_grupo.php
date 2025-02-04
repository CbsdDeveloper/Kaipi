<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);



$cuenta = $_GET['cuenta'];
$anio   = $_SESSION['anio']  ;
$tipo   = $_GET['tipo'];
 
 
if ( trim($tipo) == '1') {
       
     
    $xx = $bd->query_array('co_plan_ctas',    
        'credito',                     
        'cuenta='.$bd->sqlvalue_inyeccion(trim($cuenta),true).' and 
         anio='.$bd->sqlvalue_inyeccion($anio,true)
        );
   
     
    
     $sql = 'SELECT 
                   detalle,
                   partida
        FROM presupuesto.pre_gestion  
        where grupo ='.$bd->sqlvalue_inyeccion(trim($xx['credito']), true)." and anio = ".$bd->sqlvalue_inyeccion($anio,true)." 
        order by detalle";
 
 
        $stmt1 = $bd->ejecutar($sql);
  
            
               echo '<option value="-"> --- Seleccione Partida --- </option>';
        
                while ($fila=$bd->obtener_fila($stmt1)){
                    
                    echo '<option value="'.$fila['partida'].'">'.trim($fila['partida']).' '. trim($fila['detalle']).'</option>';
                    
                }
        }
 //------------------------------------------------------------------       
        if ( trim($tipo) == '2') {
            
        
            
            $xx = $bd->query_array('presupuesto.pre_gestion',
                'tipo',
                'partida='.$bd->sqlvalue_inyeccion(trim($cuenta),true).' and
                 anio='.$bd->sqlvalue_inyeccion($anio,true)
                );
            
            if ( trim($xx['tipo']) == 'I'){
                $cuenta = substr($cuenta, 0,6).'%';
                $filtro = " '62%' ";
                $campo = "b.credito";
            }else{
                $cuenta = substr($cuenta, 3,6).'%';
                $filtro = " '63%' ";
                $campo = "b.debito";
            }
  
            echo $cuenta;
             
            $sql0 = 'SELECT b.cuenta,
                   b.detalle
        FROM   co_plan_ctas b
        where b.credito like '.$bd->sqlvalue_inyeccion(trim($cuenta), true)." and
              b.anio =".$bd->sqlvalue_inyeccion($anio, true)." and
              b.univel= 'S' and 
              b.tipo_cuenta='F' and 
              b.estado= 'S' and 
              b.cuenta like '124%' union ";
            
            $sql = 'SELECT b.cuenta,
                   b.detalle
        FROM  co_plan_ctas b
        where '.$campo.' like '.$bd->sqlvalue_inyeccion(trim($cuenta), true)." and
              b.anio =".$bd->sqlvalue_inyeccion($anio, true)." and
              b.cuenta like ".$filtro."  and 
              b.estado= 'S' and 
              b.univel= 'S' 
        order by 1";
            
          
            
            $stmt1 = $bd->ejecutar($sql0.$sql);
            
            
            echo '<option value="-"> --- Seleccione Cuenta --- </option>';
            
            while ($fila=$bd->obtener_fila($stmt1)){
                
                echo '<option value="'.$fila['cuenta'].'">'.trim($fila['cuenta']).' '. trim($fila['detalle']).'</option>';
                
            }
        }
 

?>
								
 
 