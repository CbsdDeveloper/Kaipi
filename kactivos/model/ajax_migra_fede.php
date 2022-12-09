<?php

session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


 
$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 

 
  //-------------------------------------------
  
$sql1 = 'SELECT activo, "GRUPO", "CUENTA ", "CONTROL", " qr", 
        "CATEGORIA", "DETALLE", fcompra, "ORIGEN", "MARCA", 
        "SERIE", "MODELO", "ESTADO", "PROVEEDOR", doc, "MARCA1", 
        "SERIE1", "MODELO1", "IDENTIFICACION", "CUSTODIO", "CARGO ", 
       costo, vida, residual, aniod, mesd, acumula, libro, fin, anio, 
     fcosto, desgaste, libros2, f34, f35 FROM migra.bienes';

$stmt1 = $bd->ejecutar($sql1);

 
while ($fila=$bd->obtener_fila($stmt1)){
    
    $detalle = _ingresa_activo( $bd ,$fila );
    
  
    echo $detalle;
}

 
function _ingresa_activo( $bd ,$fila ){
    
    $tabla 	  	  = 'activo.ac_bienes';
    
    $secuencia 	     = 'activo.ac_bienes_id_bien_seq';
    
    $ATabla = array(
        array( campo => 'id_bien',   tipo => 'NUMBER',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
        array( campo => 'idbodega',tipo => 'NUMBER',id => '1',add => 'S', edit => 'N', valor => '0', key => 'N'),
        array( campo => 'tipo_bien',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',        id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'forma_ingreso',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'identificador',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'descripcion',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'origen_ingreso',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'N', valor => 'Compra', key => 'N'),
        array( campo => 'tipo_documento',tipo => 'VARCHAR2',id => '8',add => 'S', edit => 'N', valor => 'Factura', key => 'N'),
        array( campo => 'clase_documento',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'tipo_comprobante',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'fecha_comprobante',tipo => 'DATE',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'codigo_actual',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'estado',tipo => 'VARCHAR2',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'costo_adquisicion',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'depreciacion',tipo => 'VARCHAR2',id => '15',add => 'S', edit => 'N', valor => 'N', key => 'N'),
        array( campo => 'serie',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'id_modelo',tipo => 'NUMBER',id => '17',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'id_marca',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'clasificador',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'cuenta',tipo => 'VARCHAR2',id => '20',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'valor_residual',tipo => 'NUMBER',id => '21',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'anio_depre',tipo => 'NUMBER',id => '22',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'cantidad',tipo => 'NUMBER',id => '23',add => 'S', edit => 'N', valor => '1', key => 'N'),
        array( campo => 'vida_util',tipo => 'NUMBER',id => '24',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'color',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'dimension',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'uso',tipo => 'VARCHAR2',id => '27',add => 'S', edit => 'N', valor => 'Libre', key => 'N'),
        array( campo => 'fecha_adquisicion',tipo => 'DATE',id => '28',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'clase',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '30',add => 'S', edit => 'N', valor =>  $this->sesion 	, key => 'N'),
        array( campo => 'creacion',tipo => 'DATE',id => '31',add => 'S', edit => 'N', valor => $this->hoy, key => 'N'),
        array( campo => 'sesionm',tipo => 'VARCHAR2',id => '32',add => 'S', edit => 'S', valor =>  $this->sesion 	, key => 'N'),
        array( campo => 'modificacion',tipo => 'DATE',id => '33',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
        array( campo => 'material',tipo => 'VARCHAR2',id => '34',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'detalle',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'detalle_ubica',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'idsede',tipo => 'NUMBER',id => '37',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'idproveedor',tipo => 'VARCHAR2',id => '38',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'factura',tipo => 'NUMBER',id => '39',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'id_tramite',tipo => 'NUMBER',id => '40',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'tiempo_garantia',tipo => 'VARCHAR2',id => '41',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'garantia',tipo => 'VARCHAR2',id => '42',add => 'S', edit => 'S', valor => '-', key => 'N'),
        array( campo => 'tipo',tipo => 'VARCHAR2',id => '43',add => 'S', edit => 'N', valor => 'BIENES', key => 'N')
    );
    
    
}
 
 

?>
 
  