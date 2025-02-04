<?php
session_start( );
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <title>Plataforma de Gestion Empresarial</title>
	
    <?php  require('Head.php')  ?> 
    
 	<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>

</head>
 
<body>
     <div class="modal-body"> 
                      	
          <H5>Carga de archivo de documentos</h5>
                            
       <form action="docuload.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data" id="fload1" accept-charset="UTF-8">
                             
                             <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                             
                        		    <input type="file" id = 'userfile' name="userfile" class="filestyle" data-icon="true" accept="pdf/*" data-inputsize="medium">
							
                            </div>
				 
				  			 <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                             
                        		  <input name="detalle" type="text" required="required" id="detalle" placeholder="detalle del documento" class="form-control">
							
         				     </div>
				 
                          
         <div class="col-md-12" style="padding-bottom:5px; padding-top:5px">
                       		  <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-flash"></span> Cargar Informacion</button>
                             </div>
							 
							 <input name="file" type="hidden" id="file" value="ok"> 
 						   
                           </form> 
      </div>
 </body>
</html>
<?php
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

$obj     = 	new objects;

$set     = 	new ItemsController;

$bd	   =	     	new Db ;

$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);

	
    $id = $_GET['id'];
	
	if (isset($_POST["file"]))	{
 
 		$valida  = $_POST["file"];
		$detalle = $_POST["detalle"];
		$sesion  = $_SESSION['email'];
        $hoy 	 = date("Y-m-d");  
		
		if ($valida  == 'ok') {

		    
		    $Afolder = $bd->query_array('wk_config','carpeta', 'tipo='.$bd->sqlvalue_inyeccion(61,true));
		    
            $folder = $Afolder['carpeta'];
   			//$folder.$filename
			
			$archivo_temporal 	= $_FILES["userfile"]['tmp_name'];
			$subir 				= $_FILES["userfile"]['name'];
			$archivo 			= $bd->_file_random( $subir );
			//$archivo = $_FILES["userfile"]['name'];
			
  			
			$prefijo = substr(md5(uniqid(rand())),0,6);
		   
		    $copiado = move_uploaded_file($archivo_temporal,$folder.$archivo); 
  		   
			if($copiado==false){ 
 			
				$archivo = '-';
 			 
			}
			
			echo $archivo;
 
 	       $ATabla = array(
            	array( campo => 'idven_doc',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
				array( campo => 'idvengestion',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $id, key => 'N'),
				array( campo => 'archivo',tipo => 'VARCHAR2',id => '2',add => 'S', edit => 'S', valor =>$archivo, key => 'N'),
				array( campo => 'carpeta',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $folder, key => 'N'),
				array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor => $sesion, key => 'N'),
				array( campo => 'fecha',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor =>  $hoy, key => 'N'),
				array( campo => 'detalle',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'S', valor => $detalle, key => 'N')
				);
			
		  $bd->_InsertSQL('ven_cliente_doc',$ATabla,'ven_cliente_doc_idven_doc_seq'); 

			// BusquedaDoc(oTableProducto,idvengestion);
       	echo '<script type="text/javascript">
 			          window.close();
		     </script>'; 
		  
			  
			
	}	
 }
?>