<?php declare(strict_types = 1);

namespace Controllers;

use Classes\Email;
use Model\Usuarios;
use MVC\Router;


class LoginController{

    public static function login(Router $router){
  
        $alertas = [];
        $usuario = new Usuarios();
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarLogin();
            
            if (empty($alertas)) {
                
                $usuario = Usuarios::where("email", $auth->email);
                unset($usuario->password2);
                
                if (!$usuario || $usuario->confirmado === "0") {
                    Usuarios::setAlerta("error", "El Usuario no Existe o no esta confirmado");

                }else {

                    $resultado = $usuario->comprobar_password($_POST["password"], $usuario->password);
                    
                    if ($resultado) {
                        
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        header("Location: /dashboard");
                        
                    }else {
                        Usuarios::setAlerta("error", "Password Incorrecto");
                    }

                }

               
            }
         }

         $alertas =  Usuarios::getAlertas();
    $router->render("auth/login", [
        "titulo" => "iniciar Sesion",
        "logo" => "UPTASK2",
        "alertas" => $alertas,
        "usuario" => $usuario        
    ]); 

    }

    public static function logout(Router $router){

        session_start();
        
        $_SESSION = [];

        header("Location: /");

    }

    public static function crear(Router $router){

        $usuario = new Usuarios();
        $alertas = [];
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
            if (empty($alertas)) {

            $existeUsuario = Usuarios::where("email", $usuario->email);
            
            if ($existeUsuario) {
                Usuarios::setAlerta("error", "El Usuario ya esta registrado");
                $alertas =  Usuarios::getAlertas();
            }else {
                
                $usuario->hashPassword();
                unset($usuario->password2);
                $usuario->token();
                $usuario->confirmado = 0;
                $resultado = $usuario->guardar();                                
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email->enviarEmail("crear");
                
                if ($resultado["resultado"] === true) {
                    header("Location: /mensaje");
                }
            }

            }
        }
        
        $router->render("auth/crear", [
            "titulo" => "Crear Cuenta",
            "logo" => "UPTASK",
            "usuario" => $usuario,
            "alertas" => $alertas
            
        ]); 
    }
    public static function olvide(Router $router){

        $alertas = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario = new Usuarios($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                
                $usuario = Usuarios::where("email", $usuario->email);
                
                if ($usuario && $usuario->confirmado === "1") {
                    $usuario->token();
                    unset($usuario->password2);
                    $usuario->guardar();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarEmail("cambiar");
                    Usuarios::setAlerta("correcto", "Hemos enviado las instrucciones a tu email");
                }else {
                    Usuarios::setAlerta("error", "El Usuario no Existe o no esta confirmado");
                    
                }
            }
        }

        $alertas =  Usuarios::getAlertas();

        $router->render("auth/olvide", [
            "titulo" => "Olvide mi Password",
            "logo" => "UPTASK",
            "alertas" => $alertas
           
        ]); 

    }

    public static function reestablecer(Router $router){

        $token = s($_GET["token"]);

        if (!$token) {
            header("Location: /");
        }

        $usuario = Usuarios::where("token", $token);
        
        if (empty($usuario)) {
            Usuarios::setAlerta("error", "Token no Valido");
        }
        
       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            unset($usuario->password2);
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if ($resultado) {
                    header("Location: /");  
                }
                
            }
            
        }

        $alertas = Usuarios::getAlertas();

        $router->render("auth/reestablecer", [
            "titulo" => "Reestablecer Password",
            "logo" => "UPTASK",
            "alertas" => $alertas
           
        ]);
    }

    public static function mensaje(Router $router){

        $router->render("auth/mensaje", [
            "titulo" => "Cuenta Creada Exitosamente",
            "logo" => "UPTASK2"
           
        ]);
    }

    public static function confirmar(Router $router){
        $token = s($_GET["token"]);
       
        if (!$token) {
            header("Location: /");
        }

        $usuario = Usuarios::where("token", $token);

        if (empty($usuario)) {
            Usuarios::setAlerta("error", "Token No Valido");
        }else {
            //confirmar cuenta
            $usuario->confirmado = 1;
            $usuario->token = null;

            $usuario->guardar();
            Usuarios::setAlerta("correcto", "Cuenta Confirmada");
        }

        $alertas = Usuarios::getAlertas();
        
        $router->render("auth/confirmar", [
            "titulo" => "Password Confirmada",
            "logo" => "UPTASK",
            "alertas" => $alertas
           
        ]);
    }
}
