<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");    
    include_once '../config/database.php';
    include_once '../config/function.php';
    include_once '../class/product.php';
    
    $database = new Database();
    $db = $database->getConnection();
    $product_ar = new Product($db);
    $id=0;
    $id=(isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : '0';
    $product_item = $product_ar->getproducts($id);            
    $product_count = $product_item->rowCount();
            
            if($product_count > 0){        
                $productArr = array();     
                while ($row = $product_item->fetch(PDO::FETCH_ASSOC)){                    
                    extract($row);
                    $e = array(
                        "id" => $product_id,
                        "name" => $name,
                        "price" => $price,
                        "category_id" => $category_id,
                        "stock" => $stock
                    );
                    array_push($productArr, $e);
                }
                echo json_char($productArr);
            }
            else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "No record found.")
                );
            }                   
?>