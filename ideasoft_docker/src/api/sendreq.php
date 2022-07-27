<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    
    if (isset($_POST['page'])) 
    {
        $page=$_POST['page'];
        $data=$_POST['data'];
    }
    else if (isset($_POST['page1']))
    {
        $page=$_POST['page1'];
        $data=$_POST['data1'];
    }
    else
    {
        $page=$_POST['page2'];
        $data=$_POST['data2'];
    }
    
    $url = "http://127.0.0.1/api/".$page.".php";
$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => "Accept: application/json\r\n" . "Content-Type: application/json\r\n",
        'content' => $data
    )
);
$context  = stream_context_create($opts);
$result = file_get_contents($url, false, $context);

    
    
    
    echo $result;
?>