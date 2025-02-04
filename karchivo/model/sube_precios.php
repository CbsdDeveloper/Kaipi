<?php 
session_start( );  
 

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/


$bd	   =	new Db ;

// $ruc       =  $_SESSION['ruc_registro'];


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

        $Qquery = array(
            
            array( campo => 'codigo',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'detalle',   valor => '-' ,  filtro => 'N',   visor => 'S'),
            array( campo => 'precio1',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'precio2',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'precio3',   valor => '-',  filtro => 'N',   visor => 'S') 
        );
        
     
        $resultado1 = $bd->JqueryCursorVisor('hoja_precio',$Qquery);
      
        $i = 1;
        
        while ($fetch=$bd->obtener_fila($resultado1)){
            
         //   $referencia     = strtoupper(utf8_encode(trim($fetch['codigo'])));
         //   $producto       = strtoupper(utf8_encode(trim($fetch['detalle'])));
            
       /*  
            $precio3      =  $fetch['precio3'] ;*/
            
       //     $nombre_producto = $producto .' '.$referencia;
            
            $codigo=  trim($fetch['codigo'] );
            
            $id_producto = _busca_producto($bd,$codigo);
       
            $cantidad      =  $fetch['precio1'] ;
            $costo      =  $fetch['precio2'] ;
            
      /**     $precio_iva1 = str_replace(',','.', $precio1);
            $precio_iva2 = str_replace(',','.', $precio2);
            $precio_iva3 = str_replace(',','.', $precio3);*/
            
            if ( $id_producto > 0 ){
                
                $sql = 'update inv_movimiento_det
                        set costo='.$bd->sqlvalue_inyeccion($costo ,true).' , 
                            cantidad='.$bd->sqlvalue_inyeccion($cantidad ,true).'
                        where idproducto ='.$bd->sqlvalue_inyeccion($id_producto ,true). ' and id_movimiento = 662';
                
                $bd->ejecutar($sql);
                
                
            //    _busca_precio($bd	,$id_producto,$precio_iva1,$precio_iva2,$precio_iva3);
                
                $i = 1 + $i;
                
                echo $i.' - ';
            }
            
            
        
            
 
      }
     
 //-----------------------------------
    function _busca_producto($bd	,$id ){
     
        
           
        $AResultado = $bd->query_array(
            'web_producto',
            'idproducto',
            'codigo='.$bd->sqlvalue_inyeccion(trim($id),true) 
            );
        
        $dato = $AResultado['idproducto'];
            
             
            return $dato;
        
        
    }
 //----------------------------
 //-----------------------
    function _busca_precio($bd	,$id_producto,$precio_iva1,$precio_iva2,$precio_iva3){
        
        
        $sql = "DELETE  FROM inv_producto_vta
           where id_producto = ".$bd->sqlvalue_inyeccion($id_producto ,true);
        
         $bd->ejecutar($sql);
        
            _add_precio($bd	,$id_producto,$precio_iva1,'S','Normal');
            _add_precio($bd	,$id_producto,$precio_iva2,'N','PorMayor');
            _add_precio($bd	,$id_producto,$precio_iva3,'N','VentaComision');
      
        
      
    }
//---------------------
//-----------------------
    function _precio($bd	,$id_producto){
        
        
        $AResultado = $bd->query_array(
            'inv_producto_vta',
            'count(*) as nn',
            'idproducto='.$bd->sqlvalue_inyeccion(trim($id_producto),true) 
            );
        
        $dato = $AResultado['nn'];
        
        
        return $dato;
   
        
        
    }
 //---------------
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
?>
  
  