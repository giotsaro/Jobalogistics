<?php

class database{

    private  $servername = 'localhost';
    private   $username = 'drivers';
    private  $password = 'drivers';
    private $dbname = "drivers";
    public  $pdo;
    
   
   public function __construct(){
        if(!isset($this->pdo)){
            try{
                $link = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);
                $this->pdo = $link;
            }catch(PDOException $e){
                die("Failed to connect with database".$e->getMessage());
            }
        }
    }
}



$host = "localhost"; /* Host name */
$user = "drivers"; /* User */
$password = "drivers"; /* Password */
$dbname = "drivers"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

?>