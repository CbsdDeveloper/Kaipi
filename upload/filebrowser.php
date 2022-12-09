<?php
session_start( ); 
$carpeta_ficheros = '../userfiles/kaipi/' ; //$_SESSION['directorio_crm'];

$directorio = opendir($carpeta_ficheros); // Abre la carpeta

while ($fichero = readdir($directorio)) { // Lee cada uno de los ficheros
  if (!is_dir($fichero)){ // Omite las carpetas
echo "<div class='fichero' data-src='".$carpeta_ficheros.$fichero."'>".$fichero."</div>";
}
}
?>

 