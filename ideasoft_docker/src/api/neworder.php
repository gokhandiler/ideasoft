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
    include_once '../class/product.php';
    
    $database = new Database();
    $db = $database->getConnection();
    $item = new User($db);
    $order = new Order($db);
    $product = new Product($db);
    
    $data = json_decode(file_get_contents("php://input"));
    $user = $item->getuser($data->email);   
    while ($userrow = $user->fetch(PDO::FETCH_ASSOC)){                    
        extract($userrow);
        if (@count($data)>0)
        {
            if($password == $data->pass){                 
                $order_created=0;$err=array();
                for($i=0;$i<count($data->items);$i++)
                {
                    $product_stock = $product->getproducts_detail($data->items[$i]->productId);   
                    while ($productstockrow = $product_stock->fetch(PDO::FETCH_ASSOC)){                    
                        extract($productstockrow);
                        if ($stock>$data->items[$i]->quantity)
                        {
                            if ($order_created==0)
                            {
                                $order->customer_id = $customer_id;
                                $order->order_date = date("Y-m-d H:i:s");
                                $orderid=$order->createOrder();
                                $order_created=1;
                                $err["message"]="Order Created";
                            }
                            
                            $order_detail = new Order($db);
                            $order_detail->customer_id = $customer_id;
                            $order_detail->order_id = $orderid;
                            $order_detail->product_id = $data->items[$i]->productId;
                            $order_detail->quantity = $data->items[$i]->quantity;
                            
                            $order_detail->createOrder_detail(); 
                            $product->products_stock($data->items[$i]->productId,($stock-$data->items[$i]->quantity));
                        }
                        else
                        {
                            $err["error"]="Stock not found : ".$name;
                        }
                    }
                }
                
                if ($order_created==1)
                {
                    http_response_code(200);
                    echo json_encode($err);                    
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