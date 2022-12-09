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
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
    }
    
    //--- calcula libro diario
    function Comparativo_gasto($fanio,$tipo,$cmes){
 
        
        $anio1= $fanio  - 1; 
        $anio2= $fanio  - 2;
        
        $sql = "SELECT anio,sum(inicial) as inicial,  sum(codificado) as codificado,  
            	   sum(devengado) as devengado,
            	   (sum(devengado) / sum(codificado)) * 100 as p1
            FROM presupuesto.view_pre_gestion_periodo
            where tipo = 'G' and anio =".$this->bd->sqlvalue_inyeccion($fanio,true)."
            group by anio
            union
            SELECT anio,sum(inicial) as inicial,  sum(codificado) as codificado,  
            	   sum(devengado) as devengado,
            	   (sum(devengado) / sum(codificado)) * 100 as p1
            FROM presupuesto.pre_gestion
            where tipo = 'G' and 
                  anio in (".$this->bd->sqlvalue_inyeccion($anio1,true).",".$this->bd->sqlvalue_inyeccion($anio2,true).")
            group by anio
            order by anio desc";

         
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="20%" '.$estilo.'>Periodo</th>';
        echo '<th width="22%" '.$estilo.'>Inicial</th>';
        echo '<th width="22%" '.$estilo.'>Codificado</th>';
        echo '<th width="21%" '.$estilo.'>Devengado</th>';
        echo '<th width="10%" '.$estilo.'>(%)</th>';
        echo '<th width="5%" '.$estilo.'></th>';
        
        echo '</tr></thead><tbody>';
        
 
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo =  $row['anio'] ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
              
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='center'>".number_format($xx,2).'</td>';
            echo "<td align='center'>". $cimagen.'</td>';
            
 
            
            $k++;
            echo "</tr>";
            
        }
      
        
        echo "</tbody></table>";
        
        pg_free_result ($resultado) ;
 
     

    }
    //-----------------------------------
    function Comparativo_ingreso($fanio,$tipo,$cmes){
        
        
        $anio1= $fanio  - 1;
        $anio2= $fanio  - 2;
        
        $sql = "SELECT anio,sum(inicial) as inicial,  sum(codificado) as codificado,
            	   sum(devengado) as devengado,
            	   (sum(devengado) / sum(codificado)) * 100 as p1
            FROM presupuesto.view_pre_gestion_periodo
            where tipo = 'I' and anio =".$this->bd->sqlvalue_inyeccion($fanio,true)."
            group by anio
            union
            SELECT anio,sum(inicial) as inicial,  sum(codificado) as codificado,
            	   sum(devengado) as devengado,
            	   (sum(devengado) / sum(codificado)) * 100 as p1
            FROM presupuesto.pre_gestion
            where tipo = 'I' and
                  anio in (".$this->bd->sqlvalue_inyeccion($anio1,true).",".$this->bd->sqlvalue_inyeccion($anio2,true).")
            group by anio
            order by anio desc";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;

        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        
      
        
        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="20%"   '.$estilo.'>Periodo</th>';
        echo '<th width="22%"   '.$estilo.'>Inicial</th>';
        echo '<th width="22%"   '.$estilo.'>Codificado</th>';
        echo '<th width="21%"   '.$estilo.'>Devengado</th>';
        echo '<th width="10%"   '.$estilo.'>(%)</th>';
        echo '<th width="5%"   '.$estilo.'></th>';
        
        echo '</tr></thead><tbody>';
        
        
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo =  $row['anio'] ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='center'>".number_format($xx,2).'</td>';
            echo "<td align='center'>". $cimagen.'</td>';
            
            
            
            $k++;
            echo "</tr>";
            
        }
        
        
        echo "</tbody></table>";
        
        pg_free_result ($resultado) ;
        
        
        
    }
    //---------------------------------
    function titulo_programa( $fanio,$tipo,$cmes ){
        
  
        
        
        $sql = "SELECT funcion,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by funcion order by funcion";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="19%" '.$estilo. '>Detalle</th>';
        echo '<th width="9%" '.$estilo. '>Inicial</th>';
        echo '<th width="9%" '.$estilo. '>Reformas</th>';
        echo '<th width="9%" '.$estilo. '>Codificado</th>';
        echo '<th width="9%" '.$estilo. '>Compromiso</th>';
        echo '<th width="9%" '.$estilo. '>Devengado</th>';
        echo '<th width="9%" '.$estilo. '>Pagado</th>';
        echo '<th width="9%" '.$estilo. '>Por Comprometer</th>';
        echo '<th width="9%" '.$estilo. '>Por Devengar</th>';
        echo '<th width="9%" '.$estilo. '>Ejecutado</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma6 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo_funcion(trim($row['funcion'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
        
    }
    //-------------------------------------------------
    function titulo_tthh( $fanio,$tipo,$cmes ){
        
        
        
        
        $sql = "SELECT funcion,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)." and grupo in ('51','71')
                group by funcion order by funcion";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        
        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="19%" '. $estilo .'>Detalle</th>';
        echo '<th width="9%" '. $estilo .'>Inicial</th>';
        echo '<th width="9%" '. $estilo .'>Reformas</th>';
        echo '<th width="9%" '. $estilo .'>Codificado</th>';
        echo '<th width="9%" '. $estilo .'>Compromiso</th>';
        echo '<th width="9%" '. $estilo .'>Devengado</th>';
        echo '<th width="9%" '. $estilo .'>Pagado</th>';
        echo '<th width="9%" '. $estilo .'>Por Comprometer</th>';
        echo '<th width="9%" '. $estilo .'>Por Devengar</th>';
        echo '<th width="9%" '. $estilo .'>Ejecutado</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma6 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo_funcion(trim($row['funcion'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
        
    }
    //--------------------------------------------------
    function GrillaGasto_periodo_uno( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion,$cmes){
        
        
        
        $tipo 		    = $this->bd->retorna_tipo();
         
        
        if ( trim($funcion) == '-'){
            $programa_where = '';
        }else{
            $programa_where = ' and funcion ='. $this->bd->sqlvalue_inyeccion($funcion , true) ;
        }
        
        if ( $vfuente == '-'){
            $fuente_where = '';
        }else{
            $fuente_where = ' and fuente='. $this->bd->sqlvalue_inyeccion($vfuente , true) ;
        }
        
        if ( $vgrupo == '-'){
            $vgrupo_where = '';
        }else{
            $vgrupo_where = ' and grupo='. $this->bd->sqlvalue_inyeccion($vgrupo , true) ;
        }
        
        if ( $vactividad == '-'){
            $vactividad_where = '';
        }else{
            $vactividad_where = ' and actividad='. $this->bd->sqlvalue_inyeccion($vactividad , true) ;
        }
        
        
        $lon = strlen($item);
        
        if ( $lon  < 4 ){
            $item_where = '';
        }else{
            $item_where = ' and clasificador like '. $this->bd->sqlvalue_inyeccion($item , true) ;
        }
        
        
        
        $sql = 'SELECT partida ,
                   detalle,
            	   inicial ,
            	   (aumento - disminuye) as reformas,
            	   codificado  ,
            	   certificado  ,
            	   compromiso  ,
            	   devengado  ,
            	   pagado  ,
            	   ejecutado 
            FROM presupuesto.view_pre_gestion_periodo
            where tipo = '. $this->bd->sqlvalue_inyeccion('G' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .
                  $programa_where.
                  $fuente_where.
                  $vgrupo_where.
                  $vactividad_where.
                  $fuente_where.
                  $item_where.'  order by partida,fuente';
                   
                  
                  
                  $resultado  = $this->bd->ejecutar($sql);
                  
                  echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
                  
                  $this->titulo('GASTOS',$cmes);
                  
                  echo '</div> ';
                  
                  echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
                  
                  $this->grilla($resultado,$tipo,"G","jtabla_gasto");
                  
                  echo '</div> ';
                  
                  $this->firmas( );
                  
                  
                  
                  
                  
    }
    //--------------------
    function resumen($fanio,$tipo,$cmes )  {
        
        
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
        
        
        $resultado11  = $this->bd->ejecutar($sql);
        
             
        
        while($row=pg_fetch_assoc($resultado11)) {
            
 
            $c2 = $row["codificado"]  ;
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  ($row["devengado"] / $row["codificado"])  * 100;
            }
            
            $nbandera   = 0 ;
            
            $porcentaje = round($porcentaje,2) ;
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png"  align="absmiddle"  title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png"  align="absmiddle"  title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png"  align="absmiddle"  title="'.$porcentaje.' %'.'"/>';
            }
            
            $inicial = $row["inicial"]  ;
            
        }
 
        pg_free_result ($resultado11) ;
       
        $variacion =  $c2  - $inicial;
        $p1 = ( $variacion / $inicial) * 100;
        
        $pp1 =  round($p1,2) ;
        
        echo ( '<h5>El Presupuesto inicial del periódo <b>'.$fanio.'</b> es de $ <b>'.number_format($inicial,2).
        ' </b> dólares; el porcentaje (%) de variación entre el monto inicial y codificado es del <b>'.$pp1.' </b>%<br><br>'.'
          El porcentaje(%) de ejecucion de gasto correspondiente al periodo es del <b>'.$porcentaje.' </b>% '.$cimagen.' acontinuación se detalle los tramites emitidos por la unidad financiera</h5>');
        
        
    }
  //-----------------
    public function tramites_gastos(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        $sql = "SELECT  case estado when '1' then '1. Requerimiento Solicitado' when
						 '2' then '2. Tramite Autorizado' when
						 '3' then '3. Emitir Certificacion' when
						 '4' then '4. Tramites Enviado' when
						 '5' then '5. Emitir Compromiso' when
						 '6' then '6. Tramites Devengado' when
						 '0' then 'Anulados' end as proceso, count(*) || ' '  as tramites
                FROM presupuesto.view_pre_tramite
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by estado
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Procesos,Nro Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //-----------------------------------------------------
    function titulo_ingreso_grupos($fanio,$tipo,$cmes )  {
        
        
        $sql = "SELECT grupo,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'I' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by grupo order by grupo";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="19%" '.$estilo.'>Detalle</th>';
        echo '<th width="9%"  '.$estilo.'>Inicial</th>';
        echo '<th width="9%" '.$estilo.'>Reformas</th>';
        echo '<th width="9%"  '.$estilo.'>Codificado</th>';
        echo '<th width="9%"  '.$estilo.'>Compromiso</th>';
        echo '<th width="9%"  '.$estilo.'>Devengado</th>';
        echo '<th width="9%"  '.$estilo.'>Pagado</th>';
        echo '<th width="9%"  '.$estilo.'>Por Comprometer</th>';
        echo '<th width="9%"  '.$estilo.'>Por Devengar</th>';
        echo '<th width="9%"  '.$estilo.'>Ejecutado</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma6 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo(trim($row['grupo'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    //------------------------------------------------------
    function titulo_ingreso( $fanio,$tipo,$cmes ){
        
        
        $sql = "SELECT titulo,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'I' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by titulo order by titulo";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';


        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="28%" '. $estilo.'>Detalle</th>';
        echo '<th width="9%" '. $estilo.'>Inicial</th>';
        echo '<th width="9%" '. $estilo.'>Reformas</th>';
        echo '<th width="9%" '. $estilo.'>Codificado</th>';
        echo '<th width="9%" '. $estilo.'>Compromiso</th>';
        echo '<th width="9%" '. $estilo.'>Devengado</th>';
        echo '<th width="9%" '. $estilo.'>Por Comprometer</th>';
        echo '<th width="9%" '. $estilo.'>Por Devengar</th>';
        echo '<th width="9%" '. $estilo.'>Ejecutado</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma6 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo(trim($row['titulo'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
                  
 
                  
                  
    }
    //---------------------------------
    function GrillaGasto( $fanio,$tipo,$cmes ){
        
        
        
        $this->titulo($fanio,$cmes);
        
        $this->set->div_label(12,'<b>RESUMEN DE GESTION FINANCIERA</b>');
        
        
        $this->set->div_panel4('<b>RESUMEN GESTION FINANCIERA A LA FECHA </b>');
        
        $this->resumen($fanio,$tipo,$cmes );
        
        $this->set->div_panel4('fin');
        
        
        
        $this->set->div_panel4('<b>GASTO POR PERIODO - COMPARATIVO '.$fanio.'-'.$cmes.' </b>');
        
            $this->Comparativo_gasto($fanio,$tipo,$cmes );
        
        $this->set->div_panel4('fin');
        
        
        $this->set->div_panel4('<b>INGRESO POR PERIODO - COMPARATIVO '.$fanio.'-'.$cmes.' </b>');
        
        $this->Comparativo_ingreso($fanio,$tipo,$cmes );
        
        $this->set->div_panel4('fin');
        
        
             
        $this->set->div_label(12,'<b>GESTION DE GASTOS</b>');
                         
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR PERIODO '.$fanio.'-'.$cmes.' </b>');
        
                    $this->titulo_gasto( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');
        
        
        
 
        
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR GRUPO PERIODO '.$fanio.'-'.$cmes.' </b>');
        
        $this->titulo_gasto_grupos( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');
        
        
        
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR PROGRAMA '.$fanio.'-'.$cmes.' </b>');
        
        $this->titulo_programa( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');
        
        
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA  PROGRAMA - PERSONAL '.$fanio.'-'.$cmes.' </b> ( Grupo 51-71 )');
        
        $this->titulo_tthh( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');
        
        
        
        
        $this->set->div_label(12,'<b>GESTION DE INGRESOS</b>');
     
        
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR PERIODO '.$fanio.'-'.$cmes.' </b>');
        
                  $this->titulo_ingreso( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');


        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR GRUPO PERIODO '.$fanio.'-'.$cmes.' </b>');
        
        $this->titulo_ingreso_grupos( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');


        
        
        /*
        $this->set->div_label(12,'<b>TRAMITES DE GESTION FINANCIERA</b>');
        
        $this->set->div_panel4('<b>ESTADO DE TRAMITES </b>');
        
                  $this->tramites_gastos();
        
        $this->set->div_panel4('fin');
       
        $this->set->div_panel4('<b>TRAMITES POR PROGRAMA</b>');
        
              $this->tramites_programa();
        
        $this->set->div_panel4('fin');
        
        
        $this->set->div_panel4('<b>TRAMITES POR UNIDAD</b>');
        
            $this->tramites_unidades();
        
        $this->set->div_panel4('fin');
        
        
        $this->set->div_label(12,'<b>GESTION PRESUPUESTARIA - REFORMAS</b>');
        
        
        $this->set->div_panel9('<b>POR PROGRAMA</b>');
        
            $this->reformas_programa();
        
        $this->set->div_panel9('fin');
        
        
        $this->set->div_panel9('<b>POR TITULO</b>');
        
        $this->reformas_titulo();
        
        $this->set->div_panel9('fin');
        
        
        $this->set->div_panel9('<b>POR GRUPO</b>');
        
        $this->reformas_grupo();
        
        $this->set->div_panel9('fin');
     
       
        $this->set->div_panel9('<b>POR UNIDAD - GRUPO</b>');
        
        $this->reformas_unidad();
        
        $this->set->div_panel9('fin');
        */
        
    }
 //--------------------
    //----tramites_grupo
    public function tramites_programa(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        $sql = "SELECT  programa,   
                        sum(certificado) as monto_certifica,
                        sum(compromiso) as monto_compromiso
                FROM presupuesto.view_dettramites
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by programa
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Programa, Certificacion,Compromiso";
        
        $evento   = "";
        
        $this->obj->table->KP_sumatoria(2,'1','2','','') ;
         
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
 
        
    }
    //----------------------------------
    //----tramites_grupo
    public function reformas_programa(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $inicial = "( SELECT  sum(x.inicial)
                     FROM presupuesto.pre_gestion x
                    where x.funcion = a.funcion and x.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as inicial,";
        
        
        $codificado = "( SELECT  sum(y.codificado)
                     FROM presupuesto.pre_gestion y
                    where y.funcion = a.funcion and y.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as codificado";
        
  
        $sql = "SELECT  b.detalle,".$inicial." 
                        sum(a.aumento) as aumento,
                        sum(a.disminuye) as disminuye,
                        sum(a.aumento)-sum(a.disminuye) as reforma,".$codificado."
                FROM presupuesto.view_reforma_detalle a, presupuesto.pre_catalogo b
                where a.anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and 
                      a.estado =  'aprobado'  and b.codigo = a.funcion and
                      b.categoria= 'programa'          
                group by a.funcion,b.detalle
                order by 1";
        
 
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Programa,Inicial,Aumento,Disminuye,Reforma,Codificado";
        
        $evento   = "";
        
        $this->obj->table->KP_sumatoria(2,'1','2','3','4','5') ;
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
        
        
    }
 //---------------
    //----tramites_grupo
    public function reformas_titulo(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $inicial = "( SELECT  sum(x.inicial) 
                     FROM presupuesto.pre_gestion x
                    where x.titulo = a.titulo and x.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as inicial,";
        
        
        $codificado = "( SELECT  sum(y.codificado)
                     FROM presupuesto.pre_gestion y
                    where y.titulo = a.titulo and y.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as codificado";
        
        
        
        $sql = "SELECT  a.titulo || ' ' || b.detalle as detalle,".$inicial."
                        sum(a.aumento) as aumento,
                        sum(a.disminuye) as disminuye,
                        sum(a.aumento) - sum(a.disminuye) as reforma,".$codificado."
                FROM presupuesto.view_reforma_detalle a, presupuesto.pre_catalogo b
                where a.anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                      a.estado =  'aprobado'  and b.codigo = a.titulo and
                      b.categoria= 'clasificador'
                group by a.titulo,b.detalle
                order by 1";
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Titulo,Inicial,Aumento,Disminuye,Reforma,Codificado";
        
        $evento   = "";
        
        $this->obj->table->KP_sumatoria(2,'1','2','3','4','5') ;
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
 
        
    }
    //----tramites_grupo
    public function reformas_unidad(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        $sql = "SELECT c.nombre,
					   a.grupo || ' ' || b.detalle as detalle,
                        sum(a.aumento) as aumento,
                        sum(a.disminuye) as disminuye,
                        sum(a.aumento) - sum(a.disminuye)  as reforma
                FROM presupuesto.view_reforma_detalle a, 
                     presupuesto.pre_catalogo b,
                     nom_departamento c
                where a.anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                      a.estado =  'aprobado'  and b.codigo = a.titulo and
                      b.categoria= 'clasificador' and
                      c.id_departamento = a.id_departamento
                group by c.nombre,a.grupo,b.detalle
                order by 1 ";
        
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Unidad Solicita,Grupo, Aumento,Disminuye,Reforma";
        
        $evento   = "";
        
        $this->obj->table->KP_sumatoria(3,'2','3','4','') ;
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //----------------------------------------
    public function reformas_grupo(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $inicial = "( SELECT  sum(x.inicial)
                     FROM presupuesto.pre_gestion x
                    where x.grupo = a.grupo and x.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as inicial,";
        
        
        $codificado = "( SELECT  sum(y.codificado)
                     FROM presupuesto.pre_gestion y
                    where y.grupo = a.grupo and y.anio=". $this->bd->sqlvalue_inyeccion($anio,true).") as codificado";
        
        
        $sql = "SELECT  a.grupo || ' ' || b.detalle as detalle,".$inicial."
                        sum(a.aumento) as aumento,
                        sum(a.disminuye) as disminuye,
                        sum(a.aumento) - sum(a.disminuye) as reforma,".$codificado."
                FROM presupuesto.view_reforma_detalle a, presupuesto.pre_catalogo b
                where a.anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                      a.estado =  'aprobado'  and b.codigo = a.grupo and
                      b.categoria= 'clasificador'
                group by a.grupo,b.detalle
                order by 1";
        
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Grupo,Inicial,Aumento,Disminuye,Reforma,Codificado";
        
        $evento   = "";
        
        $this->obj->table->KP_sumatoria(2,'1','2','3','4','5') ;
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
 //-----------------------
    public function tramites_unidades(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        $sql = "SELECT  unidad, count(*) || ' '  as tramites,
                        sum(monto_certifica) as monto_certifica,
                        sum(monto_compromiso) as monto_compromiso
                FROM presupuesto.view_pre_tramite
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by unidad
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->KP_sumatoria(2,'1','2','3','') ;
        
        $cabecera =  "Unidades Administrativas,Nro Tramites,Certificacion,Compromiso";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
 //-------------------------------------------------------------
    function _catalogo($codigo){
        
        $AResultado = $this->bd->query_array('presupuesto.pre_catalogo',
            'codigo, detalle', "tipo='arbol' and codigo=".$this->bd->sqlvalue_inyeccion($codigo,true));
        
        
        $dato = trim($AResultado['codigo']).' '.trim($AResultado['detalle']);
        
        return     $dato;
        
        
    }
 //------------($resultado,$tipo,"G","jtabla_gastos");
    
    function titulo_gasto($fanio,$tipo,$cmes )  {
        
        
        $sql = "SELECT titulo,sum(inicial) as inicial, 
                	   SUM(aumento) - SUM(disminuye) as reformas, 
                	   sum(codificado) as codificado, sum(certificado) as certificado, 
                	   sum(compromiso) as compromiso, 
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by titulo order by titulo";


        $resultado  = $this->bd->ejecutar($sql);
     
       $k = 0;
       
       $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        
       echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';        
           echo '<th width="19%" '.  $estilo. '>Detalle</th>';
           echo '<th width="9%" '.  $estilo. '>Inicial</th>';
           echo '<th width="9%" '.  $estilo. '>Reformas</th>';
           echo '<th width="9%" '.  $estilo. '>Codificado</th>';
           echo '<th width="9%" '.  $estilo. '>Compromiso</th>';
           echo '<th width="9%" '.  $estilo. '>Devengado</th>';
           echo '<th width="9%" '.  $estilo. '>Pagado</th>';
           echo '<th width="9%" '.  $estilo. '>Por Comprometer</th>';
           echo '<th width="9%" '.  $estilo. '>Por Devengar</th>';
           echo '<th width="9%" '.  $estilo. '>Ejecutado</th>';
           
        echo '</tr></thead><tbody>';
 
                $nsuma1 = 0;
                $nsuma2 = 0;
                $nsuma3 = 0;
                $nsuma4 = 0;
                $nsuma5 = 0;
                $nsuma6 = 0;
                $nsuma7 = 0;
               
                $nsuma8 = 0;
                $nsuma9 = 0;
                
                 
                $k = 1;
                while($row=pg_fetch_assoc($resultado)) {
                    
                    $catalogo = $this->_catalogo(trim($row['titulo'])) ;
                    
                    echo "<tr>";
    
                    echo "<td>".trim($catalogo).'</td>';
                    
                    if ( $row['codificado'] <= 0 ) {
                        $porcentaje = '0';
                    }else {
                        $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
                    }
                    
                    $porcentaje = round($porcentaje,2);
                    
                    if ( $porcentaje < 75) {
                        $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
                    }elseif ($porcentaje > 75 && $porcentaje < 90){
                        $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
                    }elseif ($porcentaje > 90 ){
                        $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
                    }
                        
                    $c1 = $row["codificado"] - $row['compromiso'];
                    $c2 = $row["codificado"] - $row['devengado'];
     
                    $xx =  $porcentaje .' %';
                        
                    echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
                    echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
                    echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
                    echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
                    echo "<td align='right'>".number_format($c1,2).'</td>';
                    echo "<td align='right'>".number_format($c2,2).'</td>';
                    echo "<td align='center'>".$xx.$cimagen.'</td>';
                 
  
                     
                    $nsuma1 = $nsuma1 + $row["inicial"];
                    $nsuma2 = $nsuma2 + $row["reformas"];
                    $nsuma3 = $nsuma3 + $row["codificado"];
                    $nsuma4 = $nsuma4 + $row["compromiso"];
                    $nsuma5 = $nsuma5 + $row["devengado"];
                    $nsuma7 = $nsuma7 + $row["pagado"];
                    $nsuma8 = $nsuma8 + $c1;
                    $nsuma9 = $nsuma9 + $c2;
                  
 
                    $k++;
                     echo "</tr>";
                    
                }
                /// total
                
                if ( $nsuma3 <= 0 ) {
                    $porcentaje = '0';
                }else {
                    $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
                }
                
                //----------------------------
                if ( $porcentaje < 75) {
                    $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
                }elseif ($porcentaje > 75 && $porcentaje < 90){
                    $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
                }elseif ($porcentaje > 90 ){
                    $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
                }
                
              
                echo "<tr>";
                     echo "<td></td>";
                     echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
                     echo '<td align="center"><b>'.$cimagen.' </b></td>';
                 
                
                echo "</tr></tbody></table>";
                
                pg_free_result ($resultado) ;
            
    }
   //-----------------
    function titulo_gasto_grupos($fanio,$tipo,$cmes )  {
        
        
        $sql = "SELECT grupo,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by grupo order by grupo";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="19%" '.$estilo.'>Detalle</th>';
        echo '<th width="9%"  '.$estilo.'>Inicial</th>';
        echo '<th width="9%" '.$estilo.'>Reformas</th>';
        echo '<th width="9%"  '.$estilo.'>Codificado</th>';
        echo '<th width="9%"  '.$estilo.'>Compromiso</th>';
        echo '<th width="9%"  '.$estilo.'>Devengado</th>';
        echo '<th width="9%"  '.$estilo.'>Pagado</th>';
        echo '<th width="9%"  '.$estilo.'>Por Comprometer</th>';
        echo '<th width="9%"  '.$estilo.'>Por Devengar</th>';
        echo '<th width="9%"  '.$estilo.'>Ejecutado</th>';
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
        $nsuma4 = 0;
        $nsuma5 = 0;
        $nsuma6 = 0;
        $nsuma7 = 0;
        
        $nsuma8 = 0;
        $nsuma9 = 0;
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo(trim($row['grupo'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
            if ( $row['codificado'] <= 0 ) {
                $porcentaje = '0';
            }else {
                $porcentaje =  $row["devengado"] / $row["codificado"]  * 100;
            }
            
            $porcentaje = round($porcentaje,2);
            
            if ( $porcentaje < 75) {
                $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 75 && $porcentaje < 90){
                $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
            }elseif ($porcentaje > 90 ){
                $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
            }
            
            $c1 = $row["codificado"] - $row['compromiso'];
            $c2 = $row["codificado"] - $row['devengado'];
            
            $xx =  $porcentaje .' %';
            
            echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
            echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
            echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
            echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
            echo "<td align='right'>".number_format($c1,2).'</td>';
            echo "<td align='right'>".number_format($c2,2).'</td>';
            echo "<td align='center'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row["inicial"];
            $nsuma2 = $nsuma2 + $row["reformas"];
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma4 = $nsuma4 + $row["compromiso"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";
            
        }
        /// total
        
        if ( $nsuma3 <= 0 ) {
            $porcentaje = '0';
        }else {
            $porcentaje = round(($nsuma6 / $nsuma3),2) * 100;
        }
        
        //----------------------------
        if ( $porcentaje < 75) {
            $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 75 && $porcentaje < 90){
            $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
        }elseif ($porcentaje > 90 ){
            $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
        }
        
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma9,2).'</b></td>';
        echo '<td align="center"><b>'.$cimagen.' </b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
   //---------------------------------------
   
    
    function grilla_ingreso_reporte($resultado,$tipo,$presupuesto,$nombre,$cmes)  {
        
        
        $numero_campos = pg_num_fields($resultado) - 1;
        $k = 0;
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        for ($i = 0; $i<= $numero_campos; $i++){
            $cabecera = pg_field_name($resultado,$k) ;
            
            echo "<th ".$estilo.">".$cabecera.'</th>';
            $k++;
        }
        
        echo '</tr></thead><tbody>';
        
        $nsuma1 = 0;
        $nsuma2 = 0;
        $nsuma3 = 0;
         $nsuma6 = 0;
        $nsuma7 = 0;
        $nsuma8 = 0;
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            echo "<tr>";
            
            $i = 1;
            
            foreach ($row as $item){
                /*   $n1 = $row[$this->var1];
                 $n2 = $row[$this->var2];
                 $n3 = $row[$this->var3];
                 */
                if(is_numeric($item)){
                    
                    if ($i == 1)  {
                        
                        $evento = '<a href="#" onClick="Detallepartidas('."'".$item."'".','."'".$presupuesto."',".$k.')" data-toggle="modal" data-target="#myModalAux">';
                        
                        echo "<td>".$evento.$item.'</a></td>';
                        
                    }else{
                        
                        echo "<td align='right'>".number_format($item,2).'</td>';
                        
                    }
                    
                }else{
                    
                    echo "<td>".$item.'</td>';
                    
                }
                $i++;
            }
            
            if ( $presupuesto == 'I'){
                $suma = $row["Recaudado"];
            }else{
                $suma = $row["Pagado"];
            }
            
            
            
            $nsuma1 = $nsuma1 + $row["Inicial"];
            $nsuma2 = $nsuma2 + $row["Reformas"];
            $nsuma3 = $nsuma3 + $row["Codificado"];
            $nsuma6 = $nsuma6 + $row["Devengado"];
            $nsuma7 = $nsuma7 + $suma;
            $nsuma8 = $nsuma8 + $row["Saldo Devengar"];
            
            
            $k++;
            /*
             $variable_url = 'action='.$editar.'&tid='.trim($row[$llave_primaria]).$tab;
             $ajax = "javascript:abrir('".$archivo_ref."','".$variable_url."')";
             echo '<a class="btn btn-xs" href="'. $ajax.'"> <i class="icon-ok icon-white"></i></a> ';
             */
            echo "</tr>";
            
        }
        /// total
        
        echo "<tr>";
        echo "<td>TOTAL</td><td></td>";
        echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma6,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma8,2).'</b></td>';
        
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    //--------------------------------
    function _catalogo_funcion($codigo){
        
        $AResultado = $this->bd->query_array('presupuesto.pre_catalogo',
            'codigo, detalle', "codigo=".$this->bd->sqlvalue_inyeccion($codigo,true));
        
        
        $dato = trim($AResultado['detalle']);
        
        return     $dato;
        
        
    }
    //--------------------------------------------------
    function titulo($anio,$cmes){
        
        
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->login     =  trim($_SESSION['login']);
        
  
        $titulo = $anio.'-'.$cmes;
        
        
        $imagen = '<img src="../../kimages/'.trim($_SESSION['logo']).'" width="170" height="80">';
        
        $imagen = '';
        
        echo '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px;table-layout: auto">
              <tr>
                  <td width="20%" rowspan="2">'.$imagen.'</td>
                  <td  width="60%" rowspan="2" style="text-align: center"><b>'.$_SESSION['razon'].'</b><br>
                        <b>'.$_SESSION['ruc_registro'].'</b><br><br>
                        <b>PRESUPUESTO ( PERIODO '.$titulo.' ) </b><br>
                        <b>GESTION FINANCIERA AL PERIODO '.$tipo_presupuesto.' </b></td>
                  <td  width="20%">&nbsp;</td>
                </tr>
                <tr>
                  <td>FECHA '.$this->hoy .'<br>
                     USUARIO '.$this->login.' <br>
                     REPORTE</td>
                </tr>
 	   </table>';
 
        
    }
    
    
    function firmas( ){
        
   

        $codigo_reporte ='PR-CP';
        
		$reporte_pie   = $this->bd->query_array('par_reporte', 'pie', 'referencia='.$this->bd->sqlvalue_inyeccion( trim($codigo_reporte) ,true) );
	
        $pie_contenido = $reporte_pie["pie"];
    
        // NOMBRE / CARGO
        $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
        $pie_contenido = str_replace('#AUTORIDAD',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_AUTORIDAD',trim($a10['carpetasub']), $pie_contenido);
        
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
        $pie_contenido = str_replace('#FINANCIERO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_FINANCIERO',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
         $pie_contenido = str_replace('#CONTADOR',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_CONTADOR',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(13,true));
         $pie_contenido = str_replace('#TESORERO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_TESORERO',trim($a10['carpetasub']), $pie_contenido);
    
         $a10 = $this->bd->query_array('wk_config','carpeta , carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
         $pie_contenido = str_replace('#PRESUPUESTO',trim($a10['carpeta']), $pie_contenido);
         $pie_contenido = str_replace('#CARGO_PRESUPUESTO',trim($a10['carpetasub']), $pie_contenido);
            
            //------------- llama a la tabla de parametros ---------------------//
    
            $usuarios = $this->bd->__user($this->sesion); // nombre del usuario actual
    
            $sesion   = ucwords(strtolower($usuarios['completo']));  
      
     
            $pie_contenido = str_replace('#SESION',$sesion, $pie_contenido);
            
            echo $pie_contenido ;
        
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
    $tipo       =   $_GET["tipo"];
    $cmes     =    $_GET["cmes"];
    
    $gestion->GrillaGasto( $fanio,$tipo,$cmes);
        
        
        
      
}
?>

 