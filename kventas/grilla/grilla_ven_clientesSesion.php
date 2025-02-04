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
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  $_SESSION['ruc_registro'];
                $this->sesion 	 =  $_SESSION['email'];
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($id,$estado){
      
 
          $sql = "UPDATE ven_cliente SET idprov = idvencliente WHERE idprov= '0'";
    
          $this->bd->ejecutar($sql);
          
          
          $sql = "UPDATE ven_cliente SET idprov = idvencliente WHERE idprov= '-'";
          
          $this->bd->ejecutar($sql);
           
          
          if ($estado == '0'){
              $sql = 'SELECT idvencliente,  razon,   telefono, correo, movil ,direccion,proceso
                  FROM  ven_cliente
                  where estado ='.$this->bd->sqlvalue_inyeccion( $estado, true).' and
                        sesion ='.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true);
          }
          else {
              $sql = 'SELECT idvencliente,  razon,   telefono, correo, movil ,direccion,proceso
                  FROM  ven_cliente
                  where estado ='.$this->bd->sqlvalue_inyeccion( $estado, true).' and
                        id_campana ='.$this->bd->sqlvalue_inyeccion( $id, true).' and
                        sesion ='.$this->bd->sqlvalue_inyeccion( trim($this->sesion), true);
          }
      
          
      	$resultado  = $this->bd->ejecutar($sql);
 
      	/*
      	enviado
      	enviar
      	abierto
      	interes
      	*/
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $cimagen = '<img src="../../kimages/v_proceso.png" width="24" height="24" align="absmiddle" title="En Proceso"/>';
      	    
      	    
      	    if ($fetch['proceso'] == 'enviado' ){
      	        $cimagen = '<img src="../../kimages/v_enviado.png" width="24" height="24" align="absmiddle" title="Enviado"/>';
      	    }
      	    
      	    if ($fetch['proceso'] == 'enviar' ){
      	        $cimagen = '<img src="../../kimages/v_enviar.png" width="24" height="24" align="absmiddle"  title="Enviar"/>';
      	    }
      	    if ($fetch['proceso'] == 'abierto' ){
      	        $cimagen = '<img src="../../kimages/v_abierto.png" width="24" height="24" align="absmiddle"  title="Abierto"/>';
      	    }
      	    if ($fetch['proceso'] == 'interes' ){
      	        $cimagen = '<img src="../../kimages/v_interes.png" width="24" height="24" align="absmiddle"  title="Interes"/>';
      	    }
      	    
      	    
      	    
		 	$output[] = array (
		      				    $fetch['idvencliente'],
		 						$fetch['razon'],
		      				    $fetch['telefono'],
		      				    $fetch['correo'],
		 	                    $fetch['movil'] ,
		 	                    $cimagen
		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
/*'ffecha1' : ffecha1  ,
 'ffecha2' : ffecha2  ,
 'festado' : festado  */
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['id_campana']))	{
            
            	 
            	$id     = $_GET['id_campana'];
            	$estado = $_GET['estado'];
            	
            	
            	
            	
            	$gestion->BusquedaGrilla($id,$estado);
            	 
            }
  
  
   
 ?>
 
  