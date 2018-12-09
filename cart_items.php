<?php
class CartItem{
    private $conn;
    private $table_name = "cart";
    public $Id;
    public $Product_id;
    public $Quantity;
    public $user_id;
    public function __construct($db){
        $this->conn = $db;
    }
public function exists(){
 
    // query to count existing cart item
    $query = "SELECT count(*) FROM " . $this->table_name . " WHERE Product_id=:Product_id AND user_id=:user_id";
    $stmt = $this->conn->prepare( $query );
    $this->Product_id=htmlspecialchars(strip_tags($this->Product_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":Product_id", $this->Product_id);
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_NUM);
 
    // return
    if($rows[0]>0){
        return true;
    }
 
    return false;
}

public function delete(){
    $query = "DELETE FROM " . $this->table_name . " WHERE Product_id=:Product_id AND user_id=:user_id";
    $stmt = $this->conn->prepare($query);
    $this->Product_id=htmlspecialchars(strip_tags($this->Product_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":Product_id", $this->Product_id);
    $stmt->bindParam(":user_id", $this->user_id);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
function update(){
    $query = "UPDATE " . $this->table_name . "
            SET Quantity=:Quantity
            WHERE Product_id=:Product_id AND user_id=:user_id";
    $stmt = $this->conn->prepare($query);
    
    $this->Product_id=htmlspecialchars(strip_tags($this->Product_id));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
    $stmt->bindParam(":Quantity", $this->Quantity);
    $stmt->bindParam(":Product_id", $this->Product_id);
    $stmt->bindParam(":user_id", $this->user_id);
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
function create(){
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                Product_id = :Product_id,
                Quantity = :Quantity,
                user_id = :user_id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $this->Product_id=htmlspecialchars(strip_tags($this->Product_id));
    $this->Quantity=htmlspecialchars(strip_tags($this->Quantity));
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":Product_id", $this->Product_id);
    $stmt->bindParam(":Quantity", $this->Quantity);
    $stmt->bindParam(":user_id", $this->user_id);
    if($stmt->execute()){
        return true;
    }
    return false;
}
public function count(){
    $query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id=:user_id";
    $stmt = $this->conn->prepare( $query );
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":user_id", $this->user_id);
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_NUM);
    return $rows[0];
}
public function read(){
 
    $query="SELECT p.id, p.name, p.price, ci.quantity, ci.quantity * p.price AS subtotal
            FROM " . $this->table_name . " ci
                LEFT JOIN products p
                    ON ci.Product_id = p.id
            WHERE ci.user_id=:user_id";
    $stmt = $this->conn->prepare($query);
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}
public function deleteByUser(){
    $query = "DELETE FROM " . $this->table_name . " WHERE user_id=:user_id";
    $stmt = $this->conn->prepare($query);
    $this->user_id=htmlspecialchars(strip_tags($this->user_id));
    $stmt->bindParam(":user_id", $this->user_id);
    if($stmt->execute()){
        return true;
    }
    return false;
}
}