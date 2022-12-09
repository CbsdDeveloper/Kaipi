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
    
    
    if (isset($_POST['estado']))	{
    	$estado= $_POST['estado'] ;
    }
    
    
    $sql = "SELECT fecha,  mes, detalle, sesion,   idprov,   estado_pago, 
				   apagar, dia, sesiona, id_solpagos, solicita, autoriza, 
			       razon, sesionr, revisado,asunto
			  FROM view_pagos
			  where estado = ".$bd->sqlvalue_inyeccion($estado,true)." and 
					registro = ".$bd->sqlvalue_inyeccion($registro,true)." and 
					anio = ".$bd->sqlvalue_inyeccion($y,true)."  order by fecha desc";
    
   
    $stmt_nivel1= $bd->ejecutar($sql);
    
    echo '<h5><img src="../controller/r.png"/> Lista Solicitud '.$estado.'</h5>';
    
    echo '<table width="100%" border="0" style="font-size: 10px" cellpadding="0" cellspacing="2">';
    
    $total = 0;
    
    while ($x=$bd->obtener_fila($stmt_nivel1)){
   
    	$bene = trim($x['razon']); 
    	
         	$razon = '<a href="#" onClick="idtramite('. $x['id_solpagos']. ')">'.$bene.'</a>';
    		
		    echo ' <tr>
			      <td width="85%"><img src="../controller/p.png"/> '.$razon.'</td>
			       <td width="15%" align="right" valign="middle">'.trim($x['fecha']).'<br></td>
			    </tr>
			    <tr>
			      <td valign="middle">'.trim($x['asunto']).'</td>
			      <td align="right" valign="middle">'.number_format($x['apagar'],2,",",".").'</td>
			    </tr> 
				 <tr>
			      <td colspan="2" valign="middle">&nbsp;</td>
			    </tr>';
		    $total = $total + $x['apagar'];
		    
    }
    
    $listramite = '<b>'.number_format($total,2,",",".").'</b>';
    
	echo ' <tr>
			      <td width="85%" valign="middle">&nbsp;</td>
			      <td width="15%" align="right" valign="middle" style="font-size: 12px">'.$listramite.'</td>
         </tr>
		</table>';
    
 
    
    
    
    
 
    	
    /*

 
 	  echo '<div class="tree well"> 
				   <ul>';

	echo '  <li> <span><i class="icon-folder-open"></i> Plan de cuentas</span> 
				<ul>';
					   while ($x=$bd->obtener_fila($stmt_nivel1)){
							  $titulo_nivel1 						= trim($x['detalle']);
							  $id_departamento_nivel1   = trim($x['cuenta']);
							  $plan = $id_departamento_nivel1.'-'.$titulo_nivel1;
 							  
							  $evento = 'javascript:goToURLArbol('."'".trim($id_departamento_nivel1)."'".')';
							  
							  echo ' <li> <span><i class="icon-folder-open"></i></span><a href="'.$evento.'">'.$plan.'</a>';
							  if ($nivel <> 1){
 											niveles($id_departamento_nivel1,$bd,$obj,$formulario);
							  }				
							  echo '</li>'; 

					   }  
    echo '  </ul>
				</li>
              </ul>
           </div>';
    */
//---------------------------------------------------------------------------------------------------    
function niveles($idhijo,$bd,$obj,$formulario ){
 
 
$id         = $_SESSION['ruc_registro'];
 
$sql1       = "SELECT count(*) as existe
	             FROM co_plan_ctas  
                WHERE trim(cuentas) ='".trim($idhijo)."' and registro = ".$bd->sqlvalue_inyeccion($id ,true);
 
$resultado1 = $bd->ejecutar($sql1);
	
$datos_valida = $bd->obtener_array( $resultado1);

//echo $datos_valida['existe'];
     
if ($datos_valida['existe'] == 0){
        echo ' ';
}
     else{
		 
        $sql_nivel2 = "SELECT detalle,cuenta,cuentas,nivel,univel
				  FROM co_plan_ctas
				  where trim(cuentas) ='".trim($idhijo)."' and registro = ".$bd->sqlvalue_inyeccion($id ,true).' ORDER BY cuenta';
      
        $stmt_nivel2 = $bd->ejecutar($sql_nivel2);
        
        echo '<ul>'; 
              while ($y=$bd->obtener_fila($stmt_nivel2)){
                     $titulo_nivel2 						= trim($y['detalle']);
	                 $id_departamento_nivel2    = trim($y['cuenta']);
					 $nivel2  									 = $y['nivel'];
					 $ultimonivel 									 = $y['univel'];
                     $plan										 = $id_departamento_nivel2.'-'.$titulo_nivel2;
					 
                     $evento = 'javascript:goToURLArbol('."'".trim($id_departamento_nivel2)."'".')';
                     
                     if ($ultimonivel== 'N'){
                     	$cierre =  '<li> <span><i class="icon-folder-open"></i> </span> <a href="'.$evento.'">'.$plan.'</a>';
					   }else{
					   	$cierre = '<li> <span><i class="icon-edit"></i> </span><a href="'.$evento.'">'.$plan.'</a>';
					   }
					     
					   echo $cierre;
                            niveles($id_departamento_nivel2,$bd,$obj,$formulario,$set);
                      echo '</li>';  
                      
              }             
              echo '</ul>';
     }
 	  
   }    
 ?>
