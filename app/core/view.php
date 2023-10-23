<?php

namespace App\Core;

class View
{
    public static function render($view, $data = [])
    {
        // Establecer una variable para cada elemento de $data
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        // Incluir la vista
        include __DIR__ . "/../../views/$view.php";
    }
}
