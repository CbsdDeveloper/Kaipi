<?php   
session_start(); 
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
 


$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
   


    $accion      = trim($_GET['tipo']);
    
    $id_producto           = $_GET['id'];
    
    $valor        = $_GET['valor'];
    
    $SaldoBodega =  $id_producto;
    
    if ($accion == '0'){
        _codigo_inv($bd	,$id_producto,$valor);
    }
    
    if ($accion == '1'){
        $x = _precio_count($bd	,$id_producto,'Normal');
        if ( $x  > 0 ){
            _edit_precio($bd	,$id_producto,$valor,'S','Normal');
        }else {
            _add_precio($bd	,$id_producto,$valor,'S','Normal');
        }
    }
    
    
    if ($accion == '2'){
        $x = _precio_count($bd	,$id_producto,'PorMayor');
        if ( $x  > 0 ){
            _edit_precio($bd	,$id_producto,$valor,'S','PorMayor');
        }else {
            _add_precio($bd	,$id_producto,$valor,'S','PorMayor');
        }
    }
    
    
    if ($accion == '3'){
        $x = _precio_count($bd	,$id_producto,'VentaComision');
        if ( $x  > 0 ){
            _edit_precio($bd	,$id_producto,$valor,'S','VentaComision');
        }else {
            _add_precio($bd	,$id_producto,$valor,'S','VentaComision');
        }
    }
    
    
    if ($accion == '4'){
        $x = _precio_count($bd	,$id_producto,'VentaTarjeta');
        if ( $x  > 0 ){
            _edit_precio($bd	,$id_producto,$valor,'S','VentaTarjeta');
        }else {
            _add_precio($bd	,$id_producto,$valor,'S','VentaTarjeta');
        }
    }
    
     
    
    echo $SaldoBodega;
    
    //-----------------------
    function _precio($bd	,$id_producto,$detalle){
        
        
        $AResultado = $bd->query_array(
            'inv_producto_vta',
            'monto',
            'id_producto='.$bd->sqlvalue_inyeccion(trim($id_producto),true). ' and 
             detalle='.$bd->sqlvalue_inyeccion(trim($detalle),true)
            );
        
        $dato = $AResultado['monto'];
        
        if( empty($dato)){
            $dato = 0;
        }
 
        return $dato;
 
    }
    //-----------------------
    function _precio_count($bd	,$id_producto,$detalle){
        
        
        $AResultado = $bd->query_array(
            'inv_producto_vta',
            'count(*) as nn',
            'id_producto='.$bd->sqlvalue_inyeccion( ($id_producto),true). ' and
             detalle='.$bd->sqlvalue_inyeccion(trim($detalle),true)
            );
        
        $dato = $AResultado['nn'];
        
        if( empty($dato) ){
            $dato = 0;
        }
        
        return $dato;
        
    }
 //-----------------------------------------------   
    function _add_precio($bd	,$id_producto,$precio_iva1,$tipo,$detalle){
        
        
        
        $InsertQuery = array(
            array( campo => 'id_producto',   valor => $id_producto),
            array( campo => 'monto',   valor => $precio_iva1 ),
            array( campo => 'activo',   valor => 'S' ),
            array( campo => 'principal',   valor => $tipo),
            array( campo => 'detalle',   valor => $detalle )
        );
        
        if ( $precio_iva1 > 0 ) {
            
            $bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);
            
        }
        
    }
   ///----------------------
    function _edit_precio($bd	,$id_producto,$precio_iva1,$tipo,$detalle){
        
        $UpdateQuery = array(
            array( campo => 'id_producto',   valor => $id_producto ,  filtro => 'S'),
            array( campo => 'detalle',   valor => trim($detalle),  filtro => 'S'),
            array( campo => 'monto',      valor => $precio_iva1,  filtro => 'N') 
         );
        
        if ( $precio_iva1 > 0 ) {
         
            $bd->JqueryUpdateSQL('inv_producto_vta',$UpdateQuery);
            
         
        }
       
        
    }
    //----------------------------------
    function _codigo_inv($bd	,$id_producto,$codigo2){
        
        $UpdateQuery = array(
            array( campo => 'idproducto',   valor => $id_producto ,  filtro => 'S'),
            array( campo => 'codigo',      valor => $codigo2,  filtro => 'N')
        );
        
       
       $bd->JqueryUpdateSQL('web_producto',$UpdateQuery);
            
       
       
        
    }
 
   
 
 ?>