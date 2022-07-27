<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    
    include_once '../config/database.php';
    include_once '../config/function.php';
    include_once '../class/userauth.php';
    
    $database = new Database();
    $db = $database->getConnection();
    $customer_ar = new User($db);
    $id=0;
    $id=(isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    $customer_item = $customer_ar->getuserlist($id);            
    $customer_count = $customer_item->rowCount();
            
            if($customer_count > 0){        
                $customerArr = array();     
                while ($row = $customer_item->fetch(PDO::FETCH_ASSOC)){                    
                    extract($row);
                    $e = array(
                        "id" => $customer_id,
                        "name" => $customer_name,
                        "since" => $since,
                        "revenue" => $revenue,
                        "email" => $email
                    );
                    array_push($customerArr, $e);
                }
                echo json_char($customerArr);
            }
            else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "No record found.")
                );
            }                   
?>