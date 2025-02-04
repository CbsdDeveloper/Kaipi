<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
	
 	
	private $obj;
	private $bd;
	
	private $ruc;
	private $sesion;
	private $hoy;
	private $POST;
	private $datos;
	
	//-----------------------------------------------------------------------------------------------------------
	//Constructor de la clase
	//-----------------------------------------------------------------------------------------------------------
	function proceso( ){
		//inicializamos la clase para conectarnos a la bd
		
		$this->obj     = 	new objects;
		$this->bd	   =	new Db ;
		
		$this->ruc       =  $_SESSION['ruc_registro'];
		
		$this->sesion 	 =  trim($_SESSION['email']);
		
		$this->hoy 	     =  date("Y-m-d"); 
		
		$this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function guarda_archivo($archivo, $id, $detalle ){
        
 
	    $hoy   = date("Y-m-d");
	    
	    $fecha = "to_date('".$hoy."','yyyy/mm/dd')";
		
		$file =  '../../userfiles/files/' ;
		
 		if ($id > 0 ) {
			
			
 
	    
				$sql = "INSERT INTO flow.wk_proceso_descarga(
							idproceso, archivo, detalle,  prioridad, ubica)
					VALUES (".
					$this->bd->sqlvalue_inyeccion($id, true).",".
				    $this->bd->sqlvalue_inyeccion(trim($archivo), true).",".
					$this->bd->sqlvalue_inyeccion($detalle, true).",".
					$this->bd->sqlvalue_inyeccion('alta', true).",".			
					$this->bd->sqlvalue_inyeccion($file, true).")";

					$this->bd->ejecutar($sql);

					$this->BusquedaDoc( $id ) ;
	   }
		
	}
//---------------------------------------------------------
public function BusquedaDoc( $id){
	    
	    // Soporte Tecnico

	  $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
	   
	
	
	    
	    $qquery = array(
	        array( campo => 'idproceso_des',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'idproceso',valor => $id ,filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'prioridad',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('flow.wk_proceso_descarga',$qquery  );
	    
	    
	    echo '<table id="jsontableDocUserVisor" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th '. $estilo. ' width="40%" > Detalle </th>
                 <th '. $estilo. ' width="30%" > Archivo </th>
			     <th '. $estilo. ' width="20%" > Prioridad </th>
                 <th '. $estilo. ' width="10%" > Acciones</th></thead> </tr>';
	    
 
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =   $fetch['idproceso_des'] ;
 	        
			  $boton1 = ' ';
            
          
                $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
          
	       
	        
	        $boton2 = '<button class="btn btn-xs btn-warning"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
	                
	        echo ' <tr>';
	        echo ' <td>'.$fetch['detalle'].'</td>'; 
 	        echo ' <td>'.$fetch['archivo'].'</td>';
	        echo ' <td>'.$fetch['prioridad'].'</td>';
	        echo ' <td>'.$boton2.$boton1.'</td>';
 	        
	        echo ' </tr>';
	    }
	    
	    
	    echo "   </tbody>
               </table>";
	    
	    
	    pg_free_result($resultado);
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 

//------ grud de datos insercion
if (isset($_POST["archivo"]))	{
	
 
    $archivo 			=     $_POST["archivo"];
	
    $id 				=     $_POST["id"];
	
    $detalle 			=     $_POST["detalle"];
    
    $gestion->guarda_archivo( $archivo, $id, trim($detalle) );
 
	
}



?>
 
  