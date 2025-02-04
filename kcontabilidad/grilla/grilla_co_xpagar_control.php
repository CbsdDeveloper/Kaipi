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
      private $anio;
      
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){
           
 
                $this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  trim($_SESSION['ruc_registro']);

                $this->sesion 	 =  trim($_SESSION['email']);
         
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                
                
                $this->anio       =  $_SESSION['anio'];
 
      }
   
      //-----------------------------------------------------------------------------------------------------------
      //--- busqueda de grilla primer tab
      //-----------------------------------------------------------------------------------------------------------

      public function BusquedaGrilla($festado,$idtramiteb,  $idcasob ){
      
        	
        $output   = array();

        if ($festado == 'N'){
            $filtro1  = " and estado in ('1','2','3') ";
        }else{
            $filtro1  = " and estado = '4' ";
        }

        $filtro2  = "";

        if ( $idtramiteb > 0 ) {
            $filtro2 = " and id_tramite = ".$this->bd->sqlvalue_inyeccion($idtramiteb,true);
            $filtro1 = "";
        }

        if ( $idcasob > 0 ) {
             $filtro2 = " and idcaso = ".$this->bd->sqlvalue_inyeccion($idcasob,true);
             $filtro1 = "";
        }


      	$sql = "SELECT idcaso, fecha, caso ,id_tramite,nombre_siguiente ,estado_tramite ,dias_trascurrido 
                FROM flow.view_proceso_caso_control
                where anio = ".$this->bd->sqlvalue_inyeccion($this->anio,true). $filtro1. $filtro2;
           
         
 
      
      	
      	$resultado  = $this->bd->ejecutar($sql);
       	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
    	   
      	    
            $x = $this->bd->query_array('flow.wk_proceso_casotarea',   // TABLA
            'novedad',                        // CAMPOS
            'idcaso='.$this->bd->sqlvalue_inyeccion( $fetch['idcaso'],true) ,
             '0',
            ' order by idcasotarea desc ',
            ' limit 1 '
            );

          

  	      $output[] = array (
      				    $fetch['idcaso'],
 						$fetch['fecha'],
 	                    trim($fetch['caso']),
 	                    $fetch['id_tramite'],
                         trim($x['novedad']),
                         trim( $fetch['estado_tramite']),
                        $fetch['dias_trascurrido'],
       		
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
 
    		//------ consulta grilla de informacion
    		if (isset($_GET['vestado']))	{
    		    


    		    $festado    = $_GET['vestado'];

                $idtramiteb = $_GET['idtramiteb'];

                $idcasob    = $_GET['idcasob'];
              
		 
    		    
    		    $gestion->BusquedaGrilla($festado,$idtramiteb,  $idcasob  );
    		    
    		}
            	 
 
  
   
 ?>
 
  