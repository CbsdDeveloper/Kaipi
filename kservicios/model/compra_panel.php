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
    private $anio;
    private $Funcionarios;
    
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
        
        
        $this->anio       =  $_SESSION['anio'];
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    
    public function genero(){
        
        $sql = "SELECT genero,count(*) as total
                    FROM  view_nomina_rol
                    where estado = 'S'
                    group by genero";
        
        
        /*Ejecutamos la query*/
        $stmt = $this->bd->ejecutar($sql);
        /*Realizamos un bucle para ir obteniendo los resultados*/
        
        $mas =0;
        $fem =0;
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
            $genero 	 =  trim($x['genero']);
            $total 	 =  $x['total'] ;
            
            if ($genero == 'M' ){
                $mas = $mas + $total;
            }else{
                $fem = $fem + $total;
            }
            
        }
        
        $datos['hombre'] = $mas;
        $datos['mujer'] = $fem;
        
        $this->Funcionarios = $mas + $fem;
        
        return $datos;
        
    }
    ///----------------------------------
    public function presuesto(){
        
        $sql = "SELECT sum(codificado) as codificado,  sum(devengado) as devengado
                    FROM  presupuesto.view_grupo_gasto
                    where anio=".$this->bd->sqlvalue_inyeccion($this->anio,true);
        
        
        $stmt = $this->bd->ejecutar($sql);
        
        
        
        while ($x=$this->bd->obtener_fila($stmt)){
            
            $datos['codificado'] = $x['codificado'] ;
            $datos['devengado'] = $x['devengado'] ;
            
        }
        
        $datos['ejecutado'] =  round( $datos['devengado'] / $datos['codificado'],2) .' %' ;
        
        $datos['codificado'] = number_format($datos['codificado'],2) ;
        $datos['devengado'] =  number_format($datos['devengado'],2) ;
        
        return $datos;
        
    }
    //-------------------------------------------
    public function mensual(){
        
        $anio = date ("Y");
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $AResultado = $this->bd->query_array('view_res_inv_mes',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
             registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
             tipo = 'I' "
            );
        
        
        
        $total = $AResultado['total'];
        
        $cabecera = "CASE WHEN  mes='1' THEN 'Enero' WHEN
                                mes='2' THEN 'Febrero' WHEN
                                mes='3' THEN 'Marzo' WHEN
                                mes='4' THEN 'Abril' WHEN
                                mes='5' THEN 'Mayo' WHEN
                                mes='6' THEN 'Junio' WHEN
                                mes='7' THEN 'Julio' WHEN
                                mes='8' THEN 'Agosto' WHEN
                                mes='9' THEN 'Septiembre' WHEN
                                mes='10' THEN 'Octubre' WHEN
                                mes='11' THEN 'Noviembre' ELSE 'Diciembre' END ";
        
        
        $sql = "SELECT ".$cabecera." as mes ,
                        cantidad,
                        media,
                        total,
                        minimo,
                        maximo,
                        round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_mes
			  WHERE tipo = 'I' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true) ;
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Mes,Cantidad,Media,Total, Minimo($),Maximo($),Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //-------------------
    public function mensualv(){
        
        $anio = date ("Y");
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        $AResultado = $this->bd->query_array('view_res_inv_mes',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
                                              registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
                                              tipo = 'F' "
            );
        
        
        
        $total = $AResultado['total'];
        
        $cabecera = "CASE WHEN  mes='1' THEN 'Enero' WHEN
                                mes='2' THEN 'Febrero' WHEN
                                mes='3' THEN 'Marzo' WHEN
                                mes='4' THEN 'Abril' WHEN
                                mes='5' THEN 'Mayo' WHEN
                                mes='6' THEN 'Junio' WHEN
                                mes='7' THEN 'Julio' WHEN
                                mes='8' THEN 'Agosto' WHEN
                                mes='9' THEN 'Septiembre' WHEN
                                mes='10' THEN 'Octubre' WHEN
                                mes='11' THEN 'Noviembre' ELSE 'Diciembre' END ";
        
        $sql = "SELECT ".$cabecera." as mes ,
                        cantidad,
                        media,
                        total,
                        minimo,
                        maximo,
                        round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_mes
			  WHERE tipo = 'F' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true);
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Mes,Cantidad,Media,Total, Minimo($),Maximo($),Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //------------
    public function producto(){
        
        $anio = date ("Y");
        $mes = date ("m");
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $AResultado = $this->bd->query_array('view_res_inv_pro_mes',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
             tipo = 'I' and
             registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
             mes=". $this->bd->sqlvalue_inyeccion($mes,true)
            );
        
        $total = $AResultado['total'];
        
        if ( empty($total)){
            $total = 1;
        }
        
        $sql = "SELECT  producto,
                         cantida,
                         total,
                         minimo,
                         maximo,
                         round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_pro_mes
			  WHERE tipo = 'I' AND
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
                    mes = ". $this->bd->sqlvalue_inyeccion($mes,true)."
			ORDER BY  2 desc limit 10";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        $cabecera =  "Producto Mes Actual,Cantidad , Total, Minimo($), Maximo($),Porcentaje";
        
        
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //--------------
    public function producto_unidad(){
        
        $anio = date ("Y");
        
        $tipo 		= $this->bd->retorna_tipo();
              
        $sql = "SELECT  unidad,
                        sum(tramites) || ' '  as cantidad
			  FROM rentas.view_ren_tramite_unidad
             where estado = 'enviado' and anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
			  group by  unidad
			ORDER BY 2";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        $cabecera =  "Solicita Unidad,Nro.Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //------------
    public function productov(){
        
        $anio = date ("Y");
        
        $tipo 		= $this->bd->retorna_tipo();
        
       
         $sql = "SELECT  servicio,
                         count(*) || ' '  as cantidad 
			  FROM rentas.view_ren_tramite_rubro
              where  anio = ".$this->bd->sqlvalue_inyeccion($anio,true)."
			  group by  servicio
			ORDER BY 2 limit 10";
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
         
        
        $cabecera =  "Servicios,Nro.Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //--------------
    public function producto_rubro(){
        
        $anio = date ("Y");
        
        $tipo 		= $this->bd->retorna_tipo();
        
       
         $sql = "  select rr.detalle ,rm.estado,count(*) || ' '  as titulos,sum(rm.total) as total
         from rentas.ren_movimiento rm , rentas.ren_rubros rr 
         where rr.id_rubro = rm.id_rubro and rm.estado = 'P'
         group by rm.id_rubro,rm.estado,rr.detalle ";
       
 
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
         
        
        $cabecera =  "Rubro,Estado,Nro.Titulos,Total";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    /*
    RECAUDACION MENSUAL
    */
    public function producto_mensual(){
        
        $anio = date ("Y");
        $cmes  = date("m");

        $mes  = intval( $cmes); 

        $tipo 		= $this->bd->retorna_tipo();
        
       
         $sql = "  select rr.detalle ,count(*) || ' '  as titulos,sum(rm.total) as total
         from rentas.view_ren_emision rm , rentas.ren_rubros rr 
         where rr.id_rubro = rm.id_rubro and 
               rm.estado = 'P' and 
               rm.mes_pago =". $this->bd->sqlvalue_inyeccion($mes,true)." and
               rm.anio_pago =". $this->bd->sqlvalue_inyeccion($anio,true)."
         group by rm.id_rubro,rm.estado,rr.detalle ";
       
        echo '<h5><b>Recaudacion Mensual '.  $fecha.' </b> </h5>';
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
         
        
        $cabecera =  "Rubro,Nro.Titulos,Total";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    /*
    REGISTRO DE RECAUDACION DIARIA
    */
    public function producto_rubro_diario(){
        
        $anio = date ("Y");
        $fecha = date("Y-m-d");
        
        $tipo 		= $this->bd->retorna_tipo();
        
       
         $sql = "  select rr.detalle ,count(*) || ' '  as titulos,sum(rm.total) as total
         from rentas.ren_movimiento rm , rentas.ren_rubros rr 
         where rr.id_rubro = rm.id_rubro and 
               rm.estado = 'P' and rm.fechap =". $this->bd->sqlvalue_inyeccion($fecha,true)."
         group by rm.id_rubro,rm.estado,rr.detalle ";
       
        echo '<h5><b>Recaudacion Diario '.  $fecha.' </b> </h5>';
        
        
         
        $resultado  = $this->bd->ejecutar($sql);
         
        
        $cabecera =  "Rubro,Nro.Titulos,Total";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //------------
    public function proveeedor(){
        
        $anio = date ("Y");
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        $AResultado = $this->bd->query_array('view_res_inv_prv',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
            registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
             tipo = 'I' "
            );
        
        
        
        $total = $AResultado['total'];
        
        
        $sql = "SELECT  razon, cantida, total,  round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_prv
			  WHERE tipo = 'I' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
			ORDER BY 2 desc limit 10 offset 0";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $cabecera =  "Proveedor Compra,Cantidad adquirida, Total, Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //-------------------------
    public function proveeedorv(){
        
        $anio = date ("Y");
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $AResultado = $this->bd->query_array('view_res_inv_prv',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
             registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
             tipo = 'F' "
            );
        
        $total = $AResultado['total'];
        
        
        $sql = "SELECT  razon,
                        cantida,
                        total,
                        round(((total / ".$total.") * 100),2) || ' %' as p1
			  FROM view_res_inv_prv
			  WHERE tipo = 'F' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
			ORDER BY 2 desc limit 10";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $cabecera =  "Cliente Ventas,Cantidad vendida, Total,Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    
    //---------------------------------------------------------------------------------------------------------------------------------------
    function _catalogo($codigo){
        
        $AResultado = $this->bd->query_array('presupuesto.pre_catalogo',
            'codigo, detalle', 'codigo='.$this->bd->sqlvalue_inyeccion($codigo,true));
        
        
        $dato = trim($AResultado['codigo']).' '.trim($AResultado['detalle']);
        
        return     $dato;
        
        
    }
    //---------------------------
   
    //---------------------------
    function _gastos(){
        
        
        
        $sql = "SELECT   grupo,  sum(codificado) as total,sum(devengado) AS devengado
                FROM presupuesto.view_grupo_gasto
                where anio =  ".$this->bd->sqlvalue_inyeccion($this->anio,true)."
                group by grupo order by 1";
        
        
        
        echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="70%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">GRUPO</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">CODIFICADO ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">EJECUTADO ($)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">INDICADOR (%)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1"></td></tr>';
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items = $this->_catalogo(trim($r['grupo'])) ;
            
            $codificado = $r['total'] ;
            $ejecutado  = $r['devengado'] ;
            
            $porcentaje = round($ejecutado / $codificado,2) * 100;
            
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" align="absmiddle" >';
            
            $title = 'title="Ejecucion '.$porcentaje.' % "';
            
            if ($porcentaje < 50){
                $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 50 && $porcentaje < 80){
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png"  '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 80 && $porcentaje < 95){
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png"  '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 95 && $porcentaje < 125){
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png"  '.$title.' align="absmiddle">';
            }
            
            echo '<tr>
              <td class="filasupe" style="font-size: 12px;padding: 3px">'.$items.'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: right">'.number_format($codificado,2) .'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: right">'.number_format($ejecutado,2) .'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: center"">'.$porcentaje.' %'.'</td>
              <td class="filasupe" style="text-align: center">'.$imagen.'</td>
            </tr>';
            
        }
        
        echo '</table>';
        
        
    }
    //--------------------------------------------
   
    function _programas(){
        
        
        
        $sql = "SELECT   nombre_programa as grupo,  sum(codificado) as total,sum(devengado) AS devengado
                FROM presupuesto.view_gasto_programa
                where anio =  ".$this->bd->sqlvalue_inyeccion($this->anio,true)."
                group by nombre_programa order by 1";
        
        
        echo '<table class="actividad">
  <tbody>
    <tr>
      <td class="derecha" width="70%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">PROGRAMA</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">CODIFICADO ($)</td>
      <td class="derecha" width="10%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">EJECUTADO ($)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1">INDICADOR (%)</td>
      <td class="derecha" width="5%" style="text-align: center;padding: 5px" bgcolor="#A5CAE1"></td></tr>';
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        while ($r=$this->bd->obtener_fila($resultado)){
            
            $items =   trim($r['grupo'])  ;
            
            $codificado = $r['total'] ;
            $ejecutado  = $r['devengado'] ;
            
            $porcentaje = round($ejecutado / $codificado,2) * 100;
            
            $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" align="absmiddle" >';
            
            $title = 'title="Ejecucion '.$porcentaje.' % "';
            
            if ($porcentaje < 50){
                $imagen = ' <img src="../../kimages/iconfinder_bullet_white_35789.png" '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 50 && $porcentaje < 80){
                $imagen = ' <img src="../../kimages/if_bullet_red_35785.png"  '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 80 && $porcentaje < 95){
                $imagen = ' <img src="../../kimages/if_bullet_yellow_35791.png"  '.$title.' align="absmiddle">';
            }elseif ($porcentaje > 95 && $porcentaje < 125){
                $imagen = ' <img src="../../kimages/if_bullet_green_35779.png"  '.$title.' align="absmiddle">';
            }
            
            echo '<tr>
              <td class="filasupe" style="font-size: 12px;padding: 3px">'.$items.'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: right">'.number_format($codificado,2) .'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: right">'.number_format($ejecutado,2) .'</td>
              <td class="filasupe" style="font-size: 12px;padding: 3px;text-align: center"">'.$porcentaje.' %'.'</td>
              <td class="filasupe" style="text-align: center">'.$imagen.'</td>
            </tr>';
            
        }
        
        echo '</table>';
        
        
    }
    
}
///------------------------------------------------------------------------

?>