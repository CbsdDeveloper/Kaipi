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
	function guarda_archivo($archivo, $id, $detalle,$modulo ){
        
 
	    $hoy   = date("Y-m-d");
	    
	    $fecha = "to_date('".$hoy."','yyyy/mm/dd')";
 	    
	   $user =  $this->bd->__user($this->sesion );
	    
  	    
	    $sql = "INSERT INTO pdoc.doc_modulo( id_departamento,idprov, modulo, detalle, sesion, fecha, archivo, codigo,registro)
            VALUES (".
            $this->bd->sqlvalue_inyeccion($user['id_departamento'], true).",". 
            $this->bd->sqlvalue_inyeccion('-', true).",". 
            $this->bd->sqlvalue_inyeccion($modulo, true).",". 
            $this->bd->sqlvalue_inyeccion($detalle, true).",".
            $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
            $fecha.",".
            $this->bd->sqlvalue_inyeccion(trim($archivo), true).",".
            $this->bd->sqlvalue_inyeccion($id, true).",".
            $this->bd->sqlvalue_inyeccion($this->ruc, true).")";
          
            $this->bd->ejecutar($sql);
             
            $this->BusquedaDoc( $id,$modulo  ) ;
	
	}
//-----------------------------------------------------
	//--- calcula libro diario
	function eliminar( $id ,$idcodigo  ){
	    
 
	    //$file = '../archivos/xml/'.$archivo ;
	    
	    $sql = "delete from  pdoc.doc_modulo 
                 where id_nom_doc =". $this->bd->sqlvalue_inyeccion($idcodigo, true) ;
 
            
            $this->bd->ejecutar($sql);
            
            
            $this->BusquedaDoc( $id ) ;
            
	}
//---------------------------------------------------------
public function BusquedaDoc( $id ){
	    
	    // Soporte Tecnico
	    
	   
	    
	    $qquery = array(
	        array( campo => 'id_nom_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'codigo',valor => $id,filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'modulo',valor => trim('servicios_rentas') ,filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('pdoc.doc_modulo',$qquery );
	    
 
	    
	    echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle </th>
                <th> Sesion </th>
                <th> Acciones</th></thead> </tr>';
	    
 	    
	    // carpeta virtual -------------------------------
	    //-----------------------------------------------
	    $folder = $this->bd->_carpeta_archivo(5,1);
	    //-----------------------------------------------
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =  $fetch['id_nom_doc'] ;
	        
	        $archivo = $folder.trim($fetch['archivo']);
 	        
	        $boton1 = '';
	        
	        if ( $this->sesion  == trim($fetch['sesion'] )){
	            
	            $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
	            
	        }
	            
	            
	        $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="javascript:PoneDoc('. "'" .$archivo ."'". ')">
                           <i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;&nbsp;';
	                
	        echo ' <tr>';
	        
	        echo ' <td>'.$idproducto.'</td>';
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
	//----------------------BusquedaDocVisor
	
	public function BusquedaDocVisor( $id){
	    
	    // Soporte Tecnico
	    
	    
	    
	    $qquery = array(
	        array( campo => 'id_nom_doc',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'codigo',valor => $id,filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'modulo',valor => 'servicios_rentas',filtro => 'N', visor => 'S')
	    );
	    
	    $resultado = $this->bd->JqueryCursorVisor('pdoc.doc_modulo',$qquery );
	    
	    
	    
	    echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle </th>
                <th> Sesion </th>
                <th> Acciones</th></thead> </tr>';
	    
	    
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =  $fetch['id_nom_doc'] ;
	        
	        
 
	        $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="javascript:PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
	        
	        echo ' <tr>';
	        
	        echo ' <td>'.$idproducto.'</td>';
	        echo ' <td>'.$fetch['fecha'].'</td>';
	        echo ' <td>'.$fetch['detalle'].'</td>';
	        echo ' <td>'.$fetch['sesion'].'</td>';
	        echo ' <td>'.$boton2.'</td>';
	        
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
    $modulo 			=     $_POST["modulo"];
    
    $gestion->guarda_archivo( $archivo, $id, trim($detalle) ,$modulo);
 
	
}

if (isset($_GET["accion"]))	{

    $accion = $_GET["accion"];
	
    $id 	=     $_GET["id"];
	
    if ($accion == 'visor' ){
        $gestion->BusquedaDoc(   $id  );
    }
    
    if ($accion == 'del' ){
        $idcodigo 	=     $_GET["idcodigo"];
        $gestion->eliminar(   $id ,$idcodigo );
        
    }
    
    if ($accion == 'consulta' ){
        $gestion->BusquedaDocVisor(   $id  );
    }
    
}
    
 


?>
 
  