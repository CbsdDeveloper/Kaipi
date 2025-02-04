<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
 	$bd	   = 	new Db ;
	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	

	$registro= $_SESSION['ruc_registro'];
      
	$idbodega = $_GET["idbodega"] ;
	
	$query	  =  strtoupper ($_GET["nombre"]) .'%' ;
	
	$codigo = $_GET["codigo"] ;
	
 
 
 
	$sql = "SELECT  idproducto, producto,codigo, saldo
				  FROM web_producto
				  where upper(producto) like ".$bd->sqlvalue_inyeccion($query,true)." AND
                        estado = 'S' and 
                        registro = ".$bd->sqlvalue_inyeccion($registro,true)." AND
                        idbodega = ".$bd->sqlvalue_inyeccion($idbodega,true)."
                  order by producto";
	
 
		    $stmt = $bd->ejecutar($sql);
	
		    echo ' <table  id="tablaItem" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					   <th width="20%">Id Producto</th>
																						<th  width="40%">Descripcion</th>
																						<th width="20%">Codigo</th>
                                                                                        <th width="20%">Saldo</th>
 																						</tr>
																					</thead> ';
		    
		    while ($x=$bd->obtener_fila($stmt)){
		        
 		  
		        $dato =   $x['idproducto'] ;
	 
		        
		                 $enlace = '<a href="#" onclick="goToURLEdita('.$dato.')" >'.trim($x['producto']).'</a>';
		        
            		        
            		        
            		    	echo '  <tr>
                        <td>'.$x['idproducto'].'</td>
                        <td>'.$enlace.'</td>
                        <td>'.trim($x['codigo']).'</td>
                        <td>'.trim($x['saldo']).'</td>
                        </tr>';
		    	
		    	 
		    }
		    
		    echo ' </table>';
 
    
		    pg_free_result($stmt);
    
?>
 
  