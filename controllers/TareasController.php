<?php declare(strict_types = 1);

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareasController{

    public static function index(){
        session_start();
        isAuth();

        $proyecto = Proyecto::where("url", $_GET["id"]);
        $proyectoid = $proyecto->id;

        if (!$proyectoid || !$proyecto || !$_GET["id"]) {
            header("Location: /dashboard");
        }
        if ($proyecto->propetarioid !== $_SESSION["id"]) {
            header("Location: /404");
        }    
        $tareas = Tarea::belongsTo("proyectoid", $proyectoid);
        echo json_encode(["tareas"=> $tareas]);
        
        
    }

    public static function crear(){
      
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                
            session_start();
            isAuth();

            $proyecto = Proyecto::where("url", $_POST["proyectoid"]);

            if (!$proyecto || $proyecto->propetarioid !== $_SESSION["id"]) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al agregar la tarea"
                ];
                echo json_encode($respuesta);
            }else {
                
            $tarea = new Tarea($_POST);
                $tarea->proyectoid = $proyecto->id;                
               $resultado = $tarea->guardar();
               $respuesta = [
                "id" => $resultado["id"],
                "proyectoid" => $proyecto->id,
                "tipo" => "correcto",
                "mensaje" => "Tarea agregada correctamente"
            ];
                echo json_encode($respuesta);
        }     
           

                
                
        }
    }

    public static function actualizar(){
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
                
            session_start();
            isAuth();

            
            $proyecto = Proyecto::where("url", $_POST["url"]);
            $proyecto2 = Proyecto::where("id", $_POST["proyectoid"]);
            
            if (!$proyecto || $proyecto->propetarioid !== $_SESSION["id"] || $proyecto->id !== $proyecto2->id) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al agregar la tarea"
                ];
                echo json_encode($respuesta);
            }else {
                
            $tarea = new Tarea($_POST);                       
            $resultado = $tarea->guardar();

            if ($resultado === true) {
                $respuesta = [                    
                    "id" => $tarea->id,
                    "nombre" => $tarea->nombre,
                    "estado" => $tarea->estado,
                    "proyectoid" => $tarea->proyectoid,
                    "tipo" => "correcto",
                    "mensaje" => "Tarea actualizada correctamente"
                    
            ];
            
                       
            }else{
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al actualizar la tarea"
                    
            ];
            }
            
            echo json_encode($respuesta); 
        }    
    }
  }
    public static function eliminar(){
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            session_start();
            isAuth();

            $proyecto = Proyecto::where("url", $_POST["url"]);
            $proyecto2 = Proyecto::where("id", $_POST["proyectoid"]);
            
            if (!$proyecto || $proyecto->propetarioid !== $_SESSION["id"] || $proyecto->id !== $proyecto2->id) {
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un Error al eliminar la tarea"
                ];
                echo json_encode($respuesta);
            }else {
                
            $tarea = new Tarea($_POST);                                  
            $resultado = $tarea->eliminar();

            if ($resultado === true) {
                $respuesta = [                    
                    "id" => $tarea->id,
                    "nombre" => $tarea->nombre,
                    "estado" => $tarea->estado,
                    "proyectoid" => $tarea->proyectoid,
                    "tipo" => "correcto",
                    "mensaje" => "Tarea eliminada correctamente"
                    
            ];
            
                       
            }else{
                $respuesta = [
                    "tipo" => "error",
                    "mensaje" => "Hubo un error al eliminar la tarea"
                    
            ];
            }
            
            echo json_encode($respuesta); 
        } 
        }
    }

}
