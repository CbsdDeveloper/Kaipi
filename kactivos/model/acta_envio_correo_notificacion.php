<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
// require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require('../reportes/kreportes.php');
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

// $bd       =    new Db;
$obj   =     new objects;
$mail  =    new EmailEnvio;

$gestion =     new ReportePdf;
$id      = trim($_GET['id_acta']);
$datos   = $gestion->Acta_entrega($id);

$gestion->bd->conectar($_SESSION['us'], '', $_SESSION['ac']);

$mail->_DBconexion($obj, $gestion->bd);
$mail->_smtp_factura_electronica();

$id_acta = $_GET["id_acta"];
$datos_empresa = _empresa($gestion->bd);

$datos_funcionario = $gestion->bd->query_array(
    'view_nomina_rol',   // TABLA
    'razon,emaile',      // CAMPOS
    'idprov=' . $gestion->bd->sqlvalue_inyeccion(trim($datos["idprov"]), true) // CONDICION
);

$datos_funcionario_genera = $gestion->bd->query_array(
    'view_nomina_rol',   // TABLA
    'razon,cargo',      // CAMPOS
    'emaile=' . $gestion->bd->sqlvalue_inyeccion(trim($datos["sesion"]), true) // CONDICION
);

// print_r($datos_funcionario);
// print_r("++++++");
// print_r($datos);
// print_r("******");

$tabla_bienes = "";
$sql = 'SELECT * FROM activo.view_acta_detalle where id_acta= ' . $gestion->bd->sqlvalue_inyeccion($id, true) . ' order by clase,id_bien';
$stmt1 = $gestion->bd->ejecutar($sql);
$i = 1;
$total = 0;
$cadena = '';
while ($y = $gestion->bd->obtener_fila($stmt1)) {
    $input = str_pad($y['id_bien'], 5, "0", STR_PAD_LEFT);
    $codigo =   trim($y['cuenta']) . '-' . $input;
    $id_bien = $y['id_bien'];
    $yy = $gestion->bd->query_array(
        'activo.view_bienes',   // TABLA
        '*',                        // CAMPOS
        'id_bien=' . $gestion->bd->sqlvalue_inyeccion($id_bien, true) // CONDICION
    );
    $xxy = $gestion->bd->query_array(
        'web_modelo',
        'nombre',
        'idmodelo=' . $gestion->bd->sqlvalue_inyeccion($yy['id_modelo'], true)
    );

    $detalle =   trim($y['descripcion']) . ' Color ' . trim($y['color']) . ' ' . trim($y['material']) . ' ' . trim($y['dimension']) . ' Modelo ' . trim($xxy['nombre']);
    $tabla_bienes .= ' <tr>
                <td>' . $i . '</td>
		    	<td>' . $codigo . '</td>
				<td>' . trim($y['clase']) . '</td>
                <td>' . trim($detalle) . '</td>
                <td>' . $y['serie'] . '</td>
                <td>' . $y['estado_bien'] . '</td>
				<td>' . $yy['fecha_adquisicion'] . '</td>
           </tr>';
    $i++;
    $total = $total + $y['costo_adquisicion'];
    // $cadena = $cadena . ',' . $id_bien;
}

// echo $tabla_bienes;
// print_r($datos_funcionario);
// print_r($datos);

$asunto = 'Notificacion de ' . $datos['clase_documento'] . " #" . $datos['documento'];
// $sesion =  trim($_SESSION['email']);
// $datos_usuario = _usuario_login($login, $gestion->bd);

