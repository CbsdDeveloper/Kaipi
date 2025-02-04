<?php 
     session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
 	
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
    
  
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
      private $anio;
      private $asiento;
      private $id_tramite; 
      //-----------------------------------------------------------------------------------------------------------
      //Constructor de la clase
      //-----------------------------------------------------------------------------------------------------------
      function componente( ){
            //inicializamos la clase para conectarnos a la bd
 
                $this->obj     = 	new objects;
                
                    
                $this->bd	   =	     	new Db ;
             
                $this->bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
      
                $this->ruc       =  $_SESSION['ruc_registro'];
                
                $this->sesion 	 =  trim($_SESSION['email']);
                
                $this->hoy 	     =     date("Y-m-d");  
        
                $this->anio       =  $_SESSION['anio'];
                
       
      }
//-----------------------------------------------------------------------------------------------------------
      function Asiento( $codigo ){
          $this->asiento = $codigo;
          
          $datos = $this->bd->query_array('co_asiento',   // TABLA
              '*',                        // CAMPOS
              'id_asiento='.$this->bd->sqlvalue_inyeccion($this->asiento,true) // CONDICION
              );
          
          $this->id_tramite = $datos['id_tramite'];
          
      }
      //---------------------------------------
      
     function Formulario( $codigo ){
     
         $this->asiento = $codigo;
         
         $datos = $this->bd->query_array('co_asiento',   // TABLA
                                     '*',                        // CAMPOS
                                    'id_asiento='.$this->bd->sqlvalue_inyeccion($this->asiento,true) // CONDICION
             );
 
         $this->id_tramite = $datos['id_tramite'];
         
         $this->obj->text->text('Asiento',"number",'id_asiento',0,10,$datos,'','readonly','div-1-3') ;
         
         $this->obj->text->text('Fecha',"date",'fecha',15,15,$datos,'required','readonly','div-1-3');
         
         
         $this->obj->text->text('Comprobante',"texto",'comprobante',15,15,$datos,'required','readonly','div-1-3');
         
         $this->obj->text->text('Referencia',"texto",'documento',15,15,$datos,'required','readonly','div-1-3');
         
         $this->obj->text->text('Estado',"texto",'estado',15,15,$datos,'','readonly','div-1-3');
           
         
         $this->obj->text->text('Tramite',"texto",'id_tramite',15,15,$datos,'','readonly','div-1-3');
         
         $this->obj->text->editor('Detalle','detalle',3,45,300,$datos,'required','readonly','div-1-11') ;
  
 
       
         
   }
 
   //----------------------------------------------
   function detalle_asiento(){
 
       $sql = 'SELECT a.cuenta, 
                      b.detalle, 
                      COALESCE(a.debe,0) as debe, 
                      COALESCE(a.haber,0) as haber,
                      a.aux, 
                      a.principal, 
                      a.codigo1, 
                      a.partida, 
                      a.item, 
                      a.monto1, 
                      a.monto2,
                      a.id_asientod,
                      b.partida_enlace, 
                      COALESCE(a.debe,0) + COALESCE(a.haber,0) as suma
        FROM public.co_asientod a,  co_plan_ctas b
        where a.id_asiento= '.$this->bd->sqlvalue_inyeccion($this->asiento , true).' and
              b.anio= '.$this->bd->sqlvalue_inyeccion( $this->anio, true).' and
              b.cuenta = a.cuenta
        order by  a.monto2  desc';
 
       
       echo '<table id="jsontableDetalle" class="table  table-hover table-bordered" cellspacing="0" width="100%" style="font-size: 11px"  >
     			<thead>
    			 <tr>
                    <th align="center" width="5%">Acciones</th>
    				<th align="center" width="15%">Cuenta</th>
    				<th align="center" width="35%">Detalle</th>
                    <th align="center" width="15%">Debe</th>
    				<th align="center" width="15%">Haber</th>
    				<th align="center" width="15%">partida</th>
                    </tr>
    			</thead>';
       
 
       $resultado	= $this->bd->ejecutar($sql);
       
       $debe  = 0;
       $haber = 0;
       
       while ($y=$this->bd->obtener_fila($resultado)){
               
               $grupo        =  "'".trim($y['item'])."'";
               $id_asientod  = $y['id_asientod'];
               $cuenta       = trim($y['cuenta']);
               
               
               $cuenta1       =  "'".trim($y['cuenta'])."'";
               
               
               
               
              // id_asiento,cuenta,grupo)
               
               $funcion1  = ' onClick="goToURLAsiento('.$id_asientod.','.$cuenta1.','.$grupo.')" ';
               $title1    = 'data-toggle="modal" data-target="#myModalAsistente" title="Genere asistente de asiento enlace"';
               $boton_gas = '<button   class="btn btn-xs" '.$title1.$funcion1.'><i class="glyphicon glyphicon-th-list"></i></button>&nbsp;';
               
 
 
           echo ' <tr>
                <td>'.$boton_gas.'</td>
				<td>'.$cuenta.'</td>
				<td>'.$y['detalle'].'</td>
                <td align="right">'.trim($y['debe']).'</td>
                <td align="right">'.trim($y['haber']).'</td>
                <td>'.trim($y['partida']).'</td>
                 </tr>';
           
           
           $debe  = $debe +  $y['debe'];
           $haber = $haber + $y['haber'];
           
       }
       
       $saldo = round($debe,2) - round($haber,2);
       
       echo ' <tr>
                <td> </td>
				<td> </td>
				<td> </td>
                <td align="right"><b>'.$debe.'</b></td>
                <td align="right"><b>'.$haber.'</b></td>
                <td align="center"><b>'.$saldo.'</b></td>
                 </tr>';
     
       echo	'</table> ';
       
       $div_mistareas = "ok";
       
       echo $div_mistareas;
      
  }  
   //----------------------------------------------
   function tramite_presupuesto(){
 
       $tipo = $this->bd->retorna_tipo();
 
       
       $sql ="SELECT programa,  sum(compromiso) as compromiso
       FROM presupuesto.view_dettramites
       where id_tramite=".$this->id_tramite.' 
       group by programa
       order by programa' ;
 
 

       if ( $this->id_tramite > 0  ){
       
               $resultado = $this->bd->ejecutar($sql);
               
               
               $this->obj->table->KP_sumatoria(2,1) ;
               
               
               $this->obj->table->table_basic_js($resultado, // resultado de la consulta
                   $tipo,      // tipo de conexoin
                   '',         // icono de edicion = 'editar'
                   '',			// icono de eliminar = 'del'
                   '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                   "Programa,   Monto" , // nombre de cabecera de grill basica,
                   '10px',      // tama�o de letra
                   'id'         // id
                   );
       
       }  
      
        
  }  
  //-------------------
  function tramite_presupuesto_clasificador(){
 
    $tipo = $this->bd->retorna_tipo();

    
    $sql ="SELECT clasificador || ' ' as clasificador,detalle,  sum(compromiso) as compromiso
    FROM presupuesto.view_dettramites
    where id_tramite=".$this->id_tramite.' 
    group by clasificador,detalle
    order by clasificador' ;

 

    if ( $this->id_tramite > 0  ){
    
            $resultado = $this->bd->ejecutar($sql);
            
            
            $this->obj->table->KP_sumatoria(3,2) ;
            
            
            $this->obj->table->table_basic_js($resultado, // resultado de la consulta
                $tipo,      // tipo de conexoin
                '',         // icono de edicion = 'editar'
                '',			// icono de eliminar = 'del'
                '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                "Clasificador,Detalle,   Monto" , // nombre de cabecera de grill basica,
                '10px',      // tama�o de letra
                'ida'         // id
                );
    
    }  
   
     
}  
  ///------------------------------------------------------------------------
  function tramite_contable(){
      
      $tipo = $this->bd->retorna_tipo();
   

      $sql ="SELECT partida || ' ' as partida, sum(debe) as debe, sum(haber)   as haber,  sum(debe) - sum(haber)  as saldo
      FROM view_diario_resumen
      where partida is not null and  id_asiento=".$this->asiento.' 
      group by    partida order by partida' ;


     $this->obj->table->KP_sumatoria(2,1,2,3) ;
  
      
      $resultado1 = $this->bd->ejecutar($sql);
      
      $this->obj->table->table_basic_js($resultado1, // resultado de la consulta
          $tipo,      // tipo de conexoin
          '',         // icono de edicion = 'editar'
          '',			// icono de eliminar = 'del'
          '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
          "Partida, Debe,Haber,Saldo" , // nombre de cabecera de grill basica,
          '10px',      // tama�o de letra
          'idxx'         // id
          );
      
      
///------------------------------------------------------------------------
  }
   ///------------------------------------------------------------------------
   function tramite_contable_detalle(){
      
    $tipo = $this->bd->retorna_tipo();
    

    $sql ="SELECT partida || ' ' as partida
    FROM view_diario_resumen
    where partida is not null and  id_asiento=".$this->asiento.' 
    group by    partida order by partida' ;

 

                $resultado	= $this->bd->ejecutar($sql);
    
                echo '  <ul class="list-group">';

                $i = 1;
                while ($y=$this->bd->obtener_fila($resultado)){

                    echo ' <li class="list-group-item"><b>'.trim($y['partida']).'</b></li>';
                   
                                   $sqlDetalle ="SELECT subgrupo, item || ' ' as item , sum(debe) as debe, sum(haber)   as haber
                                    FROM view_diario_resumen
                                    where partida = ".$this->bd->sqlvalue_inyeccion(trim($y['partida']),true)." and  
                                        id_asiento=".$this->asiento.' 
                                    group by    subgrupo,item order by debe desc, item' ;

                                    $this->obj->table->KP_sumatoria(3,2,3) ;    

                                    $resultado2 = $this->bd->ejecutar($sqlDetalle);
                    
                                    $objeto = 'obj_'.$i;
                                    $this->obj->table->table_basic_js($resultado2, // resultado de la consulta
                                        $tipo,      // tipo de conexoin
                                        '',         // icono de edicion = 'editar'
                                        '',			// icono de eliminar = 'del'
                                        '' ,        // evento funciones parametro Nombnre funcion - codigo primerio
                                        "Grupo, Item, Debe,Haber" , // nombre de cabecera de grill basica,
                                        '10px',      // tama�o de letra
                                        $objeto        // id
                                        );
                
                        $i++;
                }
    
                echo '</ul>';
                
 
///------------------------------------------------------------------------
}
 ///------------------------------------------------------------------------
    }
  
 ?>