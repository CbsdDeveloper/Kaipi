<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php';  

  
class proceso{
    
     
    private $obj;
    private $bd;

    private $bd_externo;
     
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

        $this->bd_externo	    =	new Db ;
         
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    
        $servidor ='192.168.1.3';
        $base_datos = 'db_cbsd';
        $usuario = 'postgres';
        $password = 'Cbsd2019';

        $this->bd_externo->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

        
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
    
 
    //------------------------------------------------------
    //------------------------------------------------------
    public function Emision_titulos(   $GET    ){
        

        


        $x_tramite = $this->bd_externo->query_array('permisos.vw_autoinspecciones',   // TABLA
            '*',                        // CAMPOS
            'autoinspeccion_id='.$this->bd_externo->sqlvalue_inyeccion($GET['id'],true) // CONDICION
            );
        

          $idprov =  trim($x_tramite["entidad_ruc"]);

          $id_par_ciu =  $this->buscarCius( $idprov,  $x_tramite  );
         
          $xxx =   $this->bd->query_array('par_ciu',   // TABLA
         '*',                        // CAMPOS
         'id_par_ciu='.  $this->bd->sqlvalue_inyeccion($id_par_ciu,true) // CONDICION
         );

   


         $pro_direccion   =  trim($x_tramite["local_principal"]).' '. 
                             trim($x_tramite["local_secundaria"]).' '. trim($x_tramite["local_referencia"]);


         echo json_encode( array(
             "a"=>trim($xxx['id_par_ciu']), 
            "b"=> trim($x_tramite['local_nombrecomercial']), 
            "c"=> trim($x_tramite['autoinspeccion_codigo']),
            "d"=> trim($xxx['idprov']),
            "e"=> trim($xxx['razon']),
            "f"=> trim($xxx['direccion']),
            "g"=> trim($xxx['correo']),
            "h"=> trim($pro_direccion) 
 )  
);



 
 
 
 
       
    }
//-------------------------------------------------------------  
    public function buscarCius( $idprov, $row  ){
        

            $x =   $this->bd->query_array('par_ciu',   // TABLA
            'id_par_ciu',                        // CAMPOS
            'idprov='.  $this->bd->sqlvalue_inyeccion($idprov,true) // CONDICION
            );
    

        
        
            if (  $x['id_par_ciu']  >  0 ){
                
                return $x['id_par_ciu'] ;
        
            }else {
                
               $id_par_ciu =  $this->agregar($idprov,$row );
            
               return  $id_par_ciu ;
            
            }
                 
    }
 
