<?php session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/


$obj   = 	new objects;
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

$Q_IDUNIDAD= $_GET['Q_IDUNIDAD'];

$Q_IDPERIODO = $_GET['Q_IDPERIODO'];


$estado1   = 'S';
  
 

    echo "<h4>RESUMEN DE OBJETIVOS  ESTRATEGICOS<br>"."</h4>";
  
    
    $sqlO2= "select  a.id_departamento , a.idobjetivo , b.objetivo , b.objetivoe ,
					sum(a.inicial) as inicial, sum(a.codificado) as codificado
					from planificacion.view_tarea_poa a, planificacion.view_oe_oo b
					where a.anio= ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)." and 
						  a.idobjetivo = b.idobjetivo and
						  a.anio = b.anio and 
						  a.estado= 'S'    
					group by a.id_departamento , a.idobjetivo ,b.objetivo, b.objetivoe";
	
	 
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Unidad Ejecutora</td>
      <td class="derecha" width="20%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Objetivo Estrategico</td>
      <td class="derecha" width="30%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Objetivo Operativo</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Inicial ($)</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Codificado ($)</td></tr>';
    
    $numero3  = 1;

	$codificado1 = 0;
    $ejecutado1 = 0;

    while ($z=$bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $objetivoe = trim($z['objetivoe']);
        $objetivo              = trim($z['objetivo']);

        $unidad              = trim($z['id_departamento']);
 
        $codificado         = number_format($z['inicial'],2,".",",");
        $ejecutado          = number_format($z['codificado'] ,2,".",",");
      
        

        $AUnidad = $bd->query_array('nom_departamento',
        'nombre',
        'id_departamento = '.$bd->sqlvalue_inyeccion( $unidad  ,true)
        );
    
       
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.trim($AUnidad['nombre']).'</td>
               <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.$objetivoe.'</td>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.$objetivo.'</td>
               <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.$codificado.'</td>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.$ejecutado.'</td>
             </tr>';
        
			 $codificado1 =   $codificado1 + $z['inicial'];
			 $ejecutado1 =  $ejecutado1 + $z['codificado'] ;

        $numero3 ++;
    }
    

	echo '<tr>
    <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"> </td>
	<td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"> </td>
   <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"> TOTAL</td>
	<td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.number_format($codificado1,2).'</td>
   <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px;text-align: right">'.number_format($ejecutado1,2).'</td>
  </tr>';
    
    echo '</table>';

?>
								
 
 
 