<?php 
  

$fileName = trim($_GET['xml']).'_A.xml' ;


 
    $filePath = '../xml/'.$fileName;

 
    $type = filetype($filePath);
    // Get a date and timestamp
     // Send file headers
    header("Content-type: $type");
    header("Content-Disposition: attachment;filename=$fileName");
    header("Content-Transfer-Encoding: binary");
    header('Pragma: no-cache');
    header('Expires: 0');
    // Send the file contents.
    set_time_limit(0);
    readfile($filePath);
    
     exit;
    
 
?>