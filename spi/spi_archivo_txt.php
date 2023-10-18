<?php
session_start( );
require '../kconfig/Db.class.php';
require '../kconfig/Obj.conf.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$bd	   =	new Db;

$obj     = 	new objects;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


$id_spi        = $_GET['id_spi'];

$x = $bd->query_array('tesoreria.te_spi_para',
                      ' fecha_pago, mes_pago, referencia_pago, localidad, responsable1, cargo1, responsable2, cargo2, cuenta_bce, empresa', 
                      '1=1' 
    );


$y = $bd->query_array('tesoreria.spi_mov_det',
    ' sum(monto_pagar) as total ,count(*) as nn,sum(cast(codigo_banco as numeric)) as suma_bancos',
    'id_spi='.$bd->sqlvalue_inyeccion($id_spi ,true)
    );

 
//---- variable validacion
$var1 = $y['total'] * 100 ;
$var2 = $x['cuenta_bce'] * 2 ;
$var3 = $y['suma_bancos']  ;
$var4 = 107;

$validacion = $var1 + $var2+ $var3 + $var4;


 
 
$array = explode('-',$x['fecha_pago']);

$anio = $array[0] ;
$mes  = $array[1] ;
$dia  = $array[2] ;

$fecha = $dia.'/'.$mes.'/'.$anio.' 00:00:00,' ;
$input = str_pad(trim($x['referencia_pago']), 5, "0", STR_PAD_LEFT).','.$y['nn'].',1,'.$y['total'].',' ;

$codigobce = $x['cuenta_bce']; 
$empresa   = ','.substr(trim($x['empresa']), 0, 30).','.trim($x['localidad']).','.trim($x['mes_pago']);




//-------------- detalle spi ----

$sql = "SELECT id_spi, id_asiento_aux, idprov, codigo_banco, nro_cuenta, gasto_spi, enviado, monto_pagar,
               sesion, creacion, sesionm, modificacion, razon, detalle, tipo_cuenta,id_spi_det,ciu
FROM tesoreria.view_spi_detalle
where id_spi = ".$bd->sqlvalue_inyeccion($id_spi ,true).' order by razon';

$stmt1 = $bd->ejecutar($sql);


$fh = fopen("spi-sp.txt", 'w') or die("Se produjo un error al crear el archivo");
 
$cadena = $fecha.$input.$validacion.','.$codigobce.','.$codigobce.$empresa;

fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
 
 
while ($xx=$bd->obtener_fila($stmt1)){
    
    $string = substr(trim($xx['razon']),0,29).' ';
  
    
    $micadena = utf8_decode($string);
    
    $str_nombre = eliminar_simbolos($micadena);
    
    $idprov = trim($xx['idprov']);

    if ( trim($xx['ciu']) == '1' ){

        $idprov = substr(trim($idprov) ,0,10);

    }

    
    $cadena = abs($xx['id_spi_det']).','.$xx['monto_pagar'].','.
              trim($xx['gasto_spi']).','.trim($xx['codigo_banco']).','.
              trim($xx['nro_cuenta']).','.trim($xx['tipo_cuenta']).','.$str_nombre.','.
              strtoupper(trim($xx['detalle'])).','.$idprov ;
    
              if (!empty($cadena)) {
                  fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
              }
   
}
        


fclose($fh);
 
 $achivo = "....Se ha generado corrrectamente codigo de verificacion: " . $validacion;
 
 echo $achivo.'<br>' ;
 
 
 ///---------------------------------------------------------------
 
 $file = 'spi-sp.txt';
 

 $hasd = hash_file('md5',$file);
 
 
 $sql_edit = 'update tesoreria.spi_mov 
                 set codigo_control='.$bd->sqlvalue_inyeccion($hasd  , true).',
                     validacion ='.$bd->sqlvalue_inyeccion($validacion  , true).'
               where id_spi = '.$bd->sqlvalue_inyeccion($id_spi  , true);
 
 
 $bd->ejecutar($sql_edit);
 
 
 
 $fh = fopen("spi-sp.md5", 'w') or die("Se produjo un error al crear el archivo");
 $cadena = $hasd.'  c:\SPI-2005\spi-sp.txt';
 fwrite($fh, $cadena. PHP_EOL) or die("No se pudo escribir en el archivo");
 
 require 'pclzip.lib.php';
 
 
 //   Creamos un objeto con el nombre del fichero a crear
 $archivo = new PclZip( "spi-sp.zip" );
 
 
 // Podemos especificar los archivos pasandolos como un arreglo
 $nuevos_archivos = array( "spi-sp.txt" , "spi-sp.md5" );
 
 $agregar = $archivo->create($nuevos_archivos );
 
 // Gestionar error ocurrido (si $archivo->add() retorna cero a $agregar)
 if ( !$agregar ) {
     echo "ERROR. Codigo: ".$archivo->errorCode()." ";
     echo "Nombre: ".$archivo->errorName()." ";
     echo "Descripcion: ".$archivo->errorInfo();
 } else {
     echo "Archivos agregados exitosamente!";
 }
 
 
 $date = date("Y-m-d");
 
 echo '<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> <h4>
             REPORTE DE CONTROL  *** TRANSFERENCIAS SPI-SP *** <br>
             INSTITUCION         : '.trim($x['empresa']).'<br>
             FECHA REPORTE       : '.$date.'<br>
             FECHA AFECTACION    : '.$x['fecha_pago'].'</h4></div>';
 
 echo '<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> <h4>
             NUMERO CONTROL    : '. $hasd.'<br>
             MONTO TOTAL       : '.$y['total'].'<br>
             NUMERO REGISTROS  : '.$y['nn'].'</h4></div>';
 

 echo '<div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px"> <h5>
             '.$x['responsable1'].'    / '. $x['cargo1'].'<br>
             '.$x['responsable2'].'    / '. $x['cargo2'].'<br>
             CUENTA BCE       : '.$x['cuenta_bce'].'<br>
             LOCALIDAD        : '.$x['localidad'].'</h5><br>
             PARA USO INTERNO DE LA ENTIDAD PUBLICA
        </div>';
 
 
 
 $cadena = " || ' '" ;
 
 $tipo = $bd->retorna_tipo();
 
 $sql = 'SELECT  codigo_banco  '.$cadena.' as "Codigo Banco", 
                 nombre_banco as "Institucion Pagadora",  
                 count(*) as "Nro.Registro",
                 sum(monto_pagar) as "Monto"
            FROM tesoreria.view_spi_detalle
            where id_spi = '.$bd->sqlvalue_inyeccion($id_spi  , true).'
            group by codigo_banco,nombre_banco';

 
 
 $resultado = $bd->ejecutar($sql);
 
 echo '<div class="col-md-7" style="padding-top: 10px;padding-bottom: 10px">';
 
 $obj->grid->KP_sumatoria(3,"Nro.Registro","Monto", "","");
 
 $obj->grid->KP_GRID_visor($resultado,$tipo,'80%');  
 
 
 echo '  </div>';

 
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