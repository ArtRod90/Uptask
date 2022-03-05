<?php

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord{

    protected static $tabla = "proyectos";
    protected static $columnasDB = ["id", "proyecto", "url", "propetarioid"];

    public function __construct($args = [])
    {
        $this->id = $args ["id"] ?? null;
        $this->proyecto = $args ["proyecto"] ?? null;
        $this->url = $args ["url"] ?? null;
        $this->propetarioid = $args ["propetarioid"] ?? null;
        
    }

    public function validarProyecto()
    {
        if (!$this->proyecto) {
            self::$alertas["error"][] = "Olvidaste Ponerle un Nombre al Proyecto";
        }

        return self::$alertas;
    }
}