<?php include_once __DIR__ . "/header-dashboard.php"; ?>

<?php
if (count($proyectos) === 0) {?>
<p class="no-proyectos">No Hay Proyectos aun <a href="/crear-proyecto">Crea Uno</a></p>

<?php }else {?>
    <ul class="listado-proyectos"> <?php  
foreach ($proyectos as $value) {
   ?> 
   
  <li class="proyecto">
      <a href="/proyecto?id=<?php echo s($value->url) ?>"><?php echo s($value->proyecto); ?></a>
    </li>
   
<?php }
}  ?>
</ul>

<?php include_once __DIR__ . "/footer-dashboard.php"; ?>