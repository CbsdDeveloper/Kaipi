<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");     
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->ATabla = array(
            array( campo => 'idven_prod',   tipo => 'NUMBER',   id => '0',  add => 'N',     edit => 'N', valor => '-',    key => 'S'),
            array( campo => 'idvengestion', tipo => 'NUMBER',   id => '1',  add => 'S',     edit => 'S', valor => '-',    key => 'N'),
            array( campo => 'idproducto',   tipo => 'NUMBER',   id => '2',  add => 'S',     edit => 'S', valor => '-',    key => 'N'),
            array( campo => 'producto',     tipo => 'VARCHAR2', id => '3',  add => 'S',     edit => 'S', valor => '-',    key => 'N'),
            array( campo => 'estado',       tipo => 'NUMBER',   id => '4',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'sesion',       tipo => 'VARCHAR2', id => '5',  add => 'S',     edit => 'S', valor =>  $this->sesion,     key => 'N'),
            array( campo => 'fecha',        tipo => 'DATE',     id => '6',  add => 'S',     edit => 'S', valor => $this->hoy ,    key => 'N'),
            array( campo => 'detalle',      tipo => 'VARCHAR2', id => '7',  add => 'S',     edit => 'S', valor => '-',    key => 'N'),
            array( campo => 'cantidad',       tipo => 'NUMBER',   id => '8',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'precio',       tipo => 'NUMBER',   id => '9',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'descuento',       tipo => 'NUMBER',   id => '10',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'tipo',       tipo => 'NUMBER',   id => '11',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'iva',       tipo => 'NUMBER',   id => '12',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'total',       tipo => 'NUMBER',   id => '13',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'baseiva',       tipo => 'NUMBER',   id => '14',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'precio_descuento',       tipo => 'NUMBER',   id => '15',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'subtotal',       tipo => 'NUMBER',   id => '16',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'total_precio',       tipo => 'NUMBER',   id => '17',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'total_descuento',       tipo => 'NUMBER',   id => '18',  add => 'S',     edit => 'S', valor => '0',    key => 'N') ,
            array( campo => 'valor_descuento',       tipo => 'NUMBER',   id => '19',  add => 'S',     edit => 'S', valor => '0',    key => 'N'),
            array( campo => 'registro',       tipo => 'VARCHAR2',   id => '20',  add => 'S',     edit => 'N', valor => $this->ruc ,    key => 'N'),
            array( campo => 'idbodega',       tipo => 'NUMBER',   id => '21',  add => 'S',     edit => 'N', valor => '-' ,    key => 'N')
          );
 
         
        
        
        $this->tabla 	  		    = 'ven_cliente_prod';
        
        $this->secuencia 	     = 'ven_cliente_prod_idven_prod_seq';
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
 
        
        echo '<script type="text/javascript">BusquedaProd(oTable,'.$id.' );</script>';
        
        if ($tipo == 0){
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>';
                if ($accion == 'del')
                    $resultado = '<img src="../../kimages/kdel.png"/>&nbsp;<b>Eliminar registro?</b>';
                    
        }
        
        if ($tipo == 1){
             
            $resultado = '<img src="../../kimages/ksavee.png"/>&nbsp;<b>Informacion actualizada</b>';
            
        }
        
        
        return $resultado;
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
      
     //   idvengestion_pro
        
        $qquery = array(
            array( campo => 'idven_prod',   valor =>$id,  filtro => 'S',   visor => 'S'),
            array( campo => 'idproducto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'producto',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'estado',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'cantidad',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'precio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'descuento',   valor => '-',  filtro => 'N',   visor => 'S'),
             array( campo => 'tipo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'iva',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'baseiva',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'precio_descuento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'subtotal',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'total_precio',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'total_descuento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'valor_descuento',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idbodega',   valor => '-',  filtro => 'N',   visor => 'S')
            
        );
        
        $this->bd->JqueryArrayVisor('ven_cliente_prod',$qquery );
        
        
        
        echo '<script type="text/javascript"> $("#actionProducto").val('."'".$accion."'".');</script>';
        
        echo '<script type="text/javascript"> $("#idven_prod").val('.  $id. ');</script>';
        
        
        $result = '<img src="../../kimages/kedit.png"/>&nbsp;<b>Editar registro?</b>';
        
    
        
        echo  $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
        
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar( );
            
        }
       
        // ------------------  eliminar
        if ($action == 'del'){
            
            $this->eliminar($id );
            
        }
        
        if ($action == 'editar'){
            
            $this->editar($id );
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar(   ){ 
        
        $idSeguimiento           =    $_POST["idvengestion_pro"];
        $idproducto              =    $_POST["idproducto"];
        $producto                =    trim($_POST["producto"]);
        $idvengestion_pro        =    trim($_POST["idvengestion_pro"]);
        
        
        $guardarProducto =    'Seleccione producto oferta';
       
        $cantidad    =    $_POST["cantidad"];
        $precio      =    $_POST["precio"];
        
        $descuento        =    $_POST["descuento"];
        $valor_descuento  =    $precio * ($descuento/100)  ;
        $precio_descuento =    $precio - $valor_descuento ;
        
        $subtotal = $precio_descuento * $cantidad;
        
        $total_precio = $precio *   $cantidad;
        
        $tipo        =    $_POST["tipo"];
        
        if ( $tipo  == 'I'){
            $iva     = $subtotal * (12/100);
            $baseiva = $subtotal;
        }
        else{
            $iva = 0;
            $baseiva = 0;
        }
        
        $total_descuento    =    $valor_descuento * $cantidad;
        
        
        $total       =   $subtotal + $iva ;
      
        
        $this->ATabla[8][valor] = $cantidad ;
        $this->ATabla[9][valor] = $precio ;
        $this->ATabla[10][valor] = $descuento ;
        $this->ATabla[11][valor] = $tipo ;
        $this->ATabla[12][valor] = $iva ;
        
        $this->ATabla[13][valor] = $total ;
        $this->ATabla[14][valor] = $baseiva ;
        $this->ATabla[15][valor] = $precio_descuento ;
        $this->ATabla[16][valor] = $subtotal ;
        $this->ATabla[17][valor] = $total_precio ;
        $this->ATabla[18][valor] = $total_descuento ;
        $this->ATabla[19][valor] = $valor_descuento ;
        $this->ATabla[1][valor] = $idSeguimiento ;
        
        $longitud = strlen($producto);     

        if (!empty($producto)){
            //----------------------------------------
               if ( empty($idproducto)){
                
                        if ($longitud > 10 ){
                            $idproducto = $this->producto_servicios($producto,$tipo);
                        }else{
                            $idproducto = 0;
                        }
             }
            //--------------------------
            $id1 = 0;
            
            $guardarProducto = 'No se pudo crear el servicio detalle la informacion';
            
        
            if ( $idproducto  > 0 ){
                
                $this->ATabla[2][valor] = $idproducto ;
                $this->ATabla[3][valor] = $producto ;
                
                $Aprod = $this->bd->query_array('ven_cliente_prod',
                    'count(*) as numero',
                    'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion_pro,true).' and
                     idproducto = '.$this->bd->sqlvalue_inyeccion($idproducto,true)
                    );
                
                if ($Aprod["numero"] == 0 ){
                    
                     $id1 = $this->bd->_InsertSQL($this->tabla, $this->ATabla, $this->secuencia );
                    
                    $guardarProducto = $this->div_resultado('editar',$idSeguimiento,1).' '.$id1;
                    
                }
            }
                       
          
            
        }
        
  
        echo $guardarProducto;
        
    }
    //------------------------------------
    function editar ( $idven_prod  ){
        
        $idSeguimiento           =    $_POST["idvengestion_pro"];
        $idproducto              =    $_POST["idproducto"];
        $producto                =    trim($_POST["producto"]);
        $idvengestion_pro        =    trim($_POST["idvengestion_pro"]);
        
        
        $guardarProducto =    'Seleccione producto oferta';
        
        $cantidad    =    $_POST["cantidad"];
        $precio      =    $_POST["precio"];
        
        $descuento        =    $_POST["descuento"];
        $valor_descuento  =    $precio * ($descuento/100)  ;
        $precio_descuento =    $precio - $valor_descuento ;
        
        $subtotal = $precio_descuento * $cantidad;
        
        $total_precio = $precio *   $cantidad;
        
        $tipo        =    $_POST["tipo"];
        
        if ( $tipo  == 'I'){
            $iva     = $subtotal * (12/100);
            $baseiva = $subtotal;
        }
        else{
            $iva = 0;
            $baseiva = 0;
        }
        
        $total_descuento    =    $valor_descuento * $cantidad;
        
        
        $total       =   $subtotal + $iva ;
        
        
        $this->ATabla[8][valor] = $cantidad ;
        $this->ATabla[9][valor] = $precio ;
        $this->ATabla[10][valor] = $descuento ;
        $this->ATabla[11][valor] = $tipo ;
        $this->ATabla[12][valor] = $iva ;
        
        $this->ATabla[13][valor] = $total ;
        $this->ATabla[14][valor] = $baseiva ;
        $this->ATabla[15][valor] = $precio_descuento ;
        $this->ATabla[16][valor] = $subtotal ;
        $this->ATabla[17][valor] = $total_precio ;
        $this->ATabla[18][valor] = $total_descuento ;
        $this->ATabla[19][valor] = $valor_descuento ;
        $this->ATabla[1][valor] = $idSeguimiento ;
        
      
        
        if (!empty($producto)){
            //----------------------------------------
            
            //--------------------------
             
            $guardarProducto = 'No se pudo crear el servicio detalle la informacion';
            
            
            if ( $idproducto  > 0 ){
                
                $this->ATabla[2][valor] = $idproducto ;
                $this->ATabla[3][valor] = $producto ;
                
                $Aprod = $this->bd->query_array('ven_cliente_prod',
                    'count(*) as numero',
                    'idvengestion='.$this->bd->sqlvalue_inyeccion($idvengestion_pro,true).' and
                     idproducto = '.$this->bd->sqlvalue_inyeccion($idproducto,true)
                    );
                
                if ($Aprod["numero"] == 0 ){
                    
                    $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$idven_prod);
                    
                    $guardarProducto = $this->div_resultado('editar',$idSeguimiento,1).' '.$idven_prod;
                    
                }
            }
            
            
            
        }
        
        
        echo $guardarProducto;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        $guardarProducto = '';
        
            
            $sql = 'delete from ven_cliente_prod  where idven_prod='.$this->bd->sqlvalue_inyeccion($id, true);
           
            $this->bd->ejecutar($sql);
        
        
            echo $guardarProducto;
        
        
    }
  //----------------------
    function producto_servicios($producto,$tipo){
        
        $cuenta1 = '-';
        $cuenta2 = '-';
        
        $InsertQuery = array(
            array( campo => 'producto',   valor => $producto),
            array( campo => 'referencia',   valor => $producto ),
            array( campo => 'tipo',   valor => 'S'),
            array( campo => 'idcategoria',   valor => 1),
            array( campo => 'estado',   valor => 'S'),
            array( campo => 'url',   valor => '-'),
            array( campo => 'idmarca',  1),
            array( campo => 'unidad',   valor => 'Unidad'),
            array( campo => 'facturacion',   valor => 'S'),
            array( campo => 'idbodega',   valor =>0 ),
            array( campo => 'cuenta_ing',   valor => $cuenta1),
            array( campo => 'cuenta_inv',   valor => $cuenta2),
            array( campo => 'tributo',   valor => $tipo),
            array( campo => 'registro',   valor => $this->ruc),
            array( campo => 'costo',   valor => 0),
            array( campo => 'codigob',   valor => '-'),
            array( campo => 'tipourl',       valor => '1',  filtro => 'N')
        );
         
        
        $idD = $this->bd->JqueryInsertSQL('web_producto',$InsertQuery);
        
        //------------ seleccion de periodo
          
        return $idD;
        
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
if (isset($_POST["actionProducto"]))	{
    
    $action = @$_POST["actionProducto"];
 
    $id     = @$_POST["idven_prod"];
    
    $gestion->xcrud(trim($action),$id );
    
}
 

if (isset($_GET["accion"]))	{
    
    $action = $_GET["accion"];
    
    $id     = $_GET["id"];
    
    if ( $action == 'del'){
        
        $gestion->eliminar( $id );
        
    }else{
      
        $gestion->consultaId($action, $id);
        
    }
 
    
}


?>
 
  