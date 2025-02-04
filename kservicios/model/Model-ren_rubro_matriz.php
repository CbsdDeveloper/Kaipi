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
       
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date('Y-m-d');
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
   
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        $qquery = array(
            array( campo => 'id_rubro_matriz',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_rubro',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
        );
 
        
        $datos =   $this->bd->JqueryArrayVisorDato('rentas.ren_rubros_matriz',$qquery );
        
 
        
          header('Content-Type: application/json');
          
          echo json_encode($datos, JSON_FORCE_OBJECT);
    }
    
 
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( $POST  ){
 
   
        $x = $this->bd->query_array('rentas.ren_rubros_matriz',   // TABLA
            'count(*) as nn',                        // CAMPOS
            'id_rubro='.$this->bd->sqlvalue_inyeccion($POST["id_rubro"],true)  .' and 
            idproducto_ser='.$this->bd->sqlvalue_inyeccion($POST["idproducto_ser"],true) 
            );
        
 
        
        $InsertQuery = array(
            array( campo => 'id_rubro',   valor =>$POST["id_rubro"]),
            array( campo => 'idproducto_ser',   valor =>$POST["idproducto_ser"]),
            array( campo => 'estado',   valor =>$POST["estado"]),
             array( campo => 'sesion',   valor => $this->sesion),
            array( campo => 'msesion',   valor => $this->sesion),
            array( campo => 'creacion',   valor => $this->hoy 	),
            array( campo => 'modificacion',   valor => $this->hoy 	),
         
        );
        
 
        $this->bd->pideSq(0);
        
        if ( $x["nn"] > 0 ){
            $result = ' EL rubro ya existe generado... verifique!!! ';
        }else {
            $idD = $this->bd->JqueryInsertSQL('rentas.ren_rubros_matriz',$InsertQuery,'rentas.ren_rubros_matriz_id_rubro_matriz_seq');
            $result = 'Datos Guardados con exitos '.$idD;
        }

 
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($id ,$POST ){
        
      
            
  
        $UpdateQuery = array(
            array( campo => 'id_rubro_matriz',  valor => $id ,  filtro => 'S'),
            array( campo => 'estado',      valor => $POST["estado"],    filtro => 'N'),
            array( campo => 'msesion', valor => $this->sesion,    filtro => 'N'),
            array( campo => 'modificacion', valor => $this->hoy ,    filtro => 'N')
          );
 
        
 
        $this->bd->JqueryUpdateSQL('rentas.ren_rubros_matriz',$UpdateQuery);
        
        $result = 'DATOS ACTUALIZADOS CORRECTAMENTE';
        
        
        echo $result;
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
        $sql = "SELECT count(*) as nro_registros
	       FROM rentas.ren_rubros_matriz
           where id_rubro = ".$this->bd->sqlvalue_inyeccion($id ,true);
        
        $resultado = $this->bd->ejecutar($sql);
        
        $datos_valida = $this->bd->obtener_array( $resultado);
        
        if ($datos_valida['nro_registros'] == 0){
            
            $this->bd->JqueryDeleteSQL('rentas.ren_rubros',
                'id_rubro='.$this->bd->sqlvalue_inyeccion($id, true));
            
            
        }
        
        
        $result = $this->div_limpiar();
        
        echo $result;
        
    }
  
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;


//------ poner informacion en los campos del sistema
if (isset($_GET['action']))	{
    
    $accion     = $_GET['action'];
     $id        = $_GET['id'];
    
    $gestion->consultaId($accion,$id);
}
 
if (isset($_POST['action']))	{
    
    $accion     = trim($_POST['action']);
    $id         = $_POST['id'];
    
    if ($accion == 'add' ){
        $gestion->agregar($_POST );
    }
   
    if ($accion == 'edit' ){
        $gestion->edicion($id,$_POST );
    }
    
}

?>
 
  