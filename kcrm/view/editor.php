<?php session_start( );  ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>editor</title>

<script type="text/javascript" src="../../tinymce/tinymce.min.js"></script>
 
 
	
<script>
	tinymce.init({ 
      selector: 'textarea',
 		  height: 400,
 		   plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste",
		 "textcolor","emoticons",
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | emoticons",  
	 relative_urls: false,
     remove_script_host : false,
     file_browser_callback: openKCFinder
      
   	    });
 	 // function openKCFinder(field_name, url, type, win) {
 		
	  function openKCFinder(field_name, url, type, win) {
		tinyMCE.activeEditor.windowManager.open({
		 file: '../../keditor/kcfinder3/browse.php?opener=tinymce4&field=' + field_name + '&type=' + type,
     //	file: '../../keditor/ckfinder/ckfinder.html',
			title: 'KCFinder',
			width: 750,
			height: 400,
			resizable: true,
			inline: true,
			close_previous:  false
 		}, {
			window: win,
			input: field_name
		});
		return false;
	 }
	</script> 
<script type="text/javascript" src="../js/kaipi.js"></script>    
	
	<style type="text/css">
  .boton_personalizado{
    text-decoration: none;
    padding: 5px;
    font-weight: 200;
    font-size: 12px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 1px solid #0016b0;
  }
</style>
	
</head>
<?php
	require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
	 
	 $obj     = 	new objects;
     $set     = 	new ItemsController;
     $bd	  =	    new Db ;
	
     $bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
     
	 if (isset($_GET['id']))
  		{
 			 $id = $_GET['id'];	
			
             if (isset($_GET['action'])){
				 
				  K_editar($id, $obj,$bd );
			  } 
			
			
 		} 	 
 ?>
<body>
 <form action="editor?action=save&id=<?php echo $_GET['id']; ?>" method="post" enctype="application/x-www-form-urlencoded" id="formulario">	 

 <input type="submit" value="Guardar" class="boton_personalizado">
 
	 <hr>
 
<textarea  cols="50" rows="15" id="editor1" name="editor1"  >
<?php 
	  
  $contenido = K_consulta($id, $obj,$bd);
	  
  echo html_entity_decode(htmlspecialchars( $contenido ));
?>
</textarea>
	  
	 
      
</form>   
</body>
</html>
<?php
  /////////////// llena datos de la consulta individual
 function K_consulta($id ,$obj,$bd ){
 
 	 $sql = "SELECT formato
	  FROM flow.wk_doc_modelo  where id_docmodelo =".$bd->sqlvalue_inyeccion($id ,true);
  	
 
     $resultado = $bd->ejecutar($sql);
	 
  	 $datos = $bd->obtener_array( $resultado);
   
	 return  $datos["formato"];
  }	
  ///
    /////////////// llena para consultar
 function K_editar($id, $obj,$bd ){
 
 
 	  $sql = "UPDATE flow.wk_doc_modelo
			   SET  formato=".$bd->sqlvalue_inyeccion(@$_POST["editor1"], true)."
			 WHERE id_docmodelo =".$bd->sqlvalue_inyeccion($id, true);

   	$resultado = $bd->ejecutar($sql);
  
	$obj->var->kaipi_cierre_pop();
  
  }	
  
  ?>