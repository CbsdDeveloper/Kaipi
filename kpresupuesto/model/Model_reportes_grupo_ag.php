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
    
    
     
    //---------------------------------
    function GrillaGasto( $fanio,$tipo,$cmes ){
        
        
        
        $this->titulo($fanio,$cmes);
        
        $this->set->div_label(12,'<b>RESUMEN DE GESTION FINANCIERA</b>');
        
         
        $this->set->div_panel12('<b> GESTION PRESUPUESTARIA POR PERIODO '.$fanio.'-'.$cmes.' </b>');
        
                    $this->titulo_gasto( $fanio,$tipo,$cmes );
        
        $this->set->div_panel12('fin');

 
        
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
                where tipo= ".$this->bd->sqlvalue_inyeccion($tipo,true)." and 
                      anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by titulo order by titulo";


        $resultado  = $this->bd->ejecutar($sql);
     
       $k = 0;

       if ( $tipo == 'I'){
            $titulo_tipo = 'Recaudado';
        } else   {
            $titulo_tipo = 'Pagado';
        }
       
       $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        
       echo '<table class="table table-bordered table-hover table-tabletools" border="0" width="100%">
        <thead> <tr>';        
           echo '<th width="19%" '.  $estilo. '>Detalle</th>';
           echo '<th width="9%" '.  $estilo. '>Inicial</th>';
           echo '<th width="9%" '.  $estilo. '>Reformas</th>';
           echo '<th width="9%" '.  $estilo. '>Codificado</th>';
           echo '<th width="9%" '.  $estilo. '>Compromiso</th>';
           echo '<th width="9%" '.  $estilo. '>Devengado</th>';
           echo '<th width="9%" '.  $estilo. '>'. $titulo_tipo.'</th>';
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
                    
                    $titulo = $row["titulo"] ;

                    echo "<tr>";
    
                    echo "<td><b>".trim($catalogo).'</b></td>';
                    
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

                    echo '<tr>
                     <td colspan="10">';
                     $this->titulo_gasto_grupos($fanio,$tipo,$cmes,$titulo ) ;
                     echo '</td>
                     </tr>'; 
                    
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
    function titulo_gasto_grupos($fanio,$tipo,$cmes,$titulo)  {
        
        
        $sql_det = "SELECT grupo,sum(inicial) as inicial,
                	   SUM(aumento) - SUM(disminuye) as reformas,
                	   sum(codificado) as codificado, sum(certificado) as certificado,
                	   sum(compromiso) as compromiso,
                	   sum(devengado) as devengado,
                       sum(pagado) as pagado
                FROM presupuesto.view_pre_gestion_periodo
                where tipo=  ".$this->bd->sqlvalue_inyeccion($tipo,true)." and 
                      titulo =  ".$this->bd->sqlvalue_inyeccion($titulo,true)." and
                      anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
                group by grupo order by grupo";
        
        
        $resultado_det  = $this->bd->ejecutar($sql_det);
        
        $k = 0;
        
        
 
        echo '<table class="table table-hover table-tabletools" border="0" width="100%">';
        echo '<tbody>';
        
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

      

        while($row_det=pg_fetch_assoc($resultado_det)) {
            
            $catalogo = $this->_catalogo(trim($row_det['grupo'])) ;
            
            echo "<tr>";
            echo "<td  width='19%'>".trim($catalogo).'</td>';


            $item = trim($row_det['grupo']);
            
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
            
            $c1 = $row_det["codificado"] - $row_det['compromiso'];
            $c2 = $row_det["codificado"] - $row_det['devengado'];
            
            $xx = '';
            
            echo "<td align='right' width='9%'>".number_format($row_det['inicial'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($row_det['reformas'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($row_det['codificado'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($row_det['compromiso'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($row_det['devengado'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($row_det['pagado'],2).'</td>';
            echo "<td align='right' width='9%'>".number_format($c1,2).'</td>';
            echo "<td align='right' width='9%'>".number_format($c2,2).'</td>';
            echo "<td align='center' width='9%'>".$xx.$cimagen.'</td>';
            
            
            
            $nsuma1 = $nsuma1 + $row_det["inicial"];
            $nsuma2 = $nsuma2 + $row_det["reformas"];
            $nsuma3 = $nsuma3 + $row_det["codificado"];
            $nsuma4 = $nsuma4 + $row_det["compromiso"];
            $nsuma5 = $nsuma5 + $row_det["devengado"];
            $nsuma7 = $nsuma7 + $row_det["pagado"];
            $nsuma8 = $nsuma8 + $c1;
            $nsuma9 = $nsuma9 + $c2;
            
            
            $k++;
            echo "</tr>";


            echo '<tr>
            <td colspan="10">';
            $this->titulo_gasto_item($fanio,$tipo,$cmes,$item ) ;
            echo '</td>
            </tr>'; 
            
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
        
        pg_free_result ($resultado_det) ;
        
    }
   //---------------------------------------
   function titulo_gasto_item($fanio,$tipo,$cmes,$item)  {
        
        
    $sql_item = "SELECT item,sum(inicial) as inicial,
                   SUM(aumento) - SUM(disminuye) as reformas,
                   sum(codificado) as codificado, sum(certificado) as certificado,
                   sum(compromiso) as compromiso,
                   sum(devengado) as devengado,
                   sum(pagado) as pagado
            FROM presupuesto.view_pre_gestion_periodo
            where tipo= ".$this->bd->sqlvalue_inyeccion($tipo,true)." and 
                  grupo =  ".$this->bd->sqlvalue_inyeccion($item,true)." and
                  anio = ".$this->bd->sqlvalue_inyeccion($fanio,true)."
            group by item order by item";
    
    
    $resultado_item  = $this->bd->ejecutar($sql_item);
    
    $k = 0;
    
    
 
    echo '<table class="table table-bordered" border="0" width="100%">';
    echo '<tbody>';
    
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

  

    while($row_item=pg_fetch_assoc($resultado_item)) {
        
        $catalogo = $this->_catalogo(trim($row_item['item'])) ;
        
        echo "<tr>";
        echo "<td  width='19%'>".trim($catalogo).'</td>';
        
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
        
        $c1 = $row_item["codificado"] - $row_item['compromiso'];
        $c2 = $row_item["codificado"] - $row_item['devengado'];
        
        $xx =  '';
        
        echo "<td align='right' width='9%'>".number_format($row_item['inicial'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($row_item['reformas'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($row_item['codificado'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($row_item['compromiso'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($row_item['devengado'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($row_item['pagado'],2).'</td>';
        echo "<td align='right' width='9%'>".number_format($c1,2).'</td>';
        echo "<td align='right' width='9%'>".number_format($c2,2).'</td>';
        echo "<td align='center' width='9%'>".$xx.$cimagen.'</td>';
        
        
        
        $nsuma1 = $nsuma1 + $row_item["inicial"];
        $nsuma2 = $nsuma2 + $row_item["reformas"];
        $nsuma3 = $nsuma3 + $row_item["codificado"];
        $nsuma4 = $nsuma4 + $row_item["compromiso"];
        $nsuma5 = $nsuma5 + $row_item["devengado"];
        $nsuma7 = $nsuma7 + $row_item["pagado"];
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
    
    pg_free_result ($resultado_item) ;
    
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
        
  
        $a11 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(10,true));
        
        $a12 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(12,true));
        
        $a14 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(14,true));
        
        $a15 = $this->bd->query_array('wk_config','carpeta, carpetasub', 'tipo='.$this->bd->sqlvalue_inyeccion(15,true));
        
        
        $datos["g10"] = $a11["carpeta"];
        $datos["g11"] = $a11["carpetasub"];
        
        
        $datos["f10"] = $a12["carpeta"];
        $datos["f11"] = $a12["carpetasub"];
        
        
        $datos["c10"] = $a14["carpeta"];
        $datos["c11"] = $a14["carpetasub"];
        
        $datos["c10"] = $a14["carpeta"];
        $datos["c11"] = $a14["carpetasub"];
        
        $datos["a10"] = $a15["carpeta"];
        $datos["a11"] = $a15["carpetasub"];
        
        
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:10px"> ';
        
        echo '	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        	<tbody>
        	<tr>
        	  <td width="25%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="25%" style="text-align: center;padding: 15px">&nbsp;</td>
        	<td width="25%" style="text-align: center">&nbsp;</td>
        	<td width="25%" style="text-align: center">&nbsp;</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g10"].'</td>
        	<td style="text-align: center">'. $datos["f10"].'</td>
        	<td style="text-align: center">'. $datos["c10"].'</td>
        	<td style="text-align: center">'. $datos["a10"].'</td>
        	</tr>
        	<tr>
        	  <td style="text-align: center">'. $datos["g11"].'</td>
        	  <td style="text-align: center">'.$datos["f11"].'</td>
        	  <td style="text-align: center">'.$datos["c11"] .'</td>
        	  <td style="text-align: center">'.$datos["a11"] .'</td>
      	  </tr>
         
        	</tbody>
        	</table>';
        
        echo '</div> ';
        
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

 