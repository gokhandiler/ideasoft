<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ideasoft</title>
    </head>
    <body>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:30px;">
        Ideasoft Take-Home Assesment
    </div>
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Customer
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : GET<br>
        Optional: id [integer]<br>
        Success Response: <br/>
            **Code:** 200 <br />
            [
                {
                    "id": "1",
                    "name": "Gokhan Diler",
                    "since": "2021-07-22",
                    "revenue": "2500.25",
                    "email": "gokdl@hotmail.com"
                }
                ]<br>
        URL : <a href="api/customer.php" target="_blank">Customer List</a>
    </div> 
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>    
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Order List
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : GET<br>
        Optional: id [integer]<br>
        Success Response: <br/>
            **Code:** 200 <br />
            [
                {
                    "order_id": "23",
                    "customer_id": "1",
                    "items": [
                        {
                            "product_id": "3",
                            "quantity": "4",
                            "name": "Viko Kare Anahtar - Beyaz",
                            "unitPrice": "111.28",
                            "total": "445.12"
                        }
                    ],
                    "order_date": "2022-07-26 18:57:29",
                    "total": 445.12
                }
            ]            
            <br>
        URL : <a href="api/orderlist.php" target="_blank">Order List</a>
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Product List
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : GET<br>
        Optional: id [integer]<br>
        Success Response: <br/>
            **Code:** 200 <br />
            [
                {
                    "id": "1",
                    "name": "Black&Decker A7062 40",
                    "price": "120.75",
                    "category_id": "1",
                    "stock": "9"
                },
                {
                    "id": "4",
                    "name": "Legrand Salbei Anahtar",
                    "price": "88",
                    "category_id": "2",
                    "stock": "10"
                }
            ]            
            <br>
            URL : <a href="api/product.php" target="_blank">Product List</a>
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Order User
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : POST<br>
        Basic authentication <br>
        Required: {
                    "email": "gokdl@hotmail.com",
                    "pass": "E!25aetY234"
                    }<br>
        Success Response: <br/>
            **Code:** 200 <br />
            [
                    {
                        "order_id": "24",
                        "customer_id": "1",
                        "items": [
                            {
                                "product_id": "2",
                                "quantity": "4",
                                "name": "Reko Mini Tamir Hassas Tornavida Seti 32'li",
                                "unitPrice": "149.5",
                                "total": 598
                            },
                            {
                                "product_id": "4",
                                "quantity": "2",
                                "name": "Legrand Salbei Anahtar",
                                "unitPrice": "88",
                                "total": 176
                            },
                            {
                                "product_id": "5",
                                "quantity": "3",
                                "name": "Schneider Asfora Beyaz",
                                "unitPrice": "72.95",
                                "total": 218.85000000000002
                            }
                        ],
                        "order_date": "2022-07-27 11:53:29",
                        "total": 992.85
                    },
                    {
                        "order_id": "23",
                        "customer_id": "1",
                        "items": {
                            "3": {
                                "product_id": "3",
                                "quantity": "4",
                                "name": "Viko Kare Anahtar - Beyaz",
                                "unitPrice": "111.28",
                                "total": 445.12
                            },
                            "4": {
                                "product_id": "2",
                                "quantity": "1",
                                "name": "Reko Mini Tamir Hassas Tornavida Seti 32'li",
                                "unitPrice": "149.5",
                                "total": 149.5
                            },
                            "5": {
                                "product_id": "1",
                                "quantity": "1",
                                "name": "Black&Decker A7062",
                                "unitPrice": "120.75",
                                "total": 120.75
                            }
                        },
                        "order_date": "2022-07-26 18:57:29",
                        "total": 715.37
                    }
                ]           
            <br>
            Error Response: <br/>
            **Code:** 404 <br />
            {
                "message": "User not authentication"
                }<br><br>
                    Test: 
                    <form action="api/sendreq.php" method="post" target="_blank">
                <input type="text" id="page1" name="page1" value='orderuser' style="display: none;"><br>
                <textarea id="data1" name="data1" rows="4" cols="50">{"email": "gokdl@hotmail.com","pass": "E!25aetY234"}</textarea><br>
                    <input type="submit"></form>
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        New Order
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : POST<br>
        Basic authentication. Items Product tablosunda yer alan stock'dan eksiltilir. <br>
        Required: {
                "email": "gokdl@hotmail.com",
                "pass": "E!25aetY234",
                "items": [
                    {
                        "productId": 5,
                        "quantity": 3              
                    },
                    {
                        "productId": 4,
                        "quantity": 2                
                    },
                    {
                        "productId": 2,
                        "quantity": 4                
                    }
                ]
            }        
        <br>
        Success Response: <br/>
            **Code:** 200 <br />
            {
                "message": "Order Created"
            }          
            <br>
            Error Response: <br/>
            **Code:** 200 <br />
            {
                "error": "Stock not found : Reko Mini Tamir Hassas Tornavida Seti 32'li"
                }<br><br>Test: 
                    <form action="api/sendreq.php" method="post" target="_blank">
                <input type="text" id="page2" name="page2" value='neworder' style="display: none;"><br>
                <textarea id="data2" name="data2" rows="4" cols="50">{"email": "gokdl@hotmail.com","pass": "E!25aetY234","items": [{"productId": 5,"quantity": 3},{"productId": 4,"quantity": 2},{"productId": 2,"quantity": 4}]}</textarea><br>
                <input type="submit"></form>
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Delete Order
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : POST<br>
        Basic authentication. Silinen Items Product tablosunda yer alan stock'a eklenir. <br>
        Required: {
                "email": "gokdl@hotmail.com",
                "pass": "E!25aetY234",
                "order_id":"16"
                }        
        <br>
        Success Response: <br/>
            **Code:** 200 <br />
            {
                "message": "Order deleted"
            }        
            <br>
            Error Response: <br/>
            **Code:** 400 <br />
            {
                "message": "User not found"
                }<br><br>
                    Test: 
                    <form id="dataform" action="api/sendreq.php" method="post" target="_blank">
                <input type="text" id="page" name="page" value='orderdelete' style="display: none;"><br>
                <textarea id="data" name="data" rows="4" cols="50">{"email": "gokdl@hotmail.com","pass": "E!25aetY234","order_id":"16"}</textarea><br>
                <input type="submit" form="dataform"></form>
            </form>
            
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    <div style="border:3px solid #000000;width:50%;padding:5px;floa:left;margin:10px;font-weight: bold;font-size:20px;">
        Discount
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: normal;font-size:20px;">
        Method : GET<br>
        Required: id [integer]<br>
        Success Response: <br/>
            **Code:** 200 <br />
            [
    {
        "order_id": "23",
        "discounts": [
            {
                "discountReason": "OVER_2_PER_20",
                "discountAmount": "24.15",
                "subtotal": "691.22"
            }
        ],
        "totalDiscount": "24.15",
        "discountedTotal": "691.22"
    }
]          
            <br>
            Error Response: <br/>
            **Code:** 400 <br />
            {
                "message": "No record found."
                }<br>
            URL : <a href="api/discount.php" target="_blank">Discount</a>
    </div>
    <div style="width:90%;floa:left;margin:10px;font-weight: bold;font-size:20px;">&nbsp;</div>
    
    </body>
</html>