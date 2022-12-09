<?php
session_start( );
 
$_SESSION['id_rol'] =  $_GET['id_rol1'];
$_SESSION['idconfig'] =  $_GET['idconfig'];

    
    
echo 'rol '.$_SESSION['id_rol'] .' '.$_SESSION['idconfig'] ;
    
 


?>