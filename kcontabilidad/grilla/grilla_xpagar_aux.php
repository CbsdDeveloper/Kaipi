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
      public function BusquedaGrilla($tipo,$anio){
      
  
        $this->Actualiza_aux( );
        
        $this->Actualiza_comprobante( );
     
       	$cadena0 =  '( registro = '.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true).') and ';
        
       	$cadena1 = '( modulo ='.$this->bd->sqlvalue_inyeccion(trim($tipo),true).") and ";
      
       	$cadena2 = '( anio ='.$this->bd->sqlvalue_inyeccion(trim($anio),true).")  ";
      	
      	
      	$where = $cadena0.$cadena1.$cadena2;
      	
      	$sql = 'SELECT  idprov,razon,max(fecha) as fecha, count(*) as transacciones
                from view_aux a where '. $where. ' group by idprov,razon order by 2';
      	
       
      	
      	$resultado  = $this->bd->ejecutar($sql);
 
      	
      	$output = array();
      	
      	
      	while ($fetch=$this->bd->obtener_fila($resultado)){
 
 	          $output[] = array (
      				    $fetch['idprov'],
 						$fetch['razon'],
						$fetch['fecha'],
 	                    $fetch['transacciones']
        		);	 
      		
      	}
 
 
      	pg_free_result($resultado);
      	
       echo json_encode($output);
      	
      	
      	}
 /*
 */
public function Actualiza_aux( ){
    
    $anio = date('Y');

    $sql1 = 'select id_asiento,id_asiento_aux,comprobante
              from co_asiento_aux 
              where detalle is NULL and
                    anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'  order by 1';


 

$stmt1 = $this->bd->ejecutar($sql1);



while ($fila=$this->bd->obtener_fila($stmt1)){
    
    $id_asiento          =   $fila['id_asiento'];
    $id_asiento_aux      =   $fila['id_asiento_aux'];

    $comprobante      =   trim($fila['comprobante']);

    $x = $this->bd->query_array('co_asiento','detalle,fecha,comprobante', 'id_asiento='.$this->bd->sqlvalue_inyeccion( $id_asiento,true)  );

    if ( empty( $comprobante )){

        $sql = "UPDATE co_asiento_aux
        SET  fecha= ". $this->bd->sqlvalue_inyeccion( $x['fecha'],true).",
             comprobante= ". $this->bd->sqlvalue_inyeccion( $x['comprobante'],true).",
            detalle= ". $this->bd->sqlvalue_inyeccion(trim( $x['detalle'] ),true)."
         WHERE id_asiento_aux = ".$this->bd->sqlvalue_inyeccion( $id_asiento_aux,true);

    }else  {   

            $sql = "UPDATE co_asiento_aux
                        SET  fecha= ". $this->bd->sqlvalue_inyeccion( $x['fecha'],true).",
                            detalle= ". $this->bd->sqlvalue_inyeccion(trim( $x['detalle'] ),true)."
                    WHERE id_asiento_aux = ".$this->bd->sqlvalue_inyeccion( $id_asiento_aux,true);

      }
  
      $this->bd->ejecutar($sql);

    
    }
}
/*
comprobante
*/
public function Actualiza_comprobante( ){
    
    $anio = date('Y');

    $sql1 = 'select id_asiento,id_asiento_aux,comprobante
              from co_asiento_aux 
              where comprobante is NULL and
                    anio = '.$this->bd->sqlvalue_inyeccion($anio,true).'  order by 1';
 
    
$stmt1 = $this->bd->ejecutar($sql1);



            while ($fila=$this->bd->obtener_fila($stmt1)){
                
                $id_asiento          =   $fila['id_asiento'];
                $id_asiento_aux      =   $fila['id_asiento_aux'];

                $comprobante      =   trim($fila['comprobante']);

                $x = $this->bd->query_array('co_asiento','detalle,fecha,comprobante', 'id_asiento='.$this->bd->sqlvalue_inyeccion( $id_asiento,true)  );
             

                    $sql = "UPDATE co_asiento_aux
                    SET  fecha= ". $this->bd->sqlvalue_inyeccion( $x['fecha'],true).",
                         comprobante= ". $this->bd->sqlvalue_inyeccion( $x['comprobante'],true)." 
                    WHERE id_asiento_aux = ".$this->bd->sqlvalue_inyeccion( $id_asiento_aux,true);

                
                    $this->bd->ejecutar($sql);

                
            }

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
            if (isset($_GET['tipo']))	{
            
                $tipo   = $_GET['tipo'];
                $anio   =  $_GET['anio'];
              	 
                $gestion->BusquedaGrilla($tipo,$anio);
            	 
            }
  
  
   
 ?>
 
  