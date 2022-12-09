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
    function GrillaIngreso($fanio,$vfuente,$vgrupo,$tipo,$cmes){
        
         $tipo 		    = $this->bd->retorna_tipo();
         
         
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
         
          
         if  ( $cmes == '-')  {
             
             $sql = 'SELECT partida as "Partida",
                   detalle as "Partida Ingreso",
            	   inicial as "Inicial",
            	   aumento - disminuye as "Reformas",
            	   codificado as "Codificado",
            	   devengado as "Devengado",
            	   pagado as "Recaudado",
            	   (coalesce(codificado,0) - coalesce(devengado,0))  as "Saldo Devengar"
             FROM presupuesto.pre_gestion
            where tipo = '. $this->bd->sqlvalue_inyeccion('I' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .$fuente_where.$vgrupo_where.'  order by partida,fuente';
             
         }else {
             
             $fecha = $this->anio.'-'.$cmes.'-' .'01';
             $dia = $this->bd->_ultimo_dia($fecha);
             $f2 = $this->anio.'-'.$cmes.'-' .$dia;
             //---- calculo de periodos de saldos
             $this->saldos->PresupuestoPeriodo_ingreso($f2);
             
             
             $sql = 'SELECT partida as "Partida",
                   detalle as "Partida Ingreso",
            	   inicial as "Inicial",
            	   aumento - disminuye as "Reformas",
            	   codificado as "Codificado",
            	   devengado as "Devengado",
            	   pagado as "Recaudado",
            	   (coalesce(codificado,0) - coalesce(devengado,0))  as "Saldo Devengar"
             FROM presupuesto.view_pre_gestion_periodo
            where tipo = '. $this->bd->sqlvalue_inyeccion('I' , true).' and
                  anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .$fuente_where.$vgrupo_where.'  order by partida,fuente';
             
             
         }
         
      
   
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        $this->titulo('INGRESOS',$cmes);
        
        echo '</div> ';
        
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
        
        $this->grilla_ingreso_reporte($resultado,$tipo,"I","jtabla_ingreso",$cmes);
        
        echo '</div> ';
       
        
        $this->firmas( );
 
     

    }
    //---------------------------------
    function GrillaGasto_periodo( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion,$cmes){
        
        $fecha = $this->anio.'-'.$cmes.'-' .'01';
         
        $dia = $this->bd->_ultimo_dia($fecha);
        
        $f2 = $this->anio.'-'.$cmes.'-' .$dia;
 
        //---- calculo de periodos de saldos
        
       $this->saldos->PresupuestoPeriodo_gasto($f2);
        
       if ( $funcion == '0'){
           
           $this->programa_lista(   $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion,$cmes );
           
       }else {
           
           $this->GrillaGasto_periodo_uno( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion,$cmes);
       }
       
        
        
        
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
    //------------------------------------------------------
    function GrillaGasto_periodo_programa( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion,$cmes){
        
        
        
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
                  
                   
 
                  $this->grilla($resultado,$tipo,"G","jtabla_gasto1");
                  
             
                  
                  
                  
                  
                  
    }
    //---------------------------------
    function GrillaGasto( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$funcion){
                         
                         
        
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
        
 
   
        $sql = 'SELECT partida  ,
                   detalle  ,
            	   inicial  ,
            	   aumento - disminuye as reformas,
            	   codificado ,
            	   certificado ,
            	   compromiso ,
            	   devengado ,
            	   pagado ,
            	   ((devengado / codificado) * 100) as ejecutado
            FROM presupuesto.pre_gestion
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
         
         $this->titulo('GASTOS','');
         
         echo '</div> ';
         
         echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
         
        $this->grilla($resultado,$tipo,"G","jtabla_gasto");
        
        echo '</div> ';
        
        $this->firmas( );
      
        
      
     
        
    }
 //-------------------------------------------------------------
    //------------($resultado,$tipo,"G","jtabla_gastos");
    
 function grilla($resultado,$tipo,$presupuesto,$nombre)  {
        

     
       $k = 0;
       
        
       echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
           echo '<th width="15%">Partida</th>';
           echo '<th width="31%">Detalle</th>';
           echo '<th width="7%">Inicial</th>';
           echo '<th width="7%">Reformas</th>';
           echo '<th width="7%">Codificado</th>';
           echo '<th width="7%">Certificado</th>';
           echo '<th width="7%">Compromiso</th>';
           echo '<th width="7%">Devengado</th>';
           echo '<th width="7%">Pagado</th>';
           echo '<th width="5%">Ejecutado</th>';
           
        echo '</tr></thead><tbody>';
 
                $nsuma1 = 0;
                $nsuma2 = 0;
                $nsuma3 = 0;
                $nsuma4 = 0;
                $nsuma5 = 0;
                $nsuma6 = 0;
                $nsuma7 = 0;
               
                 
                $k = 1;
                while($row=pg_fetch_assoc($resultado)) {
                    
                    echo "<tr>";
                    $item = trim($row['partida']);
                    $evento = '<a href="#" onClick="Detallepartidas('."'".$item."'".','."'".$presupuesto."',".$k.')" data-toggle="modal" data-target="#myModalAux">';
                    
                    echo "<td>".$evento.$item.'</a></td>';
                    
                    echo "<td>".trim($row['detalle']).'</a></td>';
                    
                    if ( $row['codificado'] <= 0 ) {
                        $porcentaje = '0';
                    }else {
                        $porcentaje = round(($row["devengado"] / $row["codificado"]),2) * 100;
                    }
                    
 
                    
                    if ( $porcentaje < 75) {
                        $cimagen ='<img src="../../kimages/m_none.png" title="'.$porcentaje.' %'.'"/>';
                    }elseif ($porcentaje > 75 && $porcentaje < 90){
                        $cimagen ='<img src="../../kimages/m_amarillo.png" title="'.$porcentaje.' %'.'"/>';
                    }elseif ($porcentaje > 90 ){
                        $cimagen ='<img src="../../kimages/m_verde.png" title="'.$porcentaje.' %'.'"/>';
                    }
                        
     
                    
                    echo "<td align='right'>".number_format($row['inicial'],2).'</td>';
                    echo "<td align='right'>".number_format($row['reformas'],2).'</td>';
                    echo "<td align='right'>".number_format($row['codificado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['certificado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
                    echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['pagado'],2).'</td>';
                    echo "<td align='center'>".$cimagen.'</td>';
                 
      
                    $suma = $row["pagado"];
                     
                    $nsuma1 = $nsuma1 + $row["inicial"];
                    $nsuma2 = $nsuma2 + $row["reformas"];
                    $nsuma3 = $nsuma3 + $row["codificado"];
                    $nsuma4 = $nsuma4 + $row["certificado"];
                    $nsuma5 = $nsuma5 + $row["compromiso"];
                    $nsuma6 = $nsuma6 + $row["devengado"];
                    $nsuma7 = $nsuma7 + $suma;
                  
                  
 
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
                     echo "<td>TOTAL</td><td></td>";
                     echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma4,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma5,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma6,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma7,2).'</b></td>';
                     echo '<td align="center"><b>'.$cimagen.' </b></td>';
                 
                
                echo "</tr></tbody></table>";
                
                pg_free_result ($resultado) ;
            
    }
    
    
    function grilla_ingreso_reporte($resultado,$tipo,$presupuesto,$nombre,$cmes)  {
        
        
        $numero_campos = pg_num_fields($resultado) - 1;
        $k = 0;
        
        
        echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
        for ($i = 0; $i<= $numero_campos; $i++){
            $cabecera = pg_field_name($resultado,$k) ;
            
            echo "<th>".$cabecera.'</th>';
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
    function programa_lista(  $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$d,$cmes){
        
        
 
        
        echo '<div class="col-md-12" align="center" style="padding-bottom:10;padding-top:15px"> ';
        
        $this->titulo('GASTOS',$cmes);
        
        echo '</div> ';
        
        echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px"> ';
 
        
        $sql = 'SELECT   anio, funcion,    nombre_programa
            FROM presupuesto.view_gasto_programa
            where   anio = '. $this->bd->sqlvalue_inyeccion($fanio , true) .'  order by funcion';
                  
        $resultado1  = $this->bd->ejecutar($sql);
        
       echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>';
         
        while($x=pg_fetch_assoc($resultado1)) {
            
            $detalle    = trim($x['nombre_programa']);
            $programa = trim($x['funcion']);
            
            echo ' <tr>
                    <td width="100%" style="font-size: 12px;background-color:#F3F3F3;padding: 5px"><b>'.$detalle.'</b></td>
                    </tr><tr><td>';
            
            $this->GrillaGasto_periodo_programa( $fanio,$vfuente,$vgrupo,$vactividad,$item,$presupuesto,$programa,$cmes);
            
            echo '</td> </tr>';
        }
        
        echo ' </tbody> </table>';
        
        echo '</div> ';
        
        $this->firmas( );
        
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
if (isset($_GET["fanio"]))	{
    
    
     $fanio		=   $_GET["fanio"];
     $cmes     =    $_GET["cmes"];
   
     echo 'sdd';
  
 //          $gestion->GrillaGasto( $fanio,$vfuente,$vgrupo,$vactividad,$item,'G',$funcion);
      
        
 
 
}
?>

 