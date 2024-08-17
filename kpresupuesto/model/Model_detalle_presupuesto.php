<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

class proceso{
    
     
    private $obj;
    private $bd;
    private $set;
    
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
        $this->set     = 	new ItemsController;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    function GrillaIngreso( $fanio,$partida,$tipo,$cmes ){
        
        $x = $this->bd->query_array('presupuesto.pre_gestion',   // TABLA
            'detalle,anio ',                                     // CAMPOS
            'partida='.$this->bd->sqlvalue_inyeccion(trim($partida),true). ' and 
               anio=' .$this->bd->sqlvalue_inyeccion( $fanio ,true)
            );
            
 
        
        echo' <h4><b>'.$partida.'</b>  '.$x['detalle'].' </h4>  <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home1">Reformas</a></li>
        <li><a data-toggle="tab" href="#menu1">Emision</a></li>
        <li><a data-toggle="tab" href="#menu2">Recaudacion</a></li>
         </ul>
            
        <div class="tab-content">
            <div id="home1" class="tab-pane fade in active">
                <h4 align="center">Transacciones</h4>
                <p>';
                    $this->grilla_reforma($partida,$tipo,$fanio) .'</p>';
        echo'  </div>
            
            <div id="menu1" class="tab-pane fade">
            <h4 align="center">Transacciones</h4>
            <p>';
        $this->grilla_devengado_ingreso($partida,$tipo,$fanio,'3',$cmes);
            echo '</p>
            </div>
            <div id="menu2" class="tab-pane fade">
               <h4 align="center">Transacciones</h4>
                <p>';
            $this->grilla_devengado_cobro($partida,$tipo,$fanio,'5',$cmes);
                echo '</p>
             </div>
         </div>';
        
    }
    //---------------------------------
    function GrillaGasto( $fanio,$partida,$tipo,$cmes ){
        
        $x = $this->bd->query_array('presupuesto.pre_gestion',   // TABLA
            'detalle,anio ',                                     // CAMPOS
            'partida='.$this->bd->sqlvalue_inyeccion(trim($partida),true). ' and
               anio=' .$this->bd->sqlvalue_inyeccion( $fanio ,true)
            );
        
        
        
        echo' <h4><b>'.$partida.'</b>  '.$x['detalle'].' </h4>  <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home1">Reformas</a></li>
        <li><a data-toggle="tab" href="#menu1">Certificaciones</a></li>
        <li><a data-toggle="tab" href="#menu2">Compromisos</a></li>
        <li><a data-toggle="tab" href="#menu3">Devengados</a></li>
        <li><a data-toggle="tab" href="#menu4">Pagados</a></li>
        </ul>
        
        <div class="tab-content">
            <div id="home1" class="tab-pane fade in active">
                <h4 align="center">Transacciones</h4>
                <p>'; 
                 $this->grilla_reforma($partida,$tipo,$fanio) .'</p>';
        echo'  </div>

        <div id="menu1" class="tab-pane fade">
        <h4 align="center">Transacciones</h4>
        <p>';
                 $this->grilla_certificaciones($partida,$tipo,$fanio,'3');
        echo '</p>
        </div>
        <div id="menu2" class="tab-pane fade">
           <h4 align="center">Transacciones</h4>
        <p>';
                  $this->grilla_compromiso($partida,$tipo,$fanio,'5');
        echo '</p>
        </div>
        <div id="menu3" class="tab-pane fade">
        <h4 align="center">Transacciones</h4>
        <p>';
                 $this->grilla_devengado($partida,$tipo,$fanio,'6');
        echo '</p>
        </div>
        <div id="menu4" class="tab-pane fade">
        <h4 align="center">Transacciones</h4>
        <p>';
                 $this->grilla_pago($partida,$tipo,$fanio,'6');
        echo '</p>
        </div>
        </div>';
        
       
      
        
     
        
    }
 //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
 function grilla_reforma($partida,$presupuesto,$anio)  {
       
     $tipo 		= $this->bd->retorna_tipo();
 
     $sql = "SELECT id_reforma, 
                    fecha, 
                    tipo_reforma, 
                    partida || ' ' as partida, 
                    detalle_reforma, 
                    aumento, 
                    disminuye
            FROM presupuesto.view_reforma_detalle
            where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and 
                  partida = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and 
                 tipo = ".$this->bd->sqlvalue_inyeccion($presupuesto ,true). " order by fecha desc" ;
     
         $resultado  = $this->bd->ejecutar($sql);
         
         
         $this->obj->table->KP_sumatoria(6,'5','6') ;
         
         $cabecera =  "Tramite,Fecha,Reforma,partida, Detalle,Aumento,Disminuye";
         
         $evento   = "";
         
         $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
            
        
    }
    
