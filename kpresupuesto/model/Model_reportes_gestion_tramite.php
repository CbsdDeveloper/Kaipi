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
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
        $this->anio       =  $_SESSION['anio'];
        
        $this->saldos     = 	new saldo_presupuesto(  $this->obj,  $this->bd);
        
    }
    
    
    //---------------------------------
    function GrillaGasto_periodo(  $partidac,$id_departamentoc){
        
    
  
        $this->GrillaGasto_periodo_uno( $partidac,$id_departamentoc);
 
        
        
        
    }
    //--------------------------------------------------
    function GrillaGasto_periodo_uno( $partidac,$id_departamentoc){
        
      //  $this->anio 
        
        $tipo 		    = $this->bd->retorna_tipo();
         
 
        if( $partidac == '-'){
            $where_u = '';
        }else{
            $where_u = ' and  partida='.$this->bd->sqlvalue_inyeccion($partidac , true) ;
        }
        
        
        if( $id_departamentoc == '0'){
            
            $where_d = '';
            $where_u = ' and  partida='.$this->bd->sqlvalue_inyeccion($partidac , true) ;
            
        }else{
            
            $where_d = ' and  id_departamento='.$this->bd->sqlvalue_inyeccion($id_departamentoc , true) ;
        }
        
        $sql = 'SELECT id_tramite,fecha,estado_presupuesto,unidad,partida,clasificador,detalle,proveedor,certificado,compromiso,devengado ,id_departamento
                 FROM presupuesto.view_dettramites
                WHERE anio = '. $this->bd->sqlvalue_inyeccion($this->anio  , true).$where_d .$where_u .'  order by fecha';


        
 
                 
                  $_SESSION['sql_activo'] = $sql;
                  
                  
                  $resultado  = $this->bd->ejecutar($sql);
                  
 
                  
                  echo '<div class="col-md-12" style="padding-bottom:20;padding-top:20px;font-size: 11px"> ';
                  
                  $this->grilla($resultado,$tipo,"G","jtabla_gasto");
                  
                  echo '</div> ';
                  
             
                  
                
                  
                  
                  
    }
 //-------------------------------------------------------------
 //------------($resultado,$tipo,"G","jtabla_gastos");
    
 function grilla($resultado,$tipo,$presupuesto,$nombre)  {
        

     
       $k = 0;
       
       //id_tramite,fecha,estado_presupuesto,partida,clasificador,detalle,proveedor,certificado,compromiso,devengado 
     
       
       echo '<table class="table table-bordered table-hover table-tabletools" id='."'".$nombre."'".' border="0" width="100%">
        <thead> <tr>';
        
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Referencia</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Fecha</th>';
           echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Unidad</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Estado</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Partida</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Clasificador</th>';
           echo '<th width="15%" bgcolor="#167cd8" style="color: #F4F4F4">Detalle</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Proveedor</th>';
           echo '<th width="10%" bgcolor="#167cd8" style="color: #F4F4F4">Certificado</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Compromiso</th>';
           echo '<th width="5%" bgcolor="#167cd8" style="color: #F4F4F4">Devengado</th>';
           
        echo '</tr></thead><tbody>';
 
                $nsuma1 = 0;
                $nsuma2 = 0;
                $nsuma3 = 0;
 
                
                 
                $k = 1;
                while($row=pg_fetch_assoc($resultado)) {
                    
                    echo "<tr>";
 
                  
                    $referencia = ' ';
 
                    echo "<td><a ".$referencia." >".trim($row['id_tramite']).'</a></td>';
                    echo "<td>".trim($row['fecha']).'</td>';
                    echo "<td>".trim($row['unidad']).'</td>';
                    echo "<td>".trim($row['estado_presupuesto']).'</td>';
                    echo "<td>".trim($row['partida']).'</td>';
                    echo "<td>".trim($row['clasificador']).'</td>';
                    echo "<td>".trim($row['detalle']).'</td>';
                    echo "<td>".trim($row['proveedor']).'</td>';
                     
                    echo "<td align='right'>".number_format($row['certificado'],2).'</td>';
                    echo "<td align='right'>".number_format($row['compromiso'],2).'</td>';
                    echo "<td align='right'>".number_format($row['devengado'],2).'</td>';
                    
                    $nsuma1 = $nsuma1 + $row['certificado'];
                    $nsuma2 = $nsuma2 + $row['compromiso'];
                    $nsuma3 = $nsuma3 + $row['devengado'];
    
 
                    $k++;
                     echo "</tr>";
                    
                }
                /// total
                
              
                
              
                echo "<tr>";
                     echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                           <td>TOTAL</td>";
                     
                     echo '<td align="right"><b>'.number_format($nsuma1,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma2,2).'</b></td>';
                     echo '<td align="right"><b>'.number_format($nsuma3,2).'</b></td>';
                  
                
                echo "</tr></tbody></table>";
                
                pg_free_result ($resultado) ;
            
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
if (isset($_GET["id_departamentoc"]))	{
 
    $partidac	=   $_GET["partidac"];
    $id_departamentoc	=   $_GET["id_departamentoc"];
 
    
    
    $gestion->GrillaGasto_periodo( $partidac,$id_departamentoc);
            
 
 
}
?>

 