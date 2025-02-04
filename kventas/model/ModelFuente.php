 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = new Db ;
	$registro= $_SESSION['ruc_registro'];
	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    $codigo	=	$_GET["codigoAux"];
    $base	=	$_GET["baseimpair"];
    
    
    $id_compras	=	$_GET["id_compras"];
    $id_asiento	=	$_GET["id_asiento"];
    $secuencial	=	$_GET["secuencial"];
    
    // 'id_compras': ,
    // 'id_asiento': 
    //secuencial 
    
    
    $sql1 = "SELECT valor1
         		        FROM co_catalogo
        		       WHERE tipo = 'Fuente de Impuesto a la Renta' and
                             activo = 'S' and codigo=".$bd->sqlvalue_inyeccion($codigo ,true);
    
    $Amonto = $bd->ejecutar($sql1);
    
    $Aporcentaje = $bd->obtener_array( $Amonto);
    
    $porcentaje = $Aporcentaje['valor1'] /100 ;
    
    $total = round($porcentaje * $base,2) ;
    
 
    
    $﻿ATabla = array(
        array( campo => 'id_compras',   tipo => 'NUMBER',   id => '0',  add => 'S',   edit => 'S',   valor => $id_compras,   filtro => 'N',   key => 'N'),
        array( campo => 'id_asiento',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $id_asiento,   filtro => 'N',   key => 'N'),
        array( campo => 'secuencial',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'S',   valor => $secuencial,   filtro => 'N',   key => 'N'),
        array( campo => 'codretair',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $codigo,   filtro => 'N',   key => 'N'),
        array( campo => 'baseimpair',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $base,   filtro => 'N',   key => 'N'),
        array( campo => 'porcentajeair',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor =>  $Aporcentaje['valor1'],   filtro => 'N',   key => 'N'),
        array( campo => 'valretair',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
    );
    
    $id = $bd->_InsertSQL('co_compras_f',$﻿ATabla,'-');
    
    $retencion_fuente ='Resumen: '.$total;
    
    echo $retencion_fuente;
    
    
?>
 
  