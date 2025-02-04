<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
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
   
                $this->obj     = 	new objects;
                $this->set     = 	new ItemsController;
             	$this->bd	   =	new Db;
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
                $this->ruc       =  trim($_SESSION['ruc_registro']);
                $this->sesion 	 =  trim($_SESSION['email']);
                $this->hoy 	     =  date("Y-m-d");  
				
                 
      }
     //---------------------------------------
     function visor_personal(  $id  ){
      
       
        $sql1 = "SELECT idprov, razon, cargo,foto
        FROM public.view_nomina_rol
        where tipo = 'B' order by razon";
                    
                   


        $stmt =  $this->bd->ejecutar($sql1);

  
        $i = 1;
 
        echo '<ul class="list-group">';

        while ($fila= $this->bd->obtener_fila($stmt)){
            
            $codigo            = trim($fila['idprov']) ;
            $descripcion       = trim($fila['razon']) ;
            $foto              = trim($fila['foto']) ;
 
            $evento = ' onClick="agregar_personal('."'".$codigo."'".','.$id.')" ';

 

            echo ' <li class="list-group-item"> <a href="#" title="Asignar Personal a Emergencia" '.$evento.'>'. $descripcion.' '. $placa_ve  .' </a></li>';
              
  
            $i++;
 
        }
      
        echo ' </ul>';
 
      
   }

   /*
   agregar 
   */
  function add_personal(  $id ,     $idprov){
  
    $tabla           = 'bomberos.bombero_emer_asig';
     
    $secuencia 	     = 'bomberos.bombero_emer_asig_id_bom_vehiculo_seq';


    $xx = $this->bd->query_array( $tabla ,
	                                'count(*) as nn ',       
	                                'idprov='.$this->bd->sqlvalue_inyeccion( trim($idprov),true) . ' and 
                                    id_caso='.$this->bd->sqlvalue_inyeccion(   $id ,true)
	        );
 

    $ATabla = array(
        array( campo => 'id_bom_vehiculo',tipo => 'NUMBER',id => '0',add => 'N', edit => 'N', valor => '-', key => 'S'),
        array( campo => 'idprov',tipo => 'NUMBER',id => '1',add => 'S', edit => 'S', valor => $idprov, key => 'N'),
        array( campo => 'id_caso',tipo => 'NUMBER',id => '2',add => 'S', edit => 'S', valor =>$id, key => 'N'),
        array( campo => 'sesion',tipo => 'VARCHAR2',id => '3',add => 'S', edit => 'S', valor =>$this->sesion, key => 'N'),
        array( campo => 'fecha',tipo => 'DATE',id => '4',add => 'S', edit => 'S', valor => $this->hoy, key => 'N'),
        );


        if ( $xx['nn'] > 0  )  {
        
        }else {
        
            $this->bd->_InsertSQL($tabla,$ATabla,$secuencia );
        
         } 


    $this->visor_emer_vehiculos(  $id  );


} 
/*
*/
function eliminar_personal(  $id ,     $id_emer_vehiculo){
  
    $tabla 	  	  = 'bomberos.bombero_emer_asig';
     
    $sql = 'delete from '.    $tabla.'  where id_bom_vehiculo='.$this->bd->sqlvalue_inyeccion($id_emer_vehiculo, true);

    $this->bd->ejecutar($sql);

 
    $this->visor_emer_vehiculos(  $id  );


} 
  //----------------------------------------------
  function visor_emer_vehiculos(  $id  ){
      
       
    $sql1 = "  SELECT *
              FROM bomberos.view_emer_personal 
                where id_caso=".$this->bd->sqlvalue_inyeccion($id  ,true);
                
    $stmt =  $this->bd->ejecutar($sql1);

 
    $i = 1;

    echo '<ul class="list-group">';

    while ($fila= $this->bd->obtener_fila($stmt)){
        
        $codigo            = trim($fila['idprov']) ;
        $descripcion       = trim($fila['razon']) ;
       
        $tipo_vehiculo     = trim($fila['cargo']) ;

        $id_emer_vehiculo            = trim($fila['id_bom_vehiculo']) ;

        $evento = ' onClick="eliminar_personal('.$id_emer_vehiculo.','.$id.')" ';



        echo ' <li class="list-group-item"> <a href="#" title="Eliminar Personal a Emergencia" '.$evento.'>'. $descripcion.' ' .' </a><span class="badge">'. $tipo_vehiculo  .'</span></li>';
          

        $i++;

    }
  
    echo ' </ul>';

  
}




 }    
   $gestion   = 	new componente;
   
   
   
   if (isset($_GET['accion']))	{

    $accion        = trim($_GET['accion']);

    $id            = $_GET['id'];
    
    $idprov        = $_GET['idprov'];
    

            if ($accion == 'visor_personal'){
           
                $gestion->visor_personal( $id );
                
            } 

            if ($accion == 'add'){
           
                $gestion->add_personal( $id ,     $idprov);
                
            } 
   
            if ($accion == 'eliminar'){

                $idcodigo =$_GET['idcodigo'];

                $gestion->eliminar_personal( $id ,     $idcodigo);
                
            } 


            if ($accion == 'asignar'){
           
                $gestion->visor_emer_vehiculos( $id);
                
            } 
            
}  



?>

