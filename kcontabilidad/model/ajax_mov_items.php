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
    private $anio;
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

        $this->anio       =  $_SESSION['anio'];
        
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
                    $this->grilla_reforma($partida,$tipo,$this->anio) .'</p>';
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
    function GrillaGasto($partida,$tipo,$ffecha1,$ffecha2){
        
    

        $fanio = $this->anio;
         
        echo'<h4>Clasificador: '.$partida.'</h4> <ul class="nav nav-tabs">
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
                    $this->grilla_reforma($partida,'G',$fanio) .'</p>';
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
                  $this->grilla_compromiso($partida,$tipo,$fanio,'5',$ffecha1,$ffecha2);
        echo '</p>
        </div>
        <div id="menu3" class="tab-pane fade">
        <h4 align="center">Transacciones</h4>
        <p>';
                  $this->grilla_devengado($partida,$tipo,$fanio,'6',$ffecha1,$ffecha2);
        echo '</p>
        </div>
        <div id="menu4" class="tab-pane fade">
        <h4 align="center">Transacciones</h4>
        <p>';
               $this->grilla_pago($partida,$tipo,$fanio,'-',$ffecha1,$ffecha2);
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
            where anio         =".$this->bd->sqlvalue_inyeccion($anio ,true). " and 
                  clasificador = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and 
                  tipo         = ".$this->bd->sqlvalue_inyeccion($presupuesto ,true). " order by fecha desc" ;
     
         $resultado  = $this->bd->ejecutar($sql);
         
         
         
         $this->obj->table->KP_sumatoria(6,'5','6') ;
         
         $cabecera =  "Tramite,Fecha,Reforma,partida, Detalle,Aumento,Disminuye";
         
         $evento   = "";
         
         $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
            
        
    }
    
  //-------------------------------  
    function grilla_certificaciones($partida,$presupuesto,$anio,$transaccion)  {
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        $sql = "SELECT  id_tramite || ' ' as id_tramite,
                        fecha,fcertifica,
                        fcompromiso,
                        substring(trim(detalle),0,100) as detalle,
                        certificado
            FROM presupuesto.view_tramites
            where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and
                  partida like  ".$this->bd->sqlvalue_inyeccion('%'.$partida.'%' ,true). "  and
                  estado = ".$this->bd->sqlvalue_inyeccion($transaccion ,true). " order by fecha desc" ;
        
   
 
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->KP_sumatoria(6,'5') ;
        
        $cabecera =  "Tramite,Fecha,Certificacion,Compromiso, Detalle,Monto Certifica";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
    }
 //------------------------------
    function grilla_compromiso($partida,$presupuesto,$anio,$transaccion,$ffecha1,$ffecha2)  {
        
 
      

        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="5%" '.$estilo.' > tramite </th>
                <th width="10%" '.$estilo.'> Partida</th>
                <th width="7%" '.$estilo.' > Inicio</th>
                <th width="7%" '.$estilo.' > Compromiso</th>
                <th width="7%" '.$estilo.' > Devengado </th>
                <th width="59%" '.$estilo.'> Detalle</th>
                <th width="5%" '.$estilo.' > Monto</th>
                 </tr></thead>';
        
        
        $sql = "SELECT  *
            FROM presupuesto.view_tramites
            where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and 
                  partida like ".$this->bd->sqlvalue_inyeccion('%'.$partida.'%' ,true). "  and
                  estado in ('5','6') AND  
                  fcompromiso between ".$this->bd->sqlvalue_inyeccion($ffecha1 ,true). "  and
                  ".$this->bd->sqlvalue_inyeccion($ffecha2 ,true). "   order by fcompromiso  desc" ;
        
                 
        
        $resultado  = $this->bd->ejecutar($sql);
         
        $total = 0;
        
        while ($fetch11=$this->bd->obtener_fila($resultado)){
             
            echo '<tr><td>'.$fetch11['id_tramite'].'</td>';
            echo ' <td>'.$fetch11['partida'].'</td>';
            echo ' <td>'.$fetch11['fecha'].'</td>';
            echo ' <td>'.$fetch11['fcompromiso'].'</td>';
            echo ' <td>'.$fetch11['fdevenga'].'</td>';
            echo ' <td>'.$fetch11['detalle'].'</td>';
            echo ' <td  align="right">'.$fetch11['compromiso'].'</td>';
           
            echo ' </tr>';
            
            $total = $total  + $fetch11['compromiso'];
        }
        
        echo '<tr><td> </td>';
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
    function grilla_devengado($partida,$presupuesto,$anio,$transaccion,$ffecha1,$ffecha2)  {
        
        

        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="5%" '.$estilo.' > Tramite </th>
                <th width="7%" '.$estilo.' > Compromiso </th>
                <th width="7%" '.$estilo.' > Fecha </th>
                 <th width="5%" '.$estilo.'> Asiento</th>
                <th width="10%" '.$estilo.'> Partida</th>
                <th width="61%" '.$estilo.'> Detalle</th>
                <th width="5%" '.$estilo.' > Monto</th>
                 </tr></thead>';
         

                 $sql1 = "SELECT  *
                 FROM view_diario_presupuesto
                 where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and 
                       item_valida = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and
                       partida_enlace = 'gasto' and 
                       fecha between ".$this->bd->sqlvalue_inyeccion($ffecha1 ,true). "  and
                       ".$this->bd->sqlvalue_inyeccion($ffecha2 ,true). "   order by fecha desc" ;
        
                $resultado1  = $this->bd->ejecutar($sql1);
        
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado1)){
            
             
            $x_comp = $this->bd->query_array('presupuesto.view_tramites',   // TABLA
            '*',                        // CAMPOS
            'id_tramite='.$this->bd->sqlvalue_inyeccion($fetch['id_tramite'],true) // CONDICION
            );
               

            echo '<tr><td>'.$fetch['id_tramite'].'</td>';
            echo ' <td>'.$x_comp['fcompromiso'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
           
            echo ' <td>'.$fetch['id_asiento'].'</td>';
            echo ' <td>'.$fetch['partida'].'</td>';
            echo ' <td>'.$fetch['detalle_tramite'].'</td>';
              echo ' <td  align="right">'.$fetch['monto'].'</td>';
             
            echo ' </tr>';
            
            $total = $total  + $fetch['monto'];
        }
        
        echo '<tr><td></td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
         echo ' <td  align="right"><b>'.number_format($total,2).'</b></td>'; 
        echo ' </tr>';
        
        echo "</tbody>  </table>";
        
         
        pg_free_result($resultado);
 
 
        
    }
 //------------------------
    function grilla_pago($partida,$presupuesto,$anio,$transaccion,$ffecha1,$ffecha2)  {
        
        
            

        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="display table-condensed table-bordered table-hover" style="font-size: 11px" cellspacing="0" width="100%">
          <thead> <tr>
                <th width="5%" '.$estilo.' > Tramite </th>
                <th width="7%" '.$estilo.' > Fecha </th>
                <th width="5%" '.$estilo.'> Asiento</th>
                <th width="10%" '.$estilo.'> Partida</th>
                <th width="63%" '.$estilo.'> Detalle</th>
                <th width="5%" '.$estilo.' > Debe</th>
                <th width="5%" '.$estilo.' > Haber</th>
                 </tr></thead>';
         

                 $sql2 = "SELECT  *
                 FROM view_diario_presupuesto
                 where anio=".$this->bd->sqlvalue_inyeccion($anio ,true). " and 
                       item_valida = ".$this->bd->sqlvalue_inyeccion($partida ,true). "  and
                       partida_enlace = '-' and 
                       fecha between ".$this->bd->sqlvalue_inyeccion($ffecha1 ,true). "  and
                       ".$this->bd->sqlvalue_inyeccion($ffecha2 ,true). "   order by haber desc, fecha desc" ;
        
                $resultado2  = $this->bd->ejecutar($sql2);
        
        $totald = 0;
        $totalh = 0;
        
        while ($fetch1=$this->bd->obtener_fila($resultado2)){
            
             
            echo '<tr><td>'.$fetch1['id_tramite'].'</td>';
            echo ' <td>'.$fetch1['fecha'].'</td>';
            echo ' <td>'.$fetch1['id_asiento'].'</td>';
            echo ' <td>'.$fetch1['partida'].'</td>';
            echo ' <td>'.$fetch1['detalle_tramite'].'</td>';
              echo ' <td  align="right">'.$fetch1['debe'].'</td>';
              echo ' <td  align="right">'.$fetch1['haber'].'</td>';
             
            echo ' </tr>';
            
            $totald = $totald  + $fetch1['debe'];
            $totalh = $totalh  + $fetch1['haber'];
        }
        
        echo '<tr><td></td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td  align="right"><b>'.number_format($totald,2).'</b></td>';
        echo ' <td  align="right"><b>'.number_format($totalh,2).'</b></td>';
        
        echo ' </tr>';
        
        echo "</tbody>  </table>";
        
        echo $totalh - $totald;
         
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
        
        $resultado = $this->bd->JqueryCursorVisor('view_diario_presupuesto',$qquery );
        
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
    
 
    
     $partida	     =   $_GET["item"];
     $tipo           =   $_GET["tipo"];
     $ffecha1        =   $_GET["ffecha1"];
     $ffecha2        =   $_GET["ffecha2"];
     
    if ( $tipo == '2'){
   
        $gestion->GrillaGasto( $partida,$tipo,$ffecha1,$ffecha2);
    
    
    }else {
        
        $gestion->GrillaIngreso(  $partida,$tipo,$ffecha1,$ffecha2);
        
    }
 
}
?>
 