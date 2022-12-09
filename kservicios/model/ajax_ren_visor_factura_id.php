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
  
    //---------------------------------------------------------
    public function VisorTramites(   $id_renpago    ){
        
 
        
        $qquery = array(
            array( campo => 'id_ren_movimiento',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'secuencial',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'autorizacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'carga',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'envio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_renpago',valor => $id_renpago,filtro => 'S', visor => 'S') 
        );
  
  

        $resultado = $this->bd->JqueryCursorVisor('rentas.view_ren_factura',$qquery );
        
        $estilo = 'style ="background-color: #3e95d1;color:#f8f9fa;background-image: linear-gradient(to bottom, #3e95d1, #368ac5, #2d7fb8, #2474ac, #1a69a0);" ';

        echo '<table id="jsontableDoc" style="font-size: 13px" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th width="10%" '.  $estilo.' > Emision </th>
                 <th width="10%" '.  $estilo.'> Fecha </th>
                 <th width="10%" '.  $estilo.'> Secuencia </th>
                 <th width="40%" '.  $estilo.'> Autorizacion </th>
                 <th width="10%" '.  $estilo.'> Enviado </th>
                 <th width="10%" '.  $estilo.' align="right"> Total </th>
                 <th width="10%" '.  $estilo.' >  </th>
                </tr>';
 
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_ren_movimiento'] ;
            
 
            echo ' <tr>';
            
           
                
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['secuencial'].'</td>';
             echo ' <td>'.$fetch['autorizacion'].'</td>';
            echo ' <td>'.$fetch['envio'].'</td>';
            echo ' <td align="right">'.$fetch['total'].'</td>';
            

            $funcion1      = ' onClick="_Generar_factura_id('.$id_renpago .','. $idproducto .')" ';
            $title1        = ' title="Generar Factura Electronica"';
            $boton_enlaces = '<button   class="btn btn-xs btn-warning" '.$title1.$funcion1.' ><i class="glyphicon glyphicon-globe"></i></button>&nbsp;';

            $funcion2      = ' onClick="_Imprimir_factura_id('. $idproducto .')" ';
            $title2        = ' title="Imprimir Factura Electronica"';
            $boton_enlaces2 = '<button   class="btn btn-xs btn-info" '.$title2.$funcion2.' ><i class="glyphicon glyphicon-print"></i></button>&nbsp;';
                
            $funcion3      = ' onClick="_elimina_factura_id('. $idproducto .')" ';
            $title3        = ' title="Anular Factura Electronica... debe anular en el SRI"';
            $boton_enlaces3 = '<button   class="btn btn-xs btn-danger" '.$title3.$funcion3.' ><i class="glyphicon glyphicon-trash"></i></button>&nbsp;';


            echo "<td>". $boton_enlaces.$boton_enlaces2.$boton_enlaces3 .'</td>';



            $total = $total + $fetch['total'];
            echo ' </tr>';
        }
        
        echo ' <tr>';
        
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
if (isset($_GET["idpago"]))	{
    
    
    $idpago 		=     $_GET["idpago"];
    
    
  
    
    $gestion->VisorTramites(   $idpago   );
    


    
}

 


?>
 
  