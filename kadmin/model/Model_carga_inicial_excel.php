<div style="padding-top: 5px;font-size: 14px;font-family: Arial, Calibri"> 
<h4>Importando archivo CSV</h4>
  <form action='Model_carga_inicial_excel.php' method='post' enctype="multipart/form-data">
  
 
   Importar Archivo : <input type='file' name='sel_file' size='80' accept=".csv">
   <input type='submit' name='submit' value='Cargar Informacion'>
    <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     

  </form>
        </div>
<?php 
session_start( );  
 

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
  /*Creamos la instancia del objeto. Ya estamos conectados*/



$bd	   =	new Db ;


$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);


if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname = $_FILES['sel_file']['name'];
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
    $chk_ext = explode(".",$fname);
    
    //---- secuencia	producto	referencia	categoria	unidad	cantidad	facturacion	tributo	costo	stock	precio_iva
    
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        $handle = fopen($filename, "r");
        
        $i = 0;
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
        {
            $secuencia    =   trim($data[0]) ;
            $producto     = strtoupper(utf8_encode(trim($data[1])));
            $referencia   = strtoupper(utf8_encode(trim($data[2])));
            $categoria    = strtoupper(utf8_encode(trim($data[3])));
            $unidad       = utf8_encode(trim($data[4]));
            $cantidad     =  (trim($data[5]));
            $facturacion     = utf8_encode(trim($data[6]));
            $tributo         =  (trim($data[7]));
            $costo           =  (trim($data[8]));
            $stock           =  (trim($data[9]));
            $precio_iva      =  (trim($data[10]));
         
            $nombre_producto = $producto .' '.$referencia;
            
            $id_producto = _busca_producto($bd,$nombre_producto);
             
            $cantidad      = str_replace(',','.', $cantidad);
            $costo      = str_replace(',','.', $costo);
            $precio_iva = str_replace(',','.', $precio_iva);
            
            $stock      = str_replace(',','.', $stock);
                   
            $lon = strlen($producto); 
            
            $lon1 = strlen($categoria); 
            
            
            if ( $i > 0 ){
                         
                      if ($lon  > 5 ) {
                            
                                 if ( empty($id_producto)) {
                                    
                                     if ($lon1  > 5 ) {
                                         
                                        $id_producto = _guarda_producto($bd,$nombre_producto ,
                                                                        $producto,$referencia,$categoria,$unidad,
                                        $facturacion,$tributo,$costo,$stock,$precio_iva);
                                         // precio
                                        if ( $id_producto > 0) {
                                            
                                               _busca_precio($bd	,$id_producto,$precio_iva);
                                               
                                               _guarda_detalle($bd, $id_producto ,$costo, $stock );
                                               
                                        }
                                        
                                     }
                                     
                                   }
                         }
              }
              
              $i = 1 + $i;
                   
        }
        
        
        //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
        fclose($handle);
        echo "Importacion exitosa! Registros: ".$i.' '.$valida_total;
        
    }
     
 //-----------------------------------
    function _busca_producto($bd	,$id){
     
        
           
              $AResultado = $bd->query_array(
                'web_producto',
                'idproducto',
                'producto='.$bd->sqlvalue_inyeccion(trim($id),true)
                );
            
            $dato = $AResultado['idproducto'];
            
             
            return $dato;
        
        
    }
    //----------------------------
    function _busca_categoria($bd	,$categoria){
        
       
            $AResultado = $bd->query_array(
                'web_categoria',
                'idcategoria',
                'nombre='.$bd->sqlvalue_inyeccion(trim($categoria),true)
                );
            
            $idcategoria =   $AResultado['idcategoria'];
            
            $id = $idcategoria;
            
            
            $InsertQuery = array(
                array( campo => 'nombre',   valor => $categoria),
                array( campo => 'referencia',   valor => $categoria )
            );
            
            
            if (empty($idcategoria) ){
                
                $id = $bd->JqueryInsertSQL('web_categoria',$InsertQuery);
                
             }
            
            return $id;
        
    }
 //-----------------------
    function _busca_precio($bd	,$id_producto,$precio_iva){
        
        
        if ( $precio_iva > 0){
        
                $InsertQuery = array(
                    array( campo => 'id_producto',   valor => $id_producto),
                    array( campo => 'monto',   valor => $precio_iva ),
                    array( campo => 'activo',   valor => 'S' ),
                    array( campo => 'principal',   valor => 'S' ),
                    array( campo => 'detalle',   valor => 'Normal' )
                );
                
               $bd->JqueryInsertSQL('inv_producto_vta',$InsertQuery);
            
        }
      
    }
