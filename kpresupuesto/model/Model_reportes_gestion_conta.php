<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kpresupuesto/model/Model_saldos.php'; /*Incluimos el fichero de la clase objetos*/

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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
    }
    
    
    function titulo($tipo_presupuesto = 'Gasto'){
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
        
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>PRESUPUESTO ( PERIODO '.$this->anio.' ) </b><br>
                        <b>CEDULA PRESUPUESTARIA DE '.$tipo_presupuesto.'  </b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
        
    }
    //---------------------------------
    function GrillaGasto_periodo(  $partidac,$ffecha1,$ffecha2){
        
        $this->titulo($partidac);

        $fcertifica = ' and fcertifica between   '. 
                            $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.
                            $this->bd->sqlvalue_inyeccion($ffecha2 , true);
   

         $fcompromiso = ' and fcompromiso between   '. 
                            $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.
                            $this->bd->sqlvalue_inyeccion($ffecha2 , true);    

        $fecha = ' and fecha between   '. 
                            $this->bd->sqlvalue_inyeccion($ffecha1 , true) .' and '.
                            $this->bd->sqlvalue_inyeccion($ffecha2 , true);                                                        
   
        $sql = " select fcertifica as fecha,detalle_tramite as detalle ,  
                        partida, 'presupuesto' as partida_enlace, id_tramite as codigo, 0 as debe ,
                        certificado as haber, 3 as tipo,
                        'certificacion' as modulo
                    from presupuesto.view_dettramites
                    where partida = ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                          anio = ". $this->bd->sqlvalue_inyeccion($this->anio  , true)."  and 
                          estado in ('3','4','5','6')".$fcertifica ."
                    union 
                    select fcompromiso as fecha,detalle_tramite as detalle, 
                           partida, 'presupuesto' as partida_enlace, id_tramite as codigo, 0 as debe ,compromiso as haber, 4 as tipo,
                           'compromiso' as modulo
                    from presupuesto.view_dettramites
                    where partida =  ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                          anio =  ". $this->bd->sqlvalue_inyeccion($this->anio  , true)." and 
                          estado in ('3','4','5','6') ".$fcompromiso ."
                    union
                    select fecha,detalle ,partida , 'presupuesto' as partida_enlace,id_reforma as codigo,
                            (aumento-disminuye)  as debe,0 as haber,5 as tipo,
                           'reforma' as modulo
                    from presupuesto.view_reforma_detalle
                    where partida =  ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                          anio = ". $this->bd->sqlvalue_inyeccion($this->anio  , true)."   and 
                          estado = 'aprobado' ".$fecha."
                    union
                    SELECT fecha,detalle_tramite as detalle, partida, partida_enlace,
                           id_asiento as codigo ,debe,haber, 6  as tipo, 'devengado' as modulo 
                    FROM  view_diario_presupuesto 
                    where partida =  ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                          principal = 'S' and
                          anio = ". $this->bd->sqlvalue_inyeccion($this->anio  , true)."  and 
                          partida_enlace = 'gasto' ".$fecha."
                    union
                    SELECT fecha,detalle_tramite as detalle, partida, partida_enlace,
                           id_asiento as codigo ,debe,haber,7  as tipo, 'pagado' as modulo
                    FROM  view_diario_presupuesto 
                    where partida =  ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                          anio = ". $this->bd->sqlvalue_inyeccion($this->anio  , true)."  and 
                          partida_enlace = '-' and 
                          haber > 0 ".$fecha."
                    order by 1 asc, 8 asc";
        
         
                    $x = $this->bd->query_array('presupuesto.pre_gestion',   // TABLA
                    'inicial,codificado,detalle,clasificador ',                        // CAMPOS
                    "partida =  ". $this->bd->sqlvalue_inyeccion($partidac , true)." and 
                    anio = ". $this->bd->sqlvalue_inyeccion($this->anio  , true)
                    );


         $resultado  = $this->bd->ejecutar($sql);
         $nombre = 'xx';
         
         echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
         
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
         echo '<th width="55%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Inicial</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Codificado</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Reformas</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Certificacion</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Compromiso</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Devengado</th>';
         echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Pagado</th>';
           
         echo '</tr></thead><tbody>';
         
         $nsuma1 = 0;
         $nsuma2 = 0;
         $nsuma3 = 0;
         $nsuma4 = 0;
         $nsuma5 = 0;
         $nsuma6 = 0;
         $nsuma7 = 0;
         $inicial1 = '0.00';

         
         $inicial     = $x['inicial'];
         $codificado  = $x['codificado'];

         $fecha = $this->anio.'-01-01';

         echo "<tr>";
            echo '<td><a>001</a></td>';
            echo "<td>". $fecha.'</td>';
            echo '<td>ASIGNACION INICIAL DEL PRESUPUESTO</td>';

            echo "<td align='right'>".number_format( $inicial,2).'</td>';
            echo "<td align='right'>".number_format( $codificado,2).'</td>';
          
            echo "<td align='right'>".number_format( $inicial1,2).'</td>';
            echo "<td align='right'>".number_format($inicial1,2).'</td>';
            echo "<td align='right'>".number_format($inicial1,2).'</td>';
            echo "<td align='right'>".number_format($inicial1,2).'</td>';
            echo "<td align='right'>".number_format($inicial1,2).'</td>';
         
         echo "</tr>";
         while($row=pg_fetch_assoc($resultado)) {
             
             echo "<tr>";
             
             
             $referencia = ' ';
             
             echo "<td><a ".$referencia." >".trim($row['codigo']).'</a></td>';
             echo "<td>".trim($row['fecha']).'</td>';
             echo "<td>".trim($row['detalle']).'</td>';
 
             $monto = $row['debe'] +$row['haber'];

             if ( trim($row['modulo']) == 'certificacion'){
                $reformas       = '0.00';
                $certificacion =  $monto;
                $compromiso = '0.00';
                $devengado = '0.00';
                $pagado = '0.00';
             }
             if ( trim($row['modulo']) == 'compromiso'){
                $reformas       = '0.00';
                $certificacion =  '0.00';
                $compromiso = $monto;
                $devengado = '0.00';
                $pagado = '0.00';
             }
             if ( trim($row['modulo']) == 'devengado'){
                $reformas       = '0.00';
                $certificacion =  '0.00';
                $compromiso ='0.00';
                $devengado = $monto;
                $pagado = '0.00';
             }
             if ( trim($row['modulo']) == 'pagado'){
                $reformas       = '0.00';
                $certificacion =  '0.00';
                $compromiso ='0.00';
                $devengado ='0.00';
                $pagado =  $monto;
             }
             if ( trim($row['modulo']) == 'reforma'){
                $reformas       =  $monto;
                $certificacion =  '0.00';
                $compromiso ='0.00';
                $devengado ='0.00';
                $pagado = '0.00';
             }
            

             echo "<td align='right'>".number_format( $inicial1,2).'</td>';
             echo "<td align='right'>".number_format( $inicial1,2).'</td>';
           
             echo "<td align='right'>".number_format( $reformas,2).'</td>';
             echo "<td align='right'>".number_format($certificacion,2).'</td>';
             echo "<td align='right'>".number_format($compromiso,2).'</td>';
             echo "<td align='right'>".number_format($devengado,2).'</td>';
             echo "<td align='right'>".number_format($pagado,2).'</td>';
             
             $nsuma1 =  $inicial ;
             $nsuma2 =  $codificado ;

             $nsuma3 = $nsuma3 + $reformas ;
             $nsuma4 = $nsuma4 + $certificacion;
             $nsuma5 = $nsuma5 + $compromiso;
             $nsuma6 = $nsuma6 + $devengado;
             $nsuma7 = $nsuma7 + $pagado;
              
             
         
             echo "</tr>";
             
         }
         /// total
         
         
         
         
         echo "<tr>";
         echo "<td></td><td></td> 
                           <td>TOTAL</td>";
         echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';

         echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma6,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
         
         
         echo "</tr></tbody></table>";

         echo "<h5><b>Resumen Presupuestario <br>".trim($partidac).'<br> '.trim($x['detalle'])."</b></h5>";

         $disponible = $codificado  - ( $nsuma4  +  $nsuma5 );

         echo '<div class="col-md-12">   ';
         echo '<div class="col-md-2" style="font-size: 16px" align="right">Inicial : </div>
               <div class="col-md-10"  style="font-size: 16px">'.number_format($nsuma1,2).'</div>
              <div class="col-md-2"  style="font-size: 16px" align="right">Codificado :</div>
              <div class="col-md-10"  style="font-size: 16px">'.number_format($nsuma2,2).'</div>
              <div class="col-md-2"   style="font-size: 16px"align="right">Reformas :</div>
              <div class="col-md-10"  style="font-size: 16px">'. number_format($nsuma3,2).'</div>
              <div class="col-md-2"  style="font-size: 16px" align="right">Certificacion: </div>
              <div class="col-md-10"  style="font-size: 16px">'.number_format($nsuma4,2).'</div>
              <div class="col-md-2"  style="font-size: 16px" align="right">Compromiso: </div>
              <div class="col-md-10"  style="font-size: 16px">'.number_format($nsuma5,2).'</div>
              <div class="col-md-2"   style="font-size: 16px" align="right">Devengado: </div>
              <div class="col-md-10"  style="font-size: 16px">'.number_format($nsuma6,2).'</div>
              <div class="col-md-2" style="font-size: 16px" align="right">Pagado: </div>
              <div class="col-md-10"  style="font-size: 16px" >'.number_format($nsuma7,2).'</div>
              <div class="col-md-2"  style="font-size: 16px" align="right">Disponible:</div>
              <div class="col-md-10"  style="font-size: 16px" ><b>'.number_format($disponible,2)."</div>  
         <div>";

         
         pg_free_result ($resultado) ;
         
        
 
        
        
        
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
if (isset($_GET["partidac"]))	{
 
    $partidac	        =   $_GET["partidac"];
    $ffecha1	=   $_GET["ffecha1"];
    $ffecha2	=   $_GET["ffecha2"];
  
    $gestion->GrillaGasto_periodo( $partidac,$ffecha1,$ffecha2);
   
 
 
}
?>

 