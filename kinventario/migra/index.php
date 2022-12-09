<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


require_once('vendor/php-excel-reader/excel_reader2.php');
require_once('vendor/SpreadsheetReader.php');

if (isset($_POST["import"]))
{
    
$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = $_FILES['file']['name'];
        
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
                for($i=0;$i<$sheetCount;$i++)
                {
        
                           $Reader->ChangeSheet($i);
                          
                         foreach ($Reader as $Row)
                        {
                      
                                 $variable =  trim($Row[0]) ;
                                 
                                 if ($variable == 'cabecera' ){
                                     
                                     llena_factura($Row,$bd	);
                                     
                                 }
                                 
                                 if ($variable == 'detalle' ){
                                     
                                     detalle_movi( $Row,$bd);
                                     
                                 }
              
                        }
                 }
         }
         $type = "OK";
         $message = "El archivo enviado esta generado.....";
         
         actualiza_totales($bd);
  }
  else  { 
       
        $type = "error";
        $message = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
  }
  
//************************************
  function actualiza_totales(  $bd){
      
 
      
      $sql_det1 = "Select *
                    from inv_movimiento
                    where idbodega = ".$bd->sqlvalue_inyeccion(90,true) ;
      
 
      $stmt1 = $bd->ejecutar($sql_det1);
      
      
      while ($x=$bd->obtener_fila($stmt1)){
          
          $id_movimiento  = $x['id_movimiento'];
          
          $xx = $bd->query_array('inv_movimiento_det',
              'sum(total) as total',
              'id_movimiento='.$bd->sqlvalue_inyeccion($id_movimiento,true));
          
 
          $total =  $xx['total'];
          
          $sqlEdit = "update inv_movimiento
                         set base0 = ".$bd->sqlvalue_inyeccion($total,true)." ,
                             total = ".$bd->sqlvalue_inyeccion($total,true)." ,
                             base12 = 0,
                             iva = 0
                       where id_movimiento = ".$bd->sqlvalue_inyeccion($id_movimiento,true) ;
          
          $bd->ejecutar($sqlEdit);
          
          
      }
      
      
  }
  
 
///------------------------------------------------------------------------------------
function llena_factura( $Row,$bd){
    
    $id = trim($Row[5]);
    
    $valida = valida( $bd,$id);
    
    if ( $valida == 0 ){
        inserta_ciu($Row,$bd);
    };
    
    $iddoc  =  trim($Row[1]);
    $valida =  valida_factura( $bd,$iddoc);
 
   if ( $valida == 0 ){
       inserta_facturas($Row,$bd);
   };
    
    
    
 }
//-------------------
 function valida( $bd,$id){
     
     
     $AResultado = $bd->query_array('par_ciu',
         'count(idprov) as nn',
         'idprov='.$bd->sqlvalue_inyeccion($id,true));
     
     if  ( $AResultado["nn"] > 0){
         return 1;
     }else{
         return 0;
     }
     
 }
//---------------------------------
 function valida_factura( $bd,$iddoc){
 
     
     $AResultado = $bd->query_array('inv_movimiento',
         'count(id_movimiento) as nn',
         'documento='.$bd->sqlvalue_inyeccion($iddoc,true));
     
     if  ( $AResultado["nn"] > 0){
         return 1;
     }else{
         return 0;
     }
     
 }
