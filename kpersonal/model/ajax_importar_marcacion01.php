<?php session_start( );  ?>
<div style="padding-top: 5px;font-size: 12px;font-family: Arial, Calibri"> 
<h5>Importando archivo CSV</h5>
<p>
FORMATO 1.- Registro de marcaciones <br>
identificacion,Nombre,Tiempo,Estado,Dispositivos,Tipo de Registro
</p>
  <form action='ajax_importar_marcacion01.php' method='post' enctype="multipart/form-data">
 
   Importar Archivo : <input type='file' name='sel_file' size='800' accept=".csv">
     <input type='submit' name='submit' value='Cargar Informacion'>
     <input name="MAX_FILE_SIZE" type="hidden" value="20000" /> 
     <input name="valida" type="hidden" value="S" /> 
     <p>
     
	</p>
  </form>
        </div>
<?php 
 
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Db.conf.php';   /*Incluimos el fichero de la clase Conf*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

/*Creamos la instancia del objeto. Ya estamos conectados*/

$bd	     =	new Db ;
 

$bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);

 

 if(isset($_POST['submit']))
{
    //Aquí es donde seleccionamos nuestro csv
    $fname                   = $_FILES['sel_file']['name'];
  
    
    echo 'Cargando nombre del archivo: '.$fname.' <br>';
 //   $chk_ext = explode(".",$fname);
    
    //---- identificacion,Nombre,Tiempo,Estado,Dispositivos,Tipo de Registro
    
        //si es correcto, entonces damos permisos de lectura para subir
        
        $filename = $_FILES['sel_file']['tmp_name'];
        
        if (!empty($filename)){
        
                    $handle = fopen($filename, "r");
                    
                    $i = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                    {
                        $idprov    =   trim($data[0]) ;
                        $nombre     = strtoupper(utf8_encode(trim($data[1])));
                        $tiempo   = strtoupper(utf8_encode(trim($data[2])));
                        $estado    = strtoupper(utf8_encode(trim($data[3])));
                        $dispositivo       = utf8_encode(trim($data[4]));
                        $registro     =  (trim($data[5]));
                        
                        
                        $fecha_matriz =  explode(" ",$tiempo);
                        
                        $fecha = $fecha_matriz[0] ;
                        $hora  = $fecha_matriz[1] ;
                      
                        //26/07/2019 7:34:59
                        $periodo =  explode("/",$fecha);
                        $mes     =  $periodo[1] ;
                        $anio    =  $periodo[2] ;
                        
                
                     
                        if ( $i > 0 ){
                            
             
                                $valida = _busca_periodo($bd,$anio,$mes);
                                
                                if ( $valida == 0 ){
                                    
                                    _borra_periodo($bd,$anio,$mes);
                                    
                                    guarda_tiempo($bd,$idprov ,
                                        $nombre,$tiempo,$estado,
                                        $dispositivo, $registro,$fecha,$hora,
                                        $mes,$anio);
                                }
                         
                        }
                        /*
                        $cantidad      = str_replace(',','.', $cantidad);
                        $costo         = str_replace(',','.', $costo);
                        $precio_iva    = str_replace(',','.', $precio_iva);
                        
                        $stock         = str_replace(',','.', $stock);
                               
                        $lon = strlen($nombre_producto); 
                        
                        $lon1 = strlen($categoria); 
                        
             
                        
                        if ( $i > 0 ){
                                     
                                  if ($lon  > 5 ) {
                                        
                                             if ( empty($id_producto)) {
                                                
                                                 if ($lon1  > 1) {
                                                     
                                                    $id_producto = _
                                                     // precio
                                                    if ( $id_producto > 0) {
                                                        
                                                            _busca_precio($bd	,$id_producto,$precio_iva);
                                                           
                                                            _guarda_detalle($bd, $id_producto ,$costo, $cantidad ,$ruc_registro,$idbodega);
                                                           
                                                            $resultado = "Importacion exitosa! Registros: ";
                                                    }
                                                    
                                                 }
                                                 
                                               }
                                               ///-----------------------------------------
                                               else{
                                                   
                                                   _guarda_detalle($bd, $id_producto ,$costo, $cantidad ,$ruc_registro,$idbodega);
                                                   
                                                   $resultado = " Actualizacion : ".$id_producto;
                                               }
                                               //-----------------------------------------
                                     }
                          }
                          
                          $i = 1 + $i;
                               */
                        $i++;
                    
                          
                    }
                    
                  
                    
                    echo  ' registros: '.$i.' - '. $mes;
                    
                    //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                    fclose($handle);
                    
        }
    }
     
 //-----------------------------------
    function _busca_periodo($bd,$anio,$mes){
     
    
        
              $AResultado = $bd->query_array(
                'nom_marcacion_temp',
                'count(*) as nn ',
                  'mes='.$bd->sqlvalue_inyeccion(trim($mes),true). ' and 
                  anio='.$bd->sqlvalue_inyeccion(trim($anio),true). ' and 
                  estado  <>'.$bd->sqlvalue_inyeccion('XX',true)
                );
            
            $dato = $AResultado['nn'];
              
            return $dato;
        
        
    }
     
 //-----------------------
    function _borra_periodo($bd,$anio,$mes){
        
        
        $sql ='delete from nom_marcacion_temp where estado  <>' .$bd->sqlvalue_inyeccion('XX',true);
            
        $bd->ejecutar($sql);
      
    }
