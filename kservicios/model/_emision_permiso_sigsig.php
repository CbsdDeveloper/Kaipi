<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php';  

  
class proceso{
    
     
    private $obj;
    private $bd;
    private $bd_cat;
     
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $datos;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    private $qservicios;
    private $ATabla_emite;
    private $ATabla_detalle;
    
    private $calculo_servicio;
     
     
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
        
        $this->calculo_servicio = array();
        
      
        $this->qservicios = array(
            array( campo => 'id_rubro',valor => $rubro,filtro => 'S', visor => 'S'),
            array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tributo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado_servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'facturacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'interes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'recargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_formula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'formula',valor => '-',filtro => 'N', visor => 'S'),
        );
         
        
        
        
        $this->ATabla = array(
            array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '0',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'costo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto_iva',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseiva',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tarifa_cero',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'descuento',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'interes',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'recargo',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'total',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
        


        $this->ATabla_emite = array(
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

        
        $this->calculo_servicio['monto_iva'] = '0.00';
        $this->calculo_servicio['baseiva'] = '0.00';
        $this->calculo_servicio['tarifa_cero'] = '0.00';
        $this->calculo_servicio['descuento'] = '0.00';
        $this->calculo_servicio['interes'] = '0.00';
        $this->calculo_servicio['recargo'] = '0.00';
        $this->calculo_servicio['total'] = '0.00';
        
        
        $this->tabla 	  	     = 'rentas.ren_temp';
        
        $this->secuencia 	     = 'rentas.ren_temp_id_ren_temp_seq';
        
        
    }
    
     
  
    //------------------------------------------------------
    public function Emision_titulos( ){
        

        ini_set("max_execution_time", "-1");
        ini_set("memory_limit", "-1");
        ignore_user_abort(true);
        set_time_limit(0);
 

        $sql = "select id_ren_tramite , apago ,fecha_pago ,id_par_ciu ,idprov , detalle,rebaja_la ,id_rubro
        from rentas.view_ren_tramite
        where apago >2015
        order by fecha_pago, apago";



        $i = 1 ;

        $resultado = $this->bd->ejecutar($sql);

        while ($x=$this->bd->obtener_fila($resultado)){

            $tramite =  $x['id_ren_tramite'] ;
            
            $rubro  =  $x['id_rubro'] ;


 
            $fechae = $x.'-01-01';
            $fechao = $x.'-03-30';
            $anio   = $x;
            $mes    = '01';
 


            $anio_emision =  trim($x['apago']) + 1;

            for ($x = $anio_emision ; $x <= 2021; $x++) {
               
                $this->simulacion_titulos(   $tramite ,  $rubro   );

                $this->Emision_titulos_individual( $tramite ,  $rubro ,$fechae ,$fechao,$anio ,$mes);
              }

        }

 
                $mensaje = ' Registros procesados ...';

                echo  $mensaje;
       
    }
     
/*
*/
public function simulacion_titulos(   $tramite ,  $rubro   ){
        
        
    $sql = 'delete from rentas.ren_temp  where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
    
    $this->bd->ejecutar($sql);
  
    $url_externa =   trim($this->bd->_url_externo(75)); 

    $resultado = $this->bd->JqueryCursorVisor('rentas.view_rubro_servicios', $this->qservicios);
    
    while ($fetch=$this->bd->obtener_fila($resultado)){
        
        $formula      = trim($fetch['formula']);
  
        $tipo_formula = trim($fetch['tipo_formula']);
  
        $costo        = trim($fetch['costo']);
        
        $url=  "../formula/".trim($formula).".php";
  
        $url=  $url_externa.trim($formula).".php";
       
        $parametros_post = "tramite=".$tramite."&tipo_formula=".$tipo_formula."&costo=".$costo;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros_post);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
      
        $data = curl_exec($ch);
       
          
        curl_close($ch);
        
        $this->calculo_servicio['costo'] = $data;
          
        if (  $this->calculo_servicio['costo'] > 0 ){
            
            $this->_tributo(  $fetch,    $this->calculo_servicio['costo'] );
            
            $this->_calculo(  $fetch   );
            
        } 
         
    }

    pg_free_result($resultado); 
    unset($fetch);
    
}  
/*
*/
    public function _calculo(  $fetch     ){
        
        
        $this->calculo_servicio['total'] = ($this->calculo_servicio['costo'] +
        $this->calculo_servicio['monto_iva'] +
        $this->calculo_servicio['interes'] +
        $this->calculo_servicio['recargo'] ) -
        $this->calculo_servicio['descuento'];
        
        
        
        $this->ATabla[0][valor]  =  $fetch['idproducto_ser'];
        
        $this->ATabla[1][valor]  =  $this->calculo_servicio['costo'];
        $this->ATabla[2][valor]  =  $this->calculo_servicio['monto_iva'];
        $this->ATabla[3][valor]  =  $this->calculo_servicio['baseiva'];
        $this->ATabla[4][valor]  =  $this->calculo_servicio['tarifa_cero'];
        $this->ATabla[5][valor]  =  $this->calculo_servicio['descuento'];
        $this->ATabla[6][valor]  =  $this->calculo_servicio['interes'];
        $this->ATabla[7][valor]  =  $this->calculo_servicio['recargo'];
        
        $this->ATabla[8][valor]  =  $this->calculo_servicio['total'];
        
        $this->ATabla[10][valor]  =  $fetch['servicio'];
        
        if ( $this->calculo_servicio['costo'] > 0 ){
            
            $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
            
        }
         
 
}

/*
*/
public function _tributo(  $fetch,    $costo  ){    
    
    $iva = 12/100;
    
    if ( $fetch['tributo'] == '-'){
        $this->calculo_servicio['monto_iva'] = '0.00';
        $this->calculo_servicio['baseiva'] = '0.00';
        $this->calculo_servicio['tarifa_cero'] = '0.00';
    }
    if ( $fetch['tributo'] == 'I'){
        $this->calculo_servicio['monto_iva'] = $costo * $iva;
        $this->calculo_servicio['baseiva'] = $costo;
        $this->calculo_servicio['tarifa_cero'] = '0.00';
    }
    if ( $fetch['tributo'] == 'T'){
        $this->calculo_servicio['monto_iva'] = '0.00';
        $this->calculo_servicio['baseiva'] = '0.00';
        $this->calculo_servicio['tarifa_cero'] = $costo;
    }
    

}
/*
*/

public function Emision_titulos_individual(  $tramite ,  $rubro ,$fechae ,$fechao,$anio ,$mes  ){
        

    $x_tramite = $this->bd->query_array('rentas.ren_tramites',   // TABLA
        '*',                        // CAMPOS
        'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($tramite,true) // CONDICION
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

    $detalle =  $this->VisorTramites(  $tramite );

    $titulo  =  trim($x_tramite['detalle']) .' '.$detalle;
    
 
     
     $input = str_pad($x_tramite['id_rubro'], 4, "0", STR_PAD_LEFT);
    
        
    $this->ATabla_emite[1][valor]  =  $fechae;
    $this->ATabla_emite[3][valor]  =  trim($titulo);
    $this->ATabla_emite[4][valor]  =  $input.'-'.$anio;
    
    $this->ATabla_emite[8][valor]   =  round($x_total['monto_iva'],2);
    $this->ATabla_emite[9][valor]   =  round($x_total['tarifa_cero'],2);
    $this->ATabla_emite[10][valor]  =  round($x_total['baseiva'],2);
    $this->ATabla_emite[11][valor]  =  round($x_total['interes'],2);
    $this->ATabla_emite[12][valor]  =  round($x_total['descuento'],2);
    $this->ATabla_emite[13][valor]  =  round($x_total['recargo'],2);
    
    
    $this->ATabla_emite[33][valor]  =  round($x_total['costo'],2);
    
    $this->ATabla_emite[14][valor]  =  round($x_total['total'],2);
    
    $this->ATabla_emite[18][valor]  =   $tramite ;
    
    $this->ATabla_emite[25][valor]  =  $anio;
    $this->ATabla_emite[26][valor]  =  $mes;
    
    $this->ATabla_emite[30][valor]  =  $x_tramite['id_par_ciu'];
    $this->ATabla_emite[31][valor]  =  $x_tramite['id_rubro'];
    
    $this->ATabla_emite[32][valor]  =  $fechao;
    
       
    $tabla 	  	     = 'rentas.ren_movimiento';
        
    $secuencia 	     = 'rentas.ren_movimiento_id_ren_movimiento_seq';
    

     $id_movimiento =  $this->bd->_InsertSQL($tabla,$this->ATabla_emite, $secuencia ,0);
    
    $this->_detalle_emision($id_movimiento);
    
    
    //--------ELIMINA TEMPORAL ---------------------------------------

    $sql = 'delete from rentas.ren_temp 
             where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
    
    $this->bd->ejecutar($sql);
     
   
}
/*
*/
   
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
    
    pg_free_result($resultado); 
    unset($fetch);

    return trim($cadena);
    
 }
 /*
 */
public function _detalle_emision(  $id_movimiento    ){
        
 
        
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
                    
                    $this->bd->_InsertSQL('rentas.ren_movimiento_det',$this->ATabla_detalle,'rentas.ren_movimiento_det_id_ren_movimientod_seq' );
                    
                }
     
                pg_free_result($resultado); 
                unset($fetch);
    
    }

}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------


  
        $gestion   = 	new proceso( );

 
        $gestion->Emision_titulos();
 
    


 



?>
 
  