//-----------------------
 function inserta_ciu( $fila,$bd){
     
     $id =     trim($fila[5]);
     
     $telefono = '033700470' ;
     $correo   = 'mpillaro@hotmail.com';
     
     
     $sesion  =  trim($_SESSION['email']);
     
     $ATabla = array(
         array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $id,   filtro => 'N',   key => 'S'),
         array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor =>  trim($fila[2]),   filtro => 'N',   key => 'N'),
         array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
         array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'N',   valor => 'Pillaro',   filtro => 'N',   key => 'N'),
         array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'N',   valor => $telefono,   filtro => 'N',   key => 'N'),
         array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $correo,   filtro => 'N',   key => 'N'),
         array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => $telefono,   filtro => 'N',   key => 'N'),
         array( campo => 'idciudad',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => '18',   filtro => 'N',   key => 'N'),
         array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'SN',   filtro => 'N',   key => 'N'),
         array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'N',   valor => '0000',   filtro => 'N',   key => 'N'),
         array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'N',   valor =>$correo,   filtro => 'N',   key => 'N'),
         array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
         array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
         array( campo => 'registro',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'S',   valor =>trim( $_SESSION['ruc_registro']),   filtro => 'N',   key => 'N'),
         array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'C',   filtro => 'N',   key => 'N'),
         array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
         array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '16',  add => 'S',   edit => 'S',   valor =>$sesion,   filtro => 'N',   key => 'N'),
     );
     
     $tabla 	  	  = 'par_ciu';
     
     $bd->_InsertSQL($tabla,$ATabla, $id );
 }
 //-------------------- $Row,$bd
 function inserta_facturas( $fila,$bd){
     
     
     $fecha                   =  $fila[4];
     $idtitulo                =  trim($fila[1]);
     $idperiodo               =  periodo($bd,$fecha);
     $detalle                 =  trim($fila[3]);
     
     $base12 = '0';
     $iva    = '0';
     
 
     
     
     $base0  =  '0';
     $total  =  '0';
     
     $sesion  =  trim($_SESSION['email']);
     /* codigo, usuario, direccion, ano, periodo, consumo, interes, costas,
      coactiva, total, fecha_fac, hora_fac, cobrar, usuarioc, tipo, tarifa,
      servicio, alcanta, costo_ind, servadm, enlace, cedula, email */
     
     $comprobante = K_comprobante($bd );
     
     $ATabla = array(
         array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
         array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor =>$fecha,   filtro => 'N',   key => 'N'),
         array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => trim( $_SESSION['ruc_registro']),   filtro => 'N',   key => 'N'),
         array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $detalle,   filtro => 'N',   key => 'N'),
         array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor =>$sesion ,   filtro => 'N',   key => 'N'),
         array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
         array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'N',   valor => $comprobante,   filtro => 'N',   key => 'N'),
         array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'aprobado',   filtro => 'N',   key => 'N'),
         array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'F',   filtro => 'N',   key => 'N'),
         array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor =>$idperiodo,   filtro => 'N',   key => 'N'),
         array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $idtitulo,   filtro => 'N',   key => 'N'),
         array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => trim($fila[5]),   filtro => 'N',   key => 'N'),
         array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
         array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'S',   edit => 'N',   valor =>$fecha,   filtro => 'N',   key => 'N'),
         array( campo => 'cierre',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'N',   valor => 'S',   filtro => 'N',   key => 'N'),
         array( campo => 'base12',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'S',   valor => $base12,   filtro => 'N',   key => 'N'),
         array( campo => 'iva',   tipo => 'NUMBER',   id => '16',  add => 'S',   edit => 'S',   valor => $iva,   filtro => 'N',   key => 'N'),
         array( campo => 'base0',   tipo => 'NUMBER',   id => '17',  add => 'S',   edit => 'S',   valor => $base0,   filtro => 'N',   key => 'N'),
         array( campo => 'total',   tipo => 'NUMBER',   id => '18',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
         array( campo => 'idbodega',   tipo => 'NUMBER',   id => '19',  add => 'S',   edit => 'S',   valor => '90',   filtro => 'N',   key => 'N'),
         array( campo => 'comision',   tipo => 'NUMBER',   id => '20',  add => 'S',   edit => 'N',   valor =>'99',   filtro => 'N',   key => 'N'),
         array( campo => 'idproceso',   tipo => 'NUMBER',   id => '21',  add => 'S',   edit => 'N',   valor =>'100',   filtro => 'N',   key => 'N'),
         array( campo => 'cab_codigo',   tipo => 'NUMBER',   id => '22',  add => 'S',   edit => 'N',   valor =>'-',   filtro => 'N',   key => 'N')
     );
     
     
     $tabla 	  	  = 'inv_movimiento';
     
     $bd->_InsertSQL($tabla,$ATabla, '-' );
 
     
     
     
 }
 //-----------------
 function periodo($bd,$fecha ){
     
     $anio = substr($fecha, 0, 4);
     $mes  = substr($fecha, 5, 2);
     
     $APeriodo = $bd->query_array('co_periodo',
         'id_periodo, estado',
         'registro='.$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro']),true). ' AND
											  mes = '.$bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$bd->sqlvalue_inyeccion($anio,true)
         );
     
     
     
     return $APeriodo['id_periodo'];
     
 }
 //----------
 function K_comprobante($bd ){
     
     
     
     $sql = "SELECT   coalesce(factura,0) as secuencia
        	    FROM web_registro
        	    where ruc_registro = ".$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro'])  ,true);
     
     
     $parametros 			= $bd->ejecutar($sql);
     
     $secuencia 				= $bd->obtener_array($parametros);
     
     $contador = $secuencia['secuencia'] + 1;
     
     $input = str_pad($contador, 9, "0", STR_PAD_LEFT);
     
     
     $sqlEdit = "UPDATE web_registro
    			   SET 	factura=".$bd->sqlvalue_inyeccion($contador, true)."
     			 WHERE ruc_registro=".$bd->sqlvalue_inyeccion(trim( $_SESSION['ruc_registro']), true);
     
     
     $bd->ejecutar($sqlEdit);
     
     
     return $input ;
 }
 //------------------------------------------
 function detalle_movi( $Row,$bd){
     
     
     $iddoc = $Row[1] ;
     
     $AResultado = $bd->query_array('inv_movimiento',
         'id_movimiento',
         'documento='.$bd->sqlvalue_inyeccion($iddoc,true));
 
     
     $sesion  =  trim($_SESSION['email']);
     $ingreso = '0';
     $egreso  = '1';
     
     $monto_iva      = '0';
     $tarifa_cero    = $Row[4];
     $baseiva        ='0';
     $id_movimiento  = $AResultado['id_movimiento'];
     //----------------------------------------------------
     $total = $monto_iva + $tarifa_cero + $baseiva ;
     
     $costo = $tarifa_cero + $baseiva ;
     
     $tributo     = 'T';
     
     $cuenta = trim($Row[2]) ;
     
     $AProducto = $bd->query_array( 'web_producto',
         'idproducto,costo,tributo,saldo',
         'cuenta_inv ='.$bd->sqlvalue_inyeccion($cuenta,true)
         );
     
     $idproducto = $AProducto['idproducto'];
     
     if ( $idproducto >  0  ){
         
     }else{
         $idproducto = agregar($Row,$bd);
     }
     
     
     $ATabla = array(
         array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
         array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => 1,   filtro => 'N',   key => 'N'),
         array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'S',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
         array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'S'),
         array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
         array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
         array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
         array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
         array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
         array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tributo,   filtro => 'N',   key => 'N'),
         array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
         array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
         array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'S',   valor => $baseiva,   filtro => 'N',   key => 'N'),
         array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
         
     );
     
     
     $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
     
     
 }
 
 //----------------------
 function agregar( $Row,$bd   ){
     
     $cuenta1 = $Row[2];
     $cuenta2 = $Row[2];
     
     $ruc       =  $_SESSION['ruc_registro'];
     
     $InsertQuery = array(
         array( campo => 'producto',   valor => trim($Row[3])),
         array( campo => 'referencia',   valor =>'Registro de la propiedad'),
         array( campo => 'tipo',   valor => 'S'),
         array( campo => 'idcategoria',   valor =>62),
         array( campo => 'estado',   valor =>'S'),
         array( campo => 'url',   valor => '#'),
         array( campo => 'idmarca',  '3'),
         array( campo => 'unidad',   valor => 'unidad'),
         array( campo => 'facturacion',   valor => 'S'),
         array( campo => 'idbodega',   valor => '99'),
         array( campo => 'cuenta_inv',   valor => $cuenta1),
         array( campo => 'cuenta_ing',   valor => $cuenta2),
         array( campo => 'minimo',   valor => '10'),
         array( campo => 'tributo',   valor => 'T'),
         array( campo => 'costo',   valor => '0.00'),
         array( campo => 'codigob',   valor => '-'),
         array( campo => 'controlserie',   valor => 'N'),
         array( campo => 'cuenta_gas',   valor => 'N'),
         array( campo => 'registro',   valor => $ruc),
         array( campo => 'tipourl',       valor => '1',  filtro => 'N')
     );
     
     
     
     $idD = $bd->JqueryInsertSQL('web_producto',$InsertQuery);
     
     //------------ seleccion de periodo
     
 
     
     return $idD;
     
 }	
 
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">
<title>Importar archivo VENTAS</title>

