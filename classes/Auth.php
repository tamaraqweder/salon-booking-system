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



    public function register($full_name,$email,$password,$phone){

    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$email]);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user)
     {
    return false;
    }


       $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $sql = "INSERT INTO users (full_name, email, password_hash, phone, role)
        VALUES (?, ?, ?, ?, 'customer')";

   $stmt = $this->pdo->prepare($sql);

    return $stmt->execute([$full_name, $email, $hashedPassword, $phone]);

    }





}






?>