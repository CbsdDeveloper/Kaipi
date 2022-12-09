<?php

session_start( );


 $tipo     = trim($_GET['tipo']) ;
    
 

    if ( $tipo == 'vacaciones'){
        
        echo '<option value="'.'Vacaciones'.'">'.'Vacaciones'.'</option>';
        
    }else{
        
        echo '<option value="'.'Asunto Oficial'.'">'.'Permiso - Asunto Oficial'.'</option>';
        echo '<option value="'.'Estudios Regulares'.'">'.'Permiso - Estudios Regulares'.'</option>';
        echo '<option value="'.'Atención Medica'.'">'.'Permiso - Atención Medica'.'</option>';
        echo '<option value="'.'Cuidado Del Recien Nacido'.'">'.'Cuidado Del Recien Nacido'.'</option>';
        echo '<option value="'.'Representación De Una Asociación Laboral'.'">'.'Representación De Una Asociación Laboral'.'</option>';
        echo '<option value="'.'Cuidado De Familiares Con Discapacidades Severas'.'">'.'Cuidado De Familiares Con Discapacidades Severas'.'</option>';
        echo '<option value="'.'Cuidado De Familiares Con Enfermedades Catastróficas'.'">'.'Cuidado De Familiares Con Enfermedades Catastróficas'.'</option>';
        echo '<option value="'.'Matriculación De Hijos O Hijas'.'">'.'Matriculación De Hijos O Hijas'.'</option>';
        echo '<option value="'.'Otros'.'">'.'Otros'.'</option>';
         
    }

  
 

?>