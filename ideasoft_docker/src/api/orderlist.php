<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    
    include_once '../config/database.php';
    include_once '../config/function.php';
    include_once '../class/userauth.php';
    include_once '../class/order.php';
    include_once '../class/product.php';

    $database = new Database();
    $db = $database->getConnection();
    $order_ar = new Order($db);
    $id=(isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    $order_item = $order_ar->getorders($id);            
    $order_count = $order_item->rowCount();
            
            if($order_count > 0){        
                $orderArr = array();$x=0;$y=0;      
                while ($row = $order_item->fetch(PDO::FETCH_ASSOC)){                    
                    extract($row);
                    $order_total=0;
                    $orderArr[$x]['order_id']=$order_id;
                    $orderArr[$x]['customer_id']=$customer_id;
                    
                    $order_detail_ar = new Order($db);
                    $order_detail = $order_detail_ar->getorders_detail($customer_id,$order_id);
                    while ($rowdetail = $order_detail->fetch(PDO::FETCH_ASSOC)){
                        extract($rowdetail);
                        $orderArr[$x]['items'][$y]['product_id']=$product_id;
                        $orderArr[$x]['items'][$y]['quantity']=$quantity;
                        
                        $product_ar = new Product($db);
                        $product_detail = $product_ar->getproducts_detail($product_id);
                        while ($productdetail = $product_detail->fetch(PDO::FETCH_ASSOC)){
                            extract($productdetail);
                            $orderArr[$x]['items'][$y]['name']=$name;
                            $orderArr[$x]['items'][$y]['unitPrice']=$price;
                            $orderArr[$x]['items'][$y]['total']=number_format(($price*$quantity), 2, '.', '');
                            $order_total+=($price*$quantity);
                        }
                        $y++;
                    }                                        
                    $orderArr[$x]['order_date']=$order_date;
                    $orderArr[$x]['total']=$order_total;
                    $x++;
                }
                echo json_char($orderArr);
            }
            else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "No record found.")
                );
            }                   
?>