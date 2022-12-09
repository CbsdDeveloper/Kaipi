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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function archivo_xml($archivo , $id, $bodega){
        
        $sqldelete = 'delete from xml_sesion where sesion = '.$this->bd->sqlvalue_inyeccion($this->sesion, true);
        
        $this->bd->ejecutar($sqldelete);
        
        
      //  $file = '../archivos/xml/'.$archivo ;
      
    
      
        $file =  $archivo ;
        
        $myfile = fopen(  $file , "r") or die("Unable to open file!");
        
        $i = 0;
        
        while(!feof($myfile)) {
            
            // $linea = fgets($myfile) ;
            
            $linea = fgets($myfile);
            
            //  if ( $i <= 300 ){
            
            $linea = htmlspecialchars_decode($linea);
            
            
            
            $sql = "INSERT INTO xml_sesion ( sesion, etiqueta) values (".
                $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                $this->bd->sqlvalue_inyeccion( $linea, true).")";
                
                $this->bd->ejecutar($sql);
                
                // }
                $i++;
        }
        
        fclose($myfile);
        
        $procesado = $this->_VariablesTipo();
        
        if ( $procesado == 1){
            
            $this->_VariablesFactura($id,$bodega);
            
            $procesado = ' ok Actualice la informacion...';
        }
        
        
     
        
        echo $procesado;
        
    }
    //---------------------------------------------------------
    function _VariablesTipo(  ){
        
        $sql_det = 'SELECT id_xmlserie, etiqueta, sesion
                     FROM xml_sesion
                     where sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        $n1 = 0;
        
        $n2 = 0;
        
        while ($x=$this->bd->obtener_fila($stmt13)){
            
            $etiqueta = trim($x['etiqueta']);
            
            if ( $n1 == 0){
                $pos = strpos($etiqueta, '<RespuestaAutorizacionComprobante',0);
                
                if ($pos !== false) {
                    $n1 = 1;
                }
               
            }
             //--------------------------------------------
            if ( $n2 == 0){
                $pos = strpos($etiqueta, '<autorizacion>',0);
                
                if ($pos !== false) {
                    $n1 = 1;
                    $n2 = 1;
                }
                
            }
             
        }
        //---------------------------<factura id="comprobante" version="1.1.0">
        
        if ( $n1 == 1 ){
            
            $sql = 'SELECT id_xmlserie, etiqueta, sesion
                     FROM xml_sesion
                     where sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
            
            $stmt1 = $this->bd->ejecutar($sql);
            
            $y= 0 ;
               
            while ($xx=$this->bd->obtener_fila($stmt1)){
                
                $etiqueta1 = trim($xx['etiqueta']);
                
                if ( $y == 0){
                    
                    $pos = strpos($etiqueta1, '<factura id="comprobante',0);
                    
                    $etiquetaDos = trim($xx['etiqueta']);
                    
                    if ($pos !== false) {
                        $y = 1;
                    }
                    
                }
                
            }
        }
        //----------------------------
        if ($y == 1){
            
            $sqldelete = 'delete from xml_sesion where sesion = '.$this->bd->sqlvalue_inyeccion($this->sesion, true);
            
            $this->bd->ejecutar($sqldelete);
            
            $matriz = explode("<detalle>", $etiquetaDos);
            
            $this->_forma_agrega( $matriz ) ;
            
        }
        
        
        return $n1;
        
    }
   //------------------------------------ 
    function _VariablesFactura( $id,$bodega ){
        
        $sql_det = 'SELECT id_xmlserie, etiqueta, sesion
                     FROM xml_sesion
                     where sesion='.$this->bd->sqlvalue_inyeccion($this->sesion, true);
        
        $stmt13 = $this->bd->ejecutar($sql_det);
        
        $n1 = 0;
        $n2 = 0;
        $n3 = 0;
        $n4 = 0;
        $n5 = 0;
 
        
        $datos = array(); // $foo is here again
        
        echo ' <table  id="tablaItem" class="display table table-condensed table-hover datatable" cellspacing="0" width="100%"  >
																					<thead>
																						<tr>
																					   <th width="20%">Id Producto</th>
																						<th  width="60%">Descripcion</th>
																						<th width="20%">Codigo</th>
 																						</tr>
																					</thead> ';
        while ($x=$this->bd->obtener_fila($stmt13)){
            
            $etiqueta = trim($x['etiqueta']);
            
        
            // <razonSocial>
            if ( $n1 == 0){
                $pos1_razon = strpos($etiqueta, '<codigoPrincipal>');
                $pos2_razon = strpos($etiqueta, '</codigoPrincipal>');
                $razon1 =$etiqueta;
            }
            if ($pos2_razon > 0 ){
                $razon = substr($razon1,$pos1_razon,$pos2_razon - $pos1_razon);
                $aux1 = str_replace ( '<codigoPrincipal>' ,'' , $razon );
                $aux2 = str_replace ( '</codigoPrincipal>' ,'' , $aux1 );
                $datos['codigoPrincipal'] = $aux2;
                $n1 = 1;
            }
            //  <ruc>
            if ( $n2 == 0){
                $pos1_r = strpos($etiqueta, '<descripcion>');
                $pos2_r = strpos($etiqueta, '</descripcion>');
                $ruc1    =$etiqueta;
            }
            if ($pos2_r > 0 ){
                $razon = trim(substr($ruc1,$pos1_r,$pos2_r - $pos1_r));
                $aux1 = str_replace ( '<descripcion>' ,'' , $razon );
                $aux2 = str_replace ( '</descripcion>' ,'' , $aux1 );
                $datos['descripcion'] = $aux2;
                $n2 = 1;
            }
            // </claveAcceso>
            if ( $n3 == 0){
                $pos1_a = strpos($etiqueta, '<cantidad>');
                $pos2_a = strpos($etiqueta, '</cantidad>');
                $claveAcceso    =$etiqueta;
            }
            if ($pos2_a > 0 ){
                $razon = substr($claveAcceso,$pos1_a,$pos2_a - $pos1_a);
                $aux1 = str_replace ( '<cantidad>' ,'' , $razon );
                $aux2 = str_replace ( '</cantidad>' ,'' , $aux1 );
                $datos['cantidad'] = $aux2;
                $n3 = 1;
            }
            //<estab>
            if ( $n4 == 0){
                $pos1_b = strpos($etiqueta, '<precioUnitario>');
                $pos2_b = strpos($etiqueta, '</precioUnitario>');
                $estab    =$etiqueta;
            }
            if ($pos2_b > 0 ){
                $razon = substr($estab,$pos1_b,$pos2_b - $pos1_b);
                $aux1 = str_replace ( '<precioUnitario>' ,'' , $razon );
                $aux2 = str_replace ( '</precioUnitario>' ,'' , $aux1 );
                $datos['precioUnitario'] = $aux2;
                $n4 = 1;
            }
            //<ptoEmi>
            if ( $n5 == 0){
                $pos1_t = strpos($etiqueta, '<tarifa>');
                $pos2_t = strpos($etiqueta, '</tarifa>');
                $ptoEmi    =$etiqueta;
            }
            if ($pos2_t > 0 ){
                $razon = substr($ptoEmi,$pos1_t,$pos2_t - $pos1_t);
                $aux1 = str_replace ( '<tarifa>' ,'' , $razon );
                $aux2 = str_replace ( '</tarifa>' ,'' , $aux1 );
                $datos['tarifa'] = $aux2;
                $n5 = 1;
            }
            //<secuencial>
 
            $idproducto = $this->_busca_producto($datos['codigoPrincipal'],$bodega);
            
      
            $dato = "'".trim($datos['descripcion'])."'";
            
            $dato1 = "'".trim($datos['codigoPrincipal'])."'";
          
            
            $enlace = '<a href="#" onclick="goToURLCodigo('.$dato.','.$dato1.')" data-toggle="modal" data-target="#ViewCodigo">'.$datos['codigoPrincipal'].'</a>';
           
            echo '  <tr>
            <td>'.$idproducto.'</td>
            <td>'.trim($datos['descripcion']).'</td>
            <td>'.$enlace.'</td>
            </tr>';
            
            unset($datos); // $foo is gone
            
            $datos = array(); // $foo is here again
            
            $n1 = 0;
            $n2 = 0;
            $n3 = 0;
            $n4 = 0;
            $n5 = 0;
            
        }
        
        echo ' </table>';
        
    }
    //--------------------------------------------------------
    function nuevo($id_movimiento,$id_producto,$datos ){
        
        //---------------------------------------------------
         $IVA               = 12/100;
         $sesion 	       =    $_SESSION['email'];
        //----------------------------------------------------
        $costo =  $datos['precioUnitario'] ;
        //----------------------------------------------------
         $ingreso       =  $datos['cantidad'];
        $cantidad      =   $datos['cantidad'];
        $egreso        = 0;
         //----------------------------------------------------
        
        if ($datos['tarifa']  == '12'){
            $baseiva     = $costo * $cantidad ;
            $monto_iva   = round($baseiva * $IVA,2);
            $total       = $monto_iva + $baseiva ;
            $tarifa_cero = '0';
            $tipo = 'I';
            
        } else{
            $monto_iva   = '0';
            $tarifa_cero = $costo;
            $baseiva     = '0';
            $total = $tarifa_cero;
            $tipo = 'T';
        }
        
        
        
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
    //---------------------------------------------------------
    function _busca_producto($codigo, $bodega){
        
        //<fechaEmision>27/05/2018</fechaEmision>  date("Y-m-d");
        
        $AResultado = $this->bd->query_array(
            'web_producto',
            'idproducto',
            'codigo='.$this->bd->sqlvalue_inyeccion(trim($codigo),true). ' and
                 idbodega='.$this->bd->sqlvalue_inyeccion(trim($bodega),true). ' and
                 registro ='.$this->bd->sqlvalue_inyeccion(trim( $this->ruc),true)
            );
        
        return  $AResultado['idproducto'];
         
            
          
    }
 
    //---------------------------------------------------------
    function existe_asiento($idproducto,$id_movimiento ){
        
        
        
        $Aprove = $this->bd->query_array('inv_movimiento_det',
            'count(*) as nn',
            'idproducto='.$this->bd->sqlvalue_inyeccion($idproducto,true).' and
             id_movimiento='.$this->bd->sqlvalue_inyeccion($id_movimiento,true)
            );
        
        
        if ( $Aprove['nn'] == 0 ) {
            return 0;
        }else {
            return 1;
        }
        
    }
    //---------------------------------------------------------
    function _forma_agrega( $matriz ){
        
        
        
        for($i=0 ;  $i<count($matriz); $i++ ){
            
            $sql = "INSERT INTO xml_sesion ( sesion, etiqueta) values (".
                $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                $this->bd->sqlvalue_inyeccion(   $matriz[$i], true).")";
                
                $this->bd->ejecutar($sql);
        
        
        }
        
 
        
    }
    //------------------
    function movimiento($bodega   ){
           
         
        $fecha     = $this->hoy;
        $idprov    = '9999999999999';
        $idperiodo = $this->periodo($fecha);
        
        $ATabla = array(
            array( campo => 'id_movimiento',   tipo => 'VARCHAR2',   id => '0',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
            array( campo => 'fecha',   tipo => 'DATE',   id => '1',  add => 'S',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
            array( campo => 'registro',   tipo => 'VARCHAR2',   id => '2',  add => 'S',   edit => 'N',   valor => $this->ruc,   filtro => 'N',   key => 'N'),
            array( campo => 'detalle',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => 'Adquisicion para inventarios',   filtro => 'N',   key => 'N'),
            array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => $this->sesion ,   filtro => 'N',   key => 'N'),
            array( campo => 'creacion',   tipo => 'DATE',   id => '5',  add => 'S',   edit => 'N',   valor => $this->hoy,   filtro => 'N',   key => 'N'),
            array( campo => 'comprobante',   tipo => 'VARCHAR2',   id => '6',  add => 'N',   edit => 'N',   valor => '00000',   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '7',  add => 'S',   edit => 'N',   valor => 'digitado',   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'N',   valor => 'I',   filtro => 'N',   key => 'N'),
            array( campo => 'id_periodo',   tipo => 'NUMBER',   id => '9',  add => 'S',   edit => 'N',   valor => $idperiodo,   filtro => 'N',   key => 'N'),
            array( campo => 'documento',   tipo => 'VARCHAR2',   id => '10',  add => 'S',   edit => 'S',   valor => '0000-000',   filtro => 'N',   key => 'N'),
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => $idprov,   filtro => 'N',   key => 'N'),
            array( campo => 'id_asiento_ref',   tipo => 'NUMBER',   id => '12',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
            array( campo => 'fechaa',   tipo => 'DATE',   id => '13',  add => 'N',   edit => 'N',   valor => $fecha,   filtro => 'N',   key => 'N'),
            array( campo => 'transaccion',   tipo => 'VARCHAR2',   id => '14',  add => 'S',   edit => 'S',   valor => 'compra',   filtro => 'N',   key => 'N'),
            array( campo => 'idbodega',   tipo => 'NUMBER',   id => '15',  add => 'S',   edit => 'N',   valor => $bodega,   filtro => 'N',   key => 'N')
        );
        
        $tabla 	  	  = 'inv_movimiento';
 
        $id = $this->bd->_InsertSQL($tabla,$ATabla, '-' );
        
        return $id ;
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
if (isset($_GET["archivo"]))	{
    
    
    $archivo =     $_GET["archivo"];
    
    $id 	 =     $_GET["id"];
    
    $bodega  =     $_GET["bodega"];
    
    
    $gestion->archivo_xml( $archivo ,$id,$bodega);
 
   
    
    
    
    
}



?>
 
  