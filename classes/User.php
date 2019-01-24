<?php
require_once 'passwordHash.php';
require_once 'DB.php';

/**
 * Description of User
 *
 * @author pedro
 */
class User {
    private $db;
    
    public function __construct() {
        $this->db = new DB();
    }
    
    public function checkUser($username, $pass) {
        $resp = $this->db->query("SELECT * FROM users WHERE username=:user", array(':user' => $username));
        //verificar se a password e utilizador correspondem
        foreach ($resp AS $r){
            if($r['pass'] === $pass){
    //        if (passwordHash::check_password($r['SENHA'], $pass)) { }
                //retorna o token com a indicação change=false (não obriga a alterar a password)
                return $this->generateToken($r);
            }
        }
        return false;
    }

    //Functions
    //Check token and return user ID or false
    function generateToken($resp) {
        //Chave para a encriptação
        $key='klEpFG93';

        //Configuração do JWT
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];

        $header = json_encode($header);
        $header = base64_encode($header);

        //Dados 
        $payload = [
            'iss' => 'WINES',
            'nome' => $resp['nome'],
        ];

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        //Signature

        $signature = hash_hmac('sha256', "$header.$payload", $key,true);
        $signature = base64_encode($signature);
       // echo $header.$payload.$signature;

        echo "$header.$payload.$signature";
    }
}