<?php declare(strict_types = 1);

namespace Controllers;

use Model\Proyecto;
use Model\Usuarios;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        
        session_start();
        isAuth();
        $alertas = [];
        $id = $_SESSION["id"];        
        $proyectos = Proyecto::belongsTo("propetarioid", $id);
    
    $router->render("dashboard/index", [
        "titulo" => "Dashboard",
        "pagina" => "Proyectos",
        "logo" => "UPTASK2",
        "alertas" => $alertas,
        "proyectos" => $proyectos      
    ]); 

    }

    public static function crearproyecto(Router $router){
        
        session_start();
        isAuth();
        $alertas = [];
       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();
            
            if (empty($alertas)) {
                //URL
                $url =md5(uniqid());
                $proyecto->url = $url;
                $proyecto->propetarioid = $_SESSION["id"];
                $proyecto->guardar();
                
                header("Location: /proyecto?id=" . $proyecto->url);
                
                
            }
        }   
       
    $router->render("dashboard/crear", [
        "titulo" => "Dashboard",
        "pagina" => "Crea un Proyecto",
        "logo" => "UPTASK2",
        "alertas" => $alertas      
    ]); 

    }

    public static function perfil(Router $router){
        
        session_start();
        isAuth();

        $usuario = Usuarios::find($_SESSION["id"]);
        $alertas = [];   
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if (empty($alertas)) {

                $existeUsuario = Usuarios::where("email", $usuario->email);
                

                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    Usuarios::setAlerta("error", "El Email ya esta registrado");
                    $alertas = $usuario->getAlertas();
                }else{
                    $usuario->guardar();

                if ($usuario) {
                    Usuarios::setAlerta("correcto", "Guardado Correctamente");
                    $alertas = $usuario->getAlertas();
                    $_SESSION["nombre"] = $usuario->nombre;
                }
                }
                
               
            }
        }
       
    $router->render("dashboard/perfil", [
        "titulo" => "Dashboard",
        "pagina" => "Perfil",
        "logo" => "UPTASK2",
        "usuario" => $usuario,
        "alertas" => $alertas      
    ]); 

    }

    public static function proyecto(Router $router){
        
        session_start();
        isAuth();
        $token = $_GET["id"];
         

       if (!$token) {
        header("Location: /dashboard");
       }
       $proyecto = Proyecto::where("url", $token);
       if ($proyecto->propetarioid !== $_SESSION["id"]) {
            header("Location: /dashboard");
       }
    //    debuguear($proyecto);
    $router->render("dashboard/proyecto", [
        "titulo" => $proyecto->proyecto,
        "pagina" => $proyecto->proyecto,
        "logo" => "UPTASK2"
            
    ]); 

    }

    public static function cambiar_password(Router $router){
        
        session_start();
        isAuth();
        $alertas = []; 

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $usuario = Usuarios::find($_SESSION["id"]);
            $usuario->sincronizar($_POST);
            
            $alertas = $usuario->nuevo_password();
            
            if (empty($alertas)) {
                
                $resultado = $usuario->comprobar_password($usuario->password_actual, $usuario->password);  
                
                if ($resultado) {
                    
                    $usuario->password = $usuario->password_nuevo;
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    $usuario->hashPassword();
                    $usuario->guardar();

                    if ($usuario) {
                        Usuarios::setAlerta("correcto", "Password Guardado Correctamente");
                        $alertas = $usuario->getAlertas();                        
                    }
                    
                }else {
                    Usuarios::setAlerta("error", "Password Incorrecto");
                    $alertas = Usuarios::getAlertas();
                }

            }
        }
    
    $router->render("dashboard/cambiar-password", [
        "titulo" => "Cambiar Password",
        "pagina" => "Cambiar Password",
        "logo" => "UPTASK2",        
        "alertas" => $alertas
            
    ]); 

    }

}