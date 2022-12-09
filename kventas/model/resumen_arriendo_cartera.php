<?php
session_start( );

require '../../kconfig/Db.class.php';


require '../../kconfig/Obj.conf.php';


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
        
        
        $this->obj     = 	new objects;
        
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function BusquedaGrilla($ftipo,$ffinalizado){
        
        
        echo '<table id ="tabla2" class="table table-striped table-bordered table-hover table-checkable" width="100%" style="font-size: 12px;table-layout: auto">';
        echo '  <tr>
                  <td width="5%">Codigo</td>
                  <td width="10%">Identificacion</td>
                  <td width="30%">Arrendatario</td>
                  <td width="15%">Tipo</td>
                  <td width="10%">Contrato</td>
                  <td width="10%">Fecha Inicio</td>
                  <td width="5%">Facturas</td>
                  <td width="5%">Emitido</td>
                  <td width="5%">Pagado</td>
                  <td width="5%">Saldo</td>
                </tr>';
        
        
        $qquery = array(
            array( campo => 'idren_local',   valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'idprov',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo',valor => $ftipo,filtro => 'S', visor => 'S'),
            array( campo => 'contrato',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha_fin',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'novedad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'numero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'finalizado',valor => $ffinalizado,filtro => 'S', visor => 'S'),
            array( campo => 'periodo',valor => '-',filtro => 'N', visor => 'S')
        );
        
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_arren_local',$qquery );
        
        $nivel_color1 = ' style="color: #41415d" ';
        
        $nivel_color2 = ' style="color: #1eb554" ';
        
        $nivel_color3 = ' style="color: #ec4141" ';
        
        $suma_haber1 = 0;
        $suma_haber2 = 0;
        $suma_haber3 = 0;
        
        $i = 1;
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            
            $x = $this->bd->query_array('inv_movimiento',
                'count(*) as ntotal, sum(total) as t1',
                'modulo='.$this->bd->sqlvalue_inyeccion('arriendo',true).' and
                                         estado<>'.$this->bd->sqlvalue_inyeccion('anulado',true).' and
                                         idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true)
                );
            
            $y = $this->bd->query_array('inv_movimiento',
                'count(*) as ntotal, sum(total) as t2',
                'modulo='.$this->bd->sqlvalue_inyeccion('arriendo',true).' and
                                         estado='.$this->bd->sqlvalue_inyeccion('aprobado',true).' and
                                         idprov='.$this->bd->sqlvalue_inyeccion(trim($fetch['idprov']),true)
                );
            
            $facturas =  $y['ntotal'].' / '. $x['ntotal'];
            
            $saldo = $x['t1']- $y['t2'];
            
            echo "<tr>";
            echo "<td>".$fetch['idren_local']."</td>";
            echo "<td>".$fetch['idprov']."</td>";
            echo "<td><b>".$fetch['razon']."</b></td>";
          
            echo "<td>".$fetch['tipo']."</td>";
            echo "<td>".$fetch['contrato']."</td>";
            echo "<td>".$fetch['fecha_inicio']."</td>";
            echo "<td>".$facturas."</td>";
            
 
            echo "<td ".$nivel_color1." align='right'>".number_format($x['t1'],2)."</td>";
            echo "<td ".$nivel_color2." align='right'>".number_format($y['t2'],2)."</td>";
            
            if ( $saldo > 0  ){
                echo "<td ".$nivel_color3." align='right'>".number_format($saldo,2)."</td>";
            }else{
                echo "<td ".$nivel_color2." align='right'>".number_format($saldo,2)."</td>";
            }
         
     
            echo "</tr>";
            
            $suma_haber1 = $x['t1'] + $suma_haber1 ;
            $suma_haber2 = $y['t2'] + $suma_haber2 ;
            $suma_haber3 = $suma_haber3 + $saldo;
            
            $i++;
        }
        
        echo "<tr>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td ".$nivel_color1." align='right'>".number_format($suma_haber1,2)."</td>";
        echo "<td ".$nivel_color2." align='right'>".number_format($suma_haber2,2)."</td>";
        echo "<td ".$nivel_color2." align='right'>".number_format($suma_haber3,2)."</td>";
        
        echo "</tr>";
        
     
        echo "</table>";
        
        $PORCENTAJE = round(($suma_haber3 / $suma_haber1),2)  * 100;
        
        
     
        
        pg_free_result($resultado);
        
 
        echo "<h3>RESUMEN DE CARTERA</h3>";
        
        echo "<h4><b>SALDO A LA FECHA $ ".number_format($suma_haber3,2)."</b></h4>";
        echo "<h4><b>PORCENTAJE DE EFECTIVIDAD DE COBRO ".$PORCENTAJE." % </b></h4>";
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ consulta grilla de informacion
if (isset($_GET['ftipo']))	{
    
    $ftipo             = $_GET['ftipo'];
    $ffinalizado      = $_GET['ffinalizado'];
    
    
    
    $gestion->BusquedaGrilla($ftipo,$ffinalizado);
    
}










?>
 
  