// Formato HTML de notificación
$html_notificacion = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificación de Generación de Acta de Entrega de Bienes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #D21E20;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center
        }
        .header img {
            margin-right: 10px; /* Espacio entre la imagen y el texto */
            height: 100px; /* Ajusta el tamaño de la imagen según sea necesario */
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            margin: 0 0 10px;
        }
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            font-size: 10px;
            background-color: #f2f2f2;
        }
        td {
            font-size: 10px;
        }
        .footer {
            background-color: #D21E20;
            color: #ffffff;
            text-align: center;
            padding: 10px 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://kaipi.cbsd.gob.ec/kimages/Logocbsd.png" alt="Logo">
            <h1>Notificación de Generación de #clase_documento Nro. #documento</h1>
        </div>
        <div class="content">
            <p>Estimado/a #razon,</p>
            <p>Le informamos que se ha generado un acta de entrega de bienes con la siguiente información:</p>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Código del Bien</th>
                            <th>Clase</th>
                            <th>Detalle</th>
                            <th>Número de Serie</th>
                            <th>Estado</th>
                            <th>Fecha de Adquisición</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Repetir este bloque para cada bien -->
                        #TABLA_BIENES
                        <!-- Fin del bloque -->
                    </tbody>
                </table>
            </div>
            <p><b>Nota:</b> El custodio tiene un plazo de 48h para una apelacion escrita de la recepcion de los bienes, este es un medio de notificacion de los bienes asignados en sistema y costancia para su posterior firma de acta entrega recepcion.</p>
            <p>Por favor, revise esta información y confirme la recepción de los bienes.</p>
            <p>Atentamente,</p>
            <p>#empresa</p>
        </div>
        <div class="footer">
            <p>&copy; #year Cuerpo de Bomberos del Gobierno Autónomo Descentralizado Municipal de Santo Domingo . Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
';

$html_notificacion = str_replace("#razon", trim($datos["razon"]), $html_notificacion);
$html_notificacion = str_replace("#clase_documento", trim($datos["clase_documento"]), $html_notificacion);
$html_notificacion = str_replace("#documento", trim($datos["documento"]), $html_notificacion);
$html_notificacion = str_replace("#TABLA_BIENES", $tabla_bienes, $html_notificacion);
$html_notificacion = str_replace("#empresa", $datos["funcionario_entrega"].'<br>'.$datos["cargo_entrega"], $html_notificacion);
$html_notificacion = str_replace("#year", $datos["anio"], $html_notificacion);

$html_notificacion = reemplazar_tildes($html_notificacion);

if (!empty($html_notificacion)) {
    // print_r('envio correo');
    // $mail->_DeCRM( $sesion,$datos_empresa['razon']);
    $mail->_ParaCRM($datos_funcionario['emaile'], $datos['razon']);
    $mail->_AsuntoCRM($asunto, $html_notificacion);
    $mensaje_enviado = $mail->_Enviar();
    echo $mensaje_enviado;
}




//-------------------------------------------

//--------------------------------------------
function _usuario($sesion, $bd)
{
    $Ausuario = $bd->query_array(
        'par_usuario',
        '*',
        'email=' . $bd->sqlvalue_inyeccion(trim($sesion), true)
    );
    return $Ausuario;
}

//--------------------------------------------
function _usuario_login($login, $bd)
{
    $Ausuario = $bd->query_array(
        'par_usuario',
        '*',
        'idusuario=' . $bd->sqlvalue_inyeccion(trim($login), true)
    );
    return $Ausuario;
}
//--------------------
function _empresa($bd)
{
    $ruc       =  $_SESSION['ruc_registro'];
    $Ausuario = $bd->query_array(
        'web_registro',
        '*',
        'ruc_registro=' . $bd->sqlvalue_inyeccion(trim($ruc), true)
    );
    return $Ausuario;
}

function reemplazar_tildes($texto)
{
    $buscar  = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ');
    $reemplazar = array(
        '&aacute;',
        '&eacute;',
        '&iacute;',
        '&oacute;',
        '&uacute;',
        '&Aacute;',
        '&Eacute;',
        '&Iacute;',
        '&Oacute;',
        '&Uacute;',
        '&ntilde;',
        '&Ntilde;'
    );

    return str_replace($buscar, $reemplazar, $texto);
}
