<?php 
 session_start(); 

 require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 
 require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
 
 require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	
  
    $bd	   =	 	new Db ;
   
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
  
  
 
        $x = $bd->query_array('view_anexos_compras',   // TABLA
        'sum(baseimponible) baseimponible,
         sum(baseimpgrav) baseimpgrav,
         sum(montoiva) montoiva, 
         coalesce(sum( valorretbienes),0) as bienes,
         coalesce(sum( valorretservicios),0) + coalesce(sum( valretserv100),0)  as servicios',                        // CAMPOS
        'id_tramite='.$bd->sqlvalue_inyeccion($_GET['idtramite'],true)." and estado = 'S' "
        );

     
     
        $sql_dato = "select a.tiporetencion ,a.codretair,coalesce(sum( a.valretair),0) retencion,coalesce(sum( a.baseimpair),0) as base
                    from view_anexos_fuente a , 
                         view_anexos_compras b
                    where a.id_compras = b.id_compras and 
                          b.estado = 'S' and 
                          b.id_tramite =".$bd->sqlvalue_inyeccion($_GET['idtramite'],true).'
                    group by a.tiporetencion ,a.codretair';
        
                    $resultado  = $bd->ejecutar($sql_dato);

                                 

     
    echo '<div class="col-md-2" style="padding: 10px">';
        
        echo ' BASE TARIFA CERO   : <br>';
        echo ' BASE IMPONIBLE 12% : <br>';
        echo ' MONTO IVA : <br>';
    
    echo '</div>';
    
    echo '<div class="col-md-2" style="padding: 10px">';
    
    echo  number_format($x['baseimponible'],2).'<br>';
    echo  number_format($x['baseimpgrav'],2).'<br>';
    echo  number_format($x['montoiva'],2).'<br>';
    
    echo '</div>';
    
    echo '<div class="col-md-2" style="padding: 10px">';
    
    echo ' RETENCION IVA BIENES  : <br>';
    echo ' RETENCION IVA SERVICIOS  : <br>';
     
    echo '</div>';
    
    echo '<div class="col-md-2" style="padding: 10px">';
    
    echo  number_format($x['bienes'],2).'<br>';
    echo  number_format($x['servicios'],2).'<br>';
     
    echo '</div>';
    
    echo '<div class="col-md-6" style="padding: 10px">';
         
    while ($y=$bd->obtener_fila($resultado)){
        
        echo ' RETENCION       : '.$y['tiporetencion'] .'<br>';
        echo ' BASE RETENCION  : '.$y['base'] .'<br>';
        echo ' MONTO RETENCION : '.$y['retencion'] .'<br><br>';
 
        
    }      
	 
    echo '</div>';
      
 	 
?>