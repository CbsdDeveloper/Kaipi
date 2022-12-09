<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php'; /*Incluimos el fichero de la clase objetos*/

$bd	   =	new Db;
$obj   = 	new objects;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 
$mail->_DBconexion( $obj, $bd );

//$mail->_smtp_tramites( );

$mail->_smtp_factura_electronica();

$idprov				=   $_GET["idprov"];
$tramite			=   $_GET["tramite"];
$nombre_funcionario =   $_GET["nombre_funcionario"];
$modulo				=   $_GET["modulo"];
$tarea			    =   $_GET["tarea"];
 

$datos_empresa = _empresa($bd);


$asunto = 'Notitificacion de '.$modulo.' del nro.tramite '.$tramite;
 

$sesion 	   =  trim($_SESSION['email']);


 
 
$datos_usuario = _usuario_login( $idprov,$bd  );


$content =  'Estimado(a): '.$nombre_funcionario.'<br><br>'.
    'Tiene un tramite pendiente o novedad que requiere su revision<br> ';
    
$content =  $content.'Novedad: '.$tarea.'<br>';
$content =  $content.'Modulo : '.$modulo.'<br>';
$content =  $content.'Nro.Tramite : '.$tramite.'<br>';

$content =  $content.'Enviado por : '.$sesion.'<br>';

$content =  $content.'Comuniquese con la unidad/responsable.<br>';
$content =  $content.'Saludos Cordiales.<br>';
$content =  $content.'Administrador Sistema<br><br>';


$content =  $content.'<h4>ADVERTENCIA... se recomienda navegador Google Chrome   </h4><br>  ';

  $content =  $content.'<h5>  <b>               
                        En Chrome</b><br>
                        En tu computadora, abre Chrome.<br>
                        En la esquina superior derecha, haz clic en Más .<br>
                        Haz clic en Más herramientas. ...<br>
                        En la parte superior, elige un intervalo de tiempo. ...<br>
                        Marca las casillas junto a "Cookies y otros datos de sitios" y "Imágenes y archivos almacenados en caché".<br>
                        Haz clic en Borrar datos enlace: https://support.google.com/accounts/answer/32050?hl=es-419&co=GENIE.Platform%3DDesktop</h5>';

if (!empty($content)){
    
    
    
    $mail->_DeCRM( $sesion,$datos_empresa['razon']);
    
    $mail->_ParaCRM($datos_usuario['correo'],$datos_usuario['razon']);
    
    $mail->_AsuntoCRM($asunto,$content );
    
    
    $mensaje_enviado = $mail->_Enviar();
    
    
    
    
    echo $mensaje_enviado;
    
    
} 

 

 
    //-------------------------------------------
    
    //--------------------------------------------
    function _usuario( $sesion,$bd  ) {
        
        $Ausuario = $bd->query_array( 'par_usuario',
            '*',
            'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
            );
        
        return $Ausuario;
        
    }
    
    //--------------------------------------------
    function _usuario_login( $login,$bd  ) {
        
        $Ausuario = $bd->query_array( 'par_ciu',
            '*',
            'idprov='.$bd->sqlvalue_inyeccion(trim($login),true)
            );
        
        return $Ausuario;
        
    }
    //--------------------
    function _empresa(  $bd  ) {
        
         $ruc       =  $_SESSION['ruc_registro'];
        
        $Ausuario = $bd->query_array( 'web_registro',
            '*',
            'ruc_registro='.$bd->sqlvalue_inyeccion(trim($ruc),true)
            );
        
        return $Ausuario;
        
    }
    
    ?>
 
  