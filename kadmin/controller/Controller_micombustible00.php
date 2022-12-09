<?php 
session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class Controller_micombustible00{
 
  
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
      function Controller_micombustible00( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =  $this->bd->hoy();
        
 
           
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
 
      function Formulario( $estado ){

         
         $year = date('Y');

        $x = $this->bd->query_array('view_nomina_user',   // TABLA
        'completo ,cargo ,unidad ,regimen,idprov',                        // CAMPOS
        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) .' or 
        sesion_corporativo='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
        );

 
       
 
 
        
        $year = date('Y');
        
        $qquery = array(
            array( campo => 'id_combus',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'id_bien',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'fecha',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'hora_in',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'u_km_inicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ubicacion_salida',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'ubicacion_llegada',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_comb',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'codigo_veh',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'marca',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'placa_ve',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descripcion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'razon',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'referencia',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'cantidad',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'anio',valor =>$year,filtro => 'S', visor => 'S'),
            array( campo => 'estado',valor => $estado,filtro => 'S', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'id_prov',valor =>   trim($x['idprov']),filtro => 'S', visor => 'S'),
        );
        
        
       
        
      
        $resultado = $this->bd->JqueryCursorVisor('adm.view_comb_vehi',$qquery);
        
        
        echo '<table id="jsontableDoc" class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                <th> Referencia </th>
                <th> Responsable </th>
                <th> Comprobante </th>
                <th> Fecha </th>
                 <th> Hora </th>
                 <th> Ubicacion </th>
                 <th> Km.Actual </th>
                 <th> Combustible </th>
                <th> Cantidad </th>
                <th> Costo </th>
                <th> Subtotal </th>
                <th> Iva </th>
                <th> Total </th>
                <th> Acciones</th></thead> </tr>';
        
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['id_combus'] ;
            
             
            $boton2 = '<button class="btn btn-xs"
                              title="Editar Registro"
                              data-toggle="modal" data-target="#myModal"
                              onClick="goToURLdetalle('.$idproducto.')">
                             <i class="glyphicon glyphicon-search"></i></button>&nbsp;&nbsp;&nbsp;';
         
            
            echo ' <tr>';
            
            $total = $fetch['cantidad'] * $fetch['costo'];
            
            $iva =  (12/ 100);
            $monto_iva = $total * $iva;
            
            $total_consumo = round($total,4)+ $monto_iva;
            
            
            $mensaje = '<b> '. trim( $fetch['codigo_veh']).'</b> '.trim( $fetch['marca']).' '.trim( $fetch['placa_ve']);
          
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'. $mensaje .'</td>';
            echo ' <td>'.$fetch['referencia'].'</td>';
            echo ' <td>'.$fetch['fecha'].'</td>';
            echo ' <td>'.$fetch['hora_in'].'</td>';
            echo ' <td>'.$fetch['ubicacion_salida'].'</td>';
            echo ' <td>'.$fetch['u_km_inicio'].'</td>';
            echo ' <td>'.$fetch['tipo_comb'].'</td>';
            echo ' <td>'.number_format($fetch['cantidad'],4).'</td>';
            echo ' <td>'.number_format($fetch['costo'],4).'</td>';
            echo ' <td>'.number_format($total,2).'</td>';
            echo ' <td>'.number_format($monto_iva,2).'</td>';
            echo ' <td>'.number_format($total_consumo,4).'</td>';
            echo ' <td>'.$boton2.'</td>';
            
            echo ' </tr>';
        }
        
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
        
   }




   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new Controller_micombustible00;
  
  $estado = $_GET['estado'];
   
  $gestion->Formulario( trim($estado));
  
 ?>
 
  