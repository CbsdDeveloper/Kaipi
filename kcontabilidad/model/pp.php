<?php 
    session_start( );   
  
    require '../../kconfig/Db.class.php';   /*Incluimos el fichero de la clase Db*/
    
    require '../../kconfig/Obj.conf.php'; /*Incluimos el fichero de la clase objetos*/
	
     
	$bd	   = new Db ;
	
 	
    $bd->conectar($_SESSION['us'],'',$_SESSION['ac']);
	
      
    if(isset($_POST['querystr'])){
        
         
        
        
        $results = array('error' => false, 'data' => '');
        
        
        
        $querystr = $_POST['querystr'];
        
        
        
        if(empty($querystr)){
            
            $results['error'] = true;
            
        }else{
            
            $sql = "SELECT * FROM co_plan_ctas WHERE cuenta LIKE '$querystr%'";
            
            $stmt = $bd->ejecutar($sql);
            
            
            
         //   if($sqlquery->num_rows > 0){
                
            while ($ldata=$bd->obtener_fila($stmt)){
                    
                    $results['data'] .= "
                        
						<li class='list-gpfrm-list' data-fullname='".trim($ldata['detalle'])." ".trim($ldata['cuenta'])."'>".trim($ldata['detalle'])." ".trim($ldata['cuenta'])."</li>
						    
					";
                    
                }
                
           /* }
            
            else{
                
                $results['data'] = "
                    
					<li class='list-gpfrm-list'>No found data matches Records</li>
                    
				";
                
            }*/
            
        }
        
        
        
        echo json_encode($results);
        
    }
     
    
?>