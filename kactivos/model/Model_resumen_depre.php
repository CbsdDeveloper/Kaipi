<?php
session_start( );
require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/

require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
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
        $this->bd     = 	new Db;
        
        $this->set     = 	new ItemsController;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  $_SESSION['login'];
        $this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
       
        $this->anio       =  $_SESSION['anio'];
        
    }
    //--------------------------------------
    function historial($anio,$tipo,$mes){
          
        
        
        if ( $tipo== 'A'){
            
            $sql = "SELECT  cuenta, nombre_cuenta,
                       clasificador, count(*) as bienes,   sum(costo) compra,
                       sum(vresidual) as residual,  sum(cuotadp) as cdp
                    FROM activo.view_bienes_depre
                    where anio_actual  = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                          tipo_depre = 'A'
                    group by cuenta, nombre_cuenta, clasificador
                    order by cuenta";
        }else{
            
            
            $sql = "SELECT  cuenta, nombre_cuenta,
                       clasificador, count(*) as bienes,   sum(costo) compra,
                       sum(vresidual) as residual,  sum(cuotadp) as cdp
                    FROM activo.view_bienes_depre
                    where anio_actual  = ".$this->bd->sqlvalue_inyeccion($anio,true)." and
                          tipo_depre = 'M' and 
                          mes =".$this->bd->sqlvalue_inyeccion($mes,true)." 
                    group by cuenta, nombre_cuenta, clasificador
                    order by cuenta";
            
        }
       
        
      
                    
        
        $resultado    =  $this->bd->ejecutar($sql);
          
        echo ' <table class="table table-responsive"   width="100%" style="font-size:12px" id="TablaResumen" >
            <thead>
                <tr>
                     <th width="10%">Cuenta</th>
                     <th width="25%">Detalle</th>
                     <th width="10%">Item</th>
                     <th align="right" width="10%">Nro.Bienes</th>
                     <th align="right" width="10%">Costo Adquisicion</th>
                     <th align="right" width="10%">Valor Residual</th>
                     <th align="right" width="15%">Depreciacion periodo</th>
                     </tr>
            </thead><tbody>';
 
        $a1 = 0;
        $a2 = 0;
        $a3 = 0;
        $a4 = 0;
 
        while($row=pg_fetch_assoc ($resultado)) {
                
            echo '<tr>
                 <td> <b>'. $row['cuenta'].' </b></td>
                 <td> '. $row['nombre_cuenta'].' </td>
                 <td> '. $row['clasificador'].' </td>
                 <td align="right"> '. $row['bienes'].' </td>
                 <td align="right"> '. number_format($row['compra'],2).' </td>
                 <td align="right"> '. number_format($row['residual'],2).' </td>
                 <td align="right"> '. number_format($row['cdp'],2).' </td>
              </tr>';
            
            $a1 = $a1 + $row['bienes'];
            $a2 = $a2 + $row['compra'];
            $a3 = $a3 + $row['residual'];
            $a4 = $a4 + $row['cdp'] ;
            
        }
        
        
        echo '<tr>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="right"> <b>'. $a1.' </b></td>
                 <td align="right"> <b>'. number_format($a2,2).'</b> </td>
                 <td align="right"><b> '. number_format($a3,2).'</b> </td>
                 <td align="right"> <b>'. number_format($a4,2).' </b></td>
              </tr>';
        
        
        echo "</tbody></table>";
        
        
        $this->set->div_label(12,'INFORMACION ENLACE FINANCIERO');
        
        $tipo_db = $this->bd->retorna_tipo();
        
        $union = "Select '-' as codigo, ' [ No aplica ] ' as nombre union" ;
        
        $datos = array();

         
        $resultado = $this->bd->ejecutar($union." select trim(cuenta) as codigo, (trim(cuenta) || '. ' || trim(detalle))  as nombre
								                        from co_plan_ctas
                                                        where univel = 'S' and
                                                              anio = ".$this->bd->sqlvalue_inyeccion($this->anio ,true)." and
                                                              registro = ".$this->bd->sqlvalue_inyeccion($this->ruc,true)." and
                                                              substring(trim(cuenta),1,3) in ('638','639') ORDER BY 1");
        
        $this->obj->list->listadb($resultado,$tipo_db,'Cuenta Cierre','cuenta_depre',$datos,'','','div-2-4');
        
        
        
        
    }
    
}
//-------------------------

$gestion         = 	new proceso;


if (isset($_GET['anio']))	{
    
    $anio    = $_GET['anio'];
    $tipo    = $_GET['tipo'];
    $mes     = $_GET['mes'];
    
    $gestion->historial($anio,$tipo,$mes) ;
    
}
 


?>
 
 
