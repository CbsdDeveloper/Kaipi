<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/


class proceso{
    
    //creamos la variable donde se instanciar la clase "mysql"
    
    private $obj;
    private $bd;
    
    private $ruc;
    public  $sesion;
    public  $hoy;
    private $POST;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =     $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  $_SESSION['email'];
        
        $this->hoy 	     =  date("Y-m-d");    	//$this->hoy 	     =  $this->bd->hoy();
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        
        
        
    }
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
   
 
    //--------------------------------------------------------------------------------
    //--- busqueda de por codigo para llenar los datos
    //--------------------------------------------------------------------------------
    function Vigencia( $id ){
        
        
        $sqlUser = 'SELECT id_rol, id_periodo, mes, anio, registro, estado, fecha, novedad, sesion
                      FROM public.nom_rol_pago   
                     WHERE id_rol = '.$this->bd->sqlvalue_inyeccion($id,true).' AND
                           registro= '.$this->bd->sqlvalue_inyeccion( $this->ruc,true)   ;
        
        $stmtUser = $this->bd->ejecutar($sqlUser);
        
        while ($x=$this->bd->obtener_fila($stmtUser)){
                
            echo '<h5>'.'Periodo <b>'.$x['anio'].'-'.$x['mes'].' Estado '.$x['estado'] .'</b></h5>';
            
            echo "<script>
                	$('#id_periodo').val(".$x['id_periodo'].");
                    $('#id_rol').val(".$x['id_rol'].");
                    $('#anio').val(".$x['anio'].");
                    $('#mes').val(".$x['mes'].");
             </script>";
            
            $id_periodo = $x['id_periodo'];
            $id_rol = $x['id_rol'];
            $anio = $x['anio'];
            $mes = $x['mes'];
        }
     
 
        $sql = 'SELECT   idprov, razon, cargo, sueldo,regimen,id_departamento,id_cargo,fecha
                FROM view_nomina_rol
                where registro = '.$this->bd->sqlvalue_inyeccion( $this->ruc,true) .' 
                 order by razon'  ;
        
     
        echo '<table id="jsontable" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
    				<th align="center" width="10%">Identificacion</th>
    				<th align="center" width="20%">Nombre</th>
    				<th align="center" width="10%">Cargo</th>
    				<th align="center" width="10%">Sueldo</th>
                    <th align="center" width="10%">Dias Trabajados</th>
                    <th align="center" width="10%">Horas Suplementarias</th>
                    <th align="center" width="10%">Horas ExtraOrdinaria </th>
                    <th align="center" width="10%">Atrasos(Min)</th>
                    <th width="10%"> </th>
    				</tr>
    			</thead>';
        
        
        $stmt1 = $this->bd->ejecutar($sql);
        
        while ($y=$this->bd->obtener_fila($stmt1)){
            
            $User = $this->bd->query_array('nom_rol_horas',
                'id_rolhora, dias, horasextras, horassuple, atrasos',
                'idprov='.$this->bd->sqlvalue_inyeccion(trim($y['idprov']),true).' and
                 id_periodo='.$this->bd->sqlvalue_inyeccion($id_periodo,true).' and
                 id_rol='.$this->bd->sqlvalue_inyeccion($id_rol,true).' and
                 registro='.$this->bd->sqlvalue_inyeccion( $this->ruc ,true).' and
                 anio='.$this->bd->sqlvalue_inyeccion($anio,true).' and
                 mes='.$this->bd->sqlvalue_inyeccion($mes,true) 
                );
            
   
    
          $o = ' onClick="goToURL('."'edit'".",'".$y['idprov']."'".','.$User['id_rolhora'].')" ';
          $b = '';
            
          $title1 = 'title="Actualizar Informacion"'; 
          $title2 = 'title="Limpiar Informacion"';
          
          $boton = '<button   class="btn btn-xs" '.$title1.$o.'   ><i class="glyphicon glyphicon-ok"></i></button>&nbsp;';
          $boton1 = '';
            
          $variable = '<input type="hidden" id="id'.trim($y['idprov']).'" name="id'.trim($y['idprov']).'" value="'.$User['id_rolhora'].'">';
 
                 echo ' <tr>
				<td>'.$y['idprov'].'</td>
				<td>'.$y['razon'].'</td>
 				<td>'.$y['cargo'].'</td>
				<td align="right">'.$y['sueldo'].'</td>
                <td align="right">'.' <input type="number" min="0" max="30" step="1"  value="'.$User['dias'].'" style="text-align:right; border:rgba(193,193,193,1.00)" id="d'.trim($y['idprov']).'" name="d">'.'</td>
                <td align="right">'.' <input type="number" min="0" max="30" step="1"  value="'.$User['horassuple'].'" style="text-align:right; border:rgba(193,193,193,1.00)" id="s'.trim($y['idprov']).'" name="h">'.'</td>
                <td align="right">'.' <input type="number" min="0" max="30" step="1"  value="'.$User['horasextras'].'" style="text-align:right; border:rgba(193,193,193,1.00)" id="e'.trim($y['idprov']).'" name="s">'.'</td>
                <td align="right">'.' <input type="number" min="0" max="30" step="1"  value="'.$User['atrasos'].'" style="text-align:right; border:rgba(193,193,193,1.00)" id="a'.trim($y['idprov']).'" name="a">'.'</td>
                <td>'.$boton.$boton1.$variable.'</td>
                 </tr>';
        }


echo	'</table> ';
        
     
      
        
    }
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

//------ poner informacion en los campos del sistema
if (isset($_GET['periodo']))	{
     
    if ($_GET['periodo'] == '-'){
        
        $ViewProceso='';
        
        echo $ViewProceso;
        
    }else  {
        
        $gestion->Vigencia($_GET['periodo']);
        
    }
 
  
}
?>
<script>
    $(document).ready(function() {
        $('#jsontable').DataTable();
    } ); 
</script>
  