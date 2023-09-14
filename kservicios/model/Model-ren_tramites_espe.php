<?php
session_start();

require '../../kconfig/Db.class.php';  

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $ATabla_detalle;
    private $tabla ;
    private $secuencia;
    
    private $estado_periodo;
    private $anio;
    
    private $id;
    
    private $bd_cat;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;

        	
		$this->bd_cat	   =	 	new Db ;
        
        $this->ruc       =     trim($_SESSION['ruc_registro']);
        $this->sesion 	 =     trim($_SESSION['email']);
        $this->hoy 	     =     date("Y-m-d");     
        $this->anio      =     $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
          
        
       // $usuario = $this->bd->__user(  $this->sesion);

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
            array( campo => 'autorizacion',tipo => 'VARCHAR2',id => '17',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'id_tramite',tipo => 'NUMBER',id => '18',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '19',add => 'S', edit => 'N', valor =>$this->sesion, key => 'N'),
            array( campo => 'creacion',tipo => 'DATE',id => '20',add => 'S', edit => 'N', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesionm',tipo => 'VARCHAR2',id => '21',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
            array( campo => 'modificacion',tipo => 'DATE',id => '22',add => 'S', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesion_pago',tipo => 'VARCHAR2',id => '23',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'modulo',tipo => 'VARCHAR2',id => '24',add => 'S', edit => 'N', valor => 'especies', key => 'N'),
            array( campo => 'anio',tipo => 'VARCHAR2',id => '25',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'mes',tipo => 'VARCHAR2',id => '26',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'multa',tipo => 'NUMBER',id => '27',add => 'S', edit => 'N', valor => '0.00', key => 'N'),
            array( campo => 'fechap',tipo => 'DATE',id => '28',add => 'N', edit => 'S', valor =>$this->hoy, key => 'N'),
            array( campo => 'sesion_baja',tipo => 'VARCHAR2',id => '29',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_par_ciu',tipo => 'NUMBER',id => '30',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'id_rubro',tipo => 'NUMBER',id => '31',add => 'S', edit => 'N', valor => '-1', key => 'N'),
            array( campo => 'fecha_obligacion',tipo => 'DATE',id => '32',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'subtotal',tipo => 'NUMBER',id => '33',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'enlace',tipo => 'NUMBER',id => '34',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'direccion_alterna',tipo => 'VARCHAR2',id => '35',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'secuencial',tipo => 'VARCHAR2',id => '36',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'novedad',tipo => 'VARCHAR2',id => '37',add => 'S', edit => 'S', valor => '-', key => 'N')
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
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_resultado($accion,$id,$estado,$tipo){
        //inicializamos la clase para conectarnos a la bd
        
        

        
        if ($tipo == 0){
            
            echo '<script>accion('. $id. ','. "'".$accion."'," ."'".$estado."'" .')</script>';
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/kedit.png" align="absmiddle" />&nbsp;<b>EDITAR REGISTRO TRANSACCION ['.$id.']</b>';
           
           if ($accion == 'del')
                $resultado = '<img src="../../kimages/kdel.png" align="absmiddle" />&nbsp;<b>ELIMINAR REGISTRO TRANSACCION ['.$id.']</b>';
                    
        }
        
        if ($tipo == 1){
            
            echo '<script>accion('. $id. ','. "'".$accion."'," ."'".$estado."'" .')</script>';
            
            if ($accion == 'editar')
                $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>INFORMACION ACTUALIZADA CON EXITO ['.$id.']</b>';


           if ($accion == 'enviado')
                $resultado = '<img src="../../kimages/ksavee.png" align="absmiddle"/>&nbsp;<b>PROCESO GENERADO CON EXITO .... REGISTRO PAGADO ['.$id.']</b>';   
            
        }
        
        
        return $resultado;
        
    }
    
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function div_limpiar( ){
        //inicializamos la clase para conectarnos a la bd
        
        $resultado = '';
        
        echo '<script type="text/javascript">';
        
        echo  'LimpiarPantalla();';
        
        echo '</script>';
        
        return $resultado;
        
    }
    
    
    
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function consultaId($accion,$id ){
        
        
        $qquery = array(
            array( campo => 'id_ren_movimiento',   valor => $id,  filtro => 'S',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'comprobante',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cierre',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'apagar',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'carga',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'modulo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'mes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_par_ciu',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'correo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'direccion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'contribuyente',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
             array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'base',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S')
        );
       
        

        
      $this->bd->JqueryArrayVisor('rentas.view_ren_especies',$qquery );
        
  
       $result = $this->div_resultado('editar',$id,'',0);
        
        echo $result;
    }
    
    
    
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    
    function xcrud($action,$id){
        
           
        // ------------------  agregar
        if ($action == 'add'){
            
            $this->agregar();
            
        }
        // ------------------  editar
        if ($action == 'editar'){
            
            $this->edicion($id) ;
            
        }
        // ------------------  eliminar
        if ($action == 'del'){
            
           $this->eliminar();
            
        }
        
    }
    //--------------------------------------------------------------------------------
    //---retorna el valor del campo para impresion de pantalla ?articulo=' + articulo + '&id='+id_asiento,
    //--------------------------------------------------------------------------------
    function agregar( ){
        
        $idprov           = trim($_POST["idprov"]);
        $id_par_ciu       = $_POST["id_par_ciu"];
        
        //$documento        = trim($_POST["documento"]);
        
        $cantidad         = trim($_POST["cantidad"]);
        $costo            = trim($_POST["costo"]);
        $base             = trim($_POST["base"]);

         
        $todayh =  getdate();
        $m = $todayh[mon];
        $y = $todayh[year];
        
        $mes  =   $m  ;
        $anio =   $y ;


        if ( $id_par_ciu > 0 ){
            
        }else{

            $x = $this->bd->query_array('par_ciu',
                '*',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($idprov),true)
                );
            
            $this->ATabla[30][valor] =  $x['id_par_ciu'];
        }
        

        $this->ATabla[1][valor]  = $this->hoy 	;
        $this->ATabla[2][valor]  = $this->hoy 	;
        $this->ATabla[6][valor]  =  'E' ;

        $monto = '0.00';
        
        $this->ATabla[8][valor]   = $monto;
      
        $this->ATabla[10][valor]  =   $monto;
        $this->ATabla[11][valor]  =   $monto;
        $this->ATabla[12][valor]  =  $monto;
        $this->ATabla[13][valor]  =   $monto;

        $this->ATabla[9][valor]   =    $cantidad ;

         $this->ATabla[33][valor]  =  round(  $costo ,2);
         $this->ATabla[14][valor]  =  round($base ,2);
   
         $this->ATabla[33][valor]  =   round($base ,2);
         
 
       $this->ATabla[25][valor]  =  $anio;
       $this->ATabla[26][valor]  =  $mes;
       
     

       $id_ren_tramite         = $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
        
 

       $idproducto_ser             =  $_POST["id_rubro"];

       $this->ATabla_detalle[0][valor]  =    $idproducto_ser ;
        $this->ATabla_detalle[1][valor]  =  $id_ren_tramite;
       
       $this->ATabla_detalle[3][valor]   =   round(  $costo ,2);
       $this->ATabla_detalle[4][valor]   =   $monto;
       
       $this->ATabla_detalle[5][valor]  =    $monto;
       $this->ATabla_detalle[6][valor]   =   $monto;

       $this->ATabla_detalle[7][valor]  =    $monto;
       $this->ATabla_detalle[8][valor]  =    $monto;
       $this->ATabla_detalle[9][valor]  =    $monto;
       $this->ATabla_detalle[10][valor]  =   round($base ,2);
       
       $this->bd->_InsertSQL('rentas.ren_movimiento_det',$this->ATabla_detalle,'rentas.ren_movimiento_det_id_ren_movimientod_seq',0 );


        $result = $this->div_resultado('editar',$id_ren_tramite,'E',1);
        
         
        echo $result;
        
        
    }
//-------------------------------------------    
  
   //------------------------------
    function editar_ciu( ){
        
        $direccion              = $_POST["direccion"];
        $correo                 = $_POST["correo"];
        $id_par_ciu             = $_POST["id_par_ciu"];
 
        
        $UpdateQuery = array(
            array( campo => 'id_par_ciu',    valor => $id_par_ciu ,  filtro => 'S'),
            array( campo => 'direccion',      valor => trim($direccion) ,  filtro => 'N'),
            array( campo => 'correo',       valor => trim($correo),  filtro => 'N')  
        );
        
        
        $this->bd->JqueryUpdateSQL('par_ciu',$UpdateQuery);
        
        
}
    //--------------------------------------------------------------------------------
    //--- edicion de registros
    //--------------------------------------------------------------------------------
function edicion( $id_ren_tramite ){
 
    //$idprov           = trim($_POST["idprov"]);
    //$id_par_ciu       = $_POST["id_par_ciu"];
    //$documento        = trim($_POST["documento"]);
    
    $cantidad         = trim($_POST["cantidad"]);
    $costo            = trim($_POST["costo"]);
    $base             = trim($_POST["base"]);
        
    $todayh =  getdate();
    $m = $todayh[mon];
    $y = $todayh[year];
    
    $mes  =   $m  ;
    $anio =   $y ;

    $estado           = trim($_POST["estado"]);

      
        $this->ATabla[1][valor]  = $this->hoy 	;
        $this->ATabla[2][valor]  = $this->hoy 	;
        $this->ATabla[6][valor]  =  'E' ;

        $monto = '0.00';
        
        $this->ATabla[8][valor]   = $monto;
    
        $this->ATabla[10][valor]  =   $monto;
        $this->ATabla[11][valor]  =   $monto;
        $this->ATabla[12][valor]  =  $monto;
        $this->ATabla[13][valor]  =   $monto;

        $this->ATabla[9][valor]   =    $cantidad ;

        $this->ATabla[33][valor]  =  round(  $costo ,2);
        $this->ATabla[14][valor]  =  round($base ,2);

        $this->ATabla[33][valor]  =   round($base ,2);
        $this->ATabla[25][valor]  =  $anio;
        $this->ATabla[26][valor]  =  $mes;
        
        
        $this->bd->_UpdateSQL($this->tabla,$this->ATabla,$id_ren_tramite);
       
        $result = $this->div_resultado('editar',$id_ren_tramite,$estado,1);
        
        echo $result;
        
    }
    
    //--------------------------------------------------------------------------------
    //--- eliminar de registros
    //--------------------------------------------------------------------------------
    function eliminar($id ){
        
        
      
         
        $x = $this->bd->query_array('rentas.ren_movimiento',   // TABLA
            'estado,conta',                        // CAMPOS
            'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        $estado =  $x["estado"];
        
        if (trim($estado) == 'E') {
            
                $sql = 'delete from rentas.ren_movimiento
                         where id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id, true);
                
                $this->bd->ejecutar($sql);
 
 
        } 

        if (trim($estado) == 'P') {
            
            $sql = 'update rentas.ren_movimiento
            set estado = '.$this->bd->sqlvalue_inyeccion('B', true)."
            where conta = 'N' and  id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);
    
 
            $this->bd->ejecutar($sql);


    } 
 
        
    }
    function anula_cierra($id,$novedad){
        
        
 
         
        $x = $this->bd->query_array('rentas.ren_tramites',   // TABLA
            'estado',                        // CAMPOS
            'id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
            );
        
        $estado =  $x["estado"];
        
        if (trim($estado) == 'digitado') {
            
            echo ' ESTADO NO VALIDO';
 
 
        }else {
            

            $long = strlen($novedad);

            if (   $long  > 10 )  {
                    $sql = 'update rentas.ren_tramites
                            set estado = '.$this->bd->sqlvalue_inyeccion('cierre', true).',
                            detalle_cierre  = '.$this->bd->sqlvalue_inyeccion($novedad, true).',
                            fecha_cierre= '.$this->bd->sqlvalue_inyeccion( $this->hoy, true).'
                            where id_ren_tramite='.$this->bd->sqlvalue_inyeccion($id, true);
                    
                    
                    $this->bd->ejecutar($sql);
                    
                    
                    echo ' CIERRE/ANULACION DE TRANSACCION...'; 

             }else  {

                echo ' INGRESE LA NOVEDAD Y/O MOTIVO CIERRE ...'; 

            }
            
        }
    
 
        
    }
  
   
    //--------------------------------------------
    function envio($id,$idproducto_ser,$cantidad,$comprobante ){
 
         
            $variable = $cantidad - 1;

           // $variable1 = $cantidad  ;

            $suma    = $comprobante  +    $variable;

            // $compron =  $comprobante.'-'.   $suma ;

            $xxx = $this->bd->query_array('rentas.ren_movimiento',   // TABLA
                '*',                        // CAMPOS
                'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id,true) // CONDICION
                );

                $estado     = trim($xxx['estado']);


             if (  $estado  == 'P')   {
                    echo 'Ya emitido....';
            }
            else     {
                            
                                    if ( $cantidad  == '1'){

                                                    $sql = " UPDATE rentas.ren_movimiento
                                                    SET 	estado=".$this->bd->sqlvalue_inyeccion('P', true).",
                                                            fechap=".$this->bd->sqlvalue_inyeccion( $this->hoy , true)."
                                                WHERE id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);

                                                    $this->bd->ejecutar($sql);

                                                    $comprobante =  $comprobante  + 1;

                                                    $sql = "UPDATE  rentas.ren_serie_espe
                                                              set actual = ".$this->bd->sqlvalue_inyeccion($comprobante ,true) ."
                                                    where estado= 'S' and idproducto_ser = ".$this->bd->sqlvalue_inyeccion( $idproducto_ser ,true)  ;

                                                    $this->bd->ejecutar($sql);

                                    
                                    }else{

                                                $sql = " UPDATE rentas.ren_movimiento
                                                SET 	estado=".$this->bd->sqlvalue_inyeccion('P', true).", 
                                                        comprobante = ".$this->bd->sqlvalue_inyeccion(  $comprobante   ,true).",
                                                        secuencial = ".$this->bd->sqlvalue_inyeccion(  $suma   ,true).",
                                                        fechap=".$this->bd->sqlvalue_inyeccion( $this->hoy , true)."
                                                    WHERE id_ren_movimiento=".$this->bd->sqlvalue_inyeccion($id, true);

                                                $this->bd->ejecutar($sql);

                                                $comprobante    = $comprobante  +    $cantidad;

                                                $sql = "UPDATE  rentas.ren_serie_espe
                                                set actual   = ".$this->bd->sqlvalue_inyeccion($comprobante ,true) ."
                                            where estado= 'S' and idproducto_ser = ".$this->bd->sqlvalue_inyeccion( $idproducto_ser ,true)  ;

                                                $this->bd->ejecutar($sql);
                                    

                                    
                                    }

                                    if ( $idproducto_ser == 14 ){
                                    
                                        $this->externo_bomberos($id);

                                    }    

                                        $result = $this->div_resultado('enviado',$id,'P',1).'...SECUENCIA '.$comprobante;
                }    
        
        echo $result;
        
        
    }

    //-------------------------
function externo_bomberos($id_emite_externo){

    $x = $this->bd->query_array('rentas.ren_movimiento',   // TABLA
    '*',                        // CAMPOS
    'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion($id_emite_externo,true) // CONDICION
    );


    $codigo_per     = trim($x['autorizacion']);
    $permiso_numero = trim($x['secuencial']);



	$servidor ='192.168.1.3';
	$base_datos = 'db_cbsd';
	$usuario = 'postgres';
	$password = 'Cbsd2019';

	 
	
	$this->bd_cat->conectar_sesion_externo($servidor, $base_datos, $usuario, $password) ;

 

    $zz = $this->bd_cat->query_array('permisos.vw_autoinspecciones',   // TABLA
    '*',                        // CAMPOS
    'autoinspeccion_codigo='.$this->bd_cat->sqlvalue_inyeccion(   $codigo_per ,true) // CONDICION
    );


    $fk_autoinspeccion_id  =  $zz['autoinspeccion_id'];

    if ( empty( $permiso_numero)){
        $permiso_numero   = $fk_autoinspeccion_id.'-I';
        $numero_solicitud = $fk_autoinspeccion_id.'-E';
    }else{
        $numero_solicitud = $permiso_numero.'-E';
    }
  

 
    $exi = $this->bd_cat->query_array('permisos.tb_permisos',   // TABLA
    'count(*) ya_existe',                        // CAMPOS
    'codigo_per='.$this->bd_cat->sqlvalue_inyeccion(   $codigo_per ,true) // CONDICION
    );



        if ( $exi['ya_existe'] > 0 ) {
            echo 'PERMISO YA ACTUALIZADO.....';

        }else {

            $hoy 	         =   date("Y-m-d");  
            $tiempo          =   date("H:i:s");
            $fecha_hoy 	     =   date("Y-m-d H:i:s");  

            $sql = "INSERT INTO permisos.tb_permisos(	permiso_estado,    fk_usuario_id, fk_autoinspeccion_id, numero_solicitud, 
            codigo_per,   permiso_valor, persona_responsable, persona_retira, observacion, permiso_numero)
                    VALUES (". 
                    $this->bd_cat->sqlvalue_inyeccion('IMPRESO', true).",".
                     $this->bd_cat->sqlvalue_inyeccion(68, true).",".
                    $this->bd_cat->sqlvalue_inyeccion( $fk_autoinspeccion_id, true).",".
                    $this->bd_cat->sqlvalue_inyeccion($numero_solicitud, true).",".
                    $this->bd_cat->sqlvalue_inyeccion($codigo_per, true).",".
                      $this->bd_cat->sqlvalue_inyeccion( 3 , true).",".
                    $this->bd_cat->sqlvalue_inyeccion('PROPIETARIO', true).",".
                    $this->bd_cat->sqlvalue_inyeccion('PROPIETARIO', true).",".
                    $this->bd_cat->sqlvalue_inyeccion('ENLACE PLATAFORMA', true).",".
                    $this->bd_cat->sqlvalue_inyeccion($permiso_numero, true).")";

                    $this->bd_cat->ejecutar($sql);  
	
                    $permiso_id =  $this->bd->ultima_secuencia('permisos.tb_permisos_permiso_id_seq');


                  echo 'PERMISO ACTUALIZADO.....';

        }
 
 




}	 
 
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

        //------ poner informacion en los campos del sistema
    if (isset($_GET['accion']))	{
            
            $accion    = $_GET['accion'];
            
            $id        = $_GET['id'];
          
           
            
            if ( $accion == 'permiso'){
                
                $gestion->externo_bomberos($id);
                
            }elseif ( $accion == 'envio'){
                
                $idproducto_ser        = $_GET['idproducto_ser'];

                $cantidad              = $_GET['cantidad'];
                
                $comprobante           = $_GET['comprobante'];

                $gestion->envio($id,$idproducto_ser, $cantidad,$comprobante );
                
            }elseif ( $accion == 'del'){
                
                $gestion->eliminar($id);
                
           
            }elseif ( $accion == 'anula'){
                    
                $novedad        = trim($_GET['novedad']);
                
                $gestion->anula_cierra($id,$novedad);
                
            }
              else{
                 
                 $gestion->consultaId($accion,$id);
                 
            }
           
                
            
        }
        
        //------ grud de datos insercion
        if (isset($_POST["action"]))	{
            
            $action 	    = $_POST["action"];
            
            $id 			= $_POST["id_ren_movimiento"];
            
            $gestion->xcrud(trim($action),$id );
            
        }



?>
 
  