<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
 <?php include_once __DIR__ . "/../templates/alertas.php" ?>

    <a href="/cambiar-password" class="enlace">Cambiar Password</a>

 <form class="formulario" method="POST" action="/perfil">
     <div class="campo perfil">
         <div>
           <label for="nombre">Nombre</label>
           <input id="nombre" name="nombre" type="text" value="<?php echo s($usuario->nombre); ?>" placeholder="Tu Nombre">
         </div>
       
       <div>
           <label for="email">Email</label>
           <input id="email" name="email" type="text" value="<?php echo s($usuario->email); ?>" placeholder="Tu email">

       </div>
        
     </div>

     <input class="input-perfil" type="submit" value="Guardar Cambios">
 </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>