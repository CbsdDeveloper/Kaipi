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
    private $datos;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso( ){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj     = 	new objects;
        $this->bd	   =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        $this->sesion 	 =  trim($_SESSION['email']);
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
    }
    
    //--- calcula libro diario
    //----------- eliminar_titulo
    public function eliminar_titulo(   $emision ,  $fecha   ){

        

        $xxx = $this->bd->query_array('rentas.ren_movimiento ',
        'conta',
        'id_ren_movimiento='.$this->bd->sqlvalue_inyeccion( $emision ,true)

        );

        if (  $xxx['conta'] == 'N' ){

              
            $sql = 'delete from rentas.ren_movimiento_det
            where id_ren_movimiento= '.$this->bd->sqlvalue_inyeccion($emision ,true);

            $this->bd->ejecutar($sql);
             
            $sql = 'delete from rentas.ren_movimiento
            where id_ren_movimiento= '.$this->bd->sqlvalue_inyeccion($emision ,true);
   
            $this->bd->ejecutar($sql);
 
        }

    }
    //---------------------------------------------------------
    public function VisorTramites(   $tramite ,  $rubro   ){
        
 
        
        $qquery = array(
            array( campo => 'id_ren_movimiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fechap',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'documento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_tramite',valor => $tramite,filtro => 'S', visor => 'S'),
            array( campo => 'id_rubro',valor =>$rubro,filtro => 'S', visor => 'S'),
        );
        
        $this->bd->_order_by('fecha desc');
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_movimiento',$qquery );
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table id="jsontableDoc" style="font-size: 13px" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th width="10%" '.  $estilo.' > Emision </th>
                 <th width="12%" '.  $estilo.'> Fecha </th>
                 <th width="10%" '.  $estilo.'> Periodo </th>
                 <th width="13%" '.  $estilo.'> Estado </th>
                 <th width="15%" '.  $estilo.'> Pago </th>
                 <th width="15%" '.  $estilo.'> Comprobante </th>
                 <th width="15%" '.  $estilo.' align="right"> Total </th>
                 <th width="5%" '.  $estilo.' >  </th>
                </tr>';
 
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_ren_movimiento'] ;
            
 
            echo ' <tr>';
            
            if ( trim($fetch['estado']) == 'E'){
                $estado = 'Emitido';
            }elseif (trim($fetch['estado']) == 'P'){
                $estado = 'Pagado';
            }elseif (trim($fetch['estado']) == 'B'){
                $estado = 'Baja';
            }
                
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['anio'].'</td>';
            echo ' <td>'.$estado.'</td>';
            echo ' <td>'.$fetch['fechap'].'</td>';
            echo ' <td>'.$fetch['documento'].'</td>';
            echo ' <td align="right">'.$fetch['total'].'</td>';
            

            $funcion1      = ' onClick="Elimina_pre_emision('.$tramite .','. $rubro .','.$idproducto.','."'".trim($fetch['estado'])."',"."'".$fetch['fecha']."'".')" ';
            $title1        = ' title="Enlace partidas"';
            $boton_enlaces = '<button   class="btn btn-xs btn-danger" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-trash"></i></button>&nbsp;';

                
            echo "<td>". $boton_enlaces .'</td>';



            $total = $total + $fetch['total'];
            echo ' </tr>';
        }
        
        echo ' <tr>';
        
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td align="right"><b>'.number_format($total,2).'</b></td>';
        
 
        
        echo ' </tr>';
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
        $sql = 'delete from rentas.ren_temp
                 where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
        
        $this->bd->ejecutar($sql);
        
    }
    //-------------
 
    
    
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------

$gestion   = 	new proceso;

 
//------ grud de datos insercion
if (isset($_GET["tramite"]))	{
    
    
    $tramite 		=     $_GET["tramite"];
    
    $rubro			=     $_GET["rubro"];


    if (isset($_GET["estado"]))	{

        if ( trim($_GET["estado"]) == 'E')	{

           $gestion->eliminar_titulo(  $_GET["emision"]  ,trim($_GET["fecha"]) );

        }  

     
    }
    
    $gestion->VisorTramites(   $tramite ,  $rubro   );
    


    
}




?>
 
  