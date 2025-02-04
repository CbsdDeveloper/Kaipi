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
        $this->sesion 	 =  $_SESSION['email'];
        $this->hoy 	     =  date("Y-m-d");
        
        $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
        
    }
    /*
    Genera informacion a partir de un xml
    */
    function archivo_xml($archivo , $id, $bodega){
        
        $sqldelete = 'delete from xml_sesion where sesion = '.$this->bd->sqlvalue_inyeccion($this->sesion, true);
        
        $this->bd->ejecutar($sqldelete);
       
        $procesado          = 'Proceso generado ...ok Actualice la informacion...';
	    $array_dato         = array();
        $array_dato_detalle = array();

        $i = 0;

        $file  = '../../archivos/'.$archivo ;

        $xml   = simplexml_load_file($file );

        foreach ( $xml->children() as $child ) {
            	$array_dato[$i] = $child;
                $datosMotivos[] = $child;
		        $i++;
        }

        $array_dato_detalle  =  $array_dato[2] ;
 
        foreach($array_dato_detalle as $equipo)
 	    {
                  $j        = 0;
                  $etiqueta = '';
                  $cantidad = 0;
                  $precio   = 0;
                  $total    = 0;
                
                  foreach($equipo as $jugador)
                    {
                   
                       if ($j == 2){
                        $etiqueta = $jugador;
                       }

                       if ($j == 3){
                        $cantidad = $jugador;
                       }

                       if ($j == 4){
                        $precio = $jugador;
                       }
                       if ($j == 6){

                        $total = $jugador;

                        $sql = "INSERT INTO xml_sesion ( sesion, cantidad,precio,total,etiqueta) values (".
                        $this->bd->sqlvalue_inyeccion($this->sesion, true).",".
                        $this->bd->sqlvalue_inyeccion($cantidad, true).",".
                        $this->bd->sqlvalue_inyeccion($precio , true).",".
                        $this->bd->sqlvalue_inyeccion($total, true).",".
                        $this->bd->sqlvalue_inyeccion($etiqueta, true).")";
                        
                        $this->bd->ejecutar($sql);

                       }

                       $j++;
                     }
  	        }
  
 
        echo $procesado;
        
    }
/*
pone informacion 
*/
function genera_xml( ){
 
    
    $sql = "SELECT id_xmlserie, etiqueta, sesion, cantidad, precio, total,idproducto
          from xml_sesion
         where    sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion, true).' order by etiqueta' ;
  

    
    $stmt = $this->bd->ejecutar($sql);
    
    
    echo '<table class="table table-striped  table-hover" width="100%" id="tabla_mov" name="tabla_mov">  
                <thead> 
                    <tr>
                     <th> Codigo </th>
                    <th> Producto </th>
                    <th> Cantidad </th>
                    <th> Costo </th>
                    <th> Total </th>
                    </tr>   
                  </thead> 
                <tbody>';
 
    
    $ii = 1;
    
     while ($x=$this->bd->obtener_fila($stmt)){
      
            
          $cadena = substr($x['etiqueta'],0,6);

          $id_xmlserie = $x['id_xmlserie'];
          $costo       = $x['precio'];

          if ( $x['idproducto'] > 0 ){
                  $idproducto =     $x['idproducto'];    
                  $ajax       = ' ';
          }else{
            $idproducto =     'Editar';    
            $ajax       = '   onClick="articulo('."'".$x['etiqueta']."',".$id_xmlserie.','.$costo.')" ';
            $ajax       = ' <a class="btn btn-xs" href="#" '.$ajax.'>Agregar</a>';
         }
         
        
        $ajaxCateg   = ' data-toggle="modal" data-target="#myModal" onClick="Refarticulo('."'".trim($cadena)."',".$id_xmlserie .')" ';

      

         echo '<tr> '.'
             <td>  <a class="btn btn-xs" href="#" '.$ajaxCateg.'>' .$idproducto .'</a> '.$ajax.' </td>
             <td>  '.$x['etiqueta'].' </td>
             <td> '.$x['cantidad'].'  </td>
             <td> '.$x['precio'].'  </td>
             <td> '.$x['total'].'  </td>
              </tr>';
          
         
         $ii++;
         
    }
   

    echo "</tbody></table>";
 
    
    echo $DivMovimiento;
}
/*
*/
function copiar_producto($id ,$codigo ){

    $sql = "update xml_sesion  
              set  idproducto = ".$this->bd->sqlvalue_inyeccion($id, true)."
           where id_xmlserie =".$this->bd->sqlvalue_inyeccion($codigo, true);

     
    $this->bd->ejecutar($sql);

  }
 /*
 revision
 */ 
