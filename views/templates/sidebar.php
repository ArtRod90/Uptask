<aside class="sidebar">
    <div class="contenedor-sidebar">

    <h2>UpTask</h2>
    <div class="cerrar-menu">
        <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen menu">
    </div>

    </div>

 <nav class="sidebar-nav">
     <a class="<?php echo ($pagina === 'Proyectos') ? "activo" : "" ?>" href="/dashboard">Proyectos</a>
     <a class="<?php echo ($pagina === 'Crea un Proyecto') ? "activo" : "" ?>" href="/crear-proyecto">Crear Proyecto</a>
     <a class="<?php echo ($pagina === 'Perfil') ? "activo" : "" ?>" href="/perfil">Perfil</a>
 </nav>

 <div class="cerrar-sesion-mobile">
 <a href="/logout" class="cerrar-session">Cerrar Session</a>
 </div>
</aside>