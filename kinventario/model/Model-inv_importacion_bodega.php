<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
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
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
     
    //---------------------------------------------------------
    function _DetalleImportacion( $id_movimiento, $id_importacion ,$id,$idbodega1 ){
        
        
   
        
        $sql_det = 'SELECT id_importacionfacitem, id_importacionfac, id_importacion, idproducto, 
                           partida, cantidad, costo, peso, advalorem, infa, iva, salvaguardia, aranceles
                     FROM inv_importaciones_fac_item 
                    where id_importacionfac = '.$this->bd->sqlvalue_inyeccion($id, true);
        
        $stmt13 = $this->bd->ejecutar($sql_det);
      
        while ($x=$this->bd->obtener_fila($stmt13)){
              
            $this->nuevo_item($id_movimiento,$x ) ;
              
            
        }
        //---------------------------<factura id="comprobante" version="1.1.0">
         
        $sql = "UPDATE inv_importaciones_fac
                 SET 	id_movimiento=".$this->bd->sqlvalue_inyeccion($id_movimiento, true)."
                 WHERE id_importacionfac=".$this->bd->sqlvalue_inyeccion($id, true);
        
        $this->bd->ejecutar($sql);
        
         
    }
    //------------------------------------
    
    //--------------------------------------------------------
    function nuevo_item($id_movimiento,$datos ){
        
        //---------------------------------------------------
        $IVA               = 12/100;
        $sesion 	       =    $_SESSION['email'];
        //----------------------------------------------------
        $costo =  $datos['costo'] ;
        
        
        $id_producto =  $datos['idproducto'] ;
        //----------------------------------------------------
        $ingreso       =  $datos['cantidad'];
        $cantidad      =   $datos['cantidad'];
        $egreso        = 0;
        //----------------------------------------------------
        
 
            $baseiva     = $costo * $cantidad ;
            $monto_iva   = round($baseiva * $IVA,2);
            $total       = $monto_iva + $baseiva ;
            $tarifa_cero = '0';
            $tipo = 'I';
 
        
        
        
        $ATabla = array(
            array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $id_producto,   filtro => 'N',   key => 'N'),
            array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
            array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
            array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
            array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
            array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => $tipo,   filtro => 'N',   key => 'N'),
            array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $ingreso,   filtro => 'N',   key => 'N'),
            array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => $egreso,   filtro => 'N',   key => 'N'),
            array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $sesion,   filtro => 'N',   key => 'N')
        );
        
        
        $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
        
        
        
    }
   
    //------------------
    function movimiento($id_importacion ,$id ,$idbodega1  ){
        
        
        $x = $this->bd->query_array('inv_importaciones','fecha, registro, dai,  distrito, regimen, tipodespacho', 
                                     'id_importacion='.$this->bd->sqlvalue_inyeccion($id_importacion,true)
                                  );
        
        
        $z = $this->bd->query_array('inv_importaciones_fac','fechafactura,   factura, nombre_factura, naturaleza, id_movimiento', 
                                     'id_importacion='.$this->bd->sqlvalue_inyeccion($id_importacion,true).' and '.
                                     'id_importacionfac='.$this->bd->sqlvalue_inyeccion($id,true)
            );
        
      
        
        if ( $z['id_movimiento'] > 0  ) {
            
            return 0 ;
            
        }else {
        
            $cadena =   trim($x['dai']). ' '.  trim($z['nombre_factura']).' Nro.Factura '. trim($z['factura']).
     
     
            $fecha     = $this->hoy;
            $idprov    = '9999999999999';
            $idperiodo = $this->periodo($fecha);
            
            $ATabla = array(
                array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
                array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
                array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor =>$cadena,   filtro => 'N',   key => 'N'),
                array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
                array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
                array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '00000',   filtro => 'N',   key => 'N'),
                array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
                array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'I',   filtro => 'N',   key => 'N'),
                array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => $idperiodo,   filtro => 'N',   key => 'N'),
                array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => $x['dai'],   filtro => 'N',   key => 'N'),
                array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => $idprov,   filtro => 'N',   key => 'N'),
                array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
                array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
                array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'compra',   filtro => 'N',   key => 'N'),
                array( campo => 'idbodega',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => $idbodega1,   filtro => 'N',   key => 'N')
            );
            
            $tabla 	  	  = 'inv_movimiento';
            
            $id = $this->bd->_InsertSQL($tabla,$ATabla, '-' );
        
             return $id ;
         }
        
    }
    
    //-------------------
    function periodo($fecha ){
        
        $anio = substr($fecha, 0, 4);
        $mes  = substr($fecha, 5, 2);
        
        $APeriodo = $this->bd->query_array('co_periodo',
            'id_periodo, estado',
            'registro='.$this->bd->sqlvalue_inyeccion($this->ruc,true). ' AND
											  mes = '.$this->bd->sqlvalue_inyeccion($mes,true). ' AND
											  anio ='.$this->bd->sqlvalue_inyeccion($anio,true)
            );
        
        
        $this->estado_periodo = trim($APeriodo['estado']);
        
        return $APeriodo['id_periodo'];
        
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
if (isset($_GET["id_importacion"]))	{
    
    
    $id_importacion =     $_GET["id_importacion"];
    
    $id 	       =     $_GET["id"];
    
    $idbodega1 	       =     $_GET["idbodega1"];
      
    
    $id_movimiento = $gestion->movimiento( $id_importacion ,$id,$idbodega1);
    
    if ($id_movimiento >  0 ){
        
        $gestion->_DetalleImportacion($id_movimiento, $id_importacion ,$id,$idbodega1 ) ;
        
        $ImportaGuarda = 'Informacion generada con exito';
        
    }else{
        $ImportaGuarda = 'Dato Ya generado';
        
    }
   
    echo $ImportaGuarda ;
    
    
    
}



?>
 
  