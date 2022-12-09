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
         
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idtramite){
      
 
        	
      	$sql = 'SELECT  idprov, razon, secuencial, fechaemision,  baseimponible, baseimpgrav,
                        montoiva, secretencion1,id_compras,valorretbienes , valorretservicios , valretserv100 ,id_compras
                FROM view_anexos_compras
                where id_tramite = '.$this->bd->sqlvalue_inyeccion($idtramite,true)." and estado = 'S' ";
                      	
      	$output = array();
      	
      	$resultado  = $this->bd->ejecutar($sql);
       	
      	while ($fetch=$this->bd->obtener_fila($resultado)){


          $suma_iva =  $fetch['valorretbienes'] +  $fetch['valorretservicios'] +  $fetch['valretserv100'];
 

          $x = $this->bd->query_array('view_anexos_fuente',   // TABLA
          'coalesce(sum( valretair),0) as suma',                        // CAMPOS
          'id_compras='.$this->bd->sqlvalue_inyeccion($fetch['id_compras'],true) // CONDICION
          );


 
 
  	      $output[] = array (
      				    $fetch['fechaemision'],
 						      $fetch['idprov'],
 	                $fetch['razon'],
  	              $fetch['secuencial'],
 	                $fetch['baseimponible'],
      				    $fetch['baseimpgrav'],
      				    $fetch['montoiva'],
  	              $fetch['secretencion1'],
                  $x['suma'],
                  $suma_iva
                  
      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
}
//------------------ 
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
 
    		$idtramite = $_GET['idtramite'];
    		
    		
    		$gestion->BusquedaGrilla($idtramite);
            	 
 
  
   
 ?>
 
  