//---------------------
    function _guarda_producto($bd,$nombre_producto ,
                                $producto,$referencia,$categoria,$unidad,
                                $facturacion,$tributo,$costo,$stock,$precio_iva){
                                    
        
        $tabla 	  	 = 'par_ciu';
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");
         
        $AResultado = $bd->query_array(
            'web_producto',
            'idproducto',
            'producto='.$bd->sqlvalue_inyeccion(trim($nombre_producto),true)
            );
        
        $dato = $AResultado['idproducto'];
        
        
        $idcategoria = _busca_categoria($bd	,$categoria);
        
        
     
        $InsertQuery = array(
            array( campo => 'producto',   valor => $nombre_producto),
            array( campo => 'referencia',   valor => $producto ),
            array( campo => 'tipo',   valor => 'B'),
            array( campo => 'idcategoria',   valor => $idcategoria),
            array( campo => 'estado',   valor => 'S'),
            array( campo => 'url',      valor => '-'),
            array( campo => 'idmarca',  valor => -1),
            array( campo => 'unidad',        valor => $unidad),
            array( campo => 'facturacion',   valor => $facturacion),
            array( campo => 'idbodega',      valor => 1),
            array( campo => 'cuenta_inv',   valor => '-'),
            array( campo => 'cuenta_ing',   valor => '-'),
            array( campo => 'minimo',   valor => '5'),
            array( campo => 'tributo',   valor => $tributo),
            array( campo => 'costo',   valor => $costo),
            array( campo => 'codigob',   valor => '-'),
            array( campo => 'controlserie',   valor => 'N'),
            array( campo => 'cuenta_gas',   valor => '-'),
            array( campo => 'tipourl',       valor => '1',  filtro => 'N')
        );
        
 
        if (empty($dato) ){
            
            $idD = $bd->JqueryInsertSQL('web_producto',$InsertQuery);
            
            return $idD;
        }
 
            return 0;
        
    }
    //--------------------------
    function _guarda_detalle($bd,$id_producto ,$costo,$stock ){
        
        
        $tabla 	  	 = 'par_ciu';
        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");
        
        $idproducto	       =	$id_producto;
        $id_movimiento     = 	-1;
        $cantidad          = 	$stock;
        $tipo =  'I';
        
        
        $Existe = $bd->query_array(
            'inv_movimiento_det',
            'count(*) as nn ',
            'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true) . ' and id_movimiento = -1'
            );
        
        
        
        if ($Existe["nn"] == 0)
        {
            if ($cantidad > 0  ){
                $DatosCarga = nuevo( $id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad);
            }
          
        }
 
        
    }
  //----------------------------------------
  //--- funciones grud
    function nuevo($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad){
        
        //---------------------------------------------------
        $IVA               = 12/100;
        $IVADesglose       = 1 + $IVA;
        $sesion 	       =    $_SESSION['email'];
        
        //----------------------------------------------------
        
        
        
        $AProducto = $bd->query_array( 'web_producto',
        'costo,tributo,saldo',
        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
        );
        
        //----------------------------------------------------
        $saldo         = $AProducto['saldo'];
        $ingreso       = $cantidad;
        $egreso        = 0;
        $nbandera      = 1;
        
        
        //----------------------------------------------------
        
        if (trim($AProducto['tributo']) == 'I'){
            /*   $total = $AProducto['costo'];
             $baseiva     = round($total / $IVADesglose,2);
             $tarifa_cero = 0;
             $monto_iva   = round($baseiva * $IVA,2);*/
            
            $baseiva     = $costo * $cantidad ;
            $monto_iva   = round($baseiva * $IVA,2);
            $total       = $monto_iva + $baseiva ;
            $tarifa_cero = '0';
            
        } else{
            $monto_iva   = '0';
            $tarifa_cero = $costo;
            $baseiva     = '0';
            $total = $tarifa_cero;
        }
        
        
        
        $ATabla = array(
            array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $idproducto,   filtro => 'N',   key => 'N'),
            array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
            array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
            array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $AProducto['tributo'],   filtro => 'N',   key => 'N'),
            array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
            array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
            array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
        );
        
        
        $id = $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
        
        
        
    }
    
    
 
?>
  
  