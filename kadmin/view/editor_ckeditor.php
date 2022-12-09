<?php session_start( );  ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>editor</title>
<script type="text/javascript" src="../../keditor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../../keditor/ckfinder/ckfinder.js"></script> 
<link href="../../keditor/ckeditor/samples/sample.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/kaipi.js"></script>    
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

<textarea class="ckeditor" cols="80" id="editor1" name="editor1" rows="10">
<?php 
	  
  $contenido = K_consulta($id, $obj,$bd);
	  
  echo html_entity_decode(htmlspecialchars( $contenido ));
?>
</textarea>
	 
	<p style="padding: 3px">
 <input type="submit" value="Guardar">
</p>	 
                               
<script type="text/javascript">
// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
	{
     document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'value (line 32).' ) ;
	}
	else
	{
	  var URL_ubicacion ;
		
	    URL_ubicacion = url_editor();
	  // Just call CKFinder.setupCKEditor and pass the CKEditor instance as the first argument.
	  // The second parameter (optional), is the path for the CKFinder installation (default = "/ckfinder/").
		var editor = CKEDITOR.replace( 'editor1', {
 		height: 400
	} );
		
 		
	CKFinder.setupCKEditor( editor, URL_ubicacion) ;
		
	
    // It is also possible to pass an object with selected CKFinder properties as a second argument.
	//  CKFinder.setupCKEditor( editor, { basePath : '../', skin : 'v1' } ) ;
  }
</script>
 </form>   
</body>
</html>
<?php
  /////////////// llena datos de la consulta individual
 function K_consulta($id ,$obj,$bd ){
 
 	 $sql = "SELECT contenido
	  FROM ven_plantilla  where id_plantilla =".$bd->sqlvalue_inyeccion($id ,true);
  	
	 
 

     $resultado = $bd->ejecutar($sql);
	 
  	 $datos = $bd->obtener_array( $resultado);
   
	 return  $datos["contenido"];
  }	
  ///
    /////////////// llena para consultar
 function K_editar($id, $obj,$bd ){
 
     
 	  $sql = "UPDATE ven_plantilla
			   SET  contenido=".$bd->sqlvalue_inyeccion(@$_POST["editor1"], true)."
			 WHERE id_plantilla =".$bd->sqlvalue_inyeccion($id, true);

   	$resultado = $bd->ejecutar($sql);
  
	$obj->var->kaipi_cierre_pop();
  
  }	
  
  ?>