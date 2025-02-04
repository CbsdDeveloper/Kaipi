<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
 
    private $tabla ;
    private $secuencia;
    
     
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        
        $this->sesion 	 =     trim($_SESSION['email']);
        
        $this->hoy 	     =     date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ATabla = array(
             array( campo => 'id_matriz_var',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'catalogo',tipo => 'VARCHAR2',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idrubro',tipo => 'NUMBER',id => '2',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor => $this->sesion, key => 'N') ,
            array( campo => 'tipo_cat',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>'-', key => 'N') 
        );
        
        
        $this->tabla 	  	  = 'rentas.ren_servicios_var';
        
        $this->secuencia 	     = 'rentas.ren_servicios_var_id_matriz_var_seq';
    
      
    }
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        
        $qquery = array(
            array( campo => 'id_matriz_var',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'catalogo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idrubro',valor => '-',filtro => 'N', visor => 'S')
 
        );
         
        $datos =   $this->bd->JqueryArrayVisorDato('rentas.ren_servicios_var',$qquery );
        
        header('Content-Type: application/json');
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
 
 
        
    }
     //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( $GET ){
        
      
        $this->ATabla[1][valor] =  trim( $GET['catalogo']);
        $this->ATabla[2][valor] =  $GET['id_rubro'] ;
         
        $id = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
          
        
        $result = '<b>REGISTRO ACTUALIZADO ...</b>'.$id;
        
        echo $result;
        
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion($GET){
        
        $id = $GET['id_matriz_var'];
        
        $this->ATabla[1][valor] =  trim( $GET['catalogo']);
   
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id);
        
         
        $result = '<b>REGISTRO ACTUALIZADO ...</b>';
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
      /*  
        $estado =  $_POST["estado"];
        
        if (trim($estado) == 'digitado') {
            
            $sql = 'delete from inv_movimiento  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            
            $sql = 'delete from inv_movimiento_det  where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            $this->bd->ejecutar($sql);
            
            $result = $this->div_limpiar();
            
        }else {
            
            $sql = 'update inv_movimiento
                       set estado = '.$this->bd->sqlvalue_inyeccion('anulado', true).'
                    where id_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
            
            
            $this->bd->ejecutar($sql);
            
           
            
        }
        */
        
        $result = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>REGISTRO ANULADO </b>';
        
        echo $result;
        
        
    }
    //---------------------------------------
  
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_POST['accion']))	{
    
    $accion    = $_POST['accion'];
    
    $id        = $_POST['id'];
    
    if ( $accion == 'editar'){
        $gestion->consultaId($accion,$id);
    }
   
    if ( $accion == 'guardar'){
        $gestion->edicion($_POST);
    }
    
    if ( $accion == 'add'){
        $gestion->agregar($_POST);
    }
    
    
}
 


?>
 
  