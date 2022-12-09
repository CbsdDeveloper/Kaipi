<?php
session_start( );

require '../../kconfig/Db.class.php';         /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php';         /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Set.php';              /*Incluimos el fichero de la clase objetos*/
require '../../kconfig/Db.emailMarket.php';   /*Incluimos el fichero de la clase objetos*/

$obj   = 	new objects;
$set   = 	new ItemsController;
$bd	   =	new Db;
$mail  =	new EmailEnvio;

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);




$sesion 	   =   rtrim(ltrim($_POST['tde']));

$sesion_nombre = _usuario(  trim($_SESSION['email']) , $bd  ) ;



$content = rtrim(ltrim($_POST['editor1']));

$asunto = rtrim(ltrim($_POST['tasunto']));

$idtransaccion = $_POST['idtransaccion'];
 
 
$para          = rtrim(ltrim($_POST['temail']));

$para_nombre   = rtrim(ltrim($_POST['para_email']));




if (!empty($content)){
    
    $mail->_DBconexion( $obj, $bd );
    
    $mail->_smtp( $sesion );
    
    if ($sesion == '-'){
        $sesion = trim($_SESSION['email']) ;
    }
    
    $mail->_DeCRM( $sesion,$sesion_nombre);
    
    $mail->_ParaCRM($para,$para_nombre);
    
    $mail->_AsuntoCRM($asunto,$content );
    
    
    $mensaje_enviado = $mail->_Enviar();
    
    agregar_email($bd,$asunto,$content,$sesion,$idtransaccion,$para );
    
    echo '<script>
               ListaEmail('.$idtransaccion.'); 
               limpiaEmailEnvio('."'". (strip_tags  ($mensaje_enviado))."'".') ;
            </script>';
    
    echo $mensaje_enviado;
    
}else {
    
    $mensaje_enviado = " <h6> Presione el boton [Enviar]  </h6>"; 
    
    echo $mensaje_enviado;

}
//-------------------------------------------
//--------------------------------------------
function agregar_email($bd,$asunto,$content	,$sesion,$idtransaccion,$para ) {
    
    
    $fecha  = date("Y-m-d");
   
    
    $﻿ATabla = array(
        array( campo => 'idven_email',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idvengestion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idtransaccion, key => 'N'),
        array( campo => 'estado',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '0', key => 'N'),
        array( campo => 'asunto',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $asunto, key => 'N'),
        array( campo => 'de',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
        array( campo => 'para',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => $para, key => 'N'),
        array( campo => 'texto',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $content, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '8',add => 'S', edit => 'S', valor => $fecha, key => 'N'),
    );
    
      $bd->_InsertSQL('ven_cliente_email',$﻿ATabla,'ven_cliente_email_idven_email_seq');
    
}
//--------------------------------------------
function _usuario( $sesion,$bd  ) {
    
    $Ausuario = $bd->query_array( 'par_usuario',
                                  'completo', 
                                  'email='.$bd->sqlvalue_inyeccion(trim($sesion),true)
        );
    
    return $Ausuario['completo'];
    
}
 

?>
 
  