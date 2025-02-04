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
    function _pie_caja_venta($currentYear){
        
        
        
        $sql = 'SELECT completo  ,
                       (sum(baseImponible)  + sum(baseImpGrav) +  sum(montoIva)) as total
            FROM view_inv_venta
            where anio= '.$currentYear."  and 
                  registro  = ". $this->bd->sqlvalue_inyeccion( $this->ruc ,true).'   
            group by completo';
        
     
 
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Cajero';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
         //   $items = (string)$r[0].'  ';    // $items === "5";
             
            $items = $r['completo'] ; 
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _pie_producto_venta($currentYear){
        

        
        $sql = "SELECT  producto,
                          total
			  FROM view_res_inv_pro_mes
			  WHERE tipo = 'F' AND
					anio = ". $this->bd->sqlvalue_inyeccion($currentYear,true)." and
                    registro  = ". $this->bd->sqlvalue_inyeccion( $this->ruc ,true)."  
			ORDER BY 2 desc limit 10 offset 0";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Producto';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $r['producto'] ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
    //---------------------------------------------
    function _pie_cliente($currentYear){
        
        
        
        $sql = "SELECT  razon,
                         total
 			  FROM view_res_inv_prv
			  WHERE tipo = 'F' AND
					anio = ". $this->bd->sqlvalue_inyeccion($currentYear,true)." and
                    registro  = ". $this->bd->sqlvalue_inyeccion( $this->ruc ,true)."  
			ORDER BY 2 desc limit 10 offset 0 ";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        //---------------------------------------------- linea
        
        //$rows = array();
        $rows['type']   = 'pie';
        $rows['name'] = 'Cliente';
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $r['razon'] ;
            
            $rows['data'][] = array($items, $r['total']);
            
        }
        
        $rslt = array();
        array_push($rslt,$rows);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
    }
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
                    registro  = ". $this->bd->sqlvalue_inyeccion( $this->ruc ,true)." and 
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
    
    $tipo         = $_GET['tipo'];
    
    $currentYear  = $_GET['anio'];
    
    
}

if ($tipo == 1) {
    $gestion->_pie_caja_venta($currentYear);
}

if ($tipo ==2 ) {
    $gestion->_pie_producto_venta($currentYear);
}

if ($tipo == 3 ) {
    $gestion->_linea_mensual($currentYear);
}

if ($tipo == 4 ) {
    $gestion->_pie_cliente($currentYear);
}
 

?>
 
  