<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

 

class Model_reportes_presupuesto{
    
    
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
    function Model_reportes_presupuesto( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
         
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
         
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
         
    }
    
   
   
    //---------------------------------
    function  Gasto(){
        
       
        $tipo 		    = $this->bd->retorna_tipo();
        
        $datos          = $this->bd->__user_tthh( $this->sesion);
        
        $datosp         = $this->bd->query_array('view_nomina_rol',
                                        '*', 
                                        'idprov='.$this->bd->sqlvalue_inyeccion($datos['idprov'],true)
            );
        
        $funcion = $datosp['programa'];
         
        $sql = 'SELECT partida  ,
                   detalle  ,
            	   inicial  ,
            	   aumento - disminuye as reformas,
            	   codificado ,
            	   certificado ,
            	   compromiso ,
            	   devengado ,
            	   pagado ,
            	   devengado as ejecutado
            FROM presupuesto.pre_gestion
            where tipo = '. $this->bd->sqlvalue_inyeccion('G' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($this->anio  , true)  .' and 
                  funcion = '. $this->bd->sqlvalue_inyeccion( $funcion  , true)  .
        '  order by partida,fuente';
                  
                  
                  $_SESSION['sql_activo'] = $sql;
                  
                  $resultado  = $this->bd->ejecutar($sql);
                  
                  echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
                  
                  $this->titulo('GASTOS','');
                  
                  echo '</div> ';
                  
                  echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
                  
                  $this->grilla($resultado,$tipo,"G","jtabla_gasto");
                  
                  echo '</div> ';
                  
               
    }
    //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
    
    function grilla($resultado,$tipo,$presupuesto,$nombre)  {
        
        
        
        $k = 0;
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        echo '<th width="15%">Partida</th>';
        echo '<th width="29%">Detalle</th>';
        echo '<th width="6%">Inicial</th>';
        echo '<th width="6%">Reformas</th>';
        echo '<th width="6%">Codificado</th>';
        echo '<th width="6%">Compromiso</th>';
        echo '<th width="6%">Devengado</th>';
        echo '<th width="6%">Pagado</th>';
        echo '<th width="6%">Por Comprometer</th>';
        echo '<th width="6%">Por Devengar</th>';
        echo '<th width="5%">Ejecutado (%)</th>';
        echo '<th width="3%"></th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            $item = trim($row['partida']);
            $evento = '<a href="#"  data-toggle="modal" data-target="#myModalAux">';
            
            echo "<td>".$evento.$item.'</a></td>';
            
            echo "<td>".trim($row['detalle']).'</a></td>';
            
            $nbandera = 0;
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
                $nbandera   = 1;
            }else {
                $porcentaje = $row["devengado"] / $row["codificado"]  * 100;
            }
            
            
            $porcentaje = round($porcentaje,2) ;
            
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            
            if ($nbandera == 1){
                $porcentaje = '-';
            }
            
            if ($porcentaje=='0'){
                $porcentaje = '-';
            }
            
            
            
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$porcentaje.'</td>';
            echo "<td align='center'>".$cimagen.'</td>';
            
            
            $suma = $row["pagado"];
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $suma;
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = ($nsuma5 / $nsuma3) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        $porcentaje = round($porcentaje,2) ;
        
        echo "<tr>";
        echo "<td>TOTAL</td><td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$porcentaje.' </b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    //---------------------------------------
    function grilla_total($presupuesto,$nombre,$fanio)  {
        
        
        $sql = 'SELECT
            	   sum(inicial) as inicial,
            	   (sum(aumento) - sum(disminuye)) as reformas,
            	   sum(codificado)  codificado ,
            	   sum(certificado)  certificado,
            	   sum(compromiso) compromiso,
            	   sum(devengado)  devengado,
            	   sum(pagado)  pagado
            FROM presupuesto.view_pre_gestion_periodo
            where tipo = '. $this->bd->sqlvalue_inyeccion('G' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true);
        
        $_SESSION['sql_activo'] = $sql;
        
        
        $resultado11  = $this->bd->ejecutar($sql);
        
        
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%"> <tr>';
        
        
        
        while($row=pg_fetch_assoc($resultado11)) {
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  ($row["devengado"] / $row["codificado"])  * 100;
            }
            
            $nbandera   = 0 ;
            $porcentaje = round($porcentaje,2) ;
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            
            if ($nbandera == 1){
                $porcentaje = '-';
            }
            
            if ($porcentaje=='0'){
                $porcentaje = '-';
            }
            
            
            echo '<td width="15%"></td>';
            echo '<td width="29%">RESUMEN TOTAL</td>';
            echo '<td align="right" width="6%"><b>'.number_format($row['inicial'],2)."</b></td>";
            echo '<td align="right" width="6%"><b>'.number_format($row['reformas'],2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($row['codificado'],2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($row['compromiso'],2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($row['devengado'],2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($row['pagado'],2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($c1,2)."</b></td>";
            echo '<td align="right"  width="6%"><b>'.number_format($c2,2)."</b></td>";
            echo '<td align="center" width="5%"><b>'.$porcentaje.' </b></td>';
            echo '<td align="center" width="3%"><b>'.$cimagen.' </b></td>';
            
            echo '</tr>';
            
            
        }
        
        
        
        echo "</table>";
        
        pg_free_result ($resultado11) ;
        
        
        
    }
    
      
    //--------------------------------------------------
    function titulo($tipo_presupuesto,$cmes){
        
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
        if ( empty($cmes) ){
            $titulo = $this->anio;
        }else{
            $titulo = $this->anio.'-'.$cmes;
        }
        
        
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>PRESUPUESTO ( PERIODO '.$titulo.' ) </b><br>
                        <b>CEDULA PRESUPUESTARIA DE '.$tipo_presupuesto.' POR UNIDAD EJECUTORA </b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;<br>
                    &nbsp;<br>
                     &nbsp;</td>
                </tr>
 	   </table>';
        
        
        
    }
    
    
     
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new Model_reportes_presupuesto;

     $gestion->Gasto();
         
 
?>

 