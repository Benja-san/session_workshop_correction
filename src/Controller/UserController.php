<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string
    {
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $cleanValue = htmlentities(trim($_POST["email"]));
            if(filter_var($cleanValue, FILTER_VALIDATE_EMAIL)){
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($_POST["email"]);
                if($user && password_verify($_POST["password"], $user["password"])){
                    $_SESSION['user_id'] = $user["id"];
                    header("location: /");
                    exit();
                }
            }
        }
        return $this->twig->render('User/login.html.twig');
    }

    public function logout()
    {
        session_destroy();
        header("location: /");
    }

    public function register(): string
    {
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $user = [];
            foreach($_POST as $key => $value){
                if($key === "password"){
                    $user[$key] = password_hash($value, PASSWORD_ARGON2ID);
                } else{
                    $user[$key] = $value;
                }
            }
            $userManager = new UserManager();
            $userManager->insertUser($user);
            header("location: /");
        }
        return $this->twig->render('User/register.html.twig');
    }
}
