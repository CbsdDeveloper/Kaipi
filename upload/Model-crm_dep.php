<?php
session_start( );

require '../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
        
 
	    $id = 0;
	    
	    $hoy   = date("Y-m-d");
	    
	    $array          = $this->bd->__user($this->sesion) ;
	    
	    $iddepartamento = $array['id_departamento'];
	    
 		
		// $file =  '../../userfiles/files/' ;
		$file =  '../archivos/docs_interes/' ;
		
 		 
			
   		    
 
	    
				$sql = "INSERT INTO flow.wk_proceso_descarga(
							idproceso, iddepartamento,sesion, creacion ,archivo, detalle,  prioridad, ubica)
					VALUES (".
					$this->bd->sqlvalue_inyeccion($id, true).",".
					$this->bd->sqlvalue_inyeccion($iddepartamento, true).",".
					$this->bd->sqlvalue_inyeccion($this->sesion , true).",".
					$this->bd->sqlvalue_inyeccion($hoy, true).",".
				    $this->bd->sqlvalue_inyeccion(trim($archivo), true).",".
					$this->bd->sqlvalue_inyeccion($detalle, true).",".
					$this->bd->sqlvalue_inyeccion('alta', true).",".			
					$this->bd->sqlvalue_inyeccion($file, true).")";

					$this->bd->ejecutar($sql);

					$this->BusquedaDoc( $iddepartamento ) ;
	  
		
	}
//---------------------------------------------------------
public function BusquedaDoc( $id){
	    
	    // Soporte Tecnico

	  $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
	   
	
	  if ( $id == '0'){
	      
	      $array          = $this->bd->__user($this->sesion) ;
	      $id             = $array['id_departamento'];
	  }
	
	    
	    $qquery = array(
	        array( campo => 'idproceso_des',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'iddepartamento',valor => $id ,filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'prioridad',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('flow.wk_proceso_descarga',$qquery  );
	    
	    
	    echo '<table id="jsontableDocUserVisor" style="font-size: 12px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th '. $estilo. ' width="70%" > Lista de archivos disponibles </th>
                  <th '. $estilo. ' width="20%" > Creado por </th>
                 <th '. $estilo. ' width="10%" > Visor</th></thead> </tr>';
	    
 
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproceso_des =   $fetch['idproceso_des'] ;
 	        
			    $boton1 = ' ';
            
			    if ( trim($fetch['sesion']) == $this->sesion ){
			        
			        $boton1 = '<button class="btn btn-xs btn-default"
                              title="Eliminar Registro"
                              onClick="goToURLDocdel('.$idproceso_des.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
			    }
          
                
	        
	        $boton2 = '<button class="btn btn-xs btn-info"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;';
	                
	        echo ' <tr>';
	        echo ' <td>'.$fetch['detalle'].'</td>'; 
	        echo ' <td>'.$fetch['sesion'].'</td>';
	        echo ' <td>'.$boton2.$boton1.'</td>';
 	        
	        echo ' </tr>';
	    }
	    
	    
	    echo "   </tbody>
               </table>";
	    
	    
	    pg_free_result($resultado);
	}
	//--------------------------------------------------
	
	function Eliminar(  $idproceso_des  ){
	    //inicializamos la clase para conectarnos a la bd
	    
	 
	    $this->bd->JqueryDeleteSQL ('flow.wk_proceso_descarga' ,'idproceso_des='.$this->bd->sqlvalue_inyeccion($idproceso_des, true));
	    
	    
	}
	
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;
 
 
 
    $archivo 			=     $_POST["archivo"];
	
    $id 				=     $_POST["id"];
	
    $detalle 			=     $_POST["detalle"];

	$accion 			=     $_POST["accion"];
    

	if (trim($accion) == 'add'){
	    
		$gestion->guarda_archivo( $archivo, $id, trim($detalle) );
    }
 
    
    if (trim($accion) == 'visor'){
        
        $gestion->BusquedaDoc(   $id  );
        
    }
 
    if (trim($accion) == 'del'){
        
        
        $idproceso_des 			=     $_POST["idproceso_des"];
        
        $gestion->Eliminar( $idproceso_des 	 );
        
        $gestion->BusquedaDoc(   $id  );
        
    }


?>