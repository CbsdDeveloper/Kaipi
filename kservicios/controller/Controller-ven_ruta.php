<?php 
    session_start( );   
    
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
    require '../../kconfig/Set.php'; /*Incluimos el fichero de la clase objetos*/
  
    class componente{
 
      private $obj;
      private $bd;
      private $set;
      
      private $sesion;
      private $hoy;
      private $POST;
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){

                //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                $this->set     = 	new ItemsController;
                   
                $this->bd	   =	new  Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->sesion 	 =  $_SESSION['email'];
         
 
      }
       //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase  
      //-----------------------------------------------------------------------------------------------------------
      function FiltroFormulario( $id , $idprov ){
      


        $this->obj->text->texto_oculto("tdescuento",$datos); 

        $horaInicial =date("G:h");
 
        $minutoAnadir=120;
        
        $segundos_horaInicial=strtotime($horaInicial);
        
        $segundos_minutoAnadir=$minutoAnadir*60;
        
        $nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);


 

        $sql = "SELECT *
                FROM rentas.ren_frecuencias
                where idprov = ".$this->bd->sqlvalue_inyeccion( trim( $idprov),true)." and 
                    hora between ".$this->bd->sqlvalue_inyeccion( $horaInicial,true). ' and '.$this->bd->sqlvalue_inyeccion($nuevaHora,true);
        
        $AMatriz = $this->bd->query_array('rentas.ren_frecuencias',    
        'count(*) as nn',                        // CAMPOS
        "idprov = ".$this->bd->sqlvalue_inyeccion(  trim($idprov),true)." and 
        hora between ".$this->bd->sqlvalue_inyeccion( $horaInicial,true). ' and '.$this->bd->sqlvalue_inyeccion($nuevaHora,true)
        );	

      


        $existe_variables =   $AMatriz['nn'];
 

         
            if (  $existe_variables > 0 ){

                        $datos['valida_frecuencia'] = 1;

                        $stmt =  $this->bd->ejecutar($sql);


                        echo '  <div class="list-group">
                                <a href="#" class="list-group-item active">Frecuencias Activas</a>';

                                while ($fila= $this->bd->obtener_fila($stmt)){
                                                
                    
                                    $codigo = $fila['id_fre'] ;
                                    $marca  = trim($fila['ruta_ori']) .'/'. trim($fila['ruta_des']);
                                    $pvp    = $fila['hora'] ;

                                    $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                    
                                    echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';
                    
                                }
                                $this->obj->text->texto_oculto("ruta",$datos); 

                                $codigo = '-1';
                                $pvp    = '00' ;
                                $marca  = 'RUTA SAN VICENTE';
                                $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                                echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';

                    echo '  </div>';
                }else{

                    echo '  <div class="list-group">
                             <a href="#" class="list-group-item active">Frecuencias Activas</a>';
  
                             $codigo = '-1';
                             
                             $pvp    = '00' ;
                             $marca  = 'BAHIA/QUITO';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';

                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';
         
                             $marca  = 'BAHIA/GUAYAQUIL';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';

                             $marca  = 'BAHIA/MANTA';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';
 
                 
                             $marca  = 'BAHIA/PORTOVIEJO';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';

                             $marca  = 'BAHIA/OTRAS RUTAS';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';


                             $marca  = 'RUTA SAN VICENTE';
                             $evento = ' onClick="InsertaFrecuencia_guarda('.$codigo.','."'".$marca."'".','."'".$pvp ."'".')" ';
                             echo ' <a href="#" '.$evento.' class="list-group-item"><b>'.$marca.' </b><span class="badge">'.$pvp .'</span></a>';


                     echo '  </div>';

                     $datos['valida_frecuencia'] = 2;
                }

                $this->obj->text->texto_oculto("valida_frecuencia",$datos); 
      }
 ///------------------------------------------------------------------------
 }    

   $gestion   = 	new componente;
 
   $id	            =	$_GET["id_movimiento"];
   $idprov      	=	$_GET["idprov"];

   $gestion->FiltroFormulario( $id , trim($idprov) );
 

 ?>