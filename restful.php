<?php


require_once './classes/Wine.php';
require_once './classes/User.php';

//POSTS
if  ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    //LOG IN
    if ($_GET['url'] == "auth") {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $user = new User();
        return $user->checkUser($postBody->username, $postBody->pass);
        http_response_code(200);
        
   } 
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
        if ($_GET['url'] == "wines") {
            $wine = new Wine();
            echo json_encode($wine->getAll());
            http_response_code(200);
        } elseif ($_GET['url'] == "wine") {
            $wine = new Wine();
            echo json_encode($wine->getOne($_GET['id']));
            http_response_code(200);            
        } elseif ($_GET['url'] == "random") {
            $wine = new Wine();
            echo json_encode($wine->getRandom());
            http_response_code(200);     
        } elseif ($_GET['url'] == "search") {
            $wine = new Wine();
            echo json_encode($wine->search($_GET['name']));
            http_response_code(200);            
        }
} else {//Fim dos metodos 
    http_response_code(405);
}