    /*
    */
    public function agregar( $idprov, $fila  ){
        


        $sesion 	 =  trim($_SESSION['email']);
        $hoy 	     =  date("Y-m-d"); 
        $ruc        =   trim($_SESSION['ruc_registro']);
        
        
        $nombre   =  trim($fila["entidad_razonsocial"]);
        $id       =  trim($idprov);
        
        
 
         
      //  $str = "TOAPANTA YANCHA BLANCA SUSANA";
            $nombre_1  =  'p1';
            $nombre_2  =  'p2';

 
     
        $ccorreo  =  trim($fila["representantelegal_email"]);
        $telefono =  trim($fila["local_telefono"]);
           
        $pro_direccion   = substr(trim($fila["local_principal"]).' '. 
                                  trim($fila["local_secundaria"]).' '. 
                                  trim($fila["local_referencia"]),0,150);
        
        $contacto   =  trim($fila["representantelegal_nombre"]);
         
     
        $le1 = strlen( $ccorreo );
        $le2 = strlen( $telefono);
        $le3 = strlen( $pro_direccion);
    
        if (  $le1 <  5) {
            $ccorreo = 'info@santodomingo.gob.ec';
    
        }	
    
        if (  $le2 <  5) {
            $telefono = '09999999999' ;
            
        }	
        
        if (  $le3 <  5) {
            $pro_direccion = 'Santo Domingo' ;
            
        }	
    
        $tipo_cta  = trim('2');
        $cta_banco = trim('0');
        $banco= trim('0000');
        
        $tabla 	  	  = 'par_ciu';
         
     
         
        $ATabla = array(
            array( campo => 'idprov',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'N',   valor => $idprov,   filtro => 'N',   key => 'S'),
            array( campo => 'razon',   tipo => 'VARCHAR2',   id => '1',  add => 'S',   edit => 'S',   valor => $nombre,   filtro => 'N',   key => 'N'),
            array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '2',  add => 'N',   edit => 'N',   valor => 'N',   filtro => 'N',   key => 'N'),
            array( campo => 'direccion',   tipo => 'VARCHAR2',   id => '3',  add => 'S',   edit => 'S',   valor => $pro_direccion,   filtro => 'N',   key => 'N'),
            array( campo => 'telefono',   tipo => 'VARCHAR2',   id => '4',  add => 'S',   edit => 'S',   valor =>$telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'correo',   tipo => 'VARCHAR2',   id => '5',  add => 'S',   edit => 'S',   valor => $ccorreo,   filtro => 'N',   key => 'N'),
            array( campo => 'movil',   tipo => 'VARCHAR2',   id => '6',  add => 'S',   edit => 'S',   valor => $telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'idciudad',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => '18',   filtro => 'N',   key => 'N'),
            array( campo => 'contacto',   tipo => 'VARCHAR2',   id => '8',  add => 'N',   edit => 'N',   valor => $contacto,   filtro => 'N',   key => 'N'),
            array( campo => 'ctelefono',   tipo => 'VARCHAR2',   id => '9',  add => 'N',   edit => 'N',   valor => $telefono,   filtro => 'N',   key => 'N'),
            array( campo => 'ccorreo',   tipo => 'VARCHAR2',   id => '10',  add => 'N',   edit => 'N',   valor => $ccorreo,   filtro => 'N',   key => 'N'),
            array( campo => 'estado',   tipo => 'VARCHAR2',   id => '11',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
            array( campo => 'tpidprov',   tipo => 'VARCHAR2',   id => '12',  add => 'S',   edit => 'S',   valor => '01',   filtro => 'N',   key => 'N'),
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
            array( campo => 'salud',   tipo => 'NUMBER',   id => '30',  add => 'S',   edit => 'S',   valor =>   $salud,   filtro => 'N',   key => 'N'),
            array( campo => 'educacion',   tipo => 'NUMBER',   id => '31',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
            array( campo => 'alimentacion',   tipo => 'NUMBER',   id => '32',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
            array( campo => 'vestimenta',   tipo => 'NUMBER',   id => '33',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
            array( campo => 'sifondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => '-',   filtro => 'N',   key => 'N') ,
            array( campo => 'programa',   tipo => 'VARCHAR2',   id => '35',  add => 'S',   edit => 'S',   valor => '121',   filtro => 'N',   key => 'N') ,
            array( campo => 'fondo',   tipo => 'VARCHAR2',   id => '34',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N') ,
            array( campo => 'turismo',   tipo => 'NUMBER',   id => '35',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
            array( campo => 'banco',   tipo => 'VARCHAR2',   id => '36',  add => 'S',   edit => 'S',   valor => $banco,   filtro => 'N',   key => 'N')
        );
        
      
        
        
        $this->bd->_InsertSQL($tabla,$ATabla,$id );
      

        $xxx = $this->bd->query_array('par_ciu',
        '*',
        'idprov='.$this->bd->sqlvalue_inyeccion(trim($id),true)
        );
    
    
      return $xxx['id_par_ciu'];


             
}
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------



 
//------ grud de datos insercion
if (isset($_GET["id"]))	{
  
    $gestion   = 	new proceso( );
    
    $gestion->Emision_titulos(  $_GET );
    

    
}




?>
 
  