<!-- Bootstrap core CSS -->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="assets/sticky-footer-navbar.css" rel="stylesheet">
<link href="assets/style.css" rel="stylesheet">

</head>

<body>
<header> 
  <!-- Fixed navbar -->
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"> <a class="navbar-brand" href="#">Inicio</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active"> <a class="nav-link" href="./">Inicio <span class="sr-only">(current)</span></a> </li>
      </ul>
       
    </div>
  </nav>
</header>

<!-- Begin page content -->

<div class="container">
  <h3 class="mt-5">Importar Cabeza de movimiento</h3>
  <hr>
  <div class="row">
    <div class="col-12 col-md-12"> 
      <!-- Contenido -->
    
    <div class="outer-container">
        <form action="" method="post"
            name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
            <div>
                <label>Elija Archivo Excel</label> <input type="file" name="file"
                    id="file" accept=".xls,.xlsx">
                <button type="submit" id="submit" name="import"
                    class="btn-submit">Importar Registros</button>
        
            </div>
        
        </form>
        
    </div>
    
       <!-- Contenido -->
     
    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    
   
      <!-- Fin Contenido --> 
    </div>
  </div>
  <!-- Fin row --> 

  
</div>
<!-- Fin container -->
<footer class="footer">
  <div class="container"> <span class="text-muted">
     </span> </div>
</footer>

<script src="assets/jquery-1.12.4-jquery.min.js"></script> 

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 

<script src="dist/js/bootstrap.min.js"></script>
</body>
</html>