//---------------------
    function guarda_tiempo($bd,$idprov ,
                                    $nombre,$tiempo,$estado,
                                    $dispositivo, $registro,$fecha,$hora,
                                    $mes,$anio){
                                    
     
        
        $longitud = strlen($idprov);
        
        if ( $longitud== 9){
            $cad_idprov  = '0'.trim($idprov);
        }else{
            $cad_idprov  = trim($idprov);
        }
           
        //26/07/2019 7:34:59
        $periodo =  explode("/",$fecha);
        $dia    =  $periodo[0] ;
        $mes     =  $periodo[1] ;
        $anio    =  $periodo[2] ;
        
        $fecha_dato =  $anio.'-'.$mes.'-'. $dia ;
     
        $InsertQuery = array(
            array( campo => 'identificacion',   valor => $cad_idprov),
            array( campo => 'nombre',   valor => $nombre ),
            array( campo => 'tiempo',   valor => $tiempo),
            array( campo => 'estado',   valor => $estado),
            array( campo => 'dispositivo',   valor => $dispositivo),
            array( campo => 'registro',      valor => $registro),
            array( campo => 'fecha',  valor => $fecha_dato),
            array( campo => 'hora',        valor => $hora),
            array( campo => 'sesion',        valor => 'migra'),
            array( campo => 'anio',   valor => $anio),
            array( campo => 'mes',      valor => $mes) 
        );
        
        
        if ( $longitud > 6 ){
 
            $bd->pideSq(0);
            $bd->JqueryInsertSQL('nom_marcacion_temp',$InsertQuery);
            
        }
            return 1;
        
    }
    //--------------------------
    function _guarda_detalle($bd,$id_producto ,$costo,$stock,$ruc_registro,$idbodega){
        

        $id_movimiento     = 	-1;
        $cantidad          = 	$stock;
        $tipo =  'I';
        
        $x = $bd->query_array('inv_movimiento',
            'max(id_movimiento) as id_movimiento',
            'idbodega   ='.$bd->sqlvalue_inyeccion($idbodega,true). ' and
                           transaccion='.$bd->sqlvalue_inyeccion('carga inicial',true). ' and
                           registro   ='.$bd->sqlvalue_inyeccion($ruc_registro,true)
            );
        
        $id_movimiento = $x['id_movimiento'];
        
        
        $Existe = $bd->query_array(
            'inv_movimiento_det',
            'count(*) as nn ',
            'idproducto    ='.$bd->sqlvalue_inyeccion($id_producto,true) . ' and 
             id_movimiento = '.$bd->sqlvalue_inyeccion($id_movimiento,true) 
            );
        
        $estado = ' ';
        
        
        
        
     
        
        if ($Existe["nn"] > 0)   {
        }
        else   {
               
                if ($cantidad > 0  ){
                  
                    nuevo_detalle( $id_movimiento,$id_producto, $bd ,$estado,$tipo,$costo,$cantidad);
                }
              
            }
 
        
    }
  //----------------------------------------
  //--- funciones grud
    function nuevo_detalle($id_movimiento,$idproducto, $bd ,$estado,$tipo,$costo,$cantidad){
        
        //---------------------------------------------------
        $IVA               = 12/100;
     //   $IVADesglose       = 1 + $IVA;
        $sesion 	       =    $_SESSION['email'];
        
        //----------------------------------------------------
        
        
        
        $AProducto = $bd->query_array( 'web_producto',
        'costo,tributo,saldo',
        'idproducto='.$bd->sqlvalue_inyeccion($idproducto,true)
        );
        
        //----------------------------------------------------
  //      $saldo         = $AProducto['saldo'];
        $ingreso       = $cantidad;
        $egreso        = 0;
 //       $nbandera      = 1;
        
        
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
        
        
        $bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
        
        
        
    }
    
    
 
?>
  
  