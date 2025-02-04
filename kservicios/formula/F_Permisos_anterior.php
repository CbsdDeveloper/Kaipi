<?php
session_start( );
require 'ajax_ren_formulas.php';

class formula_datos{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    private $formulas;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $datos;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    private $qservicios;
    
    private $calculo_servicio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso($rubro ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj      = 	new objects;
        $this->bd	    =	new Db ;
        $this->formulas =  	new formulas($this->obj, $this->bd ) ;
        
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
    
    //--- calcula libro diario
     
    ///-------------------------------------------------------
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
    //------------------------------------------------------
    //------------------------------------------------------
    public function Emision_titulos(   $tramite ,  $rubro   ){
        
        
        $sql = 'delete from rentas.ren_temp
                 where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
        
        ///--- desplaza la informacion de la gestion
        $this->bd->ejecutar($sql);
        
        
        $x_tramite = $this->bd->query_array('rentas.ren_tramites',   // TABLA
            '*',                        // CAMPOS
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($tramite,true) // CONDICION
            );
        
        
        ///-----------------------------------------------------------------------------------
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_rubro_servicios',$this->qservicios );
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            //-------- FUNCIONAMIENTO
            if ($fetch['idproducto_ser'] == 1 ){
                $this->_01_permiso_anual($fetch,$tramite);
                $this->_tributo(  $fetch,    $this->calculo_servicio['costo'] );
            }
            
            //-------- MULTA FUNCIONAMIENTO
            if ($fetch['idproducto_ser'] == 4 ){
                if ($x_tramite['multa'] == 'S' ){
                    $this->_01_permiso_anual($fetch,$tramite);
                    $this->calculo_servicio['costo'] = $this->calculo_servicio['costo'] * 10/100;
                }else{
                    $this->calculo_servicio['costo'] = '0.00';
                }
            }
            
            //-------- EMISION DE PERMISOS
            if ($fetch['idproducto_ser'] == 3 ){
                $this->_03_emision_certificados($fetch,$x_tramite);
                
            }
            
            //-------- EMISION DE PERMISOS
            if ($fetch['idproducto_ser'] == 2){
                $this->_02_emision_permisos($fetch,$x_tramite);
                
            }
            
            
            
            
            ///-------------------
            $this->_calculo(  $fetch   );
            
            
        }
    }
    //-------------------------------------------------------------
    //-------------------------------------------------------------
    //--------------------------------------------------------------------
    //------PERMISO DE FUNCIONAMIENTO ANUAL
    public function _01_permiso_anual(  $fetch,   $tramite ){
        
        if ( $fetch['tipo_formula'] == 'constante'){
            $this->calculo_servicio['costo'] = $fetch['costo'];
        }else{
            $this->calculo_servicio['costo'] = $this->formulas->permisos($tramite);
        }
        
    }
    //-----------------------------
    //------EMISION DE CERTIFICADO
    public function _03_emision_certificados(  $fetch,   $x_tramite ){
        
        if ( $fetch['tipo_formula'] == 'constante'){
            $this->calculo_servicio['costo'] = $fetch['costo'];
        }else{
            $this->calculo_servicio['costo'] = $x_tramite['base'];
        }
        
    }
    //-----------------------------
    //------PERMISOS
    public function _02_emision_permisos(  $fetch,   $x_tramite ){
        
        
        
        if ( $fetch['tipo_formula'] == 'constante'){
            $this->calculo_servicio['costo'] = $fetch['costo'];
        }else{
            $this->calculo_servicio['costo'] = $x_tramite['base'];
        }
        
    }
    //-----------------------------
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
    //-----------------------------
    public function _interes(  $fetch,    $rubro   ){
        
        
        $this->calculo_servicio['interes'] = '0.00';
        
        
    }
    //-----------------------------
    public function _descuento(  $fetch,    $rubro   ){
        
        $this->calculo_servicio['descuento'] = '0.00';
        
        
    }
    //-----------------------------
    public function _recargo(  $fetch,    $rubro   ){
        
        $this->calculo_servicio['recargo'] = '0.00';
        
    }
    
    
    
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
 
    
    $tramite 		=     $_GET["tramite"];
    
    $rubro			=     $_GET["rubro"];
    
    $gestion   = 	new formula_datos($rubro);
  
 //   $gestion->Emision_titulos(   $tramite ,  $rubro   );
    
 


?>
 
  