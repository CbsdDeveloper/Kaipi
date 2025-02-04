<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php';  

  
class proceso{
    
     
    private $obj;
    private $bd;
     
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $datos;
    private $ATabla;
    private $ATabla_detalle;
    
    private $tabla ;
    private $secuencia;
     
     
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso(  ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj      = 	new objects;
        $this->bd	    =	new Db ;
         
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    
        
        $this->ATabla = array(
            array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fechaa',tipo => 'DATE',id => '2',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'estado',tipo => 'VARCHAR2',id => '6',add => 'S', edit => 'N', valor => 'E', key => 'N'),
            array( campo => 'cierre',tipo => 'VARCHAR2',id => '7',add => 'S', edit => 'S', valor => 'N', key => 'N'),
            array( campo => 'iva',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base0',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'base12',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'interes',tipo => 'NUMBER',id => '11',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'descuento',tipo => 'NUMBER',id => '12',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'recargo',tipo => 'NUMBER',id => '13',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'total',tipo => 'NUMBER',id => '14',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'carga',tipo => 'NUMBER',id => '15',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'envio',tipo => 'VARCHAR2',id => '16',add => 'S', edit => 'N', valor => 'N', key => 'N'),
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '17',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '20',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesion_pago',tipo => 'VARCHAR2',id => '23',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'N', valor => 'servicios', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'multa',tipo => 'NUMBER',id => '27',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'fechap',tipo => 'DATE',id => '28',add => 'N', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion_baja',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '30',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '31',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fecha_obligacion',tipo => 'DATE',id => '32',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'subtotal',tipo => 'NUMBER',id => '33',add => 'S', edit => 'N', valor => '-', key => 'N')
         );
        
 
 
        $this->tabla 	  	     = 'rentas.ren_movimiento';
        
        $this->secuencia 	     = 'rentas.ren_movimiento_id_ren_movimiento_seq';
        
        
        
        $this->ATabla_detalle = array(
            array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '0',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_ren_movimientod',tipo => 'NUMBER',id => '2',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'costo',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto_iva',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseiva',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tarifa_cero',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'descuento',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'interes',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'recargo',tipo => 'NUMBER',id => '9',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'total',tipo => 'NUMBER',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tipo',tipo => 'VARCHAR2',id => '11',add => 'S', edit => 'S', valor => '0', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '12',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '13',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
        );
        
        
    }
    
    //--- calcula libro diario
    //---------------------------------------------------------
    public function VisorTramites(   $tramite   ){
        
        $qservicios = array(
            array( campo => 'id_ren_tramite',valor => $tramite,filtro => 'S', visor => 'S'),
            array( campo => 'imprime',valor => 'S',filtro => 'S', visor => 'S'),
            array( campo => 'id_catalogo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'nombre_variable',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor_variable',valor => '-',filtro => 'N', visor => 'S'),
        );
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_tramite_var',$qservicios );
        
        $cadena = '';
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            if (trim($fetch['id_catalogo']) == '0'){
                
                $cadena   = $cadena.' '.trim($fetch['nombre_variable']) . ': '.trim($fetch['valor_variable']) ;
                
            }else{
                
                $valor = $this->bd->_catalogo_dato($fetch['valor_variable']);
                
                $cadena   = $cadena.' '.trim($fetch['nombre_variable']) . ': '. $valor;
            }
            
        }
        
         return trim($cadena);
        
     }
    ///-------------------------------------------------------
    public function _detalle_emision(  $id_movimiento,$GET     ){
        
 
        
        $qservicios = array(
            array( campo => 'id_ren_temp',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto_iva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tarifa_cero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'interes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'recargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor =>$this->sesion ,filtro => 'S', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
        );
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_temp',$qservicios );
        
  
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $this->ATabla_detalle[0][valor]  =  $fetch['idproducto_ser'];
            
            $this->ATabla_detalle[1][valor]  =  $id_movimiento;
            
            $this->ATabla_detalle[3][valor]   =  $fetch['costo'];
            $this->ATabla_detalle[4][valor]   =  $fetch['monto_iva'];
            
            $this->ATabla_detalle[5][valor]  =  $fetch['baseiva'];
            $this->ATabla_detalle[6][valor]   =  $fetch['tarifa_cero'];

            $this->ATabla_detalle[7][valor]  =  $fetch['descuento'];
            $this->ATabla_detalle[8][valor]  =  $fetch['interes'];
            $this->ATabla_detalle[9][valor]  =  $fetch['recargo'];
            $this->ATabla_detalle[10][valor]  =  $fetch['total'];
            
            $this->bd->_InsertSQL('rentas.ren_movimiento_det',$this->ATabla_detalle,'rentas.ren_movimiento_det_id_ren_movimientod_seq',0 );
            
        }
         
            
        
    }
    //------------------------------------------------------
    //------------------------------------------------------
    public function Emision_titulos(   $GET    ){
        

        $x_tramite = $this->bd->query_array('rentas.ren_tramites',   // TABLA
            '*',                        // CAMPOS
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($GET['tramite'],true) // CONDICION
            );
        
        
        
        $x_total = $this->bd->query_array('rentas.ren_temp',   // TABLA
             'sum(costo) costo, 
              sum(monto_iva) monto_iva, 
              sum(baseiva) baseiva, 
              sum(tarifa_cero) tarifa_cero, 
              sum(descuento) descuento, 
              sum(interes) interes, 
              sum(recargo) recargo, 
              sum(total) total',                        // CAMPOS
             'sesion='.$this->bd->sqlvalue_inyeccion( $this->sesion ,true) // CONDICION
            );
 
        $detalle =  $this->VisorTramites(   $GET['tramite']   );

        $titulo  =  trim($x_tramite['detalle']) .' '.$detalle;
        
        
         $mes  =   $GET['mes']  ;
         $anio =   $GET['anio']  ;
         
         $input = str_pad($x_tramite['id_rubro'], 4, "0", STR_PAD_LEFT);
        
            
        $this->ATabla[1][valor]  =  $GET['fechae'] ;
        $this->ATabla[3][valor]  =  trim($titulo);
        $this->ATabla[4][valor]  =  $input.'-'.$anio;
        
        $this->ATabla[8][valor]   =  round($x_total['monto_iva'],2);
        $this->ATabla[9][valor]   =  round($x_total['tarifa_cero'],2);
        $this->ATabla[10][valor]  =  round($x_total['baseiva'],2);
        $this->ATabla[11][valor]  =  round($x_total['interes'],2);
        $this->ATabla[12][valor]  =  round($x_total['descuento'],2);
        $this->ATabla[13][valor]  =  round($x_total['recargo'],2);
        
        
        $this->ATabla[33][valor]  =  round($x_total['costo'],2);
        
        $this->ATabla[14][valor]  =  round($x_total['total'],2);
        
        $this->ATabla[18][valor]  =  $GET['tramite'];
        
        $this->ATabla[25][valor]  =  $anio;
        $this->ATabla[26][valor]  =  $mes;
        
        $this->ATabla[30][valor]  =  $x_tramite['id_par_ciu'];
        $this->ATabla[31][valor]  =  $x_tramite['id_rubro'];
        
        $this->ATabla[32][valor]  =  $GET['fechao'] ;
        
        
       $bandera =  $this->buscarTramites(   $x_tramite['id_par_ciu'], $x_tramite['id_rubro'] ,$anio,$mes  );
        
 
       $bandera = 0;

        if ( $bandera > 0 ){
            
            //--------ELIMINA TEMPORAL ---------------------------------------
            
            $sql = 'delete from rentas.ren_temp
                 where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
            
            $this->bd->ejecutar($sql);
            
            echo 'Transaccion Ya generada';

         
            
        }else{
        

         $id_movimiento =  $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia ,0);
        
        $this->_detalle_emision($id_movimiento,$GET);
        
        
        //--------ELIMINA TEMPORAL ---------------------------------------

        $sql = 'delete from rentas.ren_temp 
                 where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
        
        $this->bd->ejecutar($sql);
        
        
        //--------ACTUALIZA EMISION DE TRAMITES ---------------------------------------
        
        $sql = "UPDATE rentas.ren_tramites set estado = 'aprobado'
                 where id_ren_tramite= ".$this->bd->sqlvalue_inyeccion($GET['tramite'] ,true);
        
        $this->bd->ejecutar($sql);
        
        echo 'Transaccion '.$id_movimiento.' '. $id_par_ciu;
        
        }
       
        
       
    }
//-------------------------------------------------------------  
    public function buscarTramites(   $id_par_ciu, $rubro,$anio,$mes  ){
        

        $xx = $this->bd->query_array('rentas.view_ren_movimiento_diario',   // TABLA
        'count(*) as  nn',                                     // CAMPOS
        'id_par_ciu ='.$this->bd->sqlvalue_inyeccion($id_par_ciu,true)  .' and 
           id_rubro ='.$this->bd->sqlvalue_inyeccion($rubro,true)  .' and
           anio    ='.$this->bd->sqlvalue_inyeccion($anio,true) .' and
           mes    ='.$this->bd->sqlvalue_inyeccion($mes,true) ." and
           estado  in ('E','P','A')"
           
        );


        if ( $xx["nn"] > 0 ){
            $bandera = 1;
        }else{
            $bandera = 0;
        }
 
        
            return $bandera;
 
                
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------



 
//------ grud de datos insercion
if (isset($_GET["tramite"]))	{
  
    $gestion   = 	new proceso( );
    
    $gestion->Emision_titulos(  $_GET );
    

    
}




?>
 
  