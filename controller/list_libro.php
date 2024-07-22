<?php
include ('../class/helper.php');
session_start();
$libro = (new db('books b'))
            ->joinQuery(
                ['categories c'],
                ['0'],
                ['']                          
            );
$html = "";
foreach ($libro as $value) {
    _log($value);
    $html .= "<div class=col-md-3>
                <div class=card mb-4 data-id=1>
                    <img src='{$value['imagen']}' class=card-img-top
                    alt=Portada del {$value['titulo']}>
                    <div class=card-body d-flex flex-column text-center>
                    <h5 class=card-title>{$value['titulo']}</h5>
                    <p class=card-text>Autor: {$value['autor']}</p>
                    <p class=card-text>{$value['descripcion']}</p>
                    <p class=card-text>{$value['descripcion']}</p>
                    <button class=btn btn-primary mt-auto rent-btn>Alquilar</button>
                    </div>
                </div>
            </div>";
}
_log($html);
return $html;
?>