<?php
session_start( );

require '../kconfig/Db.class.php';    

require '../kconfig/Obj.conf.php';  


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
	    
	    $temp = explode('.', $archivo) ;
	    
	    $tipoa = $temp[1];

	    if ( $tipoa == 'pdf') {
	        
	        $tipo = 'documento';
	        
	    }else {
	        
	        $tipo = 'imagen';
	        
	    }
 
	    $detalle = strtoupper($detalle);
	    
	    if ( !empty($archivo)){
 

	    $sql = "INSERT INTO flow.itil_file (
                   id_tiket, detalle, sesion, creacion, sesionm, modificacion, archivo, tipo)
            VALUES (".
            $this->bd->sqlvalue_inyeccion($id, true).",".
            $this->bd->sqlvalue_inyeccion($detalle, true).",".
            $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
            $fecha.",".
            $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
            $fecha.",".
            $this->bd->sqlvalue_inyeccion(trim($archivo), true).",".
            $this->bd->sqlvalue_inyeccion($tipo, true).")";
          
            $this->bd->ejecutar($sql);
 
            $this->BusquedaDoc( $id ) ;
	    }
	
	}
//---------------------------------------------------------
	public function BusquedaDoc( $id){
	    
 
	    $qquery = array(
	        array( campo => 'id_tiket_file',    valor => '-',  filtro => 'N',   visor => 'S'),
	        array( campo => 'id_tiket',valor => $id,filtro => 'S', visor => 'S'),
	        array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'sesion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'creacion',valor => '-',filtro => 'N', visor => 'S'),
	        array( campo => 'tipo',valor => '-',filtro => 'N', visor => 'S') ,
	        array( campo => 'archivo',valor => '-',filtro => 'N', visor => 'S') 
	    );
 	    
	    $resultado = $this->bd->JqueryCursorVisor('flow.itil_file ',$qquery );
	    
	    
	    echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Fecha </th>
                <th> Detalle Documento </th>
                <th> Sesion </th>
                <th> Tipo Archivo </th>
                <th> Acciones</th></thead> </tr>';
	    
	    
	    
	    
	    while ($fetch=$this->bd->obtener_fila($resultado)){
	        
	        $idproducto =  $fetch['id_tiket_file'] ;
	        
 	        
	        $boton1 = '<button class="btn btn-xs"
                              title="Eliminar Registro"
                              onClick="javascript:goToURLDocdel('.$idproducto.","."'".$id."'".')">
                             <i class="glyphicon glyphicon-remove"></i></button>';
	        
	        $boton2 = '<button class="btn btn-xs"
                            data-toggle="modal"
                            data-target="#myModalDocVisor"
                            title="Documento Relacionado"
                            onClick="javascript:PoneDoc('. "'" .trim($fetch['archivo']) ."'". ')">
                           <i class="glyphicon glyphicon-file"></i></button>&nbsp;&nbsp;&nbsp;';
	                
	        echo ' <tr>';
	        
	        echo ' <td>'.$idproducto.'</td>';
	        echo ' <td>'.$fetch['creacion'].'</td>';
	        echo ' <td>'.$fetch['detalle'].'</td>';
	        echo ' <td>'.$fetch['sesion'].'</td>';
	        echo ' <td>'.$fetch['tipo'].'</td>';
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
 
    if (isset($_POST["accion"]))	{
    	
        $accion 			=     @$_POST["accion"];
        
        $archivo 			=     @$_POST["archivo"];
    	
        $id 				=     @$_POST["id"];
    	
        $detalle 			=     @$_POST["detalle"];
        
        if ( $accion == 'add'){
            $gestion->guarda_archivo( trim($archivo), $id, trim($detalle) );
        }
     
     
    	
    }

    if (isset($_GET["accion"]))	{
           
        $accion 			=     $_GET["accion"];
        
        $id 				=     $_GET["id"];
 
        if ( $accion == 'visor'){
            
            $gestion->BusquedaDoc( $id  );
            
        }
        
      
        
        
    }


?>
 
  