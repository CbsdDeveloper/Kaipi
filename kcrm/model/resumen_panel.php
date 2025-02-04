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
    private $tramites;
    private $font;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso(   ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
       
        
        $this->font       =  '13px';
        
        // $_SESSION['anio'];
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
 
        
    }
    //-----------------------------------------------------------------------------------------------------------
    public function ResumenDatos( $canio ){
        
        $this->anio       =  $canio;  
        
        
        $x = $this->bd->query_array('flow.view_proceso_caso',                                  // TABLA
            'count(*) as total',                                     // CAMPOS
            'anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true) // CONDICION
            );
        
        $this->tramites = $x['total'];
        
        echo '<div class="col-md-12"> ';
        
                $this->tramites_tipo();
                
                $this->tramites_estados();
                
                $this->tramites_proceso();
        
        echo '</div>';
				 				
        
        echo '<div class="col-md-12">';
        
               $this->tramites_por_unidad();
               
               $this->tramites_por_mes();
        
       echo '</div>';
        
    }
    //--- busqueda de grilla primer tab 
    //-----------------------------------------------------------------------------------------------------------
    public function tramites_por_unidad(){
        
        $anio =  $this->anio;
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  unidad, count(*) || ' '  as tramites,".$p1."
                FROM flow.view_proceso_caso
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by unidad
                order by 1";
        
        
        
        echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">Unidades </div>
        <div class="panel-body">';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Unidades responsables,Nro Tramites,Indicador", $this->font );
            
            echo ' </div> </div> </div>	';
            
            
        
    }
    //---------------------------------tramites_unidades
    public function tramites_por_mes(){
        
        $anio =  $this->anio;
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT   CASE
                            WHEN mes = 1 THEN '1. Enero'::text
                            WHEN mes = 2 THEN '2. Febrero'::text
                            WHEN mes = 3 THEN '3. Marzo'::text
                            WHEN mes = 4 THEN '4. Abril'::text
                            WHEN mes = 5 THEN '5. Mayo'::text
                            WHEN mes = 6 THEN '6. Junio'::text
                            WHEN mes = 7 THEN '7. Julio'::text
                            WHEN mes = 8 THEN '8. Agosto'::text
                            WHEN mes = 9 THEN '9. Septiembre'::text
                            WHEN mes = 10 THEN '10. Octubre'::text
                            WHEN mes = 11 THEN '11. Noviembre'::text
                            WHEN mes = 12 THEN '12. Diciembre'::text
                        END AS nombre_mes,
                        count(*) || ' '  as tramites,".$p1."
                FROM flow.view_proceso_caso
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by mes
                order by 1";
        
        
        
        echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">Tramites Mensuales</div>
        <div class="panel-body">';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Tipo Procesos,Nro Tramites,Indicador", $this->font );
            
            echo ' </div> </div> </div>	';
         
    }
    //---------------------------------tramites_unidades
    public function tramites_proceso(){
        
        $anio =  $this->anio;
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  proceso, count(*) || ' '  as tramites,".$p1."
                FROM flow.view_proceso_caso
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by proceso
                order by 1";
        
        
        
        echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">Resumen por procesos </div>
        <div class="panel-body">';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Tramites Procesos,Nro Tramites,Indicador", $this->font );
            
            echo ' </div> </div> </div>	';
        
        
    }
    //----tramites_grupo
    public function tramites_tipo(){
        
        $anio =  $this->anio;
        
         
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  ambito, count(*) || ' '  as tramites,".$p1."
                FROM flow.view_proceso_caso
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by ambito
                order by 1";
        
        
        
    echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">Tipo de Tramites </div>  
        <div class="panel-body">';
 
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Tipo Procesos,Nro Tramites,Indicador", $this->font );
        
       echo ' </div> </div> </div>	';

    }
    //-------------------
    public function tramites_estados(){
        
        $anio =  $this->anio;
        
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  estado_tramite, count(*) || ' '  as tramites,".$p1."
                FROM flow.view_proceso_caso
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by estado_tramite
                order by 1";
        
        
        
        echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">Resumen por estados </div>
        <div class="panel-body">';
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Estado Procesos,Nro Tramites,Indicador", $this->font );
            
            echo ' </div> </div> </div>	';
        
    }
    //------------
    public function tramites_solicita(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites."  * 100) || '%'    as p1 ";
        
        $sql = "SELECT  nombre, count(*) || ' '  as tramites,".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by nombre
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Solicita,Nro Tramites,Indicador", $this->font );
        
        
    }
    //------------ 
     
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------

if (isset($_GET['canio']))	{
    
    $gestion   = 	new proceso();
    
    $canio        = $_GET['canio'];
    
    $gestion->ResumenDatos($canio);
    
}

      


?>