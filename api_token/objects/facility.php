<?php
include_once '../token_validate.php';
class facility{
  
    // database connection and table name
    private $conn;
    private $table_name = "facility";
  
    // object properties
    public $FacID;
    public $FacName;
    public $CreateDate;
    public $LocID;
    public $LocAddress;
    public $LocCity;
    public $TagName;
    public $token;
    public $New_FacName;
    public $New_TagName;
    public $cs;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    function tokvalid(){
        $val = new token_validate();
        if($val->valid($this->token)){
            return true;
        }
        else{
            return false;
        }
    }

    function readOne(){
        if($this->tokvalid()){
        $query= "SELECT p.FacID, p.FacName,TagName,LocCity 
        FROM ".$this->table_name." p INNER JOIN tags t ON p.FacID = t.FacID 
        INNER JOIN location l On p.FacID=l.FacID
         WHERE  p.FacName=? AND t.TagName = ?";

        $stmt = $this->conn->prepare($query);

        
        
        
        $stmt->bindParam(1, $this->FacName);
        $stmt->bindParam(2, $this->TagName);
        
        $stmt->execute();
       

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
    $this->FacID = $row['FacID'];
    $this->FacName = $row['FacName'];
    $this->TagName= $row['TagName'];
    $this->LocCity= $row['LocCity'];
   
}else{
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "ENTER VALID TOKEN"));
}
}

    function search(){
        if($this->tokvalid()){
        $query= "SELECT p.FacID, p.FacName,TagName,LocCity 
        FROM ".$this->table_name." p INNER JOIN tags t ON p.FacID = t.FacID 
        INNER JOIN location l On p.FacID=l.FacID
         WHERE  t.TagName=? OR  l.LocCity=? OR p.FacName = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->TagName);
        $stmt->bindParam(2, $this->LocCity);
       $stmt->bindParam(3, $this->FacName);
       
        $stmt->execute();
       

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
    $this->FacID = $row['FacID'];
    $this->FacName = $row['FacName'];
    $this->TagName= $row['TagName'];
    $this->LocCity= $row['LocCity'];
        }
        else{
            echo "NO Authorizarion";
        }
    }

    function create(){
        if($this->tokvalid()){ 
            $query ="INSERT INTO facility(FacName) SELECT *FROM (SELECT ? AS FacName)AS FacTag 
            WHERE NOT EXISTS (SELECT FacName FROM facility WHERe FacName=?);
            INSERT INTO tags(FacID,TagName) SELECT (SELECT FacID FROM facility WHERE FacName=?),? 
            FROM DUAL WHERE NOT EXISTS(SELECT * FROM tags WHERE FacID = (SELECT FacID FROM facility WHERE FacName=?) 
            AND TagName=?);
            INSERT INTO `location`(FacID,LocCity) SELECT(Select FacID FROM facility WHERE FacName=?),? 
            FROM DUAL WHERE NOT EXISTS (SELECT * FROM `location` WHERE FacID = (SELECT FacID FROM facility WHERE FacName=?)AND LocCity=?)";
    
                $stmt = $this->conn->prepare($query);

                //clean
                $this->FacName=htmlspecialchars(strip_tags($this->FacName));
                $this->TagName=htmlspecialchars(strip_tags($this->TagName));
                $this->LocCity=htmlspecialchars(strip_tags($this->LocCity));
           
                //bindig
                $stmt->bindParam(1, $this->FacName);
                $stmt->bindParam(2, $this->FacName);
                $stmt->bindParam(3, $this->FacName);
                $stmt->bindParam(4, $this->TagName);
                $stmt->bindParam(5, $this->FacName);
                $stmt->bindParam(6, $this->TagName);
                $stmt->bindParam(7, $this->FacName);
                $stmt->bindParam(8, $this->LocCity);
                $stmt->bindParam(9, $this->FacName);
                $stmt->bindParam(10, $this->LocCity);
        
                if($stmt->execute()){
                    return true;
                }
              
                return false;
           
           
           
            }
        else
        {
            return false;
        }
    }
    function update(){
        if($this->tokvalid()){
        if($this->cs == 1)
        {
            $query = "UPDATE `facility` SET `FacName`=? WHERE `FacName` = ?";
            $stmt = $this->conn->prepare($query);
            
            $this->FacName=htmlspecialchars(strip_tags($this->FacName));
            $this->New_FacName=htmlspecialchars(strip_tags($this->New_FacName));
            $stmt->bindParam(1, $this->New_FacName);
            $stmt->bindParam(2, $this->FacName);
            if($stmt->execute()){
                return true;
            }

            else{ 
            return false;
            }

        }
        else if($this->cs == 2)
        {
            

            $query="UPDATE `tags` SET `TagName`= ? WHERE `FacID` = (SELECT FacID FROM facility WHERE FacName = ?) 
            AND TagName=? ";
            $stmt= $this->conn->prepare($query);
            
            $this->TagName=htmlspecialchars(strip_tags($this->TagName));
            $this->New_TagName=htmlspecialchars(strip_tags($this->New_TagName));
            $this->FacName=htmlspecialchars(strip_tags($this->FacName));
            

            $stmt->bindParam(1, $this->New_TagName);
            $stmt->bindParam(2, $this->FacName);
            $stmt->bindParam(3, $this->TagName);
            
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
        else if($this->cs == 3){
            $query="UPDATE facility, tags
            SET facility.FacName = ?, tags.TagName = ?
            WHERE facility.FacName=? AND tags.TagName=? 
            AND tags.FacID=(SELECT facility.FacID WHERE facility.FacName = ?) " ;

            $stmt= $this->conn->prepare($query);
            
            $this->TagName=htmlspecialchars(strip_tags($this->TagName));
            $this->New_TagName=htmlspecialchars(strip_tags($this->New_TagName));
            $this->FacName=htmlspecialchars(strip_tags($this->FacName));
            $this->New_FacName=htmlspecialchars(strip_tags($this->New_FacName));
        
           
            $stmt->bindParam(1, $this->New_FacName);
            $stmt->bindParam(2, $this->New_TagName);
            $stmt->bindParam(3, $this->FacName);
            $stmt->bindParam(4, $this->TagName);
            $stmt->bindParam(5, $this->FacName);
            
            
            
           
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }
        
        else{
           
            return false;
        }

    }else{
        echo "INVALID TOKEN";

    } 
    }
    function delete(){
        if($this->tokvalid()){ 
        if($this->cs==1){
            $query="DELETE FROM `tags` WHERE FacID=(SELECT FacID From facility WHERE FacName=?);
            DELETE FROM `location` WHERE FacID=(SELECT FacID From facility WHERE FacName=?);
            DELETE From `facility` where FacName=?";

         $stmt= $this->conn->prepare($query);

         $this->FacName=htmlspecialchars(strip_tags($this->FacName));
        
         $stmt->bindParam(1, $this->FacName);
         $stmt->bindParam(2, $this->FacName);
         $stmt->bindParam(3, $this->FacName);

         if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        }
        else if($this->cs == 2){
            $query = "DELETE FROM `tags` WHERE FacID=(SELECT FacID From facility WHERE FacName=?) 
            AND TagName = ?";
            $stmt= $this->conn->prepare($query);
            $this->FacName=htmlspecialchars(strip_tags($this->FacName));
            $this->TagName=htmlspecialchars(strip_tags($this->TagName));
            $stmt->bindParam(1, $this->FacName);
            $stmt->bindParam(2, $this->TagName);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
            
        }}else{
            echo "INVALID TOKEN!";
            return false;
            
        }
        

    }




  
}
?>