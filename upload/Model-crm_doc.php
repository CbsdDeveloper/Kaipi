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
		
		$this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
		
	}
   
	//--- calcula libro diario
	function guarda_archivo($archivo, $id, $detalle,$visor ){
        
 
	    $hoy   = date("Y-m-d");
	    
	    $fecha = "to_date('".$hoy."','yyyy/mm/dd')";
	    //$file = '../archivos/xml/'.$archivo ;
		
 		if ($id > 0 ) {
			
			if ( $visor == '1'){
				$inicio = 'S';
			}else	
				{
				$inicio = 'N';
			}
	    
				$sql = "INSERT INTO flow.proceso_doc(
							idcaso, detalle, sesion, fecha, archivo,inicio,registro)
					VALUES (".
					$this->bd->sqlvalue_inyeccion($id, true).",".
					$this->bd->sqlvalue_inyeccion($detalle, true).",".
					$this->bd->sqlvalue_inyeccion($this->sesion, true).",".
					$fecha.",".
					$this->bd->sqlvalue_inyeccion(trim($archivo), true).",".
					$this->bd->sqlvalue_inyeccion(trim($inicio), true).",".
					$this->bd->sqlvalue_inyeccion($this->ruc, true).")";

					$this->bd->ejecutar($sql);

			
				  if ( trim($visor) == '1'){
					  
					  $this->BusquedaDocVisor( $id ) ;
					  
					}else  {
					  
					  $this->BusquedaDoc( $id ) ;
					}
			
					
			
			
			
	   }
	}
//---------------------------------------------------------
public function BusquedaDoc( $idprov){
	    
	    // Soporte Tecnico

	  $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
	   
	    
	    $qquery = array(
	        array( campo => 'id_proc_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'idcaso',valor => trim($idprov),filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('flow.proceso_doc',$qquery );
	    
	    
	    echo '<table id="jsontableDocUserVisor" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th '. $estilo. ' > Fecha </th>
                <th '. $estilo. ' > Detalle </th>
                <th '. $estilo. ' > Sesion </th>
                <th '. $estilo. ' > Acciones</th></thead> </tr>';
	    
	    
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =  $fetch['id_proc_doc'] ;
			 $sesion    =   trim($fetch['sesion']) ;
	        
			  $boton1 = ' ';
            
            if ( $this->sesion == $sesion) {
         
                $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdel('.$idproducto.","."'".$idprov."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
            }
 	        
	       
	        
	        $boton2 = '<button class="btn btn-xs btn-warning"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
	                
	        echo ' <tr>';
	        
 	        echo ' <td>'.$fetch['fecha'].'</td>';
	        echo ' <td>'.$fetch['detalle'].'</td>';
	        echo ' <td>'.$fetch['sesion'].'</td>';
	        echo ' <td>'.$boton2.$boton1.'</td>';
 	        
	        echo ' </tr>';
	    }
	    
	    
	    echo "   </tbody>
               </table>";
	    
	    
	    pg_free_result($resultado);
	}

	//---------------------------------------------------------
public function BusquedaDocVisor( $idprov){
	    
 
             
           

	  $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';
	   
	    
	    $qquery = array(
	        array( campo => 'id_proc_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'idcaso',valor => trim($idprov),filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('flow.proceso_doc',$qquery );
	    
	    
	    echo '<table id="jsontableDocUserVisor" style="font-size: 10px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">  ';
	    
	   
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =  $fetch['id_proc_doc'] ;
			
			 $sesion    =   trim($fetch['sesion']) ;
	        
 
			   $boton1 = '<button class="btn btn-xs btn-danger"
                              title="Eliminar Registro"
                              onClick="goToURLDocdelvi('.$idproducto.","."'".$idprov."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
            
			
	        echo ' <tr>';
	        
 	        echo ' <td>'.$fetch['detalle'].'</td>';
	        echo ' <td>'. $boton1.'</td>';
  	        
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
	
	$visor 				=     $_POST["visor"];
	
	
    
    $gestion->guarda_archivo( $archivo, $id, trim($detalle),$visor );
 
	
}



?>
 
  