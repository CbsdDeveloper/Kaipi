<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class _vehiculos_lista{
 
  
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
      function _vehiculos_lista( ){
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  date("Y-m-d");  
				
                 
      }
     //---------------------------------------
     function visor_vehiculos(  $id  ){
      
       
        $sql1 = "select id_bien ,descripcion,placa_ve,tipo_vehiculo 
                   FROM adm.view_bien_vehiculo  limit 10";
                    
        $stmt =  $this->bd->ejecutar($sql1);

  
        $i = 1;
 
        echo '<ul class="list-group">';

        while ($fila= $this->bd->obtener_fila($stmt)){
            
            $codigo            = trim($fila['id_bien']) ;
            $descripcion       = trim($fila['descripcion']) ;
            $placa_ve          = trim($fila['placa_ve']) ;
            $tipo_vehiculo     = trim($fila['tipo_vehiculo']) ;
 
            $evento = ' onClick="agregar_carro('.$codigo.','.$id.')" ';

 

            echo ' <li class="list-group-item"> 
                    <a href="#" title="Asignar Vehiculo a Emergencia" '.$evento.'>'. $descripcion.' '. $placa_ve  .' </a
                    ><span class="badge">'. $tipo_vehiculo  .'</span>';

            
            echo '</li>';
              
  
            $i++;
 
        }
      
        echo ' </ul>';
 
      
   }

   /*
   agregar 
   */
  function add_vehiculos(  $id ,     $idbien){
  
    $tabla 	  	  = 'bomberos.vehiculo_emer_asig';
     
    $secuencia 	     = 'bomberos.vehiculo_emer_asig_id_emer_vehiculo_seq';

    
    $xx = $this->bd->query_array( $tabla ,
	                                'count(*) as nn ',       
                                   'id_bien='.$this->bd->sqlvalue_inyeccion( trim($idbien),true) . ' and 
                                    id_caso='.$this->bd->sqlvalue_inyeccion(   $id ,true)
	        );


    $ATabla = array(
        array( campo => 'id_emer_vehiculo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'id_bien',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idbien, key => 'N'),
        array( campo => 'id_caso',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>$id, key => 'N'),
        array( campo => 'u_km',tipo => 'NUMBER',id => '3',add => 'S', edit => 'S', valor => '0.00', key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '4',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '5',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
        );

        if ( $xx['nn'] > 0  )  {
        
        }else {
        
            $this->bd->_InsertSQL($tabla,$ATabla,$secuencia );
        
         } 

    $this->visor_emer_vehiculos(  $id  );


} 
/*
*/
function km_vehiculos( $id,$id_emer_vehiculo, $valor1,  $valor2  ){
  
    $tabla 	  	  = 'bomberos.vehiculo_emer_asig';
     
    $sql = 'update  '.    $tabla.' 
            set   u_km='.$this->bd->sqlvalue_inyeccion($valor1, true).', 
                  s_km='.$this->bd->sqlvalue_inyeccion($valor2, true).'
            where id_emer_vehiculo='.$this->bd->sqlvalue_inyeccion($id_emer_vehiculo, true);

    $this->bd->ejecutar($sql);
 

} 
/*
*/
function eliminar_vehiculos(  $id ,     $id_emer_vehiculo){
  
    $tabla 	  	  = 'bomberos.vehiculo_emer_asig';
     
    $sql = 'delete from '.    $tabla.'  where id_emer_vehiculo='.$this->bd->sqlvalue_inyeccion($id_emer_vehiculo, true);

    $this->bd->ejecutar($sql);

 
    $this->visor_emer_vehiculos(  $id  );


} 
  //----------------------------------------------
  function visor_emer_vehiculos(  $id  ){
      
       
    $sql1 = "SELECT id_emer_vehiculo, id_bien, id_caso, coalesce(u_km,0) as u_km, 
                      sesion,coalesce(s_km,0) as s_km,
                      fecha, descripcion, placa_ve, tipo_vehiculo 
              FROM bomberos.view_emer_vehiculo 
                where id_caso=".$this->bd->sqlvalue_inyeccion($id  ,true);
                
    $stmt =  $this->bd->ejecutar($sql1);


    $i = 1;
 
    while ($fila= $this->bd->obtener_fila($stmt)){
        
    
        $descripcion       = trim($fila['descripcion']) ;
        $placa_ve          = trim($fila['placa_ve']) ;
        $tipo_vehiculo     = trim($fila['tipo_vehiculo']) ;

        $id_emer_vehiculo            = trim($fila['id_emer_vehiculo']) ;

        $evento = ' onClick="eliminar_carro('.$id_emer_vehiculo.','.$id.')" ';

        $objeto = 'km1_';
      
        $objeto1 = 'km1_'. $id_emer_vehiculo ;
        $objeto2 = 'km2_'. $id_emer_vehiculo ;
        
        $datos[$objeto1] =  $fila['u_km']; 
        $datos[$objeto2] =  $fila['s_km'];
        
      
        echo '<div class="col-md-12" style="padding: 6px">';

        echo '<a href="#" title="Eliminar Vehiculo a Emergencia" '.$evento.'><b>'. $descripcion.'</b> '. $placa_ve  .' </a>
                <span class="badge">'. $tipo_vehiculo  .'</span>';
        
        echo '</div>';
         
        $evento='onChange="Guardakm('."'".$objeto."'".','.$id_emer_vehiculo.',this.value' .')"';
        
        $this->obj->text->text_yellow('Informacion (Km)', 'number' ,$objeto1,70,70,$datos,'required','','div-3-3') ;
        
        $this->obj->text->texte('Llegada  (Km)','number',$objeto2,70,70,$datos,'required','', $evento,'div-3-3') ;
        
          
     
             

        $i++;

    }
  
    

  
}




 }    
   $gestion   = 	new _vehiculos_lista;
   
   
   
   if (isset($_GET['accion']))	{

    $accion        = trim($_GET['accion']);

    $id            = $_GET['id'];
    
    $idbien        = $_GET['idbien'];
    

            if ($accion == 'visor_vehiculo'){
           
                $gestion->visor_vehiculos( $id );
                
            } 

            if ($accion == 'add'){
           
                $gestion->add_vehiculos( $id ,     $idbien);
                
            } 
   
            if ($accion == 'eliminar'){

                $idcodigo =$_GET['idcodigo'];

                $gestion->eliminar_vehiculos( $id ,     $idcodigo);
                
            } 


            if ($accion == 'asignar'){
           
                $gestion->visor_emer_vehiculos( $id);
                
            } 

            if ($accion == 'kmvalor'){
           
                $id_emer_vehiculo =$_GET['id_emer_vehiculo'];
                $valor1  = $_GET['valor1'];
                $valor2  = $_GET['valor2'];

                $gestion->km_vehiculos( $id,$id_emer_vehiculo, $valor1,  $valor2  );
                
            } 

            
            
}  



?>

