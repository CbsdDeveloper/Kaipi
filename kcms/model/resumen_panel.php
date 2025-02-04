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
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->font       =  '13px';
        
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        
        
        $x = $this->bd->query_array('flow.view_itil_tiket',                                  // TABLA
                                    'count(*) as total',                                     // CAMPOS
                                    'anio='.$this->bd->sqlvalue_inyeccion($this->anio ,true) // CONDICION
            );
        
        $this->tramites = $x['total'];
        
    }
    
    //-----------------------------------------------------------------------------------------------------------
    //--- busqueda de grilla primer tab
    //-----------------------------------------------------------------------------------------------------------
    public function tramites_por_unidad(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  unidad, count(*) || ' '  as tramites, ".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by unidad
                order by 1";
       
        
        $resultado  = $this->bd->ejecutar($sql);
         
        $this->obj->table->table_basic_js($resultado,
                                          $tipo,
                                          '',
                                          '',
                                          '' ,
                                          "Unidades,Nro Tramites,Indicador", $this->font );
        
        
    }
    //---------------------------------tramites_unidades
    public function tramites_por_mes(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  mes || '. '  || cmes, count(*) || ' '  as tramites, ".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by mes,cmes
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Mes,Nro Tramites,Indicador", $this->font );
         
    }
    //---------------------------------tramites_unidades
    public function tramites_categoria(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  categoria, count(*) || ' '  as tramites,".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by categoria
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Categorias,Nro Tramites,Indicador", $this->font );
        
        
    }
    //----tramites_grupo
    public function tramites_estados(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  estado, count(*) || ' '  as tramites,".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by estado
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Estados,Nro Tramites,Indicador", $this->font );
        
        
    }
    //-------------------
    public function tramites_usuarios(){
        
        $anio =  $this->anio;
        
        $tipo 		= $this->bd->retorna_tipo();
        
        $p1 = " round(trunc(count(*))/".$this->tramites." *100) || '%'    as p1 ";
        
        $sql = "SELECT  tecnico, count(*) || ' '  as tramites,".$p1." 
                FROM flow.view_itil_tiket
                where anio = ". $this->bd->sqlvalue_inyeccion($anio,true)."
                group by tecnico
                order by 1";
        
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $this->obj->table->table_basic_js($resultado,
            $tipo,
            '',
            '',
            '' ,
            "Tecnico,Nro Tramites,Indicador", $this->font );
        
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




?>
 
  