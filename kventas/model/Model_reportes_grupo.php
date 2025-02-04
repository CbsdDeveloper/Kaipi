<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kpresupuesto/model/Model_saldos.php';  

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
    
   
    
    //---------------------------------
     
    //-------------------------------------------------
    function titulo_tthh( $fanio,$tipo,$cmes ){
        
        
        
        
        $sql = "SELECT funcion,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_pagos
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)." and grupo in ('51','71')
                group by funcion order by funcion";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        
        echo '<table class="table table-bordered table-condensed table-hover" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="60%">Detalle</th>';
        echo '<th width="10%">Codificado</th>';
        echo '<th width="10%">Devengado</th>';
        echo '<th width="10%">Pagado</th>';
         
        echo '</tr></thead><tbody>';
        
          $nsuma3 = 0;
         $nsuma5 = 0;
         $nsuma7 = 0;
        
 
        
        
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
            
       
             echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
             echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
             
 
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
 
            
            
            $k++;
            echo "</tr>";
            
        }
      
        
        echo "<tr>";
        echo "<td></td>";
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
         
        
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
            FROM presupuesto.view_pre_gestion_pagos
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
            FROM presupuesto.view_pre_gestion_pagos
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
        
        echo utf8_encode( '<h5>El Presupuesto inicial del peri�do <b>'.$fanio.'</b> es de $ <b>'.number_format($inicial,2).
            ' </b> d�lares; el porcentaje (%) de variaci�n entre el monto inicial y codificado es del <b>'.$pp1.' </b>%<br><br>'.'
          El porcentaje(%) de ejecucion de gasto correspondiente al periodo es del <b>'.$porcentaje.' </b>% '.$cimagen.' acontinuaci�n se detalle los tramites emitidos por la unidad financiera</h5>');
        
        
    }
    //-----------------
 
    
    //---------------------------------
    function GrillaGasto( $fanio,$tipo,$cmes ){
        
        $fecha = $fanio.'-'.$cmes.'-' .'01';
        
       
        
        $f2 = $this->bd->_ultimo_dia($fecha);
        
   
        
       /* 
        if ( $cmes == '2'){
            $dia = 28;
            $cmes = '02';
        }
        if ( $cmes == '02'){
            $dia = 28;
            $cmes = '02';
        }
        
         $f2 = $this->anio.'-'.$cmes.'-' .$dia;
        */
        
 
        $this->saldos->PresupuestoPeriodo_pagos($fecha,$f2);
        
        $this->set->div_panel6('<b> ENLACE CONTABLE - PRESUPUESTARIO PAGOS '.$fanio.'-'.$cmes.' </b>');
        
        $this->titulo_gasto_grupos( $fanio,$tipo,$cmes );
        
        $this->set->div_panel6('fin');
        
 
       
        
        $this->set->div_panel6('<b> GESTION PAGOS POR  PROGRAMA - PERSONAL '.$fanio.'-'.$cmes.' </b> ( Grupo 51-71 )');
        
        $this->titulo_tthh( $fanio,$tipo,$cmes );
        
        $this->set->div_panel6('fin');
        
         
        
    }
    //--------------------
      
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
                FROM presupuesto.view_pre_gestion_pagos
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by titulo order by titulo";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="70%">Detalle</th>';
        echo '<th width="10%">Codificado</th>';
        echo '<th width="10%">Pagado</th>';
        echo '<th width="10%">%</th>';
        
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
            
             echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
             echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
             echo "<td align='center'>".$cimagen.'</td>';
            
            
            
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
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
         echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
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
                FROM presupuesto.view_pre_gestion_pagos
                where tipo= 'G' and anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by grupo order by grupo";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $k = 0;
        
        
        echo '<table class="table table-bordered table-condensed table-hover" border="0" width="100%">
        <thead> <tr>';
        echo '<th width="60%">Grupo</th>';
         echo '<th width="10%">Codificado</th>';
         echo '<th width="10%">Devengado</th>';
        echo '<th width="10%">Pagado</th>';
         
        echo '</tr></thead><tbody>';
        
         $nsuma3 = 0;
         $nsuma5 = 0;
         $nsuma7 = 0;
 
        
        
        $k = 1;
        while($row=pg_fetch_assoc($resultado)) {
            
            $catalogo = $this->_catalogo(trim($row['grupo'])) ;
            
            echo "<tr>";
            
            echo "<td>".trim($catalogo).'</td>';
            
           
        
            echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
             echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
            echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
             
            
            
            $nsuma3 = $nsuma3 + $row["codificado"];
            $nsuma5 = $nsuma5 + $row["devengado"];
            $nsuma7 = $nsuma7 + $row["pagado"];
 
             
            $k++;
            echo "</tr>";
            
        }
      
            
        
        echo "<tr>";
        echo "<td></td>";
 
        echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
        echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
         
        
        echo "</tr></tbody></table>";
        
        pg_free_result ($resultado) ;
        
    }
    //---------------------------------------
     
    //--------------------------------
    function _catalogo_funcion($codigo){
        
        $AResultado = $this->bd->query_array('presupuesto.pre_catalogo',
            'codigo, detalle', "codigo=".$this->bd->sqlvalue_inyeccion($codigo,true));
        
        
        $dato = trim($AResultado['detalle']);
        
        return     $dato;
        
        
    }
    //--------------------------------------------------
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
/*
$gestion   = 	new proceso;



//------ grud de datos insercion
if (isset($_GET["tipo"]))	{
    

    $fanio		=   $_GET["fanio"];
    $tipo       =   $_GET["tipo"];
    $cmes       =    $_GET["cmes"];
    
 $gestion->GrillaGasto( $fanio,$tipo,$cmes);
    
   
    
}
 */
    
?>

 