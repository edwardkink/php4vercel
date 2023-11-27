<?php
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $res = array(
        'msg' => 'Hello, World'
    );
}else{
    http_response_code(405);
    $res = array(
        'msg' => 'Method Not Allowed'
    );
}
echo json_encode($res);