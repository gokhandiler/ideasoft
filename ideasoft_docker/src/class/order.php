<?php
    class Order{
        private $conn;
        private $db_table = "orderlist";
        public $order_id;
        public $customer_id;
        public $order_date;
        public $total;

        public function __construct($db){
            $this->conn = $db;
        }
        
        public function getorders($id=0){
            $sqladd="";
            if ($id!=0) $sqladd=" WHERE order_id=".$id." ";
            $sqlQuery = "SELECT * FROM ". $this->db_table ." ".$sqladd." ORDER BY order_id desc";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        public function getorders_user($customer_id){
            $sqlQuery = "SELECT * FROM " . $this->db_table . " where customer_id=".$customer_id." ORDER BY order_id desc";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        public function getorders_detail($customer_id,$order_id){
            $sqlQuery = "SELECT * FROM order_detail where customer_id=".$customer_id." and order_id=".$order_id;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        
        public function getorders_total($order_id){
            $sqlQuery = "SELECT SUM(quantity*price) as total FROM order_detail od, product p where od.product_id=p.product_id and od.order_id=".$order_id;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        public function getorders_category($order_id,$category){
            $sqlQuery = "SELECT quantity,price FROM order_detail od, product p where od.product_id=p.product_id and od.order_id=".$order_id." and p.category_id=".$category." order by price asc";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        
        public function createOrder(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        customer_id = :customer_id, 
                        order_date = :order_date";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
            $this->order_date=htmlspecialchars(strip_tags($this->order_date));
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":order_date", $this->order_date);
            
            if($stmt->execute()){
               $insert_id = $this->conn->lastInsertId();
               return $insert_id;
            }
            return false;
        }
        
        public function createOrder_detail(){
            $sqlQuery = "INSERT INTO order_detail
                    SET
                        customer_id = :customer_id, 
                        order_id = :order_id,
                        product_id = :product_id,
                        quantity = :quantity";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->customer_id=htmlspecialchars(strip_tags($this->customer_id));
            $this->order_id=htmlspecialchars(strip_tags($this->order_id));
            $this->product_id=htmlspecialchars(strip_tags($this->product_id));
            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            $stmt->bindParam(":customer_id", $this->customer_id);
            $stmt->bindParam(":order_id", $this->order_id);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":quantity", $this->quantity);
            
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        function deleteorder_stockupdate($id=0){
            $sqlQuery = "UPDATE product
                        LEFT JOIN
                        order_detail ON order_detail.product_id = product.product_id 
                        SET 
                        stock = product.stock + order_detail.quantity
                        WHERE
                        order_detail.order_id=".$id;
            $stmt = $this->conn->prepare($sqlQuery);
            if($stmt->execute()){
               return true;
            }
            return false;            
        }
        
        function deleteorder($id=0,$customer_id=0){
            $this->deleteorder_stockupdate($id);
            $sqlQuery = "DELETE FROM orderlist WHERE order_id=".$id." and customer_id=".$customer_id;
            $stmt = $this->conn->prepare($sqlQuery);
            if($stmt->execute()){
               return true;
            }
            return false;            
        }

    }
?>

