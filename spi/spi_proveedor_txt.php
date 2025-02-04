<?php
session_start( );

require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

$bd	   =	new Db;

 

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);


$id_spi        = $_GET['id_spi'];

$x = $bd->query_array('tesoreria.te_spi_para',
                      ' fecha_pago, mes_pago, referencia_pago, localidad, responsable1, 
                        cargo1, responsable2, cargo2, cuenta_bce, empresa', 
                        '1=1' 
    );


$array = explode('-',$x['fecha_pago']);

$anio = $array[0] ;
$mes  = $array[1] ;
$dia  = $array[2] ;

$fecha = $dia.'/'.$mes.'/'.$anio ;

$cadena = $fecha.sp().trim($x['cuenta_bce']).sp().substr(trim($x['empresa']), 0, 30);
 

$fh = fopen("proveedor.txt", 'w') or die("Se produjo un error al crear el archivo");


fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");


//-------------- detalle spi ----
$sql = "SELECT id_spi, id_asiento_aux, idprov, codigo_banco, nro_cuenta, gasto_spi, enviado, monto_pagar,
               sesion, creacion, sesionm, modificacion, razon, detalle, tipo_cuenta,ciu
FROM tesoreria.view_spi_detalle
where id_spi = ".$bd->sqlvalue_inyeccion($id_spi ,true).' order by razon';

$stmt1 = $bd->ejecutar($sql);

while ($xx=$bd->obtener_fila($stmt1)){
      
    $string = substr(trim($xx['razon']),0,29);
    
    
    $micadena = utf8_decode($string);
    
    $str_nombre = eliminar_simbolos($micadena);

    $idprov = trim($xx['idprov']);
    
    if ( trim($xx['ciu']) == '1' ){

        $idprov = substr($idprov ,0,10);

    }

    $cadena = trim($idprov).sp().trim($str_nombre).sp().
              trim($xx['nro_cuenta']).sp().($xx['monto_pagar']).sp().
              trim($xx['codigo_banco']).sp().trim($xx['tipo_cuenta'])  ;
        
        if (!empty($cadena)) {
            fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
        }
        
}

 
fclose($fh);

require 'pclzip.lib.php';
$archivo = new PclZip( "spi-proveedor.zip" );
// Podemos especificar los archivos pasandolos como un arreglo
$nuevos_archivos = array( "proveedor.txt" );
$agregar = $archivo->create($nuevos_archivos );

// Gestionar error ocurrido (si $archivo->add() retorna cero a $agregar)
if ( !$agregar ) {
    echo "ERROR. Codigo: ".$archivo->errorCode()." ";
    echo "Nombre: ".$archivo->errorName()." ";
    echo "Descripcion: ".$archivo->errorInfo();
} else {
    echo "Archivos agregados exitosamente!";
}

 
 $achivo = '<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> <h4>
             REPORTE DE CONTROL  *** DETALLE DE PAGO A PROVEEDORES *** <br>
             INSTITUCION         : '.trim($x['empresa']).'<br>
             FECHA REPORTE       : '.$fecha.'<br>
             FECHA AFECTACION    : '.$x['fecha_pago'].'</h4></div>';
 
 echo $achivo;

 
 //----------------------------------------
 function sp(){
     
     //return "&nbsp;&nbsp;&nbsp;&nbsp;";
     
     return "\t";
     
     
 } 
 //----------------------------------------
 function eliminar_simbolos($string){
     
     $string = trim($string);
     
     $string = str_replace(
         array('�', '�', '�', '�', '�', '�', '�', '�', '�'),
         array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
         $string
         );
     
     $string = str_replace(
         array('�', '�', '�', '�', '�', '�', '�', '�'),
         array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
         $string
         );
     
     $string = str_replace(
         array('�', '�', '�', '�', '�', '�', '�', '�'),
         array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
         $string
         );
     
     $string = str_replace(
         array('�', '�', '�', '�', '�', '�', '�', '�'),
         array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
         $string
         );
     
     $string = str_replace(
         array('�', '�', '�', '�', '�', '�', '�', '�'),
         array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
         $string
         );
     
     $string = str_replace(
         array('�', '�', '�', '�'),
         array('n', 'N', 'c', 'C',),
         $string
         );
     
     $string = str_replace(
         array("\\", "�", "�", "-", "~",
             "#", "@", "|", "!", "\"",
             "�", "$", "%", "&", "/",
             "(", ")", "?", "'", "�",
             "�", "[", "^", "<code>", "]",
             "+", "}", "{", "�", "�",
             ">", "< ", ";", ",", ":",
             ".", " "),
         ' ',
         $string
         );
     return $string;
 } 
?>