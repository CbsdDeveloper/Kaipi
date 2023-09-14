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
 
     function Formulario(  $accion ){



        $x = $this->bd->query_array('view_nomina_user',   // TABLA
                        'completo ,cargo ,unidad ,regimen,idprov',                        // CAMPOS
                        'email='.$this->bd->sqlvalue_inyeccion($this->sesion,true) .' or 
                        sesion_corporativo='.$this->bd->sqlvalue_inyeccion($this->sesion,true)
        );


        if ( $accion ==  'BLD') {

                    $this->set->div_label(12,' Información Personal');

                    echo '<h4>';
                    echo  '<b>'.$x['completo'].'</b><br>'.$x['regimen'].'<br>'.$x['unidad'].'<br>'.$x['cargo'];
                    echo '</h4>';

        }

        $datos = $this->bd->query_array('view_nomina_rol',   // TABLA
        '*',                        // CAMPOS
        'idprov='.$this->bd->sqlvalue_inyeccion( trim($x['idprov']),true));
         

        $idprov = trim($x['idprov']);

        $this->obj->text->texto_oculto("idprov",$datos); 
 

        $this->set->div_label(12,' Verifique la informacion antes de actualizar la información');


        $tipo = $this->bd->retorna_tipo();
            
            
        $sql = "SELECT  id_bien || ' ' as  id,codigo_actual, cuenta || '-' || id_bien, nombre_cuenta ,descripcion,detalle,serie,estado,costo_adquisicion 
                            FROM activo.view_bienes
                            where idprov = ".$this->bd->sqlvalue_inyeccion(trim($idprov)  ,true). ' and 
                                  tipo_bien = '.$this->bd->sqlvalue_inyeccion(trim( $accion)  ,true).' order by nombre_cuenta' ;

 

                
            $resultado = $this->bd->ejecutar($sql);
            
            $this->obj->table->table_basic_js($resultado, // resultado de la consulta
                $tipo,      // tipo de conexoin
                '',         // icono de edicion = 'editar'
                '',			// icono de eliminar = 'del'
                'proceso_doc-0' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                "Nro.Bien, Codigo Anterior, Codigo Actual, Cuenta,Descripcion,Referencia,Serie,Estado,Costo",  // nombre de cabecera de grill basica,
                '9px',      // tamaño de letra
                $accion         // id
                );


   }
   
 
 ///------------------------------------------------------------------------
///------------------------------------------------------------------------
  }
  ///------------------------------------------------------------------------
  ///------------------------------------------------------------------------
   
  
  $gestion   = 	new componente;
  

  $accion    = $_GET['accion'];

  
   
  $gestion->Formulario(  $accion   );
  
 ?>
 
  