<?php
session_start( );

require '../../kconfig/Db.class.php';  

require '../../kconfig/Obj.conf.php';  

require '../../kconfig/Set.php';  

class componente{
    
    
    
    private $obj;
    private $bd;
    private $set;
    
    private $formulario;
    private $evento_form;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function componente( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        
        $this->set     = 	new ItemsController;
        
        $this->bd	   =	new  Db ;
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function FiltroUnidad(){
        
 
        
        $sql_nivel1 = 'SELECT id_departamento, id_departamentos, nombre, nivel
										 FROM nom_departamento
										 WHERE nivel = 1
										 ORDER BY id_departamento, id_departamentos';
        
        $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
 
 
        
        while ($x=$this->bd->obtener_fila($stmt_nivel1) ){
            
            $nombre 				= trim($x['nombre']);
            $id_unidad  			= trim($x['id_departamento']);
            
            echo '<a href="#">'.$nombre.'</a>';
            
 
            $mas_niveles = $this->_niveles( $id_unidad );
            
            $nivel = 2;
            
            if ( $mas_niveles >= 1){
                 $this->Subnivel($id_unidad,$nivel);
             } 
            
            
        }
        
    }
    //----
    function FiltroUnidadDato(){
        
        
        
        /*$sql_nivel1 = 'SELECT a.nombre as c1, b.nombre as c2, a.nivel
                          FROM nom_departamento a
                         join nom_departamento b on b.id_departamento = a.id_departamentos and a.nivel  <> 0
                          ORDER BY a.nivel	';
        
        */
        
        $sql_nivel1 = 'SELECT a.id_departamento as c1, a.id_departamentos as c2, a.nivel, a.nombre, a.ruc_registro
                          FROM nom_departamento a
                          ORDER BY a.nivel asc, a.id_departamentos ASC ';
        
        $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
        
 
        
        $i = 0;
        
        while ($x=$this->bd->obtener_fila($stmt_nivel1) ){
            
            
            $datos1 =  'N'.$x['c2'];
            $datos2 =  'N'.$x['c1'];
            
            echo '['."'".trim($datos1)."'".','."'".trim($datos2)."'".'],';
            $i++;
            
        }
        
        
    }
//---------------------------------------------        
function FiltroUnidadDatoValor(){
            
            /*
    
            $sql_nivel1 = ' SELECT unidad,id_departamento,count(*) as empleados
                            FROM  view_nomina_rol
                            where unidad is not null
                            group by unidad,id_departamento ORDER BY id_departamento	';
            
            */
            
            $sql_nivel1 = 'SELECT a.id_departamento as c1, a.id_departamentos as c2, a.nivel, a.nombre, a.ruc_registro
                          FROM nom_departamento a
                          ORDER BY a.nivel asc, a.id_departamentos ASC ';
            
            
 
            $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
            
 
            
            while ($x=$this->bd->obtener_fila($stmt_nivel1) ){
                
                
                $datos1 =  'N'.$x['c1'];
                $datos2 = ''; // $x['nombre'];
                $datos3 =  $x['nombre'];
                
                //echo '['."'".$datos1."'".','."'".$datos2."'".'],'; id: 'HR',
                
 
                echo "{
                        id: '".trim($datos1)."',
                        name: '".trim($datos3)."', 
                        title: '".' ('.$datos2.')'."',
                        image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132317/Grethe.jpg'
                    },";

 
                
            }
        
            /*{
            id: 'HR',
            title: 'HR/CFO',
            name: 'Anne Jorunn Fj�restad',
            color: '#007ad0',
            image: 'https://wp-assets.highcharts.com/www-highcharts-com/blog/wp-content/uploads/2018/11/12132314/AnneJorunn.jpg',
            column: 3,
            offset: '75%'
        }*/
        
       
    }
    ///------------------------------------------------------------------------
    function _niveles($id_unidad){
        
        
        $AResultado = $this->bd->query_array('nom_departamento',
            'count(*) as numero',
            'id_departamentos='.$this->bd->sqlvalue_inyeccion($id_unidad,true));
        
        return $AResultado['numero'] ;
    }
    ///------------------------------------------------------------------------
    function Subnivel($id_unidad,$nivel){
        
        
        $nivel = $nivel + 1;
        
        
        $sql1 ="SELECT id_departamento, id_departamentos, nombre, nivel,univel
   FROM nom_departamento
   WHERE id_departamentos =" .$this->bd->sqlvalue_inyeccion($id_unidad,true); ;
        
        
        $stmt_nivel2 = $this->bd->ejecutar($sql1);
        
        echo '<ul>';
        
        while ($y=$this->bd->obtener_fila($stmt_nivel2)){
            
            $titulo_nivel2 			= trim($y['nombre']);
            $id_departamento_nivel2 = trim($y['id_departamento']);
         //   $nivel2  				= $y['nivel'];
        //  $ultimonivel 			= $y['univel'];
            
            $y = $this->bd->query_array('nom_personal',
                'count(*) as numero',
                'id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamento_nivel2,true));
            
            $total =  $y['numero'] ;
          
 
            
              
            echo  '<li> <a href="#">'.$titulo_nivel2.' ( '.$total.' )</a>';
            
            $mas_niveles = $this->_niveles($id_departamento_nivel2 );
            
            if ( $mas_niveles >= 1){
                
                $this->Subnivel($id_departamento_nivel2,$nivel);
                
            }
            
 
            echo '</li>';
            
        }
        echo '</ul>';
        
        
    }   
    function Gestion_genero( $id_departamento){
        
        $AResultado = $this->bd->query_array('view_nomina_rol',
            'count(*) as numero',
            "estado = 'S' and genero= 'M' and id_departamento=".$this->bd->sqlvalue_inyeccion($id_departamento,true)
            );
        
        return $AResultado['numero'] ;
        
    }
    //--------------
    function Gestion_tthh( ){
        
        $sql_nivel1 = "SELECT unidad,id_departamento,sum(sueldo) as remuneracion, count(*) as funcionario       
                        FROM view_nomina_rol
                        where estado = 'S'
                        group by unidad,id_departamento order by 3 desc";
        
        $stmt_nivel1 = $this->bd->ejecutar($sql_nivel1);
        
        $anterior ='t';
        
        while ($x=$this->bd->obtener_fila($stmt_nivel1) ){
            
            $nombre 				= trim($x['unidad']);
            $id_unidad  			= trim($x['id_departamento']);
            
            $funcionario  			=  ($x['funcionario']);
            $masculino = $this->Gestion_genero( $id_unidad);
            $femenino  = $funcionario - $masculino;
            
            $remuneracion  			=  number_format($x['remuneracion'],2);
           
 
            //15 20 25 30 35 40 45
   
                
            $longitud = strlen(trim($nombre));
            
            if ( $longitud <= 10 ){
                $randomNumber= 'p';
            }elseif($longitud > 10  && $longitud <= 13 ){
                $randomNumber= 'q';
            }elseif($longitud > 13  && $longitud <= 16 ){
                $randomNumber= 'r';
            }elseif($longitud > 16  && $longitud <= 18 ){
                $randomNumber= 's';
            }elseif($longitud > 18  && $longitud <= 22 ){
                $randomNumber= 't';
            }elseif($longitud > 22  && $longitud <= 28 ){
                $randomNumber= 'u';
            }elseif($longitud > 28  && $longitud <= 150 ){
                $randomNumber= 'v';
            }
            
            $cadena_clase = 'class="div_'.$randomNumber.'" ';
            
            $imagen = $masculino.' <img  align="absmiddle" src="../../kimages/tthh.png" width="30" height="20" />'.$femenino;
             
            echo '<div '.$cadena_clase.'><b>'.' '.$nombre.'</b><br>'.$funcionario.' Funcionarios<br> '.$imagen.'<br>$$ '.$remuneracion.' </div>';
          
          
        }
        
    }
    //----------------------
    function GestionValor( ){
        
        
        $AResultado = $this->bd->query_array('nom_departamento',
                                            'count(*) as numero',
                                            '1='.$this->bd->sqlvalue_inyeccion(1,true)
                                            );
        
        $total =  $AResultado['numero'] ;
        
        
        $sql = "SELECT  ambito, count(*) as nro, round( ((count(*)::numeric / ".$total."::numeric)  * 100),2) as p1, sum(sueldos) as monto
FROM view_nomina_unidad
group by ambito";

 
        $tipo = $this->bd->retorna_tipo();
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Ambito,Nro.Unidades,Porcentaje (%), Monto RMU";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
       
    }
    //-----------
    function GestionAccion( ){
        
 
        $anio = date('Y');
        
        $AResultado = $this->bd->query_array('view_nom_accion',
                                            'count(*) as numero',
                                            'estado='.$this->bd->sqlvalue_inyeccion('S',true). ' and 
                                             anio='.$this->bd->sqlvalue_inyeccion( $anio ,true)
                                            );
        
        $total =  $AResultado['numero'] ;
        
        
        $sql = "SELECT  motivo, 
                        count(*) || ' ' as nro, 
                        round( ((count(*)::numeric / ".$total."::numeric)  * 100),2) as p1 
                FROM view_nom_accion
                where estado=".$this->bd->sqlvalue_inyeccion('S',true). " and 
                      anio=".$this->bd->sqlvalue_inyeccion( $anio ,true)."
                group by motivo";

 
        $tipo = $this->bd->retorna_tipo();
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Ambito,Emitidos,Porcentaje (%)";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
       
    }
    //---------
    function GestionPermisos( ){
        
        $anio = date('Y');
        
        $AResultado = $this->bd->query_array('view_nomina_vacacion',
                                            'count(*) as numero',
                                            'anio='.$this->bd->sqlvalue_inyeccion( $anio ,true)
                                            );
        
        $total =  $AResultado['numero'] ;
        
        
        $sql = "SELECT  motivo, 
                        count(*) || ' 'as nro, 
                        round( ((count(*)::numeric / ".$total."::numeric)  * 100),2) as p1 
                FROM view_nomina_vacacion
                where anio=".$this->bd->sqlvalue_inyeccion( $anio ,true)."
                group by motivo";

 
        $tipo = $this->bd->retorna_tipo();
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Ambito,Emitidos,Porcentaje (%)";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
       
    }
    //----------------------
    function Gestion_cumple( ){
        
        
       $mes = date('m');
        
        
        $sql = "SELECT date_part('day'::text, fechan) || ' ' AS dia ,razon,unidad 
                FROM public.view_nomina_rol
                where estado = 'S' and mes_nacio = ".$this->bd->sqlvalue_inyeccion($mes,true)." 
                order by 1 asc ";
        
        
        $tipo = $this->bd->retorna_tipo();
        
        $resultado  = $this->bd->ejecutar($sql);
        
        $cabecera =  "Dia,Funcionario,unidad";
        
        $evento   = "";
        
        $this->obj->table->table_basic_js($resultado,$tipo,'','',$evento ,$cabecera);
        
        
    }
}

?>