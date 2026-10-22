<?php

class Auth{
    private $pdo;

    public function __construct($pdo){
        $this->pdo=$pdo;
    }



    public function login($email,$password){
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt=$this->pdo->prepare($sql);
        $stmt->execute([$email]);


         $user = $stmt->fetch(PDO::FETCH_ASSOC);//بنجيب نتيجة الاستعلام على شكل Associative Array
          if ($user && password_verify($password, $user["password_hash"])) {
            return $user;
        }
            return false;


    }





}






?>