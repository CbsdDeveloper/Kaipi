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
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------  
    public function tramites(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        
        $sql = "SELECT estado || ' ' as estado, 
                    CASE
                            WHEN estado = '1' THEN 'SOLICITADO'::text
                            WHEN estado = '2' THEN 'AUTORIZADO'::text
                            WHEN estado = '3' THEN 'ANULADO'::text
                            ELSE NULL::text
                        END AS estado_tramites,
                        count(*) as nn
                    from view_nomina_vacacion
                where anio = '2022'
                group by estado";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        //$this->obj->table->KP_sumatoria(2,'1','2') ;
        
        $cabecera =  "Estado,Detalle,Nro Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
        
        
    }
    //---------------------------
    public function tramites_certificaciones_mes(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        
        $sql = "SELECT   dmes, 
                         count(*) || ' '  as tramites ,
                         sum(coalesce(monto_certifica,0)) as monto
                FROM presupuesto.view_pre_tramite
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and estado in ('3','4','5','6')
                group by dmes order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->KP_sumatoria(2,'1','2') ;
        
        $cabecera =  "Mes,Nro Tramites,Monto";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
        
        
    }
    public function tramites_unidad(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
 
      
        
        $sql = "
        SELECT  unidad,sum(dia_tomados) || ' ' as dias,
               count(*) || ' ' as nn
        from view_nomina_vacacion
       where anio = '2022' and estado = '2'
       group by unidad";

         
        $resultado  = $this->bd->ejecutar($sql);
        
       // $this->obj->table->KP_sumatoria(2,'1','2') ;
        
        $cabecera =  "Unidad,Dias tomados,Nro Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        

        
        
    }
    //---------------------------------tramites_unidades
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
        
        $this->obj->table->KP_sumatoria(2,'1','2','3') ;
        
        $cabecera =  "Unidades Administrativas,Nro Tramites,Certificacion,Compromiso";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //---------------------------------tramites_unidades
    public function tramites_motivo(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
          
        $sql = "
        SELECT  motivo,sum(dia_tomados) || ' ' as dias,
               count(*) || ' ' as nn
        from view_nomina_vacacion
       where anio = '2022' and estado = '2'
       group by motivo";

         
        $resultado  = $this->bd->ejecutar($sql);
        
       // $this->obj->table->KP_sumatoria(2,'1','2') ;
        
        $cabecera =  "Motivo,Dias tomados,Nro Tramites";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //----tramites_grupo
    public function tramites_programa(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        
        
        $sql = "SELECT  programa, count(*) || ' '  as tramites,
                        sum(certificado) as monto_certifica,
                        sum(compromiso) as monto_compromiso
                FROM presupuesto.view_dettramites
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by programa
                order by 1";
        
 
        $this->obj->table->KP_sumatoria(2,'1','2','3') ;
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Programa,Nro Partidas,Certificacion,Compromiso";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //-------------------
    public function anual_ejecucion(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        echo ' <h6> GASTO</h6>';
        
        $sql = "SELECT cfuente, devengado, round(ejecucion,2)  || ' %' as p1 
                FROM presupuesto.view_resumen_gasto
                WHERE anio = ". $this->bd->sqlvalue_inyeccion($anio,true);
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Fuente Financiamiento, Monto Ejecucion, % Ejecucion";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
        $sql = "SELECT cfuente, devengado, round(ejecucion,2)  || ' %' as p1
                FROM presupuesto.view_resumen_ingreso
                WHERE anio = ". $this->bd->sqlvalue_inyeccion($anio,true);
        
        echo ' <h6> INGRESO</h6>';
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Fuente Financiamiento, Monto Ejecucion, % Ejecucion";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
    }
    //------------
    public function producto(){
        
        $anio =  $this->anio;
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
    //------------
    public function productov(){
        
        $anio =  $this->anio;
        $mes  = date ("m");
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $AResultado = $this->bd->query_array('view_res_inv_pro_mes',
            'sum(total) as total',
            'anio='.$this->bd->sqlvalue_inyeccion($anio,true). " and
             tipo = 'F' and
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
			  WHERE tipo = 'F' AND
                    registro=".$this->bd->sqlvalue_inyeccion($this->ruc ,true). "  and
					anio = ". $this->bd->sqlvalue_inyeccion($anio,true)." and
                    mes = ". $this->bd->sqlvalue_inyeccion($mes,true)."
			ORDER BY 2 desc limit 10 offset 0";
        
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        
        
        $cabecera =  "Producto Mes Actual,Cantidad , Total, Minimo($), Maximo($),Porcentaje";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
    //------------
    public function proveeedor(){
        
        $anio =  $this->anio;
        
        
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
    
        $anio =  $this->anio;
        
        
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
    //---- 
    //-------------------------
    public function filtros_busqueda(){
        
        
        $tipo = $this->bd->retorna_tipo();
        
        $datos = array();
        
        $resultado = $this->bd->ejecutar("select 0 as codigo , '  [  01. Todas las unidades ]' as nombre union
                                            SELECT id_departamento AS codigo, unidad  as nombre
													FROM presupuesto.view_pre_tramite
                                                    where anio = ".$this->bd->sqlvalue_inyeccion($this->anio,true)."
                                                    group by  id_departamento ,unidad   ORDER BY 2 ");
        
        $this->obj->list->listadb($resultado,$tipo,'Unidad','id_departamentoc',$datos,'required','','div-2-10');
 
     
        
      
        
        
        $resultado = $this->bd->ejecutar("select '-' as codigo , '  [  02. Seleccionar partida ]' as nombre union
                                                   SELECT partida AS codigo, partida || ' ' || detalle  as nombre
													FROM presupuesto.view_dettramites
                                                    where anio = ".$this->bd->sqlvalue_inyeccion($this->anio,true)."
                                                         group by  partida,detalle   ORDER BY 2 ");
        
        $this->obj->list->listadb($resultado,$tipo,'Partida','partidac',$datos,'required','','div-2-10');
        
 
            
            
            
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------




?>
 
  