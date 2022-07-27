<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../config/function.php';
    include_once '../class/userauth.php';
    include_once '../class/order.php';
    
    $database = new Database();
    $db = $database->getConnection();
    $item = new User($db);
    $order = new Order($db);
    
    $data = json_decode(file_get_contents("php://input"));
    $user = $item->getuser($data->email);   
    while ($userrow = $user->fetch(PDO::FETCH_ASSOC)){                    
        extract($userrow);
        if (@count($data)>0)
        {
            if($password == $data->pass){ 
                if($order->deleteorder($data->order_id,$customer_id)){
                    http_response_code(200);
                    echo json_encode(
                        array("message" => "Order deleted")
                    );
                } else{
                    http_response_code(200);
                    echo json_encode(
                        array("message" => "Data could not be deleted")
                    );
                }
            }
            else
            {
                http_response_code(400);
                echo json_encode(
                    array("message" => "User not found")
                );
            }
        }
        else
        {
            http_response_code(400);
            echo json_encode(
                array("message" => "User not found")
            );
        }
    }
?>