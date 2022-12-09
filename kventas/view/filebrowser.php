<style>
 .fichero  {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 13px;
    color:#322E2E;
 }
</style>
<script> 
$(document).on("click","div.fichero",function(){
		  item_url = $(this).data("src");
		  var args = top.tinymce.activeEditor.windowManager.getParams();
		  win = (args.window);
		  input = (args.input);
		  win.document.getElementById(input).value = item_url;
		  top.tinymce.activeEditor.windowManager.close();
		});
</script> 
<?php
session_start( ); 
$carpeta_ficheros = '../../userfiles/kaipi/' ; //$_SESSION['directorio_crm'];

$directorio = opendir($carpeta_ficheros); // Abre la carpeta

while ($fichero = readdir($directorio)) { // Lee cada uno de los ficheros
  if (!is_dir($fichero)){ // Omite las carpetas
	  	echo "<div class='fichero' data-src='".$carpeta_ficheros.$fichero."'>".$fichero."</div>";
  }
}
?>

 