  //-------------------------------  
    function grilla_certificaciones($partida,$presupuesto,$anio,$transaccion)  {
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $sql = "SELECT  id_tramite,fecha,fcertifica,unidad,solicita,detalle,certificado
            FROM presupuesto.view_tramites
            where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and
                  partida = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and
                 estado = ".$this->bd->sqlvalue_inyeccion($transaccion ,true). " order by fecha desc" ;
        
   
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->KP_sumatoria(7,'6') ;
        
        $cabecera =  "Tramite,Fecha,Certificacion,Unidad,Responsable, Detalle,Monto Certifica";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
    }
 //------------------------------
    function grilla_compromiso($partida,$presupuesto,$anio,$transaccion)  {
        
 
        
        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="5%"> tramite </th>
                <th width="7%"> Inicio</th>
                <th width="7%"> Compromisos </th>
                <th width="15%"> Unidad </th>
                <th width="15%"> Solicita </th>
                <th width="31%"> Detalle</th>
                <th width="15%"> Beneficiario </th>
                <th width="5%"> Monto</th>
                 </tr></thead>';
        
        
        $sql = "SELECT  *
            FROM presupuesto.view_tramites
            where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and
                  partida = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and
                  estado in ('5','6')  order by fecha desc" ;
        
                  
        
        $resultado  = $this->bd->ejecutar($sql);
         
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
             
            echo '<tr><td>'.$fetch['id_tramite'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['fcompromiso'].'</td>';
            echo ' <td>'.$fetch['unidad'].'</td>';
            echo ' <td>'.$fetch['solicita'].'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['proveedor'].'</td>';
            echo ' <td  align="right">'.$fetch['compromiso'].'</td>';
           
            echo ' </tr>';
            
            $total = $total  + $fetch['compromiso'];
        }
        
        echo '<tr><td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td  align="right">'.number_format($total,2).'</td>';
        
        echo ' </tr>';
        echo "</tbody>  </table>";
        
 
        
        pg_free_result($resultado);
        
 
        
    }
  //------------
    function grilla_devengado($partida,$presupuesto,$anio,$transaccion)  {
        
        

        
        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="8%"> tramite </th>
                <th width="5%"> Asiento</th>
                <th width="42%"> Detalle </th>
                <th width="7%"> Fecha </th>
                <th width="10%"> Cuenta </th>
                <th width="20%"> Detalle Cuenta </th>
                 <th width="8%"> Monto</th>
                 </tr></thead>';
        
        
        $qquery = array(
            array( campo => 'id_tramite',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_asiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_cuenta',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'detalle_tramite',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'monto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
            array( campo => 'partida',valor => trim($partida),filtro => 'S', visor => 'N'),
            array( campo => 'partida_enlace',valor => 'gasto',filtro => 'S', visor => 'N')
        );
        
 
        $this->bd->_order_by('fecha');
        
        $resultado = $this->bd->JqueryCursorVisor('view_diario_presupuesto',$qquery, 1 );
        
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $detalle = trim($fetch['detalle_tramite']) . ' '.trim($fetch['razon']);
            
            echo '<tr><td>'.$fetch['id_tramite'].'</td>';
            echo ' <td>'.$fetch['id_asiento'].'</td>';
            echo ' <td>'.$detalle.'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['cuenta'].'</td>';
            echo ' <td>'.$fetch['detalle_cuenta'].'</td>';
             echo ' <td  align="right">'.$fetch['monto'].'</td>';
             
            echo ' </tr>';
            
            $total = $total  + $fetch['monto'];
        }
        
        echo '<tr><td>'.$fetch['id_tramite'].'</td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td  align="right">'.number_format($total,2).'</td>';
        
        echo ' </tr>';
        
        echo "</tbody>  </table>";
        
         
        pg_free_result($resultado);
 
 
        
    }
 //------------------------
    function grilla_pago($partida,$presupuesto,$anio,$transaccion)  {
        
        
        
        
        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="10%"> tramite </th>
                <th width="10%"> Asiento</th>
                <th width="10%"> Fecha </th>
                <th width="10%"> Cuenta </th>
                <th width="40%"> Detalle Cuenta </th>
                <th width="10%"> Debe(pago)</th>
                <th width="10%"> Haber(dev)</th>
                 </tr></thead>';
        
        
        $qquery = array(
            array( campo => 'id_tramite',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_asiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_cuenta',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'detalle_tramite',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'debe',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'haber',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
            array( campo => 'partida',valor => trim($partida),filtro => 'S', visor => 'N'),
            array( campo => 'partida_enlace',valor => '-',filtro => 'S', visor => 'N')
        );
        
        
        $this->bd->_order_by('fecha');
        
        $resultado = $this->bd->JqueryCursorVisor('view_diario_presupuesto',$qquery,1 );
        
        $totald = 0;
        $totalh = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            
            
            echo '<tr><td>'.$fetch['id_tramite'].'</td>';
            echo ' <td>'.$fetch['id_asiento'].'</td>';
             echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['cuenta'].'</td>';
            echo ' <td>'.$fetch['detalle_cuenta'].'</td>';
            echo ' <td  align="right">'.$fetch['debe'].'</td>';
            echo ' <td  align="right">'.$fetch['haber'].'</td>';
            
            echo ' </tr>';
            
            $totald = $totald  + $fetch['debe'];
            $totalh = $totalh  + $fetch['haber'];
        }
        
        echo '<tr><td>'.$fetch['id_tramite'].'</td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
         echo ' <td> </td>';
        echo ' <td align="right"> Resumen </td>';
        echo ' <td  align="right"><b>'.number_format($totald,2).'</b></td>';
        echo ' <td  align="right"><b>'.number_format($totalh,2).'</b></td>';
        
        echo ' </tr>';
        
        echo "</tbody>  </table>";
        
        
        pg_free_result($resultado);
        
        
        
    }
 //-------------------
    function grilla_devengado_ingreso($partida,$presupuesto,$anio,$transaccion,$cmes)  {
        
        
        
        
        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                 <th width="8%"> Asiento</th>
                 <th width="8%"> Fecha </th>
                 <th width="31%"> Detalle Asiento </th>
                 <th width="15%"> Cuenta </th>
                 <th width="30%"> Detalle Cuenta </th>
                 <th width="8%"> Monto</th>
                 </tr></thead>';
        
        
        $qquery = array(
             array( campo => 'id_asiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_tramite',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'detalle_cuenta',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'monto',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
            array( campo => 'partida',valor => trim($partida),filtro => 'S', visor => 'N'),
            array( campo => 'partida_enlace',valor => 'ingreso',filtro => 'S', visor => 'N')
        );
        
        
        if ( $cmes == '-'){
            
        }else{
            $hasta = intval($cmes);
            $this->bd->__between('mes','1',$hasta);
        }
         
            
        $this->bd->_order_by('fecha');
        
        $resultado = $this->bd->JqueryCursorVisor('view_diario_presupuesto',$qquery );
        
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $detalle = trim($fetch['detalle_tramite']) . ' '.trim($fetch['razon']);
            
            echo '<tr>';
            echo ' <td>'.$fetch['id_asiento'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$detalle.'</td>';
            echo ' <td>'.$fetch['cuenta'].'</td>';
            echo ' <td>'.$fetch['detalle_cuenta'].'</td>';
            echo ' <td  align="right">'.$fetch['monto'].'</td>';
            
            echo ' </tr>';
            
            $total = $total  + $fetch['monto'];
        }
        
        
        echo "</tbody>  </table>";
        
        echo '<h4>Resumen: '.number_format($total,2).'</h4>';
        
        pg_free_result($resultado);
        
        
        
        
        
    }
    
    function grilla_devengado_cobro($partida,$presupuesto,$anio,$transaccion,$cmes)  {
        
        
        
        
        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                 <th width="8%"> Asiento</th>
                 <th width="8%"> Fecha </th>
                 <th width="31%"> Detalle Asiento  </th>
                <th width="15%"> Cuenta </th>
                <th width="30%"> Detalle Cuenta</th>
                <th width="8%"> Debe</th>
                <th width="8%"> Haber</th>
                 </tr></thead>';
        
        
        $qquery = array(
            array( campo => 'id_asiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cuenta',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle_tramite',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'detalle_cuenta',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S') ,
            array( campo => 'debe',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'haber',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => $anio,filtro => 'S', visor => 'N'),
            array( campo => 'partida',valor => trim($partida),filtro => 'S', visor => 'N'),
            array( campo => 'partida_enlace',valor => '-',filtro => 'S', visor => 'N')
        );
        
        if ( $cmes == '-'){
            
        }else{
            $hasta = intval($cmes);
            $this->bd->__between('mes','1',$hasta);
        }
        
        $this->bd->_order_by('fecha');
        
        $resultado = $this->bd->JqueryCursorVisor('view_diario_presupuesto',$qquery, '1' );
        
        $totald = 0;
        $totalh = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $detalle = trim($fetch['detalle_tramite']) . ' '.trim($fetch['razon']);
            
            echo '<tr>';
            echo ' <td>'.$fetch['id_asiento'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$detalle.'</td>';
            echo ' <td>'.$fetch['cuenta'].'</td>';
            echo ' <td>'.$fetch['detalle_cuenta'].'</td>';
            echo ' <td  align="right">'.$fetch['debe'].'</td>';
            echo ' <td  align="right">'.$fetch['haber'].'</td>';
            
            echo ' </tr>';
            
            $totald = $totald  + $fetch['debe'];
            $totalh  = $totalh  + $fetch['haber'];
        }
        
        echo '<tr>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td  align="right"> Resumen</td>';
        echo ' <td  align="right">'.number_format($totald,2).'</td>';
        echo ' <td  align="right">'.number_format($totalh,2).'</td>';
        
        echo ' </tr>';
        
        echo "</tbody>  </table>";
 
        pg_free_result($resultado);
        
        
        
        
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["tipo"]))	{
    
 
    
    
    $fanio		=   $_GET["fanio"];
    $partida	=   $_GET["partida"];
    $tipo       =   $_GET["tipo"];
    $cmes        =   $_GET["cmes"];
     
    if ( $tipo == 'G'){
   
        $gestion->GrillaGasto( $fanio,$partida,$tipo,$cmes);
    
    
    }else {
        
        $gestion->GrillaIngreso( $fanio,$partida,$tipo,$cmes);
        
    }
 
}
?>
 