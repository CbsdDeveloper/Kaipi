<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
     
    private $obj;
    private $bd;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $anio;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd     = 	new Db;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['login'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
       
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------
    function historial($anio,$tipo,$mes,$cuenta_depre){
          
        $f2        = $anio .'-12-30';
         
        $ruc       =  trim($_SESSION['ruc_registro']);
        $sesion    =  trim($_SESSION['email']);
        
        $periodo_s = $this->bd->query_array('co_periodo',
            'id_periodo',
            'registro ='.$this->bd->sqlvalue_inyeccion($ruc ,true).' and
                                         anio ='.$this->bd->sqlvalue_inyeccion($anio ,true).' and
                                         mes='.$this->bd->sqlvalue_inyeccion($mes ,true)
            );
        
        $id_periodo = $periodo_s['id_periodo'];
        
        
       $lon = strlen($cuenta_depre);
        
        
       if ( $lon > 5 ){
       
        $id_asiento = $this->nuevo($anio,$periodo_s,$f2,$ruc,$sesion );
        
        if ( $tipo== 'A'){
            
            $sql = "SELECT  cuenta, nombre_cuenta,
                       clasificador, count(*) as bienes,   sum(costo) compra,
                       sum(vresidual) as residual,  sum(cuotadp) as cdp
                    FROM activo.view_bienes_depre
                    where anio_actual  = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                          tipo_depre = 'A'
                    group by cuenta, nombre_cuenta, clasificador
                    order by cuenta";
        }else{
            
            
            $sql = "SELECT  cuenta, nombre_cuenta,
                       clasificador, count(*) as bienes,   sum(costo) compra,
                       sum(vresidual) as residual,  sum(cuotadp) as cdp
                    FROM activo.view_bienes_depre
                    where anio_actual  = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                          tipo_depre = 'M' and
                          mes =".$this->bd->sqlvalue_inyeccion($mes,true)."
                    group by cuenta, nombre_cuenta, clasificador
                    order by cuenta";
            
        }
                    
        
        $resultado    =  $this->bd->ejecutar($sql);
      
       
        while($row=pg_fetch_assoc ($resultado)) {
            
            $partida  = '-';
            $item     = '-';
            $programa = '-';
            
            //---141.99.08 D
            $cuenta_datos = explode('.',$row['cuenta']);
            $parte1       = $cuenta_datos[0];
            $parte2       = $cuenta_datos[2];
            
            $cuenta1 =   $parte1.'.99.'.$parte2;
            
            $xa     = $cuenta_depre;
            
            
            
            
            $debe  = $row['cdp'];
            $haber = '0.00';
            $hoy 	          =   $this->bd->hoy();
  
            $sql = "INSERT INTO co_asientod(
        								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
        								sesion, creacion, principal,partida,item,programa,registro)
        								VALUES (".
        								$this->bd->sqlvalue_inyeccion($id_asiento , true).",".
        								$this->bd->sqlvalue_inyeccion( ltrim(rtrim($xa)), true).",".
        								$this->bd->sqlvalue_inyeccion( 'N', true).",".
        								$this->bd->sqlvalue_inyeccion($debe, true).",".
        								$this->bd->sqlvalue_inyeccion($haber, true).",".
        								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
        								$this->bd->sqlvalue_inyeccion( $anio, true).",".
        								$this->bd->sqlvalue_inyeccion( $mes, true).",".
        								$this->bd->sqlvalue_inyeccion($sesion , true).",".
        								$hoy.",".
        								$this->bd->sqlvalue_inyeccion( 'N', true).",".
        								$this->bd->sqlvalue_inyeccion( $partida, true).",".
        								$this->bd->sqlvalue_inyeccion( $item, true).",".
        								$this->bd->sqlvalue_inyeccion( $programa, true).",".
        								$this->bd->sqlvalue_inyeccion( $ruc, true).")";
        								
        								$this->bd->ejecutar($sql);
            
         $debe  = '0.00';
         $haber = $row['cdp'];
         
         $sql = "INSERT INTO co_asientod(
        								id_asiento, cuenta, aux,debe, haber, id_periodo, anio, mes,
        								sesion, creacion, principal,partida,item,programa,registro)
        								VALUES (".
        								$this->bd->sqlvalue_inyeccion($id_asiento , true).",".
        								$this->bd->sqlvalue_inyeccion( $cuenta1, true).",".
        								$this->bd->sqlvalue_inyeccion( 'N', true).",".
        								$this->bd->sqlvalue_inyeccion($debe, true).",".
        								$this->bd->sqlvalue_inyeccion($haber, true).",".
        								$this->bd->sqlvalue_inyeccion( $id_periodo, true).",".
        								$this->bd->sqlvalue_inyeccion( $anio, true).",".
        								$this->bd->sqlvalue_inyeccion( $mes, true).",".
        								$this->bd->sqlvalue_inyeccion($sesion , true).",".
        								$hoy.",".
        								$this->bd->sqlvalue_inyeccion( 'N', true).",".
        								$this->bd->sqlvalue_inyeccion( $partida, true).",".
        								$this->bd->sqlvalue_inyeccion( $item, true).",".
        								$this->bd->sqlvalue_inyeccion( $programa, true).",".
        								$this->bd->sqlvalue_inyeccion( $ruc, true).")";
        								
        								$this->bd->ejecutar($sql);
         
        }
 
        echo '<b>Asiento Generado... '.$id_asiento.'</b>';
        
       }else {
           echo '<b>No existe cuenta ... Seleccione nuevamente'.'</b>';
       }
       
    }
 //-------------------------
    function nuevo($id,$periodo_s,$f2,$ruc,$sesion ){
        
          
        $total_apagar     =  '0';
        
        $estado           =  'digitado';
        $fecha		      =   $this->bd->fecha($f2);
        $hoy 	          =   $this->bd->hoy();
        $cuenta           = '-';
        
       
        $mes           = '12';
        $anio          = $id;
        
        $id_asiento_ref = 0;
        $secuencial     = '000-'.$anio;
        $cuenta         ='-';
        $idmovimiento = '1';
        
        $detalle = 'Registro de Depreciacion - Modulo Actios Fijos'.
            ' correspondientes al periodo  ('.$id.'). usuario: '.$sesion;
        
        //------------ seleccion de periodo
        
        
        $id_periodo = $periodo_s['id_periodo'];
        
        
        //------------------------------------------------------------
        $sql = "INSERT INTO co_asiento(	fecha, registro, anio, mes, detalle, sesion, creacion,modulo,
                					comprobante, estado, tipo, documento,idprov,cuentag,
                                    estado_pago,apagar, idmovimiento,
                                    id_asiento_ref,id_periodo)
										        VALUES (".$fecha.",".
										        $this->bd->sqlvalue_inyeccion($ruc, true).",".
										        $this->bd->sqlvalue_inyeccion($anio, true).",".
										        $this->bd->sqlvalue_inyeccion($mes, true).",".
										        $this->bd->sqlvalue_inyeccion( $detalle, true).",".
										        $this->bd->sqlvalue_inyeccion($sesion, true).",".
										        $hoy.",".
										        $this->bd->sqlvalue_inyeccion('contabilidad', true).",".
										        $this->bd->sqlvalue_inyeccion('-', true).",".
										        $this->bd->sqlvalue_inyeccion($estado, true).",".
										        $this->bd->sqlvalue_inyeccion('I', true).",".
										        $this->bd->sqlvalue_inyeccion(trim($secuencial), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($ruc), true).",".
										        $this->bd->sqlvalue_inyeccion(trim($cuenta), true).",".
										        $this->bd->sqlvalue_inyeccion( 'S', true).",".
										        $this->bd->sqlvalue_inyeccion( $total_apagar, true).",".
										        $this->bd->sqlvalue_inyeccion( $idmovimiento, true).",".
										        $this->bd->sqlvalue_inyeccion( $id_asiento_ref, true).",".
										        $this->bd->sqlvalue_inyeccion($id_periodo, true).")";
										        
										        $this->bd->ejecutar($sql);
										        
										        $idAsiento =  $this->bd->ultima_secuencia('co_asiento');
 										        
										        return $idAsiento;
										        
    }
    
}
//-------------------------

$gestion         = 	new proceso;


if (isset($_GET['anio']))	{
    
    $anio    = $_GET['anio'];
    $tipo    = $_GET['tipo'];
    $mes     = $_GET['mes'];
    $cuenta_depre = $_GET['cuenta_depre'];
    
    $gestion->historial($anio,$tipo,$mes,$cuenta_depre) ;
    
}


?>
 
 
