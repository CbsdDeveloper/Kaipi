<?php   

//folder-close 
//folder-open
session_start();

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

    $obj   = 	new objects;
	$bd	   =	new Db;	
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
    
    $registro = $_SESSION['ruc_registro'];
    
    $todayh =  getdate();
    $d = $todayh[mday];
    $m = $todayh[mon];
    $y = $todayh[year];
    
    
    if (isset($_POST['idcodigo']))	{
    	$idcodigo= $_POST['idcodigo'] ;
    }
    
    
    $sql = "SELECT fecha,  mes, detalle, sesion,   idprov,   estado_pago, 
				   apagar, dia, sesiona, id_solpagos, solicita, autoriza, 
			       razon, sesionr, revisado,asunto
			  FROM view_pagos
			  where id_solpagos = ".$bd->sqlvalue_inyeccion($idcodigo,true)." and 
					registro = ".$bd->sqlvalue_inyeccion($registro,true) ;
    
   
    $stmt_nivel1= $bd->ejecutar($sql);
    
         
    $total = 0;
    
    while ($x=$bd->obtener_fila($stmt_nivel1)){
    	
    	echo '<div class="alert alert-info" style="padding: 2px">

			  <h5> <img src="../controller/o.png"/> Solicitud '.$x['id_solpagos'].'</h5>  ';
    	
    	echo 'fecha   :&nbsp;'.$x['fecha'].'<br>';
    	
    	echo 'Solicita:&nbsp;'.$x['solicita'].'<br>';
    	
    	echo 'Beneficiario:&nbsp;'.$x['razon'].'<br><br>';
    	
    	echo 'Asunto:&nbsp;'.$x['asunto'].'<br><br>';
    	
    	echo '<hr><b>Detalle solicitud</b>'.'<br>';
    		
    	echo $x['detalle'];
    	
    	$total = number_format($x['apagar'],2,",",".");
    	
    	$id = $x['id_solpagos'];
    }
 
 
    
    $vertramite= '<br><br>'.'<b>Total:&nbsp;&nbsp;'.$total.'</b><br>';
    
    echo $vertramite;
    
    $url = '<a href="#" onClick="goToURL('."'editar',".$id.')"><img src="../controller/a.png"/></a>';
    
    
    echo $url.'</div> <br><br>';
    
       
 ?>
