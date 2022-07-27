<?php
    class User{
        private $conn;
        private $db_table = "customer";
        public $customer_id;
        public $customer_name;
        public $since;
        public $revenue;
        public $email;
        public $password;
        
        public function __construct($db){
            $this->conn = $db;
        }

        public function getuser($email){
            $sqlQuery = "SELECT * FROM ". $this->db_table ." WHERE email = '".$email."'";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;            
        }
        
        public function getuserlist($id=0){
            $sqladd="";
            if ($id!=0) $sqladd=" WHERE customer_id=".$id." ";
            $sqlQuery = "SELECT * FROM ".$this->db_table." ".$sqladd." ORDER BY customer_id";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;            
        }
    }
?>

