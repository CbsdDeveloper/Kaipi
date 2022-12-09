<?php
session_start( );
 

$_SESSION['idmarca'] = $_GET['idmarca'];

$SaldoBodega = $_SESSION['idmarca'];

echo trim($SaldoBodega);

?>					 