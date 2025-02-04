<?php 
 session_start();   
    
 require '../../kconfig/Db.class.php';    // fichero de conexion y funciones de manejo de base de datos

 require '../../kconfig/Obj.conf.php';    // fichero de la clase objetos para manejo de formularios, objetos
  
    class proceso{
 
      private $obj;
      private $bd;
      
      private $ruc;
      private $sesion;
      private $POST;

      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function proceso( ){

				$this->obj     = 	new objects;
                $this->bd	   =	new Db ;
    
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
        
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
 
      }
/*
  Visualiza la informacion en la tabla
*/      
public function BusquedaGrilla($estado,$tipo,$fecha1,$fecha2,$idbodega1){
      
       
      	$qquery = 
      			array( 
      			array( campo => 'id_movimiento',   valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'fecha',   		valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'detalle',   	valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'comprobante',  valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'documento',   	valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'idprov',   	valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'proveedor',   	valor => '-',  filtro => 'N',   visor => 'S'),
      			array( campo => 'carga',     	valor => '0',  filtro => 'S',   visor => 'N'),
      			array( campo => 'estado',     	valor => $estado,  		filtro => 'S',   visor => 'N'),
      		    array( campo => 'registro',     valor => $this->ruc ,  	filtro => 'S',   visor => 'N'),
      			array( campo => 'idbodega',     valor => $idbodega1 ,  	filtro => 'S',   visor => 'N'),
       			array( campo => 'tipo',       	valor => $tipo,  		filtro => 'S',   visor => 'N')
       			);
        
      	$this->bd->__between('fecha',$fecha1,$fecha2);  							// Funcion que agrega y personaliza el between para busquedas de fecha.
      			
      	$resultado = $this->bd->JqueryCursorVisor('view_inv_movimiento',$qquery ); // Funcion que retorna cursor del arreglo de busqueda con filtro
      
      	while ($fetch=$this->bd->obtener_fila($resultado)){
      		 
      		$output[] = array (
      							$fetch['id_movimiento'],
								$fetch['fecha'],
								$fetch['detalle'],
      		                    $fetch['comprobante'],
								$fetch['documento'],
								$fetch['idprov'],
								$fetch['proveedor']
       					);
      	}	
      
      	echo json_encode($output);
      }
   
 }    
/*
  Llama a la clase de proceso para la visualizacion de los datos en tabla
*/   
 
    		$gestion   = 	new proceso;
		 
   			 if (isset($_GET['estado']))	{
   			 
   			 	$estado		= $_GET['estado'];
   			 	
   			 	$tipo		= $_GET['tipo'];
   			 	
   			 	$fecha1		= $_GET['fecha1'];
   			 	
   			 	$idbodega1	= $_GET['idbodega1'];
   			 	
   			 	$fecha2		= $_GET['fecha2'];
   		 	 	 
   			 	$gestion->BusquedaGrilla($estado,$tipo,$fecha1,$fecha2,$idbodega1);
   			 	 
   			 }
   
 ?>