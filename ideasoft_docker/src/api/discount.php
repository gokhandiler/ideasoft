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
    include_once '../class/discount_rule.php';

    $database = new Database();
    $db = $database->getConnection();
    $order_ar = new Order($db);
    $disc_ar = new Discount();
    $id=(isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    if ($id!=0)
    {
    $order_item = $order_ar->getorders($id);            
    $order_count = $order_item->rowCount();           
            if($order_count > 0){        
                $orderArr = array();$x=0;$y=0;$subtotal=0;$discount_total=0;
                while ($row = $order_item->fetch(PDO::FETCH_ASSOC)){                    
                    extract($row);
                    $order_total=0;
                    $orderArr[$x]['order_id']=$order_id;                    
                    $order_detail_ar = new Order($db);
                    $order_detail = $order_detail_ar->getorders_detail($customer_id,$order_id);
                    $order_total_ar = $order_ar->getorders_total($order_id);
                    while ($rowordertotal = $order_total_ar->fetch(PDO::FETCH_ASSOC)){
                        extract($rowordertotal);
                        $order_total=$total;
                        $subtotal=$order_total;
                    }
                    
                    $order_category_ar = $order_ar->getorders_category($order_id,"1");$category_total=0;$category_min_price=0;$category_min_quantity=0;
                    while ($rowcategorytotal = $order_category_ar->fetch(PDO::FETCH_ASSOC)){
                        extract($rowcategorytotal);
                        $category_total+=$quantity;
                        if ($category_min_price=="0") 
                        { 
                            $category_min_price=$price;
                            $category_min_quantity=$quantity;
                        }
                    }                    
                    
                    if ($category_total>1)
                    {
                        $disc_item = $disc_ar->getOVER2PER20(number_format($order_total, 2, '.', ''),$category_min_price,$category_min_quantity);
                        if (count($disc_item)>0)
                        {
                            for ($i=0;$i<count($disc_item);$i++)
                            {
                                        $orderArr[$x]['discounts'][$y]['discountReason']=$disc_item[$i]['discountReason'];
                                        $orderArr[$x]['discounts'][$y]['discountAmount']=$disc_item[$i]['discountAmount'];                                    
                                        $subtotal=$disc_item[$i]['subtotal'];                                        
                                        $orderArr[$x]['discounts'][$y]['subtotal']=number_format($subtotal, 2, '.', '');
                                        $discount_total+=$disc_item[$i]['discountAmount'];
                                        $y++;
                            }
                        }
                    }    
                    
                    
                    
                    while ($rowdetail = $order_detail->fetch(PDO::FETCH_ASSOC)){
                        extract($rowdetail);
                        
                        $product_ar = new Product($db);
                        $product_detail = $product_ar->getproducts_detail($product_id);
                        while ($productdetail = $product_detail->fetch(PDO::FETCH_ASSOC)){
                            extract($productdetail);
                            $disc_item = $disc_ar->getBUY5GET1(number_format($order_total, 2, '.', ''),$product_id,$category_id,$quantity,$price);
                            if (count($disc_item)>0)
                            {
                                for ($i=0;$i<count($disc_item);$i++)
                                {
                                    $orderArr[$x]['discounts'][$y]['discountReason']=$disc_item[$i]['discountReason'];
                                    $orderArr[$x]['discounts'][$y]['discountAmount']=$disc_item[$i]['discountAmount'];                                    
                                    $subtotal-=$disc_item[$i]['discountAmount'];
                                    $orderArr[$x]['discounts'][$y]['subtotal']=number_format($subtotal, 2, '.', '');                                    
                                    $discount_total+=$disc_item[$i]['discountAmount'];
                                    $y++;
                                }
                            }                            
                        }                        
                    }

                    $disc_item = $disc_ar->gettotal($order_total);
                    if (count($disc_item)>0)
                    {
                        for ($i=0;$i<count($disc_item);$i++)
                        {
                                    $orderArr[$x]['discounts'][$y]['discountReason']=$disc_item[$i]['discountReason'];
                                    $orderArr[$x]['discounts'][$y]['discountAmount']=$disc_item[$i]['discountAmount'];                                    
                                    $subtotal-=$disc_item[$i]['discountAmount'];
                                    $orderArr[$x]['discounts'][$y]['subtotal']=number_format($subtotal, 2, '.', '');
                                    $discount_total+=$disc_item[$i]['discountAmount'];
                        }
                    }
                    
                    $orderArr[$x]['totalDiscount']=number_format($discount_total, 2, '.', '');
                    $orderArr[$x]['discountedTotal']=number_format($subtotal, 2, '.', '');                    
                    $x++;
                }
                echo json_char($orderArr);
            }
            else{
                http_response_code(400);
                echo json_encode(
                    array("message" => "No record found.")
                );
            } 
    }
    else
    {
        http_response_code(400);
                echo json_encode(
                    array("error" => "Id param is must")
                );
    }
?>