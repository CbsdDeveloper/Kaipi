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
  
 

    echo "<h4>RESUMEN POR RESPONSABLES<br>"."</h4>";
  
    
    $sqlO2= "select responsable , nombre_funcionario, producto_actividad,id_departamento,
					sum(inicial) as inicial, sum(codificado) as codificado, count(*) as tareas
					from planificacion.view_tarea_poa  
					where anio= ".$bd->sqlvalue_inyeccion($Q_IDPERIODO,true)." and 
						  estado= 'S'    
					group by responsable,nombre_funcionario,id_departamento,producto_actividad   order by nombre_funcionario";

                  

	 
    
    $stmt_TA = $bd->ejecutar($sqlO2);
    
    
    echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Identificacion</td>
      <td class="derecha" width="60%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Responsable Tarea</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Actividades Asignadas</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Inicial ($)</td>
      <td class="derecha" width="15%" style="text-align: center;padding: 5px" valign="top"  bgcolor="#A5CAE1">Codificado ($)</td></tr>';
    
    $numero3  = 1; 

   

	$codificado1 = 0;
    $ejecutado1 = 0;

    while ($z=$bd->obtener_fila($stmt_TA)){
        
        //$idtarea            = $z['idtarea'];
        $responsable = trim($z['responsable']);
        $nombre_funcionario              = trim($z['nombre_funcionario']);

        $producto_actividad              = trim($z['tareas']);
 
        $codificado         = number_format($z['inicial'],2,".",",");
        $ejecutado          = number_format($z['codificado'] ,2,".",",");
      
        $AUnidad = $bd->query_array('nom_departamento',
        'nombre',
        'id_departamento = '.$bd->sqlvalue_inyeccion( $z['id_departamento'] ,true)
        );
    
        
        echo '<tr>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">' .$responsable.'</td>
               <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px"><b>'.$nombre_funcionario.'</b><br>'.  trim($AUnidad['nombre']) .'</td>
              <td class="filasupe" valign="top" style="font-size: 10px;padding: 5px">'.$producto_actividad.'</td>
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
								
 
 
 