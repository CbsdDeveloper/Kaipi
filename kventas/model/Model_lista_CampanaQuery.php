 <?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
	$obj   = 	new objects;
	$bd	   = 	new Db ;
	
 	
    
	$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
	$sesion 	 =     $_SESSION['email'];
	
	$id			 =     $_GET["id"];
	
	 	    
    $sql = "SELECT id_campana, fecha,   medio,   idvengrupo,   titulo
	FROM view_ventas_campana
	where publica = 'S' ";
             
     $stmt = $bd->ejecutar($sql);
		
     $ViewFormCampana = '';
   
   while ($fila=$bd->obtener_fila($stmt)){
      
       $medio = $fila['medio'];
       
       if ($medio ==  'email personalizado'){
           $cimagen ='c_mailing.png';
       }
       if ($medio ==  'email grupo'){
           $cimagen ='c_mail.png';
       }
       if ($medio ==  'telefono'){
           $cimagen ='c_phone.png';
       }
       if ($medio ==  'whatsapp'){
           $cimagen ='c_wasap.png';
       }
 
       
 
       $ViewFormCampana .= '<div class="col-md-3" align="center">
			  <img   src="../../kimages/'.$cimagen.'" width="64" height="64" title="'.$medio.'" /> 
			  <h6>'.$fila['titulo'].'</h6> <p>'.$fila['fecha'].'</p>
			</div>';
      
  }
  
  echo $ViewFormCampana;
  
?>
 
  