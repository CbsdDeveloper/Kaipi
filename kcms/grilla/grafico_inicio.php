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
        
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_gasto_fuente1($currentYear){
        
        $rows= array();
        
        $sql = "SELECT   grupo,  sum(codificado) as total
                FROM presupuesto.view_grupo_gasto
                where anio =  ".$this->bd->sqlvalue_inyeccion($currentYear,true)." and fuente = '001'
                group by grupo";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Grupo';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //-----------------
    function _barra_unidad_resumen( ){
        
        
        $sql = "SELECT unidad,SUM(costo_adquisicion) as total, count(*) as numero
                FROM activo.view_bienes
                where tipo_bien = 'BLD' and uso <> 'baja' and unidad is not null
                group by unidad";
                        
        $resultado  = $this->bd->ejecutar($sql);
        
        $category = array();
        $series1  = array();
    
        
        $category['name'] ='Unidad';
        $series1['name'] ='Nro.Bienes';
  
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = trim($r['unidad']);
            
            $category['data'][] = $items;
            $series1['data'][] =  $r['numero'];
        
         
            
            
        }
        
        $result = array();
        
        array_push($result,$category);
        array_push($result,$series1);
     
      
        
        print json_encode($result, JSON_NUMERIC_CHECK);
        
        
        
    }
    //---------------------------------------------------------------
    function _barra_gasto_fuente2($currentYear){
        
        
        $sql = " SELECT   grupo,  sum(inicial) as inicial,
                            sum(codificado) as codificado,
                            sum(certificado) as certificado ,
                            sum(compromiso) as compromiso,
                            sum(devengado) as devengado
        FROM presupuesto.view_grupo_gasto
        where anio = ".$this->bd->sqlvalue_inyeccion($currentYear,true)."  and
              fuente = '002'
        group by grupo";
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $category = array();
        $series1  = array();
        $series2  = array();
        $series3  = array();
        $series4  = array();
        $series5  = array();
        
        $category['name'] ='Grupo';
        $series1['name'] ='Inicial';
        $series2['name'] ='Codificado';
        $series3['name'] ='Certificado';
        $series4['name'] ='Compromiso';
        $series5['name'] ='Devengado';
        
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $category['data'][] = $items;
            $series1['data'][] =  $r['inicial'];
            $series2['data'][] =  $r['codificado'];
            $series3['data'][] =  $r['certificado'];
            $series4['data'][] =  $r['compromiso'];
            $series5['data'][] =  $r['devengado'];
            
            
        }
        
        $result = array();
        
        array_push($result,$category);
        array_push($result,$series1);
        array_push($result,$series2);
        array_push($result,$series3);
        array_push($result,$series4);
        array_push($result,$series5);
        
        print json_encode($result, JSON_NUMERIC_CHECK);
        
        
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_gasto_fuente2($currentYear){
        
        $rows= array();
        
        
        $sql = "SELECT   grupo,  sum(codificado) as total
                FROM presupuesto.view_grupo_gasto
                where anio =  ".$this->bd->sqlvalue_inyeccion($currentYear,true)." and fuente = '002'
                group by grupo";
        
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Grupo';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_ingreso_fuente1($currentYear){
        
        $rows= array();
        
        $sql = "SELECT   grupo,  sum(codificado) as total
                FROM presupuesto.view_grupo_ingreso
                where anio =  ".$this->bd->sqlvalue_inyeccion($currentYear,true)." and fuente = '001'
                group by grupo";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Grupo';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //-------
    function _pie_ingreso_fuente2($currentYear){
        
        $rows= array();
        
        $sql = "SELECT   grupo,  sum(codificado) as total
                FROM presupuesto.view_grupo_ingreso
                where anio =  ".$this->bd->sqlvalue_inyeccion($currentYear,true)." and fuente = '002'
                group by grupo";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Grupo';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            //     $items = (string)$r['grupo'] .'  ';
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _catalogo($codigo){
        
        $AResultado = $this->bd->query_array('presupuesto.pre_catalogo',
            'codigo, detalle', 'codigo='.$this->bd->sqlvalue_inyeccion($codigo,true));
        
        
        $dato = trim($AResultado['codigo']).' '.trim($AResultado['detalle']);
        
        return     $dato;
        
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _linea_mensual($currentYear){
        
        
        $cabecera = "CASE WHEN  mes='1' THEN 'Enero' WHEN
                                mes='2' THEN 'Febrero' WHEN
                                mes='3' THEN 'Marzo' WHEN
                                mes='4' THEN 'Abril' WHEN
                                mes='5' THEN 'Mayo' WHEN
                                mes='6' THEN 'Junio' WHEN
                                mes='7' THEN 'Julio' WHEN
                                mes='8' THEN 'Agosto' WHEN
                                mes='9' THEN 'Septiembre' WHEN
                                mes='10' THEN 'Octubre' WHEN
                                mes='11' THEN 'Noviembre' ELSE 'Diciembre' END ";
        
        $sql = "SELECT ".$cabecera." as mes ,
                        cantidad,
                        media,
                        total,
                        minimo,
                        maximo
			  FROM view_res_inv_mes
			  WHERE tipo = 'F' AND
					anio = ". $this->bd->sqlvalue_inyeccion($currentYear,true);
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        
        $category = array();
        $series1 = array();
        $series2 = array();
        $series3 = array();
        
        $category['name'] ='Mes';
        $series1['name'] ='Cantidad';
        $series2['name'] ='Media';
        $series3['name'] ='Total';
        
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $category['data'][] = $r['mes'];
            $series1['data'][] =  $r['cantidad'];
            $series2['data'][] =  $r['media'];
            $series3['data'][] =  $r['total'];
            
            
        }
        
        $result = array();
        
        array_push($result,$category);
        array_push($result,$series1);
        array_push($result,$series2);
        array_push($result,$series3);
        
        
        print json_encode($result, JSON_NUMERIC_CHECK);
        
        
    }
    
    //---
    
    //-----------------------------------------------
}
//-------------------------

$gestion         = 	new proceso;




//------ poner informacion en los campos del sistema
$tipo = 0 ;
if (isset($_GET['tipo']))	{
    $tipo    = $_GET['tipo'];
}

 

if ($tipo == 1) {
    $gestion->_barra_unidad_resumen();
}

 


?>
 
  