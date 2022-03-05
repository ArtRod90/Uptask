<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareasController;
use Model\Proyecto;
use MVC\Router;
$router = new Router();
// echo '<pre>'; var_dump($_SERVER['REQUEST_URI'] ); echo '</pre>'; 
// echo '<pre>'; var_dump($_GET); echo '</pre>';
// exit;
  // Login y Autenticacion
  $router->get("/", [LoginController::class, "login"]);
  $router->post("/", [LoginController::class, "login"]);
  $router->get("/logout", [LoginController::class, "logout"]);

  // Crear
  $router->get("/crear", [LoginController::class, "crear"]);
  $router->post("/crear", [LoginController::class, "crear"]);

  // Formulario de olvide mi password
  $router->get("/olvide", [LoginController::class, "olvide"]);
  $router->post("/olvide", [LoginController::class, "olvide"]);

  // Nuevo password
  if (isset($_GET["token"])) {
  $token = $_GET["token"];
  $router->get("/reestablecer?token=$token", [LoginController::class, "reestablecer"]);
  $router->post("/reestablecer?token=$token", [LoginController::class, "reestablecer"]);
  }
  
  
  // Confirmacion Cuenta
  $router->get("/mensaje", [LoginController::class, "mensaje"]);
  if (isset($_GET["token"])) {
  $token = $_GET["token"];
  $router->get("/confirmar?token=$token", [LoginController::class, "confirmar"]);
  }
    
//ZONA DE PROYECTOS
$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/crear-proyecto", [DashboardController::class, "crearproyecto"]);
$router->get("/crear-proyecto", [DashboardController::class, "crearproyecto"]);
$router->post("/crear-proyecto", [DashboardController::class, "crearproyecto"]);
$router->get("/perfil", [DashboardController::class, "perfil"]);
$router->post("/perfil", [DashboardController::class, "perfil"]);
$router->get("/cambiar-password", [DashboardController::class, "cambiar_password"]);
$router->post("/cambiar-password", [DashboardController::class, "cambiar_password"]);
if (isset($_GET["id"])) {
  $proyecto = $_GET["id"];
  $router->get("/proyecto?id=$proyecto", [DashboardController::class, "proyecto"]);
}


//API
if (isset($_GET["id"])) {
$proyecto = $_GET["id"];  
$router->get("/api/tareas?id=$proyecto", [TareasController::class, "index"]);
}
$router->post("/api/tarea", [TareasController::class, "crear"]);
$router->post("/api/tarea/actualizar", [TareasController::class, "actualizar"]);
$router->post("/api/tarea/eliminar", [TareasController::class, "eliminar"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();