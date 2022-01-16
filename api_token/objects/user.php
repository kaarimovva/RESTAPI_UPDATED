<?php
class User{

    private $conn;
    private $table_name = "auth";

    public $id;
    public $name;
    public $password;


    public function __construct($db){
        $this->conn=$db;

    }

    function create(){
    $query="INSERT INTO ".$this->table_name." SET id=?,name= ?,password= ?";
    
    $stmt=$this->conn->prepare($query);

    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->password=htmlspecialchars(strip_tags($this->password));

    $stmt->bindValue(1,$this->id,PDO::PARAM_STR);
    $stmt->bindValue(2,$this->name,PDO::PARAM_STR);
    $password_hash=password_hash($this->password,PASSWORD_BCRYPT);
    $stmt->bindValue(3,$password_hash,PDO::PARAM_STR);

    IF($stmt->execute()){
        return true;
    }else{
        return false;
    }}


    function id_exists(){
        $query="SELECT name, password FROM auth WHERE id=?";
        $stmt=$this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1,$this->id);

        $stmt->execute();

        $num=$stmt->rowCount();

        if($num>0){
            $row=$stmt->fetch(PDO::FETCH_ASSOC);

            //assign properties 
            $this->name=$row['name'];
            $this->password=$row['password'];            
            return true; //because id exist 

        }
      return false;//because id does not exist.
    }

}






?>