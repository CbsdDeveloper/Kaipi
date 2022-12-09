<?php
session_start( );

require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/

require '../../kconfig/Obj.conf.php';


class proceso{
    
     
    private $obj;
    private $bd;
    private $formulas;
    
    private $ruc;
    private $sesion;
    private $hoy;
    private $POST;
    private $datos;
    private $ATabla;
    private $tabla ;
    private $secuencia;
    private $qservicios;
    
    private $calculo_servicio;
    
    //-----------------------------------------------------------------------------------------------------------
    //Constructor de la clase
    //-----------------------------------------------------------------------------------------------------------
    function proceso($rubro){
        //inicializamos la clase para conectarnos a la bd
        
        $this->obj      = 	new objects;
        
        $this->bd	    =	new Db ;
        
        $this->ruc       =  $_SESSION['ruc_registro'];
        
        $this->sesion 	 =  trim($_SESSION['email']);
        
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],$_SESSION['db'],$_SESSION['ac']);
        
        $this->calculo_servicio = array();
        
      
        $this->qservicios = array(
            array( campo => 'id_rubro',valor => $rubro,filtro => 'S', visor => 'S'),
            array( campo => 'idproducto_ser',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tributo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado_servicio',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'facturacion',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'interes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'recargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'estado',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tipo_formula',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'formula',valor => '-',filtro => 'N', visor => 'S'),
        );
         
        
        
        
        $this->ATabla = array(
            array( campo => 'idproducto_ser',tipo => 'NUMBER',id => '0',add => 'S', edit => 'N', valor => '-', key => 'N'),
            array( campo => 'costo',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'monto_iva',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'baseiva',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'tarifa_cero',tipo => 'NUMBER',id => '4',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'descuento',tipo => 'NUMBER',id => '5',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'interes',tipo => 'NUMBER',id => '6',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'recargo',tipo => 'NUMBER',id => '7',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'total',tipo => 'NUMBER',id => '8',add => 'S', edit => 'S', valor => '-', key => 'N'),
            array( campo => 'sesion',tipo => 'VARCHAR2',id => '9',add => 'S', edit => 'S', valor => $this->sesion, key => 'N'),
            array( campo => 'detalle',tipo => 'VARCHAR2',id => '10',add => 'S', edit => 'S', valor => '-', key => 'N'),
        );
        
        
        $this->calculo_servicio['monto_iva'] = '0.00';
        $this->calculo_servicio['baseiva'] = '0.00';
        $this->calculo_servicio['tarifa_cero'] = '0.00';
        $this->calculo_servicio['descuento'] = '0.00';
        $this->calculo_servicio['interes'] = '0.00';
        $this->calculo_servicio['recargo'] = '0.00';
        $this->calculo_servicio['total'] = '0.00';
        
        
        $this->tabla 	  	     = 'rentas.ren_temp';
        
        $this->secuencia 	     = 'rentas.ren_temp_id_ren_temp_seq';
        
        
        
    }
    
    //--- calcula libro diario
    public function SimularTramites(   $tramite ,  $rubro   ){
        
        
        $qquery = array(
            array( campo => 'idproducto_ser',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto_iva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tarifa_cero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'interes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'recargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor =>$this->sesion,filtro => 'S', visor => 'S'),
        );
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_temp',$qquery );
        
         
        
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
          //  $idproducto =  $fetch['idproducto_ser'] ;
 
            $total = $total + $fetch['total'];
             
        }
     
        
        pg_free_result($resultado);


        echo json_encode( array("a"=> $total)   );


    }
    
    //---------------------------------------------------------
    public function VisorTramites(   $tramite ,  $rubro   ){
        
        
        
        $qquery = array(
            array( campo => 'idproducto_ser',    valor => '-',  filtro => 'N',   visor => 'S'),
            array( campo => 'costo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'monto_iva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'baseiva',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'tarifa_cero',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'descuento',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'interes',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'recargo',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'total',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'detalle',valor => '-',filtro => 'N', visor => 'S'),
            array( campo => 'sesion',valor =>$this->sesion,filtro => 'S', visor => 'S'),
        );
        
        
        
        $resultado = $this->bd->JqueryCursorVisor('rentas.ren_temp',$qquery );
        
        
        echo '<table id="jsontableSim" style="font-size: 13px"  class="display table-condensed table-bordered table-hover" cellspacing="0" width="100%">
          <thead> <tr>
                 <th width="10%" bgcolor="#8bb6da"> Codigo</th>
                 <th width="50%" bgcolor="#8bb6da">Detalle</th>
                 <th width="20%" bgcolor="#8bb6da">Sesion</th>
                 <th width="20%" bgcolor="#8bb6da">Pagar</th>
                 </tr>';
        
        $total = 0;
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $idproducto =  $fetch['idproducto_ser'] ;
            
            
            echo ' <tr>';
            
            echo ' <td>'.$idproducto.'</td>';
            echo ' <td>'.$fetch['detalle'].'</td>';
            echo ' <td>'.$fetch['sesion'].'</td>';
            echo ' <td align="right">'.number_format($fetch['total'],2).'</td>';
            
            
            $total = $total + $fetch['total'];
            echo ' </tr>';
        }
        
        echo ' <tr>';
        
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td> </td>';
        echo ' <td align="right">'.number_format($total,2).'</td>';
        
        
        
        echo ' </tr>';
        
        echo "   </tbody>
               </table>";
        
        
        pg_free_result($resultado);
    }
   
    //------------------------------------------------------
    public function Emision_titulos(   $tramite ,  $rubro , $anio	,  $fechae	, $accion='NO'  ){
        
        
        $sql = 'delete from rentas.ren_temp  where sesion= '.$this->bd->sqlvalue_inyeccion($this->sesion ,true);
        
        $this->bd->ejecutar($sql);
        
        $ADISCAPACIDAD = $this->bd->query_array('rentas.view_ren_tramite_var','valor_variable', 
                        "nombre_variable='DISCAPACIDAD' AND id_ren_tramite=".$this->bd->sqlvalue_inyeccion($tramite,true)
        );

        $TRAMITE = $this->bd->query_array('rentas.view_ren_tramite','fecha_inicio', 
        "id_ren_tramite=".$this->bd->sqlvalue_inyeccion($tramite,true)
        );

        $fecha_inicio =     $TRAMITE['fecha_inicio'];

        $DISCAPACIDAD =     intval($ADISCAPACIDAD['valor_variable']);
 


        //$url_externa =   trim($this->bd->_url_externo(75)); 

      
        $anio_actual = date('Y');
        
        ///-----------------------------------------------------------------------------------
        $resultado = $this->bd->JqueryCursorVisor('rentas.view_rubro_servicios', $this->qservicios);
        
        while ($fetch=$this->bd->obtener_fila($resultado)){
            
            $formula      = trim($fetch['formula']);
            $tipo_formula = trim($fetch['tipo_formula']);
            $variable     = trim($fetch['variable']);
            //$costo        = trim($fetch['costo']);
 
            $data = 0;
            
            if (  $tipo_formula == 'formula'){
            
                $data = $this->bd->ejecutar_formula($formula, $tramite); // funcion que llama a la formula de calculo
    
     
            } elseif( $tipo_formula == 'constante' )
            {
                $data        = trim($fetch['costo']);
    
            } elseif( $variable == 'variable' )  {
    
                $data = $this->bd->ejecutar_formula('f_general', $tramite); // funcion que llama a la formula de calculo
    
            } 
            
            $this->calculo_servicio['costo'] = $data;
         
            if (   $DISCAPACIDAD > 0  ) {
                
                $data = $data * ($DISCAPACIDAD/100);
                $this->calculo_servicio['costo'] = $data;
                
            }  
            
           
            if ( trim($fetch['recargo']) == 'S'){
                
                $bandera = 1;
                $fecha_valido =  $anio_actual .'-04-01';
                
                 
                if ( $anio < $anio_actual  ){
                    $bandera = 1;
                }  else {
                    if (   $fecha_inicio  >  $fecha_valido){
                        $bandera = 0;
                    }else{
                        $bandera = 1;
                    }
                }
                   
                 if ( $bandera == 1 ){
                     
                        $data_recargo = $this->bd->ejecutar_formula_recargo( $tramite,  $data,  $anio_actual, $anio,$fechae ); 
 
                         $this->calculo_servicio['recargo'] = $data_recargo;
                         
                         if ( $accion == 'NO'){
                             echo 'Aplica Recargo: '.$data_recargo.'<br>';
                         }
                        
                     //}
                 } 
                
            }

           
            if ( $accion == 'NO'){
                echo '% Discapacidad: '.$DISCAPACIDAD.'<br>';
             }
            
           
      
            
            //---------------------------------------------------------------------------

            if ( trim($fetch['descuento']) == 'S'){

 
                    $porcentaje = $this->bd->ejecutar_formula( 'f_descuentos',$tramite ); // funcion que llama a la formula de calculo

 
                    if (  $porcentaje == '-') {
              
                    } else{

                    $data_d =  ($porcentaje/100)  * $data ;

                    if (  $accion == 'NO') {
                       echo 'Aplica '. $porcentaje .'% Descuento: '.$data_d.'<br>';
                    }  
                    
                    $this->calculo_servicio['descuento'] = round($data_d,2);
              
                }  

            }     


            
            
            if (  $this->calculo_servicio['costo'] > 0 ){
                
                $this->_tributo(  $fetch,    $this->calculo_servicio['costo'] );
                
                $this->_calculo(  $fetch   );
                
            } 

          
            
        }
    }
    //-------------------------------------------------------------
    public function _calculo(  $fetch     ){
        
        
            $this->calculo_servicio['total'] = ($this->calculo_servicio['costo'] +
            $this->calculo_servicio['monto_iva'] +
            $this->calculo_servicio['interes'] +
            $this->calculo_servicio['recargo'] ) -
            $this->calculo_servicio['descuento'];
            
            
            
            $this->ATabla[0][valor]  =  $fetch['idproducto_ser'];
            
            $this->ATabla[1][valor]  =  $this->calculo_servicio['costo'];
            $this->ATabla[2][valor]  =  $this->calculo_servicio['monto_iva'];
            $this->ATabla[3][valor]  =  $this->calculo_servicio['baseiva'];
            $this->ATabla[4][valor]  =  $this->calculo_servicio['tarifa_cero'];
            $this->ATabla[5][valor]  =  $this->calculo_servicio['descuento'];
            $this->ATabla[6][valor]  =  $this->calculo_servicio['interes'];
            $this->ATabla[7][valor]  =  $this->calculo_servicio['recargo'];
            
            $this->ATabla[8][valor]  =  $this->calculo_servicio['total'];
            
            $this->ATabla[10][valor]  =  $fetch['servicio'];
            
            if ( $this->calculo_servicio['costo'] > 0 ){
                
                $this->bd->_InsertSQL($this->tabla,$this->ATabla, $this->secuencia );
                
            }
             
    }
    
    //--------------------------------------------
    public function _tributo(  $fetch,    $costo  ){
        
        $iva = 12/100;
        
        if ( $fetch['tributo'] == '-'){
            $this->calculo_servicio['monto_iva'] = '0.00';
            $this->calculo_servicio['baseiva'] = '0.00';
            $this->calculo_servicio['tarifa_cero'] = '0.00';
        }
        if ( $fetch['tributo'] == 'I'){
            $this->calculo_servicio['monto_iva'] = $costo * $iva;
            $this->calculo_servicio['baseiva'] = $costo;
            $this->calculo_servicio['tarifa_cero'] = '0.00';
        }
        if ( $fetch['tributo'] == 'T'){
            $this->calculo_servicio['monto_iva'] = '0.00';
            $this->calculo_servicio['baseiva'] = '0.00';
            $this->calculo_servicio['tarifa_cero'] = $costo;
        }
        
        
        
    }
}
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------
///------------------------------------------------------------------------




//------ grud de datos insercion
if (isset($_GET["tramite"]))	{
    
    $tramite 		=     $_GET["tramite"];
    $rubro			=     $_GET["rubro"];

    $anio			=     $_GET["anio"];
    $fechae			=     $_GET["fechae"];
 
    $accion			=     trim($_GET["accion"]);
    

    $gestion        = 	  new proceso($rubro);
    
     
    if (   $accion == 'simula') {

         $gestion->Emision_titulos(   $tramite ,  $rubro , $anio	,  $fechae, 'SI'	  );
    
         $gestion->SimularTramites(   $tramite ,  $rubro   );

    }
    else
    {
        $gestion->Emision_titulos(   $tramite ,  $rubro , $anio	,  $fechae	,  'NO'	   );
    
        $gestion->VisorTramites(   $tramite ,  $rubro   );
    }
  
    
  
}




?>
 
  