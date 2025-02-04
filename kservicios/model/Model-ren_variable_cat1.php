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
            array( campo => 'id_matriz_cat',tipo => 'NUMBER',id => '0',add => 'S', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'id_matriz_var',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idcatalogo1',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'idcatalogo2',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'idcatalogo3',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'valor',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'idrubro',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valor1',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'valor2',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'basico',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'excendente',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N')
        );
        
 
        $this->tabla 	  	  = 'rentas.ren_servicios_cat';
        
         
      
    }
 
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        
        $qquery = array(
            array( campo => 'id_matriz_cat',   valor => $id,  filtro => 'S',   visor => 'S'),
             array( campo => 'valor1',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor2',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'basico',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'excendente',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor',valor => '-',filtro => 'N', visor => 'S'),
        );
        
    
        
        $datos =   $this->bd->JqueryArrayVisorDato('rentas.ren_servicios_cat',$qquery );
        
        header('Content-Type: application/json');
        
        echo json_encode($datos, JSON_FORCE_OBJECT);
 
 
        
    }
//-------------------
   
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id );
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar($GET ){
        
     
        $x = $this->bd->query_array('rentas.ren_servicios_cat',   // TABLA
            'max(id_matriz_cat) as codigo',                        // CAMPOS
            '1='.$this->bd->sqlvalue_inyeccion(1,true) // CONDICION
            );
        
        $id = $x['codigo'] + 1;
        
        $this->ATabla[0][valor] =   $id;
        $this->ATabla[1][valor] =   $GET['id_matriz_var'] ;
        
        $this->ATabla[5][valor] =   $GET['valor'] ;
        $this->ATabla[7][valor] =   $GET['valor1'] ;
        $this->ATabla[8][valor] =   $GET['valor2'] ;
        $this->ATabla[9][valor] =   $GET['basico'] ;
        $this->ATabla[10][valor] =   $GET['excendente'] ;
        $this->ATabla[6][valor] =   $GET['id_rubro'] ;
        
       
        
        $this->bd->_InsertSQL($this->tabla,$this->ATabla, $id);
        
        
        $result = '<b>REGISTRO ACTUALIZADO ...</b>'.$id;
        
        echo $result;
        
        
    }
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
    function edicion( $GET  ){
        
 
        $id = $GET['id_matriz_cat'];
        
        $this->ATabla[1][valor] =   $GET['id_matriz_var'] ;
        $this->ATabla[5][valor] =   $GET['valor'] ;
        $this->ATabla[7][valor] =   $GET['valor1'] ;
        $this->ATabla[8][valor] =   $GET['valor2'] ;
        $this->ATabla[9][valor] =   $GET['basico'] ;
        $this->ATabla[10][valor] =   $GET['excendente'] ;
        $this->ATabla[6][valor] =   $GET['id_rubro'] ;
        
        
        
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
if (isset($_GET['accion']))	{
    
    $accion    = $_GET['accion'];
    
    $id        = $_GET['id'];
    
    if ( $accion == 'editar'){
        $gestion->consultaId($accion,$id);
    }
   
    if ( $accion == 'guardar'){
        $gestion->edicion($_GET);
    }
    
    if ( $accion == 'add'){
        $gestion->agregar($_GET);
    }
    
    
    
}
 


?>
 
  