<?php   

//folder-close 
//folder-open
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $registro = $_SESSION['ruc_registro'];
    
    $todayh =  getdate();
    $d = $todayh[mday];
    $m = $todayh[mon];
    $y = $todayh[year];
    
 
    
    $sql = "SELECT  nombre, 
                    idproceso, 
                    responsable,
                    completo,
                    id_departamento, 
                    depa, fecha, ambito, 
                    creado
              FROM view_proceso_publicado";

 
   
    $stmt_nivel1= $bd->ejecutar($sql);
    
    echo '<h4><b>PORTAFOLIO DE PROCESOS</b></h4>';
  
    
    echo '<div class="panel panel-default">
    <div class="panel-heading"> </div>
    <div class="panel-body"> ';
    
    echo '<table width="100%" style="font-size: 12px"  border="0">';
    
    $total = 0;
    
    while ($x=$bd->obtener_fila($stmt_nivel1)){
    	
    	$bene = trim($x['nombre']);
    	
    	$completo= trim($x['completo']);
    	
    	$depa= trim($x['depa']);
    	
    	$fecha= ($x['fecha']);
    	
    	$razon = ' <a href="#" id="loadproceso"  data-toggle="modal" data-target="#myModal" onClick="goToURL('. $x['idproceso']. ')">('.$completo.')</a>';
       	
    	echo ' <tr>
				<td width="30%"  align="left" valign="middle">
                <img src="../controller/icon.trigger.png"/  align="absmiddle">&nbsp;<b>'.$bene.'</b></td>
				<td width="20%">'.$depa.'</td>
				<td width="20%">'.$razon.'</td>
				<td width="10%">'.$x['ambito'].'</td>
		    	<td width="10%">'.$x['creado'].'</td>
				<td width="10%">'.$fecha.'</td>
		    	</tr>
				<tr>
			      <td colspan="6">&nbsp;</td>
			    </tr>
		    	  ';
    	
    }
    
     
    
    echo '</table>';
    
    echo '</div>
    </div>';
    
    
    
    
   
 
  
 ?>
