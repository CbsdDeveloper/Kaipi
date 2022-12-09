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

        $this->bd_cat	   =	 	new Db ;

        $this->bd_cat->conectar_sesion_catastro();

         
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    
        
        $this->ATabla = array(
            array( campo => 'id_ren_movimiento',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
            array( campo => 'fecha',tipo => 'DATE',id => '1',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'fechaa',tipo => 'DATE',id => '2',add => 'N', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'comprobante',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'documento',tipo => 'VARCHAR2',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
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
            array( campo => 'subtotal',tipo => 'NUMBER',id => '33',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'enlace',tipo => 'NUMBER',id => '34',add => 'S', edit => 'N', valor => '-', key => 'N')
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
    
    
    ///-------------------------------------------------------
    public function _detalle_emision(  $id_movimiento,$x_array,$id_emite_externo   ){
        
 
        
        $qservicios = array(
            array( campo => 'nombre_rubro_det',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_emite_externo',valor =>$id_emite_externo ,filtro => 'S', visor => 'S') 
        );
       

         
        $resultado = $this->bd_cat->JqueryCursorVisor('enlace_recaudacion.vista_demite_externo',$qservicios );
        
        $monto = '0.00';
  
        
        while ($fetch=$this->bd_cat->obtener_fila($resultado)){
            
            $this->ATabla_detalle[1][valor]  =  $id_movimiento;
           
            $this->ATabla_detalle[3][valor]   =  $fetch['valor'];
            $this->ATabla_detalle[4][valor]   =  $monto ;
            
            $this->ATabla_detalle[5][valor]  =   $monto ;
            $this->ATabla_detalle[6][valor]   =  $monto ;

            $this->ATabla_detalle[7][valor]   =  $monto ;
            $this->ATabla_detalle[8][valor]   =  $monto ;
            $this->ATabla_detalle[9][valor]   =  $monto ;
            $this->ATabla_detalle[10][valor]  =  $fetch['valor'];

            $nombre_rubro_det                  = trim($fetch['nombre_rubro_det']);

            if ( $nombre_rubro_det  == 'SOLAR NO EDIFICADO'){
                $rubro = 103;
            } elseif( $nombre_rubro_det  == 'ADMINISTRATIVOS' ){
                $rubro = 105;
            } elseif( $nombre_rubro_det  == 'BOMBEROS' ){
                $rubro = 104;
            } elseif( $nombre_rubro_det  == 'IMPUESTO PREDIAL' ){
                $rubro = 45;
            } elseif( $nombre_rubro_det  == 'CEM' ){
                $rubro = 107;
            }

            $this->ATabla_detalle[0][valor]  =   $rubro;

            if (  $fetch['valor'] > 0 ){

                      $this->bd->_InsertSQL('rentas.ren_movimiento_det',$this->ATabla_detalle,'rentas.ren_movimiento_det_id_ren_movimientod_seq' );
              }

        }
         
            
        
    }
    //------------------------------------------------------
    public function _detalle_emision_rural(  $id_movimiento,$x_array,$id_emite_externo   ){
        
 
        
        $qservicios = array(
            array( campo => 'nombre_rubro_det',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'valor',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_emite_externo',valor =>$id_emite_externo ,filtro => 'S', visor => 'S') 
        );
       
/*
"SOLAR NO EDIFICADO"
"ADMINISTRATIVOS"
"BOMBEROS"
"IMPUESTO PREDIAL"
"CEM"
*/
         
        $resultado = $this->bd_cat->JqueryCursorVisor('enlace_recaudacion.vista_demite_externo',$qservicios );
        
        $monto = '0.00';
  
        
        while ($fetch=$this->bd_cat->obtener_fila($resultado)){
            
            $this->ATabla_detalle[1][valor]  =  $id_movimiento;
           
            $this->ATabla_detalle[3][valor]   =  $fetch['valor'];
            $this->ATabla_detalle[4][valor]   =  $monto ;
            
            $this->ATabla_detalle[5][valor]  =   $monto ;
            $this->ATabla_detalle[6][valor]   =  $monto ;

            $this->ATabla_detalle[7][valor]   =  $monto ;
            $this->ATabla_detalle[8][valor]   =  $monto ;
            $this->ATabla_detalle[9][valor]   =  $monto ;
            $this->ATabla_detalle[10][valor]  =  $fetch['valor'];

            $nombre_rubro_det                  = trim($fetch['nombre_rubro_det']);

            if ( $nombre_rubro_det  == 'SOLAR NO EDIFICADO'){
                $rubro = 103;
            } elseif( $nombre_rubro_det  == 'ADMINISTRATIVOS' ){
                $rubro = 102;
            } elseif( $nombre_rubro_det  == 'BOMBEROS' ){
                $rubro = 104;
            } elseif( $nombre_rubro_det  == 'IMPUESTO PREDIAL' ){
                $rubro = 64;
            } elseif( $nombre_rubro_det  == 'CEM' ){
                $rubro = 107;
            }

            $this->ATabla_detalle[0][valor]  =   $rubro;

            if (  $fetch['valor'] > 0 ){

                      $this->bd->_InsertSQL('rentas.ren_movimiento_det',$this->ATabla_detalle,'rentas.ren_movimiento_det_id_ren_movimientod_seq' );
              }

        }
         
            
        
    }
    //------------------------------------------------------
    public function Emision_titulos(   $GET    ){
        

        ini_set("max_execution_time", "-1");
        ini_set("memory_limit", "-1");
        ignore_user_abort(true);
        set_time_limit(0);
 
        $titulo = trim($_GET["titulo"]);

        if (  $titulo == 'URBANO'){
            $impuesto = 'TITULO URBANO' ;
        }    

        if (  $titulo == 'RURAL'){
            $impuesto = 'TITULO RURAL'  ;
        }    

        $sql = "SELECT *
                FROM enlace_recaudacion.vista_emite_externo
                where  total > 0 and  nombre_rubro = ".$this->bd->sqlvalue_inyeccion($impuesto ,true). ' order by id_emite_externo';
 
  

        $i = 1 ;

        $resultado = $this->bd_cat->ejecutar($sql);

                while ($x=$this->bd_cat->obtener_fila($resultado)){

                    $id_emite_externo       =  trim($x['id_emite_externo']);
 
                    $x_tramite = $this->bd->query_array($this->tabla ,   // TABLA
                    'count(*) as existe',                        // CAMPOS
                    'enlace='.$this->bd->sqlvalue_inyeccion( $id_emite_externo  ,true) // CONDICION
                    );


                    $existe_emision = $x_tramite['existe'];

 
 
                    if ( $existe_emision > 0 ) {
                            $mensaje = ' Ya existe';
                    }else{

                       $this->agregar_tramite(   $x ,  $id_emite_externo,$titulo );

                       $i ++;
                    }   

                }
 
                $mensaje = ' Registros procesados ...';

                echo  $mensaje;
       
    }
//-------------------------------------------------------------  
    public function agregar_tramite(   $x_array , $id_emite_externo,$titulo_rubro ){
        
   
        $x_total = $this->bd_cat->query_array('enlace_recaudacion.vista_demite_externo',   // TABLA
             'sum(valor) as total',                        // CAMPOS
             'id_emite_externo='.$this->bd_cat->sqlvalue_inyeccion( $id_emite_externo ,true) // CONDICION
            );
  
         $mes       =   '01' ;
         $bandera   =   0;
         $anio      =   $x_array['periodo']  ;
         $input     =   $x_array['id_emite_externo'] ;
         $titulo    =   trim( $x_array['detalle_emision'] );
         $referencia  = trim( $x_array['referencia'] );
            

        $this->ATabla[1][valor]   =  $x_array['fecha_emision'] ;
        $this->ATabla[32][valor]  =  $x_array['fecha_obligacion'] ;
 
        $this->ATabla[3][valor]  =  trim($titulo);
        $this->ATabla[5][valor]  =  trim($referencia);
        $this->ATabla[4][valor]  =  $input;
        
        $valor = '0.00';
        $this->ATabla[8][valor]   =   $valor ;
        $this->ATabla[9][valor]   =   $valor ;
        $this->ATabla[10][valor]  =   $valor ;
        $this->ATabla[11][valor]  =   $valor ;
        $this->ATabla[12][valor]  =   $valor ;
        $this->ATabla[13][valor]  =   $valor ;
        
        
        $this->ATabla[33][valor]  =  round($x_total['total'],2);
        $this->ATabla[14][valor]  =  round($x_total['total'],2);
        $this->ATabla[18][valor]  =  '0';
        
        $this->ATabla[25][valor]  =  $anio;
        $this->ATabla[26][valor]  =  $mes;
        $this->ATabla[34][valor]  =  $id_emite_externo;
      
        $idprov                   = trim( $x_array['identificacion'] ) ;
 
        $x_ciu                    = $this->bd->query_array('par_ciu',   
        'id_par_ciu',                        // CAMPOS
        'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true) // CONDICION
        );
  
       
       $this->ATabla[30][valor]  =  $x_ciu['id_par_ciu'];
        
  
        if ( trim($titulo_rubro) == 'URBANO'){

            $this->ATabla[31][valor]  =  23;
  
            $id_movimiento =  $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
        
            if (  $id_movimiento  > 0 ){
                      $this->_detalle_emision($id_movimiento,$x_array,$id_emite_externo);
                      $bandera = 1;
             }
        }
 
        if ( trim($titulo_rubro) == 'RURAL'){

            $this->ATabla[31][valor]  =  25;
  
            $id_movimiento =  $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
        
            if (  $id_movimiento  > 0 ){
                      $this->_detalle_emision_rural($id_movimiento,$x_array,$id_emite_externo);
                      $bandera = 1;
             }
        }

       ///------------------------------------------------------------------------
       ///------------------------------------------------------------------------
       
      
        
         unset($x_array);
         unset($x_total);

          
    }
//------------
public function verifica_cius(  ){ 
 
    ini_set("max_execution_time", "-1");
    ini_set("memory_limit", "-1");
    ignore_user_abort(true);
    set_time_limit(0);


    $sql = "SELECT *
                  FROM enlace_recaudacion.vista_contribuyentes 
                order by id_ciudadano";

        $resultado = $this->bd_cat->ejecutar($sql);

        $i = 1;

        while ($x=$this->bd_cat->obtener_fila($resultado)){

            $idprov   = trim($x['numero_documento']);
            $nombres  = trim($x['nombres']);
  
            $x_ciu    = $this->bd->query_array('par_ciu',   
                        'id_par_ciu',                        
                        'idprov='.$this->bd->sqlvalue_inyeccion($idprov,true) 
            );
        
            if (  $x_ciu['id_par_ciu'] > 0 ){

                $mensaje = 'Existe';

            } else {
        
                $this->agregar_ciu( $idprov,$nombres  );
                $mensaje = 'registro ';
                $i ++;
            }

        }

echo $mensaje.' '. $i;
 

}
///------------------------------------------------------------------------    
 function agregar_ciu( $idprov,$nombres  ){
   
    
    $sesion 	 =  trim($_SESSION['email']);
    $hoy 	     =  date("Y-m-d"); 
    $ruc        =   trim($_SESSION['ruc_registro']);
     
    if ( trim($nombres) == 'NO'){

        $x_cat = $this->bd_cat->query_array('enlace_recaudacion.vista_contribuyentes',   
        '*',                        
        'numero_documento='.$this->bd->sqlvalue_inyeccion(  trim($idprov) ,true)  
       );

       $nombre  = trim( $x_cat['nombres'] );

    }else {

        $nombre  = trim( $nombres);
    }

    
    
    $tabla 	  	  = 'par_ciu';
    
  
    $nombre_1 = 'migra';
    $nombre_2 = 'migra';

    $tipo_cta   = '0';
    $cta_banco  = '0';
    $banco      = '0';

 

    $ATabla = array(
        array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $idprov,   filtro => 'N',   key => 'S'),
        array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => $nombre,   filtro => 'N',   key => 'N'),
        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
        array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => 'Sin Dato',   filtro => 'N',   key => 'N'),
        array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor => '022999999',   filtro => 'N',   key => 'N'),
        array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => 'info@siscat.gob.ec',   filtro => 'N',   key => 'N'),
        array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => '022999999',   filtro => 'N',   key => 'N'),
        array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '18',   filtro => 'N',   key => 'N'),
        array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => $nombre,   filtro => 'N',   key => 'N'),
        array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => '022999999',   filtro => 'N',   key => 'N'),
        array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'N',   edit => 'N',   valor => 'info@siscat.gob.ec',   filtro => 'N',   key => 'N'),
        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
        array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '02',   filtro => 'N',   key => 'N'),
        array( campo => 'modulo',   tipo => 'VARCHAR2',   id => '13',  add => 'S',   edit => 'N',   valor => 'C',   filtro => 'N',   key => 'N'),
        array( campo => 'naturaleza',   tipo => 'VARCHAR2',   id => '14',  add => 'N',   edit => 'N',   valor => 'NN',   filtro => 'N',   key => 'N'),
        array( campo => 'sesion',   tipo => 'VARCHAR2',   id => '15',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
        array( campo => 'creacion',   tipo => 'DATE',   id => '16',  add => 'S',   edit => 'N',   valor =>  $hoy ,   filtro => 'N',   key => 'N'),
        array( campo => 'modificacion',   tipo => 'DATE',   id => '17',  add => 'N',   edit => 'S',   valor => $hoy ,   filtro => 'N',   key => 'N'),
        array( campo => 'msesion',   tipo => 'VARCHAR2',   id => '18',  add => 'S',   edit => 'S',   valor => $sesion,   filtro => 'N',   key => 'N'),
        array( campo => 'serie',   tipo => 'VARCHAR2',   id => '19',  add => 'N',   edit => 'N',   valor => '000000',   filtro => 'N',   key => 'N'),
        array( campo => 'autorizacion',   tipo => 'VARCHAR2',   id => '20',  add => 'N',   edit => 'N',   valor => '00000',   filtro => 'N',   key => 'N'),
        array( campo => 'cmovil',   tipo => 'VARCHAR2',   id => '21',  add => 'N',   edit => 'N',   valor => '022999999',   filtro => 'N',   key => 'N'),
        array( campo => 'nombre',   tipo => 'VARCHAR2',   id => '22',  add => 'S',   edit => 'S',   valor => $nombre_1,   filtro => 'N',   key => 'N'),
        array( campo => 'apellido',   tipo => 'VARCHAR2',   id => '23',  add => 'S',   edit => 'S',   valor => $nombre_2,   filtro => 'N',   key => 'N'),
        array( campo => 'registro',   tipo => 'VARCHAR2',   id => '24',  add => 'S',   edit => 'N',   valor => $ruc ,   filtro => 'N',   key => 'N'),
        array( campo => 'grafico',   tipo => 'VARCHAR2',   id => '25',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'N'),
        array( campo => 'id_banco',   tipo => 'NUMBER',   id => '26',  add => 'S',   edit => 'S',   valor => '23',   filtro => 'N',   key => 'N'),
        array( campo => 'tipo_cta',   tipo => 'VARCHAR2',   id => '27',  add => 'S',   edit => 'S',   valor =>$tipo_cta,   filtro => 'N',   key => 'N'),
        array( campo => 'cta_banco',   tipo => 'VARCHAR2',   id => '28',  add => 'S',   edit => 'S',   valor => $cta_banco,   filtro => 'N',   key => 'N'),
        array( campo => 'vivienda',   tipo => 'NUMBER',   id => '29',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'salud',   tipo => 'NUMBER',   id => '30',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'educacion',   tipo => 'NUMBER',   id => '31',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'alimentacion',   tipo => 'NUMBER',   id => '32',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'vestimenta',   tipo => 'NUMBER',   id => '33',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'sifondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
        array( campo => 'programa',   tipo => 'VARCHAR2',   id => '35',  add => 'S',   edit => 'S',   valor => '121',   filtro => 'N',   key => 'N') ,
        array( campo => 'fondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N') ,
        array( campo => 'turismo',   tipo => 'NUMBER',   id => '35',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
        array( campo => 'banco',   tipo => 'VARCHAR2',   id => '36',  add => 'S',   edit => 'S',   valor => $banco,   filtro => 'N',   key => 'N')
    );
   
    $this->bd->pideSq(0);
    
    $this->bd->_InsertSQL($tabla,$ATabla,$idprov);

    $numero = $this->bd->ultima_secuencia( 'par_ciu_id_par_ciu_seq') ;

    return $numero;
    
}	
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------




 
//------ grud de datos insercion
if (isset($_GET["titulo"]))	{
  
    $gestion   = 	new proceso( );
    
    $variable = trim($_GET["titulo"]);


    if (  $variable == 'CIU'){
        $gestion->verifica_cius( );
    }else{
        $gestion->Emision_titulos(  $_GET );
    }

 
    



    
}




?>
 
  