<?php
    class Product{
        private $conn;
        private $db_table = "product";
        public $product_id;
        public $name;
        public $price;
        public $category_id;
        public $stock;

        public function __construct($db){
            $this->conn = $db;
        }
        public function getproducts(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . " ORDER BY name";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        public function getproducts_detail($product_id){
            $sqlQuery = "SELECT * FROM " . $this->db_table . " where product_id=".$product_id;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        
        public function products_stock($product_id,$quantity){
            $sqlQuery = "UPDATE ".$this->db_table." SET stock=".$quantity." where product_id=".$product_id;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
    }
?>

