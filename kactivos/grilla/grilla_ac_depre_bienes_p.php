<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   
 	
 	
    require '../../kconfig/Obj.conf.php';  
  
  
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
                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------
      public function BusquedaGrilla($idsede,$ccustodio,$ccactivo,$cuenta,$anio,$fecha2){
      
 
          
          $len_nombre = strlen(trim($ccustodio));
           
          
          if ( $len_nombre >= 4 ){
              $cadena  = " and razonLIKE.%".trim(strtoupper($ccustodio))."%";
          }else {
              $cadena = '';
          }
          
           
          $mesmenos =  date("Y-m-d",strtotime($fecha2."- 1 month"));
          
   
          
          $len_bien = strlen(trim($ccactivo));
          
          if ( $len_bien >= 4 ){
               $cadena1  = " and detalle LIKE.%".trim(strtoupper($ccactivo))."%";
          }else {
              $cadena1 = ' ';
          }
          
          $sql = "select *
			from activo.view_bienes 
            where uso <> 'Baja' and
                  cuenta = ".$this->bd->sqlvalue_inyeccion($cuenta,true) ."  and 
                  tipo_bien = 'BLD' and 
                  fecha_adquisicion <= ".$this->bd->sqlvalue_inyeccion($mesmenos,true) .$cadena1.$cadena."  
           order by detalle desc"   ;
          
          
          $resultado= $this->bd->ejecutar($sql);
 
 
          
      	$output = array();
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
      	    $tiempo = $fetch['tiempo_anio'].'/'.$fetch['vida_util'];
      	    
		 	$output[] = array (
		      				    $fetch['id_bien'],
                		 	    $fetch['detalle'],
                		 	    $fetch['marca'],
                		 	    $fetch['serie'],
		 	                    $fetch['estado'],
		 	                    $fetch['fecha_adquisicion'],
		 	                    $tiempo,
  		      				    $fetch['costo_adquisicion'] 
 		      		);	 
      		
      	}
 
 
 	echo json_encode($output);
      	
      	
      	}
 
   
 }    
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------ 
///------------------------------------------------------------------------
 
///------------------------------------------------------------------------ 
 
    		$gestion   = 	new proceso;
 
   
          
            //------ consulta grilla de informacion
            if (isset($_GET['idsede']))	{
            
 
                $idsede = $_GET['idsede'];
                
                $ccustodio = $_GET['ccustodio'];
                
                $cuenta = $_GET['cuenta'];
                
                $anio = $_GET['anio'];
                
                $ccactivo = $_GET['ccactivo'];
                
                $fecha2   = $_GET['fecha2'];
 
              	 
                $gestion->BusquedaGrilla($idsede,$ccustodio,$ccactivo,$cuenta,$anio,$fecha2);
            	 
            }
  
  
   
 ?>
 
  