function agrega_producto($idbodega ,$producto ,$codigo,$costo){
            

        $sesion 	 =  $_SESSION['email'];
        $hoy 	     =  date("Y-m-d");

        echo     'xxxxxxxx '.$producto;            

           
        $AResultado = $this->bd->query_array(
                'web_producto',
                'idproducto',
                'producto='.$this->bd->sqlvalue_inyeccion(trim($producto),true).' and
                idbodega='.$this->bd->sqlvalue_inyeccion(trim($idbodega),true).' and
                registro='.$this->bd->sqlvalue_inyeccion(trim($this->ruc),true)
                                                );
                                     
     
        $dato = $AResultado['idproducto'];

        $InsertQuery = array(
        array( campo => 'producto',   valor => $producto),
        array( campo => 'referencia',   valor => $producto ),
        array( campo => 'tipo',   valor => 'B'),
        array( campo => 'idcategoria',   valor => '1'),
        array( campo => 'codigo',   valor => 'xml-0'),
        array( campo => 'estado',   valor => 'S'),
        array( campo => 'url',      valor => '-'),
        array( campo => 'idmarca',  valor => 1),
        array( campo => 'unidad',        valor => 'Unidad'),
        array( campo => 'facturacion',   valor => 'N'),
        array( campo => 'idbodega',      valor => $idbodega),
        array( campo => 'cuenta_inv',   valor => '-'),
        array( campo => 'cuenta_ing',   valor => '-'),
        array( campo => 'minimo',   valor => '5'),
        array( campo => 'tributo',   valor => 'I'),
        array( campo => 'costo',   valor => $costo),
        array( campo => 'codigob',   valor => '-'),
        array( campo => 'controlserie',   valor => 'N'),
        array( campo => 'cuenta_gas',   valor => '-'),
        array( campo => 'registro',   valor => $this->ruc),
        array( campo => 'tipourl',       valor => '1',  filtro => 'N')
        );


        if (empty($dato) ){

                    $idD = $this->bd->JqueryInsertSQL('web_producto',$InsertQuery);

                    $sql = "update xml_sesion  
                    set  idproducto = ".$this->bd->sqlvalue_inyeccion($idD, true)."
                where id_xmlserie =".$this->bd->sqlvalue_inyeccion($codigo, true);


                    $this->bd->ejecutar($sql);
                     return $idD;

        }
 
        return 0;

        }
    /*
    inserta
    */    
    function nuevo($id ,$bodega){
        
        //---------------------------------------------------
        $IVA               =  $this->bd->_catalogo_iva();
        $IVADesglose       =  1 + $IVA;
        $id_movimiento     =  $id;
       
        $sql = "SELECT id_xmlserie, etiqueta, sesion, cantidad, precio, total,idproducto
        from xml_sesion
       where   idproducto > 0 and  
                sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion, true).' order by etiqueta' ;


  
  $stmt = $this->bd->ejecutar($sql);

  while ($x=$this->bd->obtener_fila($stmt)){
        
                $costo    = $x['precio'];
                $cantidad = $x['cantidad'];

                $baseiva     = $costo * $cantidad ;
                $monto_iva   = round($baseiva * $IVA,2);
                $total       = $monto_iva + $baseiva ;
                $tarifa_cero = '0.00';

                $id_producto =  $x['idproducto'];
 

                    $ATabla = array(
                        array( campo => 'idproducto',   tipo => 'VARCHAR2',   id => '0',  add => 'S',   edit => 'S',   valor => $id_producto,   filtro => 'N',   key => 'N'),
                        array( campo => 'cantidad',   tipo => 'NUMBER',   id => '1',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
                        array( campo => 'id_movimiento',   tipo => 'NUMBER',   id => '2',  add => 'S',   edit => 'N',   valor => $id_movimiento,   filtro => 'N',   key => 'N'),
                        array( campo => 'id_movimientod',   tipo => 'NUMBER',   id => '3',  add => 'N',   edit => 'N',   valor => '-',   filtro => 'N',   key => 'S'),
                        array( campo => 'costo',   tipo => 'NUMBER',   id => '4',  add => 'S',   edit => 'S',   valor => $costo,   filtro => 'N',   key => 'N'),
                        array( campo => 'total',   tipo => 'NUMBER',   id => '5',  add => 'S',   edit => 'S',   valor => $total,   filtro => 'N',   key => 'N'),
                        array( campo => 'monto_iva',   tipo => 'NUMBER',   id => '6',  add => 'S',   edit => 'S',   valor => $monto_iva,   filtro => 'N',   key => 'N'),
                        array( campo => 'tarifa_cero',   tipo => 'NUMBER',   id => '7',  add => 'S',   edit => 'S',   valor => $tarifa_cero,   filtro => 'N',   key => 'N'),
                        array( campo => 'estado',   tipo => 'VARCHAR2',   id => '8',  add => 'S',   edit => 'S',   valor => 'S',   filtro => 'N',   key => 'N'),
                        array( campo => 'tipo',   tipo => 'VARCHAR2',   id => '9',  add => 'S',   edit => 'S',   valor => 'I',   filtro => 'N',   key => 'N'),
                        array( campo => 'ingreso',   tipo => 'NUMBER',   id => '10',  add => 'S',   edit => 'S',   valor => $cantidad,   filtro => 'N',   key => 'N'),
                        array( campo => 'egreso',   tipo => 'NUMBER',   id => '11',  add => 'S',   edit => 'S',   valor => '0.00',   filtro => 'N',   key => 'N'),
                        array( campo => 'baseiva',   tipo => 'NUMBER',   id => '12',  add => 'S',   edit => 'N',   valor => $baseiva,   filtro => 'N',   key => 'N'),
                        array( campo => 'sesion',   tipo => 'NUMBER',   id => '13',  add => 'S',   edit => 'N',   valor => $this->sesion,   filtro => 'N',   key => 'N')
                    );
                    
                    
                    $this->bd->_InsertSQL('inv_movimiento_det',$ATabla, '-' );
        
        }
        
        $sql = "DELETE  from xml_sesion
                 WHERE   idproducto > 0 and  
                         sesion = ".$this->bd->sqlvalue_inyeccion($this->sesion, true);
   
       $this->bd->ejecutar($sql);

    }
   

}
 

/*
LLamada a la funcion de insertar xml
*/
 
 
$gestion   = 	new proceso;
    
    
    $archivo =     $_GET["archivo"];
    
    $id 	 =     $_GET["id"];
    
    $bodega  =     $_GET["bodega"];

    $tipo   =     $_GET["tipo"];

    if (  $tipo   == '1'){
     $gestion->archivo_xml( $archivo ,$id,$bodega);
    }

    if (  $tipo   == '2'){
        $gestion->genera_xml( );
       }

    if (  $tipo   == '3'){
        $id 	 =     $_GET["id"];
        $codigo	 =     $_GET["codigo"];
        $gestion->copiar_producto($id ,$codigo );
      }

      if (  $tipo   == '4'){
        $bodega 	     =     $_GET["bodega"];
        $producto	     =     $_GET["producto"];
        $codigo 	     =     $_GET["codigo"];
        $costo	         =     $_GET["costo"];
        
       
        $gestion->agrega_producto($bodega ,$producto ,$codigo,$costo);

      }

      if (  $tipo   == '5'){
        $bodega 	     =     $_GET["bodega"];
        $costo	         =     $_GET["costo"];
        
       
        $gestion->nuevo($id ,$bodega );

      }

      
 
?>