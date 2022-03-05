<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<div class="contenedor-sm">
 <?php include_once __DIR__ . "/../templates/alertas.php" ?>
 <a href="/perfil" class="enlace">Volver a perfil</a>

 <form class="formulario" method="POST" action="/cambiar-password">
     <div class="campo perfil">
         <div>
           <label for="password_actual">Password Actual</label>
           <input id="password_actual" name="password_actual" type="password" placeholder="Tu Password">
         </div>
       
       <div>
           <label for="password_nuevo">Nuevo Password</label>
           <input id="password_nuevo" name="password_nuevo" type="password" placeholder="Nueva Password">
           
       </div>
        
     </div>

     <input class="input-perfil" type="submit" value="Guardar Cambios">
 </form>
</div>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>