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
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function grafico(){
        
        $anio = date ("Y");
        
        
        
        $sql = " SELECT  mes,
             	   sum(basenograiva) + sum(baseimponible) as  base0,
             	   sum(baseimpgrav) as baseiva,
             	   sum( montoiva) as iva,
             	   sum(valorretrenta) as retencionfuente ,
             	   sum(valorretbienes) +  sum(valorretservicios) as retencioniva
            FROM view_anexos_ventas
            where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                  registro =". $this->bd->sqlvalue_inyeccion( $this->ruc ,true)."
            group by mes order by mes";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $bln = array();
        
        $bln['name'] = 'Mes';
        $rows['name'] = 'Base Tarifa 0';
        $rows1['name'] = 'Base Imponible';
        $rows2['name'] = 'Monto Iva';
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $Mes = $this->bd->_mes( $r['mes'] );
            $bln['data'][]  = $Mes;
            
            $rows['data'][] = (int) $r['base0'];
            $rows1['data'][] = (int) $r['baseiva'];
            $rows2['data'][] = (int) $r['iva'];
            
        }
        
        
        $rslt = array();
        array_push($rslt, $bln);
        array_push($rslt, $rows);
        array_push($rslt, $rows1);
        array_push($rslt, $rows2);
        print json_encode($rslt, JSON_NUMERIC_CHECK);
        
        
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

$gestion->grafico();



?>
 
  