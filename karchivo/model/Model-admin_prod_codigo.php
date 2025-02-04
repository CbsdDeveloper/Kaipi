<?php   
session_start(); 
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
 


$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
   
    
    $accion    = trim($_GET['accion']);
    
    $id        = $_GET['id'];
    
    $DatosCarga1 = $accion;
    
    if ( $accion == 'visor'){
    
        $x = $bd->query_array(
            'web_producto',
            'idproducto,codigo,saldo, costo',
            'idproducto='.$bd->sqlvalue_inyeccion( ($id),true) 
            );
 
        $v11 = $x['costo'];
        $v21 = $x['saldo'];
        
        $v1 = _precio($bd	,$id,'Normal');
        $v2 = _precio($bd	,$id,'PorMayor');
        $v3 = _precio($bd	,$id,'VentaComision');
        
        $v4 = _precio($bd	,$id,'efectivo');
        $v5 = _precio($bd	,$id,'minorista');
        $v6 = _precio($bd	,$id,'mayorista');
        $v7 = _precio($bd	,$id,'VentaTarjeta');
        
      echo '<script>   $("#idproducto2").val('.$id.'); 
                       $("#codigo2").val("'. trim($x['codigo']).'");   
                       $("#costoc").val('. $v11.');   
                       $("#saldoc").val('. $v21.'); 
                       $("#precio11").val('. $v1.');   
                       $("#precio12").val('. $v2.'); 
                        $("#precio14").val('. $v4.'); 
                        $("#precio15").val('. $v5.'); 
                        $("#precio16").val('. $v6.'); 
                        $("#precio17").val('. $v7.'); 
                       $("#precio13").val('. $v3.') </script>';
  
        
    }
    
    //------------------------------------
    if ( $accion == 'edit'){
        
         $codigo2        = $_GET['codigo2'];
         $precio11        = $_GET['precio11'];
         $precio12        = $_GET['precio12'];
         $precio13        = $_GET['precio13'];
         
         $precio14        = $_GET['precio14'];
         $precio15        = $_GET['precio15'];
         $precio16        = $_GET['precio16'];
         $precio17        = $_GET['precio17'];
         
         //-------------------------------------------  
         if ( $precio11 > 0){
             $x = _precio_count($bd	,$id,'Normal');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio11,'S','Normal');
             }else {
                 _add_precio($bd	,$id,$precio11,'S','Normal');
             }
            
         }
         //-------------------------------------------
         if ( $precio12 > 0){
             $x = _precio_count($bd	,$id,'PorMayor');
             
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio12,'S','PorMayor');
             }else {
                 _add_precio($bd	,$id,$precio12,'N','PorMayor');
             }
             
         }
         //-------------------------------------------
         if ( $precio13 > 0){
             $x = _precio_count($bd	,$id,'VentaComision');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio13,'S','VentaComision');
             }else {
                 _add_precio($bd	,$id,$precio13,'N','VentaComision');
             }
         }
         //-------------------------------------------
         if ( $precio14 > 0){
             $x = _precio_count($bd	,$id,'efectivo');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio14,'S','efectivo');
             }else {
                 _add_precio($bd	,$id,$precio14,'N','efectivo');
             }
         }
         //-------------------------------------------
         if ( $precio15 > 0){
             $x = _precio_count($bd	,$id,'minorista');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio15,'S','minorista');
             }else {
                 _add_precio($bd	,$id,$precio15,'N','minorista');
             }
         }
         //-------------------------------------------
         if ( $precio16 > 0){
             $x = _precio_count($bd	,$id,'mayorista');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio16,'S','mayorista');
             }else {
                 _add_precio($bd	,$id,$precio16,'N','mayorista');
             }
         }
         //-------------------------------------------
         if ( $precio17 > 0){
             $x = _precio_count($bd	,$id,'VentaTarjeta');
             if ( $x  > 0 ){
                 _edit_precio($bd	,$id,$precio17,'S','VentaTarjeta');
             }else {
                 _add_precio($bd	,$id,$precio17,'N','VentaTarjeta');
             }
         }
         //-------------------------------------------
        
             _codigo_inv($bd,$id,$codigo2 );
        
    }
    
    
    
    echo $DatosCarga1;
    
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