<?php
include('Db.user.php'); 

class Conf{
    private $_domain;
    private $_userdb;
    private $_passdb;
    private $_hostdb;
    private $_db;
    private $_dbType;
    
    private $_modulo;
    
    private static $_instance;
    
    public $conexion; //creamos la variable donde se instanciará la clase "conexion"
    
    private function __construct(){
        //Datos de configuración de la conexión a la base de datos
        
        global $host;
        global $user;
        global $password;
        global $db;
        global $dbType;
        
        $this->conexion = new conexion();  
        //inicializamos la clase para conectarnos a la bd
       /*
        
       
        
        $host = $this->objects_var->_refd($this->conexion->host());
        
        $user  = $this->objects_var->_refd($this->conexion->user());
        
        $password  = $this->objects_var->_refd($this->conexion->password());
        
        $db  = $this->objects_var->_refd($this->conexion->db());
        
        $dbType = $this->objects_var->_refd($this->conexion->dbType());
      
        
         */
       
 
        
        $user = 'ERPNABON';
        $db = 'cabildo';
        $password = 'AS2X1420';
        $host ='192.168.1.222';
        $dbType = 'oracle';
        
        $this->_userdb	= $user;
        $this->_passdb	= $password;
        $this->_hostdb	= $host ;
        $this->_db		= $db;
        $this->_dbType	= $dbType;
        
    
        
    }
    
    private function __clone(){ }
    
    private function __wakeup(){ }
    
    public static function getInstance(){
        
        
        if (!(self::$_instance instanceof self)){
            self::$_instance=new self();
        }
        return self::$_instance;
        
    }
    
    public function getUserDB(){
        $var=$this->_userdb;
        return $var;
    }
    
    public function getHostDB(){
        $var=$this->_hostdb;
        return $var;
    }
    
    public function getPassDB(){
        $var=$this->_passdb;
        return $var;
    }
    
    public function getDB(){
        $var=$this->_db;
        return $var;
    }
    
    public function getDBType(){
        $var=$this->_dbType;
        return $var;
    }
    
}

?>