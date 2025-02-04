<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
  
  
    class proceso{
 
  
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $hoy;
      private $POST;
      private $ATabla;
      private $idsesion;
      private $tabla ;
      private $secuencia;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
                $this->hoy 	     =  $this->bd->hoy();
        
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
         
      }
   
 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function div_actualiza($nombre ){
            //inicializamos la clase para conectarnos a la bd
       
 
             echo '<script type="text/javascript">';
              
              
             echo  '$("#adjunto").val("'.$nombre.'" ); ';               
   
             echo '</script>';
 
            return $resultado;   
 
      }     
   
   
    	 
     //--------------------------------------------------------------------------------
      //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
      //--------------------------------------------------------------------------------        
     function agregar(   ){
 
     	
     	$ubica = $_GET['actividad'] ; 
     	
     	
     	$folder = "../../../userfiles/".$ubica."/";
     	
     	if ( 0 < $_FILES['file']['error'] ) {
     		echo 'Error: ' . $_FILES['file']['error'] . '<br>';
     	}
     	else {
     		move_uploaded_file($_FILES['file']['tmp_name']  ,$folder. $_FILES['file']['name']);
     	}
     	
     	//$folder. $_FILES['file']['name']   $ubica
     	
     	$archivo =   $folder. $_FILES['file']['name'];
     	
     	$this->div_actualiza($archivo);
     	
     	$resultado_notas = 'Archivo cargado correctamente: ';
     	
     	echo $resultado_notas;
     	
     }	

 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
 
    $gestion   = 	new proceso;
    
 
    
    $gestion->agregar( );
     
   
 ?>
 
  