<?php   

//folder-close 
//folder-open

session_start();

require '../../kconfig/Db.class.php';    

require '../../kconfig/Obj.conf.php'; 

 	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
    
    $registro = $_SESSION['ruc_registro'];
 
    $ambito = trim($_POST["ambito"]);
    
    $registro = $_SESSION['ruc_registro'];
    
    if ( $ambito == '-'){
        
        $sql = "SELECT  nombre,
                    idproceso,
                    responsable,
                    completo,
                    id_departamento,
                    depa, fecha, ambito,
                    creado, estado
              FROM flow.view_proceso_publicado
             WHERE registro=".$bd->sqlvalue_inyeccion($registro ,true).
             'ORDER BY estado desc, nombre';
        
        $ambito = '';
        
    }else{
        $sql = "SELECT  nombre,
                    idproceso,
                    responsable,
                    completo,
                    id_departamento,
                    depa, fecha, ambito,
                    creado, estado
              FROM flow.view_proceso_publicado
             WHERE registro=".$bd->sqlvalue_inyeccion($registro ,true).' and
                   ambito='.$bd->sqlvalue_inyeccion($ambito ,true).
                   'ORDER BY estado desc, nombre';
        
        $ambito =  ' - '. strtoupper ($ambito);
    }
 
    
   

    echo '<h4><b>PORTAFOLIO DE PROCESOS APROBADOS  '.$ambito.'</b></h4>';
   
    $stmt_nivel1= $bd->ejecutar($sql);
    
 
  
    
    echo '<div class="panel panel-default">
    <div class="panel-heading"> </div>
    <div class="panel-body"> ';
    
    echo '<table width="100%" style="font-size: 12px"  border="0">';
    
 
    
    while ($x=$bd->obtener_fila($stmt_nivel1)){
    	
    	$bene = trim($x['nombre']);
    	
    	$completo= trim($x['completo']);
    	
    	$depa= trim($x['depa']);
    	
    	$fecha= ($x['fecha']);
    	
    	$razon = ' <a href="#" id="loadproceso"  data-toggle="modal" data-target="#myModal" onClick="goToURL('. $x['idproceso']. ')">('.$completo.')</a>';
       	
    	$estado = trim($x['estado']);
    	
    	if ($estado == 'S'){
    	    $imagen = '../../kimages/m_verde.png';
    	}else {
    	    $imagen = '../../kimages/m_none.png';
    	}
    	
    	
    	
    	echo ' <tr>
				<td width="30%"  align="left" valign="middle">
                <img src="'.$imagen.'"  align="absmiddle">&nbsp;<b>'.$bene.'</b></td>
				<td width="20%">'.$depa.'</td>
				<td width="20%">'.$razon.'</td>
				<td width="5%">'.$x['ambito'].'</td>
		    	<td width="15%">'.$x['creado'].